@extends('layouts.main')

@section('title', 'Data '. $dataPage['title'])

@section('header-title', 'Data '. $dataPage['title'])
    
@section('breadcrumbs')
  <div class="breadcrumb-item"><a href="#">{{$dataPage['title']}}</a></div>
  <div class="breadcrumb-item active">Data {{$dataPage['title']}}</div>
@endsection

@section('section-title', $dataPage['title'])
    
@section('section-lead')
  Berikut ini adalah daftar seluruh {{$dataPage['title']}}.
@endsection

@section('content')

  @component('components.datatables')

    @slot('buttons')
      <div class="row">
      <a href="{{ route('analisis.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i>&nbsp;Buat Analisis Baru</a>
      </div>
    @endslot
    
    @slot('table_id', 'penyakit-table')

    @slot('table_header')
      <tr>
        <th>#</th>
        <th>Nama Penyakit</th>
        <th>Solusi</th>
        <th >Data Gejala</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    @endslot
      
  @endcomponent

@endsection

@push('after-script')

  <script>
  $(document).ready(function() {
    $('#penyakit-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ route("aturanjsondokter") }}',
      order: [1, 'asc'],
      columns: [
      {
        name: 'DT_RowIndex',
        data: 'DT_RowIndex',
      },
      {
        name: 'nama_penyakit',
        data: 'penyakit.nama_penyakit',
      },
      {
        name: 'solusi',
        data: 'solusi',
      },
      {
        name: 'created_by',
        data: 'user.name',
        render: function(data,type, row) {
            let text = ''
              row.aturanitem.forEach(element => {
                text += element.gejala.nama_gejala+' - '+parseBobotToText(element.bobot)+' <br/>'
              });
            return text
        }
      },
      {
        name: 'status_aturan',
        data: 'status_aturan',
      },
      {
        name: 'aksi',
        data: 'aksi',
        orderable: false, 
        searchable: false,
        render: function ( data, type, row ) {
          var result = '<div class=""> <a href="aturan/'+row.kode_aturan+'/edit" class="text-primary">Edit</a>'

          result += ' <div class="bullet"></div> <a href="javascript:;" data-id="'+row.kode_aturan+'" data-title="Hapus" data-body="Yakin ingin menghapus ini?" class="text-danger" id="delete-btn" name="delete-btn">Hapus</a></div>';

          return result;
            
        }
      },
    ],
    });
  

    $(document).on('click', '#delete-btn', function() {
      var id    = $(this).data('id'); 
      var title = $(this).data('title');
      var body  = $(this).data('body');

      $('.modal-title').html(title);
      $('.modal-body').html(body);
      $('#confirm-form').attr('action', 'aturan/'+id);
      $('#confirm-form').attr('method', 'POST');
      $('#submit-btn').attr('class', 'btn btn-danger');
      $('#lara-method').attr('value', 'delete');
      $('#confirm-modal').modal('show');
    });

    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
  });
</script>

@include('includes.lightbox')

@include('includes.notification')

@include('includes.confirm-modal')

@endpush