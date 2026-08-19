@props([
    'route',
    'icon',
    'label',
    'active' => null,
])

@php
    $activeRoute = $active ?? $route;
    $isActive = $active && request()->routeIs($activeRoute);
@endphp

<li>
    <a href="{{ $route === '#' ? '#' : route($route) }}"
       class="{{ $isActive ? 'active' : '' }}">

        <i class="{{ $icon }} me-2"></i>

        <span>{{ $label }}</span>

    </a>
</li>