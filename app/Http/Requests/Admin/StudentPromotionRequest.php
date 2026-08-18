<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class StudentPromotionRequest extends BaseRequest
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
        return [

            'enrollment_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'enrollment_ids.*' => [
                'exists:student_enrollments,id',
            ],

            'target_academic_session_id' => [
                'required',
                'exists:academic_sessions,id',
            ],

            'target_class_id' => [
                'required',
                'exists:academic_classes,id',
            ],

            'target_section_id' => [
                'nullable',
                'exists:sections,id',
            ],

        ];
    }

    public function messages(): array
    {
        return [
            'enrollment_ids.required' => 'Please select at least one student to promote.',
            'enrollment_ids.array' => 'The selected students data is invalid.',
            'enrollment_ids.min' => 'Please select at least one student to promote.',

            'enrollment_ids.*.exists' => 'One or more selected students are invalid or no longer exist.',

            'target_academic_session_id.required' => 'Please select the target academic session.',
            'target_academic_session_id.exists' => 'The selected academic session is invalid.',

            'target_class_id.required' => 'Please select the target class.',
            'target_class_id.exists' => 'The selected class is invalid.',

            'target_section_id.exists' => 'The selected section is invalid.',
        ];
    }
}
