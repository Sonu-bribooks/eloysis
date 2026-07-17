@props([
    'status' => 1,
])

@php

$config = [

    1 => [

        'text' => 'Active',

        'class' => 'success',

        'icon' => 'bi-check-circle-fill',

    ],

    0 => [

        'text' => 'Inactive',

        'class' => 'danger',

        'icon' => 'bi-x-circle-fill',

    ],

];

$item = $config[$status] ?? [

    'text' => 'Unknown',

    'class' => 'secondary',

    'icon' => 'bi-question-circle-fill',

];

@endphp

<span class="badge bg-{{ $item['class'] }}">

    <i class="bi {{ $item['icon'] }} me-1"></i>

    {{ $item['text'] }}

</span>