const Classes = {

    modal: null,
    init() {

        this.modal = new bootstrap.Modal(
            document.getElementById('classModal')
        );

        this.bindEvents();

        this.load();
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

        // Add Academic Class
        $('#btnAddClass').on('click', () => {

            this.openCreate();

        });

        // Save Form
        $('#classForm').on('submit', (e) => {

            e.preventDefault();

            if ($('#class_id').val() == '') {

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

            url: CLASSES_LIST_URL,
            type: 'GET',
            data: $('#filterForm').serialize() + '&page=' + page,

            beforeSend: () => {

                $('#classTableBody').html(`

                    <tr>

                        <td
                            colspan="5"
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
                Toast.error(e.responseJSON?.message ?? 'Unable to load Academic Classes.');
            }
        })

    },

    render(result) {
        const rows = result.data;

        let html = '';

        if (!rows.length) {

            html = `
                <tr>
                    <td colspan="5" class="text-center py-4">
                        No Academic Classes Found
                    </td>
                </tr>
            `;

            $('#classTableBody').html(html);

            return;
        }

        rows.forEach((row, index) => {

            html += `
                <tr>

                    <td>${index + 1}</td>

                    <td>${row.class_name}</td>

                    <td>${row.class_code}</td>

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

        $('#classTableBody').html(html);
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

        $('#classPagination').html(html);
    },

    /*
   |--------------------------------------------------------------------------
   | Create
   |--------------------------------------------------------------------------
   */

    openCreate() {

        $('#classForm')[0].reset();

        Helper.clearErrors('#classForm');

        $('#class_id').val('');

        $('#classModalTitle').text('Add Academic Classes');

        $('#btnSaveClass').html(
            '<i class="bi bi-check-lg"></i> Save Class'
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

            form: '#classForm',

            url: CLASSES_STORE_URL,

            method: 'POST',

            success: (response) => {

                this.modal.hide();

                $('#classForm')[0].reset();

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

            form: '#classForm',
            url: CLASSES_EDIT_URL.replace(':id', id),
            method: 'GET',

            success: (response) => {

                const classes = response.data;
                console.log(classes);

                Helper.clearErrors('#classesForm');

                $('#class_id').val(classes.id);

                $('#class_name').val(classes.class_name);
                $('#class_code').val(classes.class_code);
                $('#description').val(classes.description);


                $('#classModalTitle').text('Edit Academic Class');

                $('#btnSaveClass').html(
                    '<i class="bi bi-check-lg"></i> Update Class'
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
        const id = $('#class_id').val();
        // alert(id);
        let url = CLASSES_UPDATE_URL.replace(':id', id);

        Ajax.request({

            form: '#classForm',

            url: url,

            method: 'POST',

            extraData: {
                _method: 'PUT'
            },

            success: (response) => {

                this.modal.hide();

                $('#classForm')[0].reset();

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

            title: 'Delete Academic Class?',

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

                url: CLASSES_DELETE_URL.replace(':id', id),

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

            url: CLASSES_STATUS_URL.replace(':id', id),

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

    Classes.init();

});