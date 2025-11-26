@extends('layouts.layout')
@section('title', 'Burial Assistance')

@section('content')
    @section('head', 'Apply Burial Assistance')

    <div class="cust-h-content-func">
        <div class="card bg-white border-0 rounded-3">
            <div class="card-body">
                
                <form action="{{ route('Burial-Assistance.store') }}" method="post" class="h-100">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">

                            <div class="row">
                                <div class="col-12">
                                    <label for="" class="form-label">Name of the Deceased:</label>
                                    <input type="text" class="form-control" value="{{ $joData->joToJod->dec_name }}" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <label for="" class="form-label">Funeral Homes:</label>
                                    <input type="text" class="form-control" value="Alar" readonly>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">

                            <div class="row">
                                <div class="col-12">
                                    <label for="" class="form-label">Address:</label>
                                    <input type="text" class="form-control" value="{{ $joData->joToJod->jod_wakeLoc }}" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <label for="amount" class="form-label">Amount:</label>
                                    <input type="text" class="form-control" name="amount" value="{{ old('amount') }}">
                                    <input type="text" name="joId" value="{{ $joData->id }}" hidden>
                                    @error('amount')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                    </div>

                    {{-- Client Information --}}
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="cust-sub-title">Client's Information</h4>
                        </div>

                        {{-- Client Information  Left Side--}}
                        <div class="col-md-6">

                            <div class="row">
                                <div class="col-12">
                                    <label for="clientName" class="form-label">Client Full Name:</label>
                                    <input type="text" class="form-control" value="{{ $joData->client_name }}" readonly>
                                    @error('clientName')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="civilStatus" class="form-label">Civil Status:</label>
                                    <select name="civilStatus" class="form-select">
                                        <option value="" {{ old('civilStatus') == '' ? 'Selected' : '' }}>None</option>
                                        <option value="Single" {{ old('civilStatus') == 'Single' ? 'Selected' : '' }}>Single</option>
                                        <option value="Married" {{ old('civilStatus') == 'Married' ? 'Selected' : '' }}>Married</option>
                                        <option value="Divorced" {{ old('civilStatus') == 'Divorced' ? 'Selected' : 'Divorced' }}>Divorced</option>
                                        <option value="Widowed" {{ old('civilStatus') == 'Widowed' ? 'Selected' : 'Widowed' }}>Widowed</option>
                                    </select>
                                    @error('civilStatus')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="religion" class="form-label">Religion:</label>
                                    <input type="text" class="form-control" name="religion" value="{{ old('religion') }}">
                                    @error('religion')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                        </div>

                        {{-- Client Information  Right Side--}}
                        <div class="col-md-6">

                            <div class="row">
                                <div class="col-md-12">
                                    <label for="address" class="form-label">Address:</label>
                                    <input type="text" class="form-control" name="address" value="{{ old('address', $joData->joToJod->jod_wakeLoc) }}">
                                    @error('address')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label for="birthDate" class="form-label">Birthdate:</label>
                                    <input type="date" class="form-control" name="birthDate" value="{{ old('birthDate') }}">
                                    @error('birthDate')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label for="gender" class="form-label">Gender:</label>
                                    <select name="gender" class="form-select">
                                        <option value="" {{ old('gender') == '' ? 'Selected' : '' }}>None</option>
                                        <option value="Male" {{ old('gender') == 'Male' ? 'Selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('gender') == 'Female' ? 'Selected' : '' }}>Female</option>
                                    </select>
                                    @error('gender')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label for="rotd" class="form-label">Relationship to the Deceased:</label>
                                    <input type="text" class="form-control" name="rotd" value="{{ old('rotd') }}">
                                    @error('rotd')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                    </div>

                    {{-- Submit --}}
                    <div class="row justify-content-end mt-4">
                        {{-- Display Error --}}
                        <div class="col col-auto">
                            @session('promt')
                                <div class="text-success small mt-1">{{ $value }}</div>
                            @endsession
                        </div>

                        <div class="col col-auto">
                            <a href="{{ route('Job-Order.showDeploy', $joData->id) }}" class="cust-btn cust-btn-secondary"><i
                                class="bi bi-arrow-left"></i>
                                <span>Cancel</span>
                            </a>
                        </div>

                        {{-- Submit Button --}}
                        <div class="col col-auto ">
                        
                            <button type="submit" class="cust-btn cust-btn-primary"><i class="bi bi-send"></i>
                                Apply
                            </button>
                        
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

@endsection
