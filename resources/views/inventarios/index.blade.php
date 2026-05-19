@extends('layouts.dashboard')

@section('page_title', 'Gestión de Inventarios')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-secondary"><i class="bi bi-box-seam me-2"></i>Gestión de Inventarios</h5>
                    <a href="{{ route('inventarios.create') }}" class="btn btn-secondary rounded-pill px-4">
                        <i class="bi bi-plus-lg me-1"></i> Nuevo Inventario
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
                            <caption class="visually-hidden">Lista de inventarios</caption>
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Lote (Código)</th>
                                    <th scope="col">Cultivo</th>
                                    <th scope="col">Fila</th>
                                    <th scope="col">Cantidad Inicial</th>
                                    <th scope="col">Cantidad Actual</th>
                                    <th scope="col" class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($inventarios as $inventario)
                                <tr>
                                    <td>{{ $inventario->id }}</td>
                                    <td><code>{{ $inventario->lote->codigo ?? 'N/A' }}</code></td>
                                    <td><span class="badge bg-success">{{ $inventario->lote->cultivo->nombre ?? 'N/A' }}</span></td>
                                    <td>{{ $inventario->fila }}</td>
                                    <td>{{ $inventario->cantidad_inicial }}</td>
                                    <td><strong>{{ $inventario->cantidad_actual }}</strong></td>
                                    <td class="text-center">
                                        <a href="{{ route('inventarios.show', $inventario) }}" class="btn btn-sm btn-outline-info me-1" title="Ver detalles" aria-label="Ver inventario {{ $inventario->id }}">
                                            <i class="bi bi-eye" aria-hidden="true"></i>
                                        </a>
                                        <a href="{{ route('inventarios.edit', $inventario) }}" class="btn btn-sm btn-outline-primary me-1" title="Editar" aria-label="Editar inventario {{ $inventario->id }}">
                                            <i class="bi bi-pencil" aria-hidden="true"></i>
                                        </a>
                                        <form action="{{ route('inventarios.destroy', $inventario) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este inventario?')" title="Eliminar" aria-label="Eliminar inventario {{ $inventario->id }}">
                                                <i class="bi bi-trash" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        <i class="bi bi-box-seam display-4 mb-3"></i>
                                        <br>No hay inventarios registrados aún.
                                        <br><a href="{{ route('inventarios.create') }}" class="btn btn-secondary btn-sm mt-2">Crear primer inventario</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    @if($inventarios->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $inventarios->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
