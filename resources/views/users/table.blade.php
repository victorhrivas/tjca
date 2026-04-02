<div class="table-responsive">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Creado</th>
                <th width="160">Acciones</th>
            </tr>
        </thead>
        <tbody>
        @forelse($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @php
                        $role = $user->roles->pluck('name')->first();
                    @endphp

                    @if($role)
                        <span class="badge badge-info">{{ ucfirst($role) }}</span>
                    @else
                        <span class="badge badge-secondary">Sin rol</span>
                    @endif
                </td>
                <td>{{ optional($user->created_at)->format('d-m-Y H:i') }}</td>
                <td>
                    <div class="d-flex" style="gap:.4rem;">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-pen"></i>
                        </a>

                        @if(auth()->id() !== $user->id)
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este usuario?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-muted py-4">
                    No hay usuarios registrados.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

@if($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="p-3">
        {{ $users->links() }}
    </div>
@endif