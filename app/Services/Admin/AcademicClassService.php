<?php

namespace App\Services\Admin;

use App\Repositories\Admin\AcademicClassRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class AcademicClassService
{
    protected AcademicClassRepository $academicClassRepository;

    /**
     * Create a new class instance.
     */
    public function __construct(AcademicClassRepository $academicClassRepository)
    {
        $this->AcademicClassRepository = $academicClassRepository;
    }

    /**
     * Get Academic Class
     */
    public function getAcademicClasses(
        array $filters = [],
        int $page = 1,
        int $perPage = 10,
        ?int $orderColumn = null,
        string $orderDirection = 'asc'
    ) {
        return $this->AcademicClassRepository->getAcademicClasses(
            $filters,
            $page,
            $perPage,
            $orderColumn,
            $orderDirection
        );
    }

    /**
     * Create Academic Class
     */
    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $classes = $this->AcademicClassRepository->create($data);

            DB::commit();

            return $classes;

        } catch (Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Update Class
     */
    public function update(int $id, array $data)
    {
        DB::beginTransaction();

        try {

            $classes = $this->AcademicClassRepository->update($id, $data);

            DB::commit();

            return $classes;

        } catch (Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Delete Class
     */
    public function delete(int $id)
    {
        DB::beginTransaction();

        try {

            $this->AcademicClassRepository->delete($id);

            DB::commit();

            return true;

        } catch (Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Change Class Status
     */
    public function changeStatus(int $id)
    {
        return $this->AcademicClassRepository->changeStatus($id);
    }
}
