@extends('layouts.layout')
@section('title', 'Packages')

@section('content')
@section('head', 'Packages')
@section('name', 'Staff')

<div class="d-flex align-items-center justify-content-between p-2 cust-h-heading">
    <div class="input-group cust-searchbar">
        <input type="text" id="searchInput" class="form-control" placeholder="Search Package"
            style="border-radius: 0; border: none;">
        <button class="cust-btn cust-btn-search" id="clearSearch">Clear</button>
    </div>
    <a href="{{ route('Package.create') }}" class="cust-btn cust-btn-primary d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Package"
        style="white-space: nowrap;">
        <i class="bi bi-plus-lg"></i><span>Add Package</span>
    </a>
</div>

{{-- Table --}}
<div style="height: 90%;">
    <table class="table modern-table table-hover mb-0">
        <thead>
            <tr class="table-light">
                <th class="fw-semibold">Package</th>
                <th class="fw-semibold">Items</th>
                <th class="fw-semibold">Equipment</th>
                <th class="fw-semibold">Price</th>
                <th class="col col-md-2 fw-semibold text-center">Action</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @if ($pacData->isEmpty())
                <tr>
                    <td colspan="5" class="text-center text-secondary py-3">
                        No packages available.
                    </td>
                </tr>
            @else
                @foreach ($pacData as $row)
                    <tr>
                        <td>{{ $row->pkg_name }}</td>
                        <td>{{ $row->pkgToPkgSto->count() }}</td>
                        <td>{{ $row->pkgToPkgEq->count() }}</td>
                        <td>{{ $row->pkg_price }}</td>
                        <td class="text-center col col-md-2">
                            <div class="d-inline-flex justify-content-center gap-2">
                                <a href="{{ route('Package.edit', $row->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                    class="cust-btn cust-btn-secondary btn-md">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                @if(session("empRole") == 'sadmin' || session("empRole") == 'admin')
                                    <form action="{{ route('Package.destroy', $row->id) }}" method="POST" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                                            class="cust-btn cust-btn-danger-secondary btn-md">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                                
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

</div>

@endsection
