{{-- resources/views/layouts/menu.blade.php --}}

{{-- DASHBOARD --}}
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i><p>Inicio</p>
    </a>
</li>

{{-- SEGURIDAD: solo desarrollador --}}
@role('desarrollador')
<li class="nav-header">SEGURIDAD</li>

<li class="nav-item">
    <a href="{{ route('users.index') }}" class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users-cog"></i><p>Usuarios</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('roles.index') }}" class="nav-link {{ Request::is('roles*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user-shield"></i><p>Roles</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('permissions.index') }}" class="nav-link {{ Request::is('permissions*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-key"></i><p>Permisos</p>
    </a>
</li>
@endrole

{{-- CHOFER --}}
@role('chofer')
<li class="nav-header">OPERACIÓN</li>

<li class="nav-item">
    <a href="{{ route('ots.index') }}" class="nav-link {{ Request::is('ots*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-clipboard-check"></i><p>OT's</p>
    </a>
</li>

<li class="nav-item has-treeview {{ Request::is('inicio-cargas*') || Request::is('entregas*') || Request::is('checklist-camions*') || Request::is('puentes/create') || Request::is('puentes/*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ Request::is('inicio-cargas*') || Request::is('entregas*') || Request::is('checklist-camions*') || Request::is('puentes/create') || Request::is('puentes/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-file-alt"></i>
        <p>Formularios<i class="right fas fa-angle-left"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('inicio-cargas.create') }}" class="nav-link {{ Request::is('inicio-cargas/create') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i><p>Inicio de carga</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('entregas.create') }}" class="nav-link {{ Request::is('entregas/create') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i><p>Entrega</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('checklist-camions.create') }}" class="nav-link {{ Request::is('checklist-camions/create') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i><p>Checklist camión</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('puentes.create') }}" class="nav-link {{ Request::is('puentes/create') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i><p>Incidencias</p>
            </a>
        </li>
    </ul>
</li>
@endrole

{{-- ADMINISTRADOR Y DESARROLLADOR --}}
@hasanyrole('administrador|desarrollador')

<li class="nav-header">GESTIÓN COMERCIAL</li>

<li class="nav-item">
    <a href="{{ route('solicituds.index') }}" class="nav-link {{ Request::is('solicituds*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-inbox"></i><p>Solicitudes</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('cotizacions.index') }}" class="nav-link {{ Request::is('cotizacions*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-file-signature"></i><p>Cotizaciones</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('ots.index') }}" class="nav-link {{ Request::is('ots*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-clipboard-check"></i><p>OT's</p>
    </a>
</li>

<li class="nav-header">FORMULARIOS</li>

<li class="nav-item has-treeview {{ Request::is('inicio-cargas*') || Request::is('entregas*') || Request::is('checklist-camions*') || Request::is('puentes/create') || Request::is('puentes/*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ Request::is('inicio-cargas*') || Request::is('entregas*') || Request::is('checklist-camions*') || Request::is('puentes/create') || Request::is('puentes/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-file-alt"></i>
        <p>Formularios<i class="right fas fa-angle-left"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('inicio-cargas.create') }}" class="nav-link {{ Request::is('inicio-cargas/create') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i><p>Inicio de carga</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('entregas.create') }}" class="nav-link {{ Request::is('entregas/create') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i><p>Entrega</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('checklist-camions.create') }}" class="nav-link {{ Request::is('checklist-camions/create') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i><p>Checklist camión</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('puentes.create') }}" class="nav-link {{ Request::is('puentes/create') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i><p>Incidencias</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-header">OPERACIÓN</li>

<li class="nav-item has-treeview {{ Request::is('operacion/*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ Request::is('operacion/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-truck-loading"></i>
        <p>Operación<i class="right fas fa-angle-left"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('operacion.inicio-carga.index') }}" class="nav-link {{ Request::is('operacion/inicio-carga*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i><p>Inicio de carga</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('operacion.entrega.index') }}" class="nav-link {{ Request::is('operacion/entrega*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i><p>Entrega de carga</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('operacion.checklist.index') }}" class="nav-link {{ Request::is('operacion/checklist*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i><p>Checklist camiones</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('puentes.index') }}" class="nav-link {{ Request::is('puentes') || Request::is('puentes/*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i><p>Incidencias</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-header">ADMINISTRACIÓN</li>

<li class="nav-item">
    <a href="{{ route('clientes.index') }}" class="nav-link {{ Request::is('clientes*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user-friends"></i><p>Clientes</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('conductors.index') }}" class="nav-link {{ Request::is('conductors*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-id-card-alt"></i><p>Conductores</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('vehiculos.index') }}" class="nav-link {{ Request::is('vehiculos*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-truck"></i><p>Vehículos</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('tarifaRutas.index') }}" class="nav-link {{ Request::is('tarifaRutas*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-route"></i><p>Tarifa Rutas</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('reportes.index') }}" class="nav-link {{ Request::is('reportes*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-chart-bar"></i><p>Reportes</p>
    </a>
</li>

@endhasanyrole