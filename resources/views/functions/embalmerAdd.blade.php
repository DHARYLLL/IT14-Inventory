@extends('layouts.layout')
@section('title', 'Embalmer')

@section('content')
    @section('head', 'Add Embalmer')

    <div class="cust-h-content-func">
        <div class="card bg-white border-0 rounded-3 h-100">
            <div class="card-body h-100">
                
                <form action="{{ route('Embalmer.store') }}" method="post" class="h-100">
                    @csrf

                    <div class="row">

                        <div class="col-md-6">
                            <label for="embalmName" class="form-label">Name:</label>
                            <input type="text" class="form-control" name="embalmName" placeholder="Embalmer name" value="{{ old('embalmName') }}">
                            @error('embalmName')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <label for="embalmPrice" class="form-label">Price</label>
                            <input type="text" class="form-control" name="embalmPrice" placeholder="Price" value="{{ old('embalmPrice') }}">
                            @error('embalmPrice')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="row h-65 mt-4">

                        <div class="col-md-6 h-100 overflow-auto">
                            {{-- Stock --}}
                            <div class="col-12">
                                <label for="stock" class="form-label">Stock</label>
                                <div class="d-flex gap-2 align-items-center">
                                    <select name="" id="stock" class="form-select w-50" onchange="getQtyStoAddEmbalm()">
                                        <option value="">Select Stock</option>
                                        @foreach ($stoData as $data)
                                            <option value="{{ $data->id }},{{ $data->item_name }}">
                                                {{ $data->id }} — {{ $data->item_name }} {{ $data->size_weight }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="text" id="sto" class="form-control w-25" readonly placeholder="Available">
                                    
                                    <button type="button" id="add_sto" onclick="checkInputStoAddEmbalm()" class="cust-btn cust-btn-primary">Add Stock</button>
                                </div>
                            </div>

                            <div id="addStock" class="col-12 mt-3">
                            
                                @php
                                    $oldItems = old('itemName', ['']);
                                    $oldQtys = old('stockQty', ['']);
                                    $oldStock = old('stock', ['']);
                                @endphp

                                @if(!empty(array_filter($oldItems)))

                                    @foreach($oldItems as $i => $item)

                                        <div class="row g-2 align-items-start mb-2 added-item">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold text-secondary">Stock</label>
                                                <input type="text" class="form-control" name="itemName[]" value="{{ $item }}" readonly>
                                                <input type="text" name="stock[]" value="{{ $oldStock[$i] ?? '' }}" hidden>
                                                @error("itemName.$i")
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror 
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label fw-semibold text-secondary">Stock Qty</label>
                                                <input type="number" class="form-control" name="stockQty[]" placeholder="Stock Qty" value="{{ $oldQtys[$i] ?? '' }}">
                                                @error("stockQty.$i")
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label fw-semibold text-secondary">Remove</label>
                                                <button type="button" class="btn btn-outline-danger w-100 remove-sto">
                                                    <i class="bi bi-x-circle"></i></button>
                                            </div>
                                        </div>


                                    @endforeach

                                @endif

                            </div>

                        </div>

                        <div class="col-md-6 h-100 overflow-auto">

                            {{-- Equipment --}}
                            <div class="col-12">
                                <label for="equipment" class="form-label">Equipment</label>
                                <div class="d-flex gap-2 align-items-center">
                                    <select name="" id="equipment" class="form-select w-50" onchange="getQtyAddEmbalm()">
                                        <option value="">Select Equipment</option>
                                        @foreach ($eqData as $data)
                                            <option value="{{ $data->id }},{{ $data->eq_name }}">
                                                {{ $data->id }} — {{ $data->eq_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="text" id="avail" class="form-control w-25" readonly placeholder="Available">
                                    <button type="button" id="add_eq" onclick="checkInputEqyAddEmbalm()" class="cust-btn cust-btn-primary">Add Equip.</button>
                                </div>
                            </div>
                            <div id="addEquipment" class="col-12 mt-3">

                                @php
                                    $oldEq = old('eqName', ['']);
                                    $oldEqQtys = old('eqQty', ['']);
                                    $oldEqId = old('equipment', ['']);
                                @endphp

                                @if(!empty(array_filter($oldEq)))

                                    @foreach($oldEq as $i => $item)

                                        <div class="row g-2 align-items-start mb-2 added-item">

                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold text-secondary">Equipment</label>
                                                <input type="text" class="form-control" name="eqName[]" value="{{ $item }}" readonly>
                                                <input type="text" name="equipment[]" value="{{ $oldEqId[$i] ?? '' }}" hidden>
                                                @error("eqName.$i")
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label fw-semibold text-secondary">Qty</label>
                                                <input type="number" class="form-control" name="eqQty[]" placeholder="Qty" value="{{ $oldEqQtys[$i] ?? '' }}">     
                                                @error("eqQty.$i")
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label fw-semibold text-secondary">Remove</label>
                                                <button type="button" class="btn btn-outline-danger w-100 remove-eq">
                                                    <i class="bi bi-x-circle"></i></button>
                                            </div>

                                        </div>


                                    @endforeach

                                @endif


                            </div>

                        </div>

                        <script>
                            //cust embalmer

                            // for stock
                            function getQtyStoAddEmbalm() {
                                const get = document.getElementById('stock');
                                const stoInput = document.getElementById("sto");

                                if (get && stoInput) {
                                    const idData = get.options[get.selectedIndex].value;
                                    const forQty = idData.slice(idData.indexOf(",") + 1);
                                    stoInput.value = forQty;
                                } else if (stoInput) {
                                    stoInput.value = '';
                                }
                            }

                            function checkInputStoAddEmbalm() {
                                const input = document.getElementById("sto");
                                const get = document.getElementById('stock');
                                if (!input || !get) return;

                                if (input.value.trim() === "") {
                                    alert("Input is empty");
                                    return;
                                }

                                
                                var idData = get.options[get.selectedIndex].value;
                                let forId = idData.slice(0, idData.indexOf(","));
                                let forName = idData.slice(idData.indexOf(",") + 1);

                                const wrapper = document.createElement('div');
                                wrapper.classList.add('row', 'g-2', 'align-items-start', 'mb-2', 'added-item');

                                wrapper.innerHTML = `
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-secondary">Stock</label>
                                        <input type="text" class="form-control" name="itemName[]" value="${forName}" readonly>
                                        <input type="text" name="stock[]" value="${forId}" hidden>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold text-secondary">Qty Used</label>
                                        <input type="number" class="form-control" name="stockQty[]" >
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold text-secondary">Remove</label>
                                        <button type="button" class="btn btn-outline-danger w-100 remove-sto"><i class="bi bi-x-circle"></i> </button>
                                    </div>
                                `;

                                document.getElementById('addStock').appendChild(wrapper);
                            }

                            //for equipment
                            function getQtyAddEmbalm() {
                                const get = document.getElementById('equipment');
                                const availInput = document.getElementById("avail");

                                if (get && availInput) {
                                    const idData = get.options[get.selectedIndex].value;
                                    const forQty = idData.slice(idData.indexOf(",") + 1);
                                    availInput.value = forQty;
                                } else if (availInput) {
                                    availInput.value = '';
                                }
                            }

                            function checkInputEqyAddEmbalm() {
                                const input = document.getElementById("avail");
                                const get = document.getElementById('equipment');
                                if (!input || !get) return;

                                if (input.value.trim() === "") {
                                    alert("Input is empty");
                                    return;
                                }

                                var idData = get.options[get.selectedIndex].value;
                                let forId = idData.slice(0, idData.indexOf(","));
                                let forName = idData.slice(idData.indexOf(",") + 1);

                                const wrapper = document.createElement('div');
                                wrapper.classList.add('row', 'g-2', 'align-items-start', 'mb-2', 'added-item');

                                wrapper.innerHTML = `
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-secondary">Equipment</label>
                                        <input type="text" class="form-control" name="eqName[]" value="${forName}" readonly>
                                        <input type="text" name="equipment[]" value="${forId}" hidden>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold text-secondary">Qty</label>
                                        <input type="number" class="form-control" name="eqQty[]">     
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold text-secondary">Remove</label>
                                        <button type="button" class="btn btn-outline-danger w-100 remove-eq">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </div>
                                `;

                                document.getElementById('addEquipment').appendChild(wrapper);
                            }


                        </script>

                    </div>

                    {{-- Submit --}}
                    <div class="row justify-content-end mt-4">
                        {{-- Display Error --}}
                        <div class="col col-auto">
                             @session('promt')
                                <div class="text-success small mt-1">{{ $value }}</div>
                            @endsession
                        </div>

                        <div class="col col-auto">
                            <a href="{{ route('Embalmer.index') }}" class="cust-btn cust-btn-secondary"><i
                                class="bi bi-arrow-left"></i>
                                <span>Cancel</span>
                            </a>
                        </div>

                        {{-- Submit Button --}}
                        <div class="col col-auto ">
                        
                            <button type="submit" class="cust-btn cust-btn-primary"><i class="bi bi-send"></i>
                                Create
                            </button>
                        
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

@endsection
