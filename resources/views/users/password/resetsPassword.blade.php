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
                    <h2 class="fw-bold mb-2 text-uppercase">Nueva contraseña</h2>
                        <br>
                    <form method="POST" action="{{ route('session.update_password')}}" >
                        @csrf
                        <input type="hidden" name="token_pass" id="token_pass" value="{{$token_password}}">
                            <br>
                            @if (session('error'))
                                <div class="error general" role="alert">
                                    {{ __(session('error')) }}
                                </div>
                            @endif

                            <br>

                            <div class="form-outline mb-4 form-text-h3">
                                <input type="password" class="form-control" name="password" id="password" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
                                <label for="password" class="form-label">Contraseña <i class="fab fa-font-awesome-alt"></i></label>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="form-outline mb-4 form-text-h3">
                                <input type="password" class="form-control" name="password_r" id="password_r" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
                                <label for="password_r" class="form-label">Repetir contraseña <i class="fab fa-font-awesome-alt"></i></label>
                                @error('password_r')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="{{route('Inicio')}}">Regresar al menu?</a></p>

                        <button class="btn btn-outline-light btn-lg px-5" type="submit">Confirmar</button>
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
