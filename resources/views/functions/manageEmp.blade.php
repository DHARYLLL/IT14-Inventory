@extends('layouts.layout')
@section('title', 'Employee')

@section('content')
    @section('head', 'Profile')

    
    <div class="cust-h-full cust-plain-bg rounded-2">
        <div class="row h-100"> 

            <div class="col-md-12 ">
                
                {{-- Display Employee --}}
                <div class="row p-2">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="input-group cust-searchbar">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Search"
                                        style="border-radius: 0; border: none;">
                                    <button class="btn" id="clearSearch"
                                        style="background-color: #b3e6cc; color: black; border: none;">Clear</button>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('Employee.create') }}" class="cust-btn cust-btn-primary"><i class="bi bi-plus-lg"></i> <span>Add Employee</span></a>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-md-12 mt-2">
                        <table class="table table-hover modern-table mb-0">
                            <thead>
                                <tr class="table-white">
                                    <th class="fw-semibold">Employee</th>
                                    <th class="fw-semibold">Contact Number</th>
                                    <th class="fw-semibold">Address</th>
                                    <th class="fw-semibold">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @if ($empData->isEmpty())
                                    <tr>
                                        <td colspan="4" class="text-center text-secondary py-3">
                                            No Employee Available.
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($empData as $row)
                                        <tr>
                                            <td>{{ $row->emp_fname }} {{ $row->emp_mname }} {{ $row->emp_lname }}</td>
                                            <td>{{ $row->emp_contact_number }}</td>
                                            <td>{{ $row->emp_address }}</td>
                                            <td>
                                                <a href="{{ route('Employee.edit', $row->id) }}" class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>



            </div>
        </div>
    </div>


@endsection
