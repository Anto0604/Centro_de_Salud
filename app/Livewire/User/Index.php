<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $name = '';
    public $email = '';
    public $password = '';
    public $rol = '';
    public $user_id = null;

    public $modalIsOpen = false;
    public $viewMode = false;
    public $selectedUsuario;

    public $showToast = false;
    public $toastMessage = '';
    public $toastType = 'success';

    public $selectedPermissions = [];

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'password' => 'required|string|min:8',
        'rol' => 'required|in:Administrador,Archivo',
    ];

    protected $listeners = ['deleteConfirmed' => 'deleteUser'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $usuarios = User::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.user.index', compact('usuarios'));
    }

    public function create()
    {
        $this->resetForm();
        $this->viewMode = false;
        $this->modalIsOpen = true;
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        $this->user_id = $usuario->id;
        $this->name = $usuario->name;
        $this->email = $usuario->email;
        $this->rol = $usuario->roles->pluck('name');
        $this->password = ''; 
        $this->selectedPermissions = $usuario->permissions->pluck('name')->toArray();
        $this->viewMode = false;
        $this->modalIsOpen = true;
    }

    public function view($id)
    {
        $this->selectedUsuario = User::findOrFail($id);
        $this->viewMode = true;
        $this->modalIsOpen = true;
    }

    public function closeModal()
    {
        $this->modalIsOpen = false;
        $this->resetErrorBag();
    }

    public function resetForm()
    {
        $this->user_id = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->rol = '';
        $this->selectedPermissions = [];
        $this->resetErrorBag();
    }

    public function getPermissionsListProperty()
    {
        return \Spatie\Permission\Models\Permission::all();
    }

    public function save()
    {

        $rules = $this->rules;

        if ($this->user_id) {
            $rules['password'] = 'nullable|string|min:8';

            $rules['email'] = 'required|email|unique:users,email,' . $this->user_id;
        } else {
            $rules['password'] = 'required|string|min:8';

            $rules['email'] = 'required|email|unique:users,email';
        }

        $this->validate($rules);

        if ($this->user_id) {
        
            $usuario = User::findOrFail($this->user_id);
            $oldPassword = $usuario->password;
            $newPassword = $this->password ? Hash::make($this->password) : $oldPassword;

            $usuario->update([
                'name' => $this->name,
                'email' => $this->email,
                'rol' => $this->rol,
                'password' => $newPassword,
            ]);

            $usuario->syncRoles([$this->rol]);

            $usuario->syncPermissions($this->selectedPermissions);

        
            if ($this->password) {
                $this->sendCredentialsEmail($usuario, $this->password, true);
            }

            $this->toast('Usuario actualizado correctamente.', 'success');
        } else {
        
            $usuario = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);

            $usuario->assignRole($this->rol);

            $usuario->syncPermissions($this->selectedPermissions);

            $this->sendCredentialsEmail($usuario, $this->password, false);
            $this->toast('Usuario creado correctamente.', 'success');
        }

        $this->closeModal();
        $this->resetForm();
    }


    public function deleteUser($id)
    {
        User::destroy($id);
        $this->toast('Usuario eliminado.', 'success');
    }

    private function sendCredentialsEmail($usuario, $plainPassword, $isUpdate = false)
    {
        $adminEmail = 'aacostaantonio13@gmail.com';
        $subject = $isUpdate ? 'Tu contraseña ha sido actualizada' : 'Bienvenid@ - Credenciales de acceso';

        
        Mail::raw("Hola {$usuario->name},\n\nTus credenciales de acceso son:\nUsuario: {$usuario->email}\nContraseña: {$plainPassword}\n\nGracias.", function ($message) use ($usuario, $subject) {
            $message->to($usuario->email)->subject($subject);
        });

        
        Mail::raw("Se ha " . ($isUpdate ? 'actualizado' : 'creado') . " un usuario:\nNombre: {$usuario->name}\nEmail: {$usuario->email}\nContraseña: {$plainPassword}", function ($message) use ($adminEmail, $subject) {
            $message->to($adminEmail)->subject("[ADMIN] $subject");
        });
    }

    private function toast($message, $type = 'success')
    {
        $this->toastMessage = $message;
        $this->toastType = $type;
        $this->showToast = true;
    }

    public function getFriendlyPermissionName(string $permission): string
{
    return match($permission) {
        'user.create' => 'Crear',
        'user.view' => 'Ver',
        'user.edit' => 'Editar',
        'user.delete' => 'Eliminar',
        // Agrega más según necesites
        default => ucfirst(str_replace(['.', '_'], ' ', $permission))
    };
}
}