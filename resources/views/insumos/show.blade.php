@extends('layouts.dashboard')

@section('page_title', 'Detalles del Insumo')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-info">
                        <i class="bi bi-eye me-2"></i>Detalles del Insumo
                    </h5>
                    <div>
                        @can('update', $insumo)
                            <a href="{{ route('insumos.edit', $insumo) }}" class="btn btn-warning rounded-pill px-3 me-2">
                                <i class="bi bi-pencil me-1"></i>Editar
                            </a>
                        @endcan
                        <a href="{{ route('insumos.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
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
                                            <p class="form-control-plaintext">{{ $insumo->id }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Tipo</label>
                                            <p class="form-control-plaintext">{{ $insumo->tipo }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Cantidad</label>
                                            <p class="form-control-plaintext fw-bold">{{ $insumo->cantidad }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Cultivo Asociado</label>
                                            <p class="form-control-plaintext">
                                                @if($insumo->cultivo)
                                                    <span class="badge bg-success">{{ $insumo->cultivo->nombre }}</span>
                                                @else
                                                    <span class="badge bg-secondary">Sin cultivo</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Fecha de Ingreso</label>
                                            <p class="form-control-plaintext">{{ $insumo->fecha_ingreso->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                                @if($insumo->observaciones)
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Observaciones</label>
                                            <p class="form-control-plaintext">{{ $insumo->observaciones }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="bi bi-bag display-4 text-warning mb-3"></i>
                                    <h5>Información</h5>
                                    <p class="mb-1"><strong>{{ $insumo->cantidad }}</strong> unidades</p>
                                    <small class="text-muted">En existencia</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h6 class="text-muted mb-3">INFORMACIÓN DE SISTEMA</h6>
                        <div class="bg-light p-3 rounded">
                            <small class="text-muted">
                                <strong>Creado:</strong> {{ $insumo->created_at->format('d/m/Y H:i') }}<br>
                                <strong>Actualizado:</strong> {{ $insumo->updated_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
