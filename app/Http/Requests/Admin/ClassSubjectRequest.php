<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class ClassSubjectRequest extends BaseRequest
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
            'class_id' => [
                'required',
                'exists:academic_classes,id',
            ],

            'subject_id' => [
                'required',
                Rule::unique('class_subjects')
                    ->where(fn ($q) => $q->where(
                        'class_id',
                        $this->class_id
                    )),
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

            'subject_id.required'     => 'Please select a subject.',
            'subject_id.unique'       => 'This subject already exists for the selected class.',


        ];
    }
}
