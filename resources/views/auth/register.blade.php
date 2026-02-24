<x-laravel-ui-adminlte::adminlte-layout>
    <head>
        <link rel="shortcut icon" href="{{ asset('images/pirca-mini.png') }}" type="image/png">
        <style>
            /* =========================
               Estilos Globales - Modo Oscuro
            ========================== */
            body.register-page {
                background-color: #121212 !important;
            }
            .register-box {
                background-color: #1f1f1f;
                border-color: #333;
            }
            .register-logo a {
                color: #64b5f6;
            }
            .card.card-outline.card-primary {
                background-color: #1f1f1f;
                border: 1px solid #333;
            }
            .register-card-body {
                color: #1f1f1f;
            }
            .login-box-msg {
                color: #e0e0e0;
            }
            .form-control {
                background-color: #2c2c2c;
                border: 1px solid #444;
                color: #e0e0e0;
            }
            .form-control:focus {
                background-color: #2c2c2c;
                border-color: #64b5f6;
                box-shadow: none;
            }
            .input-group-text {
                background-color: #2c2c2c;
                border: 1px solid #444;
                color: #e0e0e0;
            }
            .btn.btn-primary.btn-block {
                background-color: #64b5f6;
                border-color: #64b5f6;
                color: #121212;
            }
            .btn.btn-primary.btn-block:hover {
                background-color: #42a5f5;
                border-color: #42a5f5;
                color: #fff;
            }
            .icheck-primary input[type="checkbox"] + label {
                color: #e0e0e0;
            }
            a {
                color: #64b5f6;
            }
            a:hover {
                color: #42a5f5;
            }
        </style>
    </head>
    <body class="hold-transition register-page" style="background: #121212;">
        <div class="register-box">
            <!-- Logo centrado -->
            <div class="register-logo">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/Pirca-white.png') }}" alt="Logo Pirca" style="max-width: 350px;">
                </a>
            </div>
            <!-- /.register-logo -->

            <div class="card card-outline card-primary">
                <div class="card-body register-card-body register-box">
                    <p class="login-box-msg">Crea una nueva cuenta</p>

                    <form method="post" action="{{ route('register') }}">
                        @csrf

                        <div class="input-group mb-3">
                            <input type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                placeholder="Nombre completo">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                            @error('name')
                                <span class="error invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror" placeholder="Correo electrónico">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            @error('email')
                                <span class="error invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder="Contraseña">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            @error('password')
                                <span class="error invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Repetir contraseña">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                                    <label for="agreeTerms">
                                        Acepto los <a href="#">términos y condiciones</a>
                                    </label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

                    <a href="{{ route('login') }}" class="text-center">Ya tengo una cuenta</a>
                </div>
                <!-- /.register-card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.register-box -->
    </body>
</x-laravel-ui-adminlte::adminlte-layout>
