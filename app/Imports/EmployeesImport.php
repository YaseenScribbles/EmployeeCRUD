<?php

namespace App\Imports;

use App\Models\Employee;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class EmployeesImport implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            // Skip processing if all fields are null
            if ($row->filter()->isEmpty()) {
                continue;
            }

            // Preprocess date of birth field
            $dob = $this->convertDateOfBirth($row['date_of_birth']);
            $row['date_of_birth'] = $dob;

            // Preprocess phone field
            $phone = $this->cleanPhoneNumber($row['phone']);
            $row['phone'] = $phone;

            $validator = Validator::make($row->toArray(), [
                'firstname' => 'required|string',
                'lastname' => 'required|string',
                'date_of_birth' => 'required|date',
                'educational_qualification' => 'required|string',
                'address' => 'required|string',
                'email' => ['required', 'email', Rule::unique('employees', 'email')],
                'phone' => ['required', 'string', 'min:10', 'max:10', Rule::unique('employees', 'phone')],
                'photo' => 'required|string',
                'resume' => 'required|string'
            ]);

            if ($validator->fails()) {
                Log::error('Validation failed for row: ' . json_encode($row->toArray()));
                Log::error('Validation errors: ' . json_encode($validator->errors()->toArray()));
                continue;
            }

            $data = $row->toArray();

            // // Store photo
            // $photoPath = $this->storeFile($data['photo'], 'photos');
            // $data['photo'] = $photoPath;

            // // Store resume
            // $resumePath = $this->storeFile($data['resume'], 'resumes');
            // $data['resume'] = $resumePath;

            // Create employee record
            try {
                //code...
                Employee::create($data);
            } catch (\Throwable $th) {
                //throw $th;
                Log::error($th->getMessage());
            }
        }
    }

    private function storeFile($file, $directory)
    {
        $fileName = $file->getClientOriginalName();
        $filePath = $file->storeAs($directory, $fileName, 'public');

        return $filePath;
    }

    private function convertDateOfBirth($dob)
    {
        return Date::excelToDateTimeObject($dob)->format('Y-m-d');
    }

    private function cleanPhoneNumber($phone)
    {
        // Example: Convert phone number to string and remove non-numeric characters
        return preg_replace('/[^0-9]/', '', strval($phone));
    }
}
