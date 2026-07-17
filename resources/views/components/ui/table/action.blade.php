@props([

'view'=>null,

'edit'=>null,

'delete'=>null,

])

<div class="btn-group btn-group-sm">

    @if($view)

        <x-ui.button

        :size="'sm'"

        variant="info"

        icon="bi-eye"

        :href="$view"/>

    @endif

    @if($edit)

        <x-ui.button

        :size="'sm'"

        variant="warning"

        icon="bi-pencil"

        :href="$edit"/>

    @endif

    @if($delete)

        <x-ui.button

        :size="'sm'"

        variant="danger"

        icon="bi-trash"

        class="btn-delete"

        :data-url="$delete"/>

    @endif

</div>