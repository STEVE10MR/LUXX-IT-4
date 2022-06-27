@extends('layouts.admin')
@section('tittle','Gestion de Productos')

@section('content')

<div class="container-fluid px-4">
    <div class="row my-5">
        <h3 class="fs-4 mb-3 form-text-logo">Productos</h3>
        <div class="search-input">
            <form action="{{route('product.index')}}" method="GET">
                <div class="form-outline">
                    <input type="search" id="search" name="search" class="form-control" placeholder="search" aria-label="Search" />
                </div>
            </form>
        </div>
        <div class="index_product">
            <div>
                <a class="nav-link nav-color-white text_link btn--show-modal register" data-mdb-toggle="" data-mdb-target="#" role="button">Registrar <i class="fas fa-edit"></i></a>

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
                <tbody class="link-master deactivate-modal">
                    @if($product)
                        @foreach ($product as $value)
                            <tr>
                                <th scope="row">#</th>
                                <td>{{$value->name}}</td>
                                <td>{{$value->category}}</td>
                                <td>{{$value->price}}</td>
                                <td class="value-product">
                                    @if(($value->status)==1)
                                        <a class="nav-link nav-color text_link" href="{{route('product.status',$value->id)}}"><i class="fas fa-toggle-on link-status-a"></i></a>
                                    @else
                                        <a class="nav-link nav-color text_link" href="{{route('product.status',$value->id)}}"><i class="fas fa-toggle-off link-status-d"></i></a>
                                    @endif
                                </td>
                                <td class="">

                                    <a class="nav-link nav-color text_link btn--show-modal edits " data-toggle="modalx" data-target="#modalEdit{{$value->id}}" data-id="{{$value->id}}" role="button"><i class="fas fa-edit link-edit active-modal"></i></a>
                                    @include('product.modal.edit')
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
@include('product.modal.create')
<div class="overlay hidden"></div>
@endsection




