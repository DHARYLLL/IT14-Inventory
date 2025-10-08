@extends('layouts.layout')
@section('title', 'Purchase Order')


@section('content')

    @section('head', 'Purchase Order')
    @section('name', 'Staff')

    
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="fw-semibold">Purchase Order Show</h2>
            <a href="{{ route('Purchase-Order.index') }}" class="btn btn-custom d-flex align-items-center gap-2">
                <span>Go Back</span>
            </a>
        </div>

        <div class="row border">

            <div class="col col-3">

                <div class="bg-white rounded border status-Pending">

                    <div class="row">
                        <div class="col col-4">
                            <p>Status:</p>
                        </div>
                        <div class="col col-8">
                            <p>{{ $poData->status }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-4">
                            <p>Submitted Date:</p>
                        </div>
                        <div class="col col-8">
                            <p>{{ $poData->submitted_date }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-4">
                            <p>Approved Date:</p>
                        </div>
                        <div class="col col-8">
                            <p>{{ $poData->approved_date }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-4">
                            <p>Delivered Date:</p>
                        </div>
                        <div class="col col-8">
                            <p>{{ $poData->delivered_date }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-4">
                            <p>Total:</p>
                        </div>
                        <div class="col col-8">
                            <p>{{ $poItemData->sum('total_amount') }}</p>


                            @if($poData->status == 'Pending')
                                <form action="{{ route('Purchase-Order.update', $poData->id) }}" method="post" class="{{ $poData->status }}">
                                    @csrf
                                    @method('put')
                                    <input type="text" name="total" value="{{ $poItemData->sum('total_amount') }}">
                                    <button type="submit">Approve</button>
                                </form>
                            @endif

                            @if($poData->status == 'Approved')
                                <form action="{{ route('Invoice.store') }}" method="POST" class="{{ $poData->status }}">
                                    @csrf
                                    <input type="text" placeholder="invoice number" name="inv_num">
                                    <input type="date" name="inv_date">
                                    <input type="text" name="total">
                                    <input type="text" name="po_id" value="{{ $poData->id }}">
                                    <button type="submit">Delivered</button>

                                </form>
                            @endif

                            @if($invData)
                                <div class="row">
                                    <div class="col col-4">
                                        <p>Invoice Number:</p>
                                    </div>
                                    <div class="col col-8">
                                        <p>{{ $invData->invoice_number }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col col-4">
                                        <p>Submitted Date:</p>
                                    </div>
                                    <div class="col col-8">
                                        <p>{{ $invData->invoice_date }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col col-4">
                                        <p>Total:</p>
                                    </div>
                                    <div class="col col-8">
                                        <p>{{ $invData->total }}</p>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>

                    

                </div>

            </div>
            <div class="col col-9">

                {{-- table --}}
                <div class="bg-white rounded border overflow-hidden">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="table-light">
                                <th class="fw-semibold">Item Name</th>
                                <th class="fw-semibold">Qty</th>
                                <th class="fw-semibold">Size/Weight</th>
                                <th class="fw-semibold">Unit Price</th>
                                <th class="fw-semibold">Total Amount</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if ($poItemData->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center text-secondary py-3">
                                        No supplies available.
                                    </td>
                                </tr>
                            @else
                                @foreach ($poItemData as $row)
                                    <tr>
                                        <td>{{ $row->item }}</td>
                                        <td>{{ $row->qty }}</td>
                                        <td>{{ $row->sizeWeight }}</td>
                                        <td>{{ $row->unit_price }}</td>
                                        <td>{{ $row->total_amount }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>


        </div>

        
    
@endsection

