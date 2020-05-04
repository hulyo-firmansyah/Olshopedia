<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>{{ $toko->nama_toko }}</title>

    <script src="{{ asset('template_depan/default/plugins/jquery/jquery.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('template_depan/default/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template_depan/default/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template_depan/default/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template_depan/default/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template_depan/default/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>
    #loader {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        background: rgba(0, 0, 0, 0.75);
        z-index: 10000;
        -ms-flex-align: center;
        align-items: center;
        -ms-flex-pack: center;
        justify-content: center;
    }
    </style>
</head>

<body class="hold-transition layout-top-nav">
    <div id="loader">
        <div class="text-center">
            <i class="fas fa-sync-alt fa-spin" style='font-size:5em;color:white;'></i>
        </div>
    </div>
    <div class="wrapper">
    

        <!-- header -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="{{ route('d.home', ['domain_toko' => $toko->domain_toko]) }}" class="navbar-brand">
                    @php
                        if(isset($toko->foto_id)){
                            $foto = \DB::table('t_foto')
                                ->where('data_of', \App\Http\Controllers\PusatController::dataOfByDomainToko($toko->domain_toko))
                                ->where('id_foto', $toko->foto_id)
                                ->get()->first();
                            if(isset($foto->path)){
                                @endphp
                                <img src="{{ asset($foto->path) }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                                    style="opacity: .8">
                                @php
                            }
                        }
                    @endphp
                    <span class="brand-text font-weight-light">{{ $toko->nama_toko }}</span>
                </a>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="{{ route('d.home', ['domain_toko' => $toko->domain_toko]) }}" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Kategori Produk</a>
                        </li>
                    </ul>
                    <form class="form-inline ml-0 ml-md-3">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" aria-label="Search" 
                                id='queryCari' placeholder="Cari.." value='@if($r["cari"] !== ""){{$r["cari"]}}@endif'>
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="button" id='btnCari'>
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    @php
                        $cart_count = count(\Cart::session(request()->getClientIp())->getContent());
                        $hidden = $cart_count > 0 ? '' : 'display:none;';
                    @endphp

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a href="{{ route('d.cart-index', ['domain_toko' => $toko->domain_toko]) }}" class="nav-link"><i class='fa fa-shopping-cart'></i> Cart<span class="badge badge-danger navbar-badge" style='{{ $hidden }}' id="badgeCart">{{ $cart_count }}</span></a>
                        </li>
                        @if(\Auth::check())
                            <li class="nav-item dropdown">
                                <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" class="nav-link dropdown-toggle">{{ \Auth::user()->name }}</a>
                                <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                                    <li><a href="#" class="dropdown-item">Some action </a></li>
                                    <li><a href="#" class="dropdown-item">Some other action</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li>
                                        <form id="logout-form" action="{{ route('d.logout', ['domain_toko' => $toko->domain_toko]) }}" method="post" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                        <a class="dropdown-item" href="{{ route('d.logout', ['domain_toko' => $toko->domain_toko]) }}" role="menuitem" 
                                            onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                            class="icon wb-power" aria-hidden="true"></i> Logout</a>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('d.login', ['domain_toko' => $toko->domain_toko]) }}" class="nav-link">Login</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('d.register', ['domain_toko' => $toko->domain_toko]) }}" class="nav-link">Register</a>
                            </li>
                        @endif
                    </ul>
                </div>

            </div>
        </nav>

        <!-- isi -->
        <div class="content-wrapper">
            @yield('isi')
        </div>

        <!-- footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
                Olshopedia
            </div>
            <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer>
    </div>

    <script src="{{ asset('template_depan/default/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template_depan/default/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('template_depan/default/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>

        function uangFormat(number) {
            var sp = number.toString().split("").reverse();
            var yt = 0;
            var te = "";
            $.each(sp, function(i, v) {
                if (yt === 3) {
                    te += ".";
                    yt = 0;
                }
                te += v;
                yt++;
            });
            var hasil = te.split("").reverse().join("");
            return hasil;
        }

        $(document).ready(function(){

            $('.angkaSaja').on('input', function(){
                this.value = this.value.replace(/[^0-9]/gi, '');
            });

            $('#btnCari').on('click', function(){
                $(location).attr('href', '{{ route("d.home", ["toko_slug" => $toko->domain_toko]) }}?q='+$('#queryCari').val()+'@if($r["sort"] !== "")&sort={{$r["sort"]}}@endif');
            });
        });

    </script>
</body>

</html>

            <!-- <div class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark"> Home </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">Layout</a></li>
                                <li class="breadcrumb-item active">Top Navigation</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container">
                </div>
            </div> -->