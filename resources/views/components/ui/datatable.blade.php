@props([
    'id' => null,
    'responsive' => true,
    'hover' => true,
    'striped' => true,
    'bordered' => false,
    'small' => false,
])

@php

$tableClass = 'table align-middle mb-0';

if($hover){
    $tableClass .= ' table-hover';
}

if($striped){
    $tableClass .= ' table-striped';
}

if($bordered){
    $tableClass .= ' table-bordered';
}

if($small){
    $tableClass .= ' table-sm';
}

@endphp

<div class="card shadow-sm border-0">

    <div class="{{ $responsive ? 'table-responsive' : '' }}">

        <table

            @if($id)
                id="{{ $id }}"
            @endif

            {{ $attributes->merge([

                'class'=>$tableClass

            ]) }}

        >

            {{ $slot }}

        </table>

    </div>

</div>