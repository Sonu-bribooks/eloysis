<?php

namespace App\Services\Admin;

use App\Repositories\Admin\StudentPromotionRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class StudentPromotionService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected StudentPromotionRepository $promotionRepository)
    {
        //
    }

     /**
     * Get students for promotion
     */
    public function students(array $filters)
    {
        // dd($filters);
        return $this->promotionRepository->getStudents($filters);
    }

    /**
     * Promote students
     */
    public function promote(array $data): array
    {
        $promoted = 0;
        $skipped  = [];

        DB::transaction(function () use ($data, &$promoted, &$skipped) {

            foreach ($data['enrollment_ids'] as $enrollmentId) {

                $enrollment = $this->promotionRepository->find($enrollmentId);

                if (!$enrollment) {
                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | Already promoted?
                |--------------------------------------------------------------------------
                */

                $alreadyExists = $this->promotionRepository->alreadyEnrolled(
                    $enrollment->stu_profile_id,
                    $data['target_academic_session_id']
                );

                if ($alreadyExists) {

                    $skipped[] = [
                        'student_id' => $enrollment->stu_profile_id,
                        'name'       => optional($enrollment->student->user)->name,
                        'reason'     => 'Already enrolled in selected session.',
                    ];

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | Create New Enrollment
                |--------------------------------------------------------------------------
                */

                $this->promotionRepository->create([
                    'user_id'               => $enrollment->user_id,

                    'stu_profile_id'        => $enrollment->stu_profile_id,

                    'academic_session_id'   => $data['target_academic_session_id'],

                    'class_id'              => $data['target_class_id'],

                    'section_id'            => $data['target_section_id'],

                    'roll_number'           => $enrollment->roll_number,

                    'status'                => 1,

                    'promoted_by'           => Auth::guard('admin')->id(),

                ]);

                $promoted++;
            }

        });

        return [

            'total' => count($data['enrollment_ids']),

            'promoted' => $promoted,

            'skipped'  => $skipped,

        ];
    }
}
