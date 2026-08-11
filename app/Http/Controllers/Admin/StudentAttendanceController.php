<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StudentAttendanceRequest;
use App\Services\Admin\StudentAttendanceService;

class StudentAttendanceController extends BaseController
{
    protected StudentAttendanceService $attendanceService;

    public function __construct(
        StudentAttendanceService $attendanceService
    ) {
        $this->attendanceService = $attendanceService;
    }

    /**
     * Attendance page
     */
    public function index()
    {
        return view('admin.attendance.index',[
                'academicSessions' => academic_session_options(1),
                'classes' => class_options(),
                'sections' => section_options(),
            ]);
    }

    /**
     * Load students for attendance
     */
    public function students(StudentAttendanceRequest $request)
    {
        // dd($request->all());
        $students = $this->attendanceService->students(
            $request->validated()
        );

        return $this->success(
            'Students loaded successfully.',
            $students
        );
    }

    /**
     * Save bulk attendance
     */
    public function save(StudentAttendanceRequest $request)
    {
        $result = $this->attendanceService->save(
            $request->validated()
        );

        return $this->success(
            $result,
            'Attendance saved successfully.'
        );
    }

    /**
     * Attendance history
     */
    public function history(StudentAttendanceRequest $request)
    {
        $history = $this->attendanceService->history(
            $request->validated()
        );

        return $this->success(
            $history,
            'Attendance history loaded successfully.'
        );
    }
}
