@props([
    'label',
    'name',
    'value' => 1,
    'checked' => false,
])

@php

$field = str_replace(['[', ']'], ['.', ''], $name);
$field = rtrim($field, '.');

$isChecked = old($field, $checked);

@endphp

<div class="form-check mb-3">

    <input

        type="checkbox"

        id="{{ $name }}"

        name="{{ $name }}"

        value="{{ $value }}"

        @checked($isChecked)

        {{ $attributes->merge([
            'class'=>'form-check-input'
        ]) }}

    >

    <label

        for="{{ $name }}"

        class="form-check-label">

        {{ $label }}

    </label>

</div>