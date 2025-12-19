@extends('layouts.layout')
@section('title', 'Chapel')

@section('content')
    @section('head', 'Add Chapel')

    <div class="cust-h-content-func">
        <div class="card bg-white border-0 rounded-3 h-100">
            <div class="card-body h-100">
                
                <form action="{{ route('Chapel.store') }}" method="post" class="h-100">
                    @csrf

                    <div class="row cust-h-form">
                        <div class="col-md-12 h-10">
                            <h3 class="fw-semibold text-success mb-4">Add Chapel</h3>
                        </div>

                        <div class="col-md-12 cust-h">

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="chapName" class="form-label">Name: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="chapName" placeholder="Chapel Name" value="{{ old('chapName') }}">
                                    @error('chapName')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label for="chapRoom" class="form-label">Room: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="chapRoom" placeholder="Room Number" value="{{ old('chapRoom') }}">
                                    @error('chapRoom')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label for="chapPrice" class="form-label">Room Price: <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="text" class="form-control" name="chapPrice" placeholder="Price" value="{{ old('chapPrice') }}">
                                    </div>
                                    @error('chapPrice')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>


                    {{-- Submit --}}
                    <div class="row justify-content-end mt-4 cust-h-submit">
                        {{-- Display Error --}}
                        <div class="col col-auto">
                            @session('promt-s')
                                    <div class="text-success small mt-1">{{ $value }}</div>
                            @endsession
                        </div>

                        <div class="col col-auto">
                            <a href="{{ route('Chapel.index') }}" class="cust-btn cust-btn-secondary"><i
                                class="bi bi-arrow-left"></i>
                                <span>Cancel</span>
                            </a>
                        </div>

                        {{-- Submit Button --}}
                        <div class="col col-auto ">
                        
                            <button type="submit" class="cust-btn cust-btn-primary"><i class="bi bi-send"></i>
                                Create
                            </button>
                        
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

@endsection
