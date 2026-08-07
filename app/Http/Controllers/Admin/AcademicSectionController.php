<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\AcademicSectionRequest;
use App\Services\Admin\AcademicSectionService;
use Illuminate\Http\Request;
use App\Models\Section;


class AcademicSectionController extends BaseController
{
    protected AcademicSectionService $AcademicSectionService;

    public function __construct(AcademicSectionService $AcademicSectionService) {
        $this->AcademicSectionService = $AcademicSectionService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.sections.index');
    }
    
    public function list(Request $request) {
       
        $filters = $request->only([
            'search',
            'filter_status',
            'page'
        ]);
         
        $sections = $this->AcademicSectionService->getAcademicSections($filters);
        return $this->success(
            'Academic Class Sections list fetched successfully.',
            $sections
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $class = class_options();
        // dd($class);
        return $this->success(
            'Section Create modal open successfully',
            $class ?? []
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AcademicSectionRequest $request)
    {
        $sections = $this->AcademicSectionService->create(
            $request->validated()
        );
        return $this->success(
            'Academic Class Sections create successfully.',
            $sections
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
    public function edit(Section $section)
    {
        $section['class_info'] = class_options();
        // dd($section);
        return $this->success(
            'Academic Class Sections fetch successfully.',
            $section
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AcademicSectionRequest $request, Section $section)
    {
        $sections = $this->AcademicSectionService->update(
            $section->id,
            $request->validated()
        );

        return $this->success(
            'Academic Class Sections update successfully.',
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        $sections = $this->AcademicSectionService->delete(
            $section->id
        );

        return $this->success(
            'Academic Class Sections Deleted successfully.',
        );
    }

    /**
     * Change status
     */
    public function changeStatus(Section $sections)
    {
        $this->AcademicSectionService->changeStatus($sections->id);

        return $this->success(
            'Academic Class Section status updated successfully.'
        );
    }
}
