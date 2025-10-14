@extends('layouts.layout')
@section('title', 'Equipments')

@section('content')
@section('head', 'Packages')
@section('name', 'Staff')

<div class="d-flex align-items-center justify-content-between mb-4">
    <h2 class="fw-semibold">Packages</h2>
    <div class="input-group" style="border-radius: 10px; overflow: hidden;">
        <input type="text" id="searchInput" class="form-control" placeholder="Search Package" style="border-radius: 0; border: none;">
        <button class="btn" id="clearSearch" style="background-color: #b3e6cc; color: black; border: none;">Clear</button>
    </div>
    <a href="{{ route('Package.create') }}" class="btn btn-custom d-flex align-items-center gap-2"><i
            class="bi bi-plus-lg"></i><span>Add Package</span></a>
</div>

{{-- table --}}
<div class="bg-white rounded border overflow-hidden">
    <table class="table table-hover mb-0">
        <thead>
            <tr class="table-light">
                <th class="col col-md-10 fw-semibold">Package</th>
                <th class="col col-md-2 fw-semibold text-center">Action</th>
            </tr>
        </thead>

        <tbody id="tableBody">

            @if ($pacData->isEmpty())
                <tr>
                    <td colspan="3" class="text-center text-secondary py-3">
                        No new Package.
                    </td>
                </tr>
            @else
                @foreach ($pacData as $row)
                    <tr>
                        <td>{{ $row->pkg_name }}</td>
                        <td>
                            <a href="{{ route('Package.show', $row->id) }}" class="btn btn-outline-success btn-md"><i class="fi fi-rr-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a>
                            <form action="{{ route('Package.destroy', $row->id) }}" method="POST" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-md">
                                    <i class="bi bi-trash" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endif



        </tbody>
    </table>
</div>
@endsection
