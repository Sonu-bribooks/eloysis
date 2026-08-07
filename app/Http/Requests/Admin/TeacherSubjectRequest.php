<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class TeacherSubjectRequest extends BaseRequest
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
        $teacherSubjectId = $this->route('teacher_subject');

        return [

            'teacher_id' => [
                'required',
                'exists:users,id',
            ],

            'class_id' => [
                'required',
                'exists:academic_classes,id',
            ],

            'subject_id' => [
                'required',
                'exists:subjects,id',

                Rule::unique('teacher_subjects')
                    ->ignore($teacherSubjectId)
                    ->where(function ($query) {

                        return $query
                            ->where(
                                'teacher_id',
                                $this->teacher_id
                            )
                            ->where(
                                'class_id',
                                $this->class_id
                            );

                    }),
            ],

            'section_id' => [
                'required',
                'exists:sections,id',

                Rule::unique('teacher_subjects')
                    ->ignore($teacherSubjectId)
                    ->where(function ($query) {

                        return $query
                            ->where(
                                'teacher_id',
                                $this->teacher_id
                            )
                            ->where(
                                'class_id',
                                $this->class_id
                            )
                            ->where(
                                'subject_id',
                                $this->subject_id
                            );

                    }),
            ],

            'status' => [
                'required',
                'boolean',
            ],

        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [

            'teacher_id.required' => 'Please select a teacher.',
            'teacher_id.exists'   => 'Selected teacher is invalid.',

            'class_id.required'   => 'Please select a class.',
            'class_id.exists'     => 'Selected class is invalid.',

            'subject_id.required' => 'Please select a subject.',
            'subject_id.exists'   => 'Selected subject is invalid.',
            'subject_id.unique'   => 'This subject has already been assigned to the selected teacher for this class.',

            'status.required'     => 'Please select status.',

        ];
    }

}
