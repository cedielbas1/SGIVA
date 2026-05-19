@extends('layouts.dashboard')

@section('page_title', 'Nuevo Inventario')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-secondary">
                        <i class="bi bi-plus-circle me-2"></i>Registrar Nuevo Inventario
                    </h5>
                    <a href="{{ route('inventarios.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('inventarios.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lote_id" class="form-label fw-bold">Lote <span class="text-danger">*</span></label>
                                    <select name="lote_id" id="lote_id" class="form-select form-select-lg @error('lote_id') is-invalid @enderror" required>
                                        <option value="">Seleccionar lote...</option>
                                        @foreach($lotes as $lote)
                                            <option value="{{ $lote->id }}" {{ old('lote_id') == $lote->id ? 'selected' : '' }}>
                                                {{ $lote->codigo }} - {{ $lote->cultivo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('lote_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fila" class="form-label fw-bold">Número de Fila <span class="text-danger">*</span></label>
                                    <input type="number"
                                           name="fila"
                                           id="fila"
                                           class="form-control form-control-lg @error('fila') is-invalid @enderror"
                                           placeholder="Ej: 1, 2, 3"
                                           value="{{ old('fila') }}"
                                           min="1"
                                           required>
                                    @error('fila')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                           class="form-control form-control-lg @error('cantidad_inicial') is-invalid @enderror"
                                           placeholder="Ej: 100"
                                           value="{{ old('cantidad_inicial') }}"
                                           min="0"
                                           required>
                                    @error('cantidad_inicial')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cantidad_actual" class="form-label fw-bold">Cantidad Actual <span class="text-danger">*</span></label>
                                    <input type="number"
                                           name="cantidad_actual"
                                           id="cantidad_actual"
                                           class="form-control form-control-lg @error('cantidad_actual') is-invalid @enderror"
                                           placeholder="Ej: 85"
                                           value="{{ old('cantidad_actual') }}"
                                           min="0"
                                           required>
                                    @error('cantidad_actual')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('inventarios.index') }}" class="btn btn-secondary rounded-pill px-4">
                                        <i class="bi bi-x-circle me-1"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-secondary rounded-pill px-4">
                                        <i class="bi bi-check-circle me-1"></i>Guardar Inventario
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
