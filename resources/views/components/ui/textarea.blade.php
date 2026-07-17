@props([
    'label' => null,
    'name',
    'id' => null,
    'value' => '',
    'rows' => 4,
    'placeholder' => '',
    'required' => false,
    'readonly' => false,
    'disabled' => false,
    'help' => null,
    'maxlength' => null,
    'showCounter' => false,
])

@php

$id = $id ?? $name;

$field = str_replace(['[', ']'], ['.', ''], $name);
$field = rtrim($field, '.');

$fieldValue = old($field, $value);

@endphp

<div class="mb-3">

    @if($label)
        <label for="{{ $id }}" class="form-label">

            {{ $label }}

            @if($required)
                <span class="text-danger">*</span>
            @endif

        </label>
    @endif

    <textarea

        id="{{ $id }}"

        name="{{ $name }}"

        rows="{{ $rows }}"

        placeholder="{{ $placeholder }}"

        @required($required)

        @readonly($readonly)

        @disabled($disabled)

        @if($maxlength)
            maxlength="{{ $maxlength }}"
        @endif

        {{ $attributes->merge([
            'class' => 'form-control'.($errors->has($field) ? ' is-invalid' : '')
        ]) }}

    >{{ $fieldValue }}</textarea>

    @error($field)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror

    <div class="d-flex justify-content-between mt-1">

        @if($help)
            <small class="text-muted">
                {{ $help }}
            </small>
        @else
            <span></span>
        @endif

        @if($showCounter && $maxlength)
            <small
                class="text-muted textarea-counter"
                data-target="{{ $id }}">
                {{ strlen($fieldValue) }}/{{ $maxlength }}
            </small>
        @endif

    </div>

</div>