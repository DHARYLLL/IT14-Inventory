@extends('layouts.layout')
@section('title', 'Purchase Order')

@section('content')

@section('head', 'Purchase Order')
@section('name', 'Staff')


<div class="d-flex align-items-center justify-content-between p-2 mb-0 cust-h-heading">
    <div class="input-group" style="max-width: 600px; border-radius: 10px; overflow: hidden;">
        <input type="text" id="searchInput" class="form-control" placeholder="Search Purchase Order"
            style="border-radius: 0; border: none;">
        <button class="btn" id="clearSearch"
            style="background-color: #b3e6cc; color: black; border: none;">Clear</button>
    </div>

    <a href="{{ route('Purchase-Order.create') }}" class="btn btn-custom d-flex align-items-center gap-2 px-3 py-2"
        style="background-color: #28a745; color: white; white-space: nowrap;">
        <i class="bi bi-plus-lg"></i><span>New Purchase Order</span>
    </a>

</div>

{{-- table --}}
    <div class="cust-h-content">
        <table class="table table-hover mb-0">
            <thead>
                <tr class="table-light">
                    <th class="fw-semibold">PO#</th>
                    <th class="fw-semibold">Supplier</th>
                    <th class="fw-semibold">Status</th>
                    <th class="fw-semibold">Total Amount</th>
                    <th class="fw-semibold">Submitted Date</th>
                    <th class="fw-semibold">Apporved Date</th>
                    <th class="fw-semibold">Delivered Date</th>
                    <th class="fw-semibold text-center">Action</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @if ($poData->isEmpty())
                    <tr>
                        <td colspan="8" class="text-center text-secondary py-3">
                            No New Purchase Order.
                        </td>
                    </tr>
                @else
                    @foreach ($poData as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->poToSup->fname }} {{ $row->poToSup->mname }} {{ $row->poToSup->lname }}</td>
                            <td>{{ $row->status }}</td>
                            <td>{{ $row->total_amount }}</td>
                            <td>{{ $row->submitted_date }}</td>
                            <td>{{ $row->approved_date }}</td>
                            <td>{{ $row->delivered_date }}</td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <a href="{{ route('Purchase-Order.show', $row->id) }}"
                                        class="btn btn-outline-success btn-md"><i class="fi fi-rr-eye" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Show"></i></a>
                                    @if ($row->status == 'Pending')
                                        <form action="{{ route('Purchase-Order.destroy', $row->id) }}" method="POST"
                                            class="m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-md">
                                                <i class="bi bi-trash" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Delete"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

@endsection
