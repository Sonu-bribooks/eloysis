@props([
    'variant' => 'primary',
    'pill' => false,
])

<span

    {{ $attributes->merge([

        'class' => 'badge bg-'.$variant.($pill ? ' rounded-pill' : '')

    ]) }}

>

    {{ $slot }}

</span>