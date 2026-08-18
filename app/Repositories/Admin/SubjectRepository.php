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

    public function getAcademicSubjects(
        array $filters = [],
        int $perPage = 10,
        int $page = 1,
        ?int $orderColumn = null,
        string $orderDirection = 'asc'
    ) {
        $sortableColumns = [
            1 => 'subject_name',
            2 => 'subject_code',
            3 => 'description',
            4 => 'status',
        ];

        $query = $this->model->newQuery();

        $query->when(! empty($filters['search']), function ($query) use ($filters) {
            $query->where(function ($q) use ($filters) {
                $q->where('subject_name', 'like', "%{$filters['search']}%")
                    ->orWhere('subject_code', 'like', "%{$filters['search']}%")
                    ->orWhere('description', 'like', "%{$filters['search']}%");
            });
        })
            ->when(isset($filters['filter_status']) && $filters['filter_status'] !== '', function ($query) use ($filters) {
                $query->where('status', $filters['filter_status']);
            });

        if ($orderColumn !== null && isset($sortableColumns[$orderColumn])) {
            $query->orderBy($sortableColumns[$orderColumn], $orderDirection === 'desc' ? 'desc' : 'asc');
        } else {
            $query->latest('id');
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
