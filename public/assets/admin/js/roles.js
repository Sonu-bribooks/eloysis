const Role = {

    modal: null,
    table: null,

    init() {

        this.modal = new bootstrap.Modal(
            document.getElementById('roleModal')
        );

        this.initDataTable();
        this.bindEvents();

    },

    /*
    |--------------------------------------------------------------------------
    | DataTable
    |--------------------------------------------------------------------------
    */

    initDataTable() {

        this.table = $('#roleTable').DataTable({

            processing: true,
            serverSide: true,

            ajax: {
                url: ROLE_LIST_URL,
                type: 'GET',
                data: function (d) {
                    d.filter_status = $('#filter_status').val();
                },
                error: function (xhr) {
                    Toast.error(
                        xhr.responseJSON?.message ?? 'Unable to load roles.'
                    );
                }
            },

            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            searching: true,
            ordering: true,

            columns: [
                {
                    data: null,
                    name: null,
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'role_name',
                    name: 'role_name'
                },
                {
                    data: 'slug',
                    name: 'slug'
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: true,
                    searchable: false,
                    render: function (data, type, row) {
                        return Helper.statusSwitch(row.id, row.status);
                    }
                },
                {
                    data: null,
                    name: null,
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return `
                            <button
                                type="button"
                                class="btn btn-sm btn-warning btn-edit"
                                data-id="${row.id}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button
                                type="button"
                                class="btn btn-sm btn-danger btn-delete"
                                data-id="${row.id}">
                                <i class="bi bi-trash"></i>
                            </button>
                        `;
                    }
                }
            ]

        });

    },

    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */

    bindEvents() {

        // Filter
        $('#filterForm').on('submit', (e) => {
            e.preventDefault();
            this.table.ajax.reload();
        });

        // Reset
        $('#btnReset').on('click', () => {
            $('#filterForm')[0].reset();
            this.table.search('').ajax.reload();
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

        // Change status
        $(document).on('change', '.btn-status', (e) => {
            this.changeStatus(e.currentTarget);
        });

        // Status Filter
        $('#filter_status').on('change', () => {
            this.table.ajax.reload();
        });

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
                this.table.ajax.reload(null, false);
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

                Helper.clearErrors('#roleForm');
                $('#role_id').val(role.id);
                $('#role_name').val(role.role_name);
                $('#slug').val(role.slug);

                $('#roleModalTitle').text('Edit Role');
                $('#btnSaveRole').html(
                    '<i class="bi bi-check-lg"></i> Update Role'
                );

                this.modal.show();
            }
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
                this.table.ajax.reload(null, false);
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
            cancelButtonText: 'Cancel'
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
                    this.table.ajax.reload(null, false);
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
            url: ROLE_STATUS_URL.replace(':id', id),
            method: 'POST',
            data: (() => {
                let formData = new FormData();
                formData.append('_method', 'PATCH');
                return formData;
            })(),
            success: () => {
                this.table.ajax.reload(null, false);
            },
            error: () => {
                element.checked = !element.checked;
            }
        });

    },

    generateSlug() {
        const role_name = $('#role_name').val();
        const slug = role_name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
        $('#slug').val(slug);
    }

};

$(function () {
    Role.init();
});