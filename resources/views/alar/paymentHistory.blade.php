@extends('layouts.layout')
@section('title', 'SOA')

@section('content')
    @section('head', 'Statement of Account')

    <div class="d-flex align-items-center justify-content-between p-2 mb-0 cust-h-heading">
        <div class="input-group cust-searchbar">
            <input type="text" id="searchInput" class="form-control" placeholder="Search" style="border-radius: 0; border: none;">
            <button class="cust-btn cust-btn-search" id="clearSearch">Clear</button>
        </div>

        <select id="dateFilter" class="form-select w-auto">
            <option value="">All</option>
            <option value="today">Today</option>
            <option value="week">This Week</option>
            <option value="month">This Month</option>
            <option value="year">This Year</option>
        </select>
    </div>



    {{-- SOA Table --}}
    <div class="cust-h-content overflow-auto">
        <table class="table table-hover modern-table mb-0">
            <thead>
                <tr class="table-white">
                    <th>Client</th>
                    <th>Job Order</th>
                    <th>Payment</th>
                    <th>Date</th>
                    <th>Employee</th>
                </tr>
            </thead>

            <tbody id="tableBodySoa">
                @include('alar.partials.soa-table', ['soaData' => $soaData])
            </tbody>
        </table>
    </div>
<script>
    function fetchSoaData(url = null) {
        const search = document.getElementById('searchInput').value;
        const filter = document.getElementById('dateFilter').value;

        let fetchUrl = url ?? `{{ route('SOA.index') }}?search=${search}&filter=${filter}`;

        fetch(fetchUrl, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(html => {
            document.getElementById('tableBodySoa').innerHTML = html;
        });
    }

    document.getElementById('searchInput').addEventListener('keyup', () => fetchSoaData());
    document.getElementById('dateFilter').addEventListener('change', () => fetchSoaData());

    document.getElementById('clearSearch').addEventListener('click', () => {
        document.getElementById('searchInput').value = '';
        fetchSoaData();
    });

    /* Pagination click */
    document.addEventListener('click', function (e) {
        if (e.target.closest('.pagination a')) {
            e.preventDefault();
            fetchSoaData(e.target.closest('a').href);
        }
    });
</script>


    
@endsection



        