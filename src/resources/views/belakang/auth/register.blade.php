<!DOCTYPE html>
<html class="no-js css-menubar" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="bootstrap admin template">
    <meta name="author" content="">

    <title>Olshopedia</title>

    <link rel="apple-touch-icon" href="{{ asset('template/assets/images/apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('template/assets/images/favicon.ico') }}">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('template/global/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/css/bootstrap-extend.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/css/site.min.css') }}">

    <!-- Plugins -->
    <link rel="stylesheet" href="{{ asset('template/global/vendor/animsition/animsition.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/vendor/asscrollable/asScrollable.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/vendor/switchery/switchery.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/vendor/intro-js/introjs.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/vendor/slidepanel/slidePanel.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/vendor/flag-icon-css/flag-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/examples/css/pages/register-v3.css') }}">


    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('template/global/fonts/web-icons/web-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/fonts/brand-icons/brand-icons.min.css') }}">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>

    <!--[if lt IE 9]>
    <script src="{{ asset('template/../global/vendor/html5shiv/html5shiv.min.js') }}"></script>
    <![endif]-->

    <!--[if lt IE 10]>
    <script src="{{ asset('template/../global/vendor/media-match/media.match.min.js') }}"></script>
    <script src="{{ asset('template/../global/vendor/respond/respond.min.js') }}"></script>
    <![endif]-->

    <!-- Scripts -->
    <script src="{{ asset('template/global/vendor/breakpoints/breakpoints.js') }}"></script>
    <script>
        Breakpoints();

    </script>
</head>

<body class="animsition page-register-v3 layout-full">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->


    <!-- Page -->
    <div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">>
        <div class="page-content vertical-align-middle animation-slide-top animation-duration-1">
            <div class="panel">
                <div class="panel-body">
                    <div class="brand">
                        <img class="brand-img" src="{{ asset('template/assets//images/logo-colored.png') }}" alt="...">
                        <h2 class="brand-text font-size-18">Olshopedia</h2>
                    </div>
                    @if ($danger = session('error'))
                    <div role="alert" class="alert alert-danger alert-dismissible">
                        <button aria-label="Close" data-dismiss="alert" class="close" type="button">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4>Error</h4>
                        <p>{{ $danger }}</p>
                    </div>
                    @endif
                    <form method="post" action="{{ route('b.register') }}">
                        {{ csrf_field() }}
                        <div class="form-group form-material floating{{ $errors->has('name') ? ' has-error' : '' }}"
                            data-plugin="formMaterial">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" />
                            <label class="floating-label">Full Name</label>
                            @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group form-material floating{{ $errors->has('username') ? ' has-error' : '' }}"
                            data-plugin="formMaterial">
                            <input type="text" class="form-control" name="username" value="{{ old('username') }}" />
                            <label class="floating-label">Username</label>
                            @if ($errors->has('username'))
                            <span class="help-block">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group form-material floating{{ $errors->has('email') ? ' has-error' : '' }}"
                            data-plugin="formMaterial">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" />
                            <label class="floating-label">Email</label>
                            @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group form-material floating{{ $errors->has('no_telp') ? ' has-error' : '' }}"
                            data-plugin="formMaterial">
                            <input type="number" class="form-control" name="no_telp" value="{{ old('no_telp') }}" />
                            <label class="floating-label">No Telephone</label>
                            @if ($errors->has('no_telp'))
                            <span class="help-block">
                                <strong>{{ $errors->first('no_telp') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group form-material floating{{ $errors->has('password') ? ' has-error' : '' }}"
                            data-plugin="formMaterial">
                            <input type="password" class="form-control" name="password" id='pass'/>
                            <label class="floating-label">Password</label>
                            @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group form-material floating" data-plugin="formMaterial">
                            <input type="password" class="form-control" name="password_confirmation" />
                            <label class="floating-label">Re-enter Password</label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block btn-lg mt-40">Register</button>
                    </form>
                    <p>Have account already? Please go to <a href="{{ route('b.login') }}">Login</a></p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page -->


    <!-- Core  -->
    <script src="{{ asset('template/global/vendor/babel-external-helpers/babel-external-helpers.js') }}"></script>
    <script src="{{ asset('template/global/vendor/jquery/jquery.js') }}"></script>
    <script src="{{ asset('template/global/vendor/popper-js/umd/popper.min.js') }}"></script>
    <script src="{{ asset('template/global/vendor/bootstrap/bootstrap.js') }}"></script>
    <script src="{{ asset('template/global/vendor/animsition/animsition.js') }}"></script>
    <script src="{{ asset('template/global/vendor/mousewheel/jquery.mousewheel.js') }}"></script>
    <script src="{{ asset('template/global/vendor/asscrollbar/jquery-asScrollbar.js') }}"></script>
    <script src="{{ asset('template/global/vendor/asscrollable/jquery-asScrollable.js') }}"></script>
    <script src="{{ asset('template/global/vendor/ashoverscroll/jquery-asHoverScroll.js') }}"></script>

    <!-- Plugins -->
    <script src="{{ asset('template/global/vendor/switchery/switchery.js') }}"></script>
    <script src="{{ asset('template/global/vendor/intro-js/intro.js') }}"></script>
    <script src="{{ asset('template/global/vendor/screenfull/screenfull.js') }}"></script>
    <script src="{{ asset('template/global/vendor/slidepanel/jquery-slidePanel.js') }}"></script>
    <script src="{{ asset('template/global/vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>
    <script src="{{ asset('js/password/password.min.js')}}"></script>

    <!-- Scripts -->
    <script src="{{ asset('template/global/js/Component.js') }}"></script>
    <script src="{{ asset('template/global/js/Plugin.js') }}"></script>
    <script src="{{ asset('template/global/js/Base.js') }}"></script>
    <script src="{{ asset('template/global/js/Config.js') }}"></script>

    <script src="{{ asset('template/assets/js/Section/Menubar.js') }}"></script>
    <script src="{{ asset('template/assets/js/Section/GridMenu.js') }}"></script>
    <script src="{{ asset('template/assets/js/Section/Sidebar.js') }}"></script>
    <script src="{{ asset('template/assets/js/Section/PageAside.js') }}"></script>
    <script src="{{ asset('template/assets/js/Plugin/menu.js') }}"></script>

    <script src="{{ asset('template/global/js/config/colors.js') }}"></script>
    <script src="{{ asset('template/assets/js/config/tour.js') }}"></script>
    <script>
        Config.set('assets', '../../assets');

    </script>

    <!-- Page -->
    <script src="{{ asset('template/assets/js/Site.js') }}"></script>
    <script src="{{ asset('template/global/js/Plugin/asscrollable.js') }}"></script>
    <script src="{{ asset('template/global/js/Plugin/slidepanel.js') }}"></script>
    <script src="{{ asset('template/global/js/Plugin/switchery.js') }}"></script>
    <script src="{{ asset('template/global/js/Plugin/jquery-placeholder.js') }}"></script>
    <script src="{{ asset('template/global/js/Plugin/material.js') }}"></script>

    <script>
        (function (document, window, $) {
            'use strict';

            var Site = window.Site;
            $(document).ready(function () {
                Site.run();

                $('#pass').password({
                    animate: false,
                    minimumLength: 0,
                    enterPass: '',
                    badPass: '<span class="red-800 font-size-14">The password is weak</span>',
                    goodPass: '<span class="yellow-800 font-size-14">Good password</span>',
                    strongPass: '<span class="green-700 font-size-14">Strong password</span>',
                    shortPass: ''
                });

            });
        })(document, window, jQuery);

    </script>
</body>

</html>
