<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'rol-listar',
            'rol-crear',
            'rol-editar',
            'rol-eliminar',
            'usuarios-listar',
            'usuarios-crear',
            'usuarios-editar',
            'usuarios-eliminar',
        ];

        $permissions6 = [
            'empleados-listar',
            'empleados-crear',
            'empleados-editar',
            'empleados-eliminar',
        ];

        $permissions9 = [
            'clientes-listar',
            'clientes-crear',
            'clientes-editar',
            'clientes-eliminar',
        ];

        foreach ($permissions9 as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
