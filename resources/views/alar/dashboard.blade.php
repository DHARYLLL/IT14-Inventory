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
                    <span class="count">{{ $stockData->count('item_name') + $eqData->count('eq_name') }}</span>
                </div>
            </div>

            <div class="summary-card low-stock flex-fill">
                <h5>Low Stock</h5>
                <div class="card-content">
                    <i class="bi bi-exclamation-triangle"></i>
                    <span class="count">{{ $lowStockData->count('item_name') + $lowEqData->count() }}</span>
                </div>
            </div>

            <div class="summary-card out-of-stock flex-fill">
                <h5>Out of Stock</h5>
                <div class="card-content">
                    <i class="bi bi-x-circle"></i>
                    <span class="count">{{ $noStockData->count('item_name') + $noEqData->count() }}</span>
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

        <!-- Mid Section -->
        <div class="bottom-section">
            <div class="row g-3">

                {{-- Schedule --}}
                <div class="col-md-12">
                    <div class="dashboard-box">
                        <h5>On going schedule</h5>
                        <div class="placeholder-box cust-max-500">
                            <table class="table table-borderless table-hover placeholder-table mb-0" >
                                <thead>
                                    <tr>
                                        <th class="fw-semibold">Client</th> 
                                        <th class="fw-semibold">RA</th>
                                        <th class="fw-semibold">Service Date</th>
                                        <th class="fw-semibold">Burial date</th>
                                        <th class="fw-semibold">Burial time</th>
                                        <th class="col col-md-2 fw-semibold text-center">Action</th>
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
                                                <td>{{ $row->client_fname }} {{ $row->client_lname }}</td>
                                                <td>                     
                                                    <form action="{{ route('Job-Order.raUpdate', $row->id) }}" method="POST" class="raForm">
                                                        @csrf
                                                        @method('put')
                                                        <label>
                                                            <input type="checkbox" name="status" class="raCheckbox" {{ $row->ra ? 'checked' : '' }} {{ $row->ba_id || $row->jo_status == 'Paid' || !$row->jod_id ? 'disabled' : '' }}>
                                                        </label>
                                                    </form>
                                                </td>
                                                <td>{{ $row->jo_start_date ? \Carbon\Carbon::parse($row->jo_start_date)->format('d/M/Y') : 'No Sched.' }}</td>
                                                <td>{{ $row->jo_burial_date ? \Carbon\Carbon::parse($row->jo_burial_date)->format('d/M/Y') : 'No Sched.' }}</td>
                                                <td>{{ $row->jo_burial_time ? \Carbon\Carbon::parse($row->jo_burial_time)->format('g:i A') : 'No Sched.' }}</td>
                                                <td class="text-center col col-md-2">
                                                    <div class="d-inline-flex justify-content-center gap-2">
                                                        @if($row->jod_id)
                                                            @if($row->joToJod->jod_eq_stat == 'Pending')
                                                                <a href="{{ route('Job-Order.showDeploy', $row->id) }}"
                                                                    class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Deploy">
                                                                    <i class="bi bi-box-arrow-up"></i>
                                                                </a>
                                                            @endif
                                                            @if($row->joToJod->jod_eq_stat == 'Deployed')
                                                                <a href="{{ route('Job-Order.showReturn', $row->id) }}"
                                                                    class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Return">
                                                                    <i class="bi bi-box-arrow-in-down"></i>
                                                                </a>
                                                            @endif
                                                            @if($row->joToJod->jod_eq_stat == 'Returned')
                                                                <a href="{{ route('Job-Order.show', $row->id) }}"
                                                                    class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                                                    <i class="fi fi-rr-eye"></i>
                                                                </a>
                                                            @endif
                                                        @endif
                                                        @if($row->svc_id && !$row->jod_id)
                                                            @if($row->jo_status == 'Paid')
                                                                <a href="{{ route('Service-Request.show', $row->id) }}"
                                                                    class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                                                    <i class="fi fi-rr-eye"></i>
                                                                </a>
                                                            @else
                                                                <a href="{{ route('Service-Request.show', $row->id) }}"
                                                                    class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Review">
                                                                    <i class="bi bi-list-ul"></i>
                                                                </a>
                                                            @endif
                                                        
                                                        @endif
                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                        <script>
                                            document.querySelectorAll('.raCheckbox').forEach((checkbox) => {
                                                checkbox.addEventListener('change', function() {
                                                    // submit the form that contains this checkbox
                                                    this.closest('form').submit();
                                                });
                                            });
                                        </script>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="w-100"></div>

                {{-- Delay --}}
                <div class="col-md-6">
                    <div class="dashboard-box">
                        <h5>Delayed/Exceeded Job Order Date</h5>
                        <div class="placeholder-box overflow-auto">
                            <table class="table table-borderless table-hover placeholder-table mb-0">
                                <thead>
                                    <tr>
                                        <th class="fw-semibold">Client</th>
                                        <th class="fw-semibold">Contact Number</th>
                                        <th class="fw-semibold">Status</th>
                                        <th class="col col-md-2 fw-semibold text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($joPending->isEmpty())
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No data available</td>
                                        </tr>
                                    @else
                                        @foreach ($joPending as $row)
                                            <tr>
                                                <td>{{ $row->client_fname }} {{ $row->client_lname }}</td>
                                                <td>{{ $row->client_contact_number }}</td>
                                                <td>{{ $row->jo_status }}</td>
                                                <td class="text-center col col-md-2">
                                                    <div class="d-inline-flex justify-content-center gap-2">
                                                        @if($row->jod_id)
                                                            @if($row->joToJod->jod_eq_stat == 'Pending')
                                                                <a href="{{ route('Job-Order.showDeploy', $row->id) }}"
                                                                    class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Deploy">
                                                                    <i class="bi bi-box-arrow-up"></i>
                                                                </a>
                                                            @endif
                                                            @if($row->joToJod->jod_eq_stat == 'Deployed')
                                                                <a href="{{ route('Job-Order.showReturn', $row->id) }}"
                                                                    class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Return">
                                                                    <i class="bi bi-box-arrow-in-down"></i>
                                                                </a>
                                                            @endif
                                                            @if($row->joToJod->jod_eq_stat == 'Returned')
                                                                <a href="{{ route('Job-Order.show', $row->id) }}"
                                                                    class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                                                    <i class="fi fi-rr-eye"></i>
                                                                </a>
                                                            @endif
                                                        @endif
                                                        @if($row->svc_id && !$row->jod_id)
                                                            @if($row->jo_status == 'Paid')
                                                                <a href="{{ route('Service-Request.show', $row->id) }}"
                                                                    class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                                                    <i class="fi fi-rr-eye"></i>
                                                                </a>
                                                            @else
                                                                <a href="{{ route('Service-Request.show', $row->id) }}"
                                                                    class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Review">
                                                                    <i class="bi bi-list-ul"></i>
                                                                </a>
                                                            @endif
                                                        
                                                        @endif
                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Overdue payments --}}
                <div class="col-md-6">
                    <div class="dashboard-box">
                        <h5>Overdue Payments</h5>
                        <div class="placeholder-box overflow-auto">
                            <table class="table table-borderless table-hover placeholder-table mb-0">
                                <thead>
                                    <tr>
                                        <th class="fw-semibold">Client</th>
                                        <th class="fw-semibold">Contact Number</th>
                                        <th class="col col-md-2 fw-semibold text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($joOverDue->isEmpty())
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">No data available</td>
                                        </tr>
                                    @else
                                        @foreach ($joOverDue as $row)
                                            <tr>
                                                <td>{{ $row->client_fname }} {{ $row->client_lname }}</td>
                                                <td>{{ $row->client_contact_number }}</td>
                                                <td class="text-center col col-md-2">
                                                    <div class="d-inline-flex justify-content-center gap-2">
                                                        @if($row->jod_id)
                                                            @if($row->joToJod->jod_eq_stat == 'Pending')
                                                                <a href="{{ route('Job-Order.showDeploy', $row->id) }}"
                                                                    class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Deploy">
                                                                    <i class="bi bi-box-arrow-up"></i>
                                                                </a>
                                                            @endif
                                                            @if($row->joToJod->jod_eq_stat == 'Deployed')
                                                                <a href="{{ route('Job-Order.showReturn', $row->id) }}"
                                                                    class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Return">
                                                                    <i class="bi bi-box-arrow-in-down"></i>
                                                                </a>
                                                            @endif
                                                            @if($row->joToJod->jod_eq_stat == 'Returned')
                                                                <a href="{{ route('Job-Order.show', $row->id) }}"
                                                                    class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                                                    <i class="fi fi-rr-eye"></i>
                                                                </a>
                                                            @endif
                                                        @endif
                                                        @if($row->svc_id && !$row->jod_id)
                                                            @if($row->jo_status == 'Paid')
                                                                <a href="{{ route('Service-Request.show', $row->id) }}"
                                                                    class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                                                    <i class="fi fi-rr-eye"></i>
                                                                </a>
                                                            @else
                                                                <a href="{{ route('Service-Request.show', $row->id) }}"
                                                                    class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Review">
                                                                    <i class="bi bi-list-ul"></i>
                                                                </a>
                                                            @endif
                                                        
                                                        @endif
                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="w-100"></div>

                <!-- Low Stock Items -->
                <div class="col-md-6">
                    <div class="dashboard-box">
                        <h5>Low Stock Items</h5>
                        <div class="placeholder-box overflow-auto">
                            <table class="table table-borderless table-hover placeholder-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Size</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($lowStockData->isEmpty())
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">No data available</td>
                                        </tr>
                                    @else
                                        @foreach ($lowStockData as $row)
                                            <tr>
                                                <td>{{ $row->item_name }}</td>
                                                <td>{{ $row->item_size }}</td>
                                                <td>{{ $row->item_qty }}</td>
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
                        <h5>Low Stock Equipment</h5>
                        <div class="placeholder-box overflow-auto">
                            <table class="table table-borderless table-hover placeholder-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Equipment Name</th>
                                        <th>Size</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($lowEqData->isEmpty())
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">No data available</td>
                                        </tr>
                                    @else
                                        @foreach ($lowEqData as $row)
                                            <tr>
                                                <td>{{ $row->eq_name }}</td>
                                                <td>{{ $row->eq_size }}</td>
                                                <td>{{ $row->eq_available + $row->eq_in_use }}</td>
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
