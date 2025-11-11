<x-laravel-ui-adminlte::adminlte-layout>
    <head>
        <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/png">
        <style>
            :root{
                --bg-0:#101114;--bg-1:#15171b;--bg-2:#1c1f24;--bg-3:#23272e;
                --line:#2c3139;--ink:#e6e7ea;--muted:#a7adb7;
                --accent:#d4ad18;--accent-hover:#e1ba1f;--accent-ink:#0b0c0e;
                --shadow:0 14px 40px rgba(0,0,0,.45);
            }
            body.login-page {
                position: relative;
                min-height: 100vh;
                overflow: hidden;
                background: var(--bg-0);
                color: var(--ink);
                font-family: "Inter", system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, sans-serif;
            }

            /* Capa con la imagen de fondo */
            body.login-page::before {
                content: "";
                position: absolute;
                inset: 0;
                background: 
                    linear-gradient(to right, rgba(16,17,20,0.98) 0%, rgba(16,17,20,0.7) 40%, rgba(16,17,20,0.3) 60%, rgba(16,17,20,0) 75%),
                    url('{{ url("/images/truck.png") }}') center right / cover no-repeat;
                z-index: 0;
                opacity: 0.9;
            }

            /* Contenedor principal */
            .auth-wrap {
                position: relative;
                z-index: 1;
                max-width: 900px;
                margin: 40px auto 40px auto; /* centrado horizontalmente */
                margin-right: 10%;           /* mantiene la inclinación a la derecha */
                padding: 24px;
                background: linear-gradient(180deg, var(--bg-2), var(--bg-1));
                border: 1px solid var(--line);
                border-radius: 18px;
                box-shadow: var(--shadow);
            }


            .auth-head{display:flex;align-items:center;gap:16px;background:linear-gradient(90deg,var(--accent),#f8dc3b);color:var(--accent-ink);border-radius:12px;padding:10px 14px;margin-bottom:18px}
            .auth-head img{height:100px;filter:none}
            .auth-head .title{font-weight:800;letter-spacing:.4px;text-transform:uppercase}
            .login-box{background:transparent;border:none;box-shadow:none;padding:0;margin:0 auto;width:100%}
            .card.card-outline.card-primary{background:var(--bg-2);border:1px solid var(--line);border-radius:14px;overflow:hidden}
            .card-section{padding:22px}
            .card-section.alt{background:var(--bg-3);border-top:1px solid var(--line);border-bottom:1px solid var(--line)}
            .login-box-msg{color:var(--muted);margin:0}
            .form-control{background:#2a2f38;border:1px solid var(--line);color:var(--ink);border-radius:10px;height:46px}
            .form-control:focus{background:#2d333d;border-color:var(--accent);box-shadow:0 0 0 .2rem rgba(246,199,0,.12);color:#fff}
            .input-group-text{background:#2a2f38;border:1px solid var(--line);color:var(--ink);border-radius:10px}
            .btn{border-radius:10px;height:46px;font-weight:800;letter-spacing:.3px}
            .btn-accent{background:var(--accent);border-color:var(--accent);color:var(--accent-ink)}
            .btn-accent:hover{background:var(--accent-hover);border-color:var(--accent-hover);box-shadow:0 10px 24px rgba(246,199,0,.28);transform:translateY(-1px)}
            .btn-ghost{background:transparent;border:1px solid var(--line);color:var(--ink)}
            .btn-ghost:hover{border-color:var(--accent);color:var(--accent)}
            .help-row{display:flex;justify-content:space-between;align-items:center;gap:12px;color:var(--muted);font-size:.92rem}
            .help-row a{color:var(--accent)}
            .help-row a:hover{color:var(--accent-hover);text-decoration:underline}
            .divider{display:flex;align-items:center;gap:12px;color:var(--muted);margin:12px 0}
            .divider::before,.divider::after{content:"";flex:1;height:1px;background:var(--line)}

            /* Sección de acciones rápidas (check-in / check-out) */
            .action-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}
            .action-tile{display:flex;align-items:center;justify-content:center;gap:10px;height:56px;border:1px solid var(--line);background:var(--bg-2);border-radius:12px;color:var(--ink);cursor:pointer;transition:.15s ease}
            .action-tile:hover{border-color:var(--accent);color:var(--accent)}
            .action-tile i{font-size:1.1rem}

            /* Checklist camión */
            .checklist{display:grid;grid-template-columns:1fr 1fr;gap:10px}
            .check-item{display:flex;align-items:center;gap:10px;padding:10px 12px;background:var(--bg-2);border:1px solid var(--line);border-radius:10px}
            .check-item input{accent-color:var(--accent)}
            @media (max-width: 640px){
                .action-grid{grid-template-columns:1fr}
                .checklist{grid-template-columns:1fr}
            }
        </style>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
        /* Tablet y abajo */
        @media (max-width: 992px){
        /* Fondo: más oscuro y centrado para que no corte el camión */
        body.login-page::before{
            background:
            linear-gradient(to bottom, rgba(16,17,20,0.95) 0%, rgba(16,17,20,0.85) 35%, rgba(16,17,20,0.75) 100%),
            url('{{ url("/images/truck.png") }}') center / cover no-repeat;
            opacity: 1;
        }

        /* Card centrado */
        .auth-wrap{
            max-width: 720px;
            margin: 32px auto;      /* centra horizontal */
            padding: 20px;
        }

        /* Encabezado compacto */
        .auth-head{ padding: 10px 12px; gap: 12px; }
        .auth-head img{ height: 72px; }
        .auth-head .title{ font-size: 0.95rem; }
        .auth-head .subtitle{ display:none; } /* limpia texto en pantallas chicas */
        }

        /* Móvil */
        @media (max-width: 576px){
        .auth-wrap{
            max-width: 540px;
            width: calc(100% - 24px);
            margin: 20px auto;
            border-radius: 14px;
        }

        .card-section{ padding: 16px; }
        .card-section.alt{ padding: 16px; }

        /* Inputs y botones cómodos al tacto */
        .form-control{ height: 48px; }
        .btn{ height: 48px; }

        /* Grids a una sola columna */
        .action-grid{ grid-template-columns: 1fr; gap: 10px; }

        /* Cabecera aún más mínima */
        .auth-head{ gap: 10px; }
        .auth-head img{ height: 56px; }
        }

        /* Ultra-compacto (por si hay notch o teclado abierto) */
        @media (max-height: 640px){
        .auth-wrap{ margin: 12px auto; }
        }
        </style>

    </head>

    <body class="hold-transition login-page">
    <div class="auth-wrap" style="margin-left:auto; margin-right:40px; max-width:880px;">
        <div class="auth-head">
            <img src="{{ url('/') }}/images/logo.png" alt="TJCA">
            <div>
                <div class="title">Portal TJCA</div>
                <div class="subtitle">Acceso seguro para colaboradores</div>
            </div>
        </div>

        <div class="login-box">
            <div class="card card-outline card-primary">
                {{-- Intro --}}
                <div class="card-section">
                    <p class="login-box-msg">Inicie sesión para comenzar</p>
                </div>

                {{-- Formulario --}}
                <div class="card-section alt">
                    <form method="post" action="{{ url('/login') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="email" name="email" value="{{ old('email') }}"
                                   placeholder="Correo electrónico"
                                   class="form-control @error('email') is-invalid @enderror">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                            </div>
                            @error('email') <span class="error invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" name="password" placeholder="Contraseña"
                                   class="form-control @error('password') is-invalid @enderror">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-lock"></span></div>
                            </div>
                            @error('password') <span class="error invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="row align-items-center">
                            <div class="col-6">
                                <button type="submit" class="btn btn-accent btn-block">Iniciar sesión</button>
                            </div>
                            <div class="col-6 text-right">
                                <small class="text-muted">¿Necesita ayuda?
                                    <a href="{{ route('password.request') }}">Recupere su acceso</a>
                                </small>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Acciones rápidas --}}
                <div class="card-section">
                    <div class="divider"><span>Acciones rápidas</span></div>
                    <div class="action-grid">
                        <button type="button" class="action-tile">
                            <i class="fas fa-truck-loading"></i>
                            <span>Inicio de carga</span>
                        </button>
                        <button type="button" class="action-tile">
                            <i class="fas fa-clipboard-check"></i>
                            <span>Entrega</span>
                        </button>
                        <button type="button" class="action-tile">
                            <i class="fas fa-list-check"></i>
                            <span>Checklist camión</span>
                        </button>
                    </div>
                </div>

                {{-- Soporte --}}
                <div class="card-section">
                    <div class="divider"><span>Soporte</span></div>
                    <div class="help-row">
                        <span>Problemas de acceso</span>
                        <a href="{{ route('password.request') }}">¿Olvidó su contraseña?</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</x-laravel-ui-adminlte::adminlte-layout>
