<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // -----------------------------
        // Permisos para Clientes
        // -----------------------------
        $viewClientes   = Permission::firstOrCreate(['name' => 'view_clientes', 'guard_name' => 'web']);
        $createClientes = Permission::firstOrCreate(['name' => 'create_clientes', 'guard_name' => 'web']);
        $editClientes   = Permission::firstOrCreate(['name' => 'edit_clientes', 'guard_name' => 'web']);
        $deleteClientes = Permission::firstOrCreate(['name' => 'delete_clientes', 'guard_name' => 'web']);

        // -----------------------------
        // Permisos para Productos (Inventario)
        // -----------------------------
        $viewProductos   = Permission::firstOrCreate(['name' => 'view_productos', 'guard_name' => 'web']);
        $createProductos = Permission::firstOrCreate(['name' => 'create_productos', 'guard_name' => 'web']);
        $editProductos   = Permission::firstOrCreate(['name' => 'edit_productos', 'guard_name' => 'web']);
        $deleteProductos = Permission::firstOrCreate(['name' => 'delete_productos', 'guard_name' => 'web']);

        // -----------------------------
        // Permisos para Ventas
        // -----------------------------
        $viewVentas   = Permission::firstOrCreate(['name' => 'view_ventas', 'guard_name' => 'web']);
        $createVentas = Permission::firstOrCreate(['name' => 'create_ventas', 'guard_name' => 'web']);
        $editVentas   = Permission::firstOrCreate(['name' => 'edit_ventas', 'guard_name' => 'web']);
        $deleteVentas = Permission::firstOrCreate(['name' => 'delete_ventas', 'guard_name' => 'web']);

        // -----------------------------
        // Permisos para Actividades (Seguimientos)
        // -----------------------------
        $viewActividades    = Permission::firstOrCreate(['name' => 'view_actividades', 'guard_name' => 'web']);
        $createActividades  = Permission::firstOrCreate(['name' => 'create_actividades', 'guard_name' => 'web']);
        $editActividades    = Permission::firstOrCreate(['name' => 'edit_actividades', 'guard_name' => 'web']);
        $deleteActividades  = Permission::firstOrCreate(['name' => 'delete_actividades', 'guard_name' => 'web']);

        // -----------------------------
        // Arreglo con todos los permisos
        // -----------------------------
        $allPermissions = [
            $viewClientes, $createClientes, $editClientes, $deleteClientes,
            $viewProductos, $createProductos, $editProductos, $deleteProductos,
            $viewVentas, $createVentas, $editVentas, $deleteVentas,
            $viewActividades, $createActividades, $editActividades, $deleteActividades,
        ];

        // -----------------------------
        // Permisos limitados para Ejecutivo
        // -----------------------------
        $ejecutivoPermissions = [
            $viewClientes,
            $viewProductos,
            $viewVentas, $createVentas, $editVentas,
            $viewActividades, $createActividades,
        ];

        // -----------------------------
        // Crear roles y asignar permisos
        // -----------------------------
        $superAdminRole = Role::firstOrCreate(['name' => 'superAdmin']);
        $superAdminRole->syncPermissions($allPermissions);

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions($allPermissions);

        $ejecutivoRole = Role::firstOrCreate(['name' => 'ejecutivo']);
        $ejecutivoRole->syncPermissions($ejecutivoPermissions);

        // -----------------------------
        // Crear usuarios de ejemplo
        // -----------------------------
        // Usuario Super Admin (tú)
        $userSuperAdmin = User::firstOrCreate(
            ['email' => 'vhrivas.c@gmail.com'],
            [
                'name'     => 'Víctor Rivas',
                'password' => Hash::make('admin'),
                // Otros campos si son necesarios...
            ]
        );
        $userSuperAdmin->assignRole($superAdminRole);

        // Usuario Admin (cliente)
        $userAdmin = User::firstOrCreate(
            ['email' => 'admin@client.com'],
            [
                'name'     => 'Cliente Administrador',
                'password' => Hash::make('adminpassword'),
            ]
        );
        $userAdmin->assignRole($adminRole);

        // Usuario Ejecutivo (empleado)
        $userEjecutivo = User::firstOrCreate(
            ['email' => 'ejecutivo1@client.com'],
            [
                'name'     => 'Ejecutivo Uno',
                'password' => Hash::make('password'),
            ]
        );
        $userEjecutivo->assignRole($ejecutivoRole);
    }
}
