<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\StudentRequest;
use App\Services\Admin\StudentService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\{StudentProfile,StudentEnrollment};

class StudentController extends BaseController
{
    public function __construct(
        protected StudentService $studentService
    ) {
    }

     /**
     * Student Management Page
     */
    public function index()
    {
        return view(
            'admin.students.index',
            [
                'academicSessions' => academic_session_options(),
                'classes' => class_options(),
                'sections' => section_options(),
            ]
        );
    }


    /**
     * Student Listing
     */
    public function list(Request $request)
    {
        $students = $this->studentService->getList(
            $request->only([
                'search',
                'status',
                'academic_session_id',
                'class_id',
                'section_id',
                'per_page',
            ])
        );

        return $this->success(
            'Student list fetched successfully.',
            $students
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(
            'admin.students.create',
            [
                // 'academicSessions' => academic_session_options(1),
                'academicSessions' => academic_session_options(),
                'classes' => class_options(),
                'sections' => section_options(),
            ]
        );
    }

    /**
     * Store Student
     */
    public function store(StudentRequest $request)
    {
        $this->studentService->create(
            $request->validated()
        );

        return $this->success(
            'Student created successfully.'
        );
    }

    //**********************Student actions By student Profile************************************** */
    // /**
    //  * Show Student
    //  */
    // public function show(StudentProfile $student)
    // {
    //     // $student = $this->studentService->find(
    //     //     $id
    //     // );

    //     // return $this->success(
    //     //     'Student details fetched successfully.',
    //     //     $student
    //     // );

    //     $student->load([
    //         'user',
    //         'enrollments.academicSession',
    //         'enrollments.studentClass',
    //         'enrollments.section',
    //     ]);

    //     $enrollment = $student->enrollments
    //         ->sortByDesc('id')
    //         ->first();

    //     return view(
    //         'admin.students.view',
    //         compact(
    //             'student',
    //             'enrollment'
    //         )
    //     );
    // }

    // /**
    //  * Edit
    //  */
    // public function edit(StudentProfile $student)
    // {
    //     $student->load([
    //         'user',
    //         'enrollments',
    //     ]);

    //     $enrollment = $student->enrollments
    //         ->sortByDesc('id')
    //         ->first();

    //     return view('admin.students.edit', [

    //         'student' => $student,

    //         'enrollment' => $enrollment,

    //        'academicSessions' => academic_session_options(1),
    //         'classes' => class_options(),
    //         'sections' => section_options(),

    //     ]);
    // }


    // /**
    //  * Update Student
    //  */
    // public function update(
    //     StudentRequest $request,
    //     StudentProfile $student
    // ) {
    //     $this->studentService->update(
    //         $student->id,
    //         $request->validated()
    //     );

    //     return $this->success(
    //         'Student updated successfully.'
    //     );
    // }


    // /**
    //  * Delete Student
    //  */
    // public function destroy(StudentProfile $student)
    // {
    //     $this->studentService->delete(
    //         $student->id
    //     );

    //     return $this->success(
    //         'Student deleted successfully.'
    //     );
    // }


    // /**
    //  * Update Student Status
    //  */
    // public function changeStatus(
    //     StudentProfile $students
    // ) {
    //     $this->studentService->updateStatus(
    //         $students->id
    //     );

    //     return $this->success(
    //         'Student status updated successfully.'
    //     );
    // }

    //*****************Student actions By student Profile end*********************************** */

    //*******************Student actions By student Enrollment ************************************ */

     /**
     * Show Student
     */
    public function show(StudentEnrollment $student)
    {

        $student->load([
            'student.user',
            'academicSession',
            'studentClass',
            'section',
        ]);


        $enrollment = $student;

        return view(
            'admin.students.view',
            compact(
                'enrollment'
            )
        );
    }

    /**
     * Edit
     */
    public function edit(StudentEnrollment $student)
    {
        $student->load([
            'student.user',
        ]);

        return view('admin.students.edit', [

            'enrollment' => $student,

        //    'academicSessions' => academic_session_options(1),
            'academicSessions' => academic_session_options(),
            'classes' => class_options(),
            'sections' => section_options(),

        ]);
    }


    /**
     * Update Student
     */
    public function update(
        StudentRequest $request,
        StudentEnrollment $student
    ) {
        $this->studentService->update(
            $student->id,
            $request->validated()
        );

        return $this->success(
            'Student updated successfully.'
        );
    }


    /**
     * Delete Student
     */
    public function destroy(StudentEnrollment $student)
    {
        $this->studentService->delete(
            $student->id
        );

        return $this->success(
            'Student deleted successfully.'
        );
    }


    /**
     * Update Student Status
     */
    public function changeStatus(
        StudentEnrollment $students
    ) {
        $this->studentService->updateStatus(
            $students->id
        );

        return $this->success(
            'Student status updated successfully.'
        );
    }
}
