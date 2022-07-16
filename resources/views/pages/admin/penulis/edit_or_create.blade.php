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
  <div class="breadcrumb-item"><a href="#">Data {{$dataPage['title']}}</a></div>
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
      @slot('form_action', 'penulis.update')
      @slot('update_id', $item->id_penulis)
    @else 
      @slot('form_method', 'POST')
      @slot('form_action', 'penulis.store')
    @endif

    @slot('is_form_with_file', 'true')

    @slot('input_form')
      @foreach ($dataPage['formData'] as $val)
        @component('components.input-field')
          @slot('input_label', $val['label'])
          @slot('input_type', $val['type'])
          @slot('input_name', $val['name'])
          @slot('placeholder', $val['placeholder'])
          @isset($item[$val['name']])
            @slot('input_value')
              {{ $item[$val['name']] }}
            @endslot 
          @endisset
          @if($val['type'] == 'select')
            @slot('select_content')
              <option value="">Pilih {{ $val['label'] }}</option>

              @foreach ($val['data'] as $vl)
                  <option value="{{$vl['id']}}" {{$vl['id'] == $val['selectedId'] ? 'selected' : ''}}>{{$vl['label']}}</option>
              @endforeach
            @endslot 
          @endif
          @slot('form_group_class', $val['form_group_class'].' col-md-6')
          @slot('other_attributes', $val['other_attributes'])
        @endcomponent
      @endforeach
      

    @endslot

    @slot('card_footer', 'true')
    @slot('card_footer_class', 'text-right')
    @slot('card_footer_content')
      @include('includes.save-cancel-btn')
    @endslot 

  @endcomponent

@endsection
