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
    </div>



    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>