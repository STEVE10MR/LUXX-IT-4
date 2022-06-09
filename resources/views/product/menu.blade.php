@extends('layouts.user')

@section('tittle','menu')

@section('content')


<div class="container container-web-page">
    <h3 class="font-weight-bold poppins-regular text-uppercase form-text-h1">Menú de platillos</h3>
    <p class="text-justify form-text-label">Bienvenido al menú de platillos, acá encontrara todos los platillos disponibles en el restaurante. Puede ordenar los platillos por categoría en el botón "<i class="fas fa-hamburger fa-fw"></i> MENÚ" y también ordenarlos por orden alfabético o por precio en el botón "<i class="fas fa-sort-alpha-down fa-fw"></i> ORDENAR POR". Además, puede buscar platillos por nombre haciendo clic en el botón "<i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR"</p>

    <div class="container-fluid" style="border-top: 1px solid #E1E1E1; padding: 20px; 0">
        <div class="row align-items-center">
            <div class="col-12 col-sm-4 text-center text-sm-start">
                <div class="dropdown">
                    <button class="btn form-text-logo dropdown-toggle" type="button" id="categorySubMenu" data-mdb-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-hamburger fa-fw"></i> &nbsp; Menú
                    </button>
                    <div class="dropdown-menu" aria-labelledby="categorySubMenu">
                        <a class="dropdown-item" href="#">Menú 1</a>
                        <a class="dropdown-item" href="#">Menú 2</a>
                        <a class="dropdown-item" href="#">Menú 3</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-4 text-center">
                <button type="button" class="btn form-text-logo" data-mdb-toggle="modal" data-mdb-target="#saucerModal">
                    <i class="fas fa-search fa-fw"></i> &nbsp; Buscar
                </button>
            </div>
            <div class="col-12 col-sm-4 text-center text-sm-end">
                <div class="dropdown">
                    <button class="btn form-text-logo dropdown-toggle" type="button" id="OrderSubMenu" data-mdb-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-sort-alpha-down fa-fw"></i> &nbsp; Ordenar por
                    </button>
                    <div class="dropdown-menu" aria-labelledby="OrderSubMenu">
                        <a class="dropdown-item" href="#">Ascendente (A-Z)</a>
                        <a class="dropdown-item" href="#">Descendente (Z-A)</a>
                        <a class="dropdown-item" href="#">Precio (Menor a Mayor)</a>
                        <a class="dropdown-item" href="#">Precio (Mayor a Menor)</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid" style="padding: 20px 0;">
        <div class="row">
            <div class="col-12 col-md-8">
                <p class="text-left lead form-text-label"><i class="fas fa-search fa-fw"></i> &nbsp; Resultados de la búsqueda: <span class="font-weight-bold poppins-regular text-uppercase">Platillo</span></p>
            </div>
            <div class="col-12 col-md-4">
                <button type="button" class="btn btn-outline-light btn-lg px-1">
                    <i class="fas fa-times fa-fw"></i> &nbsp; Eliminar busqueda
                </button>
            </div>
        </div>
    </div>


    <div class="container-cards full-box" style="padding-bottom: 40px;">



        @forelse ($products as $product )
        <div class="card shadow-1-strong">

            <img class="card-img-top" src="{{URL::asset("storage/$product->portada")}}" style alt="nombre_platillo">
            <div class="card-body text-center">
                <h5 class="card-title font-weight-bold font-car">{{$product->name}}</h5>
                <p class="card-text lead"><span class="badge bg-secondary">S/.{{$product->price}}</span></p>
            </div>
            <div class="card-body text-center">
                <a href="{{route('client.add_cart',$product)}}" class="btn btn-outline-light btn-lg px-1"><i class="fas fa-shopping-bag fa-fw"></i> &nbsp; Agregar</a>
                <a href="{{route('product.show',$product)}}" class="btn btn-outline-light btn-lg px-1"><i class="fas fa-utensils fa-fw"></i> &nbsp; Detalles</a>
            </div>
        </div>
        @empty
        @endforelse
    </div>
    <div class="pagination">
        @if($products)
            {{!! $products->appends(request()->query())->links('pagination::bootstrap-4') !!}}
        @endif
    </div>
</div>

@endsection
