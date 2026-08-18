<?php

namespace App\Repositories\Admin;

use App\Models\StudentEnrollment;
use App\Repositories\BaseRepository;

class StudentEnrollmentRepository extends BaseRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(StudentEnrollment $studentEnrollment)
    {
        parent::__construct($studentEnrollment);
    }

    public function getList(
        array $filters = [],
        int $perPage = 10,
        int $page = 1,
        ?int $orderColumn = null,
        string $orderDirection = 'asc'
    ) {
        $sortableColumns = [
            1 => 'student_id',
            3 => 'academic_session_id',
            4 => 'roll_number',
            5 => 'class_id',
            6 => 'section_id',
        ];

        $query = $this->model
            ->with([
                'student.user:id,name,email,mobile,profile_image,status',
                'academicSession:id,name,is_current',
                'studentClass:id,class_name',
                'section:id,name',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Current Academic Session
        |--------------------------------------------------------------------------
        */

        if (! empty($filters['academic_session_id'])) {

            $query->where(
                'academic_session_id',
                $filters['academic_session_id']
            );

        } else {

            // By default current session
            $query->whereHas('academicSession', function ($q) {

                $q->where('is_current', 1);

            });

        }

        /*
        |--------------------------------------------------------------------------
        | Search
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
                    ->orWhereHas('student.user', function ($query) use ($search) {

                        $query->where(
                            'name',
                            'like',
                            "%{$search}%"
                        )
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

        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        if (
            isset($filters['status']) &&
            $filters['status'] !== ''
        ) {

            $query->whereHas('student.user', function ($query) use ($filters) {

                $query->where(
                    'status',
                    $filters['status']
                );

            });

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

        if ($orderColumn !== null && isset($sortableColumns[$orderColumn])) {
            $query->orderBy($sortableColumns[$orderColumn], $orderDirection === 'desc' ? 'desc' : 'asc');
        } else {
            $query->latest('id');
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Find enrollment with relations
     */
    public function findWithRelations(int $id)
    {
        return $this->model
            ->with([
                'student.user',
                'academicSession',
                'studentClass',
                'section',
            ])
            ->find($id);
    }
}
