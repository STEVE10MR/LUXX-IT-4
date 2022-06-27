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


        const apikey="AIzaSyA9aA829ZCM_piMFiVSdCRlP5eHjid-EHY";
        const search=document.querySelector('.search');
        const locationMarker=document.getElementById('location');
        const latitudeMarker=document.getElementById('latitude');
        const longitudeMarker=document.getElementById('longitude');
        const reference=document.getElementById('reference');
        const image ="https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png";

        class App
        {
            #map;
            #markeUser;
            #geocode;

            constructor() {
                this._getPosition();
            }
            _getPosition() {
                if (navigator.geolocation){
                    navigator.geolocation.getCurrentPosition(
                        this._loadMap.bind(this),this._loadMapN.bind(this),
                        {frequency:5000, maximumAge: 0, timeout: 100, enableHighAccuracy:true});
                }
            }
            _loadMap(position) {
                const { latitude } = position.coords;
                const { longitude } = position.coords;
                this.#map = new google.maps.Map(document.getElementById('map_canvas'), {
                    zoom: 14,
                    center: new google.maps.LatLng(latitude,longitude),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
                this.#geocode=new google.maps.Geocoder();
                this._markerMap(latitude,longitude);
                this._placeMarkerEvent();
            }
            _loadMapN() {
                alert('No se pudo obtener su ubicacion');
                this.#map = new google.maps.Map(document.getElementById('map_canvas'), {
                    zoom: 14,
                    center: new google.maps.LatLng(-18.0025255,-70.2437015),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
                this._markerMap();
                this._placeMarkerEvent();
            }
            _markerMap(latidude=-18.0025255,longitude=-70.2437015)
            {
                this.#markeUser=new google.maps.Marker({
                    position: { lat:latidude, lng:longitude },
                    map:this.#map,
                });
            }
            _placeMarkerEvent() {
                this.#map.addListener("click", (e) => {
                    this.#markeUser.setMap(null);
                    this._placeMarkerAndPanTo(e.latLng);
                    //////////////////////////////
                });
            }
            _placeMarkerAndPanTo(latLng) {
                this.#markeUser=new google.maps.Marker({position: latLng,map: this.#map,});
                this.#map.panTo(latLng);
                latitudeMarker.value=this.#markeUser.getPosition().lat();
                longitudeMarker.value=this.#markeUser.getPosition().lng();
                /////////////////////////////////
                this._coordsToAddress(this.#markeUser.getPosition().lat(),this.#markeUser.getPosition().lng());

            }
            _coordsToAddress(latidude=-18.0025255,longitude=-70.2437015)
            {
                const url = "https://maps.googleapis.com/maps/api/geocode/json?latlng="+ latidude + "," + longitude +"&key=" + apikey;
                $.ajax({url: url})
                      .done(function(data){
                            if(data.status === "OK")
                            {
                                reference.value=data.results[0].formatted_address;
                                console.log(data.results[0].formatted_address);
                            }
                            else
                            {
                                alert('Error');
                            }

                });
            }
        }
        const app=new App();
</script>
@endsection
