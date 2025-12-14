@extends('layouts.layout')
@section('title', 'Employee')

@section('content')
    @section('head', 'Profile')

    <div class="cust-h-content-func">
        <div class="card h-100">
            <div class="card-body h-100">

                {{-- Update personal info --}}
                <form action="{{ route('Employee.update', $empData->id) }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Personal Info:</h5>
                        </div>
                    
                        <div class="col-md-4">
                            <label class="fw-semibold text-dark mb-1">First Name:</label>
                            <input type="text" name="empFname" class="form-control" value="{{ old('empFname') ?  old('empFname') : $empData->emp_fname }}">
                            @error('empFname')
                                <p class="text-danger small mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="fw-semibold text-dark mb-1">Middle Name:</label>
                            <input type="text" name="empMname" class="form-control" value="{{ old('empMname') ?  old('empMname') : $empData->emp_mname }}">
                            @error('empMname')
                                <p class="text-danger small mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="fw-semibold text-dark mb-1">Last Name:</label>
                            <input type="text" name="empLname" class="form-control" value="{{ old('empLname') ?  old('empLname') : $empData->emp_lname }}">
                            @error('empLname')
                                <p class="text-danger small mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <label class="fw-semibold text-dark mb-1">Address:</label>
                            <input type="text" name="empAddress" class="form-control" value="{{ old('empAddress') ?  old('empAddress') : $empData->emp_address }}">
                            @error('empAddress')
                                <p class="text-danger small mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="fw-semibold text-dark mb-1">Contact Number:</label>
                            <input type="text" name="empConNum" class="form-control" value="{{ old('empConNum') ?  old('empConNum') : $empData->emp_contact_number }}">
                            @error('empConNum')
                                <p class="text-danger small mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col col-auto ">
                            <label class="fw-semibold text-dark mb-1">Save Changes:</label>
                            <button type="submit" class="cust-btn cust-btn-primary"><i class="bi bi-send"></i>
                                Update Profile
                            </button>
                            @session('promt-b')
                                <p class="text-success small mt-1">{{ $value }}</p>
                            @endsession
                            @session('promt-bf')
                                <p class="text-danger small mt-1">{{ $value }}</p>
                            @endsession
                    
                        </div>
                    </div>

                    <div class="row mt-3">

                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Account:</h5>
                        </div>

                        @if(session("empRole") == 'sadmin')
                            <div class="col-md-4">
                                <label class="fw-semibold text-dark mb-1">Email:</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email', $empData->emp_email) }}">
                                @error('email')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="fw-semibold text-dark mb-1">Role:</label>
                                <select name="role" class="form-select">
                                    <option value="">Select Role</option>
                                    <option value="admin" {{ old('role', $empData->emp_role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="staff" {{ old('role', $empData->emp_role) == 'staff' ? 'selected' : '' }}>Staff</option>
                                    <option value="embalmer" {{ old('role', $empData->emp_role) == 'embalmer' ? 'selected' : '' }}>Embalmer</option>
                                    <option value="driver" {{ old('role', $empData->emp_role) == 'driver' ? 'selected' : '' }}>Driver</option>
                                </select>
                                @error('role')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror 
                                
                            </div>
                        @else
                            <div class="col-md-4">
                                <label class="fw-semibold text-dark mb-1">Email:</label>
                                <input type="text" class="form-control" value="{{ $empData->emp_email }}" readonly>
                            </div>

                            <div class="col-md-3">
                                <label class="fw-semibold text-dark mb-1">Role:</label>
                                <input type="text" class="form-control" value="{{ $empData->emp_role }}" readonly> 
                                
                            </div>
                        @endif

                        

                    </div>


                </form>


                {{-- Update password --}}
                @if(session("empRole") == 'sadmin')
                    <form action="{{ route('Employee.resetPass', $empData->id) }}" method="post">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h5 class="cust-sub-title">Reset password:</h5>
                            </div>

                            <div class="col-md-3">
                                <label class="fw-semibold text-dark">New Password:</label>
                                <input type="text" name="newPass" class="form-control" value="{{ old('newPass', 'alarMemorial') }}">
                                @error('newPass')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                                @session('promt-s')
                                    <p class="text-success small mt-1">{{ $value }}</p>
                                @endsession
                            </div>
                            <div class="col col-auto mt-4">
                                <button type="submit" class="cust-btn cust-btn-primary">Reset Password</button>
                            </div>
                            <div class="col col-auto mt-4">
                                <a href="{{ route('Employee.index') }}" class="cust-btn cust-btn-secondary">Back</a>
                            </div>
                            
                        </div>
                        
                    </form>
                    
                @else
                    <form action="{{ route('updatePassword', $empData->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h5 class="cust-sub-title">Change Password:</h5>
                            </div>
                            <div class="col-md-3">
                                <label class="fw-semibold text-dark mb-1">Current Password:</label>
                                <input type="password" name="curPass" class="form-control" value="{{ old('curPass') }}">
                                @error('curPass')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                                @session('promt')
                                    <p class="text-danger small mt-1">{{ $value }}</p>
                                @endsession
                                @session('promt-s')
                                    <p class="text-success small mt-1">{{ $value }}</p>
                                @endsession
                            </div>
                            <div class="col-md-3">
                                <label class="fw-semibold text-dark mb-1">New Password:</label>
                                <input type="password" name="newPass" class="form-control" value="{{ old('newPass') }}">
                                @error('newPass')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                                @session('promt-a')
                                    <p class="text-danger small mt-1">{{ $value }}</p>
                                @endsession
                            </div>
                            <div class="col-md-3">
                                <label class="fw-semibold text-dark mb-1">Confirm New Password:</label>
                                <input type="password" name="confPass" class="form-control" value="{{ old('confPass') }}">
                                @error('confPass')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="fw-semibold text-dark mb-1">Save Password Changes:</label>
                                <button type="submit" class="cust-btn cust-btn-primary"><i class="bi bi-send"></i>
                                    Update Password
                                </button>
                                
                            </div>
                        </div>
                    </form>
                @endif
                
                
                
            </div>
        </div>
    </div>


@endsection
