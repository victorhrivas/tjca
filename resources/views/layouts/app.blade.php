<x-laravel-ui-adminlte::adminlte-layout>
    <head>
        <link rel="shortcut icon" href="{{ asset('images/pirca-mini.png') }}" type="image/png">

        {{-- AOS Animations --}}
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

        {{-- TomSelect CSS --}}
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet"/>

        <style>
            /* =========================
               Paleta y base tipográfica
               ========================= */
            :root {
                --bg-0: #101114;
                --bg-1: #15171b;
                --bg-2: #1c1f24;
                --bg-3: #23272e;
                --line: #2c3139;
                --ink: #e6e7ea;
                --muted: #a7adb7;
                --accent: #d8b600;       /* mostaza principal */
                --accent-hover: #e5c20a; /* hover más claro */
                --accent-ink: #0b0c0e;
            }

            html,body{background: var(--bg-0); color: var(--ink); font-family: "Inter", system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji","Segoe UI Emoji", "Segoe UI Symbol", sans-serif;}

            a{color: var(--accent);}
            a:hover{color: var(--accent-2); text-decoration:none}

            /* ======= Navbar ======= */
            .main-header.navbar{
                background: linear-gradient(180deg,var(--bg-3),var(--bg-2));
                color: var(--ink);
                border-bottom: 1px solid var(--line);
                box-shadow: var(--shadow);
            }
            .navbar-nav .nav-link[data-widget="pushmenu"] i{ color: var(--accent); }
            .main-header .nav-link{ color: var(--ink); opacity:.9}
            .main-header .nav-link:hover{ opacity:1 }

            /* ======= Sidebar (AdminLTE) ======= */
            .main-sidebar{ background: var(--bg-1) !important; }
            .brand-link{ background: var(--bg-1) !important; border-bottom:1px solid var(--line) }
            .nav-sidebar>.nav-item>.nav-link{ color: var(--muted); }
            .nav-sidebar>.nav-item>.nav-link.active,
            .nav-sidebar>.nav-item>.nav-link:hover{
                background: rgba(246,199,0,.12);
                color: var(--ink);
            }

            /* ======= Contenido ======= */
            .content-wrapper{
                background:
                    radial-gradient(1200px 500px at 80% -20%, rgba(246,199,0,.06), transparent 60%),
                    radial-gradient(900px 400px at -10% 110%, rgba(255,255,255,.04), transparent 60%),
                    var(--bg-0);
                min-height: calc(100vh - 56px);
            }

            /* ======= Tarjetas ======= */
            .card{
                background: linear-gradient(180deg, var(--bg-2), var(--bg-1));
                border: 1px solid var(--line);
                color: var(--ink);
                border-radius: var(--radius);
                box-shadow: var(--shadow);
            }
            .card-header{
                background: var(--bg-3);
                color: var(--ink);
                border-bottom: 1px solid var(--line);
                border-top-left-radius: var(--radius);
                border-top-right-radius: var(--radius);
            }
            .card-body,.card-footer{ background: transparent; }

            /* ======= Botones ======= */
            .btn-primary{
                background: var(--accent);
                border-color: var(--accent);
                color: var(--accent-ink);
                font-weight: 700;
                border-radius: 10px;
                transition: transform .15s ease, box-shadow .2s ease, background .15s ease;
            }
            .btn-primary:hover{
                background: var(--accent-2);
                border-color: var(--accent-2);
                transform: translateY(-1px);
                box-shadow: 0 8px 22px rgba(246,199,0,.25);
                color: #000;
            }
            .btn-secondary,.btn-default{
                background: #353945;
                border-color:#3f4653;
                color: var(--ink);
                border-radius:10px;
            }
            .btn-secondary:hover,.btn-default:hover{
                background:#404756;
                border-color:#4a5262;
            }

            /* ======= Formularios ======= */
            .form-control{
                background:#2a2f38;
                border:1px solid var(--line);
                color: var(--ink);
                border-radius:10px;
            }
            .form-control::placeholder{ color:#8b92a0 }
            .form-control:focus{
                background:#2d333d;
                border-color: var(--accent);
                box-shadow: 0 0 0 .2rem rgba(246,199,0,.12);
                color:#fff;
            }
            label{ color: var(--muted); }

            /* TomSelect (modo oscuro) */
            .tom-select .ts-control{
                background:#2a2f38 !important;
                border:1px solid var(--line) !important;
                color:var(--ink) !important;
            }
            .tom-select .ts-control.ts-focus,
            .tom-select .ts-control:focus-within{
                border-color:var(--accent) !important;
                box-shadow:0 0 0 .2rem rgba(246,199,0,.12) !important;
            }
            .tom-select .ts-control .item,
            .ts-dropdown-content .ts-option{
                background:#242933 !important; color:var(--ink) !important;
            }

            /* ======= Tablas ======= */
            .table{ background: transparent; color: var(--ink); }
            .table th{ background: #242933; color: var(--ink); border-color: var(--line); }
            .table td{ background: #1b1f25; border-color: var(--line); }
            .table-striped tbody tr:nth-of-type(odd){ background:#20242b; }
            .table-hover tbody tr:hover{ background:#2a3039; }

            /* ======= Dropdown usuario ======= */
            .dropdown-menu{
                background: var(--bg-2);
                border:1px solid var(--line);
                border-radius:12px;
                box-shadow: var(--shadow);
            }
            .user-header{
                background: var(--accent) !important;
                color: var(--accent-ink) !important;
            }

            /* ======= Footer ======= */
            .main-footer{
                background: var(--bg-3);
                color: var(--muted);
                border-top: 1px solid var(--line);
                position: sticky;
                bottom: 0;
                width: 100%;
                z-index: 900;
                padding: 8px 12px;
                font-size: .9rem;
            }
            .main-footer a{ color: var(--accent); }

            /* ======= Micro-interacciones ======= */
            .card, .btn, .list-group-item, table tr{ transition: all .2s ease-in-out; }
            .list-group-item:hover{ background:#2b3039; cursor:pointer }
        </style>

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
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-toggle="dropdown">
                            <i class="fas fa-user-circle fa-lg text-white mr-2"></i>
                            <span class="d-none d-md-inline text-white">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right" style="min-width:220px;background:var(--bg-2);border:1px solid var(--line);border-radius:12px;">
                            <li class="text-center py-3" style="color:var(--ink);">
                                <strong>{{ Auth::user()->name }}</strong><br>
                                <small style="color:var(--muted);">Desde {{ Auth::user()->created_at->format('M. Y') }}</small><br>
                                <span class="badge" style="background:var(--accent);color:var(--accent-ink);margin-top:6px;">Usuario activo</span>
                            </li>
                            <li class="dropdown-divider" style="border-color:var(--line);margin:4px 0;"></li>
                            <li class="px-3 py-2" style="font-size:.9rem;color:var(--muted);">
                                <i class="fas fa-clock mr-1 text-warning"></i> Último acceso: {{ now()->format('d/m/Y H:i') }}
                            </li>
                            <li class="dropdown-divider" style="border-color:var(--line);margin:4px 0;"></li>
                            <li class="text-center pb-2">
                                <a href="#" class="btn btn-sm btn-primary"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
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
    </body>
</x-laravel-ui-adminlte::adminlte-layout>
