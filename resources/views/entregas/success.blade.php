{{-- resources/views/entregas/success.blade.php --}}
<x-laravel-ui-adminlte::adminlte-layout>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/png">

        <style>
            :root{
                --bg-0:#101114;--bg-1:#15171b;--bg-2:#1c1f24;
                --accent:#d4ad18;--accent-hover:#e1ba1f;--accent-ink:#0b0c0e;
                --ink:#e6e7ea;--muted:#a7adb7;--line:#2c3139;
                --shadow:0 14px 40px rgba(0,0,0,.45);
            }
            body {
                background: var(--bg-0);
                color: var(--ink);
                font-family: "Inter", sans-serif;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                padding: 20px;
            }
            .box {
                max-width: 480px;
                width: 100%;
                background: var(--bg-2);
                padding: 30px;
                border-radius: 16px;
                border: 1px solid var(--line);
                box-shadow: var(--shadow);
                text-align: center;
            }
            .icon {
                width: 80px;
                margin-bottom: 18px;
            }
            .title {
                font-size: 1.3rem;
                font-weight: 800;
                margin-bottom: 10px;
                color: var(--accent);
            }
            .msg {
                font-size: .95rem;
                color: var(--muted);
                margin-bottom: 26px;
            }
            .btn-accent{
                background:var(--accent);
                color:var(--accent-ink);
                padding:10px 20px;
                font-weight:700;
                border-radius:10px;
                border:1px solid var(--accent);
                text-decoration:none;
            }
            .btn-accent:hover{
                background:var(--accent-hover);
                border-color:var(--accent-hover);
                box-shadow:0 6px 20px rgba(246,199,0,.25);
            }
        </style>
    </head>

    <body>
        <div class="box">
            <img src="{{ asset('images/check.png') }}" class="icon" alt="OK">

            <div class="title">¡Entrega registrada!</div>

            <div class="msg">
                El registro de <strong>entrega de servicio</strong> fue guardado correctamente.
                Gracias por completar la información para el cliente.
            </div>

            <a href="{{ route('login') }}" class="btn-accent">
                Volver al menú principal
            </a>
        </div>
    </body>
</x-laravel-ui-adminlte::adminlte-layout>
