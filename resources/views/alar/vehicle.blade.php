@extends('layouts.layout')
@section('title', 'Vehicle')

@section('content')
    @section('head', 'Vehicles')

    <div class="d-flex align-items-center justify-content-between p-2 mb-0 cust-h-heading">
    <div class="input-group cust-searchbar">
        <input type="text" id="searchInput" class="form-control" placeholder="Search Vehicle"
            style="border-radius: 0; border: none;">
        <button class="btn" id="clearSearch"
            style="background-color: #b3e6cc; color: black; border: none;">Clear</button>
    </div>
    <div>
        <a href="{{ route('Vehicle.create') }}" class="cust-btn cust-btn-primary"><i class="bi bi-plus-lg"></i> <span>Add Vehicle</span></a>
    </div>
    </div>


    {{-- Stock Table --}}
    <div class="cust-h-content overflow-auto">
        <table class="table table-hover modern-table mb-0">
            <thead>
                <tr class="table-white">
                    <th class="fw-semibold">Driver</th>
                    <th class="fw-semibold">Contact Number</th>
                    <th class="fw-semibold">Plate No.</th>
                    <th class="fw-semibold">Action</th>
                </tr>
            </thead>

            <tbody id="tableBody">
                @if ($vehData->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center text-secondary py-3">
                            No Vehicle Available.
                        </td>
                    </tr>
                @else
                    @foreach ($vehData as $row)
                        <tr>
                            <td>{{ $row->driver_name }}</td>
                            <td>{{ $row->driver_contact_number }}</td>
                            <td>{{ $row->veh_plate_no }}</td>
                            <td>
                                <a href="{{ route('Vehicle.edit', $row->id) }}" class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

    </div>

@endsection
