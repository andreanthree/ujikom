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

    <div class="card">
        <div class="card-header">
            <h4>Detail Artikel</h4>
        </div>
        <div class="card-body">
            <div class="row col-md-12">
                <div class="col-md-8 form-group">
                    <label>Judul Artikel</label>
                    <p>{{ $data->judul_artikel }}</p>
                </div>
                <div class="col-md-4 form-group">
                    <label>Tanggal Dibuat</label>
                    <p>{{ Helper::tanggal($data->tanggal) }}</p>
                </div>
                <div class="col-md-12 form-group">
                    <label>Isi Artikel</label>
                    <p>{{ $data->isi_artikel }}</p>
                </div>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Data Komentar</h4>
            <div class="card-header-action">

            </div>
        </div>
        <div class="card-body">
            @component('components.datatables')
                @slot('table_id', 'penyakit-table')

                @slot('table_header')
                    <tr>
                        <th>#</th>
                        <th>Nama Pembuat</th>
                        <th>Isi Komentar</th>
                        <th>Dibuat Pada</th>
                        <th>Aksi</th>
                    </tr>
                @endslot
            @endcomponent
        </div>
    </div>

@endsection

@push('after-script')
    <script>
        $(document).ready(function() {
            let kode = "{{ $data->id }}"
            $('#penyakit-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url("penulis/komentar/getperartikel/$data->id") }}',
                order: [1, 'asc'],
                columns: [{
                        name: 'DT_RowIndex',
                        data: 'DT_RowIndex',
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

                        render: function(data, type, row) {
                            return '<p class="">' + parseDatetimeToText(row.komentar.waktu) +
                            '</p>';
                        }
                    },

                    {
                        name: 'aksi',
                        data: 'aksi',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            var result = '<div class="">'

                            result +=
                                ' <div class="bullet"></div> <a href="javascript:;" data-id="' + row
                                .id +
                                '" data-title="Hapus" data-body="Yakin ingin menghapus ini?" class="text-danger" id="delete-btn" name="delete-btn">Hapus</a></div>';

                            return result;

                        }
                    },
                ],
            });

            $(document).on('click', '#delete-btn', function() {
                var id = $(this).data('id');
                var title = $(this).data('title');
                var body = $(this).data('body');

                $('.modal-title').html(title);
                $('.modal-body').html(body);
                $('#confirm-form').attr('action', 'deletekomen/' + id + '/' + kode);
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
