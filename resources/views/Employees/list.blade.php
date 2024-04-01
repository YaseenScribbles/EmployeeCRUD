@extends('Layout.app')

@section('content')
    <div class="card m-3">
        <div class="card-header d-flex justify-content-between">
            <span class="align-self-center">
                Employee List
            </span>
            <a href="{{ route('employee.create') }}" class="btn btn-primary">
                Add Employee
            </a>
        </div>
        <div class="card-body">
            <table class="table table-striped table-responsive">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>DOB</th>
                        <th>Qualification</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Photo</th>
                        <th>Resume</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            <td>{{ Str::ucfirst($employee->firstname) }}</td>
                            <td>{{ Str::ucfirst($employee->lastname) }}</td>
                            <td>{{ \Carbon\Carbon::parse($employee->date_of_birth)->format('d-m-Y') }}</td>
                            <td>{{ Str::upper($employee->educational_qualification) }}</td>
                            <td>{{ $employee->address }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->phone }}</td>
                            <td>{{ $employee->photo ? 'Yes' : 'No' }}</td>
                            <td>{{ $employee->resume ? 'Yes' : 'No' }}</td>
                            <td>
                                <a class="btn btn-outline-success"
                                    href="{{ route('employee.show', $employee->employee_id) }}">View</a>
                                <a class="btn btn-outline-primary"
                                    href="{{ route('employee.edit', $employee->employee_id) }}">Edit</a>
                                <form class="d-inline" action="{{ route('employee.destroy', $employee->employee_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $employees->links() }}
        </div>
    </div>
@endsection

@section('scripts')
@endsection
