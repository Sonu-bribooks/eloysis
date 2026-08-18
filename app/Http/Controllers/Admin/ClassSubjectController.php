<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\ClassSubjectRequest;
use App\Models\ClassSubject;
use App\Services\Admin\ClassSubjectService;
use Illuminate\Http\Request;

class ClassSubjectController extends BaseController
{
    public function __construct(protected ClassSubjectService $ClassSubjectService)
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view(
            'admin.class_subjects.index',
            [
                'classes' => class_options(),
                'subjects' => subject_options(),
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

        $subjects = $this->ClassSubjectService->getList(
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
    public function store(ClassSubjectRequest $request)
    {
        $this->ClassSubjectService->create(
            $request->validated()
        );

        return $this->success(
            'class subject creates successfully'
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
    public function edit(ClassSubject $clsubject)
    {
        $clsubject['class_info'] = class_options();
        $clsubject['subject_info'] = subject_options();

        return $this->success(
            'Academic Class subjects fetch successfully.',
            $clsubject
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClassSubjectRequest $request, ClassSubject $clsubject)
    {
        $subjects = $this->ClassSubjectService->update(
            $clsubject->id,
            $request->validated()
        );

        return $this->success(
            'Academic Class subjects update successfully.',
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassSubject $clsubject)
    {
        $subjects = $this->ClassSubjectService->delete(
            $clsubject->id
        );

        return $this->success(
            'Academic Class subjects Deleted successfully.',
        );
    }

    /**
     * Change status
     */
    public function changeStatus(ClassSubject $clsubject)
    {
        $this->ClassSubjectService->changeStatus($clsubject->id);

        return $this->success(
            'Academic Class subject status updated successfully.'
        );
    }
}
