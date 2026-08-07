<x-ui.modal
    id="classModal"
    size="lg">

    <x-slot:title>

        <span id="classModalTitle">

            Add Academic Classes

        </span>

    </x-slot:title>

    <form id="classForm" autocomplete="off">
        @csrf
        <div class="row">
            <x-ui.form-input type="hidden" name="class_id" id="class_id"> </x-ui.form-input>
            <div class="col-md-6">
                <x-ui.form-input name="class_name" id="class_name" placeholder="Class Name" label="Class Name"> </x-ui.form-input>
            </div>
            <div class="col-md-6">
                <x-ui.form-input name="class_code" id="class_code" placeholder="Class Code" label="Class Code"> </x-ui.form-input>
            </div>
            <div class="col-md-12">
                <x-ui.textarea name="description" placeholder="Description" label="Description" id="description"
                    rows="3"
                    maxlength="500"> </x-ui.form-input>
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
                id="btnSaveClass"
                icon="bi-check-lg">

                Save Class

            </x-ui.button>

        </div>

    </form>
</x-ui.modal>