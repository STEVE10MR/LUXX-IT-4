@extends('users.profiles.index')
@section('tab-pane')
<h6>
    DIRECCION DE ENTREGA</h6>
  <hr>
<form method="POST" action="{{route('address.store')}}">
    @csrf

    <div class="form-group">
        <label for="reference">Referencia:</label>
        <input type="text" class="form-control" id="reference" name="reference" aria-describedby="reference" placeholder="Ingresa una referencia">
    </div>
    <input type="hidden" name="latitude" id="latitude" value="">
    <input type="hidden" name="longitude" id="longitude" value="">
    <br>
    <br>
    <button class="btn active_upd">Agregar nueva direccion</button>

</form>
<hr>
<h6>
    MIS DIRECCIONES</h6>

<div class="col">
    <table class="table bg-white rounded shadow-sm  table-hover">
        <thead>
            <tr>
                <th scope="col" width="50">#</th>
                <th scope="col">Referencia</th>
                <th scope="col">Eliminar</th>
            </tr>
        </thead>
        <tbody class="link-master deactivate-modal">
            @if($address)
                @foreach ($address as $value)
                    <tr>
                        <th scope="row">{{'#'}}</th>
                        <td>{{$value->reference}}</td>
                        <td class="">
                            <form action="{{route('address.destroy',$value->id)}}" method="POST">
                                @csrf @method('DELETE')
                                <button class="mod-button"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <div class="container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <header class="masthead mb-auto">
            <div class="inner">
              <h3 class="masthead-brand">Busca tu Casa</h3>
              <div class="nav nav-masthead justify-content-center">
                <div class="col-md-4">
                    <input type="hidden" id="search" class="address form-control search" placeholder="Busca tu direccion">
                  </div>
              </div>
            </div>
          </header>
          <main role="main" class="inner cover">
            <div id="map_canvas" style="height:350px">
            </div>
          </main>
          <br>
    </div>
</div>

<br>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA9aA829ZCM_piMFiVSdCRlP5eHjid-EHY"></script>
<script>


        const search=document.querySelector('.search');
        const locationMarker=document.getElementById('location');
        const latitudeMarker=document.getElementById('latitude');
        const longitudeMarker=document.getElementById('longitude');
        const image ="https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png";
        const map = new google.maps.Map(document.getElementById('map_canvas'), {
            zoom: 14,
            center: new google.maps.LatLng(-18.0025255,-70.2437015),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        let markeUser=new google.maps.Marker({
            position: { lat: -18.0025255, lng: -70.2437015 },
            map:map,
        });

        map.addListener("click", (e) => {
            markeUser.setMap(null);
            placeMarkerAndPanTo(e.latLng, map);
        });
        function placeMarkerAndPanTo(latLng, map) {
            markeUser=new google.maps.Marker({position: latLng,map: map,});
            map.panTo(latLng);
            latitudeMarker.value=markeUser.getPosition().lat();
            longitudeMarker.value=markeUser.getPosition().lng();
        }
        search.addEventListener('keydown',function()
        {
            console.log('search');
        })


</script>
@endsection
