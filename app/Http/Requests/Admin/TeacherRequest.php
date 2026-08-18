<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class TeacherRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('teacher')?->user_id;

        return [

            /*
            |--------------------------------------------------------------------------
            | User Fields
            |--------------------------------------------------------------------------
            */

            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],

            'mobile' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('users', 'mobile')->ignore($userId),
            ],

            'password' => [
                $userId ? 'nullable' : 'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'status' => [
                'required',
                'boolean',
            ],

            /*
            |--------------------------------------------------------------------------
            | Teacher Profile Fields
            |--------------------------------------------------------------------------
            */

            'employee_id' => [
                'required',
                'string',
                'max:100',
                Rule::unique('teacher_profiles', 'employee_id')
                    ->ignore($userId, 'user_id'),
            ],

            'qualification' => [
                'nullable',
                'string',
                'max:255',
            ],

            'specialization' => [
                'nullable',
                'string',
                'max:255',
            ],

            'joining_date' => [
                'nullable',
                'date',
            ],

            'dob' => [
                'nullable',
                'date',
                'before:today',
            ],

            'gender' => [
                'nullable',
                Rule::in([
                    'male',
                    'female',
                    'other',
                ]),
            ],

            'experience_years' => [
                'nullable',
                'integer',
                'min:0',
                'max:100',
            ],

            'address' => [
                'nullable',
                'string',
                'max:255',
            ],

            'city' => [
                'nullable',
                'string',
                'max:100',
            ],

            'state' => [
                'nullable',
                'string',
                'max:100',
            ],

            'pincode' => [
                'nullable',
                'string',
                'max:10',
            ],

            'emergency_contact_name' => [
                'nullable',
                'string',
                'max:150',
            ],

            'emergency_contact_mobile' => [
                'nullable',
                'string',
                'max:20',
            ],

            'profile_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

        ];
    }

    public function messages(): array
    {
        return [

            'name.required' => 'Please enter teacher name.',

            'email.required' => 'Please enter email address.',

            'email.email' => 'Please enter a valid email address.',

            'email.unique' => 'Email address already exists.',

            'mobile.unique' => 'Mobile number already exists.',

            'password.required' => 'Please enter password.',

            'password.min' => 'Password must be at least 8 characters.',

            'password.confirmed' => 'Password confirmation does not match.',

            'status.required' => 'Please select status.',

            'employee_id.required' => 'Please enter employee ID.',

            'employee_id.unique' => 'Employee ID already exists.',

            'dob.before' => 'Date of birth must be a past date.',

        ];
    }
}
