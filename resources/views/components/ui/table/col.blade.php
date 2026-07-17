@props([
    'sortable'=>false,
])

<th {{ $attributes }}>

    <div class="d-flex align-items-center">

        {{ $slot }}

        @if($sortable)

            <i class="bi bi-arrow-down-up ms-2 text-muted small"></i>

        @endif

    </div>

</th>