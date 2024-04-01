@extends('Layout.app')

@section('content')
    <div class="container mt-2">
        <div class="card">
            <div class="card-header d-flex">
                <a href="{{ route('employee.index') }}"><box-icon name='arrow-back'></box-icon></a>
                <span class="ms-2">
                    {{ $employee->firstname . ' ' . $employee->lastname. '\'s Profile' }}
                </span>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col">
                        <strong>
                            Name
                        </strong>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        {{ $employee->firstname . ' ' . $employee->lastname }}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <strong>
                            Date of birth
                        </strong>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        {{ \Carbon\Carbon::parse($employee->date_of_birth)->format('d-m-Y') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <strong>
                            Qualifications
                        </strong>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        {{ $employee->educational_qualification }}
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <strong>
                            Address
                        </strong>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        {{ $employee->address }}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <strong>
                            Email
                        </strong>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        {{ $employee->email }}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <strong>
                            Phone
                        </strong>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        {{ $employee->phone }}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <strong>
                            Photo
                        </strong>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <img style="background-size: contain; height:200px; width:200px: border-radius:25%"  src="{{ Storage::url($employee->photo) }}"
                            alt="Employee Photo">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <strong>
                            Resume
                        </strong>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <a href="{{  Storage::url($employee->resume) }}" target="_blank">View Resume</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
