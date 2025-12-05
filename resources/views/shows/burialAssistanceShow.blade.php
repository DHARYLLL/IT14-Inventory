@extends('layouts.layout')
@section('title', 'Burial Assistance')

@section('content')
    @section('head', 'Show Burial Assistance')

    <div class="cust-h-content-func">
        <div class="card bg-white border-0 rounded-3">
            <div class="card-body">
                
                

                <div class="row cust-white-bg">
                    <div class="col-md-12">

                        <div class="row">
                            <div class="col-md-3">
                                <label for="" class="form-label">Name of the Deceased:</label>
                                <p>{{ $burrAsstData->burAsstToJo->joToJod->dec_name }}</p>
                            </div>

                            <div class="col-md-3">
                                <label for="" class="form-label">Funeral Homes:</label>
                                <p>Alar</p>
                            </div>

                             <div class="col-md-3">
                                <label for="" class="form-label">Address:</label>
                                <p>{{ $burrAsstData->burAsstToJo->joToJod->jod_wakeLoc }}</p>
                            </div>

                            <div class="col-md-3">
                                <label for="amount" class="form-label">Amount:</label>
                                <p>{{ $burrAsstData->amount }}</p>
                            </div>

                        </div>

                    </div>

                </div>

                {{-- Client Information --}}
                <div class="row cust-white-bg mt-4">
                    <div class="col-md-12">
                        <h4 class="cust-sub-title">Client's Information</h4>
                    </div>

                    <div class="col-md-12">

                        <div class="row">
                            <div class="col-md-4">
                                <label for="clientName" class="form-label">Last Name:</label>
                                <p>{{ $burrAsstData->burAsstToBac->cli_lname }}</p>
                            </div>
                            <div class="col-md-4">
                                <label for="clientName" class="form-label">First Name:</label>
                                <p>{{ $burrAsstData->burAsstToBac->cli_fname }}</p>
                            </div>
                            <div class="col-md-4">
                                <label for="clientName" class="form-label">Middle Name:</label>
                                <p>{{ $burrAsstData->burAsstToBac->cli_mname }}</p>
                            </div>

                            <div class="col-md-4">
                                <label for="address" class="form-label">Address:</label>
                                <p>{{ $burrAsstData->burAsstToBac->address }}</p>
                            </div>
                            <div class="col-md-4">
                                <label for="civilStatus" class="form-label">Civil Status:</label>
                                <p>{{ $burrAsstData->burAsstToBac->civil_status }}</p>
                            </div>
                            <div class="col-md-4">
                                <label for="religion" class="form-label">Religion:</label>
                                <p>{{ $burrAsstData->burAsstToBac->religion }}</p>
                            </div>

                            <div class="col-md-4">
                                <label for="birthDate" class="form-label">Birthdate:</label>
                                <p>{{ $burrAsstData->burAsstToBac->birthdate }}</p>
                            </div>
                            <div class="col-md-4">
                                <label for="gender" class="form-label">Gender:</label>
                                <p>{{ $burrAsstData->burAsstToBac->gender }}</p>
                            </div>
                            <div class="col-md-4">
                                <label for="rotd" class="form-label">Relationship to the Deceased:</label>
                                <p>{{ $burrAsstData->burAsstToBac->rel_to_the_dec }}</p>
                            </div>
                        </div>

                        
                    </div>

                </div>

                {{-- Mother Information --}}
                <div class="row cust-white-bg mt-4">

                    <div class="col-md-12">
                        <h4 class="cust-sub-title">Mother's Information</h4>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="motherLname" class="form-label">Last Name:</label>
                                <p>{{ $burrAsstData->burAsstToBam->lname ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-4">
                                <label for="motherFname" class="form-label">First Name:</label>
                                <p>{{ $burrAsstData->burAsstToBam->fname ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-4">
                                <label for="motherMname" class="form-label">Middle Name:</label>
                                <p>{{ $burrAsstData->burAsstToBam->mname ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-4">
                                <label for="momCivilStatus" class="form-label">Civil Status:</label>
                                <p>{{ $burrAsstData->burAsstToBam->civil_status ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-4">
                                <label for="momReligion" class="form-label">Religion:</label>
                                <p>{{ $burrAsstData->burAsstToBam->religion ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Father Information  Right Side--}}
                <div class="row cust-white-bg mt-4">
                    <div class="col-md-12">
                        <h4 class="cust-sub-title">Father's Information</h4>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="fatherLname" class="form-label">Last Name:</label>
                                <p>{{ $burrAsstData->burAsstToBaf->lname ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-4">
                                <label for="fatherFname" class="form-label">First Name:</label>
                                <p>{{ $burrAsstData->burAsstToBaf->fname ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-4">
                                <label for="fatherMname" class="form-label">Middle Name:</label>
                                <p>{{ $burrAsstData->burAsstToBaf->mname ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-4">
                                <label for="fatherCivilStatus" class="form-label">Civil Status:</label>
                                <p>{{ $burrAsstData->burAsstToBaf->civil_status ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-4">
                                <label for="fatherReligion" class="form-label">Religion:</label>
                                <p>{{ $burrAsstData->burAsstToBaf->religion ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>



                </div>

            

                {{-- Other Information --}}
                <div class="row cust-white-bg mt-4">
                    <div class="col-md-12">
                        <h4 class="cust-sub-title">Other's Information</h4>
                    </div>

                    <div class="col-md-12">

                        <div class="row">
                            <div class="col-md-4">
                                <label for="otherLname" class="form-label">Last Name:</label>
                                <p>{{ $burrAsstData->burAsstToBao->lname ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-4">
                                <label for="otherFname" class="form-label">First Name:</label>
                                <p>{{ $burrAsstData->burAsstToBao->fname ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-4">
                                <label for="otherMname" class="form-label">Middle Name:</label>
                                <p>{{ $burrAsstData->burAsstToBao->mname ?? 'N/A' }}</p>
                            </div>

                            <div class="col-md-4">
                                <label for="otherCivilStatus" class="form-label">Civil Status:</label>
                                <p>{{ $burrAsstData->burAsstToBao->civil_status ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-4">
                                <label for="otherReligion" class="form-label">Religion:</label>
                                <p>{{ $burrAsstData->burAsstToBao->religion ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-4">
                                <label for="relationship" class="form-label">Relationship</label>
                                <p>{{ $burrAsstData->burAsstToBao->relationship ?? 'N/A' }}</p>
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
                        <a href="{{ route('Burial-Assistance.back', $burrAsstData->jo_id) }}" class="cust-btn cust-btn-secondary"><i
                            class="bi bi-arrow-left"></i>
                            <span>Back</span>
                        </a>
                    </div>

                </div>
        </div>
    </div>

@endsection
