@extends('Layout.app')

@section('content')
    <div class="card m-lg-3">
        <div class="card-header d-flex">
            <a href="{{ route('employee.index') }}">
                <box-icon name='arrow-back'></box-icon>
            </a>
            <span class="ms-2">
                Edit Employee
            </span>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif
            <form action="{{ route('employee.update',$employee->employee_id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <input type="hidden" name="employee_id" value="{{ $employee->employee_id }}">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="firstname" placeholder="***" name="firstname"
                                required value="{{ old('firstname') ?? $employee->firstname }}">
                            <label for="firstname">First Name</label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="lastname" placeholder="***" name="lastname"
                                required value="{{ old('lastname') ?? $employee->lastname }}">
                            <label for="lastname">Last Name</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="d_o_b" placeholder="***" name="date_of_birth"
                                required value="{{ old('date_of_birth') ?? $employee->date_of_birth }}">
                            <label for="d_o_b">Date of Birth</label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="educational_qualification" placeholder="***"
                                name="educational_qualification" required value="{{ old('educational_qualification') ?? $employee->educational_qualification }}">
                            <label for="qualification">Educational Qualification</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <div class="form-floating h-100">
                            <textarea type="text" class="form-control h-100" id="address" placeholder="***" name="address" required>
                                {{ old('address') ?? $employee->address }}
                            </textarea>
                            <label for="address">Address</label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" placeholder="name@example.com"
                                name="email" required value="{{ old('email') ?? $employee->email }}">
                            <label for="email">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="phone" placeholder="***" name="phone"
                                required value="{{ old('phone') ?? $employee->phone }}">
                            <label for="phone">Phone</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label" for="photo">Photo</label>
                            <input type="file" class="form-control" id="photo" placeholder="***" name="photo"
                                accept=".jpg, .jpeg, .png">
                        </div>
                        <div>
                            <img style="background-size: contain; height:100;width:100px;" src="{{ Storage::url($employee->photo) }}" alt="Employee Photo"/>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label" for="resume">Resume</label>
                            <input type="file" class="form-control" id="resume" placeholder="***" name="resume"
                                accept=".pdf, .doc, .docx">
                        </div>
                        <div>
                            <a href="{{ Storage::url($employee->resume) }}" target="_blank">view resume</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
