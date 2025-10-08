@extends('layouts.layout')
@section('title', 'Equipments')

@section('content')
    @section('head', 'Add Package')
    @section('name', 'Staff')

    <div class="d-flex align-items-center justify-content-end mb-4">
        <a href="{{ route('Package.index') }}" class="btn btn-custom d-flex align-items-center gap-2"><span>Back</span></a>
    </div>

    {{-- table --}}
    <div class="bg-white rounded border overflow-hidden">
        <form action="{{ route('Package.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col col-6">
                    <input type="text" placeholder="package name" name="pkg_name">
                    @error('pkg_name')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
                <div class="col col-6">
                    <input type="text" placeholder="inclusion" name="pkg_inclusion">
                    @error('pkg_inclusion')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col col-12">
                    <button type="submit" class="btn btn-success w-100">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection