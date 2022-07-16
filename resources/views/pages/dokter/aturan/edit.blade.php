@extends('layouts.main')

@section('title')
  @if(isset($item))
    Edit Data {{$dataPage['title']}}
  @else 
    Tambah Data {{$dataPage['title']}}
  @endif
@endsection 

@section('header-title')
  @if(isset($item))
    Edit Data {{$dataPage['title']}}
  @else 
    Tambah Data {{$dataPage['title']}}
  @endif
@endsection 
    
@section('breadcrumbs')
  <div class="breadcrumb-item"><a href="{{ route('gejala.index') }}">Data {{$dataPage['title']}}</a></div>
  <div class="breadcrumb-item @if(isset($item)) '' @else 'active' @endif">
    @if(isset($item))
      <a href="#">Edit Data {{$dataPage['title']}}</a>
    @else 
      Tambah Data {{$dataPage['title']}} 
    @endif
  </div>
  @isset($item)
    <div class="breadcrumb-item active">{{ $item->no_buku }}</div>
  @endisset
@endsection

@section('section-title')
  @if(isset($item))
    Edit Data {{$dataPage['title']}}
  @else 
    Tambah Data {{$dataPage['title']}}
  @endif
@endsection 
    
@section('section-lead')
  Silakan isi form di bawah ini untuk @if(isset($item)) mengedit data {{ $item->no_buku }} @else menambah data {{$dataPage['title']}}. @endif
@endsection

@section('content')

  @component('components.form')

    @slot('row_class', 'justify-content-center row')
    @slot('col_class', 'col-12 col-md-12')

    @if(isset($item))
      @slot('form_method', 'POST')
      @slot('method', 'PUT')
      @slot('form_action', 'aturan.update')
      @slot('update_id', $item->kode_aturan)
    @else 
      @slot('form_method', 'POST')
      @slot('form_action', 'aturan.store')
    @endif

    @slot('is_form_with_file', 'true')

    @slot('input_form')
      
    @component('components.input-field')
        @slot('input_label', 'Solusi yang anda berikan')
        @slot('input_type', 'textarea')
        @slot('input_name', 'solusi')
        @slot('input_id', 'solusi')
        @slot('placeholder', 'Masukkan Solusi yang anda berikan')
        @slot('form_group_class', 'required col-md-6')
        @slot('other_attributes', 'required')
        @slot('input_value', $item->solusi)
    @endcomponent
    <div class="col-md-12">

    @component('components.datatables')
      @slot('table_id', 'bobot-table')

      @slot('table_header')
          <tr>
              <th>#</th>
              <th>Nama Gejala</th>
              <th>Bobot</th>
          </tr>
      @endslot
      @slot('table_body')
      @foreach ($item->aturanitem as $val)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $val->gejala->nama_gejala }}</td>
            <td>
              <div class="form-group">
                <br/>
                  <label>Pilih Bobot</label><br/>
                <div class="selectgroup ">
                  <label class="selectgroup-item">
                    <input type="radio" name="{{$val->kode_aturan_item}}" {{ (int)$val->bobot === 20 ? 'checked="checked"' : '' }} value="20"  class="selectgroup-input">
                    <span class="selectgroup-button">Sangat Rendah</span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="{{$val->kode_aturan_item}}" {{ (int)$val->bobot === 40 ? 'checked="checked"' : '' }} value="40"  class="selectgroup-input">
                    <span class="selectgroup-button">Rendah</span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="{{$val->kode_aturan_item}}" {{ (int)$val->bobot === 60 ? 'checked="checked"' : '' }} value="60"  class="selectgroup-input">
                    <span class="selectgroup-button">Menengah</span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="{{$val->kode_aturan_item}}" {{ (int)$val->bobot === 80 ? 'checked="checked"' : '' }} value="80"  class="selectgroup-input">
                    <span class="selectgroup-button">Tinggi</span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="{{$val->kode_aturan_item}}" {{ (int)$val->bobot === 100 ? 'checked="checked"' : '' }} value="100"  class="selectgroup-input">
                    <span class="selectgroup-button">Sangat Tinggi</span>
                  </label>
                </div>
              </div>  
            </td>
          </tr>
      @endforeach
      @endslot
    @endcomponent
    </div>

    @endslot

    @slot('card_footer', 'true')
    @slot('card_footer_class', 'text-right')
    @slot('card_footer_content')
      @include('includes.save-cancel-btn')
    @endslot 

  @endcomponent

@endsection
