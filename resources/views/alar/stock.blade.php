@extends('layouts.layout')
@section('title', 'Stock')

@section('content')
    @section('head', 'Stocks')

    <form id="searchForm" class="d-flex align-items-center justify-content-between p-2 mb-0 cust-h-heading">
        <div class="input-group cust-searchbar">
            <input type="text"
                name="search"
                id="searchInput"
                class="form-control"
                placeholder="Search Stock"
                value="{{ request('search') }}" style="border-radius: 0; border: none;">
            <button class="cust-btn cust-btn-search">Search</button>
                
        </div>
        @if(session("empRole") == 'admin' || session("empRole") == 'sadmin')
            <div>
                <a href="{{ route('Stock.create') }}" class="cust-btn cust-btn-primary"  data-bs-toggle="tooltip" title="Add New Stock">
                    <i class="bi bi-plus-lg"></i> Add Stock
                </a>
            </div>
        @endif
        
    </form>

    <div class="cust-h-content overflow-auto">
        <table class="table table-hover modern-table mb-0">
            <thead>
                <tr class="table-white">
                    <th class="fw-semibold">Item Name</th>
                    <th class="fw-semibold">Size/Unit</th>
                    <th class="fw-semibold">Net Content</th>
                    <th class="fw-semibold">Item Quantity</th>
                    <th class="fw-semibold">Action</th>
                </tr>
            </thead>

            <tbody id="tableBody">
                @include('alar.partials.stockTable')
            </tbody>
        </table>

        <div id="paginationLinks">
            @include('alar.partials.stockPagination')
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function debounce(fn, delay) {
        let timer;
        return function () {
            clearTimeout(timer);
            timer = setTimeout(() => fn.apply(this, arguments), delay);
        };
    }

    function fetchStock(url) {
        $.ajax({
            url: url,
            data: $('#searchForm').serialize(),
            success: function (res) {
                $('#tableBody').html(res.table);
                $('#paginationLinks').html(res.pagination);

                history.pushState(
                    {},
                    '',
                    url + '?' + $('#searchForm').serialize()
                );
            }
        });
    }

    // Pagination click
    $(document).on('click', '#paginationLinks a', function (e) {
        e.preventDefault();
        fetchStock($(this).attr('href'));
    });

    // Search (live)
    $('#searchInput').on('keyup', debounce(function () {
        fetchStock('{{ route("Stock.index") }}');
    }, 400));
</script>


@endsection
