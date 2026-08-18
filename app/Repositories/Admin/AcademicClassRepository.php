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

    public function getAcademicClasses(
        array $filters = [],
        int $page = 1,
        int $perPage = 10,
        ?int $orderColumn = null,
        string $orderDirection = 'asc'
    ) {
        // dd(['filter' => $filters, 'page' => $page, 'perPage' => $perPage, 'orderColumn' => $orderColumn, 'orderDirection' => $orderDirection]);
        /*
        |--------------------------------------------------------------------------
        | Total records before filtering
        |--------------------------------------------------------------------------
        */

        $recordsTotal = $this->model->count();

        /*
        |--------------------------------------------------------------------------
        | Base Query
        |--------------------------------------------------------------------------
        */

        $query = $this->model->newQuery();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        $query->when(! empty($filters['search']),
            function ($query) use ($filters) {

                $search = $filters['search'];

                $query->where(function ($q) use ($search) {
                    $q->where('class_name', 'like', "%{$search}%");
                    $q->orWhere('class_code', 'like', "%{$search}%");
                });
            });

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        $query->when(isset($filters['filter_status']) && $filters['filter_status'] !== '',
            function ($query) use ($filters) {
                $query->where('status', $filters['filter_status']);
            });

        /*
        |--------------------------------------------------------------------------
        | Filtered Records
        |--------------------------------------------------------------------------
        */

        $recordsFiltered = $query->count();

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        $sortableColumns = [

            1 => 'class_name',
            2 => 'class_code',
            3 => 'status',

        ];

        if ($orderColumn !== null && isset($sortableColumns[$orderColumn])) {
            $query->orderBy($sortableColumns[$orderColumn], $orderDirection === 'desc' ? 'desc' : 'asc');
        } else {

            $query->latest('id');

        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $paginator = $query->paginate(
            $perPage,
            ['*'],
            'page',
            $page
        );

        /*
        |--------------------------------------------------------------------------
        | DataTables Response
        |--------------------------------------------------------------------------
        */

        return [

            'recordsTotal' => $recordsTotal,

            'recordsFiltered' => $recordsFiltered,

            'data' => $paginator->items(),

        ];
    }
}
