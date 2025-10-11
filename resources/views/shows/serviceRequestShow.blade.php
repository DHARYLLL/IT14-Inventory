@extends('layouts.layout')
@section('title', 'Equipments')

@section('content')
    @section('head', 'Show Services Request')
    @section('name', 'Staff')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('Service-Request.index') }}" class="btn btn-custom d-flex align-items-center gap-2"><span>Back</span></a>
    </div>

    {{-- table --}}
    <div class="bg-white rounded border overflow-hidden">

        <div class="row">
            <div class="col col-5">


                <div class="row">
                    <div class="col col-4">
                        <p>Package</p>
                    </div>
                    <div class="col col-8">
                        <p>{{ $svcReqData->svcReqToPac->pkg_name }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-4">
                        <p>Client Name:</p>
                    </div>
                    <div class="col col-8">
                        <p>{{ $svcReqData->client_name }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-4">
                        <p>Contact Number:</p>
                    </div>
                    <div class="col col-8">
                        <p>{{ $svcReqData->client_contact_number }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-4">
                        <p>start date</p>
                    </div>
                    <div class="col col-8">
                        <p>{{ $svcReqData->svc_startDate }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-4">
                        <p>end date</p>
                    </div>
                    <div class="col col-8">
                        <p>{{ $svcReqData->svc_endDate }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-4">
                        <p>wake</p>
                    </div>
                    <div class="col col-8">
                        <p>{{ $svcReqData->svc_wakeLoc }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-4">
                        <p>church</p>
                    </div>
                    <div class="col col-8">
                        <p>{{ $svcReqData->svc_churchLoc }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-4">
                        <p>burial</p>
                    </div>
                    <div class="col col-8">
                        <p>{{ $svcReqData->svc_burialLoc }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-4">
                        <p>Equipment status</p>
                    </div>
                    <div class="col col-8">
                        <p>{{ $svcReqData->svc_equipment_status }}</p>
                    </div>
                </div>
                @if($svcReqData->svc_equipment_status == "Pending")

                    <div class="row">
                        <div class="col col-12">
                            <form action="{{ route('Service-Request.update', $svcReqData->id) }}" method="POST">
                                @csrf
                                @method('put')
                                <input type="text" name="status" value="{{ $svcReqData->svc_equipment_status }}" hidden>
                                <input type="text" value="{{ $svcReqData->id }}" hidden>
                                <button type="" class="btn btn-secondary w-100">Deploy Equipment</button>

                            </form>
                        </div>
                    </div>
                
                @elseif($svcReqData->svc_equipment_status == "Deployed")

                    <div class="row">
                        <div class="col col-12">
                            <form action="{{ route('Service-Request.update', $svcReqData->id ) }}" method="post">
                                @csrf
                                @method('put')
                                <input type="text" name="status" value="{{ $svcReqData->svc_equipment_status }}" hidden>
                                <input type="text" value="{{ $svcReqData->id }}" hidden>
                                <button class="btn btn-secondary w-100">Retun Equipment</button>
                            </form>
                        </div>
                    
                    </div>
                    
                @endif
                




            </div>

            <div class="col col-7">

                <div class="row">
                    <div class="col col-12">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="table-light">
                                    <th class="fw-semibold">Item name</th>
                                    <th class="fw-semibold">Size/Weight</th>
                                    <th class="fw-semibold">Qty</th>
                                </tr>
                            </thead>

                            <tbody>

                                @if ($svcStoData->isEmpty())
                                    <tr>
                                        <td colspan="3" class="text-center text-secondary py-3">
                                            No Equipment available.
                                        </td>
                                    </tr>    
                                @else
                                    @foreach($svcStoData as $row)
                                        <tr>
                                            <td>{{ $row->svcStoToSto->item_name }}</td>
                                            <td>{{ $row->svcStoToSto->size_weight }}</td>
                                            <td>{{ $row->stock_used }}</td>
                                        </tr>
                                    @endforeach
                                @endif

                                

                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="row">
                    <div class="col col-12">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="table-light">
                                    <th class="fw-semibold">Equipmet</th>
                                    <th class="fw-semibold">Borrowed Qty</th>
                                </tr>
                            </thead>

                            <tbody>

                                @if ($svcEqData->isEmpty())
                                    <tr>
                                        <td colspan="3" class="text-center text-secondary py-3">
                                            No Equipment available.
                                        </td>
                                    </tr>    
                                @else
                                    @foreach($svcEqData as $row)
                                        <tr>
                                            <td>{{ $row->svcEqToEq->eq_name }}</td>
                                            <td>{{ $row->eq_used }}</td>
                                        </tr>
                                    @endforeach
                                @endif

                                

                            </tbody>
                        </table>
                    </div>
                </div>



            </div>
        </div>
        
    </div>
@endsection