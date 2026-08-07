<?php

namespace App\Repositories\Admin;

use App\Models\Section;
use App\Repositories\BaseRepository;

class AcademicSectionRepository extends BaseRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(Section $section)
    {
        parent::__construct($section);
    }

    public function getAcademicSections(array $filters = [], int $perPage = 10) {
        
        return $this->model
            ->when(!empty($filters['search']), function ($query) use ($filters) {
                $query->where(function ($q) use ($filters) {
                    $q->where('name', 'like', "%{$filters['search']}%")
                      ->orWhere('code', 'like', "%{$filters['search']}%");
                });
            })
            ->when(isset($filters['filter_status']) && $filters['filter_status'] !== '', function ($query) use ($filters) {
                $query->where('status', $filters['filter_status']);
            })
            ->latest()
            ->paginate($perPage);
    }
}
