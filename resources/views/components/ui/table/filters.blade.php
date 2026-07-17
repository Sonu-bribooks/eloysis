@props([
    'id' => null,
    'method' => 'GET'
])

<div class="card shadow-sm border-0 mb-3">

    <div class="card-body">

        <form
            id="{{ $id }}"
            method="{{ $method }}"
            {{ $attributes }}>

            <div class="row g-3">

                {{ $slot }}

            </div>

        </form>

    </div>

</div>