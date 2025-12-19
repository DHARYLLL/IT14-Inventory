@extends('layouts.layout')
@section('title', 'Job Order')

@section('content')
@section('head', 'Job Order')

{{-- Header, Search & Filter --}}
<form id="filterForm" class="d-flex align-items-center justify-content-between p-2 mb-0 cust-h-heading">

    <div class="input-group cust-searchbar">
        <input type="text" name="search" id="searchInput" value="{{ request('search') }}" class="form-control" placeholder="Search" style="border-radius: 0; border: none;">

        <a href="{{ route('Job-Order.index') }}" class="cust-btn cust-btn-search"  style="border-radius: 0; border: none;">Clear</a>
    </div>


    <div class="row">
        <div class="col col-auto">
            <div class="cust-fit-w">
                <select class="form-select" name="filter" id="filterSelect">
                    <option value="all" {{ request('filter')=='all' ? 'selected' : '' }}>All</option>
                    <option value="pending" {{ request('filter')=='pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ request('filter')=='paid' ? 'selected' : '' }}>Paid</option>
                    <option value="package" {{ request('filter')=='package' ? 'selected' : '' }}>Package</option>
                    <option value="service" {{ request('filter')=='service' ? 'selected' : '' }}>Service</option>
                </select>
            </div>
        </div>
        <div class="col-auto">
            <div class="dropdown">
                <button class="cust-btn cust-btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-plus-lg"></i> New Job Order
                </button>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('Service-Request.create') }}" class="dropdown-item">New Service</a></li>
                    <li><a href="{{ route('Job-Order.create') }}" class="dropdown-item">New Package</a></li>
                </ul>
            </div>
        </div>
    </div>
</form>

{{-- Table --}}
<div class="cust-h-content">
    <table class="table table-hover mb-0">
        <thead>
            <tr class="table-light">
                <th class="fw-semibold">Client</th>
                <th class="fw-semibold">GL</th>
                <th class="fw-semibold">RA</th>
                <th class="fw-semibold">Address</th>
                <th class="fw-semibold">Casket</th>
                <th class="fw-semibold">Amount</th>
                <th class="fw-semibold">Contact #</th>
                <th class="col-md-2 fw-semibold text-center">Action</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @include('alar.partials.jobOrderTable')
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-3" id="paginationLinks">
        <nav aria-label="Page navigation example">
            <ul class="pagination mb-0">
                <li class="page-item {{ $jOData->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $jOData->previousPageUrl() ?? '#' }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                @for ($i = 1; $i <= $jOData->lastPage(); $i++)
                    <li class="page-item {{ $jOData->currentPage() == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ $jOData->appends(request()->query())->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
                <li class="page-item {{ $jOData->currentPage() == $jOData->lastPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $jOData->nextPageUrl() ?? '#' }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    {{-- Showing results text --}}
    <div class="text-center text-secondary mt-2">
        Showing {{ $jOData->firstItem() ?? 0 }} to {{ $jOData->lastItem() ?? 0 }} of {{ $jOData->total() ?? 0 }} results
    </div>
</div>

{{-- JavaScript --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // RA checkbox auto-submit
    function initRA() {
        document.querySelectorAll('.raCheckbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                this.closest('form').submit();
            });
        });
    }
    initRA();

    // Debounce function
    function debounce(func, delay) {
        let timer;
        return function() {
            clearTimeout(timer);
            timer = setTimeout(() => func.apply(this, arguments), delay);
        };
    }

    // Fetch table data via AJAX
    function fetchData(url) {
        $.ajax({
            url: url,
            data: $('#filterForm').serialize(),
            success: function(data) {
                $('#tableBody').html(data);
                initRA(); // Re-init checkbox events
                window.history.pushState("", "", url + '?' + $('#filterForm').serialize());
            }
        });
    }

    // Pagination link click
    $(document).on('click', '#paginationLinks a.page-link', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');
        if(url && url != '#') fetchData(url);
    });

    // Search input keyup with debounce
    $('#searchInput').on('keyup', debounce(function() {
        fetchData('{{ route("Job-Order.index") }}');
    }, 500));

    // Filter select change
    $('#filterSelect').on('change', function() {
        fetchData('{{ route("Job-Order.index") }}');
    });
</script>

@endsection
