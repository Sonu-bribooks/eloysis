@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => null,
    'icon' => null,
    'outline' => false,
    'loading' => false,
    'block' => false,
    'href' => null,
])

@php

$classes = [
    'btn',
    $outline ? 'btn-outline-'.$variant : 'btn-'.$variant,
];

if($size){
    $classes[] = 'btn-'.$size;
}

if($block){
    $classes[] = 'w-100';
}

@endphp

@if($href)

<a
    href="{{ $href }}"
    {{ $attributes->merge([
        'class' => implode(' ', $classes)
    ]) }}
>

    @if($icon)
        <i class="bi {{ $icon }} me-2"></i>
    @endif

    {{ $slot }}

</a>

@else

<button

    type="{{ $type }}"

    {{ $attributes->merge([
        'class' => implode(' ', $classes)
    ]) }}

    @disabled($loading)

>

    @if($loading)

        <span
            class="spinner-border spinner-border-sm me-2">
        </span>

    @endif

    @if($icon)

        <i class="bi {{ $icon }} me-2"></i>

    @endif

    {{ $slot }}

</button>

@endif