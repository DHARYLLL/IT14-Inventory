@extends('layouts.layout')
@section('title', 'Equipments')

@section('content')
    @section('head', 'Logs')
    @section('name', 'Staff')

    <div class="d-flex align-items-center justify-content-between mb-4">
        
    </div>

    {{-- table --}}
    <div class="bg-white rounded border overflow-auto">
        <table class="table table-hover mb-0">
            <thead>
                <tr class="table-light">
                    <th class="fw-semibold">ID</th>
                    <th class="fw-semibold">Action</th>
                    <th class="fw-semibold">From</th>
                    <th class="fw-semibold">Date</th>
                    <th class="fw-semibold">Employee</th>
                </tr>
            </thead>

            <tbody>

                @if ($logData->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center text-secondary py-3">
                            No Recent Activity.
                        </td>
                    </tr>    
                @else
                    @foreach($logData as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->action }}</td>
                            <td>{{ $row->from }}</td>
                            <td>{{ $row->action_date }}</td>
                            <td>{{ $row->emp_id }}</td>
                        </tr>
                    @endforeach
                @endif

                

            </tbody>
        </table>
    </div>
@endsection