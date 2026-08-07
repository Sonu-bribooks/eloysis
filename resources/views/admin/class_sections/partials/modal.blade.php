<x-ui.modal
    id="classSectionModal"
    size="lg">

    <x-slot:title>

        <span id="sectionModalTitle">

            Add Academic Class Section

        </span>

    </x-slot:title>

    <form id="classSectionForm" autocomplete="off">
        @csrf
        <div class="row">
            <x-ui.form-input type="hidden" name="class_section_id" id="class_section_id"> </x-ui.form-input>
            <div class="col-md-6">
                <x-ui.select
                    name="class_id"
                    id="sec_class_id"
                    value=''
                    :options='$classes'
                    label="Class selection"
                    placeholder="Select Class">

                </x-ui.select>
            </div>

            <div class="col-md-6">
                <x-ui.select
                    name="section_id"
                    id="sec_section_id"
                    value=''
                    :options=$sections
                    label="Section selection"
                    placeholder="Select Section">

                </x-ui.select>
            </div>

            <div class="col-md-6">

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
                id="btnSaveSection"
                icon="bi-check-lg">

                Save Section

            </x-ui.button>

        </div>

    </form>
</x-ui.modal>