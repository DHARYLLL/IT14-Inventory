@extends('layouts.layout')
@section('title', 'Stock Management')

@section('content')
    
    @section('head', 'Stock')
    @section('name', 'Staff')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="fw-semibold">Stocks</h2>
    </div>

    {{-- table --}}
    <div class="bg-white rounded border overflow-hidden">
        <table class="table table-hover mb-0">
            <thead>
                <tr class="table-light">
                    <th class="fw-semibold">Item #</th>
                    <th class="fw-semibold">Item name</th>          
                    <th class="fw-semibold">Size/Weight</th>
                    <th class="fw-semibold">Item quantity</th>
                    <th class="fw-semibold">Unit Price</th>
                    <th class="fw-semibold">Action</th>
                </tr>
            </thead>

            <tbody>
                @if ($stoData->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center text-secondary py-3">
                            No Stcok Item Available.
                        </td>
                    </tr>    
                @else
                    @foreach($stoData as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->item_name }}</td>
                            <td>{{ $row->size_weight }}</td>
                            <td>{{ $row->item_qty }}</td>
                            <td>{{ $row->item_unit_price }}</td>
                            <td>
                                <a href="{{ route('Stock.edit', $row->id) }}">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    
@endsection

