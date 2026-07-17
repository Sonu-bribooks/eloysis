@props([
    'label' => null,
    'name',
    'id' => null,
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'readonly' => false,
    'disabled' => false,
    'icon' => null,
    'help' => null,
])

@php

$id = $id ?? $name;

$fieldValue = old($name, $value);

@endphp

<div class="mb-3">

    @if($label)

        <label
            for="{{ $id }}"
            class="form-label">

            {{ $label }}

            @if($required)

                <span class="text-danger">*</span>

            @endif

        </label>

    @endif

    @if($icon)

        <div class="input-group">

            <span class="input-group-text">

                <i class="bi {{ $icon }}"></i>

            </span>

    @endif

    <input

        id="{{ $id }}"

        name="{{ $name }}"

        type="{{ $type }}"

        value="{{ $fieldValue }}"

        placeholder="{{ $placeholder }}"

        @required($required)

        @readonly($readonly)

        @disabled($disabled)

        {{ $attributes->merge([
            'class' => 'form-control'.($errors->has($name) ? ' is-invalid' : '')
        ]) }}

    >

    @if($icon)

        </div>

    @endif

    @error($name)

        <div class="invalid-feedback d-block">

            {{ $message }}

        </div>

    @enderror

    @if($help)

        <small class="text-muted">

            {{ $help }}

        </small>

    @endif

</div>