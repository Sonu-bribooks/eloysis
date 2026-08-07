<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\ClassSectionRequest;
use App\Services\Admin\ClassSectionService;
use Illuminate\Http\Request;
use App\Models\ClassSection;

class ClassSectionController extends BaseController
{
    public function __construct(protected ClassSectionService $classSectionService) {
       
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view(
            'admin.class_sections.index',
            [
                'classes' => class_options(),
                'sections' => section_options(),
            ]
        );
    }
    
    public function list(Request $request) {
       
        $filters = $request->only([
            'search',
            'filter_status',
            'page'
        ]);
         
        $sections = $this->classSectionService->getLists($filters);
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
        $data = [
            'class'   => class_options(),
            'section' => section_options()
        ];
        // dd($class);
        return $this->success(
            'Section Create modal open successfully',
            $data ?? []
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassSectionRequest $request)
    {
        $sections = $this->classSectionService->create(
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
    public function edit(ClassSection $class_section)
    {
        $class_section['class_info'] = class_options();
        $class_section['section_info']    = section_options();
       
        return $this->success(
            'Academic Class Sections fetch successfully.',
            $class_section
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClassSectionRequest $request, ClassSection $class_section)
    {
        $sections = $this->classSectionService->update(
            $class_section->id,
            $request->validated()
        );

        return $this->success(
            'Academic Class Sections update successfully.',
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassSection $class_section)
    {
        $sections = $this->classSectionService->delete(
            $class_section->id
        );

        return $this->success(
            'Academic Class Sections Deleted successfully.',
        );
    }

    /**
     * Change status
     */
    public function changeStatus(ClassSection $classSection)
    {
        $this->classSectionService->changeStatus($classSection->id);

        return $this->success(
            'Academic Class Section status updated successfully.'
        );
    }
}
