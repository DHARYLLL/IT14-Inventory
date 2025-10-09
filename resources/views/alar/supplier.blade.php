@extends('layouts.layout')
@section('title', 'Supplier')

@section('content')

    @section('head', 'Supplier')
    @section('name', 'Staff')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="search-input position-relative" style="width: 400px">
            <i class="bi bi-search search-icon"></i>
            <input type="search" placeholder="Search" class="form-control">
        </div>

        <button class="btn btn-custom d-flex align-items-center gap-2" type="button" data-bs-toggle="modal" data-bs-target="#NewSupplierModal">
            <i class="bi bi-plus-lg"></i>
            <span>Add Supplier</span>
        </button>
    </div>

    {{-- table --}}
    <div class="bg-white rounded border overflow-hidden" style="min-height: 70vh">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr class="table-light">
                    <th class="fw-semibold">Supplier #</th>
                    <th class="fw-semibold">Name</th>
                    <th class="fw-semibold">Contact number</th>
                    <th class="fw-semibold">Company name</th>
                    <th class="fw-semibold">Company Address</th>
                    <th class="fw-semibold text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @if($suppliers->isEmpty())
                <tr>
                    <td colspan="6" class="text-center text-secondary py-3">
                        No supplies available.
                    </td>
                </tr>
                @else
                @foreach ($suppliers as $supplier)
                    <tr>
                        <td>{{ $supplier->id }}</td>
                        <td>{{ $supplier->fname . ' ' . ($supplier->mname ? $supplier->mname . ' ' : '') . $supplier->lname}}</td>
                        <td>{{ $supplier->contact_number }}</td>
                        <td>{{ $supplier->company_name }}</td>
                        <td>{{ $supplier->company_address }}</td>
                        <td class="align-middle">
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <button type="button" class="btn btn-edit-custom btn-md" data-bs-toggle="modal" data-bs-target="#EditSupplierModal{{ $supplier->id }}">
                                    <i class="bi bi-pencil-square" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i>
                                </button>

                                <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete-custom btn-md">
                                        <i class="bi bi-trash" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>

                    
                    <!-- Edit Modal -->
                    <div class="modal fade" id="EditSupplierModal{{ $supplier->id }}" tabindex="-1" aria-labelledby="EditSupplierModalLabel{{ $supplier->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-custom">
                            <div class="modal-content">

                                {{-- Header --}}
                                
                                <div class="modal-header modal-header-custom gap-3">
                                    <div>
                                        <img src="{{ asset('images/alar-logo.png') }}" alt="Alar Memorial Services Logo" style="max-width: 100%; height: 3rem; border-radius: 8px">
                                    </div>

                                    <h1 class="modal-title fs-5" id="EditSupplierModalLabel{{ $supplier->id }}">Edit Supplier</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                {{-- Body --}}
                                <form action="{{ route('supplier.update', ['supplier' => $supplier->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="" class="form-label">
                                                    <i class="bi bi-receipt" style="color: #60BF4F"></i> First Name
                                                </label>
                                                <input type="text" name="fname" class="form-control" value="{{ $supplier->fname }}">
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">
                                                    <i class="bi bi-calendar3" style="color: #60BF4F"></i> Middle Name
                                                </label>
                                                <input type="text" name="mname" class="form-control" value="{{ $supplier->mname }}">
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">
                                                    <i class="bi bi-calendar3" style="color: #60BF4F"></i> Last Name
                                                </label>
                                                <input type="text" name="lname" class="form-control" value="{{ $supplier->lname }}">
                                            </div>

                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="" class="form-label">
                                                        <i class="bi bi-geo-alt" style="color: #60BF4F"></i> Contact Number
                                                </label>
                                                <input type="text" name="contact_number" class="form-control" value="{{ $supplier->contact_number }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">
                                                    <i class="bi bi-telephone" style="color: #60BF4F"></i> Company Name
                                                </label>
                                                <input type="text" name="company_name" class="form-control" value="{{ $supplier->company_name }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="" class="fomr-label">
                                                    <i class="bi bi-geo-alt" style="color: #60BF4F"></i> Company Address
                                                </label>
                                                <input type="text" name="company_address" class="form-control" value="{{ $supplier->company_address }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Footer --}}
                                    <div class="modal-footer d-flex align-items-center">
                                        <div>
                                            <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-create">Save changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                @endif
                
            </tbody>
            
        </table>

        {{-- Custom Pagination --}}
        <div class="d-flex justify-content-center mt-3">
            <nav aria-label="Page navigation example">
                <ul class="pagination mb-0">
                    <li class="page-item {{ $suppliers->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $suppliers->previousPageUrl() ?? '#' }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    @for ($i = 1; $i <= $suppliers->lastPage(); $i++)
                        <li class="page-item {{ $suppliers->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $suppliers->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    <li class="page-item {{ $suppliers->currentPage() == $suppliers->lastPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $suppliers->nextPageUrl() ?? '#' }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        {{-- Showing results text --}}
        <div class="text-center text-secondary mt-2">
            Showing {{ $suppliers->firstItem() ?? 0 }} to {{ $suppliers->lastItem() ?? 0 }} of {{ $suppliers->total() ?? 0 }} results
        </div>
        
    </div>
    
@endsection


<!-- Add Modal -->
<div class="modal fade" id="NewSupplierModal" tabindex="-1" aria-labelledby="NewSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-custom">
        <div class="modal-content">

            {{-- Header --}}
            
            <div class="modal-header modal-header-custom gap-3">
                <div>
                    <img src="{{ asset('images/alar-logo.png') }}" alt="Alar Memorial Services Logo" style="max-width: 100%; height: 3rem; border-radius: 8px">
                </div>

                <h1 class="modal-title fs-5" id="NewSupplierModalLabel">Add New Supplier</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- Body --}}
            <form action="{{ route('supplier.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="" class="form-label">
                                <i class="bi bi-receipt" style="color: #60BF4F"></i> First Name
                            </label>
                            <input type="text" name="fname" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">
                                <i class="bi bi-calendar3" style="color: #60BF4F"></i> Middle Name
                            </label>
                            <input type="text" name="mname" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">
                                <i class="bi bi-calendar3" style="color: #60BF4F"></i> Last Name
                            </label>
                            <input type="text" name="lname" class="form-control">
                        </div>

                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="" class="form-label">
                                    <i class="bi bi-geo-alt" style="color: #60BF4F"></i> Contact Number
                            </label>
                            <input type="text" name="contact_number" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="bi bi-telephone" style="color: #60BF4F"></i> Company Name
                            </label>
                            <input type="text" name="company_name" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="" class="fomr-label">
                                <i class="bi bi-geo-alt" style="color: #60BF4F"></i> Company Address
                            </label>
                            <input type="text" name="company_address" class="form-control">
                        </div>
                    </div>
                </div>
                {{-- Footer --}}
                <div class="modal-footer d-flex align-items-center">
                    <div>
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-create">Add Supplier</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize tooltips globally
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Reinitialize tooltips each time a modal is shown (fix for modals and dynamic content)
    // document.addEventListener('shown.bs.modal', function () {
    //     var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    //     tooltipTriggerList.map(function (tooltipTriggerEl) {
    //         return new bootstrap.Tooltip(tooltipTriggerEl);
    //     });
    // });
});
</script>
