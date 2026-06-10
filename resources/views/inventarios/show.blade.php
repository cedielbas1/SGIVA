@extends('layouts.dashboard')

@section('page_title', 'Detalles del Inventario')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-info">
                        <i class="bi bi-eye me-2"></i>Detalles del Inventario
                    </h5>
                    <div>
                        @can('update', $inventario)
                            <a href="{{ route('inventarios.edit', $inventario) }}" class="btn btn-warning rounded-pill px-3 me-2">
                                <i class="bi bi-pencil me-1"></i>Editar
                            </a>
                        @endcan
                        <a href="{{ route('inventarios.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
                            <i class="bi bi-arrow-left me-1"></i>Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <h6 class="text-muted mb-2">INFORMACIÓN GENERAL</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">ID</label>
                                            <p class="form-control-plaintext">{{ $inventario->id }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Lote</label>
                                            <p class="form-control-plaintext"><code>{{ $inventario->lote->codigo }}</code></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Cultivo</label>
                                            <p class="form-control-plaintext"><span class="badge bg-success">{{ $inventario->lote->cultivo->nombre }}</span></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Fila</label>
                                            <p class="form-control-plaintext fw-bold">{{ $inventario->fila }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Cantidad Inicial</label>
                                            <p class="form-control-plaintext">{{ $inventario->cantidad_inicial }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Cantidad Actual</label>
                                            <p class="form-control-plaintext fw-bold text-success">{{ $inventario->cantidad_actual }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="bi bi-box-seam display-4 text-secondary mb-3"></i>
                                    <h5>Estadísticas</h5>
                                    <p class="mb-1"><strong>Consumo:</strong> {{ $inventario->cantidad_inicial - $inventario->cantidad_actual }}</p>
                                    <small class="text-muted">Diferencia entre inicial y actual</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h6 class="text-muted mb-3">INFORMACIÓN DE SISTEMA</h6>
                        <div class="bg-light p-3 rounded">
                            <small class="text-muted">
                                <strong>Creado:</strong> {{ $inventario->created_at->format('d/m/Y H:i') }}<br>
                                <strong>Actualizado:</strong> {{ $inventario->updated_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
