@extends('layouts.layout')
@section('title', 'Report')

@section('content')
    @section('head', 'Report')

    <div class="h-100">
        <div class="row h-100">
            <div class="col-md-12 h-10">
                <form action="{{ route('Report.store') }}" method="POST">
                    @csrf
                    <div class="row justify-content-between">
                        <div class="col col-auto">
                            <select class="form-select" name="dateReport">
                                <option value="">Select Date</option>
                                <option value="all">All</option>
                                <option value="today">Today</option>
                                <option value="week">This week</option>
                                <option value="month">This month</option>
                                <option value="year">This year</option>
                            </select>
                            @error('dateReport')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col col-auto">
                            <div class="row">
                                <div class="col col-auto">
                                    <a href="{{ route('Job-Order.index') }}" class="cust-btn cust-btn-secondary">Back</a>
                                </div>
                                <div class="col col-auto">
                                    <button type="submit" class="cust-btn cust-btn-primary">Generate</button>
                                </div>
                            </div>
                            
                            
                        </div>
                    </div>
                    
                </form>
            </div>

            <div class="col-md-12 h-90">

                @if(session('showPreview'))
                    <iframe
                        src="{{ route('Report.preview') }}"
                        width="100%"
                        height="100%"
                        style="border: none;"
                    ></iframe>
                @endif
            </div>


        </div>
    </div>



@endsection
