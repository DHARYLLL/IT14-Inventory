@extends('layouts.layout')
@section('title', 'Purchase Order')


@section('content')

@section('head', 'Purchase Order')
<link rel="stylesheet" href="{{ asset('CSS/POshow.css') }}">


<div class="d-flex align-items-center justify-content-end cust-h-heading">
    <a href="{{ route('Purchase-Order.index') }}" class="btn btn-outline-success d-flex align-items-center gap-2"><i
            class="bi bi-arrow-left"></i>
        <span>Back</span>
    </a>
</div>

    <div class="cust-h">
        
        <form action="{{ route('Purchase-Order.storeApproved', $poData->id) }}" method="POST" class="h-100">
            @csrf
            @method('put')

            <div class="row h-100">
                <div class="col col-3 h-100 overflow-auto">
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
                                </div>
                            </div>
                        </div>
                        <hr>
                        {{-- Input invoice details --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row g-3">
                                    {{-- Invoice Number --}}
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold text-secondary">Invoice Number</label>
                                        <input type="text" class="form-control modern-input" name="inv_num"
                                            value="{{ old('inv_num') }}">
                                        @error('inv_num')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    {{-- Invoice Date --}}
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold text-secondary">Invoice Date</label>
                                        <input type="date" class="form-control modern-input" name="inv_date"
                                            value="{{ old('inv_date') }}">
                                        @error('inv_date')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    {{-- Delivery Date --}}
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold text-secondary">Delivery Date</label>
                                        <input type="date" class="form-control modern-input" name="del_date"
                                            value="{{ old('del_date') }}">
                                        @error('del_date')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    {{-- Total --}}
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold text-secondary">Total</label>
                                        <input type="text" class="form-control modern-input" name="total"
                                            value="{{ old('total') }}">
                                        <input type="hidden" name="po_id" value="{{ $poData->id }}">
                                        @error('total')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    {{-- Submit --}}
                                    <div class="col-12 text-center mt-4">
                                        <button class="btn btn-green w-50" type="submit">
                                            <i class="bi bi-truck"></i> Delivered
                                        </button>
                                    </div>
                                </div>
            
                                @if ($invData)
                                    <div class="d-flex flex-column gap-2">
                                        <div class="d-flex align-items-center">
                                            <label class="col-4">Invoice number</label>
                                            <span class="mx-2">:</span>
                                            <input type="text" class="form-control col" value="{{ $invData->invoice_number }}" readonly>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <label class="col-4">Invoice Date</label>
                                            <span class="mx-2">:</span>
                                            <input type="text" class="form-control col" value="{{ $invData->invoice_date }}"
                                                readonly>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <label class="col-4">Total</label>
                                            <span class="mx-2">:</span>
                                            <input type="text" class="form-control col" value="₱{{ $invData->total }}" readonly>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Show table --}}
                <div class="col col-9 h-100">
            
                    {{-- input arrived qty table --}}
                    <div class="h-1-0 overflow-auto">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Size</th>
                                    <th>Qty</th>
                                    <th>Type</th>
                                    <th>Unit Price</th>
                                    <th>Total Amount</th>
                                    @if ($poData->status == 'Approved')
                                        <th>Qty Arrived</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if ($poItemData->isEmpty())
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            No supplies available.
                                        </td>
                                    </tr>
            
                                @else
                                    @foreach ($poItemData as $row)
                                        <tr>
                                            @if ($row->type == 'Consumable')
                                                <td>
                                                    {{ $row->item }}
                                                    <input type="text" name="stockId[]" value="{{ $row->stock_id }}"
                                                        hidden>
                                                </td>
                                            @endif
                                            @if ($row->type == 'Non-Consumable')
                                                <td>
                                                    {{ $row->item }}
                                                    <input type="text" name="stockId[]" value="{{ $row->eq_id }}"
                                                        hidden>
                                                </td>
                                            @endif
                                            <td>{{ $row->size }}</td>
                                            <td>{{ $row->qty_total }}</td>
                                            <td>
                                                <span
                                                    class="{{ $row->type == 'Consumable' ? 'consumable' : 'non-consumable' }}">
                                                    {{ $row->type }}
                                                </span>
                                                <input type="text" name="type[]" value="{{ $row->type }}" hidden>
                                            </td>
                                            <td>₱{{ number_format($row->unit_price, 2) }}</td>
                                            <td>₱{{ number_format($row->total_amount, 2) }}</td>
                                            @if ($poData->status == 'Approved')
                                                <td>
                                                    <input type="number" class="form-control qty-input" name="qtyArrived[]" placeholder="Qty Arrived" value="{{ old('qtyArrived.' . $loop->index) }}">
                                                    @error('qtyArrived.' . $loop->index)
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    {{-- SHOW TOTAL --}}
                                    <tr>
                                        <td colspan="6" style="font-style: normal;" class="text-end">Total:</td>
                                        <td>₱ {{ $poItemData->sum('total_amount') }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>


    </div>

@endsection
