@props([
    'title',
    'count' => 0,
    'icon',
    'color' => 'primary',
    'route' => null,
])

<div class="col-xl-3 col-lg-4 col-md-6">

    <div class="card stat-card border-0 shadow-sm">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <small class="text-muted">

                        {{ $title }}

                    </small>

                    <h3 class="mt-2 mb-0">

                        {{ number_format($count) }}

                    </h3>

                </div>

                <div class="stat-icon bg-{{ $color }}">

                    <i class="bi {{ $icon }}"></i>

                </div>

            </div>

            @if($route)

                <a href="{{ $route }}"
                   class="small text-decoration-none mt-3 d-inline-block">

                    View Details →

                </a>

            @endif

        </div>

    </div>

</div>