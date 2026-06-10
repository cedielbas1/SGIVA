@php
    $flashTypes = [
        'success' => ['class' => 'success', 'icon' => 'check-circle-fill', 'title' => '¡Éxito!'],
        'error' => ['class' => 'danger', 'icon' => 'exclamation-triangle-fill', 'title' => 'Error'],
        'warning' => ['class' => 'warning', 'icon' => 'exclamation-diamond-fill', 'title' => 'Atención'],
        'info' => ['class' => 'info', 'icon' => 'info-circle-fill', 'title' => 'Información'],
        'status' => ['class' => 'success', 'icon' => 'check-circle-fill', 'title' => 'Estado'],
        'resent' => ['class' => 'success', 'icon' => 'check-circle-fill', 'title' => '¡Éxito!'],
    ];
@endphp

@foreach ($flashTypes as $key => $data)
    @if(session($key))
        <x-alert :type="$key" :title="$data['title']">
            @if ($key === 'resent')
                {{ __('A fresh verification link has been sent to your email address.') }}
            @else
                {{ session($key) }}
            @endif
        </x-alert>
    @endif
@endforeach

@if ($errors->any())
    <x-alert type="error" title="Se encontraron errores:">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-alert>
@endif
