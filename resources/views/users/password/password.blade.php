<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Recuperar contraseña</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

</head>
<body class="password_reset">
    <div id="app">
        <div class="modalx container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                <div class="card-body p-5 text-center">

                    <div class="mb-md-5 mt-md-4 pb-5 form_repeat_l">
                    <h2 class="fw-bold mb-2 text-uppercase">Recuperar contraseña</h2>
                        <br>
                    <form method="POST" action="{{ route('session.recovery_verification')}}" >
                        @csrf

                        <div class="form-outline form-white mb-4">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="example@gmail.com" required/>
                            @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                            <br>
                    
                        </div>

                        <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="{{route('Inicio')}}">Regresar al menu?</a></p>

                        <button class="btn btn-outline-light btn-lg px-5" type="submit">Recuperar</button>
                    </form>

                </div>
                </div>
            </div>
            </div>
        </div>
        @if (session('success'))
            @include('modal_subject.success')
        @elseif (session('error'))
            @include('modal_subject.error')
        @endif
        <div class="overlay hidden"></div>
    </div>
</body>
</html>
