<?php

namespace App\Repositories\Admin;

use App\Models\StudentAttendance;
use App\Models\StudentEnrollment;
use App\Repositories\BaseRepository;

class StudentAttendanceRepository extends BaseRepository
{
    protected StudentEnrollment $enrollmentModel;

    /**
     * Create a new class instance.
     */
    public function __construct(
        StudentAttendance $model,
        StudentEnrollment $enrollmentModel
    ) {
        parent::__construct($model);

        $this->enrollmentModel = $enrollmentModel;
    }

    /**
     * Get students for attendance
     */
    public function getStudents(array $filters = [])
    {
        $query = $this->enrollmentModel
            ->with([
                'student.user:id,name,email,mobile,profile_image,status',

                'academicSession:id,name',

                'studentClass:id,class_name',

                'section:id,name',

                'attendances' => function ($query) use ($filters) {

                    if (! empty($filters['attendance_date'])) {

                        $query->where(
                            'attendance_date',
                            $filters['attendance_date']
                        );

                    }

                },
            ]);

        /*
        |--------------------------------------------------------------------------
        | Academic Session
        |--------------------------------------------------------------------------
        */

        if (! empty($filters['academic_session_id'])) {

            $query->where(
                'academic_session_id',
                $filters['academic_session_id']
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Class
        |--------------------------------------------------------------------------
        */

        if (! empty($filters['class_id'])) {

            $query->where(
                'class_id',
                $filters['class_id']
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Section
        |--------------------------------------------------------------------------
        */

        if (! empty($filters['section_id'])) {

            $query->where(
                'section_id',
                $filters['section_id']
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Active Enrollment
        |--------------------------------------------------------------------------
        */

        $query->where('status', 1);

        /*
        |--------------------------------------------------------------------------
        | Student Search
        |--------------------------------------------------------------------------
        */

        if (! empty($filters['search'])) {

            $search = $filters['search'];

            $query->where(function ($query) use ($search) {

                $query->where(
                    'roll_number',
                    'like',
                    "%{$search}%"
                )
                    ->orWhereHas('student', function ($query) use ($search) {

                        $query->where(
                            'admission_no',
                            'like',
                            "%{$search}%"
                        );

                    })
                    ->orWhereHas('student.user', function ($query) use ($search) {

                        $query->where('name', 'like', "%{$search}%")

                            ->orWhere(
                                'email',
                                'like',
                                "%{$search}%"
                            )

                            ->orWhere(
                                'mobile',
                                'like',
                                "%{$search}%"
                            );

                    });

            });

        }

        return $query
            ->orderBy('roll_number')
            ->get();
    }

    /**
     * Get attendance for a particular enrollment and date
     */
    public function getAttendance(
        int $enrollmentId,
        string $date
    ) {
        return $this->model
            ->where(
                'student_enrollment_id',
                $enrollmentId
            )
            ->where(
                'attendance_date',
                $date
            )
            ->first();
    }

    /**
     * Save or update attendance
     */
    public function saveAttendance(
        int $enrollmentId,
        string $date,
        array $data
    ) {
        return $this->model->updateOrCreate(

            [
                'student_enrollment_id' => $enrollmentId,

                'attendance_date' => $date,
            ],

            [
                'status' => $data['status'],

                'remarks' => $data['remarks'] ?? null,
            ]

        );
    }

    /**
     * Get attendance history
     */
    public function getHistory(array $filters = [])
    {
        $query = $this->model
            ->with([
                'enrollment.student.user:id,name,email,mobile,profile_image',

                'enrollment.academicSession:id,name',

                'enrollment.studentClass:id,class_name',

                'enrollment.section:id,name',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Date
        |--------------------------------------------------------------------------
        */

        if (! empty($filters['attendance_date'])) {

            $query->where(
                'attendance_date',
                $filters['attendance_date']
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Academic Session
        |--------------------------------------------------------------------------
        */

        if (! empty($filters['academic_session_id'])) {

            $query->whereHas(
                'enrollment',
                function ($query) use ($filters) {

                    $query->where(
                        'academic_session_id',
                        $filters['academic_session_id']
                    );

                }
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Class
        |--------------------------------------------------------------------------
        */

        if (! empty($filters['class_id'])) {

            $query->whereHas(
                'enrollment',
                function ($query) use ($filters) {

                    $query->where(
                        'class_id',
                        $filters['class_id']
                    );

                }
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Section
        |--------------------------------------------------------------------------
        */

        if (! empty($filters['section_id'])) {

            $query->whereHas(
                'enrollment',
                function ($query) use ($filters) {

                    $query->where(
                        'section_id',
                        $filters['section_id']
                    );

                }
            );

        }

        return $query
            ->latest('attendance_date')
            ->paginate(
                $filters['per_page'] ?? 20
            );
    }
}
