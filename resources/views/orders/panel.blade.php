@extends('layouts.admin')
@section('tittle','Dashboard')

@section('content')

<div class="container-fluid px-4">
    <div class="row g-3 my-2">
        <div class="col-md-3">
            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                <div>
                    <h3 class="fs-2">{{$countProduct}}</h3>
                    <p class="fs-5">Productos</p>
                </div>
                <i class="fas fa-gift fs-1 primary-text secondary-bg p-3 image-control"></i>
            </div>
        </div>

        <div class="col-md-3">
            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                <div>
                    <h3 class="fs-2">S/.{{$sales}}</h3>
                    <p class="fs-5">Sales</p>
                </div>
                <i
                    class="fas fa-hand-holding-usd fs-1 primary-text secondary-bg p-3 image-control"></i>
            </div>
        </div>

        <div class="col-md-3">
            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                <div>
                    <h3 class="fs-2">{{$countDelivery}}</h3>
                    <p class="fs-5">Delivery</p>
                </div>
                <i class="fas fa-truck fs-1 primary-text secondary-bg p-3 image-control"></i>
            </div>
        </div>

        <div class="col-md-3">
            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                <div>
                    <h3 class="fs-2">%{{$increment}}</h3>
                    <p class="fs-5">Increase</p>
                </div>
                <i class="fas fa-chart-line fs-1 primary-text secondary-bg p-3 image-control"></i>
            </div>
        </div>
    </div>

    <div class="row my-5">
        <div class="col">
            <table class="table bg-white rounded shadow-sm  table-hover">
                <thead>
                    <tr>
                        <th scope="col" width="50">#</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Delivery</th>
                        <th scope="col">Precio</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <th scope="row">#</th>
                            <td>
                                @forelse($resumeProducts[$order->id] as $data)
                                <p>{{$data['name']}}</p>
                                @empty
                                    {{'Sin productos'}}
                                @endforelse
                            </td>
                            <td>{{$order->name}}</td>
                            <td>S/.{{$order->amount}}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection




