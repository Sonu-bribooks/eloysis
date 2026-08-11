@props([
    'id' => null,
    'method' => 'GET',
    'title' => 'Filters'
])

<div class="card shadow-sm border-0 mb-4">

    <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center pt-3 px-4 pb-0">

        <h6 class="fw-bold mb-0 text-primary fs-7 text-uppercase tracking-wider">

            {{ $title }}

        </h6>

        <div class="text-muted fs-7">

            <i class="bi bi-grid-3x3-gap"></i>

        </div>

    </div>

    <div class="card-body px-4 pb-4 pt-3">

        <form
            id="{{ $id }}"
            method="{{ $method }}"
            {{ $attributes }}>

            <div class="row g-3 align-items-center">

                {{ $slot }}

            </div>

        </form>

    </div>

</div>