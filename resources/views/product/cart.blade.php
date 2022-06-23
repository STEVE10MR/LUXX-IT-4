
@extends('layouts.user')

@section('tittle','menu')

@section('content')


<section class="h-100 h-custom">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12">
          <div class="card card-registration card-registration-2" style="border-radius: 15px;">
            <div class="card-body p-0">
              <div class="row g-0">
                <div class="col-lg-8">
                  <div class="p-5">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                      <h1 class="fw-bold mb-0 text-black">Carrito de Compras</h1>
                    </div>

                    @forelse ($cart as $value)
                        <hr class="my-4">
                        <div class="row mb-4 d-flex justify-content-between align-items-center">
                        <div class="col-md-2 col-lg-2 col-xl-2">
                            <img
                            src="{{URL::asset("storage/$value->portada")}}"
                            class="img-fluid rounded-3">
                        </div>
                        <div class="col-md-3 col-lg-3 col-xl-3">
                            <h6 class="text-muted">{{$value->producto}}</h6>
                        </div>
                        <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                            <h6 class="mb-0">{{$value->quantity}}</h6>
                        </div>
                        <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                            <h6 class="mb-0">S/. {{$value->price}}</h6>
                        </div>
                        <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                            <form action="{{route('client.cart_destroy',$value->id)}}" method="POST">
                                @csrf @method('DELETE')
                                <button>X</button>
                            </form>
                        </div>
                        </div>
                    @empty

                    @endforelse
                    <hr class="my-4">
                    <div class="pt-5">
                      <h6 class="mb-0"><a href="{{route('products.create_menu')}}" class="text-body"><i
                            class="fas fa-long-arrow-alt-left me-2"></i>Regresar al Menu</a></h6>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 bg-grey">
                  <div class="p-5">
                    <h3 class="fw-bold mb-5 mt-2 pt-1">Resumen</h3>
                    <hr class="my-4">

                    <div class="d-flex justify-content-between mb-4">
                      <h5 class="text-uppercase">SubTotal</h5>
                      <h5>S/. {{$subtotal}}</h5>
                    </div>
                    <hr class="my-4">
                    <div class="d-flex justify-content-between mb-4">
                        <h5 class="text-uppercase">Impuesto</h5>
                        <h5>S/. {{$impuesto}}</h5>
                    </div>
                    <hr class="my-4">

                    <div class="d-flex justify-content-between mb-5">
                      <h5 class="text-uppercase">Total</h5>
                      <h5>S/. {{$total}}</h5>
                    </div>
                    <form action="{{route('client.generate_order')}}" method="post">
                        @csrf
                        <input type="hidden" value="{{$cart}}" name="products">
                        <input type="hidden" value="{{$user_id}}" name="user_id">
                        <input type="hidden" value="{{$total}}" name="total">
                        <button class="btn btn-dark btn-block btn-lg procButton" id="procButton" data-mdb-ripple-color="dark" disabled>Pagar</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
<script>
    const countCar=parseInt(document.querySelector('.countcart').textContent);
    const elementCart=document.getElementById('procButton');

    if(countCar>0)
    {
        elementCart.disabled=false;
    }
    else
    {
        elementCart.disabled=true;
    }

</script>
@endsection
