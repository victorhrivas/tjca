<style>
    :root {
        --bg-0: #101114;
        --bg-1: #15171b;
        --bg-2: #1c1f24;
        --bg-3: #23272e;
        --line: #2c3139;
        --ink: #e6e7ea;
        --muted: #a7adb7;
        --accent: #f6c700;
        --accent-hover: #ffd84d;
        --accent-ink: #0b0c0e;
    }

    .main-sidebar {
        background: linear-gradient(180deg, var(--bg-2), var(--bg-1)) !important;
        border-right: 1px solid var(--line);
        box-shadow: 4px 0 15px rgba(0,0,0,0.3);
    }

    .brand-link {
        background: var(--bg-1);
        border-bottom: 1px solid var(--line);
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
    }

    .brand-link .brand-image {
        height: 38px;
        width: auto;
        margin-right: 8px;
        filter: brightness(1.2);
    }

    .brand-text {
        color: var(--ink);
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .nav-sidebar .nav-item > .nav-link {
        color: var(--muted);
        border-radius: 8px;
        margin: 2px 8px;
        transition: all 0.2s ease-in-out;
        font-weight: 500;
        font-size: 0.94rem;
    }

    .nav-sidebar .nav-item > .nav-link i {
        color: var(--muted);
        transition: color 0.2s ease-in-out;
        margin-right: 6px;
    }

    /* Hover */
    .nav-sidebar .nav-item > .nav-link:hover {
        background: var(--bg-3);
        color: var(--accent);
    }

    .nav-sidebar .nav-item > .nav-link:hover i {
        color: var(--accent);
    }

    /* Activo */
    .nav-sidebar .nav-item > .nav-link.active,
    .nav-sidebar .nav-item.menu-open > .nav-link,
    .nav-sidebar .nav-item > .nav-link.active:focus,
    .nav-sidebar .nav-item > .nav-link.active:hover {
        background: var(--accent) !important;
        color: var(--accent-ink) !important;
        font-weight: 700;
        box-shadow: 0 0 12px rgba(246,199,0,0.25);
    }

    .nav-sidebar .nav-item > .nav-link.active i,
    .nav-sidebar .nav-item.menu-open > .nav-link i {
        color: var(--accent-ink) !important;
    }

    /* Submenús */
    .nav-treeview > .nav-item > .nav-link {
        color: var(--muted);
        background: var(--bg-2);
        border-left: 2px solid transparent;
        margin: 1px 14px;
        border-radius: 6px;
        font-size: 0.9rem;
    }

    .nav-treeview > .nav-item > .nav-link:hover {
        color: var(--accent);
        background: var(--bg-3);
        border-left: 2px solid var(--accent);
    }

    .nav-treeview > .nav-item > .nav-link.active {
        color: var(--accent-ink);
        background: var(--accent);
        font-weight: 600;
        border-left: 2px solid var(--accent);
    }

    /* Scrollbar */
    .sidebar::-webkit-scrollbar {
        width: 6px;
    }
    .sidebar::-webkit-scrollbar-thumb {
        background-color: var(--line);
        border-radius: 4px;
    }
</style>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('home') }}" class="brand-link" style="display:flex;align-items:center;gap:10px;padding:14px 18px;background:#15171b;border-bottom:1px solid #2c3139;">
        <img src="{{ url('/') }}/images/logo.png"
             alt="TJCA Logo"
             class="brand-image"
             style="height:55px;width:auto;margin-right:8px;filter:brightness(1.15);">
        <span class="brand-text" style="color:#e6e7ea;font-weight:700;letter-spacing:.5px;text-transform:uppercase;">
            {{ config('app.name') }}
        </span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview" role="menu" data-accordion="false">
                @include('layouts.menu')
            </ul>
        </nav>
    </div>
</aside>
