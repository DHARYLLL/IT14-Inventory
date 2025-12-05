@extends('layouts.layout')
@section('title', 'Embalmer')

@section('content')
    @section('head', 'Embalmers')

    <div class="d-flex align-items-center justify-content-between p-2 mb-0 cust-h-heading">
    <div class="input-group cust-searchbar">
        <input type="text" id="searchInput" class="form-control" placeholder="Search Embalmer"
            style="border-radius: 0; border: none;">
        <button class="btn" id="clearSearch"
            style="background-color: #b3e6cc; color: black; border: none;">Clear</button>
    </div>
    <div>
        <a href="{{ route('Embalmer.create') }}" class="cust-btn cust-btn-primary"><i class="bi bi-plus-lg"></i> <span>Add Embalmer</span></a>
    </div>
    </div>


    {{-- Stock Table --}}
    <div class="cust-h-content overflow-auto">
        <table class="table table-hover modern-table mb-0">
            <thead>
                <tr class="table-white">
                    <th class="fw-semibold">Name</th>
                    <th class="fw-semibold">Service Price</th>
                    <th class="fw-semibold">Action</th>
                </tr>
            </thead>

            <tbody id="tableBody">
                @if ($leData->isEmpty())
                    <tr>
                        <td colspan="3" class="text-center text-secondary py-3">
                            No Embalmer Available.
                        </td>
                    </tr>
                @else
                    @foreach ($leData as $row)
                        <tr>
                            <td>{{ $row->embalmer_name }}</td>
                            <td>₱{{ $row->prep_price }}</td>
                            <td>
                                <a href="{{ route('Embalmer.edit', $row->id) }}" class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

    </div>

@endsection
