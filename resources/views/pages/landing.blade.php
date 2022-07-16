<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

    <title>Homepage</title>

    @stack('before-style')
    @include('includes.main.style')
    @stack('after-style')
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <h2 class="section-title">List Artikel</h2>
            <div class="row">
                @foreach ($data as $item)
                    <div class="col-12 col-md-4 col-lg-4">
                        <article class="article article-style-c">
                            <div class="article-header">
                                <div class="article-image"
                                    data-background="https://cdn.pixabay.com/photo/2020/05/18/16/17/social-media-5187243_1280.png">
                                </div>
                            </div>
                            <div class="article-details">
                                <div class="article-title">
                                    <h2><a href="{{ url('detailartikel/' . $item->id) }}">{{ $item->judul_artikel }}</a>
                                    </h2>
                                </div>
                                <p>{{ $item->isi_artikel }}</p>
                                <div class="article-user">
                                    <img alt="image" src="https://demo.getstisla.com/assets/img/avatar/avatar-1.png">
                                    <div class="article-user-details">
                                        <div class="user-detail-name">
                                            <a href="#">{{ $item->penulis->nama }}</a>
                                        </div>
                                        <div class="text-job">{{ Helper::tanggal($item->tanggal) }}</div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</body>

@stack('before-script')
@include('includes.main.script')
@stack('after-script')

</html>
