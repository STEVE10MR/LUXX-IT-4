@extends('layouts.user')

@section('tittle','menu')

@section('content')


<div class="container container-web-page">
    <h3 class="font-weight-bold poppins-regular text-uppercase form-text-h1">Menú de platillos</h3>
    <p class="text-justify form-text-label">Bienvenido al menú de platillos, acá encontrara todos los platillos disponibles en el restaurante. Puede ordenar los platillos por categoría en el botón "<i class="fas fa-hamburger fa-fw"></i> MENÚ" y también ordenarlos por orden alfabético o por precio en el botón "<i class="fas fa-sort-alpha-down fa-fw"></i> ORDENAR POR". Además, puede buscar platillos por nombre haciendo clic en el botón "</p>

    <div class="container-fluid" style="border-top: 1px solid #E1E1E1; padding: 20px; 0">
        <div class="row align-items-center">

            <form action="{{route('products.create_menu')}}" method="get">

                <div class="search-input">
                    <div class="form-outline">
                        <div class="div_element">

                            <label for="search"><i class="fas fa-search fa-fw edit_select"></i></label>
                            <input type="search" id="search" name="search" class="form-control"  aria-label="Search" value="{{ old('search',$resultsSearch)}}"/>
                        </div>
                    </div>
                </div>
                <div class="div_sub col-12 col-sm-4 text-center text-sm-start select_mrk">
                    <div class="dropdown">
                        <select name="order" id="order" class="select select_custom">
                            <option selected disabled>Ordenar por</option>
                            <option value="1" {{ old('order',$order) == 1 ? 'selected' : '' }}>Ascendente (A-Z)</option>
                            <option value="2" {{ old('order',$order) == 2 ? 'selected' : '' }}>Descendente (Z-A)</option>
                            <option value="3" {{ old('order',$order) == 3 ? 'selected' : '' }}>Precio (Menor a Mayor)</option>
                            <option value="4" {{ old('order',$order) == 4 ? 'selected' : '' }}>Precio (Mayor a Menor)</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="div_sub col-12 col-sm-4 text-center text-sm-start select_mrk">
                    <div class="dropdown">
                        <select name="category" id="category" class="select select_custom">
                            <option selected disabled>Categorias</option>
                            @forelse ($category as $data)
                                <option value="{{$data->id}}" {{ old('category',$cat) == $data->id ? 'selected' : '' }}>{{$data->category}}</option>
                            @empty
                            <option value="">Ninguna categoria</option>
                            @endforelse
                        </select>
                    </div>
                </div>

            </form>
        </div>
    </div>


    <div class="container-fluid" style="padding: 20px 0;">
        <div class="row">
            <div class="col-12 col-md-8">
                <p>&nbsp; Cerca de {{$results}} resultados</p>
                @if($resultsSearch)
                    <p class="text-left lead form-text-label">&nbsp; Resultados de la búsqueda: <span class="font-weight-bold poppins-regular text-uppercase">{{$resultsSearch}}</span></p>
                @endif
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
