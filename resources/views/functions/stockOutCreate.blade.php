@extends('layouts.layout')
@section('title', 'Stock out')

@section('head', 'Stock out Items')

@section('content')

    {{-- Main Card --}}
    <div class="cust-h-full">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body h-100">
                <form action="{{ route('Stock-Out.store') }}" method="POST" id="form" class="h-100">
                    @csrf
                    

                    {{-- ADD stock and equipment 
                    <div class="row">
                        <div class="col col-6">
                            <div class="row">
                                <div class="col col-8 mb-3">
                                    <div>
                                        <select class="form-select" name="" id="select_stock">
                                            <option value="" selected disabled>Select Item</option>
                                            @foreach ($stoData as $row)
                                                <option
                                                    value="{{ $row->item_name }},{{ $row->item_size }}:{{ $row->id }};{{ $row->item_qty}}">
                                                    {{ $row->item_name }} | Size: {{ $row->item_size }} | {{ $row->item_qty }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col col-4">
                                    <button class="btn btn-outline-success" type="button" onclick="setStockStoOut()">
                                        <i class="bi bi-plus-circle"></i> Add Item
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col col-6 mb-3">
                            <div class="row">
                                <div class="col col-8">
                                    <div>
                                        <select class="form-select" name="" id="select_equipment">
                                            <option value="" selected disabled>Select Item</option>
                                            @foreach ($eqData as $row)
                                                <option
                                                    value="{{ $row->eq_name }},{{ $row->eq_size }}:{{ $row->id }};{{ $row->eq_available }}">
                                                    {{ $row->eq_name }} | Size: {{ $row->eq_size }} | {{ $row->eq_available }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col col-4">
                                    <button class="btn btn-outline-success" type="button" onclick="setEquipmentStoOut()">
                                        <i class="bi bi-plus-circle"></i> Add Equipment
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                     
                    
                    <div id="pasteHereStoOut" class="mt-3">
                        @php
                            $oldItems = old('itemName', ['']);
                            $oldQtys = old('qty', ['']);
                            $oldqtySet = old('qtySet', ['']);
                            $oldsize = old('size', ['']);
                            $oldType = old('typeSelect', ['']);
                            $oldId = old('itemId', ['']);
                            $oldAvailQty = old('availQty', ['']);
                        @endphp
                        @if(!empty(array_filter($oldItems)))
                            @foreach ($oldItems as $i => $item)
                                <div class="row g-2 mb-2 px-3 py-2 bg-light rounded-3 shadow-sm form-section">
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold text-secondary">Item Name</label>
                                        <input type="text" name="itemId[]" value="{{ $oldId[$i] }}">
                                        <input type="text" name="availQty[]" value="{{ $oldAvailQty[$i] }}">

                                        <input type="text" name="itemName[]" value="{{ $item }}"
                                            class="form-control shadow-sm" {{ $item ? 'readonly' : '' }}>
                                        @error("itemName.$i")
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-1">
                                        <label class="form-label fw-semibold text-secondary">Quantity</label>
                                        <input type="number" name="qty[]" value="{{ $oldQtys[$i] ?? '' }}"
                                            class="form-control shadow-sm">
                                        @error("qty.$i")
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-1">
                                        <label class="form-label fw-semibold text-secondary">Qty. per Set/Box</label>
                                        <input type="number" name="qtySet[]" value="{{ $oldqtySet[$i] ?? '' }}"
                                            class="form-control shadow-sm">
                                        @error("qtySet.$i")
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label fw-semibold text-secondary">Size</label>
                                        <input type="text" name="size[]" value="{{ $oldsize[$i] ?? '' }}"
                                            class="form-control shadow-sm">
                                        @error("size.$i")
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label fw-semibold text-secondary">Type</label>
                                        @if($oldType[$i])
                                            <input type="text" name="typeSelect[]" class="form-control shadow-sm" value="{{ $oldType[$i] }}" readonly>
                                        @else
                                            <select name="typeSelect[]" class="form-select shadow-sm placeType">
                                                <option value="">Select Type</option>
                                                <option value="Consumable"
                                                    {{ ($oldType[$i] ?? '') === 'Consumable' ? 'selected' : '' }}>Consumable
                                                </option>
                                                <option value="Non-Consumable"
                                                    {{ ($oldType[$i] ?? '') === 'Non-Consumable' ? 'selected' : '' }}>
                                                    Non-Consumable</option>
                                            </select>
                                            @error("typeSelect.$i")
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        @endif
                                        
                                    </div>
                                    <div class="col-md-1 align-items-start">
                                        <label class="form-label fw-semibold text-secondary">Remove</label>
                                        <button type="button"
                                            class="btn btn-outline-danger remove-btn">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        
                    </div>
                    --}}

                    <div class="row cust-h-form">

                        <div class="col-md-12 h-25">
                            <label for="" class="form-label">Reason for Stock-out</label>
                            <input type="text" class="form-control" name="reason" value="{{ old('reason') }}">
                            @error('reason')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 h-75 overflow-auto">

                            <div class="row">
                                {{-- Stock --}}
                                <div class="col-12">
                                    <label for="stock" class="form-label">Stock</label>
                                    <div class="d-flex gap-2 align-items-center">
                                        <select name="" id="stock" class="form-select w-50" onchange="getQtySto()">
                                            <option value="">Select Stock</option>
                                            @foreach ($stoData as $data)
                                                <option value="{{ $data->id }},{{ $data->item_name }}:{{ $data->item_size }};{{ $data->item_qty }}">
                                                    {{ $data->id }} — {{ $data->item_name }} {{ $data->size }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="text" id="sto" class="form-control w-25" readonly placeholder="Available" hidden>
                                
                                        <button type="button" id="add_sto" onclick="checkInputSto()" class="cust-btn cust-btn-primary"><i
                                                class="bi bi-plus-circle"></i>
                                            Add Stock
                                        </button>
                                    </div>
                                </div>
                                <div id="addStock" class="col-12 mt-3">
                                
                                    @php
                                        $oldItems = old('itemName', ['']);
                                        $oldQtys = old('stockQty', ['']);
                                        $oldQtySet = old('stockQtySet', ['']);
                                        $oldStock = old('stock', ['']);
                                        $oldStoSize = old('stoSize', ['']);
                                        $oldStoAvail = old('stoAvail', ['']);
                                    @endphp
                                    @if(!empty(array_filter($oldItems)))
                                        @foreach($oldItems as $i => $item)
                                            <div class="row g-2 align-items-start mb-2 added-item">
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold text-secondary">Stock</label>
                                                    <input type="text" class="form-control" name="itemName[]" value="{{ $item }}" readonly>
                                                    <input type="text" name="stock[]" value="{{ $oldStock[$i] ?? '' }}" hidden>
                                                    
                                                    @error("itemName.$i")
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold text-secondary">Size</label>
                                                    <input type="text" class="form-control" name="stoSize[]" value="{{ $oldStoSize[$i] ?? '' }}" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold text-secondary">In Stock</label>
                                                    <input type="text" class="form-control" name="stoAvail[]" value="{{ $oldStoAvail[$i] ?? '' }}" readonly>
                                                </div>
                                                <div class="col-md-5">
                                                    <label class="form-label fw-semibold text-secondary">Qty.</label>
                                                    <input type="number" class="form-control" name="stockQty[]" value="{{ $oldQtys[$i] ?? '' }}">
                                                    @error("stockQty.$i")
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-5">
                                                    <label class="form-label fw-semibold text-secondary">Qty. per Set/Unit</label>
                                                    <input type="number" class="form-control" name="stockQtySet[]" value="{{ $oldQtySet[$i] ?? '' }}">
                                                    @error("stockQtySet.$i")
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label fw-semibold text-secondary">Remove</label>
                                                    <button type="button" class="btn btn-outline-danger w-100 remove-sto"><i class="bi bi-x-circle"></i> </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="col-md-6 h-75 overflow-auto">

                            <div class="row">
                                {{-- Equipment --}}
                                <div class="col-12">
                                    <label for="equipment" class="form-label">Equipment</label>
                                    <div class="d-flex gap-2 align-items-center">
                                        <select name="" id="equipment" class="form-select w-50" onchange="getQty()">
                                            <option value="">Select Equipment</option>
                                            @foreach ($eqData as $data)
                                                <option value="{{ $data->id }},{{ $data->eq_name }}:{{ $data->eq_size }};{{ $data->eq_available }}">
                                                    {{ $data->id }} — {{ $data->eq_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="text" id="avail" class="form-control w-25" readonly placeholder="Available" hidden>
                                        <button type="button" id="add_eq" onclick="checkInputEq()" class="cust-btn cust-btn-primary"><i
                                                class="bi bi-plus-circle"></i>
                                            Add Equipment
                                        </button>
                                    </div>
                                </div>
                                <div id="addEquipment" class="col-12 mt-3">
                                    @php
                                        $oldEq = old('eqName', ['']);
                                        $oldEqQtys = old('eqQty', ['']);
                                        $oldEqQtySet = old('eqQtySet', ['']);
                                        $oldEqId = old('equipment', ['']);
                                        $oldEqSize = old('eqSize', ['']);
                                        $oldEqAvail = old('eqAvail', ['']);
                                    @endphp
                                    @if(!empty(array_filter($oldEq)))
                                        @foreach($oldEq as $i => $item)
                                            <div class="row g-2 align-items-start mb-2 added-item">
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold text-secondary">Equipment</label>
                                                    <input type="text" class="form-control" name="eqName[]" value="{{ $item }}" readonly>
                                                    <input type="text" name="equipment[]" value="{{ $oldEqId[$i] ?? '' }}" hidden>
                                                    @error("eqName.$i")
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold text-secondary">Size</label>
                                                    <input type="text" class="form-control" name="eqSize[]" value="{{ $oldEqSize[$i] ?? '' }}" readonly>
                                                    @error("eqSize.$i")
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold text-secondary">In Stock</label>
                                                    <input type="text" class="form-control" name="eqAvail[]" value="{{ $oldEqAvail[$i] ?? '' }}" readonly>
                                                </div>
                                                <div class="col-md-5">
                                                    <label class="form-label fw-semibold text-secondary">Qty</label>
                                                    <input type="number" class="form-control" name="eqQty[]" value="{{ $oldEqQtys[$i] ?? '' }}">
                                                    @error("eqQty.$i")
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-5">
                                                    <label class="form-label fw-semibold text-secondary">Qty. per Set/Unit</label>
                                                    <input type="number" class="form-control" name="eqQtySet[]" value="{{ $oldEqQtySet[$i] ?? '' }}">
                                                    @error("eqQtySet.$i")
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label fw-semibold text-secondary">Remove</label>
                                                    <button type="button" class="btn btn-outline-danger w-100 remove-eq"><i class="bi bi-x-circle"></i></button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>


                        </div>

                    </div>
                    
                    

                    {{-- Submit --}}
                    <div class="row justify-content-end mt-4">
                        {{-- Display Error --}}
                        <div class="col col-auto">
                             @session('promt')
                                <div class="text-success small mt-1">{{ $value }}</div>
                            @endsession
                            @session('emptyEq')
                                <div class="text-danger small mt-1">{{ $value }}</div>
                            @endsession
                        </div>

                        <div class="col col-auto">
                            <a href="{{ route('Stock-Out.index') }}" class="cust-btn cust-btn-secondary"><i
                                class="bi bi-arrow-left"></i>
                                <span>Cancel</span>
                            </a>
                        </div>

                        {{-- Submit Button --}}
                        <div class="col col-auto ">
                        
                            <button type="submit" class="cust-btn cust-btn-primary"><i class="bi bi-send"></i>
                                Stock Out
                            </button>
                        
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>


    
@endsection

{{-- custom script --}}
<script>

    function setStockStoOut() {
        var get = document.getElementById('select_stock');


        if (!get) return;

        if (get.value.trim() === "") {
            alert("Input is empty");
            return;
        }

        if (get) {
            var idData = get.options[get.selectedIndex].value;
            let forName = idData.slice(0, idData.indexOf(","));
            let forSize = idData.slice(idData.indexOf(",") + 1, idData.indexOf(":"));
            let forId = idData.slice(idData.indexOf(":") + 1, idData.indexOf(";"));
            let availQty = idData.slice(idData.indexOf(";") + 1);

            //const addBtn = document.getElementById('add_new');
            const pasteHere = document.getElementById('pasteHereStoOut');

            const template = `
                <div class="row g-2 mb-2 px-3 py-2 bg-light rounded-3 shadow-sm form-section">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-secondary">
                            <i class="bi bi-receipt" style="color:#60BF4F"></i> Item Name
                        </label>
                        <input type="text" name="itemId[]" value="${forId}">
                        <input type="text" name="availQty[]" value="${availQty}">
                        <input type="text" name="itemName[]" class="form-control shadow-sm" value="${forName}" readonly>
                    </div>

                    <div class="col-md-1">
                        <label class="form-label fw-semibold text-secondary">Quantity</label>
                        <input type="number" name="qty[]" class="form-control shadow-sm">
                    </div>

                    <div class="col-md-1">
                        <label class="form-label fw-semibold text-secondary">Qty. per Set/Box</label>
                        <input type="number" name="qtySet[]" class="form-control shadow-sm">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold text-secondary">Size</label>
                        <input type="text" name="size[]" class="form-control shadow-sm" value="${forSize}" readonly>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold text-secondary">Type</label>
                        <input type="text" name="typeSelect[]" class="form-control shadow-sm" value="Consumable" readonly>
                    </div>
                    

                    <div class="col-md-1 align-items-start">
                        <label class="form-label fw-semibold text-secondary">Remove</label>
                        <button type="button" class="btn btn-outline-danger remove-btn w-100">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                </div>
            `;

            pasteHere.insertAdjacentHTML("beforeend", template);

        } else {
            document.getElementById("itemName").value = '';
        }

    }

    // get equipment

    function setEquipmentStoOut() {

        var get = document.getElementById('select_equipment');
        if (!get) return;

        if (get.value.trim() === "") {
            alert("Input is empty");
            return;
        }
        if (get) {
            var idData = get.options[get.selectedIndex].value;
            let forName = idData.slice(0, idData.indexOf(","));
            let forSize = idData.slice(idData.indexOf(",") + 1, idData.indexOf(":"));
            let forId = idData.slice(idData.indexOf(":") + 1, idData.indexOf(";"));
            let availQty = idData.slice(idData.indexOf(";") + 1);

            //document.getElementById("itemName").value = forQty;

            //const addBtn = document.getElementById('add_new');
            const pasteHere = document.getElementById('pasteHereStoOut');


            const template = `
                <div class="row g-2 mb-2 px-3 py-2 bg-light rounded-3 shadow-sm form-section">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-secondary">Item Name</label>
                        <input type="text" name="itemId[]" id="itemId" value="${forId}">
                        <input type="text" name="availQty[]" value="${availQty}">
                        <input type="text" name="itemName[]" class="form-control shadow-sm" value="${forName}" readonly>
                    </div>

                    <div class="col-md-1">
                        <label class="form-label fw-semibold text-secondary">Quantity</label>
                        <input type="number" name="qty[]" class="form-control shadow-sm">
                    </div>

                    <div class="col-md-1">
                        <label class="form-label fw-semibold text-secondary">Qty. per Set/Box</label>
                        <input type="number" name="qtySet[]" class="form-control shadow-sm">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold text-secondary">Size/Weight</label>
                        <input type="text" name="size[]" class="form-control shadow-sm" value="${forSize}" readonly>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold text-secondary">Type</label>
                        <input type="text" name="typeSelect[]" class="form-control shadow-sm" value="Non-Consumable" readonly>
                    </div>
                    

                    <div class="col-md-1 align-items-start">
                        <label class="form-label fw-semibold text-secondary">Remove</label>
                        <button type="button" class="btn btn-outline-danger remove-btn w-100">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                </div>
            `;

            pasteHere.insertAdjacentHTML("beforeend", template);

        } else {
            document.getElementById("itemName").value = '';
        }

    }

    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-btn')) {
            let row = e.target.closest('.form-section');
            if (row) row.remove();
        }
    });

</script>
