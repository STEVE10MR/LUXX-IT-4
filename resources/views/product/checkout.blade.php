
@extends('layouts.user')

@section('tittle','Ckeckout')

@section('content')
<section class="h-100 h-custom">
    <div class="container checkout">
        <div class="py-5 text-center">
            <h2 class="fw-bold">Checkout</h2>
        </div>
        <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="fw-bold">Resumen</h3>
                </h4>
                <hr>
                <ul class="list-group mb-3 sticky-top">
                    @foreach ($products as $product)
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">{{$product['producto']}}</h6>
                            </div>
                            <span class="text-muted">{{$product['price']}}</span>
                        </li>
                    @endforeach


                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total (PEN)</span>
                        <strong>S/. {{$total}}</strong>
                    </li>
                </ul>
            </div>
            <div class="col-md-8 order-md-1">
                <div class="row">
                    <div class="col-lg-6 offset-top-35 text-left" id="telef">
                        <label><b>Direccion</b></label>
                        <hr>
                        <select id="direccion" name="direccion" class="form-select col-lg-8" required>
                            <option selected disabled>Elija una Direccion</option>
                            @forelse ($address as $data)
                                <option value="{{$data->id}}">{{$data->reference}}</option>
                            @empty
                                <option selected disabled>Agrege una Direccion</option>
                            @endforelse

                        </select>
                    </div>
                    <div class="col-lg-6 offset-top-35 text-right">
                        <div class="h4 font-default text-bold">
                            <br>
                            <button class="btn btn-dark btn-block btn-lg" id="buyButton" data-mdb-ripple-color="dark" disabled>Procesar con tarjeta</button>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
    <script>

        const direccion=document.getElementById('direccion');
        const buttonCheckout=document.getElementById('buyButton');

        direccion.addEventListener('change',function(e)
        {
            if(this.value)
            {
                $('#buyButton').attr("disabled", false);
            }
            else
            {
                $('#buyButton').attr("disabled", true);
            }
        })
        Culqi.publicKey = 'pk_test_25E7HHJpVTXS26cr';
        Culqi.settings({
            title: 'Tienda en Linea - NutriFit',
            description: 'Pago - NutriFit',
            currency: 'PEN',
            amount: '<?php echo round(floatval($total))?>',
        });
        buttonCheckout.addEventListener('click',function(e)
        {
            e.preventDefault();
            Culqi.open();
        })
        function culqi() {
            if (Culqi.token) {
                let token = Culqi.token.id;
                let products = '<?= json_encode($products,false) ?>';
                let transanccion  = token;
                let user_id  = '<?= $user_id ?>';
                let total = '<?= floatval($total) ?>';
                let address_id = direccion.value;
                return window.location="../cart/checkout/"+products+"/"+user_id+"/"+total+"/"+token+"/"+address_id+'/culqi';
            }
            else {
                console.log(Culqi.error);
                alert(Culqi.error.user_message);
            }
        };

    </script>
@endpush
@endsection




