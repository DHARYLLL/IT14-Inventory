    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title') | ALAR Memorial Services</title>

        <!-- Core Styles & Libraries -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
        <link rel="stylesheet"
            href="https://cdn-uicons.flaticon.com/3.0.0/uicons-regular-rounded/css/uicons-regular-rounded.css">

        <!-- Custom Styles -->
        <link rel="stylesheet" href="{{ asset('CSS/layout.css') }}">
        <link rel="stylesheet" href="{{ asset('CSS/dashboard.css') }}">
        <link rel="stylesheet" href="{{ asset('CSS/purchaseOrder.css') }}">
        <link rel="stylesheet" href="{{ asset('CSS/stocks.css') }}">
        <link rel="stylesheet" href="{{ asset('CSS/equipment.css') }}">
        <link rel="stylesheet" href="{{ asset('css/equipmentAdd.css') }}">
        <link rel="stylesheet" href="{{ asset('css/supplier.css') }}">




        <script defer src="{{ asset('JS/func.js') }}"></script>
    </head>

    <body>
        <div class="layout-wrapper d-flex">
            {{-- SIDEBAR --}}
            <aside class="sidebar d-flex flex-column">
                <div class="sidebar-header text-center py-4 mb-4 border-bottom">
                    <img src="{{ asset('images/alar-logo.png') }}" alt="Alar Memorial Services Logo"
                        style="width: 200px; height: auto;">
                </div>

                <nav class="nav-menu flex-fill px-3">
                    <ul class="list-unstyled m-0">
                        <li>
                            <a href="{{ route('dashboard.index') }}"
                                class="nav-link-custom {{ request()->routeIs('dashboard.*') ? 'active' : '' }}">
                                <i class="bi bi-house-door"></i><span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('Stock.index') }}"
                                class="nav-link-custom {{ request()->routeIs('Stock.*') ? 'active' : '' }}">
                                <i class="bi bi-box-seam"></i><span>Stocks</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('Equipment.index') }}"
                                class="nav-link-custom {{ request()->routeIs('Equipment.*') ? 'active' : '' }}">
                                <i class="bi bi-gear"></i><span>Equipment</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('Package.index') }}"
                                class="nav-link-custom {{ request()->routeIs('Package.*') ? 'active' : '' }}">
                                <i class="bi bi-box2-heart"></i><span>Package</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('supplier.index') }}"
                                class="nav-link-custom {{ request()->routeIs('supplier.*') ? 'active' : '' }}">
                                <i class="bi bi-truck"></i><span>Supplier</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('Purchase-Order.index') }}"
                                class="nav-link-custom {{ request()->routeIs('Purchase-Order.*') ? 'active' : '' }}">
                                <i class="bi bi-receipt"></i><span>Purchase Order</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('Service-Request.index') }}"
                                class="nav-link-custom {{ request()->routeIs('Service-Request.*') ? 'active' : '' }}">
                                <i class="bi bi-envelope-paper"></i><span>Service Request</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('Log.index') }}"
                                class="nav-link-custom {{ request()->routeIs('Log.*') ? 'active' : '' }}">
                                <i class="bi bi-journal-text"></i><span>Log</span>
                            </a>

                        </li>
                    </ul>
                </nav>
            </aside>

            {{-- MAIN CONTENT --}}
            <div class="main-content flex-fill d-flex flex-column">
                {{-- HEADER --}}
                <header class="main-header d-flex align-items-center justify-content-between px-4 py-3 shadow-sm">
                    <div class="page-label">
                        <span class="label-accent"></span>
                        <h3>@yield('head')</h3>
                    </div>

                    <div class="dropdown">
                        <div class="profile-circle dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <span class="fw-semibold small">A</span>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li class="px-3 py-2 text-muted small">Logged in as: @yield('name')</li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </header>

                {{-- CONTENT --}}
                <main class="p-2 flex-fill">
                    <div class="content-container bg-light p-2 rounded shadow-sm">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
