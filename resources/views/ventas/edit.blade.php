@extends('layouts.dashboard')

@section('page_title', 'Editar Venta')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-warning">
                        <i class="bi bi-pencil-square me-2"></i>Editar Venta
                    </h5>
                    <a href="{{ route('ventas.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
                <div class="card-body">
                    @can('update', $venta)
                        <form action="{{ route('ventas.update', $venta) }}" method="POST" novalidate class="js-validate-form">
                            @csrf
                            @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cultivo_id" class="form-label fw-bold">Cultivo <span class="text-danger">*</span></label>
                                        <select name="cultivo_id" id="cultivo_id" class="form-select form-select-lg @error('cultivo_id') is-invalid @enderror js-validate" required
                                            aria-required="true"
                                            aria-invalid="@error('cultivo_id') true @else false @enderror"
                                            @error('cultivo_id') aria-describedby="cultivo_id-error" @enderror
                                        >
                                        <option value="">Seleccionar cultivo...</option>
                                        @foreach($cultivos as $cultivo)
                                            <option value="{{ $cultivo->id }}" {{ old('cultivo_id', $venta->cultivo_id) == $cultivo->id ? 'selected' : '' }}>
                                                {{ $cultivo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="cultivo_id-error" class="invalid-feedback js-error" data-for="cultivo_id" role="alert">{{ $errors->first('cultivo_id') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lote_id" class="form-label fw-bold">Lote <span class="text-danger">*</span></label>
                                        <select name="lote_id" id="lote_id" class="form-select form-select-lg @error('lote_id') is-invalid @enderror js-validate" required
                                            aria-required="true"
                                            aria-invalid="@error('lote_id') true @else false @enderror"
                                            @error('lote_id') aria-describedby="lote_id-error" @enderror
                                        >
                                        <option value="">Seleccionar lote...</option>
                                        @foreach($lotes as $lote)
                                            <option value="{{ $lote->id }}" {{ old('lote_id', $venta->lote_id) == $lote->id ? 'selected' : '' }}>
                                                {{ $lote->codigo }} - {{ $lote->cultivo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="lote_id-error" class="invalid-feedback js-error" data-for="lote_id" role="alert">{{ $errors->first('lote_id') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="cantidad_vendida" class="form-label fw-bold">Cantidad Vendida <span class="text-danger">*</span></label>
                                     <input type="number"
                                         name="cantidad_vendida"
                                         id="cantidad_vendida"
                                         class="form-control form-control-lg @error('cantidad_vendida') is-invalid @enderror js-validate"
                                         value="{{ old('cantidad_vendida', $venta->cantidad_vendida) }}"
                                         min="1"
                                         required
                                         aria-required="true"
                                         aria-invalid="@error('cantidad_vendida') true @else false @enderror"
                                         @error('cantidad_vendida') aria-describedby="cantidad_vendida-error" @enderror
                                     >
                                     <div id="cantidad_vendida-error" class="invalid-feedback js-error" data-for="cantidad_vendida" role="alert">{{ $errors->first('cantidad_vendida') }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="precio_unitario" class="form-label fw-bold">Precio Unitario <span class="text-danger">*</span></label>
                                     <input type="number"
                                         name="precio_unitario"
                                         id="precio_unitario"
                                         class="form-control form-control-lg @error('precio_unitario') is-invalid @enderror js-validate"
                                         value="{{ old('precio_unitario', $venta->precio_unitario) }}"
                                         step="0.01"
                                         min="0"
                                         required
                                         aria-required="true"
                                         aria-invalid="@error('precio_unitario') true @else false @enderror"
                                         @error('precio_unitario') aria-describedby="precio_unitario-error" @enderror
                                     >
                                     <div id="precio_unitario-error" class="invalid-feedback js-error" data-for="precio_unitario" role="alert">{{ $errors->first('precio_unitario') }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="total" class="form-label fw-bold">Total (calculado)</label>
                                    <input type="number"
                                           name="total"
                                           id="total"
                                           class="form-control form-control-lg bg-light"
                                           value="{{ old('total', $venta->total) }}"
                                           step="0.01"
                                           readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fecha_venta" class="form-label fw-bold">Fecha de Venta <span class="text-danger">*</span></label>
                                     <input type="date"
                                         name="fecha_venta"
                                         id="fecha_venta"
                                         class="form-control form-control-lg @error('fecha_venta') is-invalid @enderror js-validate"
                                         value="{{ old('fecha_venta', $venta->fecha_venta->format('Y-m-d')) }}"
                                         required
                                         aria-required="true"
                                         aria-invalid="@error('fecha_venta') true @else false @enderror"
                                         @error('fecha_venta') aria-describedby="fecha_venta-error" @enderror
                                     >
                                     <div id="fecha_venta-error" class="invalid-feedback js-error" data-for="fecha_venta" role="alert">{{ $errors->first('fecha_venta') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="bg-light p-3 rounded">
                                    <small class="text-muted">
                                        <strong>Creado:</strong> {{ $venta->created_at->format('d/m/Y H:i') }}<br>
                                        <strong>Actualizado:</strong> {{ $venta->updated_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('ventas.index') }}" class="btn btn-secondary rounded-pill px-4">
                                        <i class="bi bi-x-circle me-1"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-warning rounded-pill px-4">
                                        <i class="bi bi-check-circle me-1"></i>Actualizar Venta
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @else
                        <x-alert type="warning">
                            No tienes permiso para editar esta venta. <a href="{{ route('ventas.index') }}" class="alert-link">Volver</a>
                        </x-alert>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto-calculate total when quantity or price changes
    document.getElementById('cantidad_vendida').addEventListener('change', function() {
        calculateTotal();
    });
    document.getElementById('precio_unitario').addEventListener('input', function() {
        calculateTotal();
    });

    function calculateTotal() {
        const cantidad = parseFloat(document.getElementById('cantidad_vendida').value) || 0;
        const precio = parseFloat(document.getElementById('precio_unitario').value) || 0;
        const total = (cantidad * precio).toFixed(2);
        document.getElementById('total').value = total;
    }
</script>
@endsection
