<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

    <title>Detail Artikel</title>

    @stack('before-style')
    @include('includes.main.style')
    @stack('after-style')
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <article class="article article-style-c">
                        <div class="article-header">
                            <div class="article-image"
                                data-background="https://cdn.pixabay.com/photo/2020/05/18/16/17/social-media-5187243_1280.png">
                            </div>
                        </div>
                        <div class="article-details">
                            <div class="article-title">
                                <h1>{{ $data->judul_artikel }}
                                </h1>
                            </div>
                            <p>{{ $data->isi_artikel }}</p>
                            <div class="article-user">
                                <img alt="image" src="https://demo.getstisla.com/assets/img/avatar/avatar-1.png">
                                <div class="article-user-details">
                                    <div class="user-detail-name">
                                        <a href="#">{{ $data->penulis->nama }}</a>
                                        <p>{{ $data->penulis->biografi }}</p>
                                    </div>
                                    <div class="text-job">{{ Helper::tanggal($data->tanggal) }}</div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Comments</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">
                                @foreach ($data->listkomentar as $items)
                                    <li class="media">
                                        <img alt="image" class="mr-3 rounded-circle" width="70"
                                            src="https://demo.getstisla.com/assets/img/avatar/avatar-3.png">
                                        <div class="media-body">
                                            <div class="media-title mb-1">{{ $items->komentar->nama }}</div>
                                            <div class="text-time">{{ Helper::waktu($items->komentar->waktu) }}</div>
                                            <div class="media-description text-muted">
                                                {{ $items->komentar->isi_komentar }}
                                            </div>

                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Buat Komentar</h4>
                        </div>
                        <div class="card-body">

                            <form method="POST" action="{{ url('kirimkomen/' . $data->id) }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Nama Anda') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="nama"
                                            value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email"
                                        class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="isi_komentar"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Isi Komentar') }}</label>

                                    <div class="col-md-6">
                                        <textarea id="isi_komentar" class="form-control @error('isi_komentar') is-invalid @enderror" name="isi_komentar"
                                            required>{{ old('isi_komentar') }}</textarea>

                                        @error('isi_komentar')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Kirim') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

@stack('before-script')
@include('includes.main.script')
@stack('after-script')

@push('after-script')
    @include('includes.lightbox')

    @include('includes.notification')

    @include('includes.confirm-modal')
@endpush

</html>
