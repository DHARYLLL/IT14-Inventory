@extends('layouts.layout')
@section('title', 'Chapel')

@section('content')
    @section('head', 'Edit Chapel')

    <div class="cust-full-h">

        <div class="card shadow-sm border-0 rounded-3 p-4 bg-white h-100">

            <form action="{{ route('Chapel.update', $chapData->id) }}" method="POST" class="h-100">
                @csrf
                @method('PUT')
                {{-- Show Details --}}
                <div class="row cust-h-form justify-content-start align-items-start">
                    <div class="col-md-12 h-10">
                        <h3 class="fw-semibold text-success mb-4">Edit Chapel Details</h3>
                    </div>
                    <div class="col-md-12 cust-h">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Chapel Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="chapName" value="{{ old('chapName', $chapData->chap_name) }}">
                                @error('chapName')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Chapel Room <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="chapRoom" value="{{ old('chapRoom', $chapData->chap_room) }}">
                                @error('chapRoom')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Chapel Price <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control" name="chapPrice" value="{{ old('chapPrice', $chapData->chap_price) }}">
                                </div>
                                @error('chapPrice')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                </div>

                {{-- Submit --}}
                <div class="row justify-content-end cust-h-submit">
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
                            Save Changes
                        </button>
                    
                    </div>
                </div>
            </form>
        </div>
    </div>



@endsection
