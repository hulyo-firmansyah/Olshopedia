@if (Session::get('dari_ajax_butuh_login') === true)
dari_ajax_butuh_login
@else
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
    <link rel="stylesheet" href="{{ asset('template/assets/examples/css/pages/login-v3.css') }}">


    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('template/global/fonts/web-icons/web-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/fonts/brand-icons/brand-icons.min.css') }}">
    <link rel='stylesheet' href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic') }}">

    <!-- Style Page Loader -->
    <style type="text/css">
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
        }
    </style>

    <!--[if lt IE 9]>
    <script src="{{ asset('template/global/vendor/html5shiv/html5shiv.min.js') }}"></script>
    <![endif]-->

    <!--[if lt IE 10]>
    <script src="{{ asset('template/global/vendor/media-match/media.match.min.js') }}"></script>
    <script src="{{ asset('template/global/vendor/respond/respond.min.js') }}"></script>
    <![endif]-->

    <!-- Scripts -->
    <script src="{{ asset('template/global/vendor/breakpoints/breakpoints.js') }}"></script>
    <script>
        Breakpoints();

    </script>
</head>

<body class="animsition page-login-v3 layout-full">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    {{-- Page Loader --}}
    {{-- <div class="example-loading example-well vertical-align text-center layout-full" id="page-loader">
        <div class="loader vertical-align-middle loader-tadpole"></div>
    </div> --}}
    <div id="loader">
        <div class="layout-full vertical-align text-center">
            <div class="loader vertical-align-middle loader-cube"></div>
        </div>
    </div>

    <!-- Page -->
    <div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">
        <div class="page-content vertical-align-middle animation-slide-top animation-duration-1">
            <div class="panel">
                <div class="panel-body">
                    <div class="brand">
                        <img class="brand-img" src="{{ asset('template/assets//images/logo-colored.png') }}" alt="...">
                        <h2 class="brand-text font-size-18">Olshopedia</h2>
                    </div>
                    @if ($success = session('success'))
                    <div role="alert" class="alert alert-success alert-dismissible"><button aria-label="Close"
                            data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                        <h4>Success</h4>
                        <p>{!! $success !!}</p>
                    </div>
                    @endif
                    @if ($warning = session('warning'))
                    <div role="alert" class="alert alert-warning alert-dismissible">
                        <button aria-label="Close" data-dismiss="alert" class="close" type="button">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4>Some Message</h4>
                        <p>{{ $warning }}.</p>
                    </div>
                    @endif
                    @if ($danger = session('error'))
                    <div role="alert" class="alert alert-danger alert-dismissible">
                        <button aria-label="Close" data-dismiss="alert" class="close" type="button">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4>Error</h4>
                        <p>{{ $danger }}.</p>
                    </div>
                    @endif
                    @if ($token = session('user_token'))
                    <input type="hidden" id="h_tokenEmail" value="{{$token}}">
                    @endif
                    <form method="post" action="{{ route('b.login') }}">
                        {{ csrf_field() }}
                        <div class="form-group form-material floating{{ $errors->has('email') ? ' has-error' : '' }}"
                            data-plugin="formMaterial">
                            <input type="text" class="form-control" name="email" value="{{ old('email') }}" />
                            <label class="floating-label">Email or Phone or Username</label>
                            @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group form-material floating{{ $errors->has('password') ? ' has-error' : '' }}"
                            data-plugin="formMaterial">
                            <input type="password" class="form-control" name="password" />
                            <label class="floating-label">Password</label>
                            @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group clearfix">
                            <div class="checkbox-custom checkbox-inline checkbox-primary checkbox-lg float-left">
                                <input type="checkbox" id="inputCheckbox" name="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label for="inputCheckbox">Remember me</label>
                            </div>
                            <a class="float-right" href="{{ route('b.password-forgotPassword') }}">Forgot password?</a>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg mt-40">Login</button>
                    </form>
                    <p>Still no account? Please go to <a href="{{ route('b.register') }}">Register</a></p>
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
    <script src="{{ asset('template/global/js/Plugin/sweetalert.js') }}"></script>
    <script src="{{ asset('template/global/vendor/screenfull/screenfull.js') }}"></script>
    <script src="{{ asset('template/global/vendor/slidepanel/jquery-slidePanel.js') }}"></script>
    <script src="{{ asset('template/global/vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>

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
            });

            // Resend Email
            $('.resendMail').on('click', function () {
                $('#loader').show();
                var hasil;
                var token = $('#h_tokenEmail').val();
                $.ajax({
                    type: 'get',
                    url: "{{ route('b.email-resendMail') }}",
                    data: {
                        token: token,
                    },
                    success: function (data) {
                        hasil = data;
                    },
                    error: function (error, b, c) {
                        swal("Error", '' + c, "error")
                    }
                }).done(function () {
                    $('#loader').hide();
                    if (hasil.sukses) {
                        swal("Berhasil!", "Email autentikasi berhasil dikirim!", "success");
                    } else {
                        swal("Gagal!", "" + hasil.msg, "error");
                    }
                }).fail(function () {});
            })

        })(document, window, jQuery);

    </script>
</body>

</html>
@endif