<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::paginate(10);
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
        }  else {
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
}
