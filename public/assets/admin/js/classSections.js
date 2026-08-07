const Section = {

    modal: null,
    init() {

        this.modal = new bootstrap.Modal(
            document.getElementById('classSectionModal')
        );

        this.bindEvents();
        this.load(1);
    },

    bindEvents() {

        // Filter
        $('#filterForm').on('submit', (e) => {

            e.preventDefault();

            this.load(1);

        });

        // Reset
        $('#btnReset').on('click', () => {

            $('#filterForm')[0].reset();

            this.load(1);

        });

        // Add Role
        $('#btnAddSection').on('click', () => {

            this.openCreate();

        });

        // Save Form
        $('#classSectionForm').on('submit', (e) => {

            e.preventDefault();

            if ($('#class_section_id').val() == '') {

                this.store();

            } else {

                this.update();

            }

        });

        // Edit (Dynamic Button)
        $(document).on('click', '.btn-edit', (e) => {

            this.edit($(e.currentTarget).data('id'));

        });

        // Delete 
        $(document).on('click', '.btn-delete', (e) => {

            this.destroy($(e.currentTarget).data('id'));

        });

        //pagination
        $(document).on('click', '.page-link', (e) => {

            let page = $(e.currentTarget).data('page') ?? 1;

            this.load(page);

        });

        //change status
        $(document).on('change', '.btn-status', (e) => {

            this.changeStatus(e.currentTarget);

        });

    },

    load(page = 1) {

        $.ajax({

            url: CLASS_SECTION_LIST_URL,
            type: 'GET',
            data: $('#filterForm').serialize() + '&page=' + page,

            beforeSend: () => {

                $('#sectionTableBody').html(`

                    <tr>

                        <td
                            colspan="6"
                            class="text-center py-4">

                            Loading...

                        </td>

                    </tr>

                `);

            },

            success: (response) => {
                console.log(response);

                this.render(response.data);
                this.renderPagination(response.data);
            },

            error: (e) => {
                Toast.error(e.responseJSON?.message ?? 'Unable to load Academic Class Sections.');
            }
        })

    },

    render(result) {
        const rows = result.data;

        let html = '';

        if (!rows.length) {

            html = `
                <tr>
                    <td colspan="6" class="text-center py-4">
                        No Academic Class Sections Found
                    </td>
                </tr>
            `;

            $('#sectionTableBody').html(html);

            return;
        }

        rows.forEach((row, index) => {

            html += `
                <tr>

                    <td>${index + 1}</td>

                    <td>${row.section_class.class_name ?? '-'}</td>

                    <td>${row.section.name ?? '-'}</td>

                    <td>${row.section.code ?? '-'}</td>

                    <td>
                        ${Helper.statusSwitch(row.id, row.status)}
                    </td>

                    <td>

                        <button
                            class="btn btn-sm btn-warning btn-edit"
                            data-id="${row.id}">

                            <i class="bi bi-pencil"></i>

                        </button>

                        <button
                            class="btn btn-sm btn-danger btn-delete"
                            data-id="${row.id}">

                            <i class="bi bi-trash"></i>

                        </button>

                    </td>

                </tr>
            `;

        });

        $('#sectionTableBody').html(html);
    },

    renderPagination(pagination) {
        let html = '';

        pagination.links.forEach(link => {
            html += `
                <button
                    class="btn btn-sm ${link.active ? 'btn-primary active' : 'btn-light'} page-link"
                    data-page="${link.page ?? ''}"
                    ${link.page === null ? 'disabled' : ''}>

                    ${link.label}

                </button>
            `;
        });

        $('#sectionPagination').html(html);
    },

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    openCreate() {

        $('#classSectionForm')[0].reset();
        Helper.clearErrors('#classSectionForm');

        $('#class_section_id').val('');

        $('#sectionModalTitle').text('Add Acedemic Class Section');

        $('#btnSaveSection').html(
            '<i class="bi bi-check-lg"></i> Save Section'
        );

        this.modal.show();


    },


    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    store() {

        Ajax.request({

            form: '#classSectionForm',
            method: 'POST',
            url: CLASS_SECTION_STORE_URL,

            success: (Response) => {
                this.modal.hide();

                $('#classSectionForm')[0].reset();

                this.load(1);
            }
        })
    },

    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    edit(id) {

        Ajax.request({

            form: '#classSectionForm',
            url: CLASS_SECTION_EDIT_URL.replace(':id', id),
            method: 'GET',

            success: (response) => {

                const section = response.data; //
                console.log(section);
                $('#classSectionForm')[0].reset();
                Helper.clearErrors('#classSectionForm');
                let $class = $('#sec_class_id');
                $class.empty();
                $class.append('<option value="">Select Class</option>');
                $.each(section.class_info, function (index, item) {
                    $('#sec_class_id').append(
                        `<option value="${index}" ${index == section.class_id ? 'selected' : ''}>${item}</option>`
                    );
                });

                let $cls_sec = $('#sec_section_id');
                $cls_sec.empty();
                $cls_sec.append('<option value="">Select Section</option>');
                $.each(section.section_info, function (index, item) {
                    $('#sec_section_id').append(
                        `<option value="${index}" ${index == section.class_id ? 'selected' : ''}>${item}</option>`
                    );
                });

                $('#class_section_id').val(section.id);

                $('#status option[value="' + Number(section.status) + '"]')
                    .prop('selected', true);


                $('#sectionModalTitle').text('Edit Academic Class Section');

                $('#btnSaveSection').html(
                    '<i class="bi bi-check-lg"></i> Update section'
                );

                this.modal.show();

            },

        });


    },

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    update() {
        const id = $('#class_section_id').val();
        // alert(id);
        let url = CLASS_SECTION_UPDATE_URL.replace(':id', id);

        Ajax.request({

            form: '#classSectionForm',

            url: url,

            method: 'POST',

            extraData: {
                _method: 'PUT'
            },

            success: (response) => {

                this.modal.hide();

                $('#classSectionForm')[0].reset();

                this.load(1);

            }

        });
    },

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    destroy(id) {

        Swal.fire({

            title: 'Delete Academic Class section?',

            text: 'This action cannot be undone.',

            icon: 'warning',

            showCancelButton: true,

            confirmButtonText: 'Yes, Delete',

            cancelButtonText: 'Cancel',

        }).then((result) => {

            if (!result.isConfirmed) {

                return;

            }

            Ajax.request({

                url: CLASS_SECTION_DELETE_URL.replace(':id', id),

                method: 'POST',

                data: (() => {

                    let formData = new FormData();

                    formData.append('_method', 'DELETE');

                    return formData;

                })(),

                success: (response) => {
                    console.log('Delete Success');

                    console.log(response);
                    this.load(1);

                }

            });

        });

    },


    /*
    |--------------------------------------------------------------------------
    | Change status
    |--------------------------------------------------------------------------
    */

    changeStatus(element) {

        const id = $(element).data('id');

        Ajax.request({

            url: CLASS_SECTION_STATUS_URL.replace(':id', id),

            method: 'POST',

            data: (() => {

                let formData = new FormData();

                formData.append('_method', 'PATCH');

                return formData;

            })(),

            success: () => {

                this.load(1);

            },

            error: () => {
                // alert('ssssssssss');
                // Toggle ko wapas previous state me le aao
                element.checked = !element.checked;

            }

        });

    }
}

$(function () {

    Section.init();

}); 