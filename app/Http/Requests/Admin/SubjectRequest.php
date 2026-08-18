<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class SubjectRequest extends BaseRequest
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
        $id = $this->route('subject')?->id;

        // dd($id);
        return [
            'subject_name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('subjects', 'subject_name')->ignore($id),
            ],

            'subject_code' => [
                'required',
                'string',
                'max:20',
            ],

            'description' => [
                'nullable',
                'string',
                'max:500',
            ],
        ];
    }

    public function messages(): array
    {
        return [

            'subject_name.required' => 'Subject name is required.',
            'subject_name.unique' => 'This subject already exists for the selected class.',

            'subject_code.required' => 'Subject code is required.',
            'subject_code.max' => 'Subject code may not be greater than 20 characters.',

        ];
    }
}
