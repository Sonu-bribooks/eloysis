<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class AcademicSectionRequest extends BaseRequest
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
        $id = $this->route('section')?->id;
        // dd($id);
        return [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('sections','name')->ignore($id),
            ],

            'code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('sections','code')->ignore($id),
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

            'name.required'     => 'Section name is required.',
            'name.unique'       => 'This section already exists for the selected class.',

            'code.max'          => 'Section code may not be greater than 20 characters.',

        ];
    }
}
