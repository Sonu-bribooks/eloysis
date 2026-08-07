@props([
    'label' => null,
    'name',
    'id' => null,
    'accept' => null,
    'required' => false,
    'help' => null,
])

@php

    $id = $id ?? $name;

    $field = str_replace(
        ['[', ']'],
        ['.', ''],
        $name
    );

    $field = rtrim($field, '.');

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


    <input

        type="file"

        id="{{ $id }}"

        name="{{ $name }}"

        @if($accept)
            accept="{{ $accept }}"
        @endif

        @required($required)

        {{ $attributes->merge([
            'class' => 'form-control'
        ]) }}

    >


    @error($field)

        <div class="invalid-feedback">

            {{ $message }}

        </div>

    @enderror


    @if($help)

        <small class="text-muted">

            {{ $help }}

        </small>

    @endif

</div>