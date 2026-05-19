@extends('layouts.dashboard')

@section('page_title', 'Gestión de Lotes')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-grid-3x3 me-2"></i>Gestión de Lotes</h5>
                    <a href="{{ route('lotes.create') }}" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-plus-lg me-1"></i> Nuevo Lote
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
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Código</th>
                                    <th>Cultivo</th>
                                    <th>Cantidad Filas</th>
                                    <th>Estado</th>
                                    <th>Fecha Registro</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lotes as $lote)
                                <tr>
                                    <td>{{ $lote->id }}</td>
                                    <td><code class="fw-bold">{{ $lote->codigo }}</code></td>
                                    <td>
                                        <span class="badge bg-success">{{ $lote->cultivo->nombre ?? 'Sin cultivo' }}</span>
                                    </td>
                                    <td>{{ $lote->cantidad_filas }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $lote->estado }}</span>
                                    </td>
                                    <td>{{ $lote->created_at->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('lotes.show', $lote) }}" class="btn btn-sm btn-outline-info me-1" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('lotes.edit', $lote) }}" class="btn btn-sm btn-outline-primary me-1" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('lotes.destroy', $lote) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este lote?')" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        <i class="bi bi-grid-3x3 display-4 mb-3"></i>
                                        <br>No hay lotes registrados aún.
                                        <br><a href="{{ route('lotes.create') }}" class="btn btn-primary btn-sm mt-2">Crear primer lote</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection