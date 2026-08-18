<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class AcademicClassRequest extends BaseRequest
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
        $classId = $this->route('class')?->id;

        return [

            'class_name' => [
                'required',
                'string',
                'max:100',
                'min:2',
                Rule::unique('academic_classes', 'class_name')->ignore($classId),
            ],

            'class_code' => [
                'required',
                'string',
                'max:50',
                'min:2',
                Rule::unique('academic_classes', 'class_code')->ignore($classId),
            ],

            'description' => [
                'nullable',
                'string',
                'max:500',
            ],

        ];
    }

    /**
     * Custom Messages
     */
    public function messages(): array
    {
        return [

            'class_name.required' => 'Please enter class name.',

            'class_name.unique' => 'Class name already exists.',

            'class_code.required' => 'class Code is required.',

            'class_code.unique' => 'class Code already exists.',

        ];
    }
}
