<?php

namespace App\Services\Admin;

use App\Repositories\Admin\StudentAttendanceRepository;
use Illuminate\Support\Facades\DB;

class StudentAttendanceService
{
    protected StudentAttendanceRepository $attendanceRepository;

    /**
     * Create a new class instance.
     */
    public function __construct(StudentAttendanceRepository $attendanceRepository)
    {
        $this->attendanceRepository = $attendanceRepository;
    }

    /**
     * Get students for attendance
     */
    public function students(array $filters = [])
    {
        return $this->attendanceRepository->getStudents($filters);
    }

    /**
     * Save bulk attendance
     */
    public function save(array $data): array
    {
        $saved = 0;

        DB::transaction(function () use ($data, &$saved) {

            foreach ($data['attendance'] as $attendance) {

                $this->attendanceRepository->saveAttendance(

                    (int) $attendance['student_enrollment_id'],

                    $data['attendance_date'],

                    [
                        'status' => $attendance['status'],

                        'remarks' => $attendance['remarks'] ?? null,
                    ]

                );

                $saved++;
            }

        });

        return [
            'saved' => $saved,
            'attendance_date' => $data['attendance_date'],
        ];
    }

    /**
     * Get attendance history
     */
    public function history(array $filters = [])
    {
        return $this->attendanceRepository->getHistory($filters);
    }
}
