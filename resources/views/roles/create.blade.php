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
            <h1 class="mb-0">Nuevo rol</h1>
            <small class="text-muted">Creación de rol y asignación de permisos.</small>
        </div>
        <a href="{{ route('roles.index') }}" class="btn btn-default">Volver</a>
    </div>

    <div class="card card-outline card-primary shadow-sm">
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf

            <div class="card-body">
                @include('roles.fields')
            </div>

            <div class="card-footer text-right">
                <button class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection