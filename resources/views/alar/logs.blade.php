@extends('layouts.layout')
@section('title', 'Logs')

@section('content')
    @section('head', 'Logs')
    
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
