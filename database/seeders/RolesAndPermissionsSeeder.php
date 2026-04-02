<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Dashboard
            'ver dashboard',

            // Usuarios
            'ver usuarios',
            'crear usuarios',
            'editar usuarios',
            'eliminar usuarios',

            // Clientes
            'ver clientes',
            'crear clientes',
            'editar clientes',
            'eliminar clientes',

            // Solicitudes
            'ver solicitudes',
            'crear solicitudes',
            'editar solicitudes',
            'aprobar solicitudes',
            'eliminar solicitudes',

            // Cotizaciones
            'ver cotizaciones',
            'crear cotizaciones',
            'editar cotizaciones',
            'eliminar cotizaciones',
            'enviar cotizaciones',
            'generar ot',

            // OTs
            'ver ots',
            'crear ots',
            'editar ots',
            'eliminar ots',
            'cambiar estado ots',
            'ver pdf ots',

            // Formularios operacionales
            'usar inicio carga',
            'usar entrega',
            'usar checklist camion',

            // Gestión operacional / historial
            'ver operacion inicio carga',
            'ver operacion entrega',
            'ver operacion checklist',

            // Incidencias
            'ver incidencias',
            'crear incidencias',
            'editar incidencias',
            'eliminar incidencias',

            // Reportes
            'ver reportes',

            // Conductores
            'ver conductores',
            'crear conductores',
            'editar conductores',
            'eliminar conductores',

            // Vehículos
            'ver vehiculos',
            'crear vehiculos',
            'editar vehiculos',
            'eliminar vehiculos',

            // Tarifa rutas
            'ver tarifa rutas',
            'crear tarifa rutas',
            'editar tarifa rutas',
            'eliminar tarifa rutas',

            // Perfil
            'editar perfil',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $desarrollador = Role::firstOrCreate([
            'name' => 'desarrollador',
            'guard_name' => 'web',
        ]);

        $administrador = Role::firstOrCreate([
            'name' => 'administrador',
            'guard_name' => 'web',
        ]);

        $chofer = Role::firstOrCreate([
            'name' => 'chofer',
            'guard_name' => 'web',
        ]);

        // DESARROLLADOR: todo
        $desarrollador->syncPermissions(Permission::all());

        // ADMINISTRADOR: todo menos crear usuarios
        $administrador->syncPermissions(
            Permission::where('name', '!=', 'crear usuarios')->get()
        );

        // CHOFER: solo formularios y OTs
        $chofer->syncPermissions([
            'ver dashboard',

            'ver ots',
            'ver pdf ots',

            'usar inicio carga',
            'usar entrega',
            'usar checklist camion',

            'editar perfil',
        ]);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}