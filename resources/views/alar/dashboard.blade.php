@extends('layouts.layout')

@section('title', 'Dashboard')
@section('head', 'Dashboard')
@section('name', 'Staff')

@section('content')
    <div class="dashboard-container">

        <!-- Summary Cards -->
        <div class="summary-cards d-flex flex-wrap gap-3 mb-4">
            <div class="summary-card total-items flex-fill">
                <h5>Total Items</h5>
                <div class="card-content">
                    <i class="bi bi-box-seam"></i>
                    <span class="count">{{ $stockData->count('item_name') }}</span>
                </div>
            </div>

            <div class="summary-card low-stock flex-fill">
                <h5>Low Stock</h5>
                <div class="card-content">
                    <i class="bi bi-exclamation-triangle"></i>
                    <span class="count">{{ $lowStockData->count('item_name') }}</span>
                </div>
            </div>

            <div class="summary-card out-of-stock flex-fill">
                <h5>Out of Stock</h5>
                <div class="card-content">
                    <i class="bi bi-x-circle"></i>
                    <span class="count">{{ $noStockData->count('item_name') }}</span>
                </div>
            </div>

            <div class="summary-card out-of-stock flex-fill">
                <h5>This Month Average Spending</h5>
                <div class="card-content">
                    <i class="bi bi-cash-coin"></i>
                    <span class="count">₱{{ number_format($getAv, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Lower Section (2 Boxes) -->
        <div class="bottom-section">
            <div class="row g-3">

                {{-- Schedule --}}
                <div class="col-md-12">
                    <div class="dashboard-box">
                        <h5>Schedule</h5>
                        <div class="placeholder-box overflow-auto">
                            <table class="table table-borderless table-hover placeholder-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Client</th>
                                        <th>Contact #</th>
                                        <th>Start date</th>
                                        <th>Start time</th>
                                        <th>Equipment</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($jobOrdData->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No schedule available</td>
                                        </tr>
                                    @else
                                        @foreach ($jobOrdData as $row)
                                            <tr>
                                                <td>{{ $row->client_name }}</td>
                                                <td>{{ $row->client_contact_number }}</td>
                                                <td>{{ $row->jo_start_date }}</td>
                                                <td>{{ \Carbon\Carbon::parse($row->jo_start_time)->format('g:i A') }}</td>
                                                <td>{{ $row->joToJod->jod_eq_stat }}</td>
                                                <td>
                                                    @if($row->jod_id)
                                                        @if($row->joToJod->jod_eq_stat == 'Pending')
                                                            <a href="{{ route('Job-Order.showDeploy', $row->id) }}"
                                                                class="btn btn-outline-success btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Deploy">
                                                                <i class="bi bi-box-arrow-up"></i>
                                                            </a>
                                                        @endif 
                                                        @if($row->joToJod->jod_eq_stat == 'Deployed')
                                                            <a href="{{ route('Job-Order.showReturn', $row->id) }}"
                                                                class="btn btn-outline-success btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Return">
                                                                <i class="bi bi-box-arrow-in-down"></i>
                                                            </a>
                                                        @endif 
                                                        @if($row->joToJod->jod_eq_stat == 'Returned')
                                                            <a href="{{ route('Job-Order.show', $row->id) }}"
                                                                class="btn btn-outline-success btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                                                <i class="fi fi-rr-eye"></i>                              
                                                            </a>
                                                        @endif 
                                                    @endif
                                                    @if($row->svc_id)
                                                        @if($row->jo_status == 'Paid')
                                                            <a href="{{ route('Service-Request.show', $row->id) }}"
                                                                class="btn btn-outline-success btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                                                <i class="fi fi-rr-eye"></i>
                                                            </a>
                                                        @else
                                                            <a href="{{ route('Service-Request.show', $row->id) }}"
                                                                class="btn btn-outline-success btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Review">
                                                                <i class="bi bi-list-ul"></i>
                                                            </a>
                                                        @endif

                                                        
                                                    @endif

                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="col-md-6">
                    <div class="dashboard-box">
                        <h5>Recent Activity</h5>
                        <div class="placeholder-box overflow-auto">
                            <table class="table table-borderless table-hover placeholder-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Action Date</th>
                                        <th>Employee</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($logData->isEmpty())
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">No data available</td>
                                        </tr>
                                    @else
                                        @foreach ($logData as $row)
                                            <tr>
                                                <td>{{ $row->transaction }}</td>
                                                <td>{{ $row->tx_date }}</td>
                                                <td>{{ $row->logToEmp->emp_fname }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Low Stock Items -->
                <div class="col-md-6">
                    <div class="dashboard-box">
                        <h5>Low Stock Items</h5>
                        <div class="placeholder-box overflow-auto">
                            <table class="table table-borderless table-hover placeholder-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Size</th>
                                        <th>Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($lowStockData->isEmpty())
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No data available</td>
                                        </tr>
                                    @else
                                        @foreach ($lowStockData as $row)
                                            <tr>
                                                <td>{{ $row->item_name }}</td>
                                                <td>{{ $row->item_qty }}</td>
                                                <td>{{ $row->item_size }}</td>
                                                <td>{{ $row->item_unit }}</td>
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
    </div>
@endsection
