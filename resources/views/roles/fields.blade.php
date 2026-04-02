<div class="row">
    <div class="col-md-6 mb-3">
        <label>Nombre del rol</label>
        <input type="text"
               name="name"
               class="form-control"
               value="{{ old('name', $role->name ?? '') }}"
               required>
    </div>
</div>

<div class="mt-3">
    <label class="d-block mb-2">Permisos</label>

    <div class="row">
        @foreach($permissions as $permission)
            <div class="col-md-4 col-lg-3 mb-2">
                <div class="border rounded p-2 h-100">
                    <label class="mb-0 d-flex align-items-start" style="gap:.5rem; cursor:pointer;">
                        <input type="checkbox"
                               name="permissions[]"
                               value="{{ $permission->name }}"
                               {{ in_array($permission->name, old('permissions', isset($role) ? $role->permissions->pluck('name')->toArray() : [])) ? 'checked' : '' }}>
                        <span>{{ $permission->name }}</span>
                    </label>
                </div>
            </div>
        @endforeach
    </div>
</div>