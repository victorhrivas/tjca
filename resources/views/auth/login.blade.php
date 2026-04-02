<x-laravel-ui-adminlte::adminlte-layout>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/png">

        <style>
            :root{
                --bg-0:#0c1015;
                --bg-1:#10161d;
                --bg-2:#141b24;
                --bg-3:#1a2330;
                --line:rgba(255,255,255,.08);
                --line-strong:rgba(255,255,255,.14);

                --ink:#eef3f8;
                --muted:#aab4c0;
                --muted-2:#7f8b97;

                --accent:#d4ad18;
                --accent-hover:#e6bf2c;
                --accent-ink:#10151b;

                --shadow-xl:0 22px 60px rgba(0,0,0,.45);
                --shadow-md:0 12px 30px rgba(0,0,0,.28);
            }

            html, body {
                height: 100%;
            }

            body.login-page{
                position:relative;
                min-height:100vh;
                margin:0;
                overflow:hidden;
                background:var(--bg-0);
                color:var(--ink);
                font-family:"Inter",system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Arial,sans-serif;
            }

            body.login-page::before{
                content:"";
                position:absolute;
                inset:0;
                background:
                    linear-gradient(to right, rgba(8,11,15,.90) 0%, rgba(8,11,15,.72) 24%, rgba(8,11,15,.38) 48%, rgba(8,11,15,.10) 70%, rgba(8,11,15,.02) 100%),
                    url('{{ url("/images/truck.png") }}') center center / cover no-repeat;
                z-index:0;
            }

            body.login-page::after{
                content:"";
                position:absolute;
                inset:0;
                background:
                    radial-gradient(circle at 78% 46%, rgba(212,173,24,.08), transparent 18%),
                    linear-gradient(to bottom, rgba(255,255,255,.02), rgba(255,255,255,0));
                z-index:0;
                pointer-events:none;
            }

            .login-shell{
                position: relative;
                z-index: 1;
                min-height: 100vh;
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: flex-end;
                padding: 34px 28px 34px 34px;
            }

            .auth-card{
                width: 100%;
                max-width: 420px;
                margin-left: auto;
                margin-right: 0;
                border: 1px solid var(--line);
                border-radius: 24px;
                overflow: hidden;
                background: linear-gradient(180deg, rgba(19,26,35,.94) 0%, rgba(14,20,28,.96) 100%);
                box-shadow: var(--shadow-xl);
                backdrop-filter: blur(10px);
            }

            .auth-head{
                display:flex;
                align-items:center;
                gap:14px;
                padding:18px 20px;
                background:linear-gradient(135deg, var(--accent) 0%, #f1cd43 100%);
                color:var(--accent-ink);
            }

            .auth-head-logo{
                width:58px;
                height:58px;
                border-radius:14px;
                background:rgba(255,255,255,.18);
                display:flex;
                align-items:center;
                justify-content:center;
                flex:0 0 58px;
                box-shadow:inset 0 1px 0 rgba(255,255,255,.25);
            }

            .auth-head-logo img{
                max-width:42px;
                max-height:42px;
                object-fit:contain;
            }

            .auth-head-text{
                min-width:0;
            }

            .auth-head-title{
                margin:0;
                font-size:1.1rem;
                font-weight:800;
                letter-spacing:.02em;
                text-transform:uppercase;
            }

            .auth-head-subtitle{
                margin:3px 0 0 0;
                font-size:.93rem;
                font-weight:600;
                opacity:.9;
            }

            .auth-body{
                padding:24px 22px 20px 22px;
            }

            .auth-intro{
                text-align:center;
                margin-bottom:22px;
            }

            .auth-intro-title{
                margin:0 0 6px 0;
                font-size:1.45rem;
                font-weight:800;
                letter-spacing:-.02em;
                color:#f3f6fa;
            }

            .auth-intro-text{
                margin:0;
                color:var(--muted);
                font-size:.95rem;
                line-height:1.5;
            }

            .form-card{
                padding:18px;
                border-radius:18px;
                background:linear-gradient(180deg, rgba(255,255,255,.03), rgba(255,255,255,.015));
                border:1px solid var(--line);
                box-shadow:inset 0 1px 0 rgba(255,255,255,.03);
            }

            .form-group{
                margin-bottom:16px;
            }

            .form-label{
                display:block;
                margin:0 0 8px 2px;
                font-size:.84rem;
                font-weight:700;
                color:#d6dee7;
            }

            .input-wrap{
                display:flex;
                align-items:center;
                gap:10px;
            }

            .form-control{
                height:52px;
                border-radius:14px !important;
                background:#edf2f8;
                border:1px solid rgba(255,255,255,.08);
                color:#111827;
                padding:0 16px;
                font-size:.95rem;
                box-shadow:none !important;
            }

            .form-control::placeholder{
                color:#6b7280;
            }

            .form-control:focus{
                border-color:rgba(212,173,24,.8);
                box-shadow:0 0 0 .22rem rgba(212,173,24,.14) !important;
                background:#f7f9fc;
                color:#111827;
            }

            .input-icon{
                width:46px;
                height:46px;
                border-radius:13px;
                background:#0f1722;
                border:1px solid rgba(255,255,255,.06);
                color:#dce4ee;
                display:flex;
                align-items:center;
                justify-content:center;
                flex:0 0 46px;
            }

            .invalid-feedback{
                display:block;
                margin-top:7px;
                color:#ff9f9f;
                font-size:.83rem;
            }

            .btn{
                height:52px;
                border-radius:14px;
                font-weight:800;
                letter-spacing:.02em;
                transition:all .16s ease;
            }

            .btn-login{
                width:100%;
                border:none;
                color:var(--accent-ink);
                background:linear-gradient(135deg, var(--accent) 0%, #f0ca3d 100%);
                box-shadow:0 12px 24px rgba(212,173,24,.22);
            }

            .btn-login:hover{
                color:var(--accent-ink);
                background:linear-gradient(135deg, var(--accent-hover) 0%, #f3d24f 100%);
                transform:translateY(-1px);
                box-shadow:0 16px 28px rgba(212,173,24,.28);
            }

            .auth-links{
                display:flex;
                align-items:center;
                justify-content:space-between;
                gap:12px;
                margin-top:14px;
                font-size:.89rem;
            }

            .auth-links span{
                color:var(--muted);
            }

            .auth-links a{
                color:#f0c83a;
                text-decoration:none;
                font-weight:700;
            }

            .auth-links a:hover{
                color:#ffe27a;
                text-decoration:none;
            }

            .auth-divider{
                display:flex;
                align-items:center;
                gap:12px;
                margin:18px 0 14px 0;
                color:var(--muted-2);
                font-size:.84rem;
            }

            .auth-divider::before,
            .auth-divider::after{
                content:"";
                flex:1;
                height:1px;
                background:var(--line);
            }

            .public-tool{
                padding:16px;
                border-radius:16px;
                background:rgba(59,130,246,.05);
                border:1px solid rgba(255,255,255,.06);
            }

            .public-tool-title{
                display:flex;
                align-items:center;
                gap:10px;
                margin:0 0 8px 0;
                font-size:.96rem;
                font-weight:800;
                color:#eef4fb;
            }

            .public-tool-title i{
                color:#9cc0ff;
            }

            .public-tool-text{
                margin:0 0 14px 0;
                color:var(--muted);
                font-size:.9rem;
                line-height:1.5;
            }

            .btn-tool{
                width:100%;
                height:48px;
                border-radius:14px;
                border:1px solid rgba(255,255,255,.10);
                background:#1b2740;
                color:#eef4ff;
                display:flex;
                align-items:center;
                justify-content:center;
                gap:10px;
                font-weight:700;
            }

            .btn-tool:hover{
                color:#fff;
                background:#223253;
                border-color:rgba(156,192,255,.30);
            }

            .auth-note{
                margin-top:16px;
                text-align:center;
                color:var(--muted-2);
                font-size:.81rem;
            }

            .text-muted{
                color:var(--muted) !important;
            }

            /* Modal */
            .modal-content{
                border-radius:20px;
                overflow:hidden;
                border:1px solid rgba(255,255,255,.08);
                background:linear-gradient(180deg, #18212b 0%, #121922 100%) !important;
                box-shadow:var(--shadow-md);
            }

            .modal-header,
            .modal-footer{
                border-color:rgba(255,255,255,.08);
            }

            .modal-header{
                padding:18px 20px;
            }

            .modal-body{
                padding:20px;
            }

            .modal-title{
                font-weight:800;
            }

            .modal .form-control{
                height:50px;
                border-radius:14px !important;
            }

            .modal .btn{
                height:46px;
                border-radius:12px;
            }

            .seguimiento-card{
                margin-top:16px;
                padding:16px;
                border-radius:14px;
                background:rgba(255,255,255,.03);
                border:1px solid rgba(255,255,255,.07);
            }

            .seguimiento-card h6{
                margin:0 0 10px 0;
                font-weight:700;
            }

            .seguimiento-thumbs{
                display:flex;
                flex-wrap:wrap;
                gap:8px;
            }

            .seguimiento-thumbs img{
                width:92px;
                height:92px;
                border-radius:10px;
                border:1px solid rgba(255,255,255,.08);
                object-fit:cover;
                cursor:pointer;
                transition:transform .14s ease, box-shadow .14s ease;
            }

            .seguimiento-thumbs img:hover{
                transform:translateY(-2px);
                box-shadow:0 10px 22px rgba(0,0,0,.35);
            }

            .img-lightbox-backdrop{
                position:fixed;
                inset:0;
                background:rgba(0,0,0,.84);
                display:none;
                align-items:center;
                justify-content:center;
                z-index:1055;
                padding:24px;
            }

            .img-lightbox-backdrop.open{
                display:flex;
            }

            .img-lightbox-inner{
                position:relative;
                max-width:90vw;
                max-height:90vh;
            }

            .img-lightbox-inner img{
                max-width:100%;
                max-height:90vh;
                border-radius:12px;
                box-shadow:0 24px 60px rgba(0,0,0,.6);
            }

            .img-lightbox-close{
                position:absolute;
                top:-12px;
                right:-12px;
                width:36px;
                height:36px;
                border:none;
                border-radius:50%;
                background:#101722;
                color:#fff;
                font-size:1.2rem;
                cursor:pointer;
            }

            .img-lightbox-close:hover{
                background:#d9534f;
            }

            @media (min-width: 993px){
                .login-shell{
                    justify-content:flex-end;
                    padding:34px 22px 34px 34px;
                }

                .auth-card{
                    margin-left:auto;
                    margin-right:0;
                    transform:translateX(0);
                }
            }

            @media (max-width: 992px){
                body.login-page::before{
                    background:
                        linear-gradient(to bottom, rgba(8,11,15,.82) 0%, rgba(8,11,15,.72) 30%, rgba(8,11,15,.55) 100%),
                        url('{{ url("/images/truck.png") }}') center center / cover no-repeat;
                }

                .login-shell{
                    justify-content:center;
                    padding:24px 18px;
                }

                .auth-card{
                    max-width:440px;
                    margin-left:auto;
                    margin-right:auto;
                }
            }

            @media (max-width: 576px){
                .login-shell{
                    padding:14px;
                }

                .auth-card{
                    max-width:100%;
                    border-radius:20px;
                }

                .auth-head{
                    padding:16px;
                }

                .auth-head-logo{
                    width:52px;
                    height:52px;
                    flex-basis:52px;
                }

                .auth-head-logo img{
                    max-width:38px;
                    max-height:38px;
                }

                .auth-body{
                    padding:18px 16px 16px 16px;
                }

                .auth-intro-title{
                    font-size:1.28rem;
                }

                .form-card{
                    padding:14px;
                    border-radius:16px;
                }

                .auth-links{
                    flex-direction:column;
                    align-items:flex-start;
                }
            }
        </style>
    </head>

    <body class="hold-transition login-page">
        <div class="login-shell">
            <div class="auth-card">
                <div class="auth-head">
                    <div class="auth-head-logo">
                        <img src="{{ url('/') }}/images/logo.png" alt="TJCA">
                    </div>
                    <div class="auth-head-text">
                        <h1 class="auth-head-title">Portal TJCA</h1>
                        <p class="auth-head-subtitle">Acceso para colaboradores</p>
                    </div>
                </div>

                <div class="auth-body">
                    <div class="auth-intro">
                        <h2 class="auth-intro-title">Inicie sesión</h2>
                        <p class="auth-intro-text">Ingrese sus credenciales para continuar.</p>
                    </div>

                    <div class="form-card">
                        <form method="POST" action="{{ url('/login') }}">
                            @csrf

                            <div class="form-group">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <div class="input-wrap">
                                    <input
                                        id="email"
                                        type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        placeholder="correo@empresa.cl"
                                        class="form-control @error('email') is-invalid @enderror"
                                        autocomplete="username"
                                        autofocus
                                    >
                                    <div class="input-icon">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password" class="form-label">Contraseña</label>
                                <div class="input-wrap">
                                    <input
                                        id="password"
                                        type="password"
                                        name="password"
                                        placeholder="Ingrese su contraseña"
                                        class="form-control @error('password') is-invalid @enderror"
                                        autocomplete="current-password"
                                    >
                                    <div class="input-icon">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-login">
                                Iniciar sesión
                            </button>

                            <div class="auth-links">
                                <span>¿Necesita ayuda con su acceso?</span>
                                <a href="{{ route('password.request') }}">Recuperar contraseña</a>
                            </div>
                        </form>

                        <div class="auth-divider">Consulta pública</div>

                        <div class="public-tool">
                            <div class="public-tool-title">
                                <i class="fas fa-route"></i>
                                <span>Seguimiento de OT</span>
                            </div>
                            <p class="public-tool-text">
                                Consulte el estado de una OT sin iniciar sesión.
                            </p>
                            <button
                                type="button"
                                class="btn btn-tool"
                                data-toggle="modal"
                                data-target="#modalSeguimientoOT"
                            >
                                <i class="fas fa-search-location"></i>
                                <span>Abrir seguimiento</span>
                            </button>
                        </div>
                    </div>

                    <div class="auth-note">
                        Acceso restringido a personal autorizado.
                    </div>
                </div>
            </div>
        </div>
    </body>

    {{-- Modal Seguimiento OT --}}
    <div class="modal fade" id="modalSeguimientoOT" tabindex="-1" role="dialog" aria-labelledby="modalSeguimientoOTLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content text-light">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSeguimientoOTLabel">Seguimiento de OT</h5>
                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="formSeguimientoOT" onsubmit="return false;">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-0">
                            <label for="numero_ot" class="form-label">Folio de OT</label>
                            <input
                                type="text"
                                class="form-control"
                                id="numero_ot"
                                name="numero_ot"
                                placeholder="Ej: 202512/001"
                                required
                            >
                        </div>

                        <div id="seguimientoLoading" class="seguimiento-card" style="display: none;">
                            Consultando estado…
                        </div>

                        <div id="seguimientoError" class="seguimiento-card text-danger" style="display: none;"></div>

                        <div id="seguimientoResultado" class="seguimiento-card" style="display: none;">
                            <h6>Estado actual</h6>
                            <p class="mb-1">
                                <strong>Folio:</strong> <span id="res_ot"></span><br>
                                <strong>Estado:</strong> <span id="res_estado" class="badge badge-info"></span>
                            </p>
                            <small id="res_detalle" class="text-muted"></small>
                        </div>

                        <div id="seguimientoImagenes" class="seguimiento-card" style="display: none;">
                            <h6>Fotos relacionadas</h6>

                            <div class="mb-3">
                                <small class="text-muted d-block mb-2">Inicio de carga</small>
                                <div id="imgs_inicio_carga" class="seguimiento-thumbs"></div>
                            </div>

                            <div class="mb-0">
                                <small class="text-muted d-block mb-2">Entrega</small>
                                <div id="imgs_entrega" class="seguimiento-thumbs"></div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" id="btnConsultarSeguimiento" class="btn btn-primary">Consultar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Lightbox de imagen --}}
    <div id="imgLightbox" class="img-lightbox-backdrop" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="img-lightbox-inner">
            <button type="button" id="imgLightboxClose" class="img-lightbox-close" aria-label="Cerrar imagen">&times;</button>
            <img id="imgLightboxImg" src="" alt="Vista ampliada">
        </div>
    </div>

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
                lightbox.addEventListener('click', function(e) {
                    if (e.target === lightbox) {
                        closeLightbox();
                    }
                });
            }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeLightbox();
                }
            });

            if (modal) {
                modal.addEventListener('shown.bs.modal', function () {
                    if (inputOT) inputOT.value = '';

                    if (resBox) resBox.style.display = 'none';

                    if (errBox) {
                        errBox.style.display = 'none';
                        errBox.textContent = '';
                    }

                    if (loading) loading.style.display = 'none';

                    if (imgBox) imgBox.style.display = 'none';
                    if (imgsInicio) imgsInicio.innerHTML = '';
                    if (imgsEntrega) imgsEntrega.innerHTML = '';

                    if (inputOT) inputOT.focus();
                });
            }

            function pintarImagenes(inicioFotos, entregaFotos) {
                if (!imgBox || !imgsInicio || !imgsEntrega) return;

                imgsInicio.innerHTML = '';
                imgsEntrega.innerHTML = '';

                const tieneInicio = Array.isArray(inicioFotos) && inicioFotos.length > 0;
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

                if (resBox) resBox.style.display = 'none';

                if (errBox) {
                    errBox.style.display = 'none';
                    errBox.textContent = '';
                }

                if (loading) loading.style.display = 'block';

                if (imgBox) imgBox.style.display = 'none';
                if (imgsInicio) imgsInicio.innerHTML = '';
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
                                data.entrega_fotos || []
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
                btnConsultar.addEventListener('click', function(e) {
                    e.preventDefault();
                    consultarSeguimiento();
                });
            }

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