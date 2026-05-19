@extends('layouts.dashboard')

@section('page_title', 'Gestión de Cultivos')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-success"><i class="bi bi-sprout me-2"></i>Gestión de Cultivos</h5>
                    <button type="button" class="btn btn-success rounded-pill px-4" onclick="window.location.href='{{ route('cultivos.create') }}'">
                        <i class="bi bi-plus-lg me-1"></i> Nuevo Cultivo
                    </button>
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
                                    <th>Nombre del Cultivo</th>
                                    <th>Estado</th>
                                    <th>Fecha Registro</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cultivos as $cultivo)
                                <tr>
                                    <td>{{ $cultivo->id }}</td>
                                    <td class="fw-bold">{{ $cultivo->nombre }}</td>
                                    <td>
                                        <span class="badge rounded-pill {{ $cultivo->estado ? 'bg-success' : 'bg-danger' }}">
                                            {{ $cultivo->estado ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td>{{ $cultivo->created_at->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('cultivos.show', $cultivo) }}" class="btn btn-sm btn-outline-info me-1" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('cultivos.edit', $cultivo) }}" class="btn btn-sm btn-outline-primary me-1" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('cultivos.destroy', $cultivo) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este cultivo?')" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No hay cultivos registrados aún.</td>
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
