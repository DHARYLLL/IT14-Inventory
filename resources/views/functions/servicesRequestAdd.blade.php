@extends('layouts.layout')
@section('title', 'Add Service Request')

@section('content')
@section('head', 'Add Services Request')
@section('name', 'Staff')

{{-- Card Form Container --}}
    <div class="cust-h-content-func">
        <div class="card bg-white border-0 rounded-3">
            <div class="card-body">
                
                <h4 class="form-title mb-4">Service Request Form</h4>
                
                <form action="{{ route('Service-Request.store') }}" method="post">
                    @csrf


                    {{-- Package --}}
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Packages and Payment:</h5>
                        </div>

                        <div class="col-md-6">
                            <label for="package" class="form-label">Package</label>
                            <select name="package" id="package" class="form-select" onchange="PricePkg()">
                                <option value="">Select Package</option>
                                @foreach ($pkgData as $data)
                                    <option value="{{ $data->id }},{{ $data->pkg_price }}" {{ old('package') == $data->id ? 'selected' : '' }}>
                                        {{ $data->pkg_name }} | Price: ₱{{ $data->pkg_price }}
                                    </option>
                                @endforeach
                            </select>
                            @error('package')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="chapel" class="form-label">Chapel</label>
                            <select name="chapel" id="chapel" class="form-select" onchange="PriceChap()">
                                <option value="">None</option>

                                @foreach ($chapData as $data)
                                    <option value="{{ $data->id }},{{ $data->chap_price }}" {{ old('chapel') == $data->id ? 'selected' : '' }}>
                                        {{ $data->chap_name }} - Room {{ $data->chap_room }} | Price: ₱{{ $data->chap_price }}
                                    </option>
                                @endforeach
                        
                            </select>
                        
                        </div>


                        <div class="col-md-3">
                            <label for="payment" class="form-label">Total Payment</label>
                            <input type="text" class="form-control" id="totalPayment" readonly>

                            <input type="text" id="setPricePkg" readonly>
                            <input type="text" id="setPriceChap" readonly>

                            <input type="text" id="setIdPkg" readonly>
                            <input type="text" id="setIdChap" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="payment" class="form-label">Payment</label>
                            <input type="text" class="form-control" name="payment">
                            @error('payment')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <script>
                        function PricePkg(){
                            var getPkg = document.getElementById('package');

                            var getChap = document.getElementById('setPriceChap').value;                    

                            var pkgData = getPkg.options[getPkg.selectedIndex].value;
                            let forId = pkgData.slice(0, pkgData.indexOf(","));
                            let forPrice = pkgData.slice(pkgData.indexOf(",") + 1);

                            document.getElementById('setPricePkg').value = forPrice;
                            document.getElementById('setIdPkg').value = forId;
                            document.getElementById('totalPayment').value = Number(forPrice) + Number(getChap);
                        }

                        function PriceChap() {
                            var getChap = document.getElementById('chapel');

                            var getPkg = document.getElementById('setPricePkg').value;

                            var chapData = getChap.options[getChap.selectedIndex].value;
                            let forId = chapData.slice(0, chapData.indexOf(","));
                            let forPrice = chapData.slice(chapData.indexOf(",") + 1);

                            document.getElementById('setPriceChap').value = forPrice;
                            document.getElementById('setIdChap').value = forId;
                            document.getElementById('totalPayment').value = Number(forPrice) + Number(getPkg);
                        }

                    </script>



                    {{-- Client Info --}}
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Client Info:</h5>
                        </div>

                        <div class="col-md-6">
                            <label for="clientName" class="form-label">Client Name</label>
                            <input type="text" name="clientName" id="clientName" class="form-control"
                                placeholder="Enter Full Name" value="{{ old('clientName') }}">
                            @error('clientName')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="clientConNum" class="form-label">Contact Number</label>
                            <input type="text" name="clientConNum" id="clientConNum" class="form-control" placeholder="09..."
                                value="{{ old('clientConNum') }}">
                            @error('clientConNum')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>


                    {{-- Deceased Info --}}
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Deceased Info:</h5>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="" class="form-label">Name</label>
                                    <input type="text" name="decName" placeholder="Deceased Full Name" class="form-control">
                                    @error('decName')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="form-label">Born</label>
                                    <input type="date" name="decBorn" class="form-control">
                                    @error('decBorn')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="form-label">Died</label>
                                    <input type="date" name="decDied" class="form-control">
                                    @error('decDied')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="" class="form-label">Cause of Death</label>
                                    <input type="text" name="decCOD" class="form-control" placeholder="Deceasd Cause of Death">
                                    @error('decCOD')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="" class="form-label">Father Name</label>
                                    <input type="text" name="decFName" class="form-control" placeholder="Deceased Father Name">
                                    @error('decFName')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label">Mother Maiden Name</label>
                                    <input type="text" name="decMName" class="form-control" placeholder="Deceased Mother Maiden Name">
                                    @error('decMName')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>


                    {{-- Dates --}}
                    <div class="row mt-3">

                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Date:</h5>
                        </div>
                        <div class="col-md-6">
                            <label for="startDate" class="form-label">Start Date</label>
                            <input type="date" name="startDate" id="startDate" class="form-control"
                                value="{{ old('startDate') }}">
                            @error('startDate')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="endDate" class="form-label">End Date</label>
                            <input type="date" name="endDate" id="endDate" class="form-control" value="{{ old('endDate') }}">
                            @error('endDate')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    {{-- Locations --}}
                    <div class="row mt-4">

                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Location:</h5>
                        </div>

                        <div class="col-md-4">
                            <label for="wakeLoc" class="form-label">Wake Location</label>
                            <input type="text" name="wakeLoc" id="wakeLoc" class="form-control" value="{{ old('wakeLoc') }}">
                            @error('wakeLoc')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="churhcLoc" class="form-label">Church Location</label>
                            <input type="text" name="churhcLoc" id="churhcLoc" class="form-control"
                                value="{{ old('churhcLoc') }}">
                            @error('churhcLoc')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="burialLoc" class="form-label">Burial Location</label>
                            <input type="text" name="burialLoc" id="burialLoc" class="form-control"
                                value="{{ old('burialLoc') }}">
                            @error('burialLoc')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                   

                    {{-- Submit --}}
                    <div class="row justify-content-end mt-4">
                        {{-- Display Error --}}
                        <div class="col col-auto">
                             @session('')
                                    <div class="text-danger small mt-1">{{ $value }}</div>
                            @endsession
                        </div>

                        <div class="col col-auto">
                            <a href="{{ route('Service-Request.index') }}" class="cust-btn cust-btn-secondary"><i
                                class="bi bi-arrow-left"></i>
                                <span>Cancel</span>
                            </a>
                        </div>

                        {{-- Submit Button --}}
                        <div class="col col-auto ">
                        
                            <button type="submit" class="cust-btn cust-btn-primary"><i class="bi bi-send"></i>
                                Submit Request
                            </button>
                        
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

@endsection

{{-- Inline styling for this file  
        SAGDAI SA NI IDELETE RA KUNG NA BALHIN NA NINYO HAHAHAH --}}
<style>
.card-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.card-form {
    background: #ffffff;
    border-radius: 20px;
    border: 1px solid #e9ecef;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    padding: 40px;
    width: 100%;
    max-width: 1000px;
}

.form-title {
    font-size: 1.6rem;
    font-weight: 700;
    color: #333;
    border-bottom: 3px solid #60BF4F;
    display: inline-block;
    padding-bottom: 6px;
}

.btn-custom {
    background-color: #60BF4F;
    color: white;
    font-weight: 600;
    border-radius: 10px;
    padding: 10px 20px;
    border: none;
    transition: 0.2s ease;
}

.btn-custom:hover {
    background-color: #4ca63d;
    box-shadow: 0 4px 10px rgba(96, 191, 79, 0.3);
}

.btn-custom-outline {
    border: 1px solid #60BF4F;
    color: #60BF4F;
    border-radius: 10px;
    padding: 8px 18px;
    font-weight: 600;
    background-color: transparent;
    transition: 0.2s ease;
}

.btn-custom-outline:hover {
    background-color: #60BF4F;
    color: white;
}

.form-label {
    font-weight: 600;
    color: #333;
}

.form-control,
.form-select {
    border-radius: 10px;
    border: 1px solid #dee2e6;
    box-shadow: none;
}

.added-item {
    background: #f8fdf8;
    border: 1px solid #d9f3d9;
    padding: 12px 15px;
    border-radius: 10px;
}
</style>
