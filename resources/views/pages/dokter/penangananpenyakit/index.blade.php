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
        @slot('table_id', 'jadwal-table')

        @slot('table_header')
            <tr>
                <th>#</th>
                <th>Nama Penyakit </th>
                <th>Deskripsi</th>
                {{-- <th>Dibuat Oleh</th> --}}
                <th>Dapat Ditangani</th>
            </tr>
        @endslot
    @endcomponent

@endsection

@push('after-script')
    <script>
        $(document).ready(function() {
            $('#jadwal-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('penangananpenyakitjson') }}',
                order: [1, 'asc'],
                columns: [{
                        name: 'DT_RowIndex',
                        data: 'DT_RowIndex',
                    },
                    {
                        name: 'nama_penyakit',
                        data: 'nama_penyakit',
                    },
                    {
                        name: 'deskripsi',
                        data: 'deskripsi',
                    },

                    {
                        name: 'aksi',
                        data: 'aksi',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            var result = `<label class="custom-switch mt-2">
                            <input type="checkbox" onclick='handleClick(this,"${row.kode_penyakit}");'
                            ${(row.dokterpenyakit.length > 0 ? 'checked="checked"' : '')}
                            name="custom-switch-checkbox"
                                class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Ya</span>
                        </label>`
                            return result;

                        }
                    },
                ],
            });

        });
    </script>
    <script>
        function handleClick(cb, kode_penyakit) {
            console.log("Clicked, new value = " + cb.checked, kode_penyakit);
            $.ajax({
                type: 'POST',
                url: "{{ url('dokter/penangananpenyakit/joindokter') }}",
                dataType: "JSON",
                data: {
                    kode_penyakit: kode_penyakit,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {}
            });
        }
    </script>

    @include('includes.lightbox')

    @include('includes.notification')

    @include('includes.confirm-modal')
@endpush
