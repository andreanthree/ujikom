@extends('layouts.main')

@push('after-style')
@endpush
@section('title', 'Ganti Koordinat ' . $dataPage['title'])

@section('header-title', 'Ganti Koordinat ' . $dataPage['title'] . ' - ' . $data->nama_dokter)

@section('breadcrumbs')
    <div class="breadcrumb-item"><a href="#">{{ $dataPage['title'] }}</a></div>
    <div class="breadcrumb-item">Data {{ $dataPage['title'] }}</div>
    <div class="breadcrumb-item active">{{ $data->nama_dokter }}</div>
@endsection

{{-- @section('section-title', $dataPage['title'])
    
@section('section-lead')
  Berikut ini adalah daftar seluruh {{$dataPage['title']}}.
@endsection --}}

@section('content')
{{-- <link rel="stylesheet"  src="{{asset('css/leaflet.css')}}">
<script src="{{asset('js/leaflet.js')}}"></script> --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>

    <div class="card">
        <div class="card-header">
            <h4>Ganti Koordinat Data Dokter - {{ $data->nama_dokter }}</h4>
            <div class="card-header-action">
                <a href="#" class="btn btn-primary">
                    {{ $data->status_dokter }}
                </a>
            </div>
        </div>
        <div class="card-body">
            <div id="mapid" style="height: 700px;"></div>
            
        </div>
    </div>
    <script>
        var urlapi = "{{url('/dokter/changelocation')}}";
        var mymap = L.map('mapid').setView([(parseFloat("{{$data->latitude}}") || -7.9219346), (parseFloat("{{$data->longitude}}") || 113.822779)], 15);

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
            maxZoom: 18,
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1
        }).addTo(mymap);
        // var greenIcon = new L.Icon({
        //     iconUrl: urlapi + 'assets/images/marker_icon_green.png',
        //     shadowUrl: urlapi + 'assets/images/marker_shadow.png',
        //     iconSize: [25, 41],
        //     iconAnchor: [12, 41],
        //     popupAnchor: [1, -34],
        //     shadowSize: [41, 41]
        // });
        var marker;

        marker = L.marker([parseFloat("{{$data->latitude}}"), parseFloat("{{$data->longitude}}")], {
                    // icon: greenIcon
                }).addTo(mymap)
                .bindPopup("Lokasi Saya").openPopup();
                
        var popup = L.popup();
        var hasillatlong = "";

        function onMapClick(e) {
            hasillatlong = e.latlng.toString();
            hasillatlong = hasillatlong.replace("LatLng(", "")
            hasillatlong = hasillatlong.replace(")", "")
            hasillatlong = hasillatlong.replace(" ", "")
            popup.setLatLng(e.latlng)
                .setContent("Koordinat dipilih " + e.latlng.toString()
                +` <br/><br/> <button onclick="uplatlong()" type="button" class="btn btn-primary btn-sm">Pilih Koordinat</button> `
                )
                .openOn(mymap);
        }

        mymap.on('click', onMapClick);


        function uplatlong() {
            let tmphasillatlong = `${hasillatlong}`.toString().split(",")
            const params = {
                latitude:tmphasillatlong[0],
                longitude:tmphasillatlong[1],
            }
            
            $.ajax({
                type: "POST",
                url: urlapi,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: params,
                success: function(data) {
                    // marker.removeLayer(mymap)
                    marker.remove(mymap)
                    
                    marker = L.marker([parseFloat(params.latitude), parseFloat(params.longitude)], {
                                // icon: greenIcon
                            }).addTo(mymap)
                            .bindPopup("Lokasi Saya").openPopup();
                    popup.close()

                }

            });
            return true;
        }
    </script>
@endsection

@push('after-script')
   
    
    @include('includes.lightbox')

    @include('includes.notification')

    @include('includes.confirm-modal')
@endpush
