<x-ui.modal
    id="subjectModal"
    size="lg">

    <x-slot:title>

        <span id="subjectModalTitle">

            Add Academic Class Subject

        </span>

    </x-slot:title>

    <form id="subjectForm" autocomplete="off">
        @csrf
        <div class="row">
            <x-ui.form-input type="hidden" name="subject_id" id="subject_id"> </x-ui.form-input>
            
            <div class="col-md-6">
                <x-ui.form-input name="subject_name" id="subject_name" placeholder="Subject Name" label="Subject Name"> </x-ui.form-input>
            </div>
            <div class="col-md-6">
                <x-ui.form-input name="subject_code" id="subject_code" placeholder="Subject Code" label="Subject Code"> </x-ui.form-input>
            </div>

            <div class="col-md-12">

                <x-ui.textarea
                    label="Description"
                    name="description"
                    id="description"
                    rows="3"
                    maxlength="500"/>

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
                id="btnSaveSubject"
                icon="bi-check-lg">

                Save Subject

            </x-ui.button>

        </div>

    </form>
</x-ui.modal>