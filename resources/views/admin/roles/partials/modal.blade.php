<x-ui.modal
    id="roleModal"
    size="lg">

    <x-slot:title>

        <span id="roleModalTitle">

            Add Role

        </span>

    </x-slot:title>

    <form
        id="roleForm"
        autocomplete="off">

        @csrf

        <input
            type="hidden"
            id="role_id"
            name="role_id">

        <div class="row">

            <div class="col-md-6">

                <x-ui.form-input
                    label="Role Name"
                    name="role_name"
                    id="role_name"
                    required />

            </div>

            <div class="col-md-6">

                <x-ui.form-input
                    label="Slug"
                    name="slug"
                    id="slug"
                    required
                    help="Auto generated from Role Name" />

            </div>

            <div class="col-md-12">

                <x-ui.textarea
                    label="Description"
                    name="description"
                    id="description"
                    rows="3"
                    maxlength="500"/>

            </div>

            <div class="col-md-4">

                <x-ui.select
                    label="Status"
                    name="status"
                    id="status"
                    value=1
                    required
                    :options="[
                        1 => 'Active',
                        0 => 'Inactive'
                    ]"/>

            </div>

        </div>

        <div class="text-end mt-4">

            <x-ui.button
                type="button"
                variant="secondary"
                data-bs-dismiss="modal">

                Cancel

            </x-ui.button>

            <x-ui.button
                type="submit"
                id="btnSaveRole"
                icon="bi-check-lg">

                Save Role

            </x-ui.button>

        </div>

    </form>

</x-ui.modal>