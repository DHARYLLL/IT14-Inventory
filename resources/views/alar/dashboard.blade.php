@extends('layouts.layout')

@section('title', 'Dashboard')
@section('head', 'Dashboard')
@section('name', 'Staff')

@section('content')
    <div class="dashboard-container">

        <!-- Search and Summary Section -->
        <div class="dashboard-header d-flex align-items-center justify-content-between mb-4">
            <div class="search-bar">
                <input type="text" placeholder="Search" class="form-control shadow-sm">
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="summary-cards d-flex flex-wrap gap-3 mb-4">
            <div class="summary-card total-items flex-fill">
                <h5>Total Items</h5>
                <div class="card-content">
                    <i class="bi bi-box-seam"></i>
                    <span class="count">—</span>
                </div>
            </div>

            <div class="summary-card low-stock flex-fill">
                <h5>Low Stock</h5>
                <div class="card-content">
                    <i class="bi bi-exclamation-triangle"></i>
                    <span class="count">—</span>
                </div>
            </div>

            <div class="summary-card out-of-stock flex-fill">
                <h5>Out of Stock</h5>
                <div class="card-content">
                    <i class="bi bi-x-circle"></i>
                    <span class="count">—</span>
                </div>
            </div>
        </div>

        <!-- Lower Section (3 Boxes) -->
        <div class="bottom-section">
            <div class="row g-3">

                <!-- Recent Activity -->
                <div class="col-md-6">
                    <div class="dashboard-box">
                        <h5>Recent Activity</h5>
                        <div class="placeholder-box">
                            <!-- Content to be added later -->
                        </div>
                    </div>
                </div>

                <!-- Low Stock Items -->
                <div class="col-md-6">
                    <div class="dashboard-box">
                        <h5>Low Stock Items</h5>
                        <table class="table table-borderless table-hover placeholder-table">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                    <th>Size/Weight</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No data available</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Purchase Order Summary -->
                {{-- <div class="col-md-12">
                    <div class="dashboard-box">
                        <h5>Purchase Order Summary</h5>
                        <table class="table table-borderless table-hover placeholder-table">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2" class="text-center text-muted">No data available</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div> --}}

            </div>
        </div>

    </div>
@endsection
