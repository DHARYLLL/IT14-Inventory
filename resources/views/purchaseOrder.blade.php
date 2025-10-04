<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Purchase Order</title>

    <link rel="stylesheet" href="{{ asset('CSS/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    
</head>
<body>
    
    <div class="d-flex">
        <aside class="sidebar d-flex flex-column">
            {{-- LOGO --}}
            <div class="logo">
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ asset('images/alar-logo.png') }}" alt="Alar Memorial Services Logo" style="max-width: 100%; height: auto;">
                </div>
            </div>

            {{-- Nav menu --}}
            <nav class="nave-menu flex-fill">
                <ul class="list-unstyled">
                    <li class="nav-list">
                        <a href="#" class="nav-link-custom">
                            <i class="bi bi-house-door"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-list">
                        <a href="#" class="nav-link-custom">
                            <i class="bi bi-house-door"></i>
                            <span>Inventory</span>
                        </a>
                    </li>

                    <li class="nav-list">
                        <a href="#" class="nav-link-custom">
                            <i class="bi bi-house-door"></i>
                            <span>Equipment</span>
                        </a>
                    </li>

                    <li class="nav-list">
                        <a href="#" class="nav-link-custom">
                            <i class="bi bi-house-door"></i>
                            <span>Supplier</span>
                        </a>
                    </li>

                    <li class="nav-list">
                        <a href="#" class="nav-link-custom">
                            <i class="bi bi-house-door"></i>
                            <span>Logs</span>
                        </a>
                    </li>

                    <li class="nav-list">
                        <a href="#" class="nav-link-custom active">
                            <i class="bi bi-house-door"></i>
                            <span>Purchase Order</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <div class="main-content d-flex flex-column">

            {{-- Header --}}
            <header class="header">
                <div class="d-flex align-items-center justify-content-between">

                    <div class="d-flex align-items-center gap-3">
                        <span><h1>Purchase Order</h1></span>
                        <div>
                            <div class="search-input position-relative" style="width: 400px">
                                <i class="bi bi-search search-icon"></i>
                                <input type="search" placeholder="Search" class="form-control">
                            </div>
                        </div>
                    </div>


                    <div class="d-flex align-items-center gap-3">
                        <button class="btn btn-link text-decoration-none d-flex align-tems-center text-dark gap-2">
                            <span>Staff</span>
                            <i class="bi bi-chevron-down"></i>
                        </button>

                        <button class="btn btn-link text-dark p-2">
                            <i class="bi bi-bell fs-5"></i>
                        </button>

                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; cursor: pointer;">
                            <span class="fw-semibold small">ST</span>
                        </div>
                    </div>

                </div>
            </header>

            <main class="flex-fill p-4">
                <div class="content-area">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h2 class="fw-semibold">Purchase Order</h2>

                        <button class="btn btn-custom d-flex align-items-center gap-2" type="button" data-bs-toggle="modal" data-bs-target="#NewPOModal">
                            <i class="bi bi-plus-lg"></i>
                            <span>New Purchase Order</span>
                        </button>
                    </div>

                    {{-- table --}}
                    <div class="bg-white rounded border overflow-hidden">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="table-light">
                                    <th class="fw-semibold">PO#</th>
                                    <th class="fw-semibold">Supplier</th>
                                    <th class="fw-semibold">Total Amount</th>
                                    <th class="fw-semibold">Submitted Date</th>
                                    <th class="fw-semibold">Apporved Date</th>
                                    <th class="fw-semibold">Delivered Date</th>
                                    <th class="fw-semibold">Status</th>
                                    <th class="fw-semibold">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <td>001</td>
                                <td>Supplier 1</td>
                                <td>10000</td>
                                <td>09/25/25</td>
                                <td>09/26/25</td>
                                <td>10/01/25</td>
                                <td>Delivered</td>
                                <td></td>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="NewPOModal" tabindex="-1" aria-labelledby="NewPOModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-custom">
        <div class="modal-content">

            {{-- Header --}}
            <div class="modal-header modal-header-custom">
                <h1 class="modal-title fs-5" id="exampleModalLabel">New Purchase Order</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body">

                <form action="">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="" class="form-label">
                                <i class="bi bi-receipt" style="color: #60BF4F"></i> PO Number
                            </label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="bi bi-calendar3" style="color: #60BF4F"></i> Date
                            </label>
                            <input type="date" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="" class="fomr-label">
                                <i class="bi bi-person" style="color: #60BF4F"></i> Supplier
                            </label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="" class="form-label">
                                 <i class="bi bi-geo-alt" style="color: #60BF4F"></i> Company Address
                            </label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="bi bi-telephone" style="color: #60BF4F"></i> Supplier Contact
                            </label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    
                    <div class="flex-fill">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="fw-semibold">Order Items</h3>
                            <button class="btn btn-add-item">
                                <i class="bi bi-plus-circle"></i> Add Item
                            </button>
                        </div>
                        <div class="d-flex align-items-center justify-content-between gap-3">
                            <label class="form-label">
                                <i class="bi bi-card-text" style="color: #60BF4F"></i> Item Description
                                <input type="text" class="form-control">
                            </label>
                            <label class="form-label">
                                <i class="bi bi-hash" style="color: #60BF4F"></i> Quantity
                                <input type="number" class="form-control">
                            </label>
                            <label class="form-label">
                                <i class="bi bi-currency-dollar" style="color: #60BF4F"></i> Unit Price
                                <input type="number" class="form-control">
                            </label>
                            <label class="form-label">
                                <i class="bi bi-calculator" style="color: #60BF4F"></i> Total Price per Line Item
                                <input type="number" class="form-control">
                            </label>
                        </div>
                </form>


                </div>

                
            </div>

            {{-- Footer --}}
            <div class="modal-footer d-flex justify-content-between align-items-center">
                <div>
                    <img src="{{ asset('images/alar-logo.png') }}" alt="Alar Memorial Services Logo" style="max-width: 100%; height: 3rem;">
                </div>

                <div>
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-create">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>