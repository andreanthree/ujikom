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

    
    @slot('table_id', 'penyakit-table')

    @slot('table_header')
      <tr>
        <th>#</th>
        <th>Artikel</th>
        <th>Nama</th>
        <th>Komentar</th>
        <th>Tanggal</th>
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
      ajax: '{{ route("komentarjsonadmin") }}',
      order: [1, 'asc'],
      columns: [
      {
        name: 'DT_RowIndex',
        data: 'DT_RowIndex',
      },
      {
        name: 'judul_artikel',
        data: 'artikel.judul_artikel',
      },
      {
        name: 'komentar',
        data: 'komentar.nama',
      },
      {
        name: 'isi_komentar',
        data: 'komentar.isi_komentar',
      },
      {
        name: 'waktu',
        data: 'komentar.waktu',
      },

      {
        name: 'aksi',
        data: 'aksi',
        orderable: false, 
        searchable: false,
        render: function ( data, type, row ) {
          var result = '<div class="">'

          result += ' <div class="bullet"></div> <a href="javascript:;" data-id="'+row.id+'" data-title="Hapus" data-body="Yakin ingin menghapus ini?" class="text-danger" id="delete-btn" name="delete-btn">Hapus</a></div>';

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
      $('#confirm-form').attr('action', 'komentar/'+id);
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
<script>

  openModalImport = () => {
      $('#import-modal').modal('show');

  }
</script>

@include('includes.lightbox')

@include('includes.notification')

@include('includes.confirm-modal')

@endpush