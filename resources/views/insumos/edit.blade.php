@extends('layouts.dashboard')

@section('page_title', 'Editar Insumo')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-warning">
                        <i class="bi bi-pencil-square me-2"></i>Editar Insumo
                    </h5>
                    <a href="{{ route('insumos.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
                <div class="card-body">
                    @can('update', $insumo)
                        <form action="{{ route('insumos.update', $insumo) }}" method="POST" novalidate class="js-validate-form">
                            @csrf
                            @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tipo" class="form-label fw-bold">Tipo de Insumo <span class="text-danger">*</span></label>
                                    <select name="tipo" id="tipo" class="form-select form-select-lg @error('tipo') is-invalid @enderror js-validate" required>
                                        <option value="Semilla" {{ old('tipo', $insumo->tipo) == 'Semilla' ? 'selected' : '' }}>Semilla</option>
                                        <option value="Fertilizante" {{ old('tipo', $insumo->tipo) == 'Fertilizante' ? 'selected' : '' }}>Fertilizante</option>
                                        <option value="Pesticida" {{ old('tipo', $insumo->tipo) == 'Pesticida' ? 'selected' : '' }}>Pesticida</option>
                                        <option value="Herbicida" {{ old('tipo', $insumo->tipo) == 'Herbicida' ? 'selected' : '' }}>Herbicida</option>
                                        <option value="Fungicida" {{ old('tipo', $insumo->tipo) == 'Fungicida' ? 'selected' : '' }}>Fungicida</option>
                                        <option value="Bolsa" {{ old('tipo', $insumo->tipo) == 'Bolsa' ? 'selected' : '' }}>Bolsa</option>
                                        <option value="Otro" {{ old('tipo', $insumo->tipo) == 'Otro' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                    <div class="invalid-feedback js-error" data-for="tipo">{{ $errors->first('tipo') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cantidad" class="form-label fw-bold">Cantidad <span class="text-danger">*</span></label>
                                     <input type="number"
                                         name="cantidad"
                                         id="cantidad"
                                         class="form-control form-control-lg @error('cantidad') is-invalid @enderror js-validate"
                                         value="{{ old('cantidad', $insumo->cantidad) }}"
                                         min="1"
                                         required autofocus>
                                     <div class="invalid-feedback js-error" data-for="cantidad">{{ $errors->first('cantidad') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cultivo_id" class="form-label fw-bold">Cultivo Asociado</label>
                                    <select name="cultivo_id" id="cultivo_id" class="form-select form-select-lg @error('cultivo_id') is-invalid @enderror js-validate">
                                        <option value="">Sin cultivo específico</option>
                                        @foreach($cultivos as $cultivo)
                                            <option value="{{ $cultivo->id }}" {{ old('cultivo_id', $insumo->cultivo_id) == $cultivo->id ? 'selected' : '' }}>
                                                {{ $cultivo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback js-error" data-for="cultivo_id">{{ $errors->first('cultivo_id') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fecha_ingreso" class="form-label fw-bold">Fecha de Ingreso <span class="text-danger">*</span></label>
                                     <input type="date"
                                         name="fecha_ingreso"
                                         id="fecha_ingreso"
                                         class="form-control form-control-lg @error('fecha_ingreso') is-invalid @enderror js-validate"
                                         value="{{ old('fecha_ingreso', $insumo->fecha_ingreso->format('Y-m-d')) }}"
                                         required>
                                     <div class="invalid-feedback js-error" data-for="fecha_ingreso">{{ $errors->first('fecha_ingreso') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="observaciones" class="form-label fw-bold">Observaciones</label>
                                    <textarea name="observaciones"
                                              id="observaciones"
                                              class="form-control form-control-lg @error('observaciones') is-invalid @enderror js-validate"
                                              rows="2">{{ old('observaciones', $insumo->observaciones) }}</textarea>
                                    <div class="invalid-feedback js-error" data-for="observaciones">{{ $errors->first('observaciones') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="bg-light p-3 rounded">
                                    <small class="text-muted">
                                        <strong>Creado:</strong> {{ $insumo->created_at->format('d/m/Y H:i') }}<br>
                                        <strong>Actualizado:</strong> {{ $insumo->updated_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('insumos.index') }}" class="btn btn-secondary rounded-pill px-4">
                                        <i class="bi bi-x-circle me-1"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-warning rounded-pill px-4">
                                        <i class="bi bi-check-circle me-1"></i>Actualizar Insumo
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @else
                        <x-alert type="warning">
                            No tienes permiso para editar este insumo. <a href="{{ route('insumos.index') }}" class="alert-link">Volver</a>
                        </x-alert>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
