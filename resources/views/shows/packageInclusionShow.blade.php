@extends('layouts.layout')
@section('title', 'Equipments')

@section('content')
@section('head', 'Show Packages')
@section('name', 'Staff')

<div class="d-flex align-items-center justify-content-between mb-4">
    <h2 class="fw-semibold">Show Packages</h2>
    <a href="{{ route('Package.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2">
        <i class="bi bi-arrow-left-circle"></i> <span>Back</span>
    </a>
</div>

{{-- table --}}
<div class="bg-white rounded border overflow-hidden">
    <table class="table table-hover mb-0">
        <thead>
            <tr class="table-light">
                <th class="fw-semibold">Inclusion</th>
                <th class="fw-semibold">Action</th>
            </tr>
        </thead>

        <tbody>

            @if ($pckIncData->isEmpty())
                <tr>
                    <td colspan="3" class="text-center text-secondary py-3">
                        No new Package.
                    </td>
                </tr>
            @else
                @foreach ($pckIncData as $row)
                    <tr>
                        <td>{{ $row->pkg_inclusion }}</td>
                        <td>
                            hellos
                        </td>
                    </tr>
                @endforeach
            @endif



        </tbody>
    </table>
</div>
@endsection
