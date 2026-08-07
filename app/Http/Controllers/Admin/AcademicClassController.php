<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\AcademicClassRequest;
use App\Services\Admin\AcademicClassService;
use Illuminate\Http\Request;
use App\Models\AcademicClass;


class AcademicClassController extends BaseController
{
    protected AcademicClassService $academicClassService;

    public function __construct(AcademicClassService $academicClassService) {
        $this->academicClassService = $academicClassService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.classes.index');
    }

    public function list(Request $request) {
       
        $filters = $request->only([
            'search',
            'filter_status',
            'page'
        ]);
         
        $classes = $this->academicClassService->getAcademicClasses($filters);
        return $this->success(
            'Academic Class list fetched successfully.',
            $classes
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
    public function store(AcademicClassRequest $request)
    {
        // dd($request->all());
        $this->academicClassService->create(
            $request->validated()
        );

        return $this->success(
            'Academic Class created successfully.'
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
    public function edit(AcademicClass $class)
    {
        // dd($classes);
        return $this->success(
            'Academic Classes fetched successfully.',
            $class
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AcademicClassRequest $request, AcademicClass $class)
    {
        $this->academicClassService->update(
            $class->id,
            $request->validated()
        );

        return $this->success(
            'Academic Class Updated successfully.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicClass $class)
    {
        $this->academicClassService->delete(
            $class->id
        );

        return $this->success(
            'Academic Session deleted successfully.'
        );
    }

    /**
     * Change status
     */
    public function changeStatus(AcademicClass $classes)
    {
        $this->academicClassService->changeStatus($classes->id);

        return $this->success(
            'Academic Class status updated successfully.'
        );
    }
}
