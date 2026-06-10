@extends('layouts.dashboard')

@section('page_title', 'Nuevo Cultivo')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-success">
                        <i class="bi bi-plus-circle me-2"></i>Registrar Nuevo Cultivo
                    </h5>
                    <a href="{{ route('cultivos.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
                <div class="card-body">
                    @can('create', App\Models\Cultivo::class)
                        <form action="{{ route('cultivos.store') }}" method="POST" novalidate class="js-validate-form">
                            @csrf

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label fw-bold">Nombre del Cultivo <span class="text-danger">*</span></label>
                                    <input type="text"
                                           name="nombre"
                                           id="nombre"
                                           class="form-control form-control-lg @error('nombre') is-invalid @enderror js-validate"
                                           placeholder="Ej: Café, Aguacate, Cacao"
                                           value="{{ old('nombre') }}"
                                           required
                                           autofocus>
                                    <div class="invalid-feedback js-error" data-for="nombre">{{ $errors->first('nombre') }}</div>
                                    <div class="form-text">Ingresa el nombre del cultivo que deseas registrar.</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Estado</label>
                                    <input type="hidden" name="estado" value="0">
                                    <div class="form-check">
                                        <input class="form-check-input js-validate" type="checkbox" name="estado" id="estado" value="1" checked>
                                        <label class="form-check-label" for="estado">
                                            Activo
                                        </label>
                                    </div>
                                    <div class="invalid-feedback js-error" data-for="estado">{{ $errors->first('estado') }}</div>
                                    <div class="form-text">Los cultivos activos estarán disponibles para crear lotes.</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('cultivos.index') }}" class="btn btn-secondary rounded-pill px-4">
                                        <i class="bi bi-x-circle me-1"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-success rounded-pill px-4">
                                        <i class="bi bi-check-circle me-1"></i>Guardar Cultivo
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @else
                        <x-alert type="warning">
                            No tienes permiso para crear cultivos. <a href="{{ route('cultivos.index') }}" class="alert-link">Volver</a>
                        </x-alert>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection