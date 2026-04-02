@extends('layouts.app')

@push('styles')
<style>
    .rol-page{
        --rol-bg-card:#ffffff;
        --rol-bg-head:#f6f8fb;
        --rol-border:#e5e7eb;
        --rol-text:#4b5563;
        --rol-text-strong:#111827;
        --rol-text-muted:#6b7280;
        --rol-shadow:0 10px 30px rgba(15,23,42,.06);
        --rol-radius:14px;
    }

    body.dark-mode .rol-page,
    .dark-mode .rol-page,
    body[class*="dark"] .rol-page{
        --rol-bg-card:#232a31;
        --rol-bg-head:#2a323a;
        --rol-border:#3a434d;
        --rol-text:#d7dee5;
        --rol-text-strong:#f3f6f9;
        --rol-text-muted:#aab4bf;
        --rol-shadow:0 12px 28px rgba(0,0,0,.22);
    }

    .rol-page .rol-title{
        font-size:1.7rem;
        font-weight:800;
        letter-spacing:-.02em;
        color:var(--rol-text-strong);
        margin-bottom:.15rem;
    }

    .rol-page .rol-subtitle{
        color:var(--rol-text-muted);
        font-size:.92rem;
        margin-bottom:0;
    }

    .rol-page .rol-card{
        background:var(--rol-bg-card);
        border:1px solid var(--rol-border);
        border-radius:var(--rol-radius);
        box-shadow:var(--rol-shadow);
        overflow:hidden;
    }

    .rol-page .rol-card-header{
        background:var(--rol-bg-head);
        border-bottom:1px solid var(--rol-border);
        padding:12px 16px;
    }

    .rol-page .rol-card-title{
        margin:0;
        color:var(--rol-text-strong);
        font-size:.95rem;
        font-weight:800;
        display:flex;
        align-items:center;
        gap:.5rem;
    }

    .rol-page .rol-card-body{
        padding:16px;
    }

    .rol-page .rol-toolbar{
        display:flex;
        justify-content:space-between;
        align-items:end;
        gap:1rem;
        margin-bottom:1rem;
    }

    .rol-page .rol-toolbar-right{
        display:flex;
        gap:.5rem;
        flex-wrap:wrap;
    }

    .rol-page .form-control{
        border-radius:10px !important;
        min-height:38px;
        box-shadow:none !important;
    }

    .rol-page .btn{
        border-radius:10px;
        font-weight:700;
        min-height:38px;
    }

    @media (max-width: 767.98px){
        .rol-page .rol-toolbar{
            flex-direction:column;
            align-items:stretch;
        }

        .rol-page .rol-toolbar-right{
            width:100%;
        }

        .rol-page .rol-toolbar-right .btn{
            width:100%;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid mt-4 rol-page">

    <div class="rol-toolbar">
        <div>
            <h1 class="rol-title">Roles</h1>
            <p class="rol-subtitle">Administración de roles y permisos del sistema.</p>
        </div>

        <div class="rol-toolbar-right">
            <a class="btn btn-primary" href="{{ route('roles.create') }}">
                <i class="fas fa-plus mr-1"></i> Nuevo
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="rol-card mb-3">
        <div class="rol-card-header">
            <h3 class="rol-card-title">
                <i class="fas fa-filter"></i>
                Filtros
            </h3>
        </div>

        <div class="rol-card-body">
            <form method="GET" action="{{ route('roles.index') }}">
                <div class="row align-items-end">
                    <div class="col-md-9 mb-3">
                        <label>Texto libre</label>
                        <input type="text"
                               name="q"
                               class="form-control"
                               value="{{ request('q') }}"
                               placeholder="Nombre del rol">
                    </div>

                    <div class="col-md-3 mb-3">
                        <button class="btn btn-primary btn-block">
                            <i class="fas fa-search mr-1"></i> Filtrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="rol-card">
        <div class="rol-card-header">
            <h3 class="rol-card-title">
                <i class="fas fa-user-shield"></i>
                Listado de roles
            </h3>
        </div>

        <div class="rol-card-body p-0">
            @include('roles.table')
        </div>
    </div>

</div>
@endsection