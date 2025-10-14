@extends('layouts.layout')
@section('title', 'Packages')

@section('content')
@section('head', 'Packages')
@section('name', 'Staff')

<div class="d-flex align-items-center justify-content-between p-2 mb-0">
    <div class="input-group" style="max-width: 600px; border-radius: 10px; overflow: hidden;">
        <input type="text" id="searchInput" class="form-control" placeholder="Search Package"
            style="border-radius: 0; border: none;">
        <button class="btn" id="clearSearch"
            style="background-color: #b3e6cc; color: black; border: none;">Clear</button>
    </div>
    <a href="{{ route('Package.create') }}" class="btn btn-green d-flex align-items-center gap-2"
        style="white-space: nowrap;">
        <i class="bi bi-plus-lg"></i><span>Add Package</span>
    </a>
</div>

{{-- Table --}}
<table class="modern-table table-hover mb-0">
    <thead>
        <tr class="table-light">
            <th class="fw-semibold">Package</th>
            <th class="col col-md-2 fw-semibold text-center">Action</th>
        </tr>
    </thead>

    <tbody id="tableBody">
        @if ($pacData->isEmpty())
            <tr>
                <td colspan="2" class="text-center text-secondary py-3">
                    No packages available.
                </td>
            </tr>
        @else
            @foreach ($pacData as $row)
                <tr>
                    <td>{{ $row->pkg_name }}</td>
                    <td class="text-center">
                        <div class="d-inline-flex justify-content-center gap-2">
                            <a href="{{ route('Package.show', $row->id) }}"
                                class="btn btn-outline-success btn-md d-flex align-items-center justify-content-center">
                                <i class="fi fi-rr-eye" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="View"></i>
                            </a>
                            <form action="{{ route('Package.destroy', $row->id) }}" method="POST" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="btn btn-outline-danger btn-md d-flex align-items-center justify-content-center">
                                    <i class="bi bi-trash" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Delete"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
</div>
@endsection
