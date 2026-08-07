<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class ClassSectionRequest extends BaseRequest
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
        $id = $this->route('class-sections')?->id;
        return [
            'class_id' => [
                'required',
                'integer',
                'exists:academic_classes,id',
            ],

            'section_id' => [
                'required',
                'integer',
                'exists:sections,id',
                 Rule::unique('class_sections')
                    ->where(fn ($query) => $query->where('class_id', $this->class_id))
                    ->ignore($id),

            ],

            'status' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'class_id.required' => 'Please select a class.',
            'class_id.exists'   => 'Selected class is invalid.',

            'section_id.required'     => 'Section name is required.',
            'section_id.unique'       => 'This section already exists for the selected class.',


        ];
    }
}
