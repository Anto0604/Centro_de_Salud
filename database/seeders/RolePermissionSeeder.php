<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Crear permisos
        $permissions = [
            'user.create',
            'user.view',
            'user.edit',
            'user.delete',
            // Agrega más según necesites
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crear roles
        $admin = Role::firstOrCreate(['name' => 'Administrador']);
        $archivo = Role::firstOrCreate(['name' => 'Archivo']);

        // Asignar todos los permisos al Administrador
        $admin->givePermissionTo($permissions);

        // Asignar solo permisos limitados a Archivo
        $archivo->givePermissionTo(['user.view']);
    }
}