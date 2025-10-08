@extends('layouts.layout')
@section('title', 'Equipments')

@section('content')
    @section('head', 'Show Equipment')
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
                    <p>{{ $eqData->eq_name }}</p>
                </div>
                <div class="col col-4">
                    <p>Equipemnt Available:</p>
                    <p>{{ $eqData->eq_available }}</p>
                </div>
                <div class="col col-4">
                    <p>Equipemnt In use:</p>
                    <p>{{ $eqData->eq_in_use }}</p>
                </div>
            </div>

        </form>
        
    </div>
@endsection