@props([
    'label' => null,
    'name',
    'id' => null,
    'options' => [],
    'value' => null,
    'placeholder' => 'Select Option',
    'required' => false,
    'disabled' => false,
    'multiple' => false,
    'help' => null,
])

@php

$id = $id ?? $name;

$field = str_replace(['[', ']'], ['.', ''], $name);
$field = rtrim($field, '.');

$selectedValue = old($field, $value);

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

    <select

        id="{{ $id }}"

        name="{{ $name }}"

        @required($required)

        @disabled($disabled)

        @if($multiple) multiple @endif

        {{ $attributes->merge([
            'class' => 'form-select'.($errors->has($field) ? ' is-invalid' : '')
        ]) }}

    >

        @unless($multiple)
            <option value="">

                {{ $placeholder }}

            </option>
        @endunless

        @foreach($options as $key => $option)

            <option

                value="{{ $key }}"

                @selected(
                    $multiple
                        ? in_array($key, (array)$selectedValue)
                        : $selectedValue == $key
                )

            >

                {{ $option }}

            </option>

        @endforeach

    </select>

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