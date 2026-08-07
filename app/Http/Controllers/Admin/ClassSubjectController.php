<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Services\Admin\ClassSubjectService;
use App\Http\Requests\Admin\ClassSubjectRequest;
use App\Models\ClassSubject;

class ClassSubjectController extends BaseController
{
    public function __construct(protected ClassSubjectService $ClassSubjectService) {
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

    public function list(Request $request) {
       
        $filters = $request->only([
            'search',
            'filter_status',
            'page'
        ]);
         
        $subjects = $this->ClassSubjectService->getList($filters);
        return $this->success(
            'Academic Class subjects list fetched successfully.',
            $subjects
        );
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
