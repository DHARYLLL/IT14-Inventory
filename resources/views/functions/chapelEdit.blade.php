@extends('layouts.layout')
@section('title', 'Chapel')

@section('content')
    @section('head', 'Edit Chapel')
    @section('name', 'Staff')


    <div class="cust-h-content-func">
        <div class="card h-100">
            <div class="card-body h-100">

                <form action="" method="post">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label class="fw-semibold text-dark mb-1">Package Name</label>
                            <input type="text" name="chapName" class="form-control" value="">
                            @error('chapName')
                                <p class="text-danger small mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>


                </form>

            </div>
        </div>
    </div>


@endsection
