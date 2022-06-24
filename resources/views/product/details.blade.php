@extends('layouts.user')

@section('tittle','menu')

@section('content')


<!-- Content -->
<div class="container container-web-page">
    <h3 class="font-weight-bold poppins-regular text-uppercase form-text-h1 form-style-text">Detalles de platillo</h3>
    <hr>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-5">
                <!--cover-->
                <figure class="full-box">
                    <img class="img-fluid" src="{{URL::asset("storage/$product->portada")}}" alt="platillo_">
                </figure>

            </div>
            <div class="col-12 col-lg-7">

                <h4 class="font-weight-bold poppins-regular tittle-details form-text-label">{{$product->name}}</h4>

                <p class="text-justify lead form-text-label" style="padding: 40px 0;">
                    <span class="lead font-weight-bold">Descripcion:</span><br>
                    {{$product->descripcion}}
                </p>

                <p class="lead font-weight-bold form-text-label">Precio: {{$product->price}}</p>

                <form method="POST" action="{{route('client.add_cart_detail')}}" style="padding-top: 70px;">
                    @csrf
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-outline mb-4 px-1">
                                    <input type="text" value="1" class="form-control text-center " id="product_cant" name="product_cant" maxlength="12" required>
                                    <label for="product_cant" class="form-label form-text-label">Cantidad</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 text-center">
                                <button type="submit" class="btn btn btn-outline-light btn-lg px-1"><i class="fas fa-shopping-bag fa-fw"></i> &nbsp; Agregar al carrito</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" value="{{$product->id}}" name="product_id" id="product_id">
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
