@extends('layouts.layout')
@section('title', 'Equipments')

@section('content')
    @section('head', 'Equipments')
    @section('name', 'Staff')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="fw-semibold">Equipments</h2>
        <a href="{{ route('Equipment.create') }}" class="btn btn-custom d-flex align-items-center gap-2"><i class="bi bi-plus-lg"></i><span>Add Equipment</span></a>
    </div>

    {{-- table --}}
    <div class="bg-white rounded border overflow-hidden">
        <table class="table table-hover mb-0">
            <thead>
                <tr class="table-light">
                    <th class="fw-semibold">Equipment</th>
                    <th class="fw-semibold">Available</th>
                    <th class="fw-semibold">In use</th>
                    <th class="fw-semibold">Action</th>
                </tr>
            </thead>

            <tbody>

                @if ($eqData->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center text-secondary py-3">
                            No Equipment available.
                        </td>
                    </tr>    
                @else
                    @foreach($eqData as $row)
                        <tr>
                            <td>{{ $row->eq_name }}</td>
                            <td>{{ $row->eq_available }}</td>
                            <td>{{ $row->eq_in_use }}</td>
                            <td>
                                <a href="{{ route('Equipment.show', $row->id) }}">View</a>
                            </td>
                        </tr>
                    @endforeach
                @endif

                

            </tbody>
        </table>
    </div>
@endsection