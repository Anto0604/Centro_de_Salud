<?php

namespace App\Livewire\Pacientes;

use App\Models\Paciente;
use Livewire\Component;
use Livewire\WithPagination;

use function Livewire\before;

class Index extends Component
{
    use WithPagination;
    public $search = '';
    public $selectedPaciente = null;
    public $viewMode = false;


    protected $paginationTheme = 'tailwind';


    public $apellido_paterno = '';
    public $apellido_materno = '';
    public $nombre = '';
    public $sexo = '';
    public $numero_expediente = '';
    public $localidad = '';
    public $fecha_nacimiento = '';
    public $direccion = '';
    public $municipio = '';
    public $fecha_ingreso = '';
    public $fecha_consulta = '';
    public $seccion = '';
    public $nivel = '';
    public $departamento = '';

    public $paciente_id = null;

    public $modalIsOpen = false;


    public $toastMessage = '';
    public $toastType = 'success';
    public $showToast = false;

    public function showToast(string $message, string $type = 'success')
    {
        $this->toastMessage = $message;
        $this->toastType = $type;
        $this->showToast = true;
    }

    public function render()
    {
        $query = Paciente::query();

        if ($this->search) {
            $query->where('numero_expediente', 'like', '%' . $this->search . '%');
            $query->orWhere('apellido_paterno', 'like', '%' . $this->search . '%');
            $query->orWhere('apellido_materno', 'like', '%' . $this->search . '%');
            $query->orWhere('nombre', 'like', '%' . $this->search . '%');
        }

        return view('livewire.pacientes.index', [
            'pacientes' => $query->orderBy('apellido_paterno')->paginate(10),
        ]);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    protected function rules(): array
    {
        return [
            'apellido_paterno' => ['required', 'string', 'max:255'],
            'apellido_materno' => ['nullable', 'string', 'max:255'],
            'nombre' => ['required', 'string', 'max:255'],
            'sexo' => ['nullable', 'string', 'in:Masculino,Femenino,Otro'],
            'numero_expediente' => [
                'required',
                'string',
                'max:50',
                \Illuminate\Validation\Rule::unique('pacientes', 'numero_expediente')->ignore($this->paciente_id),
            ],
            'localidad' => ['nullable', 'string', 'max:255'],
            'fecha_nacimiento' => ['nullable', 'date', 'before_or_equal:today'],
            'direccion' => ['nullable', 'string', 'max:500'],
            'municipio' => ['nullable', 'string', 'max:255'],
            'fecha_ingreso' => ['required', 'date', 'after_or_equal:today'],
            'fecha_consulta' => ['required', 'date', 'after_or_equal:today'],
            'seccion' => ['nullable', 'string', 'max:255'],
            'nivel' => ['nullable', 'string', 'max:255'],
            'departamento' => ['nullable', 'string', 'max:255'],
        ];
    }

    protected $validationAttributes = [
        'apellido_paterno' => 'apellido paterno',
        'apellido_materno' => 'apellido materno',
        'nombre' => 'nombre(s)',
        'sexo' => 'sexo',
        'numero_expediente' => 'número de expediente',
        'localidad' => 'localidad',
        'fecha_nacimiento' => 'fecha de nacimiento',
        'direccion' => 'dirección',
        'municipio' => 'municipio',
        'fecha_ingreso' => 'fecha de ingreso',
        'fecha_consulta' => 'fecha de consulta',
        'seccion' => 'sección',
        'nivel' => 'nivel',
        'departamento' => 'departamento',
    ];

    public function updated($property): void
    {
        $this->validateOnly($property);
    }

    public function create(): void
    {
        $this->resetForm();
        $this->openModal();
    }

    public function edit(Paciente $paciente): void
    {
        $this->paciente_id = $paciente->id;
        $this->apellido_paterno = $paciente->apellido_paterno;
        $this->apellido_materno = $paciente->apellido_materno;
        $this->nombre = $paciente->nombre;
        $this->sexo = $paciente->sexo;
        $this->numero_expediente = $paciente->numero_expediente;
        $this->localidad = $paciente->localidad;
        $this->fecha_nacimiento = $paciente->fecha_nacimiento;
        $this->direccion = $paciente->direccion;
        $this->municipio = $paciente->municipio;
        $this->fecha_ingreso = $paciente->fecha_ingreso;
        $this->fecha_consulta = $paciente->fecha_consulta;
        $this->seccion = $paciente->seccion;
        $this->nivel = $paciente->nivel;
        $this->departamento = $paciente->departamento;

        $this->openModal();
    }

    public function save(): void
    {
        $data = $this->validate();

        Paciente::updateOrCreate(
            ['id' => $this->paciente_id],
            $data
        );

        

        $this->showToast(
            $this->paciente_id ? 'Paciente actualizado' : 'Paciente creado',
            'success'
        );

        

        $this->resetForm();
        $this->closeModal();
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        $paciente = Paciente::find($id);

        if (!$paciente) {
            
            $this->showToast(
                'El paciente no existe',
                'success'
            );
        
            return;
        }

        $paciente->delete();
        
        $this->showToast(
             'Paciente Eliminado',
            'success'
        );
        
        $this->resetPage();
    }

    public function updateDateConsulta(int $id): void
    {
        $paciente = Paciente::find($id);
        $paciente->fecha_consulta = now();
        $paciente->save();

        $this->showToast(
            'Fecha de consulta actualizada',
            'success'
        );

        $this->resetPage();
    }

    private function resetForm(): void
    {
        $this->reset([
            'apellido_paterno',
            'apellido_materno',
            'nombre',
            'numero_expediente',
            'localidad',
            'fecha_nacimiento',
            'direccion',
            'municipio',
            'fecha_ingreso',
            'fecha_consulta',
            'seccion',
            'nivel',
            'departamento',
            'paciente_id'
        ]);
        $this->resetValidation();
    }

    private function openModal(): void
    {
        $this->modalIsOpen = true;
    }

    public function closeModal(): void
    {
        $this->modalIsOpen = false;
        $this->viewMode = false;
        $this->selectedPaciente = null;
    }

    public function view(Paciente $paciente): void
    {
        $this->selectedPaciente = $paciente;
        $this->viewMode = true;
        $this->modalIsOpen = true;
    }
}
