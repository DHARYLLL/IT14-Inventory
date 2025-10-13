@extends('layouts.layout')
@section('title', 'Purchase Order')


@section('content')

@section('head', 'Purchase Order')
@section('name', 'Staff')
<link rel="stylesheet" href="{{ asset('CSS/POshow.css') }}">


<div class="d-flex align-items-center justify-content-end m-1">

    <a href="{{ route('Purchase-Order.index') }}" class="btn btn-custom d-flex align-items-center gap-2">
        <i class="bi bi-arrow-left"></i><span>Back</span>
    </a>
</div>

<div class="d-flex rounded gap-3">
    <div class="col col-3">
        <div class="card-custom p-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex align-items-center">
                            <label class="col-4">Status</label>
                            <span class="mx-2">:</span>
                            <input type="text" class="form-control col" value="{{ $poData->status }}" readonly>
                        </div>

                        <div class="d-flex align-items-center">
                            <label class="col-4">Submitted Date</label>
                            <span class="mx-2">:</span>
                            <input type="text" class="form-control col" value="{{ $poData->submitted_date }}"
                                readonly>
                        </div>

                        <div class="d-flex align-items-center">
                            <label class="col-4">Approve Date</label>
                            <span class="mx-2">:</span>
                            <input type="text" class="form-control col" value="{{ $poData->approved_date }}"
                                readonly>
                        </div>

                        <div class="d-flex align-items-center">
                            <label class="col-4">Delivered Date</label>
                            <span class="mx-2">:</span>
                            <input type="text" class="form-control col" value="{{ $poData->delivered_date }}"
                                readonly>
                        </div>

                        <div class="d-flex align-items-center">
                            <label class="col-4">Total</label>
                            <span class="mx-2">:</span>
                            <input type="text" class="form-control col"
                                value="{{ $poItemData->sum('total_amount') }}" readonly>
                        </div>

                    </div>
                </div>
            </div>

            <hr>

            <div class="row py-2">
                @if ($poData->status == 'Pending')
                    <form action="{{ route('Purchase-Order.update', $poData->id) }}" method="post"
                        class="{{ $poData->status }}">
                        @csrf
                        @method('put')
                        <input type="hidden" name="total" value="{{ $poItemData->sum('total_amount') }}">
                        <div class="d-flex justify-content-center mt-3">
                            <button class="btn btn-approve-custom w-75" type="submit">Approve</button>
                        </div>
                    </form>
                @endif

                @if ($invData)
                    <div class="d-flex flex-column gap-2">

                        <div class="d-flex align-items-center mt-2">
                            <label class="col-4">Invoice number</label>
                            <span class="mx-2">:</span>
                            <input type="text" class="form-control" value="{{ $invData->invoice_number }}" readonly>
                        </div>

                        <div class="d-flex align-items-center mt-2">
                            <label class="col-4">Invoice Date</label>
                            <span class="mx-2">:</span>
                            <input type="date" class="form-control my-3" value="{{ $invData->invoice_date }}"
                                readonly>
                        </div>

                        <div class="d-flex align-items-center mt-2">
                            <label class="col-4">Total</label>
                            <span class="mx-2">:</span>
                            <input type="text" class="form-control" value="{{ $invData->total }}" readonly>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col col-9 card-custom-2">


        @if ($poData->status == 'Approved')

            <form action="{{ route('Stock.store') }}" method="POST" class="{{ $poData->status }}">
                @csrf

                {{-- table --}}
                <div class="bg-white rounded border overflow-hidden" style="min-height: 70vh">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="table-light">
                                <th class="fw-semibold">Item Name</th>
                                <th class="fw-semibold">Qty</th>
                                <th class="fw-semibold">Size/Weight</th>
                                <th class="fw-semibold">Unit Price</th>
                                <th class="fw-semibold">Total Amount</th>
                                @if ($poData->status == 'Approved')
                                    <th class="fw-semibold">Qty Arrived</th>
                                @endif
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
                                        @if($row->stock_id)
                                            <td>
                                                {{ $row->item }}
                                                <input type="text" name="stockId[]" value="{{ $row->stock_id }}" hidden>
                                            </td>
                                        @endif
                                        @if($row->eq_id)
                                            <td>
                                                {{ $row->item }}
                                                <input type="text" name="stockId[]" value="{{ $row->eq_id }}" hidden>
                                            </td>
                                        @endif
                                        <td>{{ $row->sizeWeight }}</td>
                                        <td>{{ $row->qty }}</td>                                              
                                        <td>{{ $row->type }}
                                            <input type="text" name="type[]" value="{{ $row->type }}" hidden>
                                        </td>
                                        <td>{{ $row->unit_price }}</td>
                                        <td>{{ $row->total_amount }}</td>
                                        @if($poData->status == 'Approved')
                                            <td>
                                                <input type="number" name="qtyArrived[]" placeholder="Qty Arrived" value="{{ old('qtyArrived.' . $loop->index) }}">
                                                @error('qtyArrived.' . $loop->index)
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                                

                <div class="d-flex flex-column gap-2">

                    <div class="d-flex align-items-center mt-2">
                        <label class="col-4">Invoice number</label>
                        <span class="mx-2">:</span>
                        <input type="text" class="form-control" name="inv_num" value="{{ old('inv_num') }}">
                        @error("inv_num")
                            <small class="text-danger">{{ $message }}</small>
                        @enderror  
                    </div>

                    <div class="d-flex align-items-center mt-2">
                        <label class="col-4">Invoice Date</label>
                        <span class="mx-2">:</span>
                        <input type="date" class="form-control my-3" name="inv_date" value="{{ old('inv_date') }}">
                        @error("inv_date")
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="d-flex align-items-center mt-2">
                        <label class="col-4">Delivery Date</label>
                        <span class="mx-2">:</span>
                        <input type="date" class="form-control my-3" name="del_date" value="{{ old('del_date') }}">
                        @error("del_date")
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="d-flex align-items-center mt-2">
                        <label class="col-4">Total</label>
                        <span class="mx-2">:</span>
                        <input type="text" class="form-control" name="total" value="{{ old('total') }}">
                        <input type="hidden" name="po_id" value="{{ $poData->id }}">
                        @error("total")
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-center mt-2">
                        <button class="btn btn-approve-custom w-75" type="submit">Delivered</button>
                    </div>
                </div>


            </form>
        @else
            {{-- table --}}
            <div class="bg-white rounded border overflow-hidden" style="min-height: 70vh">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr class="table-light">
                            <th class="fw-semibold">Item Name</th>
                            <th class="fw-semibold">Qty</th>
                            <th class="fw-semibold">Size/Weight</th>
                            <th class="fw-semibold">Unit Price</th>
                            <th class="fw-semibold">Total Amount</th>
                            @if ($poData->status == 'Delivered')
                                <th class="fw-semibold">Qty Arrived</th>
                            @endif
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
                                    @if ($poData->status == 'Delivered')
                                        <td>
                                            {{ $row->qty_arrived }}
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
