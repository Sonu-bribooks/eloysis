<?php

namespace App\Services\Admin;

use App\Repositories\Admin\ClassSubjectRepository;
use Illuminate\Support\Facades\DB;

class ClassSubjectService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ClassSubjectRepository $classSubjectRepository,

    ) {}

    /**
     * Get student listing
     */
    public function getList(
        array $filters = [],
        int $perPage = 10,
        int $page = 1,
        ?int $orderColumn = null,
        string $orderDirection = 'asc'
    ) {
        return $this->classSubjectRepository->getList($filters, $perPage, $page, $orderColumn, $orderDirection);
    }

    /**
     * Create Academic Subject
     */
    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $classes = $this->classSubjectRepository->create($data);

            DB::commit();

            return $classes;

        } catch (Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Update Subject
     */
    public function update(int $id, array $data)
    {
        DB::beginTransaction();

        try {

            $classes = $this->classSubjectRepository->update($id, $data);

            DB::commit();

            return $classes;

        } catch (Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Delete Subject
     */
    public function delete(int $id)
    {
        DB::beginTransaction();

        try {

            $this->classSubjectRepository->delete($id);

            DB::commit();

            return true;

        } catch (Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Change Subject Status
     */
    public function changeStatus(int $id)
    {
        return $this->classSubjectRepository->changeStatus($id);
    }
}
