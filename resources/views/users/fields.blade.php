<div class="row">
    <div class="col-md-6 mb-3">
        <label>Nombre</label>
        <input type="text" name="name" class="form-control"
               value="{{ old('name', $user->name ?? '') }}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label>Correo</label>
        <input type="email" name="email" class="form-control"
               value="{{ old('email', $user->email ?? '') }}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label>Contraseña {{ isset($user) ? '(opcional)' : '' }}</label>
        <input type="password" name="password" class="form-control" {{ isset($user) ? '' : 'required' }}>
    </div>

    <div class="col-md-6 mb-3">
        <label>Confirmar contraseña</label>
        <input type="password" name="password_confirmation" class="form-control" {{ isset($user) ? '' : 'required' }}>
    </div>

    <div class="col-md-6 mb-3">
        <label>Rol</label>
        <select name="role" class="form-control" required>
            <option value="">Seleccione...</option>
            @foreach($roles as $role)
                <option value="{{ $role }}"
                    {{ old('role', isset($user) ? $user->roles->pluck('name')->first() : '') == $role ? 'selected' : '' }}>
                    {{ ucfirst($role) }}
                </option>
            @endforeach
        </select>
    </div>
</div>