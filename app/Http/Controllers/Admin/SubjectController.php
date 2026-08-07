<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\SubjectService;
use App\Http\Requests\Admin\SubjectRequest;
use App\Models\Subject;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class SubjectController extends BaseController
{
    protected SubjectService $SubjectService;

    public function __construct(SubjectService $SubjectService) {
        
        $this->SubjectService = $SubjectService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.subjects.index');
    }
    
    public function list(Request $request) {
       
        $filters = $request->only([
            'search',
            'filter_status',
            'page'
        ]);
         
        $subjects = $this->SubjectService->getAcademicSubjects($filters);
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
        
        return $this->success(
            'subject Create modal open successfully',
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubjectRequest $request)
    {
        $subjects = $this->SubjectService->create(
            $request->validated()
        );
        return $this->success(
            'Academic Class subjects create successfully.',
            $subjects
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
    public function edit(Subject $subject)
    {
        return $this->success(
            'Academic Class subjects fetch successfully.',
            $subject
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubjectRequest $request, Subject $subject)
    {
        $subjects = $this->SubjectService->update(
            $subject->id,
            $request->validated()
        );

        return $this->success(
            'Academic Class subjects update successfully.',
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subjects = $this->SubjectService->delete(
            $subject->id
        );

        return $this->success(
            'Academic Class subjects Deleted successfully.',
        );
    }

    /**
     * Change status
     */
    public function changeStatus(Subject $subjects)
    {
        $this->SubjectService->changeStatus($subjects->id);

        return $this->success(
            'Academic Class subject status updated successfully.'
        );
    }

}
