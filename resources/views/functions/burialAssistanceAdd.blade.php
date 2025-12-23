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
                                <div class="col-md-12">
                                    <label for="" class="form-label">Name of the Deceased:</label>
                                    <input type="text" class="form-control" value="{{ $joData->joToJod->dec_fname }} {{ $joData->joToJod->dec_lname }}" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label for="" class="form-label">Funeral Homes:</label>
                                    <input type="text" class="form-control" value="Alar" readonly>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">

                            <div class="row">
                                <div class="col-md-12">
                                    <label for="" class="form-label">Address:</label>
                                    <input type="text" class="form-control" value="{{ $joData->joToJod->jod_wakeLoc }}" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label for="amount" class="form-label">Amount:</label>
                                    <input type="text" class="form-control" name="amount" value="{{ old('amount') }}">
                                    <input type="text" name="joId" value="{{ $joData->id }}" hidden>
                                    <input type="text" name="addWakeId" value="{{ $joData->joTojod->jodToAddWake->id ?? '' }}" hidden>
                                    @error('amount')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                    </div>

                    {{-- Client Information --}}
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h4 class="cust-sub-title">Client's Information</h4>
                        </div>

                        {{-- Client Information  Left Side--}}
                        <div class="col-md-6">

                            <div class="row">
                                <div class="col-md-12">
                                    <label for="clientName" class="form-label">Last Name:</label>
                                    <input type="text" class="form-control" name="cliLname" value="{{ old('cliLname', $joData->client_lname) }}">
                                    @error('cliFname')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="clientName" class="form-label">First Name:</label>
                                    <input type="text" class="form-control" name="cliFname" value="{{ old('cliFname', $joData->client_fname) }}">
                                    @error('cliFname')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="clientName" class="form-label">Middle Name:</label>
                                    <input type="text" class="form-control" name="cliMname" value="{{ old('cliMname', $joData->client_mname) }}">
                                    @error('cliFname')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
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
                                    <input type="text" class="form-control" name="address" value="{{ old('address', $joData->client_address) }}">
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

                    

                    {{-- Parent Information --}}
                    <div class="row mt-4">

                        {{-- Mother Information  Left Side--}}
                        <div class="col-md-6">

                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="cust-sub-title">Mother's Information</h4>
                                </div>
                                <div class="col-md-12">
                                    <label for="motherLname" class="form-label">Last Name:</label>
                                    <input type="text" class="form-control" name="motherLname" value="{{ old('motherLname') }}">
                                    @error('motherLname')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="motherFname" class="form-label">First Name:</label>
                                    <input type="text" class="form-control" name="motherFname" value="{{ old('motherFname') }}">
                                    @error('motherFname')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="motherMname" class="form-label">Middle Name:</label>
                                    <input type="text" class="form-control" name="motherMname" value="{{ old('motherMname') }}">
                                    @error('motherMname')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="momCivilStatus" class="form-label">Civil Status:</label>
                                    <select name="momCivilStatus" class="form-select">
                                        <option value="" {{ old('momCivilStatus') == '' ? 'Selected' : '' }}>None</option>
                                        <option value="Single" {{ old('momCivilStatus') == 'Single' ? 'Selected' : '' }}>Single</option>
                                        <option value="Married" {{ old('momCivilStatus') == 'Married' ? 'Selected' : '' }}>Married</option>
                                        <option value="Divorced" {{ old('momCivilStatus') == 'Divorced' ? 'Selected' : 'Divorced' }}>Divorced</option>
                                        <option value="Widowed" {{ old('momCivilStatus') == 'Widowed' ? 'Selected' : 'Widowed' }}>Widowed</option>
                                    </select>
                                    @error('momCivilStatus')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="momReligion" class="form-label">Religion:</label>
                                    <input type="text" class="form-control" name="momReligion" value="{{ old('momReligion') }}">
                                    @error('momReligion')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            
                        </div>

                        {{-- Father Information  Right Side--}}
                        <div class="col-md-6">

                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="cust-sub-title">Father's Information</h4>
                                </div>
                                <div class="col-md-12">
                                    <label for="fatherLname" class="form-label">Last Name:</label>
                                    <input type="text" class="form-control" name="fatherLname" value="{{ old('fatherLname') }}">
                                    @error('fatherLname')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="fatherFname" class="form-label">First Name:</label>
                                    <input type="text" class="form-control" name="fatherFname" value="{{ old('fatherFname') }}">
                                    @error('fatherFname')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="fatherMname" class="form-label">Middle Name:</label>
                                    <input type="text" class="form-control" name="fatherMname" value="{{ old('fatherMname') }}">
                                    @error('fatherMname')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="fatherCivilStatus" class="form-label">Civil Status:</label>
                                    <select name="fatherCivilStatus" class="form-select">
                                        <option value="" {{ old('fatherCivilStatus') == '' ? 'Selected' : '' }}>None</option>
                                        <option value="Single" {{ old('fatherCivilStatus') == 'Single' ? 'Selected' : '' }}>Single</option>
                                        <option value="Married" {{ old('fatherCivilStatus') == 'Married' ? 'Selected' : '' }}>Married</option>
                                        <option value="Divorced" {{ old('fatherCivilStatus') == 'Divorced' ? 'Selected' : 'Divorced' }}>Divorced</option>
                                        <option value="Widowed" {{ old('fatherCivilStatus') == 'Widowed' ? 'Selected' : 'Widowed' }}>Widowed</option>
                                    </select>
                                    @error('fatherCivilStatus')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="fatherReligion" class="form-label">Religion:</label>
                                    <input type="text" class="form-control" name="fatherReligion" value="{{ old('fatherReligion') }}">
                                    @error('fatherReligion')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>



                            </div>

                        </div>

                    </div>

                    {{-- Other Information --}}
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h4 class="cust-sub-title">Other's Information</h4>
                        </div>

                        {{-- Client Information  Left Side--}}
                        <div class="col-md-6">

                            <div class="row">
                                <div class="col-md-12">
                                    <label for="otherLname" class="form-label">Last Name:</label>
                                    <input type="text" class="form-control" name="otherLname" value="{{ old('otherLname') }}">
                                    @error('otherLname')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="otherFname" class="form-label">First Name:</label>
                                    <input type="text" class="form-control" name="otherFname" value="{{ old('otherFname') }}">
                                    @error('otherFname')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="otherMname" class="form-label">Middle Name:</label>
                                    <input type="text" class="form-control" name="otherMname" value="{{ old('otherMname') }}">
                                    @error('otherMname')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                            </div>

                            
                        </div>

                        {{-- Client Information  Right Side--}}
                        <div class="col-md-6">

                            <div class="col-md-12">
                                <label for="otherCivilStatus" class="form-label">Civil Status:</label>
                                <select name="otherCivilStatus" class="form-select">
                                    <option value="" {{ old('otherCivilStatus') == '' ? 'Selected' : '' }}>None</option>
                                    <option value="Single" {{ old('otherCivilStatus') == 'Single' ? 'Selected' : '' }}>Single</option>
                                    <option value="Married" {{ old('otherCivilStatus') == 'Married' ? 'Selected' : '' }}>Married</option>
                                    <option value="Divorced" {{ old('otherCivilStatus') == 'Divorced' ? 'Selected' : 'Divorced' }}>Divorced</option>
                                    <option value="Widowed" {{ old('otherCivilStatus') == 'Widowed' ? 'Selected' : 'Widowed' }}>Widowed</option>
                                </select>
                                @error('otherCivilStatus')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="otherReligion" class="form-label">Religion:</label>
                                <input type="text" class="form-control" name="otherReligion" value="{{ old('otherReligion') }}">
                                @error('otherReligion')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label for="relationship" class="form-label">Relationship</label>
                                    <input type="text" class="form-control" name="relationship" value="{{ old('relationship') }}">
                                    @error('relationship')
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
