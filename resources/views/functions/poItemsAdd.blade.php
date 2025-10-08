@extends('layouts.layout')
@section('title', 'Supplier')

@section('content')

    @section('head', 'Create Purchase Order')
    @section('name', 'Staff')

    <div class="d-flex align-items-center justify-content-end mb-4">
        

        <button class="btn btn-custom d-flex align-items-center gap-2" type="button" data-bs-toggle="modal" data-bs-target="#NewSupplierModal">
            <i class="bi bi-plus-lg"></i>
            <span>Add Supplier</span>
        </button>
    </div>

    {{-- table --}}
    <div class="bg-white rounded border"> 
        <form action="{{ route('Purchase-Order.store') }}" method="POST" id="form">
            @csrf
            
            <select name="supp" id="supp">
                    <option value=""></option>
                @foreach($supData as $supp)
                    <option value="{{ $supp->id }}">{{ $supp->id }} {{ $supp->fname }} {{ $supp->mname }} {{ $supp->lname }}</option>
                @endforeach
            </select>
            @error('supp')
                <p style="color:red">{{ $message }}</p>
            @enderror
            
            <div id="pasteHere">
                

                @php
                    $oldItems = old('itemName', ['']);
                    $oldQtys = old('qty', ['']);
                    $oldunitPrices = old('unitPrice', ['']);
                    $oldsizeWeigth = old('sizeWeigth', ['']);
                @endphp

                @foreach($oldItems as $i => $item)
                    <div class="input-group">
                        <input type="text" placeholder="item name" name="itemName[]" value="{{ $item }}">
                        @error("itemName.$i")
                            <p style="color:red">{{ $message }}</p>
                        @enderror

                        <input type="number" placeholder="qty" name="qty[]" value="{{ $oldQtys[$i] ?? '' }}">
                        @error("qty.$i")
                            <p style="color:red">{{ $message }}</p>
                        @enderror

                        <input type="text" placeholder="unitPrice" name="unitPrice[]" value="{{ $oldunitPrices[$i] ?? '' }}">
                        @error("unitPrice.$i")
                            <p style="color:red">{{ $message }}</p>
                        @enderror

                        <input type="text" placeholder="size/weight" name="sizeWeigth[]" value="{{ $oldsizeWeigth[$i] ?? '' }}">
                        @error("sizeWeigth.$i")
                            <p style="color:red">{{ $message }}</p>
                        @enderror

                        <button type="button" id="remove-btn" class="remove-btn">Remove</button>
                    </div>
                @endforeach
            </div>
            <button type="button" id="add_new">Add More</button>
            <button type="submit">Submit</button>
        </form>
    </div>
    
@endsection

