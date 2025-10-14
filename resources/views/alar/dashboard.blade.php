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
                    <span class="count">{{ $getAv }}</span>
                </div>
            </div>
        </div>

        <!-- Lower Section (2 Boxes) -->
        <div class="bottom-section">
            <div class="row g-3">

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
                                                <td>{{ $row->action }}</td>
                                                <td>{{ $row->action_date }}</td>
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
                                        <th>Size/Weight</th>
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
                                                <td>{{ $row->item_qty }}</td>
                                                <td>{{ $row->size_weight }}</td>
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
