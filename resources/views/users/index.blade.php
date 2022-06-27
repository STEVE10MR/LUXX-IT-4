@extends('layouts.admin')
@section('tittle','Gestion de Repartidores')

@section('content')

<div class="container-fluid px-4">
    <div class="row my-5">
        <h3 class="fs-4 mb-3 form-text-logo">Repartidores</h3>
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
                        <th scope="col">Email</th>
                        <th scope="col">Telefono</th>
                        <th scope="col">Creado</th>
                        <th scope="col">Actualizado</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Restablecer contraseña</th>
                    </tr>
                </thead>
                <tbody class="link-master deactivate-modal">
                    @if($user)
                        @foreach ($user as $value)
                            <tr>
                                <th scope="row">#</th>
                                <td>{{$value->name}}</td>
                                <td>{{$value->email}}</td>
                                <td>{{$value->phone}}</td>
                                <td>{{$value->created_at}}</td>
                                <td>{{$value->updated_at->diffForHumans()}}</td>
                                <td class="value-product">
                                    @if(($value->status)==1)
                                        <a class="nav-link nav-color text_link" href="{{route('user.status',$value->id)}}""><i class="fas fa-toggle-on link-status-a"></i></a>
                                    @else
                                        <a class="nav-link nav-color text_link" href="{{route('user.status',$value->id)}}""><i class="fas fa-toggle-off link-status-d"></i></a>
                                    @endif
                                </td>
                                <td class="">
                                    <a class="nav-link nav-color text_link btn--show-modal edits" data-toggle="modalx" data-target="#modalEdit{{$value->id}}" data-id="{{$value->id}}" role="button"><i class="fa fa-key active-modal" aria-hidden="true"></i></a>
                                    @include('users.modal.edit')
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

        </div>
        <div class="pagination">
            @if($user)
                {{!! $user->appends(request()->query())->links('pagination::bootstrap-4') !!}}
            @endif
        </div>
    </div>
</div>
@include('users.modal.create')
<div class="overlay hidden"></div>
@endsection

