const ClassSubject = {

    modal: null,
    init() {

        this.modal = new bootstrap.Modal(
            document.getElementById('classSubjectModal')
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
        $('#btnAddClassSubject').on('click', () => {

            this.openCreate();

        });

        // Save Form
        $('#classSubjectForm').on('submit', (e) => {

            e.preventDefault();

            if ($('#class_subject_id').val() == '') {

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

            url: CLASS_SUBJECT_LIST_URL,
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
                console.log(response);

                this.render(response.data);
                this.renderPagination(response.data);
            },

            error: (e) => {
                Toast.error(e.responseJSON?.message ?? 'Unable to load Academic Class Subjects.');
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

            $('#classSubjectTableBody').html(html);

            return;
        }

        rows.forEach((row, index) => {

            html += `
                <tr>

                    <td>${index + 1}</td>

                    <td>${row.subject_class.class_name}</td>

                    <td>${row.subject.subject_name}</td>

                    <td>${row.subject.subject_code}</td>

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

        $('#classSubjectTableBody').html(html);
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

        $('#classSubjectPagination').html(html);
    },

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    openCreate() {

        const form =
            $('#classSubjectForm')[0];

        form.reset();

        $('#class_subject_id').val('');

        $('#classSubjectModalTitle').text('Add Acedemic Class Subject');

        $('#btnSaveClassSubject').html(
            '<i class="bi bi-check-lg"></i> Save Class Subject'
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

            form: '#classSubjectForm',
            method: 'POST',
            url: CLASS_SUBJECT_STORE_URL,

            success: (Response) => {
                this.modal.hide();

                $('#classSubjectForm')[0].reset();

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

            form: '#classSubjectForm',
            url: CLASS_SUBJECT_EDIT_URL.replace(':id', id),
            method: 'GET',

            success: (response) => {

                const subject = response.data;
                console.log('check', subject);

                Helper.clearErrors('#classSubjectForm');
                let $class = $('#sub_class_id');
                $class.empty();
                $class.append('<option value="">Select Class</option>');
                $.each(subject.class_info, function (index, item) {
                    $('#sub_class_id').append(
                        `<option value="${index}" ${index == subject.class_id ? 'selected' : ''}>${item}</option>`
                    );
                });

                let $formsubject = $('#form_subject_id');
                $formsubject.empty();
                $.each(subject.subject_info, function (index, item) {
                    $('#form_subject_id').append(
                        `<option value="${index}" ${index == subject.subject_id ? 'selected' : ''}>${item}</option>`
                    );
                });

                $('#class_subject_id').val(subject.id);
                $('#status option[value="' + Number(subject.status) + '"]')
                    .prop('selected', true);

                $('#classSubjectModalTitle').text('Edit Academic Class Subject');

                $('#btnSaveClassSubject').html(
                    '<i class="bi bi-check-lg"></i> Update Class Subject'
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
        const id = $('#class_subject_id').val();
        // alert(id);
        let url = CLASS_SUBJECT_UPDATE_URL.replace(':id', id);

        Ajax.request({

            form: '#classSubjectForm',

            url: url,

            method: 'POST',

            extraData: {
                _method: 'PUT'
            },

            success: (response) => {

                this.modal.hide();

                $('#classSubjectForm')[0].reset();

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

            title: 'Delete Academic Class subject?',

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

                url: CLASS_SUBJECT_DELETE_URL.replace(':id', id),

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

            url: CLASS_SUBJECT_STATUS_URL.replace(':id', id),

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

    ClassSubject.init();

}); 