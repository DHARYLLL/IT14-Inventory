@extends('layouts.layout')
@section('title', 'Equipments')

@section('content')
@section('head', 'Show Packages')
@section('name', 'Staff')

<div class="d-flex align-items-center justify-content-between mb-4">
    <h2 class="fw-semibold">Show Packages</h2>
    @session('promt')
        <h2 class="fw-semibold">{{ $value }}</h2>
    @endsession
    <a href="{{ route('Package.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2">
        <i class="bi bi-arrow-left-circle"></i> <span>Back</span>
    </a>
</div>

{{-- table --}}
<div class="bg-white rounded border overflow-hidden">
    <div class="row">

        <div class="col col-8">

            <form action="{{ route('Package.update', $pkgData->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col col-8 p-3">
                        <input type="text" name="pkgName" class="form-control" value="{{ $pkgData->pkg_name }}">
                        @error('pkgName')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col col-4 p-3">
                        <button class="btn btn-primary w-100">update</button>
                    </div>
                </div>
            </form>

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
                                    <a href="{{ route('Package-Inclusion.edit', $row->id) }}">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif



                </tbody>
            </table>


        </div>

        <div class="col col-4">
            @yield('package-edit')
        </div>


    </div>
    
</div>
@endsection
