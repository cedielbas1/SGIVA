@extends('layouts.dashboard')

@section('page_title', 'Editar Inventario')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-warning">
                        <i class="bi bi-pencil-square me-2"></i>Editar Inventario
                    </h5>
                    <a href="{{ route('inventarios.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
                <div class="card-body">
                    @can('update', $inventario)
                        <form action="{{ route('inventarios.update', $inventario) }}" method="POST" novalidate class="js-validate-form">
                            @csrf
                            @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lote_id" class="form-label fw-bold">Lote <span class="text-danger">*</span></label>
                                    <select name="lote_id" id="lote_id" class="form-select form-select-lg @error('lote_id') is-invalid @enderror js-validate" required>
                                        <option value="">Seleccionar lote...</option>
                                        @foreach($lotes as $lote)
                                            <option value="{{ $lote->id }}" {{ old('lote_id', $inventario->lote_id) == $lote->id ? 'selected' : '' }}>
                                                {{ $lote->codigo }} - {{ $lote->cultivo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback js-error" data-for="lote_id">{{ $errors->first('lote_id') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fila" class="form-label fw-bold">Número de Fila <span class="text-danger">*</span></label>
                                     <input type="number"
                                         name="fila"
                                         id="fila"
                                         class="form-control form-control-lg @error('fila') is-invalid @enderror js-validate"
                                         value="{{ old('fila', $inventario->fila) }}"
                                         min="1"
                                         required autofocus>
                                     <div class="invalid-feedback js-error" data-for="fila">{{ $errors->first('fila') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cantidad_inicial" class="form-label fw-bold">Cantidad Inicial <span class="text-danger">*</span></label>
                                     <input type="number"
                                         name="cantidad_inicial"
                                         id="cantidad_inicial"
                                         class="form-control form-control-lg @error('cantidad_inicial') is-invalid @enderror js-validate"
                                         value="{{ old('cantidad_inicial', $inventario->cantidad_inicial) }}"
                                         min="0"
                                         required>
                                     <div class="invalid-feedback js-error" data-for="cantidad_inicial">{{ $errors->first('cantidad_inicial') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cantidad_actual" class="form-label fw-bold">Cantidad Actual <span class="text-danger">*</span></label>
                                     <input type="number"
                                         name="cantidad_actual"
                                         id="cantidad_actual"
                                         class="form-control form-control-lg @error('cantidad_actual') is-invalid @enderror js-validate"
                                         value="{{ old('cantidad_actual', $inventario->cantidad_actual) }}"
                                         min="0"
                                         required>
                                     <div class="invalid-feedback js-error" data-for="cantidad_actual">{{ $errors->first('cantidad_actual') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="bg-light p-3 rounded">
                                    <small class="text-muted">
                                        <strong>Creado:</strong> {{ $inventario->created_at->format('d/m/Y H:i') }}<br>
                                        <strong>Actualizado:</strong> {{ $inventario->updated_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('inventarios.index') }}" class="btn btn-secondary rounded-pill px-4">
                                        <i class="bi bi-x-circle me-1"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-warning rounded-pill px-4">
                                        <i class="bi bi-check-circle me-1"></i>Actualizar Inventario
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @else
                        <x-alert type="warning">
                            No tienes permiso para editar este inventario. <a href="{{ route('inventarios.index') }}" class="alert-link">Volver</a>
                        </x-alert>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
