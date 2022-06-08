@extends('layouts.admin')
@section('tittle','Productos')

@section('content')

<div class="container-fluid px-4">
    <div class="row my-5">
        <h3 class="fs-4 mb-3 form-text-logo">Productos</h3>
        <div class="search-input">
            <form action="{{route('product.search')}}" method="GET">
                <div class="form-outline">
                    <input type="search" id="search" name="search" class="form-control" placeholder="search" aria-label="Search" />
                </div>
            </form>
        </div>
        <div class="index_product">
            <div>
                <a class="nav-link nav-color-white text_link btn--show-registro" data-mdb-toggle="" data-mdb-target="#" role="button">Registrar <i class="fas fa-edit"></i></a>
            </div>
            <div class="sorted-link">
                <a class="nav-link nav-color-white text_link sorted DESC" href="?sorted=ASC" role="button"><i class="fa-solid fa-arrow-up"></i></a>
                <a class="nav-link nav-color-white text_link sorted DESC" href="?sorted=DESC" role="button"><i class="fas fa-arrow-down"></i></i></a>
            </div>
        </div>
        <div class="col">
            <table class="table bg-white rounded shadow-sm  table-hover">
                <thead>
                    <tr>
                        <th scope="col" width="50">#</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Precio Unitario</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Editar</th>

                    </tr>
                </thead>
                <tbody>
                    @if($product)
                        @foreach ($product as $value)
                            <tr>
                                <th scope="row">1</th>
                                <td>{{$value->name}}</td>
                                <td>{{$value->category}}</td>
                                <td>{{$value->price}}</td>
                                <td>
                                    @if(($value->status)==1)
                                        <a class="nav-link nav-color text_link" href="{{route('product.status',$value->id)}}" role="button"><i class="fas fa-toggle-on"></i></a>
                                    @else
                                        <a class="nav-link nav-color text_link" href="{{route('product.status',$value->id)}}" role="button"><i class="fas fa-toggle-off"></i></a>
                                    @endif
                                </td>
                                <td>
                                    <a class="nav-link nav-color text_link btn--show-editar" data-mdb-toggle="" data-mdb-target="#" role="button"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

        </div>
        <div class="pagination">
            @if($product)
                {{!! $product->appends(request()->query())->links('pagination::bootstrap-4') !!}}
            @endif
        </div>
    </div>
</div>
<div class="modale container py-5 h-100 hidden" id="modale">
    <div class="row d-flex justify-content-center align-items-center h-100">
    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
        <div class="card-body p-5 text-center">

            <div class="mb-md-5 mt-md-4 pb-5 form_repeat_l">
            <button class="btn--close-editar">&times;</button>
            <h2 class="fw-bold mb-2 text-uppercase">Editar Producto</h2>
                <br>
                <form method="POST" enctype="multipart/form-data" action="{{ route('product.create')}}" >
                    @csrf
                    <div class="form-outline form-white mb-4">
                        <label class="form-label" for="name">Nombre de Producto</label>
                        <input type="text" name="name" id="name" class="form-control form-control-lg" required/>
                        @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>

                    <div class="form-outline form-white mb-4">
                        <label class="form-label" for="description">Descripcion de Producto</label>
                        <input type="text" name="description" id="description" class="form-control form-control-lg" required/>
                        @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>

                    <div class="form-outline form-white mb-4">
                        <label class="form-label" for="prices">Precio</label>
                        <input type="text" name="prices" id="prices" class="form-control form-control-lg" required/>
                        @error('prices')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>

                    <div class="form-outline form-white mb-4">
                        <label class="form-label" for="category_id">Categoria</label>
                        <select name="category_id" class="form-control">
                            <option value="">-------</option>
                            @forelse ($category as $categorys)
                                <option value="{{$categorys->id}}">{{$categorys->category}}</option>
                            @empty
                                <option value="">Ninguna categoria</option>
                            @endforelse
                          </select>
                    </div>
                    <div class="form-outline form-white mb-4">

                        <label class="form-label" for="image">Imagen de Producto</label>
                        <input class="form-control" type="file" name="image" id="image" accept="image/jpg, image/jpeg, image/png"/>
                        @error('images')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    <br>
                    <button class="btn btn-outline-light btn-lg px-5" type="submit">Registrar</button>
                </form>

            </div>

        </div>
        </div>
    </div>
    </div>
</div>
<div class="modalr container py-5 h-100 hidden" id="modalr">
    <div class="row d-flex justify-content-center align-items-center h-100">
    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
        <div class="card-body p-5 text-center">

            <div class="mb-md-5 mt-md-4 pb-5 form_repeat_l">
            <button class="btn--close-registro">&times;</button>
            <h2 class="fw-bold mb-2 text-uppercase">Registrar Producto</h2>
                <br>
            <form method="POST" enctype="multipart/form-data" action="{{ route('product.create')}}" >
                @csrf
                <div class="form-outline form-white mb-4">
                    <label class="form-label" for="name">Nombre de Producto</label>
                    <input type="text" name="name" id="name" class="form-control form-control-lg" required/>
                    @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>

                <div class="form-outline form-white mb-4">
                    <label class="form-label" for="description">Descripcion de Producto</label>
                    <input type="text" name="description" id="description" class="form-control form-control-lg" required/>
                    @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>

                <div class="form-outline form-white mb-4">
                    <label class="form-label" for="prices">Precio</label>
                    <input type="text" name="prices" id="prices" class="form-control form-control-lg" required/>
                    @error('prices')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>

                <div class="form-outline form-white mb-4">
                    <label class="form-label" for="category_id">Categoria</label>
                    <select name="category_id" class="form-control">
                        <option value="">-------</option>
                        @forelse ($category as $categorys)
                            <option value="{{$categorys->id}}">{{$categorys->category}}</option>
                        @empty
                            <option value="">Ninguna categoria</option>
                        @endforelse
                      </select>
                </div>
                <div class="form-outline form-white mb-4">

                    <label class="form-label" for="image">Imagen de Producto</label>
                    <input class="form-control" type="file" name="image" id="image" accept="image/jpg, image/jpeg, image/png"/>
                    @error('images')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>
                <br>
                <button class="btn btn-outline-light btn-lg px-5" type="submit">Registrar</button>
            </form>


            </div>
        </div>
        </div>
    </div>
    </div>
</div>
<div class="overlay hidden"></div>

@endsection




