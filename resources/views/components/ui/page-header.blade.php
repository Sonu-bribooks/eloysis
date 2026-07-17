@props([
    'title',
    'subtitle' => null,
])

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold mb-1">

            {{ $title }}

        </h3>

        @if($subtitle)

            <p class="text-muted mb-0">

                {{ $subtitle }}

            </p>

        @endif

    </div>

    @isset($actions)

        <div>

            {{ $actions }}

        </div>

    @endisset

</div>