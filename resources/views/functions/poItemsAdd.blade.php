@extends('layouts.layout')
@section('title', 'Supplier')

@section('content')

    @section('head', 'Create Purchase Order')
    @section('name', 'Staff')
    

    <div class="d-flex align-items-center justify-content-between mb-4">

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('purchaseOrder.index') }}" class="text-decoration-none">
                <h4 class="text-dark mb-0">Purchase Order</h4>
            </a>
            <span class="text-muted">></span>
            <p class="mb-0">Create Purchase Order</p>
        </div>


        <button class="btn btn-custom d-flex align-items-center gap-2" type="button" data-bs-toggle="modal" data-bs-target="#NewSupplierModal">
            <i class="bi bi-plus-lg"></i>
            <span>Add Supplier</span>
        </button>
    </div>

    {{-- table --}}
    <div class="bg-white rounded border" style="min-height: 70vh"> 


        <form action="{{ route('Purchase-Order.store') }}" method="POST" id="form">
            @csrf

            <div class="row d-flex justify-content-between p-3">
                <div class="col-md-4 mb-3">
                    {{-- <label for="" class="form-label">Supplier</label> --}}
                    <select class="form-select" name="supp" id="supp" aria-label="Default select example">
                        <option selected>Select supllier</option>
                        @foreach($supData as $supp)
                            <option value="{{ $supp->id }}">{{ $supp->id }} {{ $supp->fname }} {{ $supp->mname }} {{ $supp->lname }}</option>
                        @endforeach
                    </select>
                    @error('supp')
                        <p style="color:red">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-md-2 d-flex justify-content-center align-items-center gap-2">
                    
                    <button class="btn border" type="button" id="add_new">Add More</button>
                    <button class="btn border" type="submit">Submit</button>
                    
                </div>
            </div>

            <div id="pasteHere">

                @php
                    $oldItems = old('itemName', ['']);
                    $oldQtys = old('qty', ['']);
                    $oldunitPrices = old('unitPrice', ['']);
                    $oldsizeWeigth = old('sizeWeigth', ['']);
                @endphp

                @foreach ($oldItems as $i => $item)

                    <div class="row mb-2 p-3">
            
                        <div class="col-md-4 mb-2">
                            <label for="" class="form-label">
                                <i class="bi bi-receipt" style="color: #60BF4F"></i> Item Name
                            </label>
                            <input type="text" name="itemName[]" value="{{ $item }}" class="form-control">
                            @error("itemName.$i")
                                <p style="color:red">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-md-2 mb-2">
                            <label class="form-label">
                                <i class="bi bi-calendar3" style="color: #60BF4F"></i> Quantity
                            </label>
                            <input type="number" name="qty[]" value="{{ $oldQtys[$i] ?? '' }}" class="form-control">
                            @error("qty.$i")
                                <p style="color:red">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-md-2 mb-2">
                            <label class="form-label">
                                <i class="bi bi-calendar3" style="color: #60BF4F"></i> Unit Price
                            </label>
                            <input type="text" name="unitPrice[]" value="{{ $oldunitPrices[$i] ?? '' }}" class="form-control">
                            @error("unitPrice.$i")
                                <p style="color:red">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-md-2 mb-2">
                            <label class="form-label">
                                <i class="bi bi-calendar3" style="color: #60BF4F"></i> size/weight
                            </label>
                            <input type="text" name="sizeWeigth[]" value="{{ $oldsizeWeigth[$i] ?? '' }}" class="form-control">
                            @error("sizeWeigth.$i")
                                <p style="color:red">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-md-2 mb-2 d-flex align-items-end">
                            <label class="form-label invisible">Remove</label>
                            <button type="button" id="remove-btn" class="btn remove-btn text-danger border">Remove</button>
                        </div>

                    </div>
                @endforeach
                
                
            </div>

            
            
        </form>
    </div>
    
@endsection

