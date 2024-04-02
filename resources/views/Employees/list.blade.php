@extends('Layout.app')

@section('content')
    <div class="card m-3">
        <div class="card-header d-flex justify-content-between">
            <div>
                Employee List
            </div>

            <div class="d-flex">
                <form id="search-form" action="{{ route('employees.search') }}" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="search-term" placeholder="Search by name"
                            aria-label="search-term" aria-describedby="search-term" name="search"
                            value="{{ old('search') ?? '' }}">
                        <span class="input-group-text" id='search-icon'>
                            <box-icon name='search'></box-icon>
                        </span>
                    </div>
                </form>
            </div>

            <div>
                <a href="{{ route('employee.create') }}" class="btn btn-primary">
                    Add Employee
                </a>
                <a class="btn btn-primary" href="{{ route('employees.export') }}">Export</a>
            </div>
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
                                <form class="d-inline" action="{{ route('employee.destroy', $employee->employee_id) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        {{ $employees->links() }}
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-term');
            const searchForm = document.getElementById('search-form');

            // Retrieve and set the saved search value from localStorage
            const savedSearchValue = localStorage.getItem('search-term');
            if (savedSearchValue) {
                searchInput.value = savedSearchValue;
            }

            // Add event listener for keypress events on the search input
            searchInput.addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault(); // Prevent the default form submission behavior
                    localStorage.setItem('search-term', searchInput.value);
                    searchForm.submit(); // Submit the form
                }
            });

        });
    </script>
@endsection
