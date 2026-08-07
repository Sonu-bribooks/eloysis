<?php

namespace App\Repositories\Admin;

use App\Models\StudentEnrollment;
use App\Repositories\BaseRepository;

class StudentPromotionRepository extends BaseRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(StudentEnrollment $model)
    {
        parent::__construct($model);
    }

    /**
     * Get students for promotion
     */
    public function getStudents(array $filters = [])
    {
        $query = $this->query()
            ->with([
                'student.user:id,name,email,mobile,profile_image,status',
                'academicSession:id,name',
                'studentClass:id,class_name',
                'section:id,name',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Current Session
        |--------------------------------------------------------------------------
        */

        if (!empty($filters['academic_session_id'])) {

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

        if (!empty($filters['class_id'])) {

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

        if (!empty($filters['section_id'])) {

            $query->where(
                'section_id',
                $filters['section_id']
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if (!empty($filters['search'])) {

            $search = $filters['search'];

            $query->where(function ($q) use ($search) {

                $q->where(
                    'roll_number',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'admission_no',
                    'like',
                    "%{$search}%"
                )

                ->orWhereHas('student.user', function ($query) use ($search) {

                    $query->where(
                        'name',
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
     * Check student already promoted
     */
    public function alreadyEnrolled(
        int $studentProfileId,
        int $academicSessionId
    ): bool {

        return $this->query()

            ->where(
                'stu_profile_id',
                $studentProfileId
            )

            ->where(
                'academic_session_id',
                $academicSessionId
            )

            ->exists();

    }
}
