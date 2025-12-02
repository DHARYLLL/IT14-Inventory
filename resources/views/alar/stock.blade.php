@extends('layouts.layout')
@section('title', 'Stock Management')

@section('content')
    @section('head', 'Stocks')

    <div class="d-flex align-items-center justify-content-between p-2 mb-0 cust-h-heading">
        <div class="input-group cust-searchbar">
            <input type="text" id="searchInput" class="form-control" placeholder="Search Stock"
                style="border-radius: 0; border: none;">
            <button class="btn" id="clearSearch"
                style="background-color: #b3e6cc; color: black; border: none;">Clear</button>
        </div>
    </div>


    {{-- Stock Table --}}
    <div class="cust-h-content overflow-auto">
        <table class="table table-hover modern-table mb-0">
            <thead>
                <tr class="table-white">
                    <th class="fw-semibold">Item #</th>
                    <th class="fw-semibold">Item Name</th>
                    <th class="fw-semibold">Size</th>
                    <th class="fw-semibold">Item Quantity</th>
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
                            <td>{{ $row->item_size}}</td>
                            <td class="{{ $row->item_qty <= 10 ? 'bg-warning-subtle' : ''}}">{{ $row->item_qty }}</td>
                            <td>
                                <a href="{{ route('Stock.edit', $row->id) }}" class="cust-btn cust-btn-secondary btn-md" 
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        {{-- Custom Pagination --}}
        <div class="d-flex justify-content-center mt-3">
            <nav aria-label="Page navigation example">
                <ul class="pagination mb-0">
                    <li class="page-item {{ $stoData->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $stoData->previousPageUrl() ?? '#' }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    @for ($i = 1; $i <= $stoData->lastPage(); $i++)
                        <li class="page-item {{ $stoData->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $stoData->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ $stoData->currentPage() == $stoData->lastPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $stoData->nextPageUrl() ?? '#' }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        {{-- Showing results text --}}
        <div class="text-center text-secondary mt-2">
            Showing {{ $stoData->firstItem() ?? 0 }} to {{ $stoData->lastItem() ?? 0 }} of
            {{ $stoData->total() ?? 0 }} results
        </div>
    </div>

@endsection
