@extends('layouts.layout')
@section('title', 'Purchase Order')

@section('content')

@section('head', 'Purchase Order')
@section('name', 'Staff')


<div class="d-flex align-items-center justify-content-between p-2 mb-0 cust-h-heading">
    <div class="input-group cust-searchbar">
        <input type="text" id="searchInput" class="form-control" placeholder="Search Purchase Order"  style="border-radius: 0; border: none;">
        <button class="btn" id="clearSearch"
            style="background-color: #b3e6cc; color: black; border: none;">Clear</button>
    </div>

    <a href="{{ route('Purchase-Order.create') }}" class="cust-btn cust-btn-primary max-h">
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
                                    
                                    @if ($row->status == 'Pending')
                                        <a href="{{ route('Purchase-Order.show', $row->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                            class="cust-btn cust-btn-secondary btn-md"><i class="bi bi-pencil-square"></i></a>
                                        <form action="{{ route('Purchase-Order.destroy', $row->id) }}" method="POST"
                                            class="m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="cust-btn cust-btn-danger-secondary btn-md">
                                                <i class="bi bi-trash" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Delete"></i>
                                            </button>
                                        </form>
                                    @endif
                                    @if($row->status == 'Approved')
                                        <a href="{{ route('Purchase-Order.showApproved', $row->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                            class="cust-btn cust-btn-secondary btn-md"><i class="bi bi-pencil-square"></i></a>
                                    @endif
                                    @if($row->status == 'Delivered')
                                        <a href="{{ route('Purchase-Order.showDelivered', $row->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="View"
                                            class="cust-btn cust-btn-secondary btn-md"><i class="fi fi-rr-eye"></i></a>
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
