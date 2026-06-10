@props([
    'type' => 'info',
    'title' => null,
    'icon' => null,
    'dismissible' => true,
    'role' => 'alert',
])

@php
    $alertTypes = [
        'success' => ['class' => 'success', 'icon' => 'check-circle-fill', 'title' => '¡Éxito!'],
        'error' => ['class' => 'danger', 'icon' => 'exclamation-triangle-fill', 'title' => 'Error'],
        'danger' => ['class' => 'danger', 'icon' => 'exclamation-triangle-fill', 'title' => 'Error'],
        'warning' => ['class' => 'warning', 'icon' => 'exclamation-diamond-fill', 'title' => 'Atención'],
        'info' => ['class' => 'info', 'icon' => 'info-circle-fill', 'title' => 'Información'],
        'status' => ['class' => 'success', 'icon' => 'check-circle-fill', 'title' => 'Estado'],
    ];

    $config = $alertTypes[$type] ?? $alertTypes['info'];
    $icon = $icon ?? $config['icon'];
    $title = $title ?? $config['title'];
@endphp

<div {{ $attributes->merge(['class' => "flash-alert alert alert-{$config['class']}" . ($dismissible ? ' alert-dismissible fade show d-flex align-items-start' : ' d-flex align-items-start'), 'role' => $role]) }}>
    <i class="bi bi-{{ $icon }} fs-4 me-3"></i>
    <div>
        @if ($title)
            <strong class="d-block mb-1">{{ $title }}</strong>
        @endif

        {{ $slot }}
    </div>

    @if ($dismissible)
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>
