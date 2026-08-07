<?php

namespace App\Repositories\Admin;

use App\Models\Subject;
use App\Repositories\BaseRepository;

class SubjectRepository extends BaseRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(Subject $subject)
    {
        parent::__construct($subject);
    }

    public function getAcademicSubjects(array $filters = [], int $perPage = 10) {
        
        return $this->model
            ->when(!empty($filters['search']), function ($query) use ($filters) {
                $query->where(function ($q) use ($filters) {
                    $q->where('subject_name', 'like', "%{$filters['search']}%")
                      ->orWhere('subject_code', 'like', "%{$filters['search']}%");
                });
            })
            ->when(isset($filters['filter_status']) && $filters['filter_status'] !== '', function ($query) use ($filters) {
                $query->where('status', $filters['filter_status']);
            })
            ->latest()
            ->paginate($perPage);
    }
}
