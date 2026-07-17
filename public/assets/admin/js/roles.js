const Role = {

    modal: null,
    init() {

        this.modal = new bootstrap.Modal(
            document.getElementById('roleModal')
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

        // Add Role
        $('#btnAddRole').on('click', () => {

            this.openCreate();

        });

        // Save Form
        $('#roleForm').on('submit', (e) => {

            e.preventDefault();

            if ($('#role_id').val() == '') {

                this.store();

            } else {

                this.update();

            }

        });

        // Auto Slug
        $('#role_name').on('keyup', () => {

            if ($('#role_id').val() == '') {

                this.generateSlug();

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

            url: ROLE_LIST_URL,

            type: 'GET',

            data: $('#filterForm').serialize() + '&page=' + page,

            success: (response) => {

                this.render(response.data);
                this.renderPagination(response.data);

            },

            error: (xhr) => {

                Toast.error(xhr.responseJSON?.message ?? 'Unable to load roles.');

            }

        });

    },

    render(result) {

        const rows = result.data;

        let html = '';

        if (!rows.length) {

            html = `
                <tr>
                    <td colspan="5" class="text-center py-4">
                        No Roles Found
                    </td>
                </tr>
            `;

            $('#roleTableBody').html(html);

            return;

        }

        rows.forEach((row, index) => {

            html += `
                <tr>

                    <td>${index + 1}</td>

                    <td>${row.role_name}</td>

                    <td>${row.slug}</td>

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

        $('#roleTableBody').html(html);



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

        $('#rolePagination').html(html);
    },

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    openCreate() {

        $('#roleForm')[0].reset();

        Helper.clearErrors('#roleForm');

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

            form: '#roleForm',

            url: ROLE_STORE_URL,

            method: 'POST',

            success: (response) => {

                this.modal.hide();

                $('#roleForm')[0].reset();

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

            form: '#roleForm',
            url: ROLE_EDIT_URL.replace(':id', id),
            method: 'GET',

            success: (response) => {

                const role = response.data;
                console.log(role);

                Helper.clearErrors('#roleForm');

                $('#role_id').val(role.id);

                $('#role_name').val(role.role_name);

                $('#slug').val(role.slug);

                $('#description').val(role.description);
                $('#status option').prop('selected', false);

                $('#status option[value="' + Number(role.status) + '"]')
                    .prop('selected', true);

                // $('#status').val((role.status == 'true') ? 1 : 0);

                $('#roleModalTitle').text('Edit Role');

                $('#btnSaveRole').html(
                    '<i class="bi bi-check-lg"></i> Update Role'
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
        const id = $('#role_id').val();

        let url = ROLE_UPDATE_URL.replace(':id', id);

        Ajax.request({

            form: '#roleForm',

            url: url,

            method: 'POST',

            extraData: {
                _method: 'PUT'
            },

            success: (response) => {

                this.modal.hide();

                $('#roleForm')[0].reset();

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

            title: 'Delete Role?',

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

                url: ROLE_DELETE_URL.replace(':id', id),

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
    | Helpers
    |--------------------------------------------------------------------------
    */

    generateSlug() {

        let slug = $('#role_name')
            .val()
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-|-$/g, '');

        $('#slug').val(slug);

    },

    /*
    |--------------------------------------------------------------------------
    | Change status
    |--------------------------------------------------------------------------
    */

    changeStatus(element) {

        const id = $(element).data('id');

        Ajax.request({

            url: ROLE_STATUS_URL.replace(':id', id),

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

                // Toggle ko wapas previous state me le aao
                element.checked = !element.checked;

            }

        });

    }

};

$(function () {

    Role.init();

});