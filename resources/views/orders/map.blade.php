@extends('layouts.user')

@section('tittle','menu')

@section('content')

<div class="commutes">
    <div class="commutes-map" aria-label="Map">
      <div id="map_canvas" style="height: 850px"></div>
    </div>
    <div class="commutes-info">
      <div class="commutes-initial-state">
        <svg
          aria-label="Directions Icon"
          width="53"
          height="53"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <use href="#commutes-initial-icon" />
        </svg>
        <div class="description">
          <h1 class="fw-bold mb-0 color">Resumen de Ruta</h1>
          <p class="col mb-1 " style="color:white;">Inicio de Ruta: <span id="startAddress"></span></p>
          <p class="col mb-1 " style="color:white;">Fin de Ruta: <span id="endAddress"></span></p>
          <p class="col mb-1 " style="color:white;">Duracion: <span id="duration"></span></p>
        </div>
        <form action="{{route('firebase.update')}}" method="post">
            @csrf
            <input type="hidden" value="{{$order_id}}" name="order_id">
            <input type="hidden" name="distance" id="distance">
            <button class="btn btn-dark btn-block btn-lg procButton" id="procButton" data-mdb-ripple-color="dark">Entregar</button>
        </form>
      </div>
    </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA9aA829ZCM_piMFiVSdCRlP5eHjid-EHY&libraries=places"></script>
<script>
    const mapKnavas=document.getElementById("map_canvas");
    const startAddressElement=document.getElementById("startAddress");
    const endAddressElement=document.getElementById("endAddress");
    const durationElement=document.getElementById("duration");
    const distanceElement=document.getElementById("distance");

    class App {
      #map;
      #directionsService;
      #directionsRenderer;
      #lat="<?= floatval($lat) ?>";
      #lon="<?= floatval($lon) ?>";


      constructor() {
        this._getPosition();
      }

      _getPosition() {
            if (navigator.geolocation){
                navigator.geolocation.watchPosition(
                    this._loadMap.bind(this)
                    ,function()
                    {
                        alert("Tu navegador no soporta el acceso a la ubicación. Intenta con otro")
                    },
                    {frequency:5000, maximumAge: 0, timeout: 100, enableHighAccuracy:true}
                );
            }
        }
      _loadMap(position) {
        const { latitude } = position.coords;
        const { longitude } = position.coords;

        this._pushFirebase(latitude,longitude);
        if(!this.#map)
        {
            this.#map = new google.maps.Map(
            document.getElementById("map_canvas"),
            {
                center: new google.maps.LatLng(latitude,longitude),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                disableDefaultUI:true,
                position:google.maps.ControlPosition.BOTTON_CENTER,


            }
            );

        }
        else
        {
            this.#map.center=new google.maps.LatLng(this.#lat,this.#lon)
        }
        this.#directionsService = new google.maps.DirectionsService();
        this.#directionsRenderer = new google.maps.DirectionsRenderer();

        this.#directionsRenderer.setMap(this.#map);

        const request = {
          origin: new google.maps.LatLng(latitude,longitude),
          destination: new google.maps.LatLng(this.#lat,this.#lon),
          travelMode: "DRIVING",
          unitSystem: google.maps.UnitSystem.IMPERIAL
        };

        this.#directionsService.route(request, (response) => {
          this.#directionsRenderer.setDirections(response);
          const route = response.routes[0];
          let startAddress = route.legs[0].start_address;
          let endAddress = route.legs[0].end_address;
          let distance = route.legs[0].distance.value;
          let duration = route.legs[0].duration.text;

          startAddressElement.textContent=startAddress;
          endAddressElement.textContent=endAddress;
          durationElement.textContent=duration;
          distanceElement.value=distance;
        });
      }
      _pushFirebase(latitud=null,longitud=null)
      {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("input[name=_token]").val()
                }
            });
            $.ajax(
            {
                type:'POST',
                url:"{{ route('firebase.load') }}",
                data:{lat:latitud,lon:longitud},
                success:function()
                {
                    console.log("enviado");
                }
            })
        }
    }
    const app = new App();
</script>
@endsection


