@extends('layouts.layout')
@section('title', 'Logs')

@section('content')
    @section('head', 'Logs')
    @section('name', 'Staff')

    <div class="d-flex align-items-center p-2 mb-0 cust-h-heading">
        <div class="input-group" style="border-radius: 10px; overflow: hidden;">
            <input type="text" id="searchInput" class="form-control" placeholder="Search Logs"
                style="border-radius: 0; border: none;">
            <button class="btn" id="clearSearch"
                style="background-color: #b3e6cc; color: black; border: none;">Clear</button>
        </div>
    </div>

    {{-- table --}}
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
    </div>

@endsection
