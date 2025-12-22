<x-laravel-ui-adminlte::adminlte-layout>
    <head>
        <link rel="shortcut icon" href="{{ asset('images/pirca-mini.png') }}" type="image/png">

        <link rel="stylesheet" href="{{ asset('css/theme.css') }}">

        {{-- AOS Animations --}}
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

        {{-- TomSelect CSS --}}
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet"/>

        @stack('styles')
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                            <i class="fas fa-bars"></i>
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto">
    <li class="nav-item">
        <button id="theme-toggle" class="btn btn-sm btn-default" title="Cambiar tema">
            <i id="theme-icon" class="fas fa-sun"></i>
        </button>
    </li>

    <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-toggle="dropdown">
            <i class="fas fa-user-circle fa-lg mr-2"></i>
            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
        </a>

        <ul class="dropdown-menu dropdown-menu-right">
            <li class="text-center py-3">
                <strong>{{ Auth::user()->name }}</strong><br>
                <small style="color: var(--muted);">Desde {{ Auth::user()->created_at->format('M. Y') }}</small><br>
                <span class="badge" style="background: var(--accent); color: var(--accent-ink); margin-top: 6px;">
                    Usuario activo
                </span>
            </li>

            <li class="dropdown-divider"></li>

            <li class="px-3 py-2" style="font-size: .9rem; color: var(--muted);">
                <i class="fas fa-clock mr-1" style="color: var(--accent);"></i>
                Último acceso: {{ now()->format('d/m/Y H:i') }}
            </li>

            <li class="text-center pb-2">
                <a href="{{ route('users.edit') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-user-cog mr-1"></i> Editar perfil
                </a>
            </li>

            <li class="dropdown-divider"></li>

            <li class="text-center pb-2">
                <a href="#" class="btn btn-sm btn-primary"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt mr-1"></i> Cerrar sesión
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </li>
        </ul>
    </li>
</ul>

            </nav>

            {{-- Sidebar (tu archivo) --}}
            @include('layouts.sidebar')

            <div class="content-wrapper">
                @yield('content')
            </div>

            <footer class="main-footer">
                <strong>{{ date('Y') }} <a href="http://pircasolutions.cl">Pirca</a>.</strong> Todos los derechos reservados.
            </footer>
        </div>

        {{-- Scripts generales --}}
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>AOS.init();</script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

        @stack('scripts')

        <script>
(function(){
  const body = document.body;
  const btn  = document.getElementById('theme-toggle');
  const icon = document.getElementById('theme-icon');

  // Estado inicial: localStorage > preferencia SO > claro
  const stored = localStorage.getItem('theme');
  const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
  const startDark = stored ? stored === 'dark' : prefersDark;

  if (startDark) body.classList.add('dark-mode');
  icon.classList.toggle('fa-moon',  body.classList.contains('dark-mode'));
  icon.classList.toggle('fa-sun',  !body.classList.contains('dark-mode'));

  btn?.addEventListener('click', () => {
    body.classList.toggle('dark-mode');
    const dark = body.classList.contains('dark-mode');
    icon.classList.toggle('fa-moon', dark);
    icon.classList.toggle('fa-sun', !dark);
    localStorage.setItem('theme', dark ? 'dark' : 'light');
  });
})();
</script>

    </body>
</x-laravel-ui-adminlte::adminlte-layout>
