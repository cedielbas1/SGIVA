@extends('layouts.dashboard')

@section('page_title', 'Nuevo Insumo')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-warning">
                        <i class="bi bi-plus-circle me-2"></i>Registrar Nuevo Insumo
                    </h5>
                    <a href="{{ route('insumos.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
                <div class="card-body">
                    @can('create', App\Models\Insumo::class)
                        <form action="{{ route('insumos.store') }}" method="POST" novalidate class="js-validate-form">
                            @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tipo" class="form-label fw-bold">Tipo de Insumo <span class="text-danger">*</span></label>
                                        <select name="tipo" id="tipo" class="form-select form-select-lg @error('tipo') is-invalid @enderror js-validate" required
                                            aria-required="true"
                                            aria-invalid="@error('tipo') true @else false @enderror"
                                            @error('tipo') aria-describedby="tipo-error" @enderror
                                        >
                                        <option value="">Seleccionar tipo...</option>
                                        <option value="Semilla" {{ old('tipo') == 'Semilla' ? 'selected' : '' }}>Semilla</option>
                                        <option value="Fertilizante" {{ old('tipo') == 'Fertilizante' ? 'selected' : '' }}>Fertilizante</option>
                                        <option value="Pesticida" {{ old('tipo') == 'Pesticida' ? 'selected' : '' }}>Pesticida</option>
                                        <option value="Herbicida" {{ old('tipo') == 'Herbicida' ? 'selected' : '' }}>Herbicida</option>
                                        <option value="Fungicida" {{ old('tipo') == 'Fungicida' ? 'selected' : '' }}>Fungicida</option>
                                        <option value="Bolsa" {{ old('tipo') == 'Bolsa' ? 'selected' : '' }}>Bolsa</option>
                                        <option value="Otro" {{ old('tipo') == 'Otro' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                    <div id="tipo-error" class="invalid-feedback js-error" data-for="tipo" role="alert">{{ $errors->first('tipo') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cantidad" class="form-label fw-bold">Cantidad <span class="text-danger">*</span></label>
                                     <input type="number"
                                         name="cantidad"
                                         id="cantidad"
                                         class="form-control form-control-lg @error('cantidad') is-invalid @enderror js-validate"
                                         placeholder="Ej: 50"
                                         value="{{ old('cantidad') }}"
                                         min="1"
                                         required
                                         aria-required="true"
                                         aria-invalid="@error('cantidad') true @else false @enderror"
                                         @error('cantidad') aria-describedby="cantidad-error" @enderror
                                     autofocus>
                                     <div id="cantidad-error" class="invalid-feedback js-error" data-for="cantidad" role="alert">{{ $errors->first('cantidad') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cultivo_id" class="form-label fw-bold">Cultivo Asociado</label>
                                        <select name="cultivo_id" id="cultivo_id" class="form-select form-select-lg @error('cultivo_id') is-invalid @enderror js-validate"
                                            aria-invalid="@error('cultivo_id') true @else false @enderror"
                                            @error('cultivo_id') aria-describedby="cultivo_id-error" @enderror
                                        >
                                        <option value="">Sin cultivo específico</option>
                                        @foreach($cultivos as $cultivo)
                                            <option value="{{ $cultivo->id }}" {{ old('cultivo_id') == $cultivo->id ? 'selected' : '' }}>
                                                {{ $cultivo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="cultivo_id-error" class="invalid-feedback js-error" data-for="cultivo_id" role="alert">{{ $errors->first('cultivo_id') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fecha_ingreso" class="form-label fw-bold">Fecha de Ingreso <span class="text-danger">*</span></label>
                                     <input type="date"
                                         name="fecha_ingreso"
                                         id="fecha_ingreso"
                                         class="form-control form-control-lg @error('fecha_ingreso') is-invalid @enderror js-validate"
                                         value="{{ old('fecha_ingreso') }}"
                                         required
                                         aria-required="true"
                                         aria-invalid="@error('fecha_ingreso') true @else false @enderror"
                                         @error('fecha_ingreso') aria-describedby="fecha_ingreso-error" @enderror
                                     >
                                     <div id="fecha_ingreso-error" class="invalid-feedback js-error" data-for="fecha_ingreso" role="alert">{{ $errors->first('fecha_ingreso') }}</div>
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
                                              placeholder="Notas adicionales..."
                                              rows="2"
                                              aria-invalid="@error('observaciones') true @else false @enderror"
                                              @error('observaciones') aria-describedby="observaciones-error" @enderror
                                    >{{ old('observaciones') }}</textarea>
                                    <div id="observaciones-error" class="invalid-feedback js-error" data-for="observaciones" role="alert">{{ $errors->first('observaciones') }}</div>
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
                                        <i class="bi bi-check-circle me-1"></i>Guardar Insumo
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @else
                        <x-alert type="warning">
                            No tienes permiso para crear insumos. <a href="{{ route('insumos.index') }}" class="alert-link">Volver</a>
                        </x-alert>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
