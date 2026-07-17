<x-ui.modal
    id="academicModal"
    size="lg">

    <x-slot:title>

        <span id="academicModalTitle">

            Add Academic Session

        </span>

    </x-slot:title>

    <form
        id="academicForm"
        autocomplete="off">

        @csrf

        <input
            type="hidden"
            id="academic_id"
            name="academic_id">

        <div class="row">

            <div class="col-md-6">

                <x-ui.form-input
                    label="Session Name"
                    name="session_name"
                    id="session_name"
                    required />

            </div>

            <div class="col-md-6">

                <x-ui.form-input
                    label="Start year"
                    name="start_year"
                    id="start_year"
                    type="number"
                    placeholder="YYYY" maxlength="4"
                    required />

            </div>
            <div class="col-md-6">

                <x-ui.form-input
                    label="End year"
                    name="end_year"
                    id="end_year"
                    type="number"
                    placeholder="YYYY" maxlength="4"
                    required />

            </div>
            <div class="col-md-6">

                <x-ui.form-input
                    label="Start Date"
                    name="start_date"
                    id="start_date"
                    type="date"
                    required />

            </div>
            <div class="col-md-6">

                <x-ui.form-input
                    label="End Date"
                    name="end_date"
                    id="end_date"
                    type="date"
                    required />

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
                id="btnSaveAcademic"
                icon="bi-check-lg">

                Save Session

            </x-ui.button>

        </div>

    </form>

</x-ui.modal>