<?php

namespace App\Repositories\Admin;

use App\Models\AcademicClass;
use App\Repositories\BaseRepository;

class AcademicClassRepository extends BaseRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(AcademicClass $academicClass)
    {
        parent::__construct($academicClass);
    }

    public function getAcademicClasses(array $filters = [], int $perPage = 10) {
        
        return $this->model
            ->when(!empty($filters['search']), function ($query) use ($filters) {
                $query->where(function ($q) use ($filters) {
                    $q->where('class_name', 'like', "%{$filters['search']}%")
                      ->orWhere('class_code', 'like', "%{$filters['search']}%");
                });
            })
            ->when(isset($filters['filter_status']) && $filters['filter_status'] !== '', function ($query) use ($filters) {
                $query->where('status', $filters['filter_status']);
            })
            ->latest()
            ->paginate($perPage);
    }
}
