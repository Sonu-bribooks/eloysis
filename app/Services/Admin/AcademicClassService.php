<?php

namespace App\Services\Admin;

use App\Repositories\Admin\AcademicClassRepository;

class AcademicClassService
{
    protected AcademicClassRepository $academicClassRepository;

    /**
     * Create a new class instance.
     */
    public function __construct(AcademicClassRepository $academicClassRepository) {
        $this->AcademicClassRepository = $academicClassRepository;
    }

    public function getAcademicClasses(array $filters = [], int $perPage = 10) {

        return $this->AcademicClassRepository->getAcademicClasses($filters, $perPage);

    }
}
