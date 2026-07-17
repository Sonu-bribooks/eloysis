<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Role;
use App\Services\Admin\RoleService;

class RoleController extends BaseController
{
    protected RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Display Listing
     */
    public function index(Request $request)
    {

        return view('admin.roles.index');
        
    }

    public function list(Request $request)
    {
        $filters = $request->only([
            'search',
            'filter_status',
            'page'
        ]);

        $roles = $this->roleService->getRoles($filters);
        return $this->success(
            'Role list fetched successfully.',
            $roles
        );
    }

    /**
     * Store
     */
    public function store(RoleRequest $request)
    {
        $this->roleService->create(
            $request->validated()
        );

        return $this->success(
            'Role created successfully.'
        );
    }

    /**
     * Edit
     */
    public function edit(Role $role)
    {
        return $this->success(
            'Role fetched successfully.',
            $role
        );
    }

    /**
     * Update
     */
    public function update(RoleRequest $request, Role $role)
    {
        // dd($request->all());
        $this->roleService->update(
            $role->id,
            $request->validated()
        );

        return $this->success(
            'Role updated successfully.'
        );
    }

    /**
     * Delete
     */
    public function destroy(Role $role)
    {
        if ($role->users()->exists()) {

            return $this->error(
                'This role is assigned to users and cannot be deleted.',
                [],
                422
            );

        }
        $this->roleService->delete(
            $role->id
        );

        return $this->success(
            'Role deleted successfully.'
        );
    }
    
    /**
     * Change status
     */
    public function changeStatus(Role $role)
    {
        $this->roleService->changeStatus($role->id);

        return $this->success(
            'Role status updated successfully.'
        );
    }
}
