@extends('layouts.admin')
@section('tittle','Mapa')

@section('content')

<div class="commutes">
    <div class="commutes-map" aria-label="Map">
      <div id="map_canvas" style="height: 850px"></div>
    </div>
</div>

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA9aA829ZCM_piMFiVSdCRlP5eHjid-EHY&libraries=places"></script>
<script>

    class App {
      #map;
      mythis;

        constructor() {
            this._initMap();
            setInterval(this._return_coords.bind(this),1000);
        }
        _initMap() {
            this.#map = new google.maps.Map(document.getElementById('map_canvas'), {
            center: {lat:-18.0025255,lng:-70.2437015},
            zoom: 13,
            styles: [{
                featureType: 'poi',
                stylers: [{ visibility: 'off' }]  // Turn off POI.
            },
            {
                featureType: 'transit.station',
                stylers: [{ visibility: 'off' }]  // Turn off bus, train stations etc.
            }],
            disableDoubleClickZoom: true,
            streetViewControl: false,
            });

        }
        _add_marker(id,latitud,longitud){
            const iconBase ="https://developers.google.com/maps/documentation/javascript/examples/full/images/";
            var image = {
                url: 'http://andrewnoske.com/hidden/google_maps/icons/red_dot_4x4.png',
                size: new google.maps.Size(18, 18),   // Icon size.
                origin: new google.maps.Point(0, 0),  // Icon origin.
                anchor: new google.maps.Point(9, 9)   // Anchor in middle.
            };
            const marker = new google.maps.Marker({
                    position: {lat:parseFloat(latitud),lng:parseFloat(longitud)},
                    title:"",
                    icon:'https://img.icons8.com/fluent/28/000000/motorcycle.png',

            });
            marker.set('id',id);
            function markerCall()
            {
                this._return_delivery(marker);
            }
            marker.addListener('click',markerCall.bind(this));
            marker.setMap(this.#map);
        }
        _remove_marker()
        {
            console.log(1);
        }
        _addCoord(data) {


            for (const [key,value] of Object.entries(data)) {
                const {id:id,coords:{latitude:latitude,longitude:longitude}}=value;
                this._add_marker(id,latitude,longitude);

            }

        }
        _addInfo(marker,data)
        {


            const [name,phone]=data;



            const infoWindow = new google.maps.InfoWindow({
                content:
                "<h3>Resumen</h3>"+
                "<p>Nombre: "+name+"</p>"+
                "<p>Telefono: "+phone+"</p>",
            });
            infoWindow.open(this.#map, marker)



        }
        _return_coords(){
            $.ajax(
                {
                    type:'GET',
                    url:"{{ route('firebase.load_map') }}",
                    data:{},
                    success:this._addCoord.bind(this),
            })
        }
        _return_delivery(marker){

            const callAddInfo=this._addInfo.bind(this);
            $.ajax(
                {
                    type:'GET',
                    url:"{{ route('firebase.return_delivery')}}",
                    data:{id:marker.get('id')},
                    success:this._addInfo.bind(this,marker)
            })


            /*this._addInfo.bind(this),*/
        }
    }
    const app = new App();
</script>
@endsection
