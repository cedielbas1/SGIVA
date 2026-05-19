@extends('layouts.dashboard')

@section('page_title', 'Gestión de Actividades')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-info"><i class="bi bi-clipboard-check me-2"></i>Gestión de Actividades</h5>
                    <a href="{{ route('actividades.create') }}" class="btn btn-info rounded-pill px-4">
                        <i class="bi bi-plus-lg me-1"></i> Nueva Actividad
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <caption class="visually-hidden">Lista de actividades</caption>
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Tipo de Actividad</th>
                                    <th scope="col">Lote</th>
                                    <th scope="col">Usuario</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col" class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($actividades as $actividad)
                                <tr>
                                    <td>{{ $actividad->id }}</td>
                                    <td><span class="badge bg-info">{{ $actividad->tipo_actividad }}</span></td>
                                    <td><code>{{ $actividad->lote->codigo ?? 'N/A' }}</code></td>
                                    <td>{{ $actividad->usuario->name ?? 'N/A' }}</td>
                                    <td>{{ $actividad->fecha->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('actividades.show', $actividad) }}" class="btn btn-sm btn-outline-info me-1" title="Ver detalles" aria-label="Ver actividad {{ $actividad->id }}">
                                            <i class="bi bi-eye" aria-hidden="true"></i>
                                        </a>
                                        <a href="{{ route('actividades.edit', $actividad) }}" class="btn btn-sm btn-outline-primary me-1" title="Editar" aria-label="Editar actividad {{ $actividad->id }}">
                                            <i class="bi bi-pencil" aria-hidden="true"></i>
                                        </a>
                                        <form action="{{ route('actividades.destroy', $actividad) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar esta actividad?')" title="Eliminar" aria-label="Eliminar actividad {{ $actividad->id }}">
                                                <i class="bi bi-trash" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="bi bi-clipboard-check display-4 mb-3"></i>
                                        <br>No hay actividades registradas aún.
                                        <br><a href="{{ route('actividades.create') }}" class="btn btn-info btn-sm mt-2">Crear primera actividad</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    @if($actividades->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $actividades->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
