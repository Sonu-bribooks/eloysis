<?php

namespace App\Repositories\Admin;

use App\Models\TeacherProfile;
use App\Repositories\BaseRepository;

class TeacherRepository extends BaseRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(TeacherProfile $teacher)
    {
        parent::__construct($teacher);
    }

    public function getList(
        array $filters = [],
        int $perPage = 10,
        int $page = 1,
        ?int $orderColumn = null,
        string $orderDirection = 'asc'
    ) {
        $sortableColumns = [
            1 => 'user_id',
            3 => 'employee_id',
            5 => 'specialization',
        ];

        $query = $this->model
            ->with('user')
            ->when(! empty($filters['search']), function ($query) use ($filters) {
                $search = $filters['search'];

                $query->where(function ($q) use ($search) {
                    $q->where('employee_id', 'like', "%{$search}%")
                        ->orWhere('specialization', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                                ->orWhere('mobile', 'like', "%{$search}%");
                        });
                });
            })
            ->when(isset($filters['filter_status']) && $filters['filter_status'] !== '', function ($query) use ($filters) {
                $query->whereHas('user', function ($userQuery) use ($filters) {
                    $userQuery->where('status', $filters['filter_status']);
                });
            });

        if ($orderColumn !== null && isset($sortableColumns[$orderColumn])) {
            $query->orderBy($sortableColumns[$orderColumn], $orderDirection === 'desc' ? 'desc' : 'asc');
        } else {
            $query->latest('id');
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function findWithUser(int $id)
    {
        return $this->model
            ->with('user')
            ->findOrFail($id);
    }

    public function createProfile(
        int $userId,
        array $data
    ) {
        return $this->model->create([

            'user_id' => $userId,

            'employee_id' => $data['employee_id'],

            'qualification' => $data['qualification'] ?? null,

            'specialization' => $data['specialization'] ?? null,

            'joining_date' => $data['joining_date'] ?? null,

            'dob' => $data['dob'] ?? null,

            'gender' => $data['gender'] ?? null,

            'experience_years' => $data['experience_years'] ?? null,

            'address' => $data['address'] ?? null,

            'city' => $data['city'] ?? null,

            'state' => $data['state'] ?? null,

            'pincode' => $data['pincode'] ?? null,

            'emergency_contact_name' => $data['emergency_contact_name'] ?? null,

            'emergency_contact_mobile' => $data['emergency_contact_mobile'] ?? null,

        ]);
    }

    public function updateProfile(int $id, array $data)
    {

        $teacher = $this->find($id);

        $teacher->update([

            'employee_id' => $data['employee_id'],

            'qualification' => $data['qualification'] ?? null,

            'specialization' => $data['specialization'] ?? null,

            'joining_date' => $data['joining_date'] ?? null,

            'dob' => $data['dob'] ?? null,

            'gender' => $data['gender'] ?? null,

            'experience_years' => $data['experience_years'] ?? null,

            'address' => $data['address'] ?? null,

            'city' => $data['city'] ?? null,

            'state' => $data['state'] ?? null,

            'pincode' => $data['pincode'] ?? null,

            'emergency_contact_name' => $data['emergency_contact_name'] ?? null,

            'emergency_contact_mobile' => $data['emergency_contact_mobile'] ?? null,

        ]);

        return $teacher;
    }
}
