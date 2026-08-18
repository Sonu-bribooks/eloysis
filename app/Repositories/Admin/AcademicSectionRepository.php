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

    public function getAcademicSections(
        array $filters = [],
        int $perPage = 10,
        int $page = 1,
        ?int $orderColumn = null,
        string $orderDirection = 'asc'
    ) {
        $sortableColumns = [
            1 => 'name',
            2 => 'code',
            3 => 'status',
        ];

        $query = $this->model->newQuery();

        $query->when(! empty($filters['search']), function ($query) use ($filters) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%")
                    ->orWhere('code', 'like', "%{$filters['search']}%");
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
