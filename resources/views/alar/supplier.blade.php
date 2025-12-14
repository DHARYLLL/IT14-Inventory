@extends('layouts.layout')
@section('title', 'Supplier')

@section('content')
    @section('head', 'Supplier')

    <div class="d-flex align-items-center justify-content-between p-2 cust-h-heading">

        <div class="input-group cust-searchbar">
            <input type="text" id="searchInput" class="form-control" placeholder="Search Service Request"
                style="border-radius: 0; border: none;">
            <button class="cust-btn cust-btn-search" id="clearSearch">Clear</button>
        </div>
        <button class="cust-btn cust-btn-primary" type="button" data-bs-toggle="modal"
            data-bs-target="#NewSupplierModal"><i class="bi bi-plus-lg"></i><span>Add Supplier</span>
        </button>
    </div>

    {{-- table --}}
    <div class="cust-h-content">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr class="table-light">
                    <th class="fw-semibold">Supplier #</th>
                    <th class="fw-semibold">Name</th>
                    <th class="fw-semibold">Contact number</th>
                    <th class="fw-semibold">Company name</th>
                    <th class="fw-semibold">Company Address</th>
                    <th class="col col-md-2 fw-semibold text-center">Action</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @if ($suppliers->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center text-secondary py-3">No New Suppliers.</td>
                    </tr>
                @else
                    @foreach ($suppliers as $supplier)
                        <tr>
                            <td>{{ $supplier->id }}</td>
                            <td>{{ $supplier->fname . ' ' . ($supplier->mname ? $supplier->mname . ' ' : '') . $supplier->lname }}
                            </td>
                            <td>{{ $supplier->contact_number }}</td>
                            <td>{{ $supplier->company_name }}</td>
                            <td>{{ $supplier->company_address }}</td>
                            <td class="text-center col col-md-2">
                                <div class="d-inline-flex justify-content-center gap-2">
                                    <button type="button" class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="modal"
                                        data-bs-target="#EditSupplierModal{{ $supplier->id }}">
                                        <i class="bi bi-pencil-square" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Edit"></i>
                                    </button>
                                    @if(session("empRole") == 'sadmin' || session("empRole") == 'admin')
                                        <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" class="m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="cust-btn cust-btn-danger-secondary  btn-md">
                                                <i class="bi bi-trash" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Delete"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <!-- Edit Modal -->
                        <div class="modal fade" id="EditSupplierModal{{ $supplier->id }}" tabindex="-1"
                            aria-labelledby="EditSupplierModalLabel{{ $supplier->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-custom">
                                <div class="modal-content">
                                    {{-- Header --}}
                                    <div class="modal-header modal-header-custom">
                                        <h1 class="modal-title fs-5 m-0" id="EditSupplierModalLabel{{ $supplier->id }}">
                                            Edit Supplier
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    {{-- Body --}}
                                    <form action="{{ route('supplier.update', ['supplier' => $supplier->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body py-3">
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <label class="form-label">First Name</label>
                                                    <input type="text" name="fname" class="form-control"
                                                        value="{{ $supplier->fname }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Middle Name</label>
                                                    <input type="text" name="mname" class="form-control"
                                                        value="{{ $supplier->mname }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Last Name</label>
                                                    <input type="text" name="lname" class="form-control"
                                                        value="{{ $supplier->lname }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Contact Number</label>
                                                    <input type="text" name="contact_number" class="form-control"
                                                        value="{{ $supplier->contact_number }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Company Name</label>
                                                    <input type="text" name="company_name" class="form-control"
                                                        value="{{ $supplier->company_name }}">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Company Address</label>
                                                    <input type="text" name="company_address" class="form-control"
                                                        value="{{ $supplier->company_address }}">
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Footer --}}
                                        <div class="modal-footer">
                                            <button type="button" class="cust-btn cust-btn-secondary" data-bs-dismiss="modal"><i
                                                    class="bi bi-x-lg px-2"></i>Cancel</button>
                                            <button type="submit" class="cust-btn cust-btn-primary"><i class="bi bi-floppy px-2"></i>Save
                                                Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

@endsection

<!-- Add Modal -->
<div class="modal fade" id="NewSupplierModal" tabindex="-1" aria-labelledby="NewSupplierModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-custom">
    <div class="modal-content">
        {{-- Header --}}
        <div class="modal-header modal-header-custom">
            <h1 class="modal-title fs-5 m-0" id="NewSupplierModalLabel">Add New Supplier</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        {{-- Body --}}
        <form action="{{ route('supplier.store') }}" method="POST">
            @csrf
            <div class="modal-body py-3">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">First Name</label>
                        <input type="text" name="fname" class="form-control" value="{{ old('fname') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Middle Name</label>
                        <input type="text" name="mname" class="form-control" value="{{ old('mname') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="lname" class="form-control" value="{{ old('lname') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Contact Number</label>
                        <input type="text" name="contact_number" class="form-control"
                            value="{{ old('contact_number') }}" placeholder="Ex. 09...">
                        @error('contact_number')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Company Name</label>
                        <input type="text" name="company_name" class="form-control"
                            value="{{ old('company_name') }}" placeholder="Enter company name">
                        @error('company_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Company Address</label>
                        <input type="text" name="company_address" class="form-control"
                            value="{{ old('company_address') }}" placeholder="Enter company address">
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="modal-footer">
                <button type="button" class="cust-btn cust-btn-secondary" data-bs-dismiss="modal"><i
                        class="bi bi-x-lg px-1"></i>Cancel</button>
                <button type="submit" class="cust-btn cust-btn-primary"><i class="bi bi-plus-lg px-1"></i>Add
                    Supplier</button>
            </div>
        </form>
    </div>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myModal = new bootstrap.Modal(document.getElementById('NewSupplierModal'));
        myModal.show();
    });
</script>
@endif
