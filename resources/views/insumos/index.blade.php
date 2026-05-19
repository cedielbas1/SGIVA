@extends('layouts.dashboard')

@section('page_title', 'Gestión de Insumos')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-warning"><i class="bi bi-bag me-2"></i>Gestión de Insumos</h5>
                    <a href="{{ route('insumos.create') }}" class="btn btn-warning rounded-pill px-4">
                        <i class="bi bi-plus-lg me-1"></i> Nuevo Insumo
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
                            <caption class="visually-hidden">Lista de insumos</caption>
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Cultivo Asociado</th>
                                    <th scope="col">Fecha Ingreso</th>
                                    <th scope="col" class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($insumos as $insumo)
                                <tr>
                                    <td>{{ $insumo->id }}</td>
                                    <td>{{ $insumo->tipo }}</td>
                                    <td><strong>{{ $insumo->cantidad }}</strong></td>
                                    <td>
                                        @if($insumo->cultivo)
                                            <span class="badge bg-success">{{ $insumo->cultivo->nombre }}</span>
                                        @else
                                            <span class="badge bg-secondary">Sin cultivo</span>
                                        @endif
                                    </td>
                                    <td>{{ $insumo->fecha_ingreso->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('insumos.show', $insumo) }}" class="btn btn-sm btn-outline-info me-1" title="Ver detalles" aria-label="Ver detalles del insumo {{ $insumo->id }}">
                                            <i class="bi bi-eye" aria-hidden="true"></i>
                                        </a>
                                        <a href="{{ route('insumos.edit', $insumo) }}" class="btn btn-sm btn-outline-primary me-1" title="Editar" aria-label="Editar insumo {{ $insumo->id }}">
                                            <i class="bi bi-pencil" aria-hidden="true"></i>
                                        </a>
                                        <form action="{{ route('insumos.destroy', $insumo) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este insumo?')" title="Eliminar" aria-label="Eliminar insumo {{ $insumo->id }}">
                                                <i class="bi bi-trash" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="bi bi-bag display-4 mb-3"></i>
                                        <br>No hay insumos registrados aún.
                                        <br><a href="{{ route('insumos.create') }}" class="btn btn-warning btn-sm mt-2">Crear primer insumo</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    @if($insumos->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $insumos->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
