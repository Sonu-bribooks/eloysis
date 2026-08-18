<?php

namespace App\Repositories\Admin;

use App\Models\ClassSubject;
use App\Repositories\BaseRepository;

class ClassSubjectRepository extends BaseRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(ClassSubject $model)
    {
        parent::__construct($model);
    }

    public function getList(
        array $filters = [],
        int $perPage = 10,
        int $page = 1,
        ?int $orderColumn = null,
        string $orderDirection = 'asc'
    ) {
        $sortableColumns = [
            1 => 'class_id',
            2 => 'subject_id',
            4 => 'status',
        ];

        $query = $this->model
            ->with([
                'subjectClass:id,class_name',
                'subject:id,subject_name,subject_code',
            ])
            ->when(
                ! empty($filters['search']),
                function ($query) use ($filters) {
                    $search = $filters['search'];

                    $query->where(function ($q) use ($search) {
                        $q->whereHas('subjectClass', function ($classQuery) use ($search) {
                            $classQuery->where(
                                'class_name',
                                'like',
                                "%{$search}%"
                            );
                        })
                            ->orWhereHas('subject', function ($subjectQuery) use ($search) {
                                $subjectQuery->where(
                                    'subject_name',
                                    'like',
                                    "%{$search}%"
                                )
                                    ->orWhere(
                                        'subject_code',
                                        'like',
                                        "%{$search}%"
                                    );
                            });
                    });
                }
            )
            ->when(
                isset($filters['filter_status']) &&
                $filters['filter_status'] !== '',
                function ($query) use ($filters) {
                    $query->where(
                        'status',
                        $filters['filter_status']
                    );
                }
            );

        if ($orderColumn !== null && isset($sortableColumns[$orderColumn])) {
            $query->orderBy($sortableColumns[$orderColumn], $orderDirection === 'desc' ? 'desc' : 'asc');
        } else {
            $query->latest('id');
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
