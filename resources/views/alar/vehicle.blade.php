@extends('layouts.layout')
@section('title', 'Vehicle')

@section('content')
    @section('head', 'Vehicles')

    <div class="d-flex align-items-center justify-content-between p-2 mb-0 cust-h-heading">
        <div class="input-group cust-searchbar">
            <input type="text" id="searchInput" class="form-control" placeholder="Search Vehicle"
                style="border-radius: 0; border: none;">
            <button class="cust-btn cust-btn-search" id="clearSearch">Clear</button>
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
                    <th class="fw-semibold">Price</th>
                    <th class="col col-md-2 fw-semibold text-center">Action</th>
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
                            <td>₱{{ $row->veh_price }}</td>
                            <td class="text-center col col-md-2">
                                <div class="d-inline-flex justify-content-center gap-2">
                                    @if(session("empRole") == 'sadmin' || session("empRole") == 'admin')
                                        <a href="{{ route('Vehicle.edit', $row->id) }}" class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        
                                        <!-- Delte Button -->
                                        <button type="button" class="cust-btn cust-btn-danger-secondary" data-bs-toggle="modal" data-bs-target="#delete{{ $row->id }}">
                                        <i class="bi bi-trash" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i>
                                        </button>
                                    @else
                                        <a href="{{ route('Vehicle.show', $row->id) }}" class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Show">
                                            <i class="fi fi-rr-eye"></i>
                                        </a>
                                        
                                    @endif
                                    
                                </div>
                                
                            </td>
                            

                            <!-- Delete Modal -->
                            <div class="modal fade" id="delete{{ $row->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="delete{{ $row->id }}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="delete{{ $row->id }}Label">Delete Vehicle</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('Vehicle.destroy', $row->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-body">
                                            Are you sure you want to Delete {{ $row->driver_name }}?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="cust-btn cust-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="cust-btn cust-btn-danger-primary">Delete</button>
                                        </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

    </div>

@endsection
