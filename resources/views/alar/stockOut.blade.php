@extends('layouts.layout')
@section('title', 'Stock Out')

@section('content')
    @section('head', 'Stock Out')

    <div class="d-flex align-items-center justify-content-between p-2 mb-0 cust-h-heading">
        <div class="input-group cust-searchbar">
            <input type="text" id="searchInput" class="form-control" placeholder="Search"
                style="border-radius: 0; border: none;">
            <button class="btn" id="clearSearch"
                style="background-color: #b3e6cc; color: black; border: none;">Clear</button>
        </div>
    <div>
        <a href="{{ route('Stock-Out.create') }}" class="cust-btn cust-btn-primary"><i class="bi bi-box-arrow-left"></i> <span>Stock Out</span></a>
    </div>
    </div>


    {{-- Stock Table --}}
    <div class="cust-h-content overflow-auto">
        <table class="table table-hover modern-table mb-0">
            <thead>
                <tr class="table-white">
                    <th class="fw-semibold">Reason</th>
                    <th class="fw-semibold">Stock out Date</th>
                    <th class="fw-semibold">Item Qty.</th>
                    <th class="fw-semibold">Equipment Qty.</th>
                    <th class="fw-semibold">Employee</th>
                    <th class="fw-semibold">Action</th>
                </tr>
            </thead>

            <tbody id="tableBody">
                @if ($stoOutData->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center text-secondary py-3">
                            No Items has been Stock Out.
                        </td>
                    </tr>
                @else
                    @foreach ($stoOutData as $row)
                        <tr>
                            <td>{{ $row->reason }}</td>
                            <td>{{ $row->so_date }}</td>
                            <td>{{ $row->soToSoi->count() }}</td>
                            <td>{{ $row->soToSoe->count() }}</td>
                            <td>{{ $row->soToEmp->emp_fname }} {{ $row->soToEmp->emp_lname }}</td>
                            <td>
                                <a href="{{ route('Stock-Out.show', $row->id) }}" class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                    <i class="fi fi-rr-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

    </div>

@endsection
