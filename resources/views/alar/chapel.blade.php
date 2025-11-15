@extends('layouts.layout')
@section('title', 'Chapels')

@section('content')
    @section('head', 'Chapels')
    @section('name', 'Staff')

    <div class="d-flex align-items-center justify-content-between p-2 mb-0 cust-h-heading">
    <div class="input-group" style="max-width: 600px; border-radius: 10px; overflow: hidden;">
        <input type="text" id="searchInput" class="form-control" placeholder="Search Stock"
            style="border-radius: 0; border: none;">
        <button class="btn" id="clearSearch"
            style="background-color: #b3e6cc; color: black; border: none;">Clear</button>
    </div>
    <div>
        <a href="{{ route('Chapel.create') }}" class="cust-btn cust-btn-primary"><i class="bi bi-plus-lg"></i> <span>Add Chapel</span></a>
    </div>
    </div>


    {{-- Stock Table --}}
    <div class="cust-h-content overflow-auto">
        <table class="table table-hover modern-table mb-0">
            <thead>
                <tr class="table-white">
                    <th class="fw-semibold">Name</th>
                    <th class="fw-semibold">Room</th>
                    <th class="fw-semibold">Status</th>
                    <th class="fw-semibold">Price</th>
                    <th class="fw-semibold">Action</th>
                </tr>
            </thead>

            <tbody id="tableBody">
                @if ($chapData->isEmpty())
                    <tr>
                        <td colspan="3" class="text-center text-secondary py-3">
                            No Chapel Available.
                        </td>
                    </tr>
                @else
                    @foreach ($chapData as $row)
                        <tr>
                            <td>{{ $row->chap_name }}</td>
                            <td>{{ $row->chap_room }}</td>
                            <td>{{ $row->chap_status }}</td>
                            <td>₱ {{ $row->chap_price }}</td>
                            <td>
                                <a href="{{ route('Chapel.edit', $row->id) }}" class="btn btn-outline-success btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
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
