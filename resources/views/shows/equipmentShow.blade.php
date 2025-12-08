@extends('layouts.layout')
@section('title', 'Equipments')

@section('content')
@section('head', 'Equipment View')

<div class="d-flex align-items-center justify-content-end m-2">
    <a href="{{ route('Equipment.index') }}" class="cust-btn cust-btn-secondary">
        <i class="bi bi-arrow-left"></i>
        <span>Back</span>
    </a>
</div>

<div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <p class="fw-semibold text-dark mb-1">Equipment Name</p>
                <div class="border rounded-3 p-2 bg-light">{{ $eqData->eq_name }}</div>
            </div>
            <div class="col-md-4">
                <p class="fw-semibold text-dark mb-1">Available</p>
                <div class="border rounded-3 p-2 bg-light">{{ $eqData->eq_available }}</div>
            </div>
            <div class="col-md-4">
                <p class="fw-semibold text-dark mb-1">In Use</p>
                <div class="border rounded-3 p-2 bg-light">{{ $eqData->eq_in_use }}</div>
            </div>
        </div>
    </div>
</div>

@endsection
