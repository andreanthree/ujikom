@extends('layouts.main')

@section('title', 'Data ' . $dataPage['title'])

@section('header-title', 'Data ' . $dataPage['title'])

@section('breadcrumbs')
    <div class="breadcrumb-item"><a href="#">{{ $dataPage['title'] }}</a></div>
    <div class="breadcrumb-item active">Data {{ $dataPage['title'] }}</div>
@endsection

@section('section-title', $dataPage['title'])

@section('section-lead')
    Berikut ini adalah daftar seluruh {{ $dataPage['title'] }}.
@endsection

@section('content')

    @component('components.datatables')
        @slot('buttons')
            <a href="{{ url('penulis/artikelpenulis/create') }}" class="btn btn-primary"><i class="fas fa-plus"></i>&nbsp;Tambah
                Artikel</a>
        @endslot

        @slot('table_id', 'penyakit-table')

        @slot('table_header')
            <tr>
                <th>#</th>
                <th>Judul</th>
                <th>Tanggal</th>
                <th>Deskripsi</th>
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
                ajax: '{{ route('artikeljsonwriter') }}',
                order: [1, 'asc'],
                columns: [{
                        name: 'DT_RowIndex',
                        data: 'DT_RowIndex',
                    },
                    {
                        name: 'judul_artikel',
                        data: 'judul_artikel',

                        render: function(data, type, row) {
                            return '<a href="artikelpenulis/' + row.id + '" class="text-primary">' +
                                row.judul_artikel + '</a>';
                        }
                    },
                    {
                        name: 'tanggal',
                        data: 'tanggal',
                        render: function(data, type, row) {
                            return '<p class="">' + parseDateToText(row.tanggal) +
                                '</p>';
                        }
                    },
                    {
                        name: 'isi_artikel',
                        data: 'isi_artikel',
                    },

                    {
                        name: 'aksi',
                        data: 'aksi',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            var result = '<div class=""> <a href="artikelpenulis/' + row.id +
                                '/edit" class="text-primary">Edit</a>'

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
                $('#confirm-form').attr('action', 'artikelpenulis/' + id);
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
