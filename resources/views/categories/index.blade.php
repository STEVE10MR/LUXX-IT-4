@extends('layouts.admin')
@section('tittle','Categorias')

@section('content')

<div class="container-fluid px-4">
    <div class="row my-5">
        <h3 class="fs-4 mb-3 form-text-logo">Categorias</h3>
        <div class="search-input">
            <form action="{{route('user.index')}}" method="GET">
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
                        <th scope="col">Nombre</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Editar</th>
                        <th scope="col">Eliminar</th>
                    </tr>
                </thead>
                <tbody class="link-master deactivate-modal">
                    @if($categories)
                        @foreach ($categories as $value)
                            <tr>
                                <th scope="row">#</th>
                                <td>{{$value->category}}</td>
                                <td>{{$value->description}}</td>
                                <td class="value-product">
                                    <a class="nav-link nav-color text_link btn--show-modal edits" data-toggle="modalx" data-target="#modalEdit{{$value->id}}" data-id="{{$value->id}}" role="button"><i class="fas fa-edit link-edit active-modal"></i></a>
                                    @include('categories.modal.edit')
                                </td>
                                <td class="">
                                    <form action="{{route('categories.destroy',$value->id)}}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="mod-button"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="pagination">
            @if($categories)
                {{!! $categories->appends(request()->query())->links('pagination::bootstrap-4') !!}}
            @endif
        </div>
    </div>
</div>
@include('categories.modal.create')
<div class="overlay hidden"></div>
@endsection

