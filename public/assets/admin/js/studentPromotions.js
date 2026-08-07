const StudentPromotion = {

    summaryModal: null,
    init() {

        this.summaryModal = new bootstrap.Modal(
            document.getElementById('summaryModal')
        );

        this.bindEvents();

    },

    bindEvents() {

        /*
        |--------------------------------------------------------------------------
        | Load Students
        |--------------------------------------------------------------------------
        */

        $('#filterForm').on('submit', (e) => {

            e.preventDefault();

            this.loadStudents();

        });


        /*
        |--------------------------------------------------------------------------
        | Promote Students
        |--------------------------------------------------------------------------
        */

        $('#promotionForm').on('submit', (e) => {

            e.preventDefault();

            this.promote();

        });


        /*
        |--------------------------------------------------------------------------
        | Select All
        |--------------------------------------------------------------------------
        */

        $(document).on('change', '#selectAll', function () {

            $('.student-checkbox').prop(
                'checked',
                $(this).is(':checked')
            );

        });


        /*
        |--------------------------------------------------------------------------
        | Row Checkbox
        |--------------------------------------------------------------------------
        */

        $(document).on('change', '.student-checkbox', function () {

            $('#selectAll').prop(

                'checked',

                $('.student-checkbox').length === $('.student-checkbox:checked').length

            );

        });

    },



    /*
    |--------------------------------------------------------------------------
    | Load Students
    |--------------------------------------------------------------------------
    */

    loadStudents() {

        Ajax.request({

            url: STUDENT_LOAD_URL,

            method: 'GET',

            data: $('#filterForm').serialize(),

            beforeSend: () => {

                $('#studentTableBody').html(`

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

                this.renderStudents(
                    response.data
                );

            }

        });

    },



    /*
    |--------------------------------------------------------------------------
    | Render Students
    |--------------------------------------------------------------------------
    */

    renderStudents(students) {

        let html = '';

        if (students.length === 0) {

            html = `

                <tr>

                    <td colspan="7" class="text-center">

                        No students found.

                    </td>

                </tr>

            `;

            $('#studentTableBody').html(html);

            return;

        }


        students.forEach(student => {

            let user = student.student.user;

            let image = user.profile_image

                ? `<img src="${user.profile_image_url}"
                        class="rounded-circle"
                        width="40"
                        height="40">`

                : `<i class="bi bi-person-circle fs-3"></i>`;


            html += `

                <tr>

                    <td>

                        <input

                            type="checkbox"

                            class="form-check-input student-checkbox"

                            value="${student.id}">

                    </td>

                    <td>

                        ${image}

                    </td>

                    <td>

                        ${user.name}

                    </td>

                    <td>

                        ${student.academic_session.name}

                    </td>

                    <td>

                        ${student.student.admission_no}

                    </td>

                    <td>

                        ${student.roll_number ?? '-'}

                    </td>

                    <td>

                        ${student.student_class.class_name}

                    </td>

                    <td>

                        ${student.section.name}

                    </td>

                </tr>

            `;

        });

        $('#studentTableBody').html(html);

    },



    /*
    |--------------------------------------------------------------------------
    | Promote
    |--------------------------------------------------------------------------
    */

    promote() {

        let enrollmentIds = [];

        $('.student-checkbox:checked').each(function () {

            enrollmentIds.push(
                $(this).val()
            );

        });

        if (enrollmentIds.length === 0) {

            Toast.error(
                'Please select at least one student.'
            );

            return;

        }

        const formData = new FormData(
            $('#promotionForm')[0]
        );

        enrollmentIds.forEach(id => {

            formData.append(
                'enrollment_ids[]',
                id
            );

        });

        Swal.fire({

            title: 'Promote Students?',

            text: 'This action will create new enrollments.',

            icon: 'warning',

            showCancelButton: true

        }).then((result) => {

            if (result.isConfirmed) {

                Ajax.request({

                    form: '#promotionForm',

                    url: STUDENT_PROMOTE_URL,

                    method: 'POST',

                    data: formData,

                    beforeSend: () => {

                        $('#studentTableBody').html(`

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

                        // Toast.success(
                        //     response.message
                        // );

                        $('#selectAll').prop(
                            'checked',
                            false
                        );

                        this.loadStudents();
                        this.renderSummary(response.data);


                    }

                });

            }

        });


    },

    /*
        |--------------------------------------------------------------------------
        | promoted summary 
        |--------------------------------------------------------------------------
        */

    renderSummary(data) {

        $('#summaryTotal').text(data.total);

        $('#summaryPromoted').text(data.promoted);

        $('#summarySkipped').text(data.skipped.length);


        if (data.skipped.length === 0) {

            $('#summaryAlert').html(`

                <div class="alert alert-success">

                    <i class="bi bi-check-circle-fill"></i>

                    All students promoted successfully.

                </div>

            `);

            $('#skippedContainer').hide();

        } else {

            $('#summaryAlert').html(`

                <div class="alert alert-warning">

                    <i class="bi bi-exclamation-triangle-fill"></i>

                    Some students could not be promoted.

                </div>

            `);

            let html = '';

            data.skipped.forEach((row, index) => {

                html += `

                    <tr>

                        <td>${index + 1}</td>

                        <td>${row.name}</td>

                        <td>${row.reason}</td>

                    </tr>

                `;

            });

            $('#summaryTableBody').html(html);

            $('#skippedContainer').show();

        }

        this.summaryModal.show();

    }

};


$(function () {

    StudentPromotion.init();

});