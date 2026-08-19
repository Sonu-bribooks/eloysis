@props([
    'id',
    'title',
    'icon',
    'active' => false,
])

<li>

    <a href="#{{ $id }}"
       title="{{ $title }}"
       data-bs-toggle="collapse"
       aria-expanded="{{ $active ? 'true' : 'false' }}">

        <i class="{{ $icon }}"></i>

        <span>{{ $title }}</span>

        <i class="bi bi-chevron-right ms-auto menu-chevron"></i>

    </a>

    <ul class="collapse {{ $active ? 'show' : '' }}"
        id="{{ $id }}">

        {{ $slot }}

    </ul>

</li>