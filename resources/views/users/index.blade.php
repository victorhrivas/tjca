@extends('layouts.app')

@push('styles')
<style>
    .usr-page{
        --usr-bg-card:#ffffff;
        --usr-bg-head:#f6f8fb;
        --usr-border:#e5e7eb;
        --usr-text:#4b5563;
        --usr-text-strong:#111827;
        --usr-text-muted:#6b7280;
        --usr-shadow:0 10px 30px rgba(15,23,42,.06);
        --usr-radius:14px;
    }

    body.dark-mode .usr-page,
    .dark-mode .usr-page,
    body[class*="dark"] .usr-page{
        --usr-bg-card:#232a31;
        --usr-bg-head:#2a323a;
        --usr-border:#3a434d;
        --usr-text:#d7dee5;
        --usr-text-strong:#f3f6f9;
        --usr-text-muted:#aab4bf;
        --usr-shadow:0 12px 28px rgba(0,0,0,.22);
    }

    .usr-page .usr-title{
        font-size:1.7rem;
        font-weight:800;
        letter-spacing:-.02em;
        color:var(--usr-text-strong);
        margin-bottom:.15rem;
    }

    .usr-page .usr-subtitle{
        color:var(--usr-text-muted);
        font-size:.92rem;
        margin-bottom:0;
    }

    .usr-page .usr-card{
        background:var(--usr-bg-card);
        border:1px solid var(--usr-border);
        border-radius:var(--usr-radius);
        box-shadow:var(--usr-shadow);
        overflow:hidden;
    }

    .usr-page .usr-card-header{
        background:var(--usr-bg-head);
        border-bottom:1px solid var(--usr-border);
        padding:12px 16px;
    }

    .usr-page .usr-card-title{
        margin:0;
        color:var(--usr-text-strong);
        font-size:.95rem;
        font-weight:800;
        display:flex;
        align-items:center;
        gap:.5rem;
    }

    .usr-page .usr-card-body{
        padding:16px;
    }

    .usr-page .usr-toolbar{
        display:flex;
        justify-content:space-between;
        align-items:end;
        gap:1rem;
        margin-bottom:1rem;
    }

    .usr-page .usr-toolbar-right{
        display:flex;
        gap:.5rem;
        flex-wrap:wrap;
    }

    .usr-page .form-control,
    .usr-page select{
        border-radius:10px !important;
        min-height:38px;
        box-shadow:none !important;
    }

    .usr-page .btn{
        border-radius:10px;
        font-weight:700;
        min-height:38px;
    }

    @media (max-width: 767.98px){
        .usr-page .usr-toolbar{
            flex-direction:column;
            align-items:stretch;
        }
        .usr-page .usr-toolbar-right{
            width:100%;
        }
        .usr-page .usr-toolbar-right .btn{
            width:100%;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid mt-4 usr-page">

    <div class="usr-toolbar">
        <div>
            <h1 class="usr-title">Usuarios</h1>
            <p class="usr-subtitle">Administración de usuarios y roles del sistema.</p>
        </div>

        <div class="usr-toolbar-right">
            <a class="btn btn-primary" href="{{ route('users.create') }}">
                <i class="fas fa-plus mr-1"></i> Nuevo
            </a>
        </div>
    </div>

    @include('flash::message')

    <div class="usr-card mb-3">
        <div class="usr-card-header">
            <h3 class="usr-card-title">
                <i class="fas fa-filter"></i>
                Filtros
            </h3>
        </div>
        <div class="usr-card-body">
            <form method="GET" action="{{ route('users.index') }}">
                <div class="row align-items-end">
                    <div class="col-md-5 mb-3">
                        <label>Texto libre</label>
                        <input type="text" name="q" class="form-control"
                               value="{{ request('q') }}"
                               placeholder="Nombre o correo">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Rol</label>
                        <select name="role" class="form-control">
                            <option value="">Todos</option>
                            @foreach($roles as $role)
                                <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>
                                    {{ ucfirst($role) }}
                                </option>
                            @endforeach
                        </select>
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

    <div class="usr-card">
        <div class="usr-card-header">
            <h3 class="usr-card-title">
                <i class="fas fa-users"></i>
                Listado de usuarios
            </h3>
        </div>
        <div class="usr-card-body p-0">
            @include('users.table')
        </div>
    </div>

</div>
@endsection