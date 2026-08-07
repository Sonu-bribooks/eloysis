<x-ui.modal
    id="summaryModal"
    title="Student Promotion Summary"
    size="xl"
    scrollable>

    <div class="row mb-4">

        <div class="col-md-4">

            <x-ui.card>

                <div class="text-center">

                    <h6 class="text-muted mb-2">

                        Total Selected

                    </h6>

                    <h2
                        id="summaryTotal"
                        class="fw-bold text-primary mb-0">

                        0

                    </h2>

                </div>

            </x-ui.card>

        </div>

        <div class="col-md-4">

            <x-ui.card>

                <div class="text-center">

                    <h6 class="text-muted mb-2">

                        Successfully Promoted

                    </h6>

                    <h2
                        id="summaryPromoted"
                        class="fw-bold text-success mb-0">

                        0

                    </h2>

                </div>

            </x-ui.card>

        </div>

        <div class="col-md-4">

            <x-ui.card>

                <div class="text-center">

                    <h6 class="text-muted mb-2">

                        Skipped

                    </h6>

                    <h2
                        id="summarySkipped"
                        class="fw-bold text-danger mb-0">

                        0

                    </h2>

                </div>

            </x-ui.card>

        </div>

    </div>


    <div id="summaryAlert"></div>


    <div id="skippedContainer" style="display:none;">

        <h5 class="mb-3">

            Skipped Students

        </h5>

        <x-ui.datatable>

            <x-ui.table.thead>

                <x-ui.table.col width="70">

                    #

                </x-ui.table.col>

                <x-ui.table.col>

                    Student Name

                </x-ui.table.col>

                <x-ui.table.col>

                    Reason

                </x-ui.table.col>

            </x-ui.table.thead>

            <x-ui.table.tbody id="summaryTableBody">

            </x-ui.table.tbody>

        </x-ui.datatable>

    </div>

    <x-slot:footer>

        <x-ui.button
            variant="secondary"
            data-bs-dismiss="modal">

            Close

        </x-ui.button>

    </x-slot:footer>

</x-ui.modal>