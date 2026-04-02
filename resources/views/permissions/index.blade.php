@extends('layouts.app')

@push('styles')
<style>
    .per-page{
        --per-bg-card:#ffffff;
        --per-bg-head:#f6f8fb;
        --per-border:#e5e7eb;
        --per-text:#4b5563;
        --per-text-strong:#111827;
        --per-text-muted:#6b7280;
        --per-shadow:0 10px 30px rgba(15,23,42,.06);
        --per-radius:14px;
    }

    body.dark-mode .per-page,
    .dark-mode .per-page,
    body[class*="dark"] .per-page{
        --per-bg-card:#232a31;
        --per-bg-head:#2a323a;
        --per-border:#3a434d;
        --per-text:#d7dee5;
        --per-text-strong:#f3f6f9;
        --per-text-muted:#aab4bf;
        --per-shadow:0 12px 28px rgba(0,0,0,.22);
    }

    .per-page .per-title{
        font-size:1.7rem;
        font-weight:800;
        letter-spacing:-.02em;
        color:var(--per-text-strong);
        margin-bottom:.15rem;
    }

    .per-page .per-subtitle{
        color:var(--per-text-muted);
        font-size:.92rem;
        margin-bottom:0;
    }

    .per-page .per-card{
        background:var(--per-bg-card);
        border:1px solid var(--per-border);
        border-radius:var(--per-radius);
        box-shadow:var(--per-shadow);
        overflow:hidden;
    }

    .per-page .per-card-header{
        background:var(--per-bg-head);
        border-bottom:1px solid var(--per-border);
        padding:12px 16px;
    }

    .per-page .per-card-title{
        margin:0;
        color:var(--per-text-strong);
        font-size:.95rem;
        font-weight:800;
        display:flex;
        align-items:center;
        gap:.5rem;
    }

    .per-page .per-card-body{
        padding:16px;
    }

    .per-page .per-toolbar{
        display:flex;
        justify-content:space-between;
        align-items:end;
        gap:1rem;
        margin-bottom:1rem;
    }

    .per-page .form-control{
        border-radius:10px !important;
        min-height:38px;
        box-shadow:none !important;
    }

    .per-page .btn{
        border-radius:10px;
        font-weight:700;
        min-height:38px;
    }

    @media (max-width: 767.98px){
        .per-page .per-toolbar{
            flex-direction:column;
            align-items:stretch;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid mt-4 per-page">

    <div class="per-toolbar">
        <div>
            <h1 class="per-title">Permisos</h1>
            <p class="per-subtitle">Listado de permisos disponibles en el sistema.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="per-card mb-3">
        <div class="per-card-header">
            <h3 class="per-card-title">
                <i class="fas fa-filter"></i>
                Filtros
            </h3>
        </div>

        <div class="per-card-body">
            <form method="GET" action="{{ route('permissions.index') }}">
                <div class="row align-items-end">
                    <div class="col-md-9 mb-3">
                        <label>Texto libre</label>
                        <input type="text"
                               name="q"
                               class="form-control"
                               value="{{ request('q') }}"
                               placeholder="Nombre del permiso">
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

    <div class="per-card">
        <div class="per-card-header">
            <h3 class="per-card-title">
                <i class="fas fa-key"></i>
                Listado de permisos
            </h3>
        </div>

        <div class="per-card-body p-0">
            @include('permissions.table')
        </div>
    </div>

</div>
@endsection