<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asegúrate de que el rol "Administrador" exista
        $adminRole = Role::firstOrCreate(['name' => 'Administrador']);

        // Crea un usuario administrador
        $user = User::create([
            'name' => 'Administrador',
            'email' => 'admin@tudominio.com',
            'password' => Hash::make('password123'), // ⚠️ Cámbialo en producción
        ]);

        // Asigna el rol de administrador
        $user->assignRole($adminRole);

        // Opcional: crear más usuarios
        /*
        User::factory()->create([
            'name' => 'Usuario Archivo',
            'email' => 'archivo@tudominio.com',
            'password' => Hash::make('password123'),
        ])->assignRole('Archivo');
        */
    }
}