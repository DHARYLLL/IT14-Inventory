@extends('layouts.layout')
@section('title', 'Stock Management')

@section('content')
@section('head', 'Stocks')
@section('name', 'Staff')

<div class="d-flex align-items-center justify-content-between p-2 mb-0">
    <div class="input-group" style="max-width: 600px; border-radius: 10px; overflow: hidden;">
        <input type="text" id="searchInput" class="form-control" placeholder="Search Stock"
            style="border-radius: 0; border: none;">
        <button class="btn" id="clearSearch"
            style="background-color: #b3e6cc; color: black; border: none;">Clear</button>
    </div>
</div>


{{-- Stock Table --}}
<table class="table table-hover modern-table mb-0">
    <thead>
        <tr class="table-white">
            <th class="fw-semibold">Item #</th>
            <th class="fw-semibold">Item Name</th>
            <th class="fw-semibold">Size / Weight</th>
            <th class="fw-semibold">Item Quantity</th>
            <th class="fw-semibold">Unit Price</th>
            <th class="fw-semibold">Action</th>
        </tr>
    </thead>

    <tbody id="tableBody">
        @if ($stoData->isEmpty())
            <tr>
                <td colspan="6" class="text-center text-secondary py-3">
                    No Stock Item Available.
                </td>
            </tr>
        @else
            @foreach ($stoData as $row)
                <tr>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->item_name }}</td>
                    <td>{{ $row->size_weight }}</td>
                    <td>{{ $row->item_qty }}</td>
                    <td>{{ $row->item_unit_price }}</td>
                    <td>
                        <a href="{{ route('Stock.edit', $row->id) }}" class="btn btn-outline-success btn-md">
                            <i class="bi bi-pencil-square" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Edit"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

@endsection
