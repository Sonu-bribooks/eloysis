<?php

namespace App\Services\Admin;

use App\Repositories\Admin\ClassSectionRepository;
use Illuminate\Support\Facades\DB;

class ClassSectionService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected ClassSectionRepository $classSectionRepository)
    {
        //
    }

     /**
     * Get Academic Section
     */
    public function getLists(array $filters = [], int $perPage = 10) {

        return $this->classSectionRepository->getLists($filters, $perPage);

    }

    /**
     * Create Academic Section
     */
    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            // dd($data);
            $classes = $this->classSectionRepository->create($data);

            DB::commit();

            return $classes;

        } catch (Exception $e) {

            DB::rollBack();

            dd([
                'message'   => $e->getMessage(),
                'errorInfo' => $e->errorInfo ?? null,
            ]);
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

            $classes = $this->classSectionRepository->update($id, $data);

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

            $this->classSectionRepository->delete($id);

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
        return $this->classSectionRepository->changeStatus($id);
    }

}
