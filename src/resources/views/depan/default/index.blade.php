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
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Project name</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                            aria-expanded="false">Dropdown <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li role="separator" class="divider"></li>
                            <li class="dropdown-header">Nav header</li>
                            <li><a href="#">Separated link</a></li>
                            <li><a href="#">One more separated link</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="../navbar/">Default</a></li>
                    <li><a href="../navbar-static-top/">Static top</a></li>
                    <li class="active"><a href="./">Fixed top <span class="sr-only">(current)</span></a></li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container">

        <!-- Main component for a primary marketing message or call to action -->
        <div class="jumbotron">
            <h1>Navbar example</h1>
            <p>This example is a quick exercise to illustrate how the default, static and fixed to top navbar work. It
                includes the responsive CSS and HTML, so it also adapts to your viewport and device.</p>
            <p>To see the difference between static and fixed top navbars, just scroll.</p>
            <p>
                <a class="btn btn-lg btn-primary" href="../../components/#navbar" role="button">View navbar docs
                    &raquo;</a>
            </p>
        </div>

    </div> <!-- /container -->


    <script src="{{ asset('template/global/vendor/jquery/jquery.js') }}"></script>
    <script src="{{ asset('template_depan/'.$toko->template.'/bootstrap-3.3.7/js/bootstrap.min.js') }}"></script>
</body>

</html>