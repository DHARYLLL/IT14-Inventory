<!DOCTYPE html>
<html lang="en">
{{-- comment --}}

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<meta http-equiv="X-UA-Compatible" content="ie=edge">-->
    <title>@yield('title')</title>


    <!-- Custom JS -->
    <script defer src="{{ asset('JS/func.js') }}"></script>

    <!-- Flaticon uIcons -->
    <link rel="stylesheet"
        href="https://cdn-uicons.flaticon.com/3.0.0/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <link rel="stylesheet"
        href="https://cdn-uicons.flaticon.com/3.0.0/uicons-regular-straight/css/uicons-regular-straight.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('CSS/style.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/purchaseOrder.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/equipment.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/supplier.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/stockEdit.css') }}">

    <!-- Bootstrap CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

</head>

<body>
    <div class="d-flex vh-100">
        <aside class="sidebar d-flex flex-column h-100 overflow-auto">
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
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-list">
                        <a href="{{ route('Job-Order.index') }}"
                            class="nav-link-custom {{ request()->routeIs('Job-Order.*') || request()->routeIs('Service-Request.*') ? 'active' : '' }}">
                            <span>Job Order</span>
                        </a>
                    </li>

                    <li class="nav-list">
                        <a href="{{ route('SOA.index') }}"
                            class="nav-link-custom {{ request()->routeIs('SOA.*') ? 'active' : '' }}">
                            <span>SOA</span>
                        </a>
                    </li>

                    @if(session("empRole") == 'admin' || session("empRole") == 'sadmin')
                        <li class="nav-list">
                            <a href="{{ route('Purchase-Order.index') }}"
                                class="nav-link-custom {{ request()->routeIs('Purchase-Order.*') ? 'active' : '' }}">
                                <span>Purchase Order</span>
                            </a>
                        </li>

                        <li class="nav-list">
                            <a href="{{ route('Stock.index') }}"
                                class="nav-link-custom {{ request()->routeIs('Stock.*') ? 'active' : '' }}">
                                <span>Stock</span>
                            </a>
                        </li>

                        <li class="nav-list">
                            <a href="{{ route('Equipment.index') }}"
                                class="nav-link-custom {{ request()->routeIs('Equipment.*') ? 'active' : '' }}">
                                <span>Equipment</span>
                            </a>
                        </li>

                        <li class="nav-list">
                            <a href="{{ route('Package.index') }}"
                                class="nav-link-custom {{ request()->routeIs('Package.*') ? 'active' : '' }}">
                                <span>Package</span>
                            </a>
                        </li>

                    @endif

                    <li class="nav-list">
                        <a href="{{ route('Chapel.index') }}"
                            class="nav-link-custom {{ request()->routeIs('Chapel.*') ? 'active' : '' }}">
                            <span>Chapel</span>
                        </a>
                    </li>

                    <li class="nav-list">
                        <a href="{{ route('Personnel.index') }}"
                            class="nav-link-custom {{ request()->routeIs('Personnel.*') || request()->routeIs('Embalmer.*') || request()->routeIs('Vehicle.*') ? 'active' : '' }}">
                            <span>Personnel</span>
                        </a>
                    </li>

                    @if(session("empRole") == 'admin' || session("empRole") == 'sadmin')

                        <li class="nav-list">
                            <a href="{{ route('supplier.index') }}"
                                class="nav-link-custom {{ request()->routeIs('supplier.*') ? 'active' : '' }}">
                                <span>Supplier</span>
                            </a>
                        </li>

                        <li class="nav-list">
                            <a href="{{ route('Stock-Out.index') }}"
                                class="nav-link-custom {{ request()->routeIs('Stock-Out.*') ? 'active' : '' }}">
                                <span>Stock Out</span>
                            </a>
                        </li>
                    @endif

                    

                </ul>
            </nav>

        </aside>
        {{-- Main Content --}}
        <div class="main-content flex-fill d-flex flex-column h-100" style="width: 85%;">
            {{-- Header --}}
            <header class="header px-4 py-3 shadow-sm" style="height: 13%;">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <h1>@yield('head')</h1>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <div class="dropdown">
                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center dropdown-toggle"
                                id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                style="width: 36px; height: 36px; cursor: pointer;">
                                <span class="fw-semibold small">AM</span>
                            </div>

                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li class="px-3 py-2 text-muted small">
                                    Logged in as: {{session('empRole')}} {{--@yield('name')--}}
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    @if(session("empRole") == 'admin')
                                        <a href="{{ route('Employee.create') }}" class="dropdown-item"><i class="bi bi-plus-lg"></i> <span>Add Employee</span></a>
                                    @endif
                                    @if(session("empRole") == 'sadmin')
                                        <a href="{{ route('Employee.index') }}" class="dropdown-item"><i class="bi bi-person-fill-gear"></i> Employees</a>
                                    @else
                                        <form action="{{ route('Employee.edit', session("loginId")) }}" method="POST">
                                            @csrf
                                            @method('get')
                                            <button type="submit" class="dropdown-item">
                                                <i class="bi bi-person"></i> Profile
                                            </button>
                                        </form>
                                    @endif
                                    
                                </li>
                                <li>
                                    <a href="{{ route('Log.index') }}"   class="dropdown-item"><i class="bi bi-journal-text"></i> <span>Log</span></a>
                                </li>
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
                <div class="content-area bg-light p-2 rounded shadow-sm h-100 w-100">
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
