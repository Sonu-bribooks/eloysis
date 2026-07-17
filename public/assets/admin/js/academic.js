const Academic = {

    modal: null,
    init() {

        this.modal = new bootstrap.Modal(
            document.getElementById('academicModal')
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

        // Add Academic Session
        $('#btnAddSession').on('click', () => {

            this.openCreate();

        });

        // Save Form
        $('#academicForm').on('submit', (e) => {

            e.preventDefault();

            if ($('#academic_id').val() == '') {

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

        $(document).on('input', '#start_year, #end_year', (e) => {
            $(this).val($(this).val().replace(/\D/g, '').slice(0, 4));
        });


        $(document).on('change', '#end_year', function () {

            let start = parseInt($('#start_year').val());
            let end = parseInt($(this).val());

            if (end < start) {
                $(this).val('');
                Toast.error(
                    'End year cannot be less than start year.'
                );
            }
        });

    },

    load(page = 1) {

        $.ajax({

            url: ACADEMIC_LIST_URL,

            type: 'GET',

            data: $('#filterForm').serialize() + '&page=' + page,

            success: (response) => {

                this.render(response.data);
                this.renderPagination(response.data);

            },

            error: (xhr) => {

                Toast.error(xhr.responseJSON?.message ?? 'Unable to load Academic Sessions.');

            }

        });

    },

    render(result) {

        const rows = result.data;

        let html = '';

        if (!rows.length) {

            html = `
                <tr>
                    <td colspan="8" class="text-center py-4">
                        No Academic Sessions Found
                    </td>
                </tr>
            `;

            $('#academicTableBody').html(html);

            return;

        }

        rows.forEach((row, index) => {

            html += `
                <tr>

                    <td>${index + 1}</td>

                    <td>${row.name}</td>

                    <td>${row.start_year}</td>
                    <td>${row.end_year}</td>
                    <td>${row.start_date}</td>
                    <td>${row.end_date}</td>

                    <td>
                        ${Helper.statusSwitch(row.id, row.is_current)}
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

        $('#academicTableBody').html(html);



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

        $('#academicPagination').html(html);
    },

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    openCreate() {

        $('#academicForm')[0].reset();

        Helper.clearErrors('#academicForm');

        $('#role_id').val('');

        $('#roleModalTitle').text('Add Role');

        $('#btnSaveRole').html(
            '<i class="bi bi-check-lg"></i> Save Role'
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

            form: '#academicForm',

            url: ACADEMIC_STORE_URL,

            method: 'POST',

            success: (response) => {

                this.modal.hide();

                $('#academicForm')[0].reset();

                this.load(1);

            }

        });

    },

    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    edit(id) {

        Ajax.request({

            form: '#academicForm',
            url: ACADEMIC_EDIT_URL.replace(':id', id),
            method: 'GET',

            success: (response) => {

                const academic = response.data;
                console.log(academic);

                Helper.clearErrors('#academicForm');

                $('#academic_id').val(academic.id);

                $('#session_name').val(academic.name);
                $('#start_year').val(academic.start_year);
                $('#end_year').val(academic.end_year);
                // alert(this.formatDate(academic.start_date));
                $('#start_date').val(this.formatDate(academic.start_date));
                $('#end_date').val(this.formatDate(academic.end_date));

                $('#academicModalTitle').text('Edit Academic Session');

                $('#btnSaveAcademic').html(
                    '<i class="bi bi-check-lg"></i> Update Session'
                );

                this.modal.show();

            },

        });


    },

    formatDate(date) {
        let parts = date.split('T');
        return `${parts[0]}`;
    },

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    update() {
        const id = $('#academic_id').val();
        // alert(id);
        let url = ACADEMIC_UPDATE_URL.replace(':id', id);

        Ajax.request({

            form: '#academicForm',

            url: url,

            method: 'POST',

            extraData: {
                _method: 'PUT'
            },

            success: (response) => {

                this.modal.hide();

                $('#academicForm')[0].reset();

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

            title: 'Delete Academic Session?',

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

                url: ACADEMIC_DELETE_URL.replace(':id', id),

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

            url: ACADEMIC_STATUS_URL.replace(':id', id),

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

};

$(function () {

    Academic.init();

});