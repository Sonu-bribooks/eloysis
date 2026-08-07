<?php

namespace App\Repositories\Admin;

use App\Models\StudentProfile;
use App\Repositories\BaseRepository;

class StudentRepository extends BaseRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(StudentProfile $student)
    {
        parent::__construct($student);
    }

     /**
     * Get paginated students
     */
    public function getList(array $filters = [])
    {
        $query = $this->model
            ->with([
                'user:id,name,email,mobile,profile_image,status',

                'enrollments' => function ($query) {

                    $query->with([
                        'academicSession:id,name',
                        'studentClass:id,class_name',
                        'section:id,name',
                    ])
                    ->latest('id');

                },

            ]);

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if (!empty($filters['search'])) {

            $search = $filters['search'];

            $query->where(function ($query) use ($search) {

                $query->where('admission_no', 'like', "%{$search}%")

                    // ->orWhere('roll_number', 'like', "%{$search}%")

                    ->orWhereHas('user', function ($query) use ($search) {

                        $query->where('name', 'like', "%{$search}%")

                            ->orWhere('email', 'like', "%{$search}%")

                            ->orWhere('mobile', 'like', "%{$search}%");

                    });

            });

        }


        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if (
            isset($filters['status'])
            && $filters['status'] !== ''
        ) {

            $query->whereHas('user', function ($query) use ($filters) {

                $query->where(
                    'status',
                    $filters['status']
                );

            });

        }


        /*
        |--------------------------------------------------------------------------
        | Academic Session
        |--------------------------------------------------------------------------
        */

        if (!empty($filters['academic_session_id'])) {

            $query->whereHas('enrollments', function ($query) use ($filters) {

                $query->where(
                    'academic_session_id',
                    $filters['academic_session_id']
                );

            });

        }


        /*
        |--------------------------------------------------------------------------
        | Class
        |--------------------------------------------------------------------------
        */

        if (!empty($filters['class_id'])) {

            $query->whereHas('enrollments', function ($query) use ($filters) {

                $query->where(
                    'class_id',
                    $filters['class_id']
                );

            });

        }


        /*
        |--------------------------------------------------------------------------
        | Section
        |--------------------------------------------------------------------------
        */

        if (!empty($filters['section_id'])) {

            $query->whereHas('enrollments', function ($query) use ($filters) {

                $query->where(
                    'section_id',
                    $filters['section_id']
                );

            });

        }


        return $query
            ->latest('id')
            ->paginate(
                $filters['per_page'] ?? 10
            );

    }


    /**
     * Find student with relations
     */
    public function findWithRelations(int $id)
    {
        return $this->model
            ->with([
                'user',
                'enrollments.academicSession',
                'enrollments.studentClass',
                'enrollments.section',
            ])
            ->find($id);
    }
}
