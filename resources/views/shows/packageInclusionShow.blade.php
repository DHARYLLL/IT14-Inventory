@extends('layouts.layout')
@section('title', 'Equipments')

@section('content')
@section('head', 'Show Packages')
@section('name', 'Staff')

<div class="d-flex align-items-center justify-content-end mb-1">
    <a href="{{ route('Package.index') }}" class="btn btn-green d-flex align-items-center gap-2">
        <i class="bi bi-arrow-left"></i><span>Back</span>
    </a>
</div>

{{-- table --}}
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
@endsection
