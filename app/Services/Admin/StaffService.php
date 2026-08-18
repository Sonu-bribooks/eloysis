<?php

namespace App\Services\Admin;

use App\Helpers\UploadHelper;
use App\Models\Role;
use App\Models\StaffProfile;
use App\Repositories\Admin\StaffRepository;
use App\Repositories\Admin\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StaffService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected StaffRepository $staffRepository,
        protected UserRepository $userRepository
    ) {
        //
    }

    /**
     * Create Staff / Admin
     */
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {

            /*
            |--------------------------------------------------------------------------
            | Get Admin Role
            |--------------------------------------------------------------------------
            */

            $adminRole = Role::where(
                'slug',
                'admin'
            )->firstOrFail();

            /*
            |--------------------------------------------------------------------------
            | Create User
            |--------------------------------------------------------------------------
            */

            if (isset($data['profile_image'])) {
                $data['profile_image'] = UploadHelper::upload(
                    $data['profile_image'],
                    'assets/uploads/staff'
                );

            }

            $user = $this->userRepository->create([

                'name' => $data['name'],

                'email' => $data['email'],

                'mobile' => $data['mobile'] ?? null,

                'role_id' => $adminRole->id,

                'password' => Hash::make(
                    $data['password'] ?? Str::random(12)
                ),

                'status' => $data['status'] ?? 1,

                'created_by' => Auth::guard('admin')->id(),

                'profile_image' => $data['profile_image'] ?? null,

            ]);

            /*
            |--------------------------------------------------------------------------
            | Create Staff Profile
            |--------------------------------------------------------------------------
            */

            $staff = $this->staffRepository->create([

                'user_id' => $user->id,

                'employee_id' => $data['employee_id'] ?? null,

                'designation' => $data['designation'] ?? null,

                'department' => $data['department'] ?? null,

                'joining_date' => $data['joining_date'] ?? null,

                'dob' => $data['dob'] ?? null,

                'gender' => $data['gender'] ?? null,

                'address' => $data['address'] ?? null,

                'city' => $data['city'] ?? null,

                'state' => $data['state'] ?? null,

                'pincode' => $data['pincode'] ?? null,

            ]);

            return $staff;

        });
    }

    /**
     * Staff Listing
     */
    public function list(
        array $filters = [],
        int $perPage = 10,
        int $page = 1,
        ?int $orderColumn = null,
        string $orderDirection = 'asc'
    ) {
        $sortableColumns = [
            1 => 'user_id',
            3 => 'employee_id',
            4 => 'designation',
            5 => 'department',
        ];

        $query = $this->staffRepository->query()
            ->with([
                'user',
            ])
            ->when(
                ! empty($filters['search']),
                function ($query) use ($filters) {
                    $search = $filters['search'];

                    $query->where(function ($q) use ($search) {
                        // Staff Table
                        $q->where('designation', 'like', "%{$search}%")
                            ->orWhere('department', 'like', "%{$search}%")
                            ->orWhere('employee_id', 'like', "%{$search}%")
                            // User Table
                            ->orWhereHas('user', function ($userQuery) use ($search) {
                                $userQuery->where('name', 'like', "%{$search}%")
                                    ->orWhere('email', 'like', "%{$search}%")
                                    ->orWhere('mobile', 'like', "%{$search}%");
                            });
                    });
                }
            )
            ->whereHas('user', function ($query) use ($filters) {
                if (
                    isset($filters['filter_status']) &&
                    $filters['filter_status'] !== ''
                ) {
                    $query->where(
                        'status',
                        $filters['filter_status']
                    );
                }
            })
            ->when(
                ! empty($filters['employee_id']),
                function ($query) use ($filters) {
                    $query->where(
                        'employee_id',
                        'like',
                        '%'.$filters['employee_id'].'%'
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

    /**
     * Update Staff
     */
    public function update(
        StaffProfile $staff,
        array $data
    ) {
        return DB::transaction(function () use (
            $staff,
            $data
        ) {

            /*
            |--------------------------------------------------------------------------
            | Update User
            |--------------------------------------------------------------------------
            */
            if (isset($data['profile_image'])) {

                $data['profile_image'] = UploadHelper::replace(

                    $data['profile_image'],

                    $staff->user->profile_image,

                    'assets/uploads/staff'
                );

            }

            $userData = [

                'name' => $data['name'],

                'email' => $data['email'],

                'mobile' => $data['mobile'] ?? null,

                'status' => $data['status'],

                'profile_image' => $data['profile_image'] ?? $staff->user->profile_image,
                'updated_by' => Auth::guard('admin')->id(),
            ];

            if (! empty($data['password'])) {

                $userData['password'] =
                    Hash::make(
                        $data['password']
                    );
            }

            $this->userRepository->update(

                $staff->user_id,
                $userData

            );

            /*
            |--------------------------------------------------------------------------
            | Update Staff Profile
            |--------------------------------------------------------------------------
            */

            $this->staffRepository->update(

                $staff->id,

                [

                    'employee_id' => $data['employee_id'] ?? null,

                    'designation' => $data['designation'] ?? null,

                    'department' => $data['department'] ?? null,

                    'joining_date' => $data['joining_date'] ?? null,

                    'dob' => $data['dob'] ?? null,

                    'gender' => $data['gender'] ?? null,

                    'address' => $data['address'] ?? null,

                    'city' => $data['city'] ?? null,

                    'state' => $data['state'] ?? null,

                    'pincode' => $data['pincode'] ?? null,

                ]

            );

            return $staff->fresh([
                'user',
            ]);

        });

    }

    /**
     * Delete Staff
     */
    public function delete(StaffProfile $staff)
    {
        return DB::transaction(function () use ($staff) {

            /*
            |--------------------------------------------------------------------------
            | Delete Staff Profile
            |--------------------------------------------------------------------------
            */

            $this->staffRepository->delete(
                $staff->id
            );

            /*
            |--------------------------------------------------------------------------
            | Delete User
            |--------------------------------------------------------------------------
            */
            UploadHelper::delete(
                $staff->user->profile_image
            );

            $this->userRepository->delete(
                $staff->user_id
            );

            return true;

        });

    }

    /**
     * Toggle User Status
     */
    public function updateStatus(
        StaffProfile $staff
    ) {

        $user = $staff->user;

        $this->userRepository->changeStatus(

            $user->id

        );

        return true;

    }
}
