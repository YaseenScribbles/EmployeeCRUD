<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $excludedFields = ['photo', 'resume'];

    public function collection()
    {
        return Employee::all();
    }

    public function headings(): array
    {
        return array_map(function ($field) {
            return $this->getCustomHeading($field);
        }, array_diff(Employee::first()->getFillable(), $this->excludedFields));
    }

    protected function getCustomHeading($field)
    {

        switch ($field) {
            case 'firstname':
                return 'First Name';
            case 'lastname':
                return 'Last Name';
            case 'date_of_birth':
                return 'Date of Birth';
            case 'educational_qualification':
                return 'Education';
            case 'address':
                return 'Address';
            case 'email':
                return 'Email';
            case 'phone':
                return 'Phone';
            default:
                return ucfirst(str_replace('_', ' ', $field));
        }
    }

    public function map($employee): array
    {
        return [
            $employee->firstname,
            $employee->lastname,
            \Carbon\Carbon::parse($employee->date_of_birth)->format('d-m-Y'),
            $employee->educational_qualification,
            $employee->address,
            $employee->email,
            $employee->phone,
        ];
    }
}
