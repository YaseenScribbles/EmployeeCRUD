<?php

namespace App\Http\Controllers;

use App\Exports\EmployeesExport;
use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Imports\EmployeesImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::simplePaginate(10);
        return view('Employees.list', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Employees.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        $data = $request->validated();

        $photo = $request->file('photo');
        $photo_path = $photo->store('photos', 'public');

        $resume = $request->file('resume');
        $resume_path = $resume->store('resumes', 'public');

        $data['photo'] = $photo_path;
        $data['resume'] = $resume_path;

        Employee::create($data);

        return redirect()->route('employee.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return view('Employees.view', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return view('Employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $data = $request->validated();

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            Storage::delete($employee->photo);

            $photo = $request->file('photo');
            $photo_path = $photo->store('photos', 'public');
            $data['photo'] = $photo_path;
        } else {
            unset($data['photo']);
        }
        if ($request->hasFile('resume') && $request->file('resume')->isValid()) {
            Storage::delete($employee->resume);

            $resume = $request->file('resume');
            $resume_path = $resume->store('resumes', 'public');
            $data['resume'] = $resume_path;
        } else {
            unset($data['resume']);
        }

        $employee->update($data);

        return redirect()->route('employee.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employee.index');
    }

    public function export()
    {
        return Excel::download(new EmployeesExport, 'employees.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls', // Ensure the uploaded file is an Excel file
        ]);

        try {
            Excel::import(new EmployeesImport, $request->file('file'));

            return redirect()->route('employee.index');
        } catch (\Exception $e) {
            // Handle import errors
            return redirect()->back()->with('error', 'Error importing employees: ' . $e->getMessage());
        }
    }

    public function sample()
    {
        $path = Storage::path('public/sample/sample.xlsx');
        return response()->download($path, 'sample.xlsx');
    }

    public function search(Request $request)
    {

        $searchTerm = $request->query('search');
        try {
            $employees = Employee::where('firstname', 'like', '%' . $searchTerm . '%')
                ->orWhere('lastname', 'like', '%' . $searchTerm . '%')
                ->simplePaginate(10);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            $employees = [];
        }

        return view('Employees.list',compact('employees'));
    }
}
