@extends('layouts.layout')
@section('title', 'Equipments')

@section('content')
@section('head', 'Equipments')
<!-- Search Bar 
<div class="d-flex align-items-center gap-3 justify-content-between p-2 mb-0 cust-h-heading"> 
    <div class="input-group cust-searchbar">
        <input type="text" id="searchInput" class="form-control" placeholder="Search Equipment"
            style="border-radius: 0; border: none;">
        <button class="btn" id="clearSearch"
            style="background-color: #b3e6cc; color: black; border: none;">Clear</button>
    </div>
</div>
-->
    <form method="GET" action="{{ route('Equipment.index') }}" class="d-flex align-items-center justify-content-between p-2 mb-0 cust-h-heading">
        <div class="input-group cust-searchbar">
            <input type="text" name="search" id="searchInput"
                class="form-control" style="border-radius: 0; border: none;"
                placeholder="Search Equipment"
                value="{{ request('search') }}">
            <button class="cust-btn cust-btn-search">Search</button>
        </div>
    </form>

<!-- Equipment Table -->
<div class="cust-h-content">
    <table class="table table-hover modern-table mb-0">
        <thead class="table-light">
            <tr>
                <th class="fw-semibold">Equipment</th>
                <th class="fw-semibold">Size/Unit</th>
                <th class="fw-semibold">Available</th>
                <th class="fw-semibold">In Use</th>
                <th class="fw-semibold">Action</th>
            </tr>
        </thead>
    
        <tbody id="tableBody">
            @if ($eqData->isEmpty())
                <tr>
                    <td colspan="6" class="text-center text-secondary py-3">
                        No Equipment available.
                    </td>
                </tr>
            @else
                @foreach ($eqData as $row)
                    <tr>
                        <td>{{ $row->eq_name }}</td>
                        <td>{{ $row->eq_size }}</td>
                        <td>
                            @if($row->eq_available == 0)
                                    <p class="cust-empty">{{ $row->eq_available }} {{ $row->eq_available <= $row->eq_low_limit ? '(No stock)' : ''}}</p>
                            @else
                                @if($row->eq_available > $row->eq_low_limit)
                                    <p>{{ $row->eq_available }}</p>
                                @else
                                    <p class="cust-warning">{{ $row->eq_available }} {{ $row->eq_available <= $row->eq_low_limit ? '(Low Stock)' : ''}}</p>
                                @endif
                                
                            @endif
                            
                        </td>
                        <td>{{ $row->eq_in_use }}</td>
                        <td>
                            <a href="{{ route('Equipment.edit', $row->id) }}" class="cust-btn cust-btn-secondary btn-md" 
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
                <li class="page-item {{ $eqData->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $eqData->previousPageUrl() ?? '#' }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                @for ($i = 1; $i <= $eqData->lastPage(); $i++)
                    <li class="page-item {{ $eqData->currentPage() == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ $eqData->appends(request()->query())->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
                <li class="page-item {{ $eqData->currentPage() == $eqData->lastPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $eqData->nextPageUrl() ?? '#' }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    {{-- Showing results text --}}
    <div class="text-center text-secondary mt-2">
        Showing {{ $eqData->firstItem() ?? 0 }} to {{ $eqData->lastItem() ?? 0 }} of
        {{ $eqData->total() ?? 0 }} results
    </div>
</div>



@endsection
