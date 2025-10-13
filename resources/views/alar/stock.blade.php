@extends('layouts.layout')
@section('title', 'Stock Management')

@section('head', 'Stocks')
@section('name', 'Staff')

@section('content')


    {{-- Stock Table --}}
    <table class="table table-hover modern-table">
        <thead>
            <tr>
                <th>Item #</th>
                <th>Item Name</th>
                <th>Size / Weight</th>
                <th>Item Quantity</th>
                <th>Unit Price</th>
            </tr>
        </thead>
        <tbody>
            @if ($stoData->isEmpty())
                <tr>
                    <td colspan="5" class="text-center text-secondary py-4">
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
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
