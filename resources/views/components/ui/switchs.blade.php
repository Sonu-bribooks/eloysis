@props([
    'label' => null,
    'name',
    'id' => null,
    'value' => 1,
    'checked' => false,
    'disabled' => false,
])

@php

$id = $id ?? $name;

$field = str_replace(['[', ']'], ['.', ''], $name);
$field = rtrim($field, '.');

$isChecked = old($field, $checked);

@endphp

<div class="form-check form-switch mb-3">

    <input

        type="checkbox"

        class="form-check-input"

        id="{{ $id }}"

        name="{{ $name }}"

        value="{{ $value }}"

        @checked($isChecked)

        @disabled($disabled)

        {{ $attributes }}

    >

    @if($label)

        <label
            class="form-check-label"
            for="{{ $id }}">

            {{ $label }}

        </label>

    @endif

</div>