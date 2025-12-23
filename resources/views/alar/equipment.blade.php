@extends('layouts.layout')
@section('title', 'Equipments')

@section('content')
@section('head', 'Equipments')

    <form id="searchForm" class="d-flex align-items-center justify-content-between p-2 mb-0 cust-h-heading">
        <div class="input-group cust-searchbar">
            <input type="text"
                name="search"
                id="searchInput"
                class="form-control"
                placeholder="Search Equipment"
                value="{{ request('search') }}" style="border-radius: 0; border: none;">
            <button class="cust-btn cust-btn-search">Search</button>
        </div>
        @if(session("empRole") == 'admin' || session("empRole") == 'sadmin')
            <div>
                <a href="{{ route('Equipment.create') }}" class="cust-btn cust-btn-primary"  data-bs-toggle="tooltip" title="Add New Equipment">
                    <i class="bi bi-plus-lg"></i> Add Equipment
                </a>
            </div>
        @endif
    </form>

<!-- Equipment Table -->
<div class="cust-h-content">
    <table class="table table-hover modern-table mb-0">
        <thead class="table-light">
            <tr>
                <th class="fw-semibold">Equipment</th>
                <th class="fw-semibold">Size/Unit</th>
                <th class="fw-semibold">Net Content</th>
                <th class="fw-semibold">Available</th>
                <th class="fw-semibold">In Use</th>
                <th class="fw-semibold">Action</th>
            </tr>
        </thead>

        <tbody id="tableBody">
            @include('alar.partials.equipmentTable')
        </tbody>
    </table>
    <div id="paginationLinks">
        @include('alar.partials.equipmentPagination')
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

    function fetchEquipment(url) {
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
        fetchEquipment($(this).attr('href'));
    });

    // Live search
    $('#searchInput').on('keyup', debounce(function () {
        fetchEquipment('{{ route("Equipment.index") }}');
    }, 400));
</script>



@endsection
