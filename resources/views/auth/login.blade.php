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

            .auth-wrap {
                position: relative;
                z-index: 1;
                max-width: 900px;
                max-height: 700px;
                margin: 40px auto 40px auto;
                margin-right: 10%;
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
            .divider{display:flex;align-items:center;gap:12px;color:var(--muted);margin:12px 0}
            .divider::before,.divider::after{content:"";flex:1;height:1px;background:var(--line)}

            .action-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}
            .action-tile{display:flex;align-items:center;justify-content:center;gap:10px;height:56px;border:1px solid var(--line);background:var(--bg-2);border-radius:12px;color:var(--ink);cursor:pointer;transition:.15s ease}
            .action-tile:hover{border-color:var(--accent);color:var(--accent)}
            .action-tile i{font-size:1.1rem}

            .checklist{display:grid;grid-template-columns:1fr 1fr;gap:10px}
            .check-item{display:flex;align-items:center;gap:10px;padding:10px 12px;background:var(--bg-2);border:1px solid var(--line);border-radius:10px}
            .check-item input{accent-color:var(--accent)}

            @media (max-width: 640px){
                .action-grid{grid-template-columns:1fr}
                .checklist{grid-template-columns:1fr}
            }

            /* Thumbs de fotos en seguimiento */
            .seguimiento-thumbs img {
                max-width: 90px;
                max-height: 90px;
                border-radius: 6px;
                border: 1px solid var(--line);
                object-fit: cover;
                margin-right: 6px;
                margin-bottom: 6px;
                cursor: pointer;
                transition: .12s ease-out;
            }
            .seguimiento-thumbs img:hover {
                transform: translateY(-1px);
                box-shadow: 0 6px 16px rgba(0,0,0,.4);
            }

            /* Lightbox simple sin jQuery */
            .img-lightbox-backdrop {
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,.82);
                display: none;
                align-items: center;
                justify-content: center;
                z-index: 1055; /* por encima del modal de Bootstrap */
            }
            .img-lightbox-backdrop.open {
                display: flex;
            }
            .img-lightbox-inner {
                position: relative;
                max-width: 90vw;
                max-height: 90vh;
            }
            .img-lightbox-inner img {
                max-width: 100%;
                max-height: 100%;
                border-radius: 8px;
                box-shadow: 0 20px 60px rgba(0,0,0,.6);
            }
            .img-lightbox-close {
                position: absolute;
                top: -14px;
                right: -14px;
                width: 32px;
                height: 32px;
                border-radius: 50%;
                border: none;
                background: rgba(16,17,20,.95);
                color: #fff;
                font-size: 1.2rem;
                line-height: 1;
                cursor: pointer;
                box-shadow: 0 8px 20px rgba(0,0,0,.5);
            }
            .img-lightbox-close:hover {
                background: #ff4b4b;
            }
        </style>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
        @media (max-width: 992px){
            body.login-page::before{
                background:
                linear-gradient(to bottom, rgba(16,17,20,0.95) 0%, rgba(16,17,20,0.85) 35%, rgba(16,17,20,0.75) 100%),
                url('{{ url("/images/truck.png") }}') center / cover no-repeat;
                opacity: 1;
            }

            .auth-wrap{
                max-width: 720px;
                margin: 32px auto;
                padding: 20px;
            }

            .auth-head{ padding: 10px 12px; gap: 12px; }
            .auth-head img{ height: 72px; }
            .auth-head .title{ font-size: 0.95rem; }
            .auth-head .subtitle{ display:none; }
        }

        @media (max-width: 576px){
            .auth-wrap{
                max-width: 540px;
                width: calc(100% - 24px);
                margin: 20px auto;
                border-radius: 14px;
            }

            .card-section{ padding: 16px; }
            .card-section.alt{ padding: 16px; }

            .form-control{ height: 48px; }
            .btn{ height: 48px; }

            .action-grid{ grid-template-columns: 1fr; gap: 10px; }

            .auth-head{ gap: 10px; }
            .auth-head img{ height: 56px; }
        }

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

                        {{-- Inicio de carga --}}
                        <a href="{{ route('inicio-cargas.create') }}" class="action-tile">
                            <i class="fas fa-truck-loading"></i>
                            <span>Inicio de carga</span>
                        </a>

                        {{-- Entrega --}}
                        <a href="{{ route('entregas.create') }}" class="action-tile">
                            <i class="fas fa-clipboard-check"></i>
                            <span>Entrega</span>
                        </a>

                        {{-- Checklist camión --}}
                        <a href="{{ route('checklist-camions.create') }}" class="action-tile">
                            <i class="fas fa-list-check"></i>
                            <span>Checklist camión</span>
                        </a>

                        {{-- Seguimiento OT --}}
                        <button type="button"
                                class="action-tile"
                                data-toggle="modal"
                                data-target="#modalSeguimientoOT">
                            <i class="fas fa-route"></i>
                            <span>Seguimiento</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>

    {{-- Modal Seguimiento OT --}}
    <div class="modal fade" id="modalSeguimientoOT" tabindex="-1" role="dialog" aria-labelledby="modalSeguimientoOTLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSeguimientoOTLabel">Seguimiento de OT</h5>
                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- NO queremos que el form haga submit normal --}}
                <form id="formSeguimientoOT" onsubmit="return false;">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="numero_ot">Folio de OT</label>
                            <input type="text"
                                   class="form-control"
                                   id="numero_ot"
                                   name="numero_ot"
                                   placeholder="Ej: 202512/001"
                                   required>
                        </div>

                        <div id="seguimientoResultado" class="mt-3" style="display: none;">
                            <hr>
                            <h6 class="mb-2">Estado actual</h6>
                            <p class="mb-1">
                                <strong>Folio:</strong> <span id="res_ot"></span><br>
                                <strong>Estado:</strong> <span id="res_estado" class="badge badge-info"></span>
                            </p>
                            <small id="res_detalle" class="text-muted"></small>
                        </div>

                        {{-- Fotos relacionadas --}}
                        <div id="seguimientoImagenes" class="mt-3" style="display: none;">
                            <hr>
                            <h6 class="mb-2">Fotos relacionadas</h6>

                            <div class="mb-2">
                                <small class="text-muted d-block mb-1">Inicio de carga</small>
                                <div id="imgs_inicio_carga" class="seguimiento-thumbs"></div>
                            </div>

                            <div class="mb-2">
                                <small class="text-muted d-block mb-1">Entrega</small>
                                <div id="imgs_entrega" class="seguimiento-thumbs"></div>
                            </div>
                        </div>

                        <div id="seguimientoLoading" class="mt-3" style="display: none;">
                            Consultando estado…
                        </div>

                        <div id="seguimientoError" class="mt-3 text-danger" style="display: none;"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        {{-- IMPORTANTE: type="button" para NO enviar el form --}}
                        <button type="button" id="btnConsultarSeguimiento" class="btn btn-primary">Consultar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Lightbox de imagen (sin jQuery) --}}
    <div id="imgLightbox" class="img-lightbox-backdrop" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="img-lightbox-inner">
            <button type="button" id="imgLightboxClose" class="img-lightbox-close" aria-label="Cerrar imagen">&times;</button>
            <img id="imgLightboxImg" src="" alt="Vista ampliada">
        </div>
    </div>

    {{-- Script directo, sin depender de @push --}}
    <script>
        (function() {
            const modal        = document.getElementById('modalSeguimientoOT');
            const inputOT      = document.getElementById('numero_ot');
            const resBox       = document.getElementById('seguimientoResultado');
            const resOT        = document.getElementById('res_ot');
            const resEstado    = document.getElementById('res_estado');
            const resDetalle   = document.getElementById('res_detalle');
            const loading      = document.getElementById('seguimientoLoading');
            const errBox       = document.getElementById('seguimientoError');
            const btnConsultar = document.getElementById('btnConsultarSeguimiento');

            const imgBox       = document.getElementById('seguimientoImagenes');
            const imgsInicio   = document.getElementById('imgs_inicio_carga');
            const imgsEntrega  = document.getElementById('imgs_entrega');

            // Lightbox
            const lightbox      = document.getElementById('imgLightbox');
            const lightboxImg   = document.getElementById('imgLightboxImg');
            const lightboxClose = document.getElementById('imgLightboxClose');

            function openLightbox(url) {
                if (!lightbox || !lightboxImg) return;
                lightboxImg.src = url;
                lightbox.classList.add('open');
                lightbox.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            }

            function closeLightbox() {
                if (!lightbox || !lightboxImg) return;
                lightbox.classList.remove('open');
                lightbox.setAttribute('aria-hidden', 'true');
                lightboxImg.src = '';
                document.body.style.overflow = '';
            }

            if (lightboxClose) {
                lightboxClose.addEventListener('click', function() {
                    closeLightbox();
                });
            }

            if (lightbox) {
                // Cerrar al hacer click fuera de la imagen
                lightbox.addEventListener('click', function(e) {
                    if (e.target === lightbox) {
                        closeLightbox();
                    }
                });
            }

            // Cerrar con ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeLightbox();
                }
            });

            // Limpia el modal cada vez que se abre
            if (modal) {
                modal.addEventListener('shown.bs.modal', function () {
                    if (inputOT) inputOT.value = '';

                    if (resBox)  resBox.style.display = 'none';
                    if (errBox) {
                        errBox.style.display = 'none';
                        errBox.textContent = '';
                    }
                    if (loading) loading.style.display = 'none';

                    if (imgBox) imgBox.style.display = 'none';
                    if (imgsInicio)  imgsInicio.innerHTML = '';
                    if (imgsEntrega) imgsEntrega.innerHTML = '';

                    if (inputOT) inputOT.focus();
                });
            }

            function pintarImagenes(inicioFotos, entregaFotos) {
                if (!imgBox || !imgsInicio || !imgsEntrega) {
                    return;
                }

                imgsInicio.innerHTML  = '';
                imgsEntrega.innerHTML = '';

                const tieneInicio  = Array.isArray(inicioFotos)  && inicioFotos.length > 0;
                const tieneEntrega = Array.isArray(entregaFotos) && entregaFotos.length > 0;

                if (!tieneInicio && !tieneEntrega) {
                    imgBox.style.display = 'none';
                    return;
                }

                if (tieneInicio) {
                    inicioFotos.forEach(function(url) {
                        const a = document.createElement('a');
                        a.href = url;

                        const img = document.createElement('img');
                        img.src = url;
                        img.alt = 'Foto inicio de carga';

                        a.appendChild(img);
                        a.addEventListener('click', function(ev) {
                            ev.preventDefault();
                            openLightbox(url);
                        });

                        imgsInicio.appendChild(a);
                    });
                }

                if (tieneEntrega) {
                    entregaFotos.forEach(function(url) {
                        const a = document.createElement('a');
                        a.href = url;

                        const img = document.createElement('img');
                        img.src = url;
                        img.alt = 'Foto entrega';

                        a.appendChild(img);
                        a.addEventListener('click', function(ev) {
                            ev.preventDefault();
                            openLightbox(url);
                        });

                        imgsEntrega.appendChild(a);
                    });
                }

                imgBox.style.display = 'block';
            }

            function consultarSeguimiento() {
                if (!inputOT) return;

                const folio = inputOT.value.trim();
                if (!folio) return;

                // Reset visual
                if (resBox)  resBox.style.display = 'none';
                if (errBox) {
                    errBox.style.display = 'none';
                    errBox.textContent = '';
                }
                if (loading) loading.style.display = 'block';

                if (imgBox) imgBox.style.display = 'none';
                if (imgsInicio)  imgsInicio.innerHTML = '';
                if (imgsEntrega) imgsEntrega.innerHTML = '';

                fetch("{{ route('seguimiento-ot.consultar') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ numero_ot: folio })
                })
                .then(function(response) {
                    return response.json().catch(function() {
                        return {};
                    }).then(function(data) {
                        if (loading) loading.style.display = 'none';

                        if (!response.ok) {
                            if (errBox) {
                                errBox.textContent = data.message || 'Ocurrió un error al consultar el seguimiento.';
                                errBox.style.display = 'block';
                            }
                            return;
                        }

                        if (data.found) {
                            if (resOT) resOT.textContent = data.folio || '';

                            if (resEstado) {
                                resEstado.textContent = data.estado || '';
                                if (data.badge_class) {
                                    resEstado.className = 'badge ' + data.badge_class;
                                }
                            }

                            const partes = [];
                            if (data.cliente)   partes.push('Cliente: ' + data.cliente);
                            if (data.origen)    partes.push('Origen: ' + data.origen);
                            if (data.destino)   partes.push('Destino: ' + data.destino);
                            if (data.conductor) partes.push('Conductor: ' + data.conductor);
                            if (data.fecha)     partes.push('Fecha: ' + data.fecha);

                            if (resDetalle) resDetalle.textContent = partes.join(' • ');

                            if (resBox) resBox.style.display = 'block';

                            pintarImagenes(
                                data.inicio_carga_fotos || [],
                                data.entrega_fotos      || []
                            );
                        } else {
                            if (errBox) {
                                errBox.textContent = data.message || 'No se encontró una OT con ese folio.';
                                errBox.style.display = 'block';
                            }
                        }
                    });
                })
                .catch(function(err) {
                    if (loading) loading.style.display = 'none';
                    if (errBox) {
                        errBox.textContent = 'Ocurrió un error al consultar el seguimiento. Intenta nuevamente.';
                        errBox.style.display = 'block';
                    }
                    console.error(err);
                });
            }

            if (btnConsultar) {
                btnConsultar.addEventListener('click', function (e) {
                    e.preventDefault();
                    consultarSeguimiento();
                });
            }

            // Bloqueo de submit estándar del formulario
            const form = document.getElementById('formSeguimientoOT');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    return false;
                });
            }
        })();
    </script>

</x-laravel-ui-adminlte::adminlte-layout>
