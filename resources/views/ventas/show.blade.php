@extends('layouts.dashboard')

@section('page_title', 'Detalles de la Venta')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-success">
                        <i class="bi bi-eye me-2"></i>Detalles de la Venta
                    </h5>
                    <div>
                        @can('update', $venta)
                            <a href="{{ route('ventas.edit', $venta) }}" class="btn btn-warning rounded-pill px-3 me-2">
                                <i class="bi bi-pencil me-1"></i>Editar
                            </a>
                        @endcan
                        <a href="{{ route('ventas.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
                            <i class="bi bi-arrow-left me-1"></i>Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <h6 class="text-muted mb-2">INFORMACIÓN DE LA VENTA</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">ID de Venta</label>
                                            <p class="form-control-plaintext">{{ $venta->id }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Fecha de Venta</label>
                                            <p class="form-control-plaintext">{{ $venta->fecha_venta->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Cultivo</label>
                                            <p class="form-control-plaintext"><span class="badge bg-success">{{ $venta->cultivo->nombre }}</span></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Lote</label>
                                            <p class="form-control-plaintext"><span class="badge bg-info">{{ $venta->lote->codigo }}</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-muted mb-2">DETALLES DE LA TRANSACCIÓN</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Cantidad Vendida</label>
                                            <p class="form-control-plaintext fw-bold">{{ $venta->cantidad_vendida }} unidades</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Precio Unitario</label>
                                            <p class="form-control-plaintext">${{ number_format($venta->precio_unitario, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Subtotal</label>
                                            <p class="form-control-plaintext">${{ number_format($venta->cantidad_vendida * $venta->precio_unitario, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <i class="bi bi-cash-coin display-4 mb-3"></i>
                                    <h6>TOTAL DE LA VENTA</h6>
                                    <h3 class="display-5 fw-bold">${{ number_format($venta->total, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h6 class="text-muted mb-3">INFORMACIÓN DE SISTEMA</h6>
                        <div class="bg-light p-3 rounded">
                            <small class="text-muted">
                                <strong>Creado:</strong> {{ $venta->created_at->format('d/m/Y H:i') }}<br>
                                <strong>Actualizado:</strong> {{ $venta->updated_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
