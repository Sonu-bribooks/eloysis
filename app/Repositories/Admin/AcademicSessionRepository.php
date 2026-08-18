<?php

namespace App\Repositories\Admin;

use App\Models\AcademicSession;
use App\Repositories\BaseRepository;

class AcademicSessionRepository extends BaseRepository
{
    public function __construct(AcademicSession $academic_session)
    {
        parent::__construct($academic_session);
    }

    /**
     * Search sessions.
     */
    public function getAcademicSessions(
        array $filters = [],
        int $perPage = 10,
        int $page = 1,
        ?int $orderColumn = null,
        string $orderDirection = 'asc'
    ) {
        $sortableColumns = [
            1 => 'name',
            2 => 'start_year',
            3 => 'end_year',
            4 => 'start_date',
            5 => 'end_date',
            6 => 'is_current',
        ];

        $query = $this->model->newQuery();

        $query->when(! empty($filters['search']), function ($query) use ($filters) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%")
                    ->orWhere('start_year', 'like', "%{$filters['search']}%")
                    ->orWhere('end_year', 'like', "%{$filters['search']}%");
            });
        })
            ->when(isset($filters['filter_status']) && $filters['filter_status'] !== '', function ($query) use ($filters) {
                $query->where('is_current', $filters['filter_status']);
            });

        if ($orderColumn !== null && isset($sortableColumns[$orderColumn])) {
            $query->orderBy($sortableColumns[$orderColumn], $orderDirection === 'desc' ? 'desc' : 'asc');
        } else {
            $query->latest('id');
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function academicStatus(int $id)
    {
        $session = $this->model->findOrFail($id);

        $session->is_current = ! $session->is_current;

        return $session->save();
    }
}
