const TeacherSubject = {

    modal: null,
    init() {

        this.modal = new bootstrap.Modal(
            document.getElementById('teacherSubjectModal')
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
        $('#btnAddTeacherSubject').on('click', () => {

            this.openCreate();

        });

        // Save Form
        $('#teacherSubjectForm').on('submit', (e) => {

            e.preventDefault();

            if ($('#teacher_subject_id').val() == '') {

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

            url: TEACHER_SUBJECT_LIST_URL,
            type: 'GET',
            data: $('#filterForm').serialize() + '&page=' + page,

            beforeSend: () => {

                $('#subjectTableBody').html(`

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
                console.log('load', response);

                this.render(response.data);
                this.renderPagination(response.data);
            },

            error: (e) => {
                Toast.error(e.responseJSON?.message ?? 'Unable to load Academic Teacher Subjects.');
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
                        No Academic Class Subjects Found
                    </td>
                </tr>
            `;

            $('#teacherSubjectTableBody').html(html);

            return;
        }

        rows.forEach((row, index) => {

            html += `
                <tr>

                    <td>${index + 1}</td>

                    <td>${row.teacher?.name ?? '-'}</td>

                    <td>${row.teacher?.teacher_profile?.employee_id ?? '-'}</td>

                    <td>${row.subject_class?.class_name ?? '-'}</td>

                    <td>${row.subject?.subject_name ?? '-'}</td>

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

        $('#teacherSubjectTableBody').html(html);
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

        $('#teacherSubjectPagination').html(html);
    },

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    openCreate() {

        const form =
            $('#teacherSubjectForm')[0];

        form.reset();
        Helper.clearErrors(form);
        $('#teacher_subject_id').val('');

        $('#teacherSubjectModalTitle').text('Add Acedemic Teacher Subject');

        $('#btnSaveClassSubject').html(
            '<i class="bi bi-check-lg"></i> Save teacher Subject'
        );

        Helper.clearErrors(form);

        this.modal.show();

    },


    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    store() {

        Ajax.request({

            form: '#teacherSubjectForm',
            method: 'POST',
            url: TEACHER_SUBJECT_STORE_URL,

            success: (Response) => {
                this.modal.hide();

                $('#teacherSubjectForm')[0].reset();

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

            form: '#teacherSubjectForm',
            url: TEACHER_SUBJECT_EDIT_URL.replace(':id', id),
            method: 'GET',

            success: (response) => {

                const subject = response.data;
                console.log('check', subject);

                Helper.clearErrors('#teacherSubjectForm');
                let $teachers = $('#form_teacher_id');
                $teachers.empty();
                $teachers.append('<option value="">Select Teacher</option>');
                $.each(subject.teacher_info, function (index, item) {
                    $('#form_teacher_id').append(
                        `<option value="${index}" ${index == subject.teacher_id ? 'selected' : ''}>${item}</option>`
                    );
                });

                let $class = $('#form_class_id');
                $class.empty();
                $class.append('<option value="">Select Class</option>');
                $.each(subject.class_info, function (index, item) {
                    $('#form_class_id').append(
                        `<option value="${index}" ${index == subject.class_id ? 'selected' : ''}>${item}</option>`
                    );
                });

                let $formsubject = $('#form_subject_id');
                $formsubject.empty();
                $formsubject.append('<option value="">Select Subject</option>');
                $.each(subject.subject_info, function (index, item) {
                    $('#form_subject_id').append(
                        `<option value="${index}" ${index == subject.subject_id ? 'selected' : ''}>${item}</option>`
                    );
                });

                let $formsection = $('#form_section_id');
                $formsection.empty();
                $formsection.append('<option value="">Select Section</option>');
                $.each(subject.sections_info, function (index, item) {
                    $('#form_section_id').append(
                        `<option value="${index}" ${index == subject.section_id ? 'selected' : ''}>${item}</option>`
                    );
                });

                $('#teacher_subject_id').val(subject.id);
                $('#status option[value="' + Number(subject.status) + '"]')
                    .prop('selected', true);

                $('#teacherSubjectModalTitle').text('Edit Academic Teacher Subject');

                $('#btnSaveClassSubject').html(
                    '<i class="bi bi-check-lg"></i> Update Teacher Subject'
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
        const id = $('#teacher_subject_id').val();
        // alert(id);
        let url = TEACHER_SUBJECT_UPDATE_URL.replace(':id', id);

        Ajax.request({

            form: '#teacherSubjectForm',

            url: url,

            method: 'POST',

            extraData: {
                _method: 'PUT'
            },

            success: (response) => {

                this.modal.hide();

                $('#teacherSubjectForm')[0].reset();

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

            title: 'Delete Academic Teacher subject?',

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

                url: TEACHER_SUBJECT_DELETE_URL.replace(':id', id),

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

            url: TEACHER_SUBJECT_STATUS_URL.replace(':id', id),

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

    TeacherSubject.init();

}); 