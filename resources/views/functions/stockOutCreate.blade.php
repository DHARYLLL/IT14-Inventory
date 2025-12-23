@extends('layouts.layout')
@section('title', 'Stock out')

@section('head', 'Stock out Items')

@section('content')

    {{-- Main Card --}}
    <div class="cust-add-form">

        <form action="{{ route('Stock-Out.store') }}" method="POST" id="form" class="h-100">
            @csrf

            <div class="row">
                <div class="col col-auto">
                    <h4 class="form-title">Stock-out</h4>
                </div>
            </div>

            <div class="row mt-4 cust-white-bg">
                <div class="col-md-12">
                    <h5 class="cust-sub-title">Reason:</h5>
                </div>

                <div class="col-md-12">
                    <label for="" class="form-label">Reason for Stock-out <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="reason" value="{{ old('reason') }}">
                    @error('reason')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mt-4 cust-white-bg">
                <div class="col-md-12">
                    <h5 class="cust-sub-title">Stock:</h5>
                </div>

                {{-- Stock --}}
                <div class="col-md-12">
                    <div class="d-flex gap-2 align-items-center">
                        <select name="" id="stock" class="form-select w-50" onchange="getQtyStoOut()">
                            <option value="">Select Stock</option>
                            @foreach ($stoData as $data)
                                <option value="{{ $data->id }},{{ $data->item_name }}:{{ $data->item_size }};{{ $data->item_net_content }}">
                                    {{ $data->item_name }} | Size: {{ $data->item_size }} | In Stock: {{ $data->item_qty }}
                                </option>
                            @endforeach
                        </select>
                        <input type="text" id="sto" class="form-control w-25" readonly placeholder="Available" hidden>
                
                        <button type="button" id="add_sto" onclick="checkInputStoOut()" class="cust-btn cust-btn-primary">
                            <i class="bi bi-plus-circle"></i> Add Stock
                        </button>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="row cust-table-header cust-table-shadow">
                        <div class="col-md-4">Name</div>
                        <div class="col-md-2">Size / Unit</div>
                        <div class="col-md-2">Quantity</div>
                        <div class="col-md-2">Net Contents</div>
                        <div class="col-md-2">Remove</div>
                    </div>
                </div>
                <div id="addStock" class="col-md-12 cust-max-300 cust-table-shadow">
                        
                    @php
                        $oldItems = old('itemName', ['']);
                        $oldStock = old('stock', ['']);
                        $oldStoSize = old('stockSize', ['']);
                        $oldStoQty = old('stockQty', ['']);
                        $oldQtySet = old('stockQtySet', ['']);
                    @endphp
                    @if(!empty(array_filter($oldItems)))
                        @foreach($oldItems as $i => $item)
                            <div class="row cust-table-content py-3 added-item">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="itemName[]" value="{{ $item }}" readonly>
                                    <input type="text" name="stock[]" value="{{ $oldStock[$i] ?? '' }}" hidden>
                                    
                                    @error("itemName.$i")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" name="stockSize[]" value="{{ $oldStoSize[$i] ?? '' }}" readonly>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" name="stockQty[]" value="{{ $oldStoQty[$i] ?? '' }}">
                                    @error("stockQty.$i")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="stockQtySet[]" value="{{ $oldQtySet[$i] ?? '' }}" readonly>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-outline-danger w-100 remove-sto"><i class="bi bi-x-circle"></i> </button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>


            </div>



            <div class="row mt-4 cust-white-bg">
                <div class="col-md-12">
                    <h5 class="cust-sub-title">Equipment:</h5>
                </div>

                {{-- Equipment --}}
                <div class="col-md-12">
                    <label for="equipment" class="form-label">Equipment</label>
                    <div class="d-flex gap-2 align-items-center">
                        <select name="" id="equipment" class="form-select w-50" onchange="getQtyOut()">
                            <option value="">Select Equipment</option>
                            @foreach ($eqData as $data)
                                <option value="{{ $data->id }},{{ $data->eq_name }}:{{ $data->eq_size }};{{ $data->eq_net_content }}">
                                    {{ $data->eq_name }} | Size: {{ $data->eq_size }} | Available: {{ $data->eq_available }}
                                </option>
                            @endforeach
                        </select>
                        <input type="text" id="avail" class="form-control w-25" readonly placeholder="Available" hidden>
                        <button type="button" id="add_eq" onclick="checkInputEqOut()" class="cust-btn cust-btn-primary"><i
                                class="bi bi-plus-circle"></i>
                            Add Equipment
                        </button>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="row cust-table-header cust-table-shadow">
                        <div class="col-md-4">Name</div>
                        <div class="col-md-2">Size / Unit</div>
                        <div class="col-md-2">Quantity</div>
                        <div class="col-md-2">Net Contents</div>
                        <div class="col-md-2">Remove</div>
                    </div>
                </div>
                <div id="addEquipment" class="col-md-12 cust-max-300 cust-table-shadow">
                    @php
                        $oldEq = old('eqName', ['']);
                        $oldEqId = old('equipment', ['']);
                        $oldEqSize = old('eqSize', ['']);
                        $oldEqQtys = old('eqQty', ['']);
                        $oldEqQtySet = old('eqQtySet', ['']);
                    @endphp
                    @if(!empty(array_filter($oldEq)))
                        @foreach($oldEq as $i => $item)
                            <div class="row g-2 align-items-start mb-2 added-item">
                                
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="eqName[]" value="{{ $item }}" readonly>
                                    <input type="text" name="equipment[]" value="{{ $oldEqId[$i] ?? '' }}" hidden>
                                    @error("eqName.$i")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-2">
                                    <input type="text" class="form-control" name="eqSize[]" value="{{ $oldEqSize[$i] ?? '' }}" readonly>
                                    @error("eqSize.$i")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="eqQty[]" value="{{ $oldEqQtys[$i] ?? '' }}">
                                    @error("eqQty.$i")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="eqQtySet[]" value="{{ $oldEqQtySet[$i] ?? '' }}">
                                </div>

                                <div class="col-md-2">
                                    <button type="button" class="btn btn-outline-danger w-100 remove-eq"><i class="bi bi-x-circle"></i></button>
                                </div>
                            </div>
                        @endforeach
                    @endif
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
    <script>
        function getQtyOut() {
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

        function checkInputEqOut() {
            const input = document.getElementById("avail");
            const get = document.getElementById('equipment');
            if (!input || !get) return;

            if (input.value.trim() === "") {
                alert("Input is empty");
                return;
            }

            var idData = get.options[get.selectedIndex].value;
            let forId = idData.slice(0, idData.indexOf(","));
            let forName = idData.slice(idData.indexOf(",") + 1, idData.indexOf(":"));
            let forSize = idData.slice(idData.indexOf(":") + 1, idData.indexOf(";"));
            let forNet = idData.slice(idData.indexOf(";") + 1);

            const wrapper = document.createElement('div');
            wrapper.classList.add('row', 'cust-table-conten', 'py-3', 'added-item');

            wrapper.innerHTML = `
                <div class="col-md-4">
                    <input type="text" class="form-control" name="eqName[]" value="${forName}" readonly>
                    <input type="text" name="equipment[]" value="${forId}" hidden>
                </div>

                <div class="col-md-2">
                    <input type="text" class="form-control" name="eqSize[]" value="${forSize}" readonly>
                </div>

                <div class="col-md-2">
                    <input type="number" class="form-control" name="eqQty[]" value="1">
                </div>

                <div class="col-md-2">
                    <input type="number" class="form-control" name="eqQtySet[]" value="${forNet}" readonly>
                </div>

                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-danger w-100 remove-eq"><i class="bi bi-x-circle"></i></button>
                </div>
            `;

            document.getElementById('addEquipment').appendChild(wrapper);
        }

        // remove equipment row
        if (document.getElementById('addEquipment')) {
            document.getElementById('addEquipment').addEventListener('click', function (event) {
                if (event.target && event.target.classList.contains('remove-eq')) {
                    event.target.closest('.added-item').remove();
                }
            });
        }

        // --- STOCK --- //

        function getQtyStoOut() {
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

        function checkInputStoOut() {
            const input = document.getElementById("sto");
            const get = document.getElementById('stock');
            if (!input || !get) return;

            if (input.value.trim() === "") {
                alert("Input is empty");
                return;
            }

            
            var idData = get.options[get.selectedIndex].value;
            let forId = idData.slice(0, idData.indexOf(","));
            let forName = idData.slice(idData.indexOf(",") + 1, idData.indexOf(":"));
            let forSize = idData.slice(idData.indexOf(":") + 1, idData.indexOf(";"));
            let forNet = idData.slice(idData.indexOf(";") + 1);

            const wrapper = document.createElement('div');
            wrapper.classList.add('row', 'cust-table-conten', 'py-3', 'added-item');

            wrapper.innerHTML = `
                <div class="col-md-4">
                    <input type="text" class="form-control" name="itemName[]" value="${forName}" readonly>
                    <input type="text" name="stock[]" value="${forId}" hidden>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="stockSize[]" value="${forSize}" readonly>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="stockQty[]" value="1">
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="stockQtySet[]" value="${forNet}" readonly>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-danger w-100 remove-sto"><i class="bi bi-x-circle"></i></button>
                </div>
            `;

            document.getElementById('addStock').appendChild(wrapper);
        }

        // remove stock row
        if (document.getElementById('addStock')) {
            document.getElementById('addStock').addEventListener('click', function (event) {
                if (event.target && event.target.classList.contains('remove-sto')) {
                    event.target.closest('.added-item').remove();
                }
            });
        }


    </script>


    
@endsection