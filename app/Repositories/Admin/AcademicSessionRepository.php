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
     * Search roles.
     */
    public function getAcademicSessions(array $filters = [], int $perPage = 10)
    {
        return $this->model
            ->when(!empty($filters['search']), function ($query) use ($filters) {
                $query->where(function ($q) use ($filters) {
                    $q->where('name', 'like', "%{$filters['search']}%")
                      ->orWhere('start_year', 'like', "%{$filters['search']}%")
                      ->orWhere('end_year', 'like', "%{$filters['search']}%");
                });
            })
            ->when(isset($filters['filter_status']) && $filters['filter_status'] !== '', function ($query) use ($filters) {
                $query->where('is_current', $filters['filter_status']);
            })
            ->latest()
            ->paginate($perPage);
    }

    public function academicStatus(int $id)
    {
        $session = $this->model->findOrFail($id);

        $session->is_current = ! $session->is_current;

        return $session->save();
    }

}