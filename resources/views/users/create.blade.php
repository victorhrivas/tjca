@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    @include('adminlte-templates::common.errors')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="mb-0">Nuevo usuario</h1>
            <small class="text-muted">Creación de usuarios y asignación de rol.</small>
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-default">Volver</a>
    </div>

    <div class="card card-outline card-primary shadow-sm">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="card-body">
                @include('users.fields')
            </div>

            <div class="card-footer text-right">
                <button class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection