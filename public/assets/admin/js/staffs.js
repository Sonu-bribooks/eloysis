const Staff = {

    modal: null,
    viewModal: null,
    table: null,

    init() {

        this.modal = new bootstrap.Modal(
            document.getElementById('staffModal')
        );

        this.viewModal = new bootstrap.Modal(
            document.getElementById('staffViewModal')
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

        this.table = $('#staffTable').DataTable({

            processing: true,
            serverSide: true,

            ajax: {
                url: STAFF_LIST_URL,
                type: 'GET',
                data: function (d) {
                    d.filter_status = $('#filter_status').val();
                },
                error: function (xhr) {
                    Toast.error(
                        xhr.responseJSON?.message ?? 'Unable to load admins.'
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
                    data: 'user.name',
                    name: 'user_id',
                    render: function (data, type, row) {
                        const user = row.user || {};
                        const profileImage = user.profile_image_url ?? DEFAULT_AVATAR;

                        return `
                            <div class="d-flex align-items-center">
                                <img
                                    src="${profileImage}"
                                    width="38"
                                    height="38"
                                    class="rounded-circle me-2"
                                    style="object-fit: cover;">
                                <div>
                                    <div class="fw-semibold">
                                        ${user.name ?? '-'}
                                    </div>
                                    <small class="text-muted">
                                        ${user.email ?? '-'}
                                    </small>
                                </div>
                            </div>
                        `;
                    }
                },
                {
                    data: 'user.mobile',
                    name: 'mobile',
                    orderable: false,
                    render: function (data, type, row) {
                        return row.user?.mobile ?? '-';
                    }
                },
                {
                    data: 'employee_id',
                    name: 'employee_id',
                    render: function (data, type, row) {
                        return row.employee_id ?? '-';
                    }
                },
                {
                    data: 'designation',
                    name: 'designation',
                    render: function (data, type, row) {
                        return row.designation ?? '-';
                    }
                },
                {
                    data: 'department',
                    name: 'department',
                    render: function (data, type, row) {
                        return row.department ?? '-';
                    }
                },
                {
                    data: 'user.status',
                    name: 'status',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return Helper.statusSwitch(row.id, row.user?.status);
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
                                class="btn btn-sm btn-view"
                                data-id="${row.id}">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button
                                type="button"
                                class="btn btn-sm btn-edit"
                                data-id="${row.id}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button
                                type="button"
                                class="btn btn-sm btn-delete"
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

        // Add Staff
        $('#btnAddStaff').on('click', () => {
            this.openCreate();
        });

        // Save Form
        $('#staffForm').on('submit', (e) => {
            e.preventDefault();
            this.save();
        });

        // Edit
        $(document).on('click', '.btn-edit', (e) => {
            this.edit($(e.currentTarget).data('id'));
        });

        // View
        $(document).on('click', '.btn-view', (e) => {
            this.view($(e.currentTarget).data('id'));
        });

        // Delete
        $(document).on('click', '.btn-delete', (e) => {
            this.delete($(e.currentTarget).data('id'));
        });

        // Status Toggle
        $(document).on('change', '.btn-status', (e) => {
            this.toggleStatus($(e.currentTarget).data('id'), e.currentTarget);
        });

        // Status Filter
        $('#filter_status').on('change', () => {
            this.table.ajax.reload();
        });

        // Image preview
        $('#profile_image').on('change', function () {
            const file = this.files[0];
            if (!file) {
                $('#profilePreview').attr('src', DEFAULT_AVATAR);
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                $('#profilePreview').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        });

    },

    /*
    |--------------------------------------------------------------------------
    | Open Create Modal
    |--------------------------------------------------------------------------
    */

    openCreate() {

        $('#staffForm')[0].reset();
        $('#staff_id').val('');
        $('#staffModalLabel').text('Add Admin');
        $('#profilePreview').attr('src', DEFAULT_AVATAR);

        Helper.clearErrors($('#staffForm'));
        this.modal.show();

    },

    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    edit(id) {

        const url = STAFF_SHOW_URL.replace(':id', id);

        $.ajax({
            url: url,
            type: 'GET',
            success: (response) => {
                const staff = response.data;
                const user = staff.user;

                $('#staff_id').val(staff.id);
                $('#name').val(user.name);
                $('#email').val(user.email);
                $('#mobile').val(user.mobile);
                $('#employee_id').val(staff.employee_id);
                $('#designation').val(staff.designation);
                $('#department').val(staff.department);
                $('#joining_date').val(staff.joining_date);
                $('#status').val(user.status ? 1 : 0);
                $('#address').val(staff.address);
                $('#city').val(staff.city);
                $('#state').val(staff.state);
                $('#pincode').val(staff.pincode);
                $('#password').val('');
                $('#password_confirmation').val('');
                $('#profilePreview').attr('src', user.profile_image_url ?? DEFAULT_AVATAR);
                $('#dob').val(staff.dob ? staff.dob.substring(0, 10) : '');
                $('#gender').val(staff.gender);

                $('#staffModalLabel').text('Edit Admin');
                this.modal.show();
            },
            error: (xhr) => {
                Toast.error(xhr.responseJSON?.message ?? 'Unable to load admin.');
            }
        });

    },

    /*
    |--------------------------------------------------------------------------
    | Save
    |--------------------------------------------------------------------------
    */

    save() {

        const id = $('#staff_id').val();
        const isEdit = id !== '';

        const url = isEdit
            ? STAFF_UPDATE_URL.replace(':id', id)
            : STAFF_STORE_URL;

        Ajax.request({
            form: '#staffForm',
            url: url,
            method: 'POST',
            extraData: isEdit ? { _method: 'PUT' } : {},
            success: (response) => {
                this.modal.hide();
                $('#staffForm')[0].reset();
                Toast.success(
                    response.message ?? (isEdit ? 'Admin updated successfully.' : 'Admin created successfully.')
                );
                this.table.ajax.reload(null, false);
            }
        });

    },

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    delete(id) {

        Swal.fire({
            title: 'Delete Admin?',
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
                url: STAFF_DELETE_URL.replace(':id', id),
                method: 'POST',
                data: (() => {
                    let formData = new FormData();
                    formData.append('_method', 'DELETE');
                    return formData;
                })(),
                success: (response) => {
                    Toast.success(response.message ?? 'Admin deleted successfully.');
                    this.table.ajax.reload(null, false);
                }
            });
        });

    },

    /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */

    toggleStatus(id, element) {

        const url = STAFF_STATUS_URL.replace(':id', id);

        $.ajax({
            url: url,
            type: 'PATCH',
            success: (response) => {
                Toast.success(response.message ?? 'Status updated successfully.');
                this.table.ajax.reload(null, false);
            },
            error: () => {
                $(element).prop('checked', !$(element).prop('checked'));
                Toast.error('Unable to update status.');
            }
        });

    },

    /*
    |--------------------------------------------------------------------------
    | View
    |--------------------------------------------------------------------------
    */

    view(id) {

        const url = STAFF_SHOW_URL.replace(':id', id);

        $.ajax({
            url: url,
            type: 'GET',
            success: (response) => {
                const staff = response.data;
                const user = staff.user;

                $('#viewName').text(user.name);
                $('#viewEmail').text(user.email ?? '-');
                $('#viewMobile').text(user.mobile ?? '-');
                $('#viewEmployeeId').text(staff.employee_id ?? '-');
                $('#viewEmployee').text(staff.employee_id ?? '-');
                $('#viewDesignation').text(staff.designation ?? '-');
                $('#viewDepartment').text(staff.department ?? '-');
                $('#viewJoiningDate').text(staff.joining_date ?? '-');

                $('#viewStatus').html(
                    user.status
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>'
                );

                $('#viewProfileImage').attr(
                    'src',
                    user.profile_image_url ? user.profile_image_url : DEFAULT_AVATAR
                );

                $('.teacher-profile-header').css(
                    'background-image',
                    `url(${user.profile_image_url})`
                );

                $('#viewDob').text(Helper.formatDate(staff.dob));
                $('#viewCity').text(staff.city ?? '-');
                $('#viewState').text(staff.state ?? '-');
                $('#viewPincode').text(staff.pincode ?? '-');
                $('#viewAddress').text(staff.address ?? '-');
                $('#viewGender').text(staff.gender ? Helper.capitalize(staff.gender) : '-');

                this.viewModal.show();
            },
            error: (xhr) => {
                Toast.error(xhr.responseJSON?.message ?? 'Unable to load admin details.');
            }
        });

    }

};

$(function () {
    Staff.init();
});