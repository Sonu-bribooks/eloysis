const Attendance = {

    students: [],


    /*
    |--------------------------------------------------------------------------
    | Initialize
    |--------------------------------------------------------------------------
    */

    init() {

        this.bindEvents();

        this.setDefaultDate();

    },


    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */

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
        | Save Attendance - Top
        |--------------------------------------------------------------------------
        */

        $('#btnSaveAttendance').on('click', () => {

            this.saveAttendance();

        });


        /*
        |--------------------------------------------------------------------------
        | Save Attendance - Bottom
        |--------------------------------------------------------------------------
        */

        $('#btnSaveAttendanceBottom').on('click', () => {

            this.saveAttendance();

        });


        /*
        |--------------------------------------------------------------------------
        | Mark All Present
        |--------------------------------------------------------------------------
        */

        $('#btnMarkAllPresent').on('click', () => {

            this.markAll('present');

        });


        /*
        |--------------------------------------------------------------------------
        | Mark All Absent
        |--------------------------------------------------------------------------
        */

        $('#btnMarkAllAbsent').on('click', () => {

            this.markAll('absent');

        });


        /*
        |--------------------------------------------------------------------------
        | Individual Attendance Status
        |--------------------------------------------------------------------------
        */

        $(document).on(
            'click',
            '.attendance-status-btn',
            (e) => {

                const button =
                    $(e.currentTarget);

                const status =
                    button.data('status');

                const row =
                    button.closest('.attendance-row');


                this.setRowStatus(
                    row,
                    status
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Remarks
        |--------------------------------------------------------------------------
        */

        $(document).on(
            'input',
            '.attendance-remarks',
            () => {

                this.updateSummary();

            }
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Default Date
    |--------------------------------------------------------------------------
    */

    setDefaultDate() {

        if (!$('#attendance_date').val()) {

            const today = new Date();

            const date =
                today.toISOString()
                    .split('T')[0];

            $('#attendance_date').val(date);

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Load Students
    |--------------------------------------------------------------------------
    */

    loadStudents(page = 1) {

        const sessionId =
            $('#academic_session_id').val();

        const classId =
            $('#class_id').val();

        const sectionId =
            $('#section_id').val();

        const date =
            $('#attendance_date').val();


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        if (!sessionId) {

            Toast.error(
                'Please select academic session.'
            );

            return;

        }


        if (!classId) {

            Toast.error(
                'Please select class.'
            );

            return;

        }


        if (!date) {

            Toast.error(
                'Please select attendance date.'
            );

            return;

        }


        const data = {

            academic_session_id:
                sessionId,

            class_id:
                classId,

            section_id:
                sectionId,

            attendance_date:
                date

        };


        Ajax.request({

            url:
                ATTENDANCE_STUDENTS_URL,

            method: 'GET',

            data: $('#filterForm').serialize() + '&page=' + page,

            success:
                (response) => {

                    this.students =
                        response.data || [];

                    this.renderStudents(
                        this.students
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


        /*
        |--------------------------------------------------------------------------
        | Empty State
        |--------------------------------------------------------------------------
        */

        if (!students.length) {

            html = `

                <tr>

                    <td
                        colspan="7"
                        class="text-center text-muted py-5">

                        <i
                            class="bi bi-person-x fs-3 d-block mb-2">
                        </i>

                        No students found for the
                        selected criteria.

                    </td>

                </tr>

            `;


            $('#attendanceTableBody')
                .html(html);


            this.setActionButtons(false);


            $('#attendanceSummary')
                .text('No students found.');


            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Render Rows
        |--------------------------------------------------------------------------
        */

        students.forEach((enrollment, index) => {

            const student =
                enrollment.student;

            const user =
                student?.user;


            /*
            |--------------------------------------------------------------------------
            | Existing Attendance
            |--------------------------------------------------------------------------
            */

            const attendance =
                enrollment.attendances?.[0];


            const status =
                attendance?.status || 'present';


            const remarks =
                attendance?.remarks || '';


            /*
            |--------------------------------------------------------------------------
            | Profile Image
            |--------------------------------------------------------------------------
            */

            let profileImage = '';


            if (user?.profile_image_url) {

                profileImage = `

                    <img
                        src="${this.escapeHtml(
                    user.profile_image_url
                )}"
                        class="student-avatar"
                        alt="Student">

                `;

            } else {

                profileImage = `

                    <div
                        class="student-avatar-placeholder">

                        <i class="bi bi-person"></i>

                    </div>

                `;

            }


            /*
            |--------------------------------------------------------------------------
            | Attendance Buttons
            |--------------------------------------------------------------------------
            */

            const statusHtml = `

                <input
                    type="hidden"
                    class="attendance-status"
                    value="${this.escapeHtml(status)}">


                <div
                    class="attendance-status-group">

                    ${this.statusButton(
                'present',
                'Present',
                'bi-check-circle',
                status
            )}

                    ${this.statusButton(
                'absent',
                'Absent',
                'bi-x-circle',
                status
            )}

                    ${this.statusButton(
                'late',
                'Late',
                'bi-clock',
                status
            )}

                    ${this.statusButton(
                'leave',
                'Leave',
                'bi-calendar-x',
                status
            )}

                </div>

            `;


            /*
            |--------------------------------------------------------------------------
            | Student Row
            |--------------------------------------------------------------------------
            */

            html += `

                <tr
                    class="attendance-row"
                    data-enrollment-id="${enrollment.id}">

                    <td>

                        ${index + 1}

                    </td>


                    <td>

                        ${profileImage}

                    </td>


                    <td>

                        <strong>

                            ${this.escapeHtml(
                user?.name ?? '-'
            )}

                        </strong>

                    </td>


                    <td>

                        ${this.escapeHtml(
                student?.admission_no ?? '-'
            )}

                    </td>


                    <td>

                        ${this.escapeHtml(
                enrollment.roll_number ?? '-'
            )}

                    </td>


                    <td>

                        ${statusHtml}

                    </td>


                    <td>

                        <input
                            type="text"
                            class="form-control attendance-remarks"
                            value="${this.escapeHtml(remarks)}"
                            placeholder="Remarks">

                    </td>

                </tr>

            `;

        });


        $('#attendanceTableBody')
            .html(html);


        this.setActionButtons(true);

        this.updateSummary();

    },


    /*
    |--------------------------------------------------------------------------
    | Status Button
    |--------------------------------------------------------------------------
    */

    statusButton(
        value,
        label,
        icon,
        currentStatus
    ) {

        const active =
            currentStatus === value
                ? 'active'
                : '';


        return `

            <button
                type="button"
                class="btn btn-outline-secondary attendance-status-btn ${active}"
                data-status="${value}">

                <i class="bi ${icon} me-1"></i>

                ${label}

            </button>

        `;

    },


    /*
    |--------------------------------------------------------------------------
    | Set Row Status
    |--------------------------------------------------------------------------
    */

    setRowStatus(row, status) {

        /*
        |--------------------------------------------------------------------------
        | Hidden status field
        |--------------------------------------------------------------------------
        */

        row.find('.attendance-status')
            .val(status);


        /*
        |--------------------------------------------------------------------------
        | Active button
        |--------------------------------------------------------------------------
        */

        row.find('.attendance-status-btn')
            .removeClass('active');


        row.find(
            `.attendance-status-btn[data-status="${status}"]`
        )
            .addClass('active');


        /*
        |--------------------------------------------------------------------------
        | Update Counter
        |--------------------------------------------------------------------------
        */

        this.updateSummary();

    },


    /*
    |--------------------------------------------------------------------------
    | Mark All
    |--------------------------------------------------------------------------
    */

    markAll(status) {

        const rows =
            $('.attendance-row');


        if (!rows.length) {

            return;

        }


        rows.each((index, element) => {

            this.setRowStatus(
                $(element),
                status
            );

        });


        this.updateSummary();

    },


    /*
    |--------------------------------------------------------------------------
    | Action Buttons
    |--------------------------------------------------------------------------
    */

    setActionButtons(enabled) {

        $('#btnSaveAttendance')
            .prop('disabled', !enabled);

        $('#btnSaveAttendanceBottom')
            .prop('disabled', !enabled);

        $('#btnMarkAllPresent')
            .prop('disabled', !enabled);

        $('#btnMarkAllAbsent')
            .prop('disabled', !enabled);

    },


    /*
    |--------------------------------------------------------------------------
    | Update Summary
    |--------------------------------------------------------------------------
    */

    updateSummary() {

        const rows =
            $('.attendance-row');


        const total =
            rows.length;


        let present = 0;

        let absent = 0;

        let late = 0;

        let leave = 0;


        rows.each(function () {

            const status =
                $(this)
                    .find('.attendance-status')
                    .val();


            switch (status) {

                case 'present':

                    present++;

                    break;


                case 'absent':

                    absent++;

                    break;


                case 'late':

                    late++;

                    break;


                case 'leave':

                    leave++;

                    break;

            }

        });


        $('#attendanceSummary').html(`

            <span class="me-3">
                Total:
                <strong>${total}</strong>
            </span>

            <span class="text-success me-3">
                Present:
                <strong>${present}</strong>
            </span>

            <span class="text-danger me-3">
                Absent:
                <strong>${absent}</strong>
            </span>

            <span class="text-warning me-3">
                Late:
                <strong>${late}</strong>
            </span>

            <span class="text-info">
                Leave:
                <strong>${leave}</strong>
            </span>

        `);

    },


    /*
    |--------------------------------------------------------------------------
    | Save Attendance
    |--------------------------------------------------------------------------
    */

    saveAttendance() {


        const rows =
            $('.attendance-row');


        if (!rows.length) {

            Toast.error(
                'No students available.'
            );

            return;

        }


        const attendance = [];


        rows.each(function () {

            const row =
                $(this);


            const enrollmentId =
                row.data('enrollment-id');


            const status =
                row.find('.attendance-status')
                    .val();


            const remarks =
                row.find('.attendance-remarks')
                    .val();


            attendance.push({

                student_enrollment_id:
                    enrollmentId,

                status:
                    status,

                remarks:
                    remarks || null

            });

        });


        const data = {

            academic_session_id:
                $('#academic_session_id').val(),

            class_id:
                $('#class_id').val(),

            section_id:
                $('#section_id').val(),

            attendance_date:
                $('#attendance_date').val(),

            attendance:
                attendance

        };

        console.log('attendance data', data);

        Ajax.request({

            url:
                ATTENDANCE_SAVE_URL,

            method:
                'POST',

            data:
                data,

            success:
                (response) => {

                    Toast.success(
                        response.message
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Reload
                    |--------------------------------------------------------------------------
                    */

                    this.loadStudents();

                }

        });

    },


    /*
    |--------------------------------------------------------------------------
    | Escape HTML
    |--------------------------------------------------------------------------
    */

    escapeHtml(value) {

        if (
            value === null ||
            value === undefined
        ) {

            return '';

        }


        return String(value)

            .replace(
                /&/g,
                '&amp;'
            )

            .replace(
                /</g,
                '&lt;'
            )

            .replace(
                />/g,
                '&gt;'
            )

            .replace(
                /"/g,
                '&quot;'
            )

            .replace(
                /'/g,
                '&#039;'
            );

    }

};


/*
|--------------------------------------------------------------------------
| Initialize
|--------------------------------------------------------------------------
*/

$(function () {

    Attendance.init();

});