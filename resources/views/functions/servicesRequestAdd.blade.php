@extends('layouts.layout')
@section('title', 'Equipments')

@section('content')
    @section('head', 'Add Services Request')
    @section('name', 'Staff')

    <div class="d-flex align-items-center justify-content-end mb-4">

        <a href="{{ route('Service-Request.index') }}" class="btn btn-custom d-flex align-items-center gap-2"><span>Back</span></a>
    </div>

    {{-- table --}}
    <div class="bg-white rounded border overflow-hidden">
        <form action="{{ route('Service-Request.store') }}" method="post">
            @csrf

            <select name="package" id="package">
                    <option value=""></option>
                @foreach($pkgData as $data)
                    <option value="{{ $data->id }}">{{ $data->id }} {{ $data->pkg_name }}</option>
                @endforeach
            </select>
            @error('package')
                <p style="color:red">{{ $message }}</p>
            @enderror

            <div>
                <label for="startDate">Start date</label>
                <input type="date" name="startDate">
                @error('startDate')
                    <p>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="endDate">End date</label>
                <input type="date" name="endDate">
                @error('endDate')
                    <p>{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="wakeLoc">Wake location</label>
                <input type="text" name="wakeLoc">
                @error('wakeLoc')
                    <p>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="churhcLoc">Church location</label>
                <input type="text" name="churhcLoc">
                @error('churhcLoc')
                    <p>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="burialLoc">Burial location</label>
                <input type="text" name="burialLoc">
                @error('burialLoc')
                    <p>{{ $message }}</p>
                @enderror
            </div>

            <div>
                <select name="equipment" id="equipment" onchange="getQty()">
                        <option value=""></option>
                    @foreach($eqData as $data)
                        <option value="{{ $data->id }},{{ $data->eq_available }}">{{ $data->id }} {{ $data->eq_name }}</option>
                    @endforeach
                </select>
                <input type="text" id="avail" readonly>
                <button type="button" id="add_eq" onclick="checkInputEq()">Add Equipment</button>
            </div>

            <div id="addEquipment">
                
                @php
                    $oldItems = old('equipment', ['']);
                    $oldQtys = old('eqQty', ['']);
                @endphp

                @foreach($oldItems as $i => $item)
                    <div class="input-group-eq">

                    </div>
                @endforeach

            </div>



            <div>
                <select name="stock" id="stock" onchange="getQtySto()">
                        <option value=""></option>
                    @foreach($stoData as $data)
                        <option value="{{ $data->id }},{{ $data->item_qty }}">{{ $data->id }} {{ $data->item_name }} {{ $data->size_weight }}</option>
                    @endforeach
                </select>
                <input type="text" id="sto" readonly>
                <button type="button" id="add_sto" onclick="checkInputSto()">Add Stock</button>
            </div>

            <div id="addStock">
                
                @php
                    $oldItems = old('stock', ['']);
                    $oldQtys = old('stockQty', ['']);
                @endphp

                @foreach($oldItems as $i => $item)
                    <div class="input-group-sto">

                    </div>
                @endforeach

            </div>

            <button type="submit">Submit</button>


        </form>
    </div>
@endsection