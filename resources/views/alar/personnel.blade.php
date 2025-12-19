@extends('layouts.layout')
@section('title', 'Personnel')

@section('content')
    @section('head', 'Personnels')

    <div class="row h-100">
        <div class="col-md-6 h-100">

            <div class="d-flex align-items-center justify-content-between p-2 mb-0 cust-h-heading">
                <div class="input-group cust-searchbar">
                    <input type="text" id="searchInputVeh" class="form-control" placeholder="Search Driver"
                        style="border-radius: 0; border: none;">
                    <button class="cust-btn cust-btn-search" id="clearSearchVeh">Clear</button>
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

                    <tbody id="tableBodyVehicle">
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
                                                
                                                <!-- Delete Button -->
                                                {{-- <button type="button" class="cust-btn cust-btn-danger-secondary" data-bs-toggle="modal" data-bs-target="#delete{{ $row->id }}">
                                                <i class="bi bi-trash" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i>
                                                </button> --}}
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

        </div>
        <div class="col-md-6 h-100">

            <div class="d-flex align-items-center justify-content-between p-2 mb-0 cust-h-heading">
                <div class="input-group cust-searchbar">
                    <input type="text" id="searchInputLe" class="form-control" placeholder="Search Embalmer"
                        style="border-radius: 0; border: none;">
                    <button class="cust-btn cust-btn-search" id="clearSearchLe">Clear</button>
                </div>
                <div>
                    <a href="{{ route('Embalmer.create') }}" class="cust-btn cust-btn-primary"><i class="bi bi-plus-lg"></i> <span>Add Embalmer</span></a>
                </div>
            </div>


            {{-- Embalmer Table --}}
            <div class="cust-h-content overflow-auto">
                <table class="table table-hover modern-table mb-0">
                    <thead>
                        <tr class="table-white">
                            <th class="fw-semibold">Name</th>
                            <th class="fw-semibold">Service Price</th>
                            <th class="col col-md-2 fw-semibold text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody id="tableBodyEmbalm">
                        @if ($leData->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center text-secondary py-3">
                                    No Embalmer Available.
                                </td>
                            </tr>
                        @else
                            @foreach ($leData as $row)
                                <tr>
                                    <td>{{ $row->embalmer_name }}</td>
                                    <td>₱{{ $row->prep_price }}</td>
                                    <td class="text-center col col-md-2">
                                        <div class="d-inline-flex justify-content-center gap-2">

                                            @if(session("empRole") == 'sadmin' || session("empRole") == 'admin')
                                                <a href="{{ route('Embalmer.edit', $row->id) }}" class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            
                                                <!-- Delte Button -->
                                                {{-- <button type="button" class="cust-btn cust-btn-danger-secondary" data-bs-toggle="modal" data-bs-target="#delete{{ $row->id }}">
                                                    <i class="bi bi-trash" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i>
                                                </button> --}}
                                            @else
                                                <a href="{{ route('Embalmer.show', $row->id) }}" class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Show">
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
                                                <h1 class="modal-title fs-5" id="delete{{ $row->id }}Label">Delete Embalmer</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('Embalmer.destroy', $row->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-body">
                                                    Are you sure you want to Delete {{ $row->embalmer_name }}?
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


        </div>
    </div>

    {{-- Custom Script --}}
    <script>

        const searchInputVeh = document.getElementById('searchInputVeh');
        const clearSearchVeh = document.getElementById('clearSearchVeh');

        if (searchInputVeh && clearSearchVeh) {
            searchInputVeh.addEventListener('input', function () {
                const filter = this.value.toLowerCase();
                const rows = document.querySelectorAll("#tableBodyVehicle tr");

                rows.forEach(row => {

                    const cells = Array.from(row.cells);
                    const match = cells.some(cell => cell.innerText.toLowerCase().includes(filter));
                    row.style.display = match ? '' : 'none';
                });
            });

            clearSearchVeh.addEventListener('click', function () {
                searchInputVeh.value = '';
                searchInputVeh.dispatchEvent(new Event('input')); // reset table
            });
        }

        const searchInputLe = document.getElementById('searchInputLe');
        const clearSearchLe = document.getElementById('clearSearchLe');

        if (searchInputLe && clearSearchLe) {
            searchInputLe.addEventListener('input', function () {
                const filter = this.value.toLowerCase();
                const rows = document.querySelectorAll("#tableBodyEmbalm tr");

                rows.forEach(row => {

                    const cells = Array.from(row.cells);
                    const match = cells.some(cell => cell.innerText.toLowerCase().includes(filter));
                    row.style.display = match ? '' : 'none';
                });
            });

            clearSearchLe.addEventListener('click', function () {
                searchInputLe.value = '';
                searchInputLe.dispatchEvent(new Event('input')); // reset table
            });
        }



    </script>
    

@endsection
