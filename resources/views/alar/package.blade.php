@extends('layouts.layout')
@section('title', 'Equipments')

@section('content')
    @section('head', 'Packages')
    @section('name', 'Staff')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="fw-semibold">Packages</h2>
        <a href="{{ route('Package.create') }}" class="btn btn-custom d-flex align-items-center gap-2"><i class="bi bi-plus-lg"></i><span>Add Package</span></a>
    </div>

    {{-- table --}}
    <div class="bg-white rounded border overflow-hidden">
        <table class="table table-hover mb-0">
            <thead>
                <tr class="table-light">
                    <th class="fw-semibold">Package</th>
                    <th class="fw-semibold">pkg_inclusion</th>
                    <th class="fw-semibold">Action</th>
                </tr>
            </thead>

            <tbody>

                @if ($pacData->isEmpty())
                    <tr>
                        <td colspan="3" class="text-center text-secondary py-3">
                            No Equipment available.
                        </td>
                    </tr>    
                @else
                    @foreach($pacData as $row)
                        <tr>
                            <td>{{ $row->pkg_name }}</td>
                            <td>{{ $row->pkg_inclusion }}</td>
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