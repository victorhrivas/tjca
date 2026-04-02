@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ups.</strong> Revisa los campos del formulario.
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="mb-0">Editar rol</h1>
            <small class="text-muted">Actualización de nombre y permisos.</small>
        </div>
        <a href="{{ route('roles.index') }}" class="btn btn-default">Volver</a>
    </div>

    <div class="card card-outline card-primary shadow-sm">
        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">
                @include('roles.fields')
            </div>

            <div class="card-footer text-right">
                <button class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>
@endsection