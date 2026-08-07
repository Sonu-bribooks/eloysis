const Teacher = {

    modal: null,
    viewModal: null,
    init() {

        this.modal = new bootstrap.Modal(
            document.getElementById('teacherModal')
        );

        this.viewModal = new bootstrap.Modal(
            document.getElementById('teacherViewModal')
        );

        this.bindEvents();

        this.load();

    },


    bindEvents() {

        /*
        |--------------------------------------------------------------------------
        | Filter Submit
        |--------------------------------------------------------------------------
        */

        $('#filterForm').on('submit', (e) => {

            e.preventDefault();

            this.load();

        });


        /*
        |--------------------------------------------------------------------------
        | Reset Filter
        |--------------------------------------------------------------------------
        */

        $('#btnReset').on('click', () => {

            $('#filterForm')[0].reset();

            this.load();

        });

        /*
        |--------------------------------------------------------------------------
        | Add Teacher
        |--------------------------------------------------------------------------
        */

        $('#btnAddTeacher').on('click', () => {

            this.openCreate();

        });


        /*
        |--------------------------------------------------------------------------
        | Form Submit
        |--------------------------------------------------------------------------
        */

        $('#teacherForm').on('submit', (e) => {

            e.preventDefault();

            this.save();

        });


        /*
        |--------------------------------------------------------------------------
        | Edit Teacher
        |--------------------------------------------------------------------------
        */

        $(document).on(
            'click',
            '.btn-edit-teacher',
            (e) => {

                const id =
                    $(e.currentTarget).data('id');

                this.edit(id);

            }
        );

        /*
        |--------------------------------------------------------------------------
        | View Teacher
        |--------------------------------------------------------------------------
        */
        $(document).on(
            'click',
            '.btn-view-teacher',
            (e) => {

                const id =
                    $(e.currentTarget).data('id');

                this.view(id);

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $(document).on(
            'click',
            '#teacherPagination .page-link',
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

        //change status
        $(document).on('change', '.btn-status', (e) => {

            this.changeStatus(e.currentTarget);

        });

        // Delete 
        $(document).on('click', '.btn-delete-teacher', (e) => {

            this.destroy($(e.currentTarget).data('id'));

        });

    },


    /*
    |--------------------------------------------------------------------------
    | Load Teachers
    |--------------------------------------------------------------------------
    */

    load(page = 1) {

        let data =
            $('#filterForm').serialize();

        data += '&page=' + page;


        Ajax.request({

            url: TEACHER_LIST_URL,

            method: 'GET',

            data: data,

            beforeSend: () => {

                $('#teacherTableBody').html(`

                    <tr>

                        <td
                            colspan="7"
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

                    xhr.responseJSON?.message ??

                    'Unable to load teachers.'

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
                        colspan="7"
                        class="text-center py-4">

                        No Teachers Found

                    </td>

                </tr>

            `;

            $('#teacherTableBody')
                .html(html);

            $('#teacherPagination')
                .html('');

            return;

        }


        rows.forEach((row, index) => {

            const user =
                row.user;


            html += `

                <tr>

                    <td>

                        ${result.from + index}

                    </td>


                    <td>
                        <div class="d-flex align-items-center gap-2">

                            <img
                                src="${row.user.profile_image_url}"
                                class="rounded-circle"
                                width="40"
                                height="40"
                                style="object-fit: cover;">

                            <span>

                               ${user?.name ?? '-'}

                            </span>

                        </div>

                    </td>


                    <td>

                        ${user?.email ?? '-'}

                    </td>


                    <td>

                        ${row.employee_id ?? '-'}

                    </td>


                    <td>

                        ${user?.mobile ?? '-'}

                    </td>
                    <td>
                        ${row.specialization ?? '-'}

                    </td>
                    <td>

                      ${Helper.statusSwitch(row.id, user?.status)}

                    </td>


                    <td>

                        <button

                            type="button"

                            class="btn
                                   btn-sm
                                   btn-outline-primary
                                   btn-view-teacher"

                            data-id="${row.id}">

                            <i
                                class="bi bi-eye">

                            </i>

                        </button>

                        <button

                            type="button"

                            class="btn
                                   btn-sm
                                   btn-outline-warning
                                   btn-edit-teacher"

                            data-id="${row.id}">

                            <i
                                class="bi bi-pencil">

                            </i>

                        </button>


                        <button

                            type="button"

                            class="btn
                                   btn-sm
                                   btn-outline-danger
                                   btn-delete-teacher"

                            data-id="${row.id}">

                            <i
                                class="bi bi-trash">

                            </i>

                        </button>

                    </td>

                </tr>

            `;

        });


        $('#teacherTableBody')
            .html(html);


        this.renderPagination(result);

    },


    /*
    |--------------------------------------------------------------------------
    | Render Pagination
    |--------------------------------------------------------------------------
    */

    renderPagination(pagination) {

        let html = '';


        pagination.links.forEach(link => {

            html += `

                <button

                    type="button"

                    class="btn btn-sm

                        ${link.active

                    ? 'btn-primary active'

                    : 'btn-light'

                }

                        page-link"

                    data-page="${link.page ?? ''}"

                    ${link.page === null

                    ? 'disabled'

                    : ''

                }>

                    ${link.label}

                </button>

            `;

        });


        $('#teacherPagination')
            .html(html);

    },

    /*
   |--------------------------------------------------------------------------
   | Open Create Modal
   |--------------------------------------------------------------------------
   */

    openCreate() {

        const form =
            $('#teacherForm')[0];

        form.reset();

        $('#teacher_id').val('');

        $('#teacherModalTitle')
            .text('Add Teacher');

        $('#btnSaveTeacher')
            .text('Save Teacher');

        Helper.clearErrors(form);

        this.modal.show();

    },


    /*
    |--------------------------------------------------------------------------
    | Save Teacher
    |--------------------------------------------------------------------------
    */

    save() {

        const id =
            $('#teacher_id').val();

        if (id) {

            this.update();

            return;

        }

        this.store();

    },


    /*
    |--------------------------------------------------------------------------
    | Store Teacher
    |--------------------------------------------------------------------------
    */

    store() {

        Ajax.request({

            form: '#teacherForm',

            url: TEACHER_STORE_URL,

            method: 'POST',

            success: (response) => {

                this.modal.hide();

                $('#teacherForm')[0].reset();

                this.load();

            }

        });

    },


    /*
    |--------------------------------------------------------------------------
    | Edit Teacher
    |--------------------------------------------------------------------------
    */

    edit(id) {

        const url =
            TEACHER_EDIT_URL.replace(':id', id);


        Ajax.request({

            url: url,

            method: 'GET',

            data: {},

            success: (response) => {

                const teacher =
                    response.data;


                const user =
                    teacher.user;


                $('#teacher_id')
                    .val(teacher.id);


                $('#name')
                    .val(user.name);


                $('#email')
                    .val(user.email);


                $('#mobile')
                    .val(user.mobile);


                $('#employee_id')
                    .val(teacher.employee_id);


                $('#qualification')
                    .val(teacher.qualification);


                $('#specialization')
                    .val(teacher.specialization);


                $('#joining_date')
                    .val(
                        teacher.joining_date
                            ? teacher.joining_date.substring(0, 10)
                            : ''
                    );


                $('#dob')
                    .val(
                        teacher.dob
                            ? teacher.dob.substring(0, 10)
                            : ''
                    );


                $('#gender')
                    .val(teacher.gender);


                $('#experience_years')
                    .val(teacher.experience_years);


                $('#address')
                    .val(teacher.address);


                $('#city')
                    .val(teacher.city);


                $('#state')
                    .val(teacher.state);


                $('#pincode')
                    .val(teacher.pincode);


                $('#emergency_contact_name')
                    .val(
                        teacher.emergency_contact_name
                    );


                $('#emergency_contact_mobile')
                    .val(
                        teacher.emergency_contact_mobile
                    );


                $('#status')
                    .val(
                        user.status ? '1' : '0'
                    );


                $('#password')
                    .val('');


                $('#password_confirmation')
                    .val('');

                $('#profilePreview').attr(
                    'src',
                    user.profile_image_url
                );


                $('#teacherModalTitle')
                    .text('Edit Teacher');


                $('#btnSaveTeacher')
                    .text('Update Teacher');


                Helper.clearErrors(
                    $('#teacherForm')
                );


                this.modal.show();

            },

            error: (xhr) => {

                Toast.error(

                    xhr.responseJSON?.message ??

                    'Unable to fetch teacher details.'

                );

            }

        });

    },

    /*
    |--------------------------------------------------------------------------
    | View Teacher
    |--------------------------------------------------------------------------
    */
    view(id) {

        const url =
            TEACHER_SHOW_URL.replace(':id', id);


        Ajax.request({

            url: url,

            method: 'GET',

            data: {},

            success: (response) => {

                const teacher =
                    response.data;


                const user =
                    teacher.user;


                $('#viewProfileImage').attr(

                    'src',

                    user.profile_image_url
                        ? user.profile_image_url
                        : DEFAULT_AVATAR

                );

                $('.teacher-profile-header').css({
                    'background-image': `url(${user.profile_image_url})`,
                    'background-repeat': 'no-repeat',
                    'background-position': 'center',
                    // 'background-size': 'cover'
                });


                $('#viewName').text(
                    user.name ?? '-'
                );


                $('#viewEmployeeId').text(

                    teacher.employee_id
                        ? `Employee ID: ${teacher.employee_id}`
                        : 'Employee ID: -'

                );


                $('#viewEmail').text(
                    user.email ?? '-'
                );


                $('#viewMobile').text(
                    user.mobile ?? '-'
                );


                $('#viewQualification').text(
                    teacher.qualification ?? '-'
                );


                $('#viewSpecialization').text(
                    teacher.specialization ?? '-'
                );


                $('#viewGender').text(

                    teacher.gender
                        ? Helper.capitalize(
                            teacher.gender
                        )
                        : '-'

                );



                $('#viewDob').text(

                    Helper.formatDate(
                        teacher.dob
                    )

                );


                $('#viewJoiningDate').text(

                    Helper.formatDate(
                        teacher.joining_date
                    )

                );


                $('#viewExperience').text(

                    teacher.experience_years
                        ? `${teacher.experience_years} Years`
                        : '-'

                );


                $('#viewCity').text(
                    teacher.city ?? '-'
                );


                $('#viewState').text(
                    teacher.state ?? '-'
                );


                $('#viewPincode').text(
                    teacher.pincode ?? '-'
                );


                $('#viewAddress').text(
                    teacher.address ?? '-'
                );


                $('#viewEmergencyContactName').text(

                    teacher.emergency_contact_name
                    ?? '-'

                );


                $('#viewEmergencyContactMobile').text(

                    teacher.emergency_contact_mobile
                    ?? '-'

                );


                $('#viewStatus').html(

                    user.status

                        ? '<span class="badge bg-success">Active</span>'

                        : '<span class="badge bg-danger">Inactive</span>'

                );


                this.viewModal.show();

            },

            error: (xhr) => {

                Toast.error(

                    xhr.responseJSON?.message ??

                    'Unable to fetch teacher details.'

                );

            }

        });

    },
    /*
    |--------------------------------------------------------------------------
    | Update Teacher
    |--------------------------------------------------------------------------
    */

    update() {

        const id =
            $('#teacher_id').val();


        const url =
            TEACHER_UPDATE_URL.replace(
                ':id',
                id
            );


        Ajax.request({

            form: '#teacherForm',

            url: url,

            method: 'POST',

            extraData: {

                _method: 'PUT'

            },

            success: (response) => {

                this.modal.hide();

                $('#teacherForm')[0].reset();

                this.load();

            }

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

            url: TEACHER_STATUS_URL.replace(':id', id),

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

    },

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    destroy(id) {

        Swal.fire({

            title: 'Delete Academic Teacher?',

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

                url: TEACHER_DELETE_URL.replace(':id', id),

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

};


$(function () {

    Teacher.init();

});