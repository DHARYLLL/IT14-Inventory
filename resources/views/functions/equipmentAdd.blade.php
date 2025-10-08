@extends('layouts.layout')
@section('title', 'Equipments')

@section('content')
    @section('head', 'Create Equipment')
    @section('name', 'Staff')

    <div class="d-flex align-items-center justify-content-end mb-4">

        <a href="{{ route('Equipment.index') }}" class="btn btn-custom d-flex align-items-center gap-2"></i><span>Back</span></a>
    </div>

    {{-- table --}}
    <div class="bg-white rounded border overflow-hidden">
        <form action="{{ route('Equipment.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col col-4">
                    <p>Equipemnt name:</p>
                </div>
                <div class="col col-4">
                    <input type="number" name="eq_add">
                    @error('eq_add')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
                <div class="col col-4">
                    <input type="text" name="eq_name">
                    @error('eq_name')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="row">

                <div class="col col-12">
                    <button type="submit" class="btn btn-success w-100">Add Equipment</button>
                </div>
            </div>

        </form>
        
    </div>
@endsection