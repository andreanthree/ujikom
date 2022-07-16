@extends('layouts.main')

@section('title', 'Template Import Data')

@section('header-title', 'Template Import Data')
    
@section('breadcrumbs')
  <div class="breadcrumb-item active">Template Import Data</div>
@endsection

@section('section-title', 'Template Import Data')
    
@section('section-lead')
  Berikut ini adalah daftar template Import data pada aplikasi ini.
@endsection

@section('content')

  @component('components.datatables')

    @slot('table_id', 'mapel-table')

    @slot('table_header')
      <tr>
        <th>#</th>
        <th>Nama Import</th>
        <th>Aturan</th>
        <th>Aksi</th>
      </tr>
    @endslot
    @slot('table_body')
      @foreach ($data as $item)
      <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{ $item['name'] }}</td>
        <td>{{ $item['aturan'] }}</td>
        <td>

          <a href="{{$item['link']}}" download="{{$item['name']}}.xlsx" class="btn btn-sm btn-primary"><i class="fas fa-download"></i> Download File</a>
        </td>
      </tr>
      @endforeach
    @endslot
      
  @endcomponent
@endsection

@push('after-script')


@include('includes.lightbox')

@include('includes.notification')

@include('includes.confirm-modal')

@endpush