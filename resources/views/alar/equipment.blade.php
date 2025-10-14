@extends('layouts.layout')
@section('title', 'Equipments')

@section('content')
@section('head', 'Equipments')
@section('name', 'Staff')

<!-- Header Section -->

<div class="d-flex align-items-center gap-3 justify-content-between p-2 mb-2">
    <!-- Search Bar -->
    <div class="input-group" style="max-width: 400px; border-radius: 10px; overflow: hidden;">
        <input type="text" id="searchInput" class="form-control" placeholder="Search Equipment"
            style="border-radius: 0; border: none;">
        <button class="btn" id="clearSearch"
            style="background-color: #b3e6cc; color: black; border: none;">Clear</button>
    </div>

    <a href="{{ route('Equipment.create') }}" class="btn btn-custom d-flex align-items-center gap-2 px-3 py-2"
        style="background-color: #28a745; color: white; white-space: nowrap;">
        <i class="bi bi-plus-lg"></i><span>Add Equipment</span>
    </a>
</div>


<!-- Equipment Table -->
<div class="bg-white rounded shadow-sm border overflow-hidden">
    <table class="modern-table table-hover mb-0">
        <thead class="table-light">
            <tr>
                <th class="fw-semibold">Equipment</th>
                <th class="fw-semibold">Size/Weight</th>
                <th class="fw-semibold">Unit Price</th>
                <th class="fw-semibold">Available</th>
                <th class="fw-semibold">In Use</th>
                <th class="fw-semibold text-center">Action</th>
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
                        <td>{{ $row->eq_size_weight }}</td>
                        <td>{{ $row->eq_unit_price }}</td>
                        <td>{{ $row->eq_available }}</td>
                        <td>{{ $row->eq_in_use }}</td>
                        <td class="text-center">
                            <a href="{{ route('Equipment.show', $row->id) }}" class="btn btn-outline-success btn-md"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="View">
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
