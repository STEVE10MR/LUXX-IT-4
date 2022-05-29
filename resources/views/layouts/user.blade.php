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

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">


</head>
<body>
    <div id="app">

        <div class="collapse show" id="navbarToggleExternalContent" >
            <div class="bg-logo p-4" style="background-image: url('img/banner_01.png');">
                <a class="navbar-brand" href="#">
                    <img
                    src="img/logo.png"
                    height="90"
                    alt="Portrait of a Woman"
                    loading="lazy"
                    />
                </a>

                <div class="nav justify-content-between">
                    <ul class="nav justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link active color text_link" aria-current="page" href="#">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link color text_link" href="#">Menu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link color text_link" href="#">Galeria</a>
                        </li>
                    </ul>

                    <ul class="nav flex-row mov">

                        @guest
                            <li class="nav-item">
                                <a class="nav-link color text_link btn--show-modal" data-mdb-toggle="modalx" data-mdb-target="#modalx" role="button">{{ __('Hola, Identificate') }}</a>
                            </li>
                        @endguest

                        <li class="nav-item">
                            <a class="nav-link" href="#">
                            <span class="badge badge-pill bg-danger">2</span>
                            <span><i class="fas fa-shopping-cart color"></i></span>
                            </a>
                        </li>

                        @if(Auth::check())

                            <li class="nav-item dropdown">
                                <a
                                id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre
                                >
                                <img
                                    src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img (31).webp"
                                    class="rounded-circle"
                                    height="22"
                                    alt="Portrait of a Woman"
                                    loading="lazy"
                                />
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                    <a class="dropdown-item" href="#">{{ __('Mi perfil') }}</a>
                                    <a class="dropdown-item" href="#">{{ __('Configuracion') }}</a>
                                    <a class="dropdown-item" href="{{route('session.destroy')}}">{{ __('Cerrar Sesion') }}</a>

                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-dark bg-dark">
            <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <ul class="list-unstyled" >
                            <li><h5 class="font-weight-bold" ><i class="far fa-copyright"></i> NutriFit</h5></li>
                            <li> Todos los derechos reservados </li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-4">
                        <ul class="list-unstyled" >
                            <li><h5 class="font-weight-bold" >Tacna</h5></li>
                            <li><i class="fas fa-map-marker-alt fa-fw"></i> Francisco Paula Vigil 1126, Tacna 23001</li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-4">
                        <ul class="list-unstyled" >
                            <li><h5 class="font-weight-bold" >Siguenos en:</h5> </li>
                            <li>
                                <a href="#" class="footer-link" target="_blank" >
                                    <i class="fab fa-facebook fa-fw"></i> Facebook
                                </a>
                            </li>

                            <li>
                                <a href="#" class="footer-link" target="_blank" >
                                    <i class="fab fa-youtube fa-fw"></i>
                                        Youtube
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>



        <div class="modalx container py-5 h-100 hidden" id="modalx">
            <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                <div class="card-body p-5 text-center">

                    <div class="mb-md-5 mt-md-4 pb-5 form_repeat_l">
                    <button class="btn--close-modal">&times;</button>
                    <h2 class="fw-bold mb-2 text-uppercase">Iniciar Sesion</h2>
                        <br>
                    <form method="POST" action="{{ route('session.store')}}" >
                        @csrf

                        <div class="form-outline form-white mb-4">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control form-control-lg" required/>
                            @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-outline form-white mb-4">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control form-control-lg" required/>
                            @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="#!">Recuperar Contraseña?</a></p>

                        <button class="btn btn-outline-light btn-lg px-5" type="submit">Ingresar</button>
                    </form>

                    <div class="d-flex justify-content-center text-center mt-4 pt-1">
                        <a href="#!" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
                        <a href="#!" class="text-white"><i class="fab fa-twitter fa-lg mx-4 px-2"></i></a>
                        <a href="#!" class="text-white"><i class="fab fa-google fa-lg"></i></a>
                    </div>

                    </div>

                    <div>
                    <p class="mb-0">{{ __('¿No tienes una cuenta?') }}<a class="text-white-50 fw-bold btn--show-modal-register" href="{{route('register.create')}}">{{ __('Registrate') }}</a></p>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        <div class="overlay hidden"></div>
    </div>
</body>
</html>
