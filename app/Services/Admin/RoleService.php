<?php

namespace App\Services\Admin;

use App\Repositories\Admin\RoleRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleService
{
    protected RoleRepository $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Get Roles
     */
    public function getRoles(
        array $filters = [],
        int $perPage = 10,
        int $page = 1,
        ?int $orderColumn = null,
        string $orderDirection = 'asc'
    ) {
        return $this->roleRepository->getRoles($filters, $perPage, $page, $orderColumn, $orderDirection);
    }

    /**
     * Create Role
     */
    public function create(array $data)
    {
        DB::beginTransaction();

        try {

            $data['slug'] = Str::slug($data['role_name']);

            $role = $this->roleRepository->create($data);

            DB::commit();

            return $role;

        } catch (Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Update Role
     */
    public function update(int $id, array $data)
    {
        DB::beginTransaction();

        try {

            $data['slug'] = Str::slug($data['role_name']);

            $role = $this->roleRepository->update($id, $data);

            DB::commit();

            return $role;

        } catch (Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Delete Role
     */
    public function delete(int $id)
    {
        DB::beginTransaction();

        try {

            $this->roleRepository->delete($id);

            DB::commit();

            return true;

        } catch (Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Change Role Status
     */
    public function changeStatus(int $id)
    {
        return $this->roleRepository->changeStatus($id);
    }
}
