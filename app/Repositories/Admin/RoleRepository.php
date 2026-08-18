<?php

namespace App\Repositories\Admin;

use App\Models\Role;
use App\Repositories\BaseRepository;

class RoleRepository extends BaseRepository
{
    public function __construct(Role $role)
    {
        parent::__construct($role);
    }

    /**
     * Search roles.
     */
    public function getRoles(
        array $filters = [],
        int $perPage = 10,
        int $page = 1,
        ?int $orderColumn = null,
        string $orderDirection = 'asc'
    ) {
        $sortableColumns = [
            1 => 'role_name',
            2 => 'slug',
            3 => 'status',
        ];

        $query = $this->model->newQuery();

        $query->when(! empty($filters['search']), function ($query) use ($filters) {
            $query->where(function ($q) use ($filters) {
                $q->where('role_name', 'like', "%{$filters['search']}%")
                    ->orWhere('slug', 'like', "%{$filters['search']}%");
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

    /**
     * Check duplicate role.
     */
    public function existsByName(string $name, ?int $ignoreId = null): bool
    {
        return $this->model
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->where('name', $name)
            ->exists();
    }
}
