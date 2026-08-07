<?php

namespace App\Services\Admin;

use App\Models\Role;
use App\Repositories\Admin\TeacherRepository;
use App\Repositories\Admin\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Helpers\UploadHelper;

class TeacherService
{
    protected TeacherRepository $teacherRepository;
    protected UserRepository $userRepository;
    public function __construct(
        TeacherRepository $teacherRepository,
        UserRepository $userRepository
    ) {
        $this->teacherRepository  = $teacherRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Get teacher list
     */
    public function getList(array $filters = [])
    {
        return $this->teacherRepository->getList($filters);
    }

    /**
     * Get teacher details
     */
    public function find(int $id)
    {
        return $this->teacherRepository->findWithUser($id);
    }

    /**
     * Create teacher
     */
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {

            $teacherRole = Role::where(
                'slug',
                'teacher'
            )->firstOrFail();

            /*
            |--------------------------------------------------------------------------
            | Create User
            |--------------------------------------------------------------------------
            */

            if(isset($data['profile_image'])){
                $data['profile_image'] = UploadHelper::upload(
                    $data['profile_image'],
                    'assets/uploads/teachers'
                );

            }

            $user = $this->userRepository->create([

                'name' => $data['name'],

                'email' => $data['email'],

                'mobile' => $data['mobile'] ?? null,

                'password' => Hash::make(
                    $data['password']
                ),

                'role_id' => $teacherRole->id,

                'status' => $data['status'],
                'created_by' => Auth::guard('admin')->id(),
                'profile_image' => $data['profile_image'] ?? null,

            ]);

            /*
            |--------------------------------------------------------------------------
            | Create Teacher Profile
            |--------------------------------------------------------------------------
            */

            return $this->teacherRepository->createProfile(
                $user->id,
                $data
            );
        });
    }

    /**
     * Update teacher
     */
    public function update(
        int $id,
        array $data
    ) {
        return DB::transaction(function () use (
            $id,
            $data
        ) {

            $teacher =
                $this->teacherRepository->findWithUser($id);

            /*
            |--------------------------------------------------------------------------
            | Update User
            |--------------------------------------------------------------------------
            */

            if(isset($data['profile_image'])){

                $data['profile_image'] = UploadHelper::replace(

                    $data['profile_image'],

                    $teacher->user->profile_image,

                    'assets/uploads/teachers'
                );

            }

            $userData = [

                'name' => $data['name'],

                'email' => $data['email'],

                'mobile' =>
                    $data['mobile'] ?? null,

                'status' => $data['status'],

                'profile_image' => $data['profile_image'] ?? $teacher->user->profile_image,
                'updated_by' => Auth::guard('admin')->id(),
            ];

            if (!empty($data['password'])) {

                $userData['password'] =
                    Hash::make(
                        $data['password']
                    );
            }

            $this->userRepository->update(
                $teacher->user_id,
                $userData
            );

            /*
            |--------------------------------------------------------------------------
            | Update Teacher Profile
            |--------------------------------------------------------------------------
            */

            $this->teacherRepository->updateProfile(
                $teacher->id,
                $data
            );

            return $this->teacherRepository
                ->findWithUser($teacher->id);
        });
    }

    /**
     * Delete teacher
     */
    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {

            $teacher =
                $this->teacherRepository->findWithUser($id);

            /*
            |--------------------------------------------------------------------------
            | Delete User
            |--------------------------------------------------------------------------
            */
            UploadHelper::delete(
                $teacher->user->profile_image
            );

            $this->userRepository->delete(
                $teacher->user_id
            );

            /*
            |--------------------------------------------------------------------------
            | Delete Teacher Profile
            |--------------------------------------------------------------------------
            */

            $this->teacherRepository->delete(
                $teacher->id
            );

            return true;
        });
    }

    /**
     * Change teacher status
     */
    public function changeStatus(
        int $id
    ) {

        $teacher =
            $this->teacherRepository->findWithUser($id);

        return $this->userRepository->changeStatus(
            $teacher->user_id,
        );
    }
}