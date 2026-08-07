@props([
    'label',
    'id',
    'icon' => null,
])

<div class="detail-item">

    <div class="detail-label">

        @if($icon)

            <i class="bi {{ $icon }} me-1"></i>

        @endif

        {{ $label }}

    </div>

    <div
        id="{{ $id }}"
        class="detail-value">

        -

    </div>

</div>