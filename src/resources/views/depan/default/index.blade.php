<!DOCTYPE html>
<html class="no-js css-menubar" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="bootstrap theme">
    <meta name="author" content="NickmanUiop">

    <title>Olshopedia</title>
    <script src="{{ asset('template/global/vendor/jquery/jquery.js') }}"></script>
    <script src="{{ asset('template/global/js/Plugin/sweetalert.js') }}"></script>
    <script src="{{ asset('alertifyjs/alertify.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('template_depan/default/bootstrap-3.3.7/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('alertifyjs/css/alertify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('alertifyjs/css/themes/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/vendor/bootstrap-select/bootstrap-select.css') }}">

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
                    <li><a href="#"><i class='fa fa-shopping-cart'></i> Cart</a></li>
                    <li><a href="#">Login</a></li>
                    <li><a href="#">Register</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                            aria-expanded="false"><i class='fa fa-user'></i> User <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Profil</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container" id='body-page'>
        @yield('isi')
    </div>


    <script src="{{ asset('template_depan/default/bootstrap-3.3.7/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('template/global/vendor/bootstrap-select/bootstrap-select.js') }}"></script>
    <script>

        $(document).ready(function(){
            $('#sorting').selectpicker({
                style: 'btn-outline btn-default'
            });
        });

    </script>
</body>

</html>
