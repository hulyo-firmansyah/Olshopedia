<!DOCTYPE html>
<html class="no-js css-menubar" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="bootstrap admin template">
    <meta name="author" content="NickmanUiop">

    <title>Olshopedia</title>
    <script src="{{ asset('template/global/js/Plugin/sweetalert.js') }}"></script>
    <script src="{{ asset('alertifyjs/alertify.min.js') }}"></script>
    <link rel="stylesheet"
        href="{{ asset('template_depan/'.$toko->template.'/bootstrap-3.3.7/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('alertifyjs/css/alertify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('alertifyjs/css/themes/bootstrap.min.css') }}">

    <link rel="apple-touch-icon" href="{{ asset('template/assets/images/apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('template/assets/images/favicon.ico') }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('template/global/fonts/font-awesome/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/fonts/web-icons/web-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/fonts/material-design/material-design.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/fonts/brand-icons/brand-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/fonts/glyphicons/glyphicons.css') }}">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>

</head>

<body>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">{{ $toko->nama_toko }}</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <!-- <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>
                </ul> -->
                <form class="navbar-form navbar-left">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Cari..">
                    </div>
                    <button type="submit" class="btn btn-default"><i class='fa fa-search'></i></button>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">Login</a></li>
                    <li><a href="#">Register</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                            aria-expanded="false">Dropdown <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class='row'>
            <div class='col-lg-6'>
                <h1 class="page-title font-size-26 font-weight-100">Katalog Produk</h1>
            </div>
            <div class='col-lg-6'>
                <div class='text-right' style='margin-top:25px'>
                    <div class='form-inline'>
                    Urutkan berdasarkan :
                    <select class='form-control'>
                        <option>addslashes</option>
                    </select>
                    </div>
                </div>
            </div>
        </div>
        <hr>

        <div class="row">
            @foreach(\App\Http\Controllers\PusatController::genArray($produk) as $p)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="thumbnail">
                    <img src="{{ asset('photo.png') }}" alt="..." width='240px' height='240px'>
                    <div class="caption">
                        <h3>{{ $p->nama_produk }}</h3>
                        @php
                            if($p->termurah !== $p->termahal){
                                @endphp
                                <p>{{ \App\Http\Controllers\PusatController::formatUang($p->termurah, true).' - '.\App\Http\Controllers\PusatController::formatUang($p->termahal, true) }}</p>
                                @php
                            } else {
                                @endphp
                                <p>{{ \App\Http\Controllers\PusatController::formatUang($p->termurah, true) }}</p>
                                @php
                            }
                        @endphp
                        <p>{{ $p->ket ?? '' }}</p>
                        <p class='text-right'>
                            <a href="#" class="btn btn-primary" role="button">Selengkapnya</a>
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>


    <script src="{{ asset('template/global/vendor/jquery/jquery.js') }}"></script>
    <script src="{{ asset('template_depan/'.$toko->template.'/bootstrap-3.3.7/js/bootstrap.min.js') }}"></script>
</body>

</html>