@extends('layouts.user')

@section('tittle','home')

@section('content')

<hr class="form-text-logo">

<div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">

    @forelse ($galeria as $value)
        <div class="carousel-inner">
            <div class="carousel-item active">
            <img src="{{URL::asset("storage/$value->foto")}}" class="d-block w-100 carousel-image banner-image-font" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <div class="banner">
                    <div class="banner-body">
                        <h3 class="text-uppercase text-night">Bienvenidos</h3>
                        <p class="text-night">{{$value->resena}}</p>
                        <a href="{{route('products.create_menu')}}" class="btn btn-warning"><i class="fas fa-hamburger fa-fw"></i> &nbsp; Ir al menu</a>
                    </div>
              </div>
            </div>
      </div>
    @empty
        <span class="invalid-feedback" role="alert">
            <strong>{{ "No existe ninguna imagen" }}</strong>
        </span>
    @endforelse


    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
</div>
<hr class="form-text-logo">
<div class="container container-web-page">
    <h3 class="text-center text-uppercase poppins-regular font-weight-bold form-text-logo">Nuestros servicios</h3>
    <br>
    <div class="row">
        <div class="col-12 col-sm-6 col-md-4">
            <p class="text-center"><i class="fas fa-shipping-fast fa-5x form-text-logo"></i></p>
            <h5 class="text-center text-uppercase poppins-regular font-weight-bold form-text-logo">Envíos a domicilio</h5>
            <p class="text-center form-text-logo">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ratione ad possimus modi repellendus? Expedita, vitae rerum at aliquam eligendi soluta veniam ut dolor facere fugiat quod, maxime ad accusamus quisquam.</p>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <p class="text-center"><i class="fas fa-utensils fa-5x form-text-logo"></i></p>
            <h5 class="text-center text-uppercase poppins-regular font-weight-bold form-text-logo">Ventas al por mayor</h5>
            <p class="text-center form-text-logo">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ratione ad possimus modi repellendus? Expedita, vitae rerum at aliquam eligendi soluta veniam ut dolor facere fugiat quod, maxime ad accusamus quisquam.</p>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <p class="text-center"><i class="fas fa-store-alt fa-5x form-text-logo"></i></p>
            <h5 class="text-center text-uppercase poppins-regular font-weight-bold form-text-logo">Reservaciones de local</h5>
            <p class="text-center form-text-logo">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ratione ad possimus modi repellendus? Expedita, vitae rerum at aliquam eligendi soluta veniam ut dolor facere fugiat quod, maxime ad accusamus quisquam.</p>
        </div>
    </div>
</div>
<hr class="form-text-logo">

@endsection
