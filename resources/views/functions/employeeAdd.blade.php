@extends('layouts.layout')
@section('title', 'Employee')

@section('content')
    @section('head', 'Profile')

    <div class="cust-h-content-func">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('Employee.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Personal Info:</h5>
                        </div>
                    
                        <div class="col-md-4">
                            <label class="fw-semibold text-dark mb-1">First Name:</label>
                            <input type="text" name="empFname" class="form-control" value="{{ old('empFname') }}">
                            @error('empFname')
                                <p class="text-danger small mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="fw-semibold text-dark mb-1">Middle Name:</label>
                            <input type="text" name="empMname" class="form-control" value="{{ old('empMname') }}">
                            @error('empMname')
                                <p class="text-danger small mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="fw-semibold text-dark mb-1">Last Name:</label>
                            <input type="text" name="empLname" class="form-control" value="{{ old('empLname') }}">
                            @error('empLname')
                                <p class="text-danger small mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <label class="fw-semibold text-dark mb-1">Address:</label>
                            <input type="text" name="empAddress" class="form-control" value="{{ old('empAddress') }}">
                            @error('empAddress')
                                <p class="text-danger small mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="fw-semibold text-dark mb-1">Contact Number:</label>
                            <input type="text" name="empConNum" class="form-control" value="{{ old('empConNum') }}">
                            @error('empConNum')
                                <p class="text-danger small mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Email and Password:</h5>
                        </div>

                        <div class="col-md-4">
                            <label class="fw-semibold text-dark mb-1">Email:</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                            @error('email')
                                <p class="text-danger small mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="fw-semibold text-dark mb-1">Role:</label>
                            <select name="role" class="form-select">
                                <option value="">Select Role</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>staff</option>
                                <option value="embalmer" {{ old('role') == 'embalmer' ? 'selected' : '' }}>Embalmer</option>
                                <option value="driver" {{ old('role') == 'driver' ? 'selected' : '' }}>Driver</option>
                            </select>
                            @error('role')
                                <p class="text-danger small mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="w-100 mb-2"></div>

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
                    </div>


                    {{-- Submit --}}
                    <div class="row justify-content-end cust-h-submit">
                        {{-- Display Error --}}
                        <div class="col col-auto">
                            @session('promt-s')
                                <div class="text-success small mt-1">{{ $value }}</div>
                            @endsession
                        </div>

                        @if(session("empRole") == 'sadmin')
                            <div class="col col-auto">
                                <a href="{{ route('Employee.index') }}" class="cust-btn cust-btn-secondary"><i
                                    class="bi bi-arrow-left"></i>
                                    <span>Cancel</span>
                                </a>
                            </div>
                        @endif

                        {{-- Submit Button --}}
                        <div class="col col-auto ">
                        
                            <button type="submit" class="cust-btn cust-btn-primary"><i class="bi bi-send"></i>
                                Create account
                            </button>
                        
                        </div>
                    </div>
                </form>      
                
            </div>
        </div>
    </div>


@endsection
