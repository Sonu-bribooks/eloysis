<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Role;
use App\Services\Admin\RoleService;
use Illuminate\Http\Request;

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
        $filters = [
            'search' => $request->input('search.value'),
            'filter_status' => $request->input('filter_status'),
        ];

        $length = max((int) $request->input('length', 10), 1);
        $start = max((int) $request->input('start', 0), 0);
        $page = (int) floor($start / $length) + 1;

        $orderColumn = $request->input('order.0.column');
        $orderDirection = $request->input('order.0.dir', 'asc');

        $roles = $this->roleService->getRoles(
            $filters,
            $length,
            $page,
            $orderColumn !== null ? (int) $orderColumn : null,
            $orderDirection
        );

        return $this->datatable($roles, (int) $request->input('draw', 1));
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
