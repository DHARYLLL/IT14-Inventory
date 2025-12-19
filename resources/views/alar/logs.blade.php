@extends('layouts.layout')
@section('title', 'Logs')

@section('content')
    @section('head', 'Logs')

    {{-- <div class="d-flex align-items-center p-2 mb-0 cust-h-heading">
        <div class="input-group" style="border-radius: 10px; overflow: hidden;">
            <input type="text" id="searchInput" class="form-control" placeholder="Search Logs"
                style="border-radius: 0; border: none;">
            <button class="btn" id="clearSearch"
                style="background-color: #b3e6cc; color: black; border: none;">Clear</button>
        </div>
    </div>

    <div class="cust-h-content">
        <table class="table table-hover mb-0 ">
            <thead>
                <tr class="table-light">
                    <th class="fw-semibold">ID</th>
                    <th class="fw-semibold">Employee</th>
                    <th class="fw-semibold">Transaction</th>
                    <th class="fw-semibold">Description</th>
                    <th class="fw-semibold">Date</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @if ($logData->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center text-secondary py-3">
                            No Recent Activity.
                        </td>
                    </tr>
                @else
                    @foreach ($logData as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->logToEmp->emp_fname }} {{ $row->logToEmp->emp_mname }} {{ $row->logToEmp->emp_lname }}
                            </td>
                            <td>{{ $row->transaction }}</td>
                            <td>{{ $row->tx_desc }}</td>
                            <td>{{ $row->tx_date }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div> --}}
    <div class="d-flex align-items-center p-2 mb-0 cust-h-heading">
    <div class="input-group" style="border-radius: 10px; overflow: hidden;">
        <input type="text" id="searchInput" class="form-control"
               placeholder="Search Logs" style="border-radius: 0; border: none;">
        <button class="btn" id="clearSearch"
                style="background-color: #b3e6cc; border: none;">
            Clear
        </button>
    </div>
</div>

<div class="cust-h-content">
    <table class="table table-hover mb-0">
        <thead>
            <tr class="table-light">
                <th>ID</th>
                <th>Employee</th>
                <th>Transaction</th>
                <th>Description</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @include('alar.partials.logs-table')
        </tbody>
    </table>
</div>

<script>
const searchInput = document.getElementById('searchInput');
const clearBtn = document.getElementById('clearSearch');
let timer = null;

searchInput.addEventListener('keyup', () => {
    clearTimeout(timer);
    timer = setTimeout(() => {
        loadLogs(searchInput.value);
    }, 400);
});

clearBtn.addEventListener('click', () => {
    searchInput.value = '';
    loadLogs('');
});

function loadLogs(search = '', page = 1) {
    fetch(`{{ route('Log.index') }}?search=${encodeURIComponent(search)}&page=${page}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.text())
    .then(html => {
        document.getElementById('tableBody').innerHTML = html;
        bindPagination();
    });
}

function bindPagination() {
    document.querySelectorAll('.pagination a').forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            if (link.closest('.disabled')) return;

            const url = new URL(link.href);
            loadLogs(searchInput.value, url.searchParams.get('page'));
        });
    });
}

bindPagination();
</script>


@endsection
