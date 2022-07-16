@extends('layouts.main')

@section('title', 'Detail ' . $dataPage['title'])

@section('header-title', 'Detail ' . $dataPage['title'] . ' - ' . $data->nama_dokter)

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

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
        integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
        crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
        integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
        crossorigin=""></script>

    <div class="card">
        <div class="card-header">
            <h4>Detail Data Dokter - {{ $data->nama_dokter }}</h4>
            <div class="card-header-action">
                <a href="#" class="btn btn-primary">
                    {{ $data->status_dokter }}
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row col-md-12">
                <div class="col-md-3 form-group">
                    <label>Nama Lengkap</label>
                    <p>{{ $data->nama_dokter }}</p>
                </div>
                <div class="col-md-3 form-group">
                    <label>Kategori Dokter</label>
                    <p>{{ $data->kategori->nama_kategori }}</p>
                </div>
                <div class="col-md-3 form-group">
                    <label>No Izin Praktik</label>
                    <p>{{ $data->no_izin_praktik }}</p>
                </div>
                <div class="col-md-3 form-group">
                    <label>Jenis Kelamin</label>
                    <p>{{ Helper::convertGender($data->jenis_kelamin) }}</p>
                </div>
                <div class="col-md-3 form-group">
                    <label>No HP</label>
                    <p>{{ $data->no_hp }}</p>
                </div>
                <div class="col-md-3 form-group">
                    <label>No WA</label>
                    <p>{{ $data->no_wa }}</p>
                </div>
                <div class="col-md-3 form-group">
                    <label>Alamat</label>
                    <p>{{ $data->alamat }}</p>
                </div>
                <div class="col-md-3 form-group">
                    <label>Koordinat Lokasi</label>
                    <p>{{ $data->latitude . ',' . $data->longitude }}</p>
                    <a href="{{ url('dokter/changelocation') }}">
                        Ganti</a>
                </div>
                <div class="col-md-3 form-group">
                    <label>Foto</label><br />
                    <a href="{{ url($data->foto) }}">
                        <img src="{{ url($data->foto) }}" class="avatar" />
                    </a>
                </div>
                <div class="col-md-3 form-group">
                    <label>Dibuat Pada</label>
                    <p>{{ Helper::waktu($data->created_at) }}</p>
                </div>
                <div class="col-md-3 form-group">
                    <label>Ganti Status</label><br/>
                    
                    <div class="btn-group">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{$data->status_dokter}}
                        </button>
                        <form action="" method="post">
                            
                        </form>
                        <div class="dropdown-menu">
                          <div class="dropdown-title">Silahkan Pilih Status</div>
                          <a class="dropdown-item {{$data->status_dokter === 'Aktif' ? 'active' : '' }}" href="#">Aktif</a>
                          <a class="dropdown-item {{$data->status_dokter === 'Libut' ? 'active' : '' }}" href="#">Libur</a>
                          <a class="dropdown-item {{$data->status_dokter === 'NonAktif' ? 'active' : '' }}" href="#">NonAktif</a>
                        </div>
                      </div>
                </div>
            </div>

            <div id="mapid" style="height: 500px;"></div>
        </div>
    </div>
    <script>
        var mymap = L.map('mapid').setView([(parseFloat("{{ $data->latitude }}") || -7.9219346), (parseFloat(
            "{{ $data->longitude }}") || 113.822779)], 15);

        L.tileLayer(
            'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                maxZoom: 18,
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                    '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                    'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1
            }).addTo(mymap);

        var marker;

        marker = L.marker([parseFloat("{{ $data->latitude }}"), parseFloat("{{ $data->longitude }}")], {
                // icon: greenIcon
            }).addTo(mymap)
            .bindPopup("Lokasi Saya").openPopup();
    </script>
@endsection

@push('after-script')
    @include('includes.lightbox')

    @include('includes.notification')

    @include('includes.confirm-modal')
@endpush
