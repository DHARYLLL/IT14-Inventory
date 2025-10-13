@extends('layouts.layout')
@section('title', 'Equipments')

@section('content')
@section('head', 'Equipments')
@section('name', 'Staff')
{{--
<div class="d-flex align-items-center justify-content-between equipment-header">
    <h2 class="fw-semibold"></h2>
    <!-- Trigger Modal -->
    <button class="btn btn-green d-flex align-items-center gap-2" data-bs-toggle="modal"
        data-bs-target="#addEquipmentModal">
        <i class="bi bi-plus-lg"></i><span>Add Equipment</span>
    </button>
</div>

{{-- Equipment Table --}}

<table class="modern-table table-hover mb-0">
    <thead>
        <tr>
            <th class="fw-semibold">Equipment</th>
            <th class="fw-semibold">Available</th>
            <th class="fw-semibold">In use</th>
            <th class="fw-semibold">Action</th>
        </tr>
    </thead>

    <tbody>
        @if ($eqData->isEmpty())
            <tr>
                <td colspan="4" class="text-center text-secondary py-3">
                    No Equipment available.
                </td>
            </tr>
        @else
            @foreach ($eqData as $row)
                <tr>
                    <td>{{ $row->eq_name }}</td>
                    <td>{{ $row->eq_available }}</td>
                    <td>{{ $row->eq_in_use }}</td>
                    <td>
                        <a href="{{ route('Equipment.show', $row->id) }}" class="btn btn-outline-success btn-md">
                            <i class="fi fi-rr-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="View"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>


<!-- Add Equipment Modal -->
<div class="modal fade" id="addEquipmentModal" tabindex="-1" aria-labelledby="addEquipmentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content equipment-modal">
            <div class="modal-header modal-green">
                <h5 class="modal-title fw-bold text-white" id="addEquipmentModalLabel">Add New Equipment</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('Equipment.store') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-success">Equipment Name</label>
                            <input type="text" name="eq_name" class="form-control form-input"
                                placeholder="Enter equipment name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-success">Quantity</label>
                            <input type="number" name="eq_available" class="form-control form-input"
                                placeholder="Enter quantity" required>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer justify-content-end mt-4">
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-success modal-btn" data-bs-dismiss="modal">
                                <i class="bi bi-arrow-left"></i> Back
                            </button>
                            <button type="submit" class="btn btn-green modal-btn">
                                <i class="bi bi-plus-circle"></i> Add
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
