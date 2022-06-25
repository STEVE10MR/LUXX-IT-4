@extends('users.profiles.index')
@section('tab-pane')
<h6>
    MIS ENTREGAS</h6>
  <hr>
<div class="col">
    <table class="table bg-white rounded shadow-sm  table-hover">
        <thead>
            <tr>
                <th scope="col" width="10">#</th>
                <th scope="col">Productos</th>
                <th scope="col">Direccion</th>
                <th scope="col">Monto</th>
                <th scope="col">Entregado</th>
                <th scope="col">Tiempo de Entrega</th>
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
                        <td>{{($value->recept) == '1'? 'Entregado' : 'No entregado'}}</td>
                        <td>{{$value->updated_at->diffForHumans()}}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        </tbody>
    </table>
</div>

<br>

@endsection
