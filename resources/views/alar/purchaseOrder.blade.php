@extends('layouts.layout')
@section('title', 'Purchase Order')

@section('content')

    @section('head', 'Purchase Order')
    @section('name', 'Staff')

    
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="fw-semibold">Purchase Order</h2>

            <button class="btn btn-custom d-flex align-items-center gap-2" type="button" data-bs-toggle="modal" data-bs-target="#NewPOModal">
                <i class="bi bi-plus-lg"></i>
                <span>New Purchase Order</span>
            </button>
        </div>

        {{-- table --}}
        <div class="bg-white rounded border overflow-hidden">
            <table class="table table-hover mb-0">
                <thead>
                    <tr class="table-light">
                        <th class="fw-semibold">PO#</th>
                        <th class="fw-semibold">Supplier</th>
                        <th class="fw-semibold">Total Amount</th>
                        <th class="fw-semibold">Submitted Date</th>
                        <th class="fw-semibold">Apporved Date</th>
                        <th class="fw-semibold">Delivered Date</th>
                        <th class="fw-semibold">Status</th>
                        <th class="fw-semibold">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <td>001</td>
                    <td>Supplier 1</td>
                    <td>10000</td>
                    <td>09/25/25</td>
                    <td>09/26/25</td>
                    <td>10/01/25</td>
                    <td>Delivered</td>
                    <td></td>
                </tbody>
            </table>
        </div>
    
@endsection


<!-- Modal -->
<div class="modal fade" id="NewPOModal" tabindex="-1" aria-labelledby="NewPOModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-custom">
        <div class="modal-content">

            {{-- Header --}}
            <div class="modal-header modal-header-custom">
                <h1 class="modal-title fs-5" id="exampleModalLabel">New Purchase Order</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- Body --}}
            <form action="{{ route('POItems.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="" class="form-label">
                                <i class="bi bi-receipt" style="color: #60BF4F"></i> PO Number
                            </label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="bi bi-calendar3" style="color: #60BF4F"></i> Date
                            </label>
                            <input type="date" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="" class="fomr-label">
                                <i class="bi bi-person" style="color: #60BF4F"></i> Supplier
                            </label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="" class="form-label">
                                    <i class="bi bi-geo-alt" style="color: #60BF4F"></i> Company Address
                            </label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="bi bi-telephone" style="color: #60BF4F"></i> Supplier Contact
                            </label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
            
                    <div class="flex-fill">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="fw-semibold">Order Items</h3>
                            <button class="btn btn-add-item">
                                <i class="bi bi-plus-circle"></i> Add Item
                            </button>
                        </div>
                        <div class="d-flex align-items-center justify-content-between gap-3">
                            <label class="form-label">
                                <i class="bi bi-card-text" style="color: #60BF4F"></i> Item Description
                                <input type="text" name="Item_description" class="form-control">
                            </label>
                            <label class="form-label">
                                <i class="bi bi-hash" style="color: #60BF4F"></i> Quantity
                                <input type="number" name="Quantity" class="form-control">
                            </label>
                            <label class="form-label">
                                <i class="bi bi-currency-dollar" style="color: #60BF4F"></i> Unit Price
                                <input type="number" name="Unit_price" class="form-control">
                            </label>
                            <label class="form-label">
                                <i class="bi bi-calculator" style="color: #60BF4F"></i> Total Price per Line Item
                                <input type="number" class="form-control">
                            </label>
                        </div>
                    </div>
                </div>
                {{-- Footer --}}
                <div class="modal-footer d-flex justify-content-between align-items-center">
                    <div>
                        <img src="{{ asset('images/alar-logo.png') }}" alt="Alar Memorial Services Logo" style="max-width: 100%; height: 3rem;">
                    </div>
                    <div>
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-create">Save changes</button>
                    </div>
                </div>
            </form>

            
        </div>
    </div>
</div>
