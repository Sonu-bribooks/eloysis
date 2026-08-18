<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class AcademicSessionRequest extends BaseRequest
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
        // dd($this->all());
        $academicId = $this->route('academic')?->id;

        return [

            'session_name' => [
                'required',
                'string',
                'regex:/^\d{4}-\d{4}$/',
                Rule::unique('academic_sessions', 'name')->ignore($academicId),
            ],

            'start_year' => [
                'required',
                'digits:4',
                'integer',
                'min:2000',
            ],

            'end_year' => [
                'required',
                'digits:4',
                'integer',
                'gte:start_year',
            ],

            'start_date' => [
                'required',
                'date',
            ],

            'end_date' => [
                'required',
                'date',
                'after:start_date',
            ],

        ];
    }

    /**
     * Custom Messages
     */
    public function messages(): array
    {
        return [
            'session_name.required' => 'Academic session name is required.',
            'session_name.string' => 'Academic session name must be a valid format (example: YYYY-YYYY).',
            'session_name.regex' => 'Academic session must be in format YYYY-YYYY (example: 2025-2026).',
            'session_name.unique' => 'This academic session already exists.',

            'start_year.required' => 'Start year is required.',
            'start_year.digits' => 'Start year must be exactly 4 digits.',
            'start_year.integer' => 'Start year must be a valid number.',
            'start_year.min' => 'Start year must be greater than or equal to :min.',

            'end_year.required' => 'End year is required.',
            'end_year.digits' => 'End year must be exactly 4 digits.',
            'end_year.integer' => 'End year must be a valid number.',
            'end_year.gte' => 'End year must be greater than or equal to start year.',

            'start_date.required' => 'Start date is required.',
            'start_date.date' => 'Start date must be a valid date.',

            'end_date.required' => 'End date is required.',
            'end_date.date' => 'End date must be a valid date.',
            'end_date.after' => 'End date must be after start date.',

        ];
    }
}
