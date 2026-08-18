<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\TeacherSubjectRequest;
use App\Models\TeacherSubject;
use App\Services\Admin\TeacherSubjectService;
use Illuminate\Http\Request;

class TeacherSubjectController extends BaseController
{
    public function __construct(protected TeacherSubjectService $TeacherSubjectService)
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view(
            'admin.teacher_subjects.index',
            [
                'classes' => class_options(),
                'subjects' => subject_options(),
                'teachers' => teacher_options(),
                'sections' => section_options(),
            ]
        );
    }

    public function list(Request $request)
    {
        $filters = [
            'search' => $request->input('search.value'),
            'filter_status' => $request->input('filter_status'),
        ];

        $length = max((int) $request->input('length', 10), 1);
        $start = max((int) $request->input('start', 0), 0);
        $page = (int) floor($start / $length) + 1;

        $orderColumn = $request->input('order.0.column');
        $orderDirection = $request->input('order.0.dir', 'asc');

        $subjects = $this->TeacherSubjectService->getList(
            $filters,
            $length,
            $page,
            $orderColumn !== null ? (int) $orderColumn : null,
            $orderDirection
        );

        return $this->datatable($subjects, (int) $request->input('draw', 1));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeacherSubjectRequest $request)
    {
        $this->TeacherSubjectService->create(
            $request->validated()
        );

        return $this->success(
            'teacher subject creates successfully'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeacherSubject $teacher_subject)
    {
        $teacher_subject['class_info'] = class_options();
        $teacher_subject['subject_info'] = subject_options();
        $teacher_subject['teacher_info'] = teacher_options();
        $teacher_subject['sections_info'] = section_options();

        return $this->success(
            'Academic Teacher subjects fetch successfully.',
            $teacher_subject
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TeacherSubjectRequest $request, TeacherSubject $teacher_subject)
    {
        $subjects = $this->TeacherSubjectService->update(
            $teacher_subject->id,
            $request->validated()
        );

        return $this->success(
            'Academic Teacher subjects update successfully.',
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeacherSubject $teacher_subject)
    {
        $subjects = $this->TeacherSubjectService->delete(
            $teacher_subject->id
        );

        return $this->success(
            'Academic Teacher subjects Deleted successfully.',
        );
    }

    /**
     * Change status
     */
    public function changeStatus(TeacherSubject $teacher_subject)
    {
        $this->TeacherSubjectService->changeStatus($teacher_subject->id);

        return $this->success(
            'Academic teacher subject status updated successfully.'
        );
    }
}
