@extends('layouts.layout')
@section('title', 'Equipment Details')

@section('content')
@section('head', 'Equipment Details')
@section('name', 'Staff')

<div class="d-flex align-items-center justify-content-end equipment-header m-1">
    <a href="{{ route('Equipment.index') }}" class="btn btn-green d-flex gap-2">
        <i class="bi bi-arrow-left"></i><span>Back</span>
    </a>
</div>

<!-- Equipment Info Table -->
<table class="modern-table table-hover mb-0">
    <thead>
        <tr>
            <th class="fw-semibold">Equipment Name</th>
            <th class="fw-semibold">Available</th>
            <th class="fw-semibold">In Use</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $eqData->eq_name }}</td>
            <td>{{ $eqData->eq_available }}</td>
            <td>{{ $eqData->eq_in_use }}</td>
        </tr>
    </tbody>
</table>



@endsection
