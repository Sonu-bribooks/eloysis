const Staff = {

    modal: null,

    viewModal: null,


    init() {

        this.modal = new bootstrap.Modal(
            document.getElementById('staffModal')
        );

        this.viewModal = new bootstrap.Modal(
            document.getElementById('staffViewModal')
        );


        this.bindEvents();

        this.load();

    },


    bindEvents() {


        /*
        |--------------------------------------------------------------------------
        | Filter
        |--------------------------------------------------------------------------
        */

        $('#filterForm').on(
            'submit',
            (e) => {

                e.preventDefault();

                this.load();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Reset Filter
        |--------------------------------------------------------------------------
        */

        $('#btnReset').on(
            'click',
            () => {

                $('#filterForm')[0].reset();

                this.load();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Add Staff
        |--------------------------------------------------------------------------
        */

        $('#btnAddStaff').on(
            'click',
            () => {

                this.openCreate();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Form Submit
        |--------------------------------------------------------------------------
        */

        $('#staffForm').on(
            'submit',
            (e) => {

                e.preventDefault();

                this.save();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $(document).on(
            'click',
            '#staffPagination .page-link',
            (e) => {

                e.preventDefault();

                const page =
                    $(e.currentTarget).data('page');

                if (page) {

                    this.load(page);

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Edit
        |--------------------------------------------------------------------------
        */

        $(document).on(
            'click',
            '.btn-edit-staff',
            (e) => {

                const id =
                    $(e.currentTarget).data('id');

                this.edit(id);

            }
        );


        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        $(document).on(
            'click',
            '.btn-view-staff',
            (e) => {

                const id =
                    $(e.currentTarget).data('id');

                this.view(id);

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Delete
        |--------------------------------------------------------------------------
        */

        $(document).on(
            'click',
            '.btn-delete-staff',
            (e) => {

                const id =
                    $(e.currentTarget).data('id');

                this.delete(id);

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Status Toggle
        |--------------------------------------------------------------------------
        */

        $(document).on(
            'change',
            '.btn-status',
            (e) => {

                const id =
                    $(e.currentTarget).data('id');

                this.toggleStatus(
                    id,
                    e.currentTarget
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Image preview
        |--------------------------------------------------------------------------
        */
        $('#profile_image').on('change', function () {

            const file = this.files[0];

            if (!file) {

                $('#profilePreview').attr(
                    'src',
                    DEFAULT_AVATAR
                );

                return;

            }


            const reader = new FileReader();

            reader.onload = function (e) {

                $('#profilePreview')
                    .attr('src', e.target.result);
                // .removeClass('d-none');

            };

            reader.readAsDataURL(file);

        });

    },


    /*
    |--------------------------------------------------------------------------
    | Load Listing
    |--------------------------------------------------------------------------
    */

    load(page = 1) {

        let data =
            $('#filterForm').serialize();

        data += `&page=${page}`;


        Ajax.request({

            url: STAFF_LIST_URL,

            method: 'GET',

            data: data,

            beforeSend: () => {

                $('#teacherTableBody').html(`

                    <tr>

                        <td
                            colspan="8"
                            class="text-center py-4">

                            Loading...

                        </td>

                    </tr>

                `);

            },


            success: (response) => {

                this.render(
                    response.data
                );

            },


            error: (xhr) => {

                Toast.error(

                    xhr.responseJSON?.message
                    ??
                    'Unable to load admins.'

                );

            }

        });

    },


    /*
    |--------------------------------------------------------------------------
    | Render Table
    |--------------------------------------------------------------------------
    */

    render(result) {

        const rows =
            result.data;


        let html = '';


        if (!rows.length) {

            html = `

                <tr>

                    <td
                        colspan="8"
                        class="text-center py-4">

                        No Admins Found

                    </td>

                </tr>

            `;


            $('#staffTableBody')
                .html(html);


            this.renderPagination(
                result
            );


            return;

        }


        rows.forEach(
            (row, index) => {


                const user =
                    row.user;

                const profileImage =
                    user.profile_image_url
                    ?? DEFAULT_AVATAR;


                html += `

                    <tr>


                        <td>

                            ${result.from + index}

                        </td>


                        <td>

                            <div
                                class="d-flex align-items-center">

                                <img
                                    src="${profileImage}"
                                    width="38"
                                    height="38"
                                    class="rounded-circle me-2"
                                    style="object-fit: cover;">

                                <div>

                                    <div
                                        class="fw-semibold">

                                        ${user.name ?? '-'}

                                    </div>

                                    <small
                                        class="text-muted">

                                        ${user.email ?? '-'}

                                    </small>

                                </div>


                            </div>

                        </td>


                        <td>

                            ${user.mobile ?? '-'}

                        </td>


                        <td>

                            ${row.employee_id ?? '-'}

                        </td>


                        <td>

                            ${row.designation ?? '-'}

                        </td>

                        <td>

                            ${row.department ?? '-'}

                        </td>


                        <td>

                           ${Helper.statusSwitch(row.id, user?.status)}

                        </td>


                        <td>


                            <button

                                type="button"

                                class="btn btn-sm btn-info btn-view-staff"

                                data-id="${row.id}">

                                <i

                                    class="bi bi-eye">

                                </i>

                            </button>


                            <button

                                type="button"

                                class="btn btn-sm btn-warning btn-edit-staff"

                                data-id="${row.id}">

                                <i

                                    class="bi bi-pencil">

                                </i>

                            </button>


                            <button

                                type="button"

                                class="btn btn-sm btn-danger btn-delete-staff"

                                data-id="${row.id}">

                                <i

                                    class="bi bi-trash">

                                </i>

                            </button>


                        </td>


                    </tr>

                `;

            }

        );


        $('#staffTableBody')
            .html(html);


        this.renderPagination(
            result
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    renderPagination(pagination) {

        let html = '';


        pagination.links.forEach(
            (link) => {


                html += `

                    <button

                        class="btn btn-sm

                        ${link.active

                        ?

                        'btn-primary active'

                        :

                        'btn-light'

                    }

                        page-link"

                        data-page="${link.page ?? ''}"

                        ${link.page === null

                        ?

                        'disabled'

                        :

                        ''

                    }>

                        ${link.label}

                    </button>

                `;

            }

        );


        $('#staffPagination')
            .html(html);

    },


    /*
    |--------------------------------------------------------------------------
    | Open Create Modal
    |--------------------------------------------------------------------------
    */

    openCreate() {

        $('#staffForm')[0].reset();

        $('#staff_id').val('');

        $('#staffModalLabel')
            .text('Add Admin');


        Helper.clearErrors(
            $('#staffForm')
        );


        this.modal.show();

    },


    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    edit(id) {

        const url =
            STAFF_SHOW_URL.replace(
                ':id',
                id
            );


        $.ajax({

            url: url,

            type: 'GET',


            success: (response) => {

                const staff =
                    response.data;


                const user =
                    staff.user;


                $('#staff_id')
                    .val(staff.id);


                $('#name')
                    .val(user.name);


                $('#email')
                    .val(user.email);


                $('#mobile')
                    .val(user.mobile);


                $('#employee_id')
                    .val(staff.employee_id);


                $('#designation')
                    .val(staff.designation);


                $('#department')
                    .val(staff.department);


                $('#joining_date')
                    .val(staff.joining_date);


                $('#status')
                    .val(
                        user.status ? 1 : 0
                    );
                $('#address')
                    .val(staff.address);


                $('#city')
                    .val(staff.city);


                $('#state')
                    .val(staff.state);


                $('#pincode')
                    .val(staff.pincode);

                $('#password')
                    .val('');


                $('#password_confirmation')
                    .val('');

                $('#profilePreview').attr(
                    'src',
                    user.profile_image_url
                );

                $('#dob')
                    .val(
                        staff.dob
                            ? staff.dob.substring(0, 10)
                            : ''
                    );


                $('#gender')
                    .val(staff.gender);


                $('#staffModalLabel')
                    .text('Edit Admin');


                this.modal.show();

            },


            error: (xhr) => {

                Toast.error(

                    xhr.responseJSON?.message
                    ??
                    'Unable to load admin.'

                );

            }

        });

    },


    /*
    |--------------------------------------------------------------------------
    | Save
    |--------------------------------------------------------------------------
    */

    save() {

        const id =
            $('#staff_id').val();


        const isEdit =
            id !== '';


        const url =
            isEdit

                ?

                STAFF_UPDATE_URL.replace(
                    ':id',
                    id
                )

                :

                STAFF_STORE_URL;


        Ajax.request({

            form: '#staffForm',

            url: url,

            method: 'POST',


            extraData: isEdit
                ? {
                    _method: 'PUT'
                }
                : {},


            success: (response) => {

                this.modal.hide();


                $('#staffForm')[0]
                    .reset();


                Toast.success(

                    response.message
                    ??

                    (

                        isEdit

                            ?

                            'Admin updated successfully.'

                            :

                            'Admin created successfully.'

                    )

                );


                this.load();

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

            title: 'Delete Academic Staff?',

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

                url: STAFF_DELETE_URL.replace(':id', id),

                method: 'POST',

                data: (() => {

                    let formData = new FormData();

                    formData.append('_method', 'DELETE');

                    return formData;

                })(),

                success: (response) => {
                    // console.log('Delete Success');

                    // console.log(response);

                    Toast.success(response.message ?? 'Admin deleted successfully.');

                    this.load(1);

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

        const url =
            STAFF_STATUS_URL.replace(
                ':id',
                id
            );


        $.ajax({

            url: url,

            type: 'PATCH',


            success: (response) => {

                Toast.success(

                    response.message
                    ??
                    'Status updated successfully.'

                );


                this.load();

            },


            error: () => {

                $(element).prop(
                    'checked',
                    !$(element).prop('checked')
                );


                Toast.error(
                    'Unable to update status.'
                );

            }

        });

    },


    /*
    |--------------------------------------------------------------------------
    | View
    |--------------------------------------------------------------------------
    */

    view(id) {

        const url =
            STAFF_SHOW_URL.replace(
                ':id',
                id
            );


        $.ajax({

            url: url,

            type: 'GET',


            success: (response) => {

                const staff =
                    response.data;

                const user =
                    staff.user;


                $('#viewName')
                    .text(user.name);


                $('#viewEmail')
                    .text(
                        user.email ?? '-'
                    );


                $('#viewMobile')
                    .text(
                        user.mobile ?? '-'
                    );


                $('#viewEmployeeId')
                    .text(
                        staff.employee_id ?? '-'
                    );
                $('#viewEmployee').text(staff.employee_id ?? '-');

                $('#viewDesignation')
                    .text(
                        staff.designation ?? '-'
                    );


                $('#viewDepartment')
                    .text(
                        staff.department ?? '-'
                    );


                $('#viewJoiningDate')
                    .text(
                        staff.joining_date ?? '-'
                    );


                /*
                |--------------------------------------------------------------------------
                | Status
                |--------------------------------------------------------------------------
                */

                $('#viewStatus').html(

                    user.status

                        ? '<span class="badge bg-success">Active</span>'

                        : '<span class="badge bg-danger">Inactive</span>'

                );


                /*
                |--------------------------------------------------------------------------
                | Profile Image
                |--------------------------------------------------------------------------
                */


                $('#viewProfileImage').attr(

                    'src',

                    user.profile_image_url
                        ? user.profile_image_url
                        : DEFAULT_AVATAR

                );

                $('.teacher-profile-header').css(
                    'background-image',
                    `url(${user.profile_image_url})`
                );

                $('#viewDob').text(

                    Helper.formatDate(
                        staff.dob
                    )

                );

                $('#viewCity').text(
                    staff.city ?? '-'
                );


                $('#viewState').text(
                    staff.state ?? '-'
                );


                $('#viewPincode').text(
                    staff.pincode ?? '-'
                );


                $('#viewAddress').text(
                    staff.address ?? '-'
                );

                $('#viewGender').text(

                    staff.gender
                        ? Helper.capitalize(
                            staff.gender
                        )
                        : '-'

                );


                this.viewModal.show();

            },


            error: (xhr) => {

                Toast.error(

                    xhr.responseJSON?.message
                    ??
                    'Unable to load admin details.'

                );

            }

        });

    }

};


$(function () {

    Staff.init();

});