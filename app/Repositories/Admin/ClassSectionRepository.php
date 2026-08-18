<?php

namespace App\Repositories\Admin;

use App\Models\ClassSection;
use App\Repositories\BaseRepository;

class ClassSectionRepository extends BaseRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(ClassSection $model)
    {
        parent::__construct($model);
    }

    public function getLists(
        array $filters = [],
        int $perPage = 10,
        int $page = 1,
        ?int $orderColumn = null,
        string $orderDirection = 'asc'
    ) {
        $sortableColumns = [
            1 => 'class_id',
            2 => 'section_id',
            4 => 'status',
        ];

        $query = $this->model
            ->with([
                'sectionClass:id,class_name',
                'section:id,name,code',
            ])
            ->when(! empty($filters['search']), function ($query) use ($filters) {
                $query->where(function ($q) use ($filters) {
                    $q->whereHas('sectionClass', function ($classQuery) use ($filters) {
                        $classQuery->where('class_name', 'like', "%{$filters['search']}%");
                    })
                        ->orWhereHas('section', function ($sectionQuery) use ($filters) {
                            $sectionQuery->where('name', 'like', "%{$filters['search']}%")
                                ->orWhere('code', 'like', "%{$filters['search']}%");
                        });
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
