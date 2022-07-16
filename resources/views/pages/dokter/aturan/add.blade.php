@extends('layouts.main')
@push('after-style')
    <link rel="stylesheet" href="{{ asset('css/steps.css') }}">
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        .loader {
            border: 16px solid #f3f3f3;
            /* Light grey */
            border-top: 16px solid #3498db;
            /* Blue */
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
            margin-bottom: 20px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

    </style>
@endpush

@section('title')
    @if (isset($item))
        Edit Data {{ $dataPage['title'] }}
    @else
        Tambah Data {{ $dataPage['title'] }}
    @endif
@endsection

@section('header-title')
    @if (isset($item))
        Edit Data {{ $dataPage['title'] }}
    @else
        Tambah Data {{ $dataPage['title'] }}
    @endif
@endsection

@section('breadcrumbs')
    <div class="breadcrumb-item"><a href="{{ route('aturan.index') }}">Data {{ $dataPage['title'] }}</a></div>
    <div class="breadcrumb-item @if (isset($item)) '' @else 'active' @endif">
        @if (isset($item))
            <a href="#">Edit Data {{ $dataPage['title'] }}</a>
        @else
            Tambah Data {{ $dataPage['title'] }}
        @endif
    </div>
    @isset($item)
        <div class="breadcrumb-item active">{{ $item->no_buku }}</div>
    @endisset
@endsection

@section('section-title')
    @if (isset($item))
        Edit Data {{ $dataPage['title'] }}
    @else
        Tambah Data {{ $dataPage['title'] }}
    @endif
@endsection

@section('section-lead')
    Silakan isi form di bawah ini untuk @if (isset($item))
    mengedit data {{ $item->no_buku }} @else menambah data {{ $dataPage['title'] }}.
    @endif
@endsection

@section('content')
    <div id="panelLoader" class="text-center card card-body center-block" style="visibility:hidden; display: none;">>
        <center>
            <div class="loader"></div>
            <h2>Loading . . .</h2>
            <p>Mengirim data ke server, Silahkan Tunggu</p>
        </center>
    </div>
    <form id="example-basic" class=" card card-body">

        <div>
            <h3>Data Penyakit</h3>
            <section class="row col-md-12">
                @component('components.input-field')
                    @slot('input_label', 'Nama Penyakit')
                    @slot('input_type', 'text')
                    @slot('input_name', 'penyakit')
                    @slot('input_id', 'penyakit')
                    @slot('placeholder', 'Masukkan Nama Penyakit')
                    @slot('form_group_class', 'required col-md-6')
                    @slot('other_attributes', 'required')
                @endcomponent
                @component('components.input-field')
                    @slot('input_label', 'Solusi yang anda berikan')
                    @slot('input_type', 'textarea')
                    @slot('input_name', 'solusi')
                    @slot('input_id', 'solusi')
                    @slot('placeholder', 'Masukkan Solusi yang anda berikan')
                    @slot('form_group_class', 'required col-md-6')
                    @slot('other_attributes', 'required')
                @endcomponent
                @component('components.input-field')
                    @slot('input_label', 'Deskripsi Penyakit')
                    @slot('input_type', 'textarea')
                    @slot('input_name', 'descpenyakit')
                    @slot('input_id', 'descpenyakit')
                    @slot('placeholder', 'Masukkan Deskripsi Penyakit')
                    @slot('form_group_class', 'required col-md-6')
                    @slot('other_attributes', 'required')
                @endcomponent
                {{-- <p></p> --}}

            </section>
            <h3>Data Gejala</h3>
            <section>
                <p>Silahkan input data gejala pada penyakit telah anda input</p>

                <p>Input Gejala Baru</p>
                <div id="inputgejala" class="row com-md-12">

                </div>
                <button type="button" class="btn btn-primary" onclick="addRow()"><i class="fas fa-plus"></i>&nbsp;Tambah
                    Baris</button>

                @component('components.datatables')
                    @slot('card_header', 'true')
                    @slot('card_header_content', 'Pilih data yang telah ada')
                    @slot('table_id', 'gejala-table')

                    @slot('table_header')
                        <tr>
                            <th>#</th>
                            <th>Nama Gejala</th>
                            <th>Kategori Gejala</th>
                            <th>Aktifkan</th>
                        </tr>
                    @endslot
                    @slot('table_body')
                        @foreach ($gejala as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_gejala }}</td>
                                <td>{{ $item->gejalagrup->nama_gejala_grup }}</td>
                                <td>
                                    <label class="custom-switch mt-2">
                                        <input type="checkbox"
                                            onclick='handleClick(this,"{{ $item->kode_gejala }}","{{ $item->nama_gejala }}");'
                                            name="custom-switch-checkbox" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Aktifkan</span>
                                    </label>
                                </td>
                            </tr>
                        @endforeach
                    @endslot
                @endcomponent
            </section>
            <h3>Atur Bobot Gejala</h3>
            <section>
                <p>Silahkan beri bobot gejala terhadap penyakit</p>
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
                    @endslot
                @endcomponent
            </section>
            <h3>Konfirmasi</h3>
            <section>
                <p>Silahkan konfirmasi data yang telah anda input.</p>
                @component('components.datatables')
                    @slot('table_id', 'konfirmasi-table')

                    @slot('table_header')
                    @endslot
                    @slot('table_body')
                    @endslot
                @endcomponent
            </section>
        </div>
    </form>
@endsection

@push('after-script')
    <script src="{{ asset('js/jquery.validate.js') }}"></script>
    <script src="{{ asset('js/jquery.steps.min.js') }}"></script>

    <script>
        $.fn.dataTable.ext.errMode = 'none';

        let dataSelected = [],
            currentBobot = 100.0,
            kode_penyakit;
        const listOption = <?php echo json_encode($option); ?>;
        window.onload = function() {
            // addRow();
        };

        function addRow() {
            dataSelected.push({
                kode_gejala: '',
                kode_gejala_grup: '',
                nama_gejala: '',
                isManual: true,
                bobot: 0
            })
            renderRow()
        }

        function renderRow() {
            let newHtml = ''
            let no = 1
            dataSelected
                .forEach((element, index) => {
                    if (element.isManual) {
                        newHtml += `<div class="form-group col-md-6 ">
                        <label class="input-label">Gejala ${no}</label>
                        <input type="text" name="gejala1" onchange="handleChangeGejala(event,${index})" class="form-control" placeholder="Masukkan Gejala ${no}" value="${element.nama_gejala}">
                    </div>
                    <div class="form-group col-md-4 ">
                        <label class="input-label">Letak Gejala ${no}</label>
                        <select name="selectgejala1" onchange="handleChangeKelompokGejala(this.options[this.selectedIndex].value,${index})" class="form-control">
                        <option value='9'>Pilih Letak Gejala</option>
                        ${(listOption.map((item) => (
                            `<option value='${item.kode_gejala_grup}' ${(item.kode_gejala_grup === element.kode_gejala_grup && 'selected')}>${item.nama_gejala_grup}</option>`
                        )))}
                        </select>
                    </div>
                    <div class="form-group col-md-2 ">
                        <button type="button" class="btn btn-danger btn-sm mt-4" onclick="removeItemManul(${index})">Hapus Gejala ${no}</button>
                    </div>`
                    no++
                    }
                });
            document.getElementById("inputgejala").innerHTML = newHtml

        }

        function handleChangeGejala(e, index) {
            if (dataSelected.length === 0) {
                dataSelected[0] = {
                    nama_gejala: e.target.value,
                    kode_gejala_grup: '',
                    isManual: true
                }
            } else {

                dataSelected[index]['nama_gejala'] = e.target.value
            }
        }

        function handleChangeKelompokGejala(e, index) {
            if (dataSelected.length === 0) {
                dataSelected[0] = {
                    nama_gejala: e,
                    kode_gejala_grup: '',
                    isManual: true
                }
            } else {

                dataSelected[index]['kode_gejala_grup'] = e
            }
        }

        function removeItemManul(index) {
            dataSelected.splice(index, 1)
            renderRow()
        }

        function handleChangeBobot(value, index) {
            dataSelected[index].bobot = value
        }


        function handleClick(cb, kode_gejala, nama_gejala) {
            const getIndex = dataSelected.findIndex(item => item.kode_gejala === kode_gejala)
            if (getIndex === -1) {
                dataSelected.push({
                    kode_gejala,
                    nama_gejala,
                    isManual: false,
                    bobot: 0
                })
            } else {
                dataSelected.splice(getIndex, 1);

            }
            renderViewStep3()
        }

        function renderViewStep3() {
            let tmpView = ""
            dataSelected
                .filter((item) => {
                    return item.nama_gejala !== ""
                })
                .forEach((element, index) => {
                    tmpView += `<tr><td>${(index+1)}</td><td>${element.nama_gejala}</td>`
                    tmpView +=
                        `<td> 
                        <div class="form-group">
                            <br/>
                        <label>Pilih Bobot</label><br/>
                      <div class="selectgroup ">
                        <label class="selectgroup-item">
                          <input type="radio" name="value${index}" value="20" onchange="handleChangeBobot(20,${index})" class="selectgroup-input">
                          <span class="selectgroup-button">Sangat Rendah</span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="value${index}" value="40" onchange="handleChangeBobot(40,${index})" class="selectgroup-input">
                          <span class="selectgroup-button">Rendah</span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="value${index}" value="60" onchange="handleChangeBobot(60,${index})" class="selectgroup-input">
                          <span class="selectgroup-button">Menengah</span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="value${index}" value="80" onchange="handleChangeBobot(80,${index})" class="selectgroup-input">
                          <span class="selectgroup-button">Tinggi</span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="value${index}" value="100" onchange="handleChangeBobot(100,${index})" class="selectgroup-input">
                          <span class="selectgroup-button">Sangat Tinggi</span>
                        </label>
                      </div>
                    </div>
                    </td></tr>`
                });
            document.getElementById("table_body_bobot-table").innerHTML = tmpView
        }

        function handleChange(event, index) {
            let newValue = event.target.value
            newValue = (newValue === "" ? 0 : (Number(newValue) < 0 ? 0 : Number(newValue)))
            const selectItem = dataSelected[index]
            const lastBobot = currentBobot + selectItem.bobot
            if (newValue === 0) {
                document.getElementById("bobot_" + selectItem.kode_gejala).value = 0;

            } else if ((lastBobot - newValue) >= 0) {
                currentBobot = lastBobot - newValue
                dataSelected[index]['bobot'] = newValue
                document.getElementById("bobot_" + selectItem.kode_gejala).value = parseInt(newValue);
            } else {
                document.getElementById("bobot_" + selectItem.kode_gejala).value = selectItem.bobot;
            }
            document.getElementById("bobot_sisa").innerHTML = `<b>${currentBobot}/100</b>`
            document.getElementById("bobot_terpakai").innerHTML = `<b>${(100 - currentBobot)}/100</b>`
        }

        function hideLoading() {

            document.getElementById("panelLoader").style.display = "none";
            document.getElementById("panelLoader").style.visibility = "visible";
            document.getElementById("example-basic").style.visibility = "visible";
            document.getElementById("example-basic").style.display = "block";
        }

        function showLoading() {

            document.getElementById("example-basic").style.display = "none";
            document.getElementById("example-basic").style.visibility = "visible";
            document.getElementById("panelLoader").style.visibility = "visible";
            document.getElementById("panelLoader").style.display = "block";
        }

        function updatePanelLoading(title, subtitle) {
            document.getElementById("panelLoader").innerHTML = `<center><h2>${title}</h2><p>${subtitle}</p></center>`;
        }

        function sendData() {
            showLoading()
            const params = {
                kode_penyakit: document.getElementById("penyakit").value,
                deskripsi: document.getElementById("descpenyakit").value,
                solusi: document.getElementById("solusi").value,
                data: dataSelected
            }
            $.ajax({
                type: 'POST',
                url: "{{ route('aturan.store') }}",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: params,
                success: function(data) {
                    if (data.success) {
                        updatePanelLoading('Berhasil',
                            'Data telah tersimpan, silahkan menunggu konfirmasi dari admin, terima kasih atas partisipasi anda.')
                    } else {
                        updatePanelLoading('Gagal', data.message)
                        setTimeout(() => {
                            hideLoading()
                        }, 3000);
                    }
                }
            });
        }

        var form = $("#example-basic");
        form.validate({
            errorPlacement: function errorPlacement(error, element) {
                element.after(error);
            },
            rules: {}
        });
        form.children("div").steps({
            // enableAllSteps: true,
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",

            onStepChanging: function(event, currentIndex, newIndex) {
                form.validate().settings.ignore = ":disabled,:hidden";
                if (newIndex === 1) {
                    $('#gejala-table').DataTable({})
                }
                if (newIndex === 2) {
                    const cekDulu = dataSelected.filter((item) => {
                        return item.nama_gejala === ""
                    })
                    if (cekDulu.length === 0 && dataSelected.length !== 0) {
                        renderViewStep3()
                    } else {
                        alert('Data gejala yang dipilih masih kosong')
                        return false
                    }
                } else if (newIndex === 3) {
                    const cekDulu = dataSelected.filter((item) => {
                        return item.bobot === 0
                    })
                    if (cekDulu.length === 0) {
                        const tmpdataSelected = dataSelected.map((item) => {
                            item.bobot_text = parseBobotToText(item.bobot)
                            return item
                        })
                        $('#konfirmasi-table').DataTable({
                            data: tmpdataSelected,
                            columns: [{
                                    title: "Nama Gejala",
                                    data: "nama_gejala"
                                },
                                {
                                    title: "Bobot",
                                    data: "bobot_text",
                                },
                            ]
                        });
                    } else {
                        alert('Data bobot masih ada yang kosong, silahkan pilih terlebih dahulu')
                        return false
                    }
                }
                return form.valid();
            },
            onFinishing: function(event, currentIndex) {
                form.validate().settings.ignore = ":disabled";
                return form.valid();
            },
            onFinished: function(event, currentIndex) {
                sendData()

            }
        });
    </script>
@endpush
