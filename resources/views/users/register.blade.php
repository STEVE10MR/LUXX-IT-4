@extends('layouts.user')
@section('title','Registro')
@section('content')

<div class="container container-web-page">
    <h3 class="font-weight-bold poppins-regular text-uppercase form-text-h1">Crear cuenta</h3>
    <p class="text-justify form-text-label">Al crear una cuenta en nuestro sitio web usted acepta nuestros <a href="#">términos y condiciones</a>. La información introducida en el formulario debe de ser clara, precisa y legitima. Para crear una cuenta debe de llenar todos los campos que son obligatorios marcados con el icono <i class="fab fa-font-awesome-alt"></i></p>
    <hr>
    <div class="row">
        <div class="col-12">
            <form class="div-bordered" method="POST" action="{{route('register.store_client')}}" style="padding: 15px;">
                @csrf
                <fieldset>
                    <legend class="form-text-h2"><i class="far fa-address-card form-text-logo"></i> &nbsp; Información personal</legend>
                    <div class="container-fluid">
                        <div class="row">

                            <div class="col-12 col-md-4">
                                <div class="form-outline mb-4 form-text-h3">
                                    <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}" class="form-control " name="nombres" id="nombres" maxlength="35">
                                    <label for="nombres" class="form-label">Nombres <i class="fab fa-font-awesome-alt"></i></label>
                                    @error('nombres')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="form-outline mb-4 form-text-h3">
                                    <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}" class="form-control" name="apellidos" id="apellidos" maxlength="35">
                                    <label for="apellidos" class="form-label">Apellidos <i class="fab fa-font-awesome-alt"></i></label>
                                    @error('apellidos')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="form-outline mb-4 form-text-h3" >
                                    <input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="numero" id="numero" maxlength="20">
                                    <label for="numero" class="form-label">Teléfono <i class="fab fa-font-awesome-alt"></i></label>
                                    @error('numero')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <br><br>

                <fieldset>
                    <legend class="form-text-h2"><i class="fas fa-user-lock"></i> &nbsp; Información de inicio de sesión</legend>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="form-outline mb-4 form-text-h3">
                                    <input type="email" class="form-control" name="email" id="email" maxlength="47">
                                    <label for="email" class="form-label">Email <i class="fab fa-font-awesome-alt"></i></label>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-outline mb-4 form-text-h3">
                                    <input type="password" class="form-control" name="password" id="password" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
                                    <label for="password" class="form-label">Contraseña <i class="fab fa-font-awesome-alt"></i></label>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-outline mb-4 form-text-h3">
                                    <input type="password" class="form-control" name="password_r" id="password_r" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
                                    <label for="password_r" class="form-label">Repetir contraseña <i class="fab fa-font-awesome-alt"></i></label>
                                    @error('password_r')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <p class="text-center" style="margin-top: 40px;">
                    <button class="btn btn-outline-light btn-lg px-5" type="submit"><i class="far fa-paper-plane"></i> &nbsp; CREAR CUENTA</button>
                </p>


                <p class="text-center">
                    <small>Los campos marcados con <i class="fab fa-font-awesome-alt"></i> son obligatorios</small>
                </p>
            </form>
        </div>
    </div>
</div>

@endsection
