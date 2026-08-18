<?php

namespace App\Services\Admin;

use App\Repositories\Admin\AcademicSectionRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class AcademicSectionService
{
    protected AcademicSectionRepository $AcademicSectionRepository;

    /**
     * Create a new class instance.
     */
    public function __construct(AcademicSectionRepository $AcademicSectionRepository)
    {
        $this->AcademicSectionRepository = $AcademicSectionRepository;
    }

    /**
     * Get Academic Section
     */
    public function getAcademicSections(
        array $filters = [],
        int $perPage = 10,
        int $page = 1,
        ?int $orderColumn = null,
        string $orderDirection = 'asc'
    ) {
        return $this->AcademicSectionRepository->getAcademicSections($filters, $perPage, $page, $orderColumn, $orderDirection);
    }

    /**
     * Create Academic Section
     */
    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $classes = $this->AcademicSectionRepository->create($data);

            DB::commit();

            return $classes;

        } catch (Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Update Section
     */
    public function update(int $id, array $data)
    {
        DB::beginTransaction();

        try {

            $classes = $this->AcademicSectionRepository->update($id, $data);

            DB::commit();

            return $classes;

        } catch (Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Delete Section
     */
    public function delete(int $id)
    {
        DB::beginTransaction();

        try {

            $this->AcademicSectionRepository->delete($id);

            DB::commit();

            return true;

        } catch (Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Change Section Status
     */
    public function changeStatus(int $id)
    {
        return $this->AcademicSectionRepository->changeStatus($id);
    }
}
