<x-ui.modal
    id="sectionModal"
    size="lg">

    <x-slot:title>

        <span id="sectionModalTitle">

            Add Academic Class Section

        </span>

    </x-slot:title>

    <form id="sectionForm" autocomplete="off">
        @csrf
        <div class="row">
            <x-ui.form-input type="hidden" name="section_id" id="section_id"> </x-ui.form-input>
            <div class="col-md-6">
                <x-ui.form-input name="name" id="name" placeholder="Section Name" label="Section Name"> </x-ui.form-input>
            </div>
            <div class="col-md-6">
                <x-ui.form-input name="code" id="code" placeholder="Section Code" label="Section Code"> </x-ui.form-input>
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
                id="btnSaveSection"
                icon="bi-check-lg">

                Save Section

            </x-ui.button>

        </div>

    </form>
</x-ui.modal>