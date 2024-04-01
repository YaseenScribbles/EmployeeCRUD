<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UpdateEmployeeRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $employeeId = $this->route('employee')->employee_id;
        return [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'date_of_birth' => 'required|date',
            'educational_qualification' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|email|unique:employees,email,' . $employeeId . ',employee_id',
            'phone' => 'required|string|min:10|max:10|unique:employees,phone,' . $employeeId . ',employee_id',
            'photo' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'resume' => 'nullable|mimes:pdf,doc,docx|max:2048'
        ];
    }
}
