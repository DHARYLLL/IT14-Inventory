@extends('layouts.layout')
@section('title', 'Job Order')

@section('content')
@section('head', 'Show Job Order')

    {{-- table --}}
    <div class="cust-h">
        <div class="row h-100">
            
            <div class="col col-12 h-100 overflow-auto">
                <div class="card-custom p-3">

                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Package and Services</h5>
                        </div>
                        <div class="col-md-12">
                            <h4>Package: {{ $jodData->jodToPkg->pkg_name }}</h4>
                        </div>
                        <div class="col-md-12">
                            <h4>Chapel: {{ $jodData->chap_id ? $jodData->jodToChap->chap_name : 'N/A' }}</h4>
                        </div>
                    </div>


                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Client Info:</h5>
                        </div>

                        <div class="col-md-6">
                            <h4>Client: {{ $joData->client_name }}</h4>
                        </div>
                        <div class="col-md-6">
                            <h4>Contact Number: {{ $joData->client_contact_number }}</h4>
                        </div>

                        <div class="col-md-6">
                            <h4>Initial Payment: ₱{{ $joData->jo_dp }}</h4>
                        </div>
                        <div class="col-md-6">
                            <h4>Total Payment: ₱{{ $joData->jo_total }}</h4>
                        </div>
                    </div>


                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Job Order Details:</h5>
                        </div>

                        <div class="col-md-6">
                            <h4>Status: {{ $joData->jo_status }}</h4>
                        </div>
                        <div class="col-md-6">
                            <h4>Start Date: {{ $joData->jo_start_date }}</h4>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Deceased Info:</h5>
                        </div>

                        <div class="col-md-6">
                            <h4>Deceased Name: {{ $jodData->dec_name }}</h4>
                        </div>

                        <div class="col-md-3">
                            <h4>Birth Date: {{ $jodData->dec_born_date }}</h4>
                        </div>
                        <div class="col-md-3">
                            <h4>Died Date: {{ $jodData->dec_died_date }}</h4>
                        </div>

                        <div class="col-md-6">
                            <h4>Casue of Death: {{ $jodData->dec_cause_of_death }}</h4>
                        </div>

                    </div>


                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Location:</h5>
                        </div>

                        <div class="col-md-6">
                            <h4>Wake Location: {{ $jodData->jod_wakeLoc }}</h4>
                        </div>
                        <div class="col-md-6">
                            <h4>Burial Location: {{ $jodData->jod_burialLoc }}</h4>
                        </div>
                    </div>

                    <form action="{{ route('Job-Order.deploy', $jodData->id) }}" method="POST">
                        @csrf
                        @method('put')

                        {{-- Additional Items and Equipment --}}
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5 class="cust-sub-title">Additional Items and Equipment:</h5>
                            </div>

                            <div class="col-md-6">
                                <h4>Additional Item:</h4>
                                <div class="row">
                                    <div class="col col-3">Name</div>
                                    <div class="col col-3">Size</div>
                                    <div class="col col-3">Add. Fee</div>
                                    <div class="col col-3">Qty. Used</div>
                                </div>
                                @foreach($addStoData as $row)
                                    <div class="row mt-1">
                                        <div class="col col-3">{{ $row->addStoToSto->item_name }}</div>
                                        <div class="col col-3">{{ $row->addStoToSto->item_size }}</div>
                                        <div class="col col-3">Add. Fee</div>
                                        <div class="col col-3">
                                            {{ $row->stock_dpl }}
                                            <input type="text" name="addStoId[]" value="{{ $row->addStoToSto->id }}" hidden>
                                            <input type="text" name="addStoDepl[]" value="{{ $row->stock_dpl }}" hidden>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="col-md-6">
                        
                                <h4>Additional Equipment:</h4>
                                <div class="row mt-1">
                                    <div class="col col-3">Name</div>
                                    <div class="col col-3">Size</div>
                                    <div class="col col-3">Add. Fee</div>
                                    <div class="col col-3">Qty. Used</div>
                                </div>
                                @foreach($addEqData as $row)
                                    <div class="row">
                                        <div class="col col-3">{{ $row->addEqToEq->eq_name }}</div>
                                        <div class="col col-3">{{ $row->addEqToEq->eq_size }}</div>
                                        <div class="col col-3">Add. Fee</div>
                                        <div class="col col-3">
                                            {{ $row->eq_dpl }}
                                            <input type="text" name="addEqId[]" value="{{ $row->addEqToEq->id }}" hidden>
                                            <input type="text" name="addEqDepl[]" value="{{ $row->eq_dpl }}" hidden>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>


                        {{-- Package Items and Equipment --}}
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5 class="cust-sub-title">Package Items and Equipment:</h5>
                            </div>
                            <div class="col-md-6">
                                <h4>Item:</h4>
                                <div class="row">
                                    <div class="col col-3">Name</div>
                                    <div class="col col-3">Size</div>
                                    <div class="col col-3">Qty. Used</div>
                                    <div class="col col-3">Qty. Depl.</div>
                                </div>
                                @php
                                    $oldStoDepl = old('stoDepl', ['']);
                                @endphp
                                @foreach($pkgStoData as $row)
                                    <div class="row mt-1">
                                        <div class="col col-3">{{ $row->pkgStoToSto->item_name }}</div>
                                        <div class="col col-3">{{ $row->pkgStoToSto->item_size }}</div>
                                        <div class="col col-3">{{ $row->stock_used }}</div>
                                        <div class="col col-3">{{ $row->pkgStoToSto->id }}</div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-6">
                        
                                <h4>Equipment:</h4>
                                <div class="row">
                                    <div class="col col-3">Name</div>
                                    <div class="col col-3">Size</div>
                                    <div class="col col-3">Qty. Used</div>
                                    <div class="col col-3">Qty. Depl.</div>
                                </div>
                                @foreach($tempEqData as $row)
                                    <div class="row mt-1">
                                        <div class="col col-3">{{ $row->tempEqToPkgEq->pkgEqToEq->eq_name }}</div>
                                        <div class="col col-3">{{ $row->tempEqToPkgEq->pkgEqToEq->eq_size }}</div>
                                        <div class="col col-3">{{ $row->tempEqToPkgEq->eq_used }}</div>
                                        <div class="col col-3">{{ $row->eq_dpl_qty }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="row justify-content-end mt-4">
                            {{-- Display Error --}}
                            <div class="col col-auto">
                                @session('promt')
                                    <div class="text-danger small mt-1">{{ $value }}</div>
                                @endsession
                                @session('promt-s')
                                    <div class="text-success small mt-1">{{ $value }}</div>
                                @endsession
                            </div>
                            <div class="col col-auto">
                                <a href="{{ route('Job-Order.index') }}" class="cust-btn cust-btn-secondary"><i
                                    class="bi bi-arrow-left"></i>
                                    <span>Back</span>
                                </a>
                            </div>
                        </div>
                    </form>
                    

                </div>
            </div>
            
        </div>
    </div>
@endsection