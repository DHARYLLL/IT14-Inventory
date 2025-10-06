@extends('layouts.layout')
@section('title', 'Supplier')

@section('content')

    @section('head', 'Supplier')
    @section('name', 'Staff')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="fw-semibold">Suppliers</h2>

        <button class="btn btn-custom d-flex align-items-center gap-2" type="button" data-bs-toggle="modal" data-bs-target="#NewPOModal">
            <i class="bi bi-plus-lg"></i>
            <span>Add Supplier</span>
        </button>
    </div>

    {{-- table --}}
    <div class="bg-white rounded border overflow-hidden">
        <table class="table table-hover mb-0">
            <thead>
                <tr class="table-light">
                    <th class="fw-semibold">Supplier #</th>
                    <th class="fw-semibold">Name</th>
                    <th class="fw-semibold">Contact number</th>
                    <th class="fw-semibold">Company name</th>
                    <th class="fw-semibold">Company Address</th>
                    <th class="fw-semibold">Action</th>
                </tr>
            </thead>

            <tbody>
                <td>001</td>
                <td>Supplier 1</td>
                <td>10000</td>
                <td>qwerty</td>
                <td>Matina</td>
            </tbody>
        </table>
    </div>
    
@endsection