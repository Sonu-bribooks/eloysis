<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\StaffRequest;
use App\Models\StaffProfile;
use App\Services\Admin\StaffService;
use Illuminate\Http\Request;

class StaffController extends BaseController
{

    public function __construct(
        protected StaffService $staffService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.staffs.index');
    }

     /**
     * Staff Listing AJAX
     */
    public function list(Request $request)
    {
        $staff = $this->staffService->list(
            $request->all()
        );

        return $this->success(
            'Staff fetched successfully.',
            $staff
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
    public function store(StaffRequest $request)
    {
        $this->staffService->create(
            $request->validated()
        );

        return $this->success(
            'Staff created successfully.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(StaffProfile $staff)
    {
        $staff->load([
            'user',
        ]);

        return $this->success(
            'Staff fetched successfully.',
            $staff
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StaffRequest $request, StaffProfile $staff)
    {
        $this->staffService->update(
            $staff,
            $request->validated()
        );

        return $this->success(
            'Staff updated successfully.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StaffProfile $staff)
    {
        $this->staffService->delete(
            $staff
        );

        return $this->success(
            'Admin deleted successfully.'
        );
    }

    /**
     * Update Student Status
     */
    public function changeStatus(
        StaffProfile $staffs
    ) {
        $this->staffService->updateStatus(
            $staffs
        );

        return $this->success(
            'Staff status updated successfully.'
        );
    }
}
