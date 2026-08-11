@props([
    'title',
    'subtitle' => null,
    'icon' => 'bi-grid-1x2',
])

<div class="card border-0 shadow-sm mb-4 px-4 py-3 bg-white">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

        <div class="d-flex align-items-center gap-3">

            <div class="fs-4 text-secondary opacity-75">

                <i class="bi {{ $icon }}"></i>

            </div>

            <div>

                <h4 class="fw-bold mb-0 text-dark">

                    {{ $title }}

                </h4>

                @if($subtitle)

                    <p class="text-muted mb-0 fs-7">

                        {{ $subtitle }}

                    </p>

                @endif

            </div>

        </div>

        @isset($actions)

            <div class="d-flex align-items-center gap-2">

                {{ $actions }}

            </div>

        @endisset

    </div>

</div>