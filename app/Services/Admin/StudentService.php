<?php

namespace App\Services\Admin;

use App\Repositories\Admin\StudentRepository;
use App\Repositories\Admin\UserRepository;
use App\Repositories\Admin\StudentEnrollmentRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use Illuminate\Support\Str;
use App\Helpers\UploadHelper;


class StudentService
{
    public function __construct(
        protected StudentRepository $studentRepository,
        protected UserRepository $userRepository,
        protected StudentEnrollmentRepository $enrollmentRepository
    ) {
    }


    /**
     * Get student listing
     */
    public function getList(array $filters = [])
    {
        
        // return $this->studentRepository->getList($filters);
        return $this->enrollmentRepository->getList($filters);
    }

    public function find(int $id)
    {
        return $this->studentRepository
            ->findWithRelations($id);
    }


    /**
     * Create student
     */
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {

            $studentRole = Role::where(
                    'slug',
                    'student'
                )->firstOrFail();
            /*
            |--------------------------------------------------------------------------
            | Create User
            |--------------------------------------------------------------------------
            */

            if(isset($data['profile_image'])){
                $data['profile_image'] = UploadHelper::upload(
                    $data['profile_image'],
                    'assets/uploads/students'
                );

            }

            $user = $this->userRepository->create([

                'name' => $data['name'],

                'email' => $data['email'],

                'mobile' => $data['mobile'] ?? null,

                'password' => Hash::make(
                    $data['password'] ?? '12345678'
                ),

                'role_id' => $studentRole->id,

                'status' => $data['status'] ?? 1,

                'created_by' => Auth::guard('admin')->id(),
                'profile_image' => $data['profile_image'] ?? null,


            ]);


            /*
            |--------------------------------------------------------------------------
            | Create Student Profile
            |--------------------------------------------------------------------------
            */

            $student = $this->studentRepository->create([

                'user_id' => $user->id,

                'admission_no' => $data['admission_no'],

                'dob' => $data['dob'] ?? null,

                'gender' => $data['gender'] ?? null,

                'address' => $data['address'] ?? null,
                'admission_date' => $data['admission_date'] ?? null,
                'blood_group' =>
                    $data['blood_group'] ?? null,

                'father_name' =>
                    $data['father_name'] ?? null,

                'mother_name' =>
                    $data['mother_name'] ?? null,

                'guardian_name' =>
                    $data['guardian_name'] ?? null,

                'guardian_mobile' =>
                    $data['guardian_mobile'] ?? null,

                'guardian_email' =>
                    $data['guardian_email'] ?? null,
                'city' =>
                    $data['city'] ?? null,

                'state' =>
                    $data['state'] ?? null,

                'pincode' =>
                    $data['pincode'] ?? null,

            ]);


            /*
            |--------------------------------------------------------------------------
            | Create Enrollment
            |--------------------------------------------------------------------------
            */

            $this->enrollmentRepository->create([
                'user_id' => $user->id,
                'stu_profile_id' => $student->id,

                'academic_session_id' =>
                    $data['academic_session_id'],

                'class_id' =>
                    $data['class_id'],

                'section_id' =>
                    $data['section_id'],

                'roll_number' =>
                    $data['roll_number'],

                'admission_date' =>
                    $data['admission_date'] ?? now(),

                'status' => 1,

            ]);


            return $student;

        });

    }

    //*******************Student Action By Student profile start*************************************** */

    // /**
    //  * Update student
    //  */
    // public function update(
    //     int $id,
    //     array $data
    // ) {

    //     return DB::transaction(function () use ($id, $data) {

    //         $student = $this->studentRepository
    //             ->findWithRelations($id);


    //         if (!$student) {

    //             throw new \Exception(
    //                 'Student not found.'
    //             );

    //         }


    //         /*
    //         |--------------------------------------------------------------------------
    //         | Update User
    //         |--------------------------------------------------------------------------
    //         */

    //         $userData = [
    //             'name'       => $data['name'],
    //             'email'      => $data['email'],
    //             'mobile'     => $data['mobile'] ?? null,
    //             'status'     => $data['status'] ?? 1,
    //             'updated_by' => Auth::guard('admin')->id(),
    //         ];

    //         // Password agar aaya ho
    //         if (!empty($data['password'])) {
    //             $userData['password'] = Hash::make($data['password']);
    //         }

    //         // Profile image agar upload hui ho
    //         if (isset($data['profile_image']) && !empty($data['profile_image'])) {
    //             $userData['profile_image'] = UploadHelper::replace($data['profile_image'],
    //                                         $student->user->profile_image,'assets/uploads/students');
    //         }

    //         $this->userRepository->update(

    //             $student->user->id, $userData

    //         );


    //         /*
    //         |--------------------------------------------------------------------------
    //         | Update Student Profile
    //         |--------------------------------------------------------------------------
    //         */

    //         $this->studentRepository->update(

    //             $student->id,

    //             [
    //                 'admission_no' =>
    //                     $data['admission_no'],

    //                 'dob' =>
    //                     $data['dob'] ?? null,

    //                 'gender' =>
    //                     $data['gender'] ?? null,

    //                 'address' =>
    //                     $data['address'] ?? null,
    //                 'admission_date' => $data['admission_date'] ?? null,
    //                 'blood_group' =>
    //                     $data['blood_group'] ?? null,

    //                 'father_name' =>
    //                     $data['father_name'] ?? null,

    //                 'mother_name' =>
    //                     $data['mother_name'] ?? null,

    //                 'guardian_name' =>
    //                     $data['guardian_name'] ?? null,

    //                 'guardian_mobile' =>
    //                     $data['guardian_mobile'] ?? null,

    //                 'guardian_email' =>
    //                     $data['guardian_email'] ?? null,
    //                 'city' =>
    //                     $data['city'] ?? null,

    //                 'state' =>
    //                     $data['state'] ?? null,

    //                 'pincode' =>
    //                     $data['pincode'] ?? null,

    //             ]

    //         );


    //         /*
    //         |--------------------------------------------------------------------------
    //         | Update Latest Enrollment
    //         |--------------------------------------------------------------------------
    //         */

    //         $enrollment = $student
    //             ->enrollments
    //             ->first();


    //         if ($enrollment) {

    //             $this->enrollmentRepository->update(

    //                 $enrollment->id,

    //                 [

    //                     'academic_session_id' =>
    //                         $data['academic_session_id'],

    //                     'class_id' =>
    //                         $data['class_id'],

    //                     'section_id' =>
    //                         $data['section_id'],

    //                     'roll_number' =>
    //                         $data['roll_number'],

    //                 ]

    //             );

    //         }


    //         return $student->fresh([
    //             'user',
    //             'enrollments',
    //         ]);

    //     });

    // }


    // /**
    //  * Delete student
    //  */
    // public function delete(int $id): bool
    // {
    //     return DB::transaction(function () use ($id) {

    //         $student = $this->studentRepository
    //             ->findWithRelations($id);


    //         if (!$student) {

    //             throw new \Exception(
    //                 'Student not found.'
    //             );

    //         }


    //         /*
    //         |--------------------------------------------------------------------------
    //         | Delete Enrollments
    //         |--------------------------------------------------------------------------
    //         */

    //         $this->enrollmentRepository
    //             ->deleteWhere([
    //                 'stu_profile_id' => $student->id,
    //             ]);


    //         /*
    //         |--------------------------------------------------------------------------
    //         | Delete Student Profile
    //         |--------------------------------------------------------------------------
    //         */

    //         $this->studentRepository
    //             ->delete($student->id);


    //         /*
    //         |--------------------------------------------------------------------------
    //         | Delete User
    //         |--------------------------------------------------------------------------
    //         */

    //         UploadHelper::delete(
    //             $student->user->profile_image
    //         );

    //         $this->userRepository
    //             ->delete($student->user->id);


    //         return true;

    //     });

    // }


    // /**
    //  * Change student status
    //  */
    // public function updateStatus(
    //     int $id
    // ) {

    //     $student = $this->studentRepository
    //         ->findWithRelations($id);


    //     if (!$student) {

    //         throw new \Exception(
    //             'Student not found.'
    //         );

    //     }

    //     return $this->userRepository->changeStatus(

    //         $student->user_id

    //     );

    // }

    //***************Student Action By Student profile End********************************* */

    //***************Student Action By Student Enrollment********************************* */

    /**
     * Update student
     */
    public function update(
        int $id,
        array $data
    ) {

        return DB::transaction(function () use ($id, $data) {

            $enrollment = $this->enrollmentRepository
                ->findWithRelations($id);

            // dd($enrollment,$enrollment->student );
            if (!$enrollment) {

                throw new \Exception(
                    'Student not found.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Update User
            |--------------------------------------------------------------------------
            */

            $userData = [
                'name'       => $data['name'],
                'email'      => $data['email'],
                'mobile'     => $data['mobile'] ?? null,
                'status'     => $data['status'] ?? 1,
                'updated_by' => Auth::guard('admin')->id(),
            ];

            // Password agar aaya ho
            if (!empty($data['password'])) {
                $userData['password'] = Hash::make($data['password']);
            }

            // Profile image agar upload hui ho
            if (isset($data['profile_image']) && !empty($data['profile_image'])) {
                $userData['profile_image'] = UploadHelper::replace($data['profile_image'],
                                            $enrollment->student->user->profile_image,'assets/uploads/students');
            }

            $this->userRepository->update(

                $enrollment->user_id, $userData

            );


            /*
            |--------------------------------------------------------------------------
            | Update Student Profile
            |--------------------------------------------------------------------------
            */

            $this->studentRepository->update(

                $enrollment->stu_profile_id,

                [
                    'admission_no' =>
                        $data['admission_no'],

                    'dob' =>
                        $data['dob'] ?? null,

                    'gender' =>
                        $data['gender'] ?? null,

                    'address' =>
                        $data['address'] ?? null,
                    'admission_date' => $data['admission_date'] ?? null,
                    'blood_group' =>
                        $data['blood_group'] ?? null,

                    'father_name' =>
                        $data['father_name'] ?? null,

                    'mother_name' =>
                        $data['mother_name'] ?? null,

                    'guardian_name' =>
                        $data['guardian_name'] ?? null,

                    'guardian_mobile' =>
                        $data['guardian_mobile'] ?? null,

                    'guardian_email' =>
                        $data['guardian_email'] ?? null,
                    'city' =>
                        $data['city'] ?? null,

                    'state' =>
                        $data['state'] ?? null,

                    'pincode' =>
                        $data['pincode'] ?? null,

                ]

            );


            /*
            |--------------------------------------------------------------------------
            | Update Latest Enrollment
            |--------------------------------------------------------------------------
            */


            if ($enrollment) {

                $this->enrollmentRepository->update(

                    $enrollment->id,

                    [

                        'academic_session_id' =>
                            $data['academic_session_id'],

                        'class_id' =>
                            $data['class_id'],

                        'section_id' =>
                            $data['section_id'],

                        'roll_number' =>
                            $data['roll_number'],

                    ]

                );

            }


            return $enrollment->fresh([
                'student.user',
            ]);

        });

    }


    /**
     * Delete student
     */
    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {

            $enrollment = $this->enrollmentRepository
                ->findWithRelations($id);


            if (!$enrollment) {

                throw new \Exception(
                    'Student not found.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Delete Enrollments
            |--------------------------------------------------------------------------
            */

            $this->enrollmentRepository
                ->delete($enrollment->id);


            /*
            |--------------------------------------------------------------------------
            | Delete Student Profile
            |--------------------------------------------------------------------------
            */

            $this->studentRepository
                ->delete($enrollment->stu_profile_id);


            /*
            |--------------------------------------------------------------------------
            | Delete User
            |--------------------------------------------------------------------------
            */

            UploadHelper::delete(
                $enrollment->student->user->profile_image
            );

            $this->userRepository
                ->delete($enrollment->user_id);


            return true;

        });

    }


    /**
     * Change student status
     */
    public function updateStatus(
        int $id
    ) {

        $enrollment = $this->enrollmentRepository
            ->findWithRelations($id);


        if (!$enrollment) {

            throw new \Exception(
                'Student not found.'
            );

        }

        $this->enrollmentRepository->changeStatus($enrollment->id);

        return $this->userRepository->changeStatus(

            $enrollment->user_id

        );

    }

}