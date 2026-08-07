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

    public function getList(array $filters = [], int $perPage = 10) {
        
        return $this->model
            ->with([
                'subjectClass:id,class_name',
                'subject:id,subject_name,subject_code',
            ])
            ->when(
                !empty($filters['search']),
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
            )
            ->latest()
            ->paginate($perPage);

    }
}
