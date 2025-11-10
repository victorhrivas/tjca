<x-laravel-ui-adminlte::adminlte-layout>
    <head>
        <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/png">
        <style>
            :root {
                --bg-0: #101114;
                --bg-1: #15171b;
                --bg-2: #1c1f24;
                --bg-3: #23272e;
                --line: #2c3139;
                --ink: #e6e7ea;
                --muted: #a7adb7;

                /* Amarillo mostaza más cálido */
                --accent: #d4ad18;         /* tono base mostaza */
                --accent-hover: #e1ba1f;   /* hover más claro */
                --accent-ink: #0b0c0e;
                --shadow: 0 14px 40px rgba(0, 0, 0, .45);
            }

            body.login-page{
                background:
                    radial-gradient(900px 520px at 70% 18%, rgba(246,199,0,.06), transparent 60%),
                    radial-gradient(800px 420px at -8% 108%, rgba(255,255,255,.04), transparent 60%),
                    var(--bg-0) !important;
                color:var(--ink);
                font-family:"Inter",system-ui,-apple-system,Segoe UI,Roboto,Helvetica Neue,Arial,sans-serif;
            }

            /* Capa contenedora para dar profundidad */
            .auth-wrap{
                max-width: 920px;
                margin: 28px auto;
                padding: 22px;
                background: linear-gradient(180deg,var(--bg-2),var(--bg-1));
                border:1px solid var(--line);
                border-radius:18px;
                box-shadow: var(--shadow);
            }

            /* Cabecera del bloque con banda acento */
            .auth-head{
                display:flex; align-items:center; gap:16px;
                background: linear-gradient(90deg,var(--accent),#f8dc3b);
                color:var(--accent-ink);
                border-radius:12px;
                padding:10px 14px;
                margin-bottom:18px;
            }
            .auth-head img{ height:40px; filter: grayscale(0); }
            .auth-head .title{ font-weight:800; letter-spacing:.4px; text-transform:uppercase; }
            .auth-head .subtitle{ font-size:.92rem; opacity:.9 }

            /* Card de login embebido y secciones */
            .login-box{
                background: transparent;
                border: none;
                box-shadow:none;
                padding: 0;
                margin: 0 auto;
                width: 100%;
            }

            .card.card-outline.card-primary{
                background: var(--bg-2);
                border:1px solid var(--line);
                border-radius:14px;
                overflow:hidden;
            }

            .card-section{
                padding: 22px;
            }
            .card-section.alt{
                background: var(--bg-3);
                border-top:1px solid var(--line);
                border-bottom:1px solid var(--line);
            }

            .login-box-msg{ color:var(--muted); margin:0 }

            .form-control{
                background: #2a2f38;
                border:1px solid var(--line);
                color: var(--ink);
                border-radius:10px;
                height: 46px;
            }
            .form-control:focus{
                background:#2d333d;
                border-color: var(--accent);
                box-shadow: 0 0 0 .2rem rgba(246,199,0,.12);
                color:#fff;
            }
            .input-group-text{
                background:#2a2f38;
                border:1px solid var(--line);
                color:var(--ink);
                border-radius:10px;
            }

            .btn.btn-primary.btn-block{
                background: var(--accent);
                border-color: var(--accent);
                color: var(--accent-ink);
                font-weight:800;
                letter-spacing:.3px;
                border-radius:10px;
                height: 46px;
                transition: transform .15s ease, box-shadow .2s ease, background .15s ease;
            }
            .btn.btn-primary.btn-block:hover{
                background: var(--accent-hover);
                border-color: var(--accent-hover);
                box-shadow: 0 10px 24px rgba(246,199,0,.28);
                transform: translateY(-1px);
            }

            .help-row{
                display:flex; justify-content:space-between; align-items:center;
                gap: 12px; color: var(--muted);
                font-size:.92rem;
            }
            .help-row a{ color: var(--accent); }
            .help-row a:hover{ color: var(--accent-hover); text-decoration: underline; }

            /* Separador visual */
            .divider{
                display:flex; align-items:center; gap:12px; color:var(--muted); margin:12px 0;
            }
            .divider::before, .divider::after{
                content:""; flex:1; height:1px; background: var(--line);
            }
        </style>
    </head>

    <body class="hold-transition login-page">
        <div class="auth-wrap">
            <div class="auth-head">
                <img src="{{ url('/') }}/images/logo.png" style="height:100px; margin-bottom:8px; filter:none;"  alt="TJCA">
                <div>
                    <div class="title">Portal TJCA</div>
                    <div class="subtitle">Acceso seguro para colaboradores</div>
                </div>
            </div>

            <div class="login-box">
                <div class="card card-outline card-primary">
                    {{-- Bloque introductorio --}}
                    <div class="card-section">
                        <p class="login-box-msg">Inicie sesión para comenzar</p>
                    </div>

                    {{-- Bloque de formulario con fondo alterno --}}
                    <div class="card-section alt">
                        <form method="post" action="{{ url('/login') }}">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="email" name="email" value="{{ old('email') }}"
                                       placeholder="Correo electrónico"
                                       class="form-control @error('email') is-invalid @enderror">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                                @error('email')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="input-group mb-3">
                                <input type="password" name="password" placeholder="Contraseña"
                                       class="form-control @error('password') is-invalid @enderror">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row align-items-center">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
                                </div>
                                <div class="col-6 text-right">
                                    <small class="text-muted">¿Necesita ayuda? <a href="{{ route('password.request') }}">Recupere su acceso</a></small>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Bloque inferior con enlaces y separador --}}
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
