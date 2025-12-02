{{-- resources/views/layouts/menu.blade.php --}}

<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i><p>Inicio</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('solicituds.index') }}" class="nav-link {{ Request::is('solicitudes*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-inbox"></i><p>Solicitudes</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('cotizacions.index') }}" class="nav-link {{ Request::is('cotizaciones*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-file-signature"></i><p>Cotizaciones</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('ots.index') }}" class="nav-link {{ Request::is('ots*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-clipboard-check"></i><p>OT's</p>
    </a>
</li>

<li class="nav-item has-treeview {{ Request::is('operacion/*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ Request::is('operacion/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-truck-loading"></i>
        <p>Operación<i class="right fas fa-angle-left"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('operacion.inicio-carga.index') }}"
               class="nav-link {{ Request::is('operacion/inicio-carga*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i><p>Inicio de carga</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('operacion.en-transito.index') }}"
               class="nav-link {{ Request::is('operacion/en-transito*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i><p>En tránsito</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('operacion.entrega.index') }}"
               class="nav-link {{ Request::is('operacion/entrega*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i><p>Entrega de carga</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item">
    <a href="{{ route('puentes.index') }}" class="nav-link {{ Request::is('puentes*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-exclamation-triangle"></i><p>Incidencias</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('clientes.index') }}" class="nav-link {{ Request::is('clientes*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user-friends"></i><p>Clientes</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('conductors.index') }}" class="nav-link {{ Request::is('conductors*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-truck-moving"></i>
        <p>Conductores</p>
    </a>
</li>
