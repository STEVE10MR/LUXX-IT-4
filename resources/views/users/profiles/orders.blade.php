@extends('users.profiles.index')
@section('tab-pane')
<h6>
    MIS PEDIDOS</h6>
  <hr>
<div class="col">
    <table class="table bg-white rounded shadow-sm  table-hover">
        <thead>
            <tr>
                <th scope="col" width="10">#</th>
                <th scope="col">Productos</th>
                <th scope="col">Direccion</th>
                <th scope="col">Monto</th>
                <th scope="col">Estado</th>
                <th scope="col">Tipo de pago</th>
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
                        <td>{{$value->status}}</td>
                        <td>{{$value->pay_type}}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tbody class="link-master deactivate-modal">

        </tbody>
    </table>
</div>

<br>

@endsection

