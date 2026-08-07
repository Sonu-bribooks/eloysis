const Student = {

    // modal: null,
    // viewModal: null,

    init() {


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
        | Reset
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
        | Pagination
        |--------------------------------------------------------------------------
        */

        $(document).on(
            'click',
            '#studentPagination .page-link',
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
       | Add Student
       |--------------------------------------------------------------------------
       */

        // $('#btnAddStudent').on(
        //     'click',
        //     () => {

        //         this.openCreateModal();

        //     }
        // );


        /*
        |--------------------------------------------------------------------------
        | Student Form Submit
        |--------------------------------------------------------------------------
        */

        $('#studentForm').on('submit', (e) => {

            e.preventDefault();

            const form = $('#studentForm');

            const action = form.attr('action');

            const method =
                form.find('input[name="_method"]').val()
                ?? 'POST';

            if (method === 'PUT') {
                this.update(action);
            } else {
                this.store(action);
            }
        });

        /*
        |--------------------------------------------------------------------------
        | Edit student
        |--------------------------------------------------------------------------
        */

        $(document).on(
            'click',
            '.btn-edit-student',
            (e) => {

                const id =
                    $(e.currentTarget).data('id');

                window.location.href = BASE_URL + '/admin/students/' + id + '/edit';

            }
        );

        /*
        |--------------------------------------------------------------------------
        | View Student
        |--------------------------------------------------------------------------
        */
        $(document).on(
            'click',
            '.btn-view-student',
            (e) => {

                const id =
                    $(e.currentTarget).data('id');

                window.location.href = BASE_URL + '/admin/students/' + id;

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
        $(document).on('click', '.btn-delete-student', (e) => {

            this.destroy($(e.currentTarget).data('id'));

        });


    },


    /*
    |--------------------------------------------------------------------------
    | Load Students
    |--------------------------------------------------------------------------
    */

    load(page = 1) {

        $.ajax({

            url: BASE_URL + '/admin/students/list',

            type: 'GET',

            data: {

                ...$('#filterForm').serializeArray()
                    .reduce(
                        (obj, item) => {

                            obj[item.name] =
                                item.value;

                            return obj;

                        },
                        {}
                    ),

                page: page,

            },


            success: (response) => {

                // this.renderByStudentProfile(
                //     response.data
                // );

                this.renderByStudentEnrollment(response.data);

            },


            error: (xhr) => {

                Toast.error(

                    xhr.responseJSON?.message ??

                    'Unable to load students.'

                );

            }

        });

    },


    /*
    |--------------------------------------------------------------------------
    | Render Students
    |--------------------------------------------------------------------------
    */

    // renderByStudentProfile(result) {

    //     const rows =
    //         result.data;


    //     let html = '';


    //     if (!rows.length) {

    //         html = `

    //             <tr>

    //                 <td
    //                     colspan="8"
    //                     class="text-center py-4">

    //                     No Students Found

    //                 </td>

    //             </tr>

    //         `;


    //         $('#studentTableBody')
    //             .html(html);


    //         $('#studentPagination')
    //             .html('');


    //         return;

    //     }


    //     rows.forEach(
    //         (row, index) => {

    //             const user =
    //                 row.user ?? {};


    //             const enrollment =
    //                 row.enrollments?.[0]
    //                 ?? {};


    //             const session =
    //                 enrollment.academic_session
    //                 ?? {};


    //             const studentClass =
    //                 enrollment.student_class
    //                 ?? {};


    //             const section =
    //                 enrollment.section
    //                 ?? {};


    //             const serialNumber =
    //                 result.from + index;


    //             const profileImage =
    //                 user.profile_image_url
    //                 ?? DEFAULT_AVATAR;


    //             html += `

    //                 <tr>

    //                     <td>

    //                         ${serialNumber}

    //                     </td>


    //                     <td>

    //                         <div
    //                             class="d-flex align-items-center">

    //                             <img
    //                                 src="${profileImage}"
    //                                 width="38"
    //                                 height="38"
    //                                 class="rounded-circle me-2"
    //                                 style="object-fit: cover;">

    //                             <div>

    //                                 <div
    //                                     class="fw-semibold">

    //                                     ${user.name ?? '-'}

    //                                 </div>

    //                                 <small
    //                                     class="text-muted">

    //                                     ${user.email ?? '-'}

    //                                 </small>

    //                             </div>

    //                         </div>

    //                     </td>

    //                     <td>

    //                         ${user.mobile ?? '-'}

    //                     </td>

    //                     <td>

    //                         ${session.name ?? '-'}

    //                     </td>

    //                     <td>

    //                         ${enrollment.roll_number ?? '-'}

    //                     </td>


    //                     <td>

    //                         ${studentClass.class_name ?? '-'}

    //                     </td>


    //                     <td>

    //                         ${section.name ?? '-'}

    //                     </td>


    //                     <td>
    //                          ${Helper.statusSwitch(row.id, user?.status)}

    //                     </td>


    //                     <td>

    //                         <button

    //                             type="button"

    //                             class="btn btn-sm btn-info btn-view-student"

    //                             data-id="${row.id}"

    //                             title="View">

    //                             <i
    //                                 class="bi bi-eye">

    //                             </i>

    //                         </button>


    //                         <button

    //                             type="button"

    //                             class="btn btn-sm btn-warning btn-edit-student"

    //                             data-id="${row.id}"
    //                             href="${BASE_URL + '/admin/students/' + row.id + '/edit'}"

    //                             title="Edit">

    //                             <i
    //                                 class="bi bi-pencil">

    //                             </i>

    //                         </button>


    //                         <button

    //                             type="button"

    //                             class="btn btn-sm btn-danger btn-delete-student"

    //                             data-id="${row.id}"

    //                             title="Delete">

    //                             <i
    //                                 class="bi bi-trash">

    //                             </i>

    //                         </button>

    //                     </td>

    //                 </tr>

    //             `;

    //         }

    //     );


    //     $('#studentTableBody')
    //         .html(html);


    //     this.renderPagination(result);

    // },

    renderByStudentEnrollment(result) {

        const rows =
            result.data;


        let html = '';


        if (!rows.length) {

            html = `

                <tr>

                    <td
                        colspan="8"
                        class="text-center py-4">

                        No Students Found for current Academic Session

                    </td>

                </tr>

            `;


            $('#studentTableBody')
                .html(html);


            $('#studentPagination')
                .html('');


            return;

        }


        rows.forEach(
            (row, index) => {

                const user =
                    row.student.user ?? {};


                const student_profile =
                    row.student
                    ?? {};


                const session =
                    row.academic_session
                    ?? {};


                const studentClass =
                    row.student_class
                    ?? {};


                const section =
                    row.section
                    ?? {};


                const serialNumber =
                    result.from + index;


                const profileImage =
                    user.profile_image_url
                    ?? DEFAULT_AVATAR;


                html += `

                    <tr>

                        <td>

                            ${serialNumber}

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

                            ${session.name ?? '-'}

                        </td>

                        <td>

                            ${row.roll_number ?? '-'}

                        </td>


                        <td>

                            ${studentClass.class_name ?? '-'}

                        </td>


                        <td>

                            ${section.name ?? '-'}

                        </td>


                        <td>
                             ${Helper.statusSwitch(row.id, user?.status)}
                           
                        </td>


                        <td>

                            <button

                                type="button"

                                class="btn btn-sm btn-info btn-view-student"

                                data-id="${row.id}"

                                title="View">

                                <i
                                    class="bi bi-eye">

                                </i>

                            </button>


                            <button

                                type="button"

                                class="btn btn-sm btn-warning btn-edit-student"

                                data-id="${row.id}"
                                href="${BASE_URL + '/admin/students/' + row.id + '/edit'}"

                                title="Edit">

                                <i
                                    class="bi bi-pencil">

                                </i>

                            </button>


                            <button

                                type="button"

                                class="btn btn-sm btn-danger btn-delete-student"

                                data-id="${row.id}"

                                title="Delete">

                                <i
                                    class="bi bi-trash">

                                </i>

                            </button>

                        </td>

                    </tr>

                `;

            }

        );


        $('#studentTableBody')
            .html(html);


        this.renderPagination(result);

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

            }

        );


        $('#studentPagination')
            .html(html);

    },

    /*
    |--------------------------------------------------------------------------
    | Open Create Modal
    |--------------------------------------------------------------------------
    */

    // openCreateModal() {

    //     const form =
    //         $('#studentForm')[0];


    //     form.reset();


    //     $('#student_id')
    //         .val('');


    //     $('#studentModalTitle')
    //         .text('Add Student');


    //     $('#btnSaveStudent')
    //         .text('Save Student');


    //     // /*
    //     // |--------------------------------------------------------------------------
    //     // | Default Status
    //     // |--------------------------------------------------------------------------
    //     // */

    //     // $('#status')
    //     //     .val('1');


    //     /*
    //     |--------------------------------------------------------------------------
    //     | Clear File Preview
    //     |--------------------------------------------------------------------------
    //     */

    //     $('#profile_image_preview')
    //         .attr(
    //             'src',
    //             DEFAULT_AVATAR
    //         );


    //     this.modal.show();

    // },


    /*
    |--------------------------------------------------------------------------
    | Create Student
    |--------------------------------------------------------------------------
    */

    store(url) {

        Ajax.request({

            form: '#studentForm',

            url: url,

            method: 'POST',

            success: (response) => {

                $('#studentForm')[0]
                    .reset();


                Toast.success(

                    response.message ?? 'Student created successfully.'

                );


                window.location.href = BASE_URL + '/admin/students';

            }

        });

    },

    /*
    |--------------------------------------------------------------------------
    | Update Student
    |--------------------------------------------------------------------------
    */

    update(url) {


        Ajax.request({

            form: '#studentForm',

            url: url,

            method: 'POST',

            extraData: {

                _method: 'PUT'

            },

            success: (response) => {

                $('#studentForm')[0].reset();
                Toast.success(

                    response.message

                    ??

                    'Student Updated successfully.'

                );
                window.location.href = BASE_URL + '/admin/students';

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

            url: BASE_URL + '/admin/students/' + id + '/status',

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

            title: 'Delete Student?',

            text: 'This action cannot be undone and delete User Profile',

            icon: 'warning',

            showCancelButton: true,

            confirmButtonText: 'Yes, Delete',

            cancelButtonText: 'Cancel',

        }).then((result) => {

            if (!result.isConfirmed) {

                return;

            }

            Ajax.request({

                url: BASE_URL + '/admin/students/' + id,

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

    Student.init();

});