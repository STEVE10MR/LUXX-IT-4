<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('tittle')</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
     <!-- KJS QUERY -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">


</head>
<body>
    <div id="app">
        <div class="d-flex" id="wrapper">
            <!-- Sidebar -->
            <div class="bg-white" id="sidebar-wrapper">
                <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom"><i
                        class="fas fa-user-secret me-2"></i>ADMIN</div>
                <div class="list-group list-group-flush my-3">
                    <a href="{{route('order.panel')}}" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                            class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="{{route('statistics')}}" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                            class="fas fa-chart-line me-2"></i>Análisis</a>
                    <a href="{{route('firebase.create_map')}}" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                            class="fas fa-map me-2"></i>Mapa</a>
                    <a href="{{route('user.index')}}" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                            class="fas fa-shopping-cart me-2"></i>Gestion de Repartidores</a>
                    <a href="{{route('product.index')}}" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                            class="fas fa-gift me-2"></i>Productos</a>
                    <a href="{{route('categories.index')}}" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                            class="fas fa-cookie-bite me-2"></i>Categorias</a>
                    <a href="{{route('session.destroy')}}" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i
                            class="fas fa-power-off me-2"></i>Cerrar Sesion</a>
                </div>
            </div>
            <div id="page-content-wrapper">
                <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-align-left primary-text fs-4 me-3 form-text-logo" id="menu-toggle"></i>
                        <h2 class="fs-2 m-0 form-text-logo">Dashboard</h2>
                    </div>
                </nav>
                @yield('content')
            </div>
        </div>
        @if (session('success'))
            @include('modal_subject.success')
        @elseif (session('error'))
            @include('modal_subject.error')
        @endif
        <div class="overlay hidden"></div>
    </div>
    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");
        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };
    </script>
</body>
</html>
