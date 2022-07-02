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
                      <h1 class="fw-bold mb-0 text-black">Pedidos</h1>
                    </div>
                    <table class="table bg-white rounded shadow-sm  table-hover">
                        <thead>
                            <tr>
                                <th scope="col" width="10">#</th>
                                <th scope="col">Productos</th>
                                <th scope="col">Direccion</th>
                                <th scope="col">Monto</th>
                                <th scope="col">Tipo de pago</th>
                                <th scope="col">Pedido Creado</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody class="link-master deactivate-modal">
                            @if($orders)
                                @foreach ($orders as $value)
                                        <tr>

                                            <th scope="row">{{'#'}}</th>
                                            <td>
                                                @forelse($resumeProducts[$value->id] as $data)
                                                    <p>- {{$data['name']}}</p>
                                                @empty
                                                    <p>{{'Sin productos'}}</p>
                                                @endforelse
                                            </td>
                                            <td>{{$value->reference}}</td>
                                            <td>{{$value->amount}}</td>
                                            <td>{{$value->pay_type}}</td>
                                            <td>{{$value->created_at->diffForHumans()}}</td>
                                            <td>
                                                <form action="{{route('firebase.create')}}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="address_id" value="{{$value->address_id}}">
                                                    <input type="hidden" name="order_id" value="{{$value->id}}">
                                                    <button class="btn btn-dark btn-block btn-lg button_map" data-id="{{$value->id}}" id="button_map" data-mdb-ripple-color="dark"><i class="font_awesome fa-solid fa-play color_green"></i></button>
                                                </form>
                                            </td>

                                        </tr>
                                @endforeach
                            @endif
                        </tbody>
                        </tbody>
                    </table>
                    <hr class="my-4">
                    <div class="pt-5">
                      <h6 class="mb-0"><a href="{{route('products.create_menu')}}" class="text-body"><i
                            class="fas fa-long-arrow-alt-left me-2"></i>Regresar al Menu</a></h6>
                    </div>
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
    'use strict';
    const buttonMaps=document.querySelectorAll('.button_map');
    const orderPending=parseInt('<?= intval($orderPending) ?>');
    if(orderPending){
        buttonMaps.forEach(function(element)
        {
            const orderId=parseInt(element.dataset.id);
            if(orderPending === orderId) return;

            element.disabled=true;
            element.children[0].classList.add('color');
            element.children[0].classList.remove('color_green');
        });
    }

</script>
@endsection
