<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare data before validation
     */
    protected function prepareForValidation(): void
    {
        if ($this->filled('role_name') && empty($this->slug)) {

            $this->merge([
                'slug' => Str::slug($this->name)
            ]);

        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
       $roleId = $this->route('role')?->id;

        return [

            'role_name' => [
                'required',
                'string',
                'max:100',
                'min:3',
                Rule::unique('roles', 'role_name')->ignore($roleId),
            ],

            // 'slug' => [
            //     'required',
            //     'string',
            //     'max:100',
            //     Rule::unique('roles', 'slug')->ignore($roleId),
            // ],

            'description' => [
                'nullable',
                'string',
                'max:500',
            ],

            'status' => [
                'required',
                'boolean',
            ],

        ];
    }

    /**
     * Custom Messages
     */
    public function messages(): array
    {
        return [

            'role_name.required' => 'Please enter role name.',

            'role_name.unique' => 'Role name already exists.',

            'slug.required' => 'Slug is required.',

            'slug.unique' => 'Slug already exists.',

            'status.required' => 'Please select status.',

        ];
    }

}
