<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class StaffRequest extends BaseRequest
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
        $staffId = $this->route('staff')?->id;

        return [

            /*
            |--------------------------------------------------------------------------
            | User Details
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

                'max:150',

                Rule::unique(
                    'users',
                    'email'
                )->ignore(
                    $this->route('staff')?->user_id
                ),

            ],

            'mobile' => [

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

            /*
            |--------------------------------------------------------------------------
            | Staff Profile Details
            |--------------------------------------------------------------------------
            */

            'employee_id' => [

                'nullable',

                'string',

                'max:50',

                Rule::unique(

                    'staff_profiles',

                    'employee_id'

                )->ignore($staffId),

            ],

            'designation' => [

                'nullable',

                'string',

                'max:100',

            ],

            'department' => [

                'nullable',

                'string',

                'max:100',

            ],

            'joining_date' => [

                'nullable',

                'date',

            ],

            'dob' => [

                'nullable',

                'date',

            ],

            'gender' => [

                'nullable',

                Rule::in([
                    'male',
                    'female',
                    'other',
                ]),

            ],

            'address' => [

                'nullable',

                'string',

                'max:500',

            ],

            'password' => [
                $this->isMethod('POST')
                    ? 'required'
                    : 'nullable',

                'string',

                'min:8',

                'confirmed',
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

            'status' => [
                'required',
                'boolean',
            ],

        ];
    }

    /**
     * Custom Validation Messages
     */
    public function messages(): array
    {
        return [

            'name.required' => 'Please enter staff name.',

            'email.required' => 'Please enter email address.',

            'email.email' => 'Please enter a valid email address.',

            'email.unique' => 'Email address already exists.',

            'status.required' => 'Please select status.',

            'employee_id.unique' => 'Employee ID already exists.',

            'profile_image.image' => 'Profile image must be a valid image.',

            'profile_image.mimes' => 'Profile image must be jpg, jpeg, png or webp.',

            'profile_image.max' => 'Profile image must not be greater than 2 MB.',

        ];
    }
}
