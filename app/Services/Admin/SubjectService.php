<?php

namespace App\Services\Admin;

use App\Repositories\Admin\SubjectRepository;
use Illuminate\Support\Facades\DB;
use Exception;

class SubjectService
{
    protected SubjectRepository $SubjectRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(SubjectRepository $SubjectRepository)
    {
        $this->SubjectRepository = $SubjectRepository;
    }

    /**
     * Get Academic Subject
     */
    public function getAcademicSubjects(array $filters = [], int $perPage = 10) {

        return $this->SubjectRepository->getAcademicSubjects($filters, $perPage);

    }

    /**
     * Create Academic Subject
     */
    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $classes = $this->SubjectRepository->create($data);

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

            $classes = $this->SubjectRepository->update($id, $data);

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

            $this->SubjectRepository->delete($id);

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
        return $this->SubjectRepository->changeStatus($id);
    }
}
