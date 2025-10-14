<!DOCTYPE html>
<html lang="en">
{{-- comment --}}

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <script defer src="{{ asset('JS/func.js') }}"></script>

    <!-- Flaticon uIcons -->
    <link rel="stylesheet"
        href="https://cdn-uicons.flaticon.com/3.0.0/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <link rel="stylesheet"
        href="https://cdn-uicons.flaticon.com/3.0.0/uicons-regular-straight/css/uicons-regular-straight.css">

    <link rel="stylesheet" href="{{ asset('CSS/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('CSS/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/purchaseOrder.css') }}">
    
    <link rel="stylesheet" href="{{ asset('CSS/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/equipment.css') }}">
    <link rel="stylesheet" href="{{ asset('css/supplier.css') }}">
    <link rel="stylesheet" href="{{ asset('css/stockEdit.css') }}">
    





</head>

<body>
    <div class="d-flex vh-100">
        <aside class="sidebar d-flex flex-column h-100">
            {{-- LOGO --}}
            <div class="logo mb-4">
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ asset('images/alar-logo.png') }}" alt="Alar Memorial Services Logo"
                        style="max-width: 100%; height: auto;">
                </div>
            </div>

            {{-- Nav menu --}}
            <nav class="nave-menu flex-fill">
                <ul class="list-unstyled">
                    <li class="nav-list">
                        <a href="{{ route('dashboard.index') }}"
                            class="nav-link-custom {{ request()->routeIs('dashboard.*') ? 'active' : '' }}">
                            <i class="bi bi-house-door"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-list">
                        <a href="{{ route('Stock.index') }}"
                            class="nav-link-custom {{ request()->routeIs('Stock.*') ? 'active' : '' }}">
                            <i class="bi bi-box-seam"></i>
                            <span>Stock</span>
                        </a>
                    </li>

                    <li class="nav-list">
                        <a href="{{ route('Equipment.index') }}"
                            class="nav-link-custom {{ request()->routeIs('Equipment.*') ? 'active' : '' }}">
                            <i class="bi bi-gear"></i>
                            <span>Equipment</span>
                        </a>
                    </li>

                    <li class="nav-list">
                        <a href="{{ route('Package.index') }}"
                            class="nav-link-custom {{ request()->routeIs('Package.*') ? 'active' : '' }}">
                            <i class="bi bi-receipt"></i>
                            <span>Package</span>
                        </a>
                    </li>

                    <li class="nav-list">
                        <a href="{{ route('supplier.index') }}"
                            class="nav-link-custom {{ request()->routeIs('supplier.*') ? 'active' : '' }}">
                            <i class="bi bi-truck"></i>
                            <span>Supplier</span>
                        </a>
                    </li>

                    <li class="nav-list">
                        <a href="{{ route('Purchase-Order.index') }}"
                            class="nav-link-custom {{ request()->routeIs('Purchase-Order.*') ? 'active' : '' }}">
                            <i class="bi bi-receipt"></i>
                            <span>Purchase Order</span>
                        </a>
                    </li>

                    <li class="nav-list">
                        <a href="{{ route('Service-Request.index') }}"
                            class="nav-link-custom {{ request()->routeIs('Service-Request.*') ? 'active' : '' }}">
                            <i class="bi bi-receipt"></i>
                            <span>Service Requests</span>
                        </a>
                    </li>

                    <li class="nav-list">
                        <a href="{{ route('Log.index') }}"
                            class="nav-link-custom {{ request()->routeIs('Log.*') ? 'active' : '' }}">
                            <i class="bi bi-journal-text"></i>
                            <span>Log</span>
                        </a>
                    </li>
                </ul>
            </nav>

            {{-- Logout Button
            <div class="mt-auto p-3 border-top">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div> --}}
        </aside>
        {{-- Main Content --}}
        <div class="main-content flex-fill d-flex flex-column h-100">
            {{-- Header --}}
            <header class="header px-4 py-3 shadow-sm" style="height: 13%;">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <h1>@yield('head')</h1>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        {{--
                        <button class="btn btn-link text-decoration-none d-flex align-items-center text-dark gap-2">
                            <div>@yield('name')</div>
                            <i class="bi bi-chevron-down"></i>
                        </button>

                        <button class="btn btn-link text-dark p-2">
                            <i class="bi bi-bell fs-5"></i>
                        </button>
                        --}}
                        <div class="dropdown">
                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center dropdown-toggle"
                                id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                style="width: 36px; height: 36px; cursor: pointer;">
                                <span class="fw-semibold small">ST</span>
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
                                            <i class="bi bi-box-arrow-right"></i>
                                            Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </header>
            {{-- Content --}}
            <main class="flex-fill p-4 overflow-auto" style="height: 87%;">
                <div class="content-area bg-light p-2 rounded shadow-sm">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

@if (session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        });
    </script>
@endif

</html>
