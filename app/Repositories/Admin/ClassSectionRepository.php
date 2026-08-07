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

    public function getLists(array $filters = [],  int $perPage = 10) {
        return $this->model
            ->with([
                'sectionClass:id,class_name',
                'section:id,name,code',
            ])
            ->when(!empty($filters['search']), function ($query) use ($filters) {
                $query->where(function ($q) use ($filters) {
                      $q->WhereHas('sectionClass', function ($classQuery) use ($filters) {
                        $classQuery->where('class_name', 'like', "%{$filters['search']}%");
                      })
                      ->orWhereHas('section',function ($sectionQuery) use ($filters) {
                        $sectionQuery->where('name','like', "%{$filters['search']}%")
                                ->orWhere('code','like', "%{$filters['search']}%");
                      }); 
                });
            })
            ->when(isset($filters['filter_status']) && $filters['filter_status'] !== '', function ($query) use ($filters) {
                $query->where('status', $filters['filter_status']);
            })
            ->latest()
            ->paginate($perPage);
    }
}
