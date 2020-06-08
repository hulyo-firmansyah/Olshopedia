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
    <link rel="stylesheet" href="{{ asset('template/assets/examples/css/pages/forgot-password.css') }}">

    <!-- Fonts -->

    <link rel="stylesheet" href="{{ asset('template/global/fonts/material-design/material-design.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/fonts/web-icons/web-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/fonts/brand-icons/brand-icons.min.css') }}">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>

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

<body class="animsition page-forgot-password layout-full">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <div id="loader">
        <div class="layout-full vertical-align text-center">
            <div class="loader vertical-align-middle loader-cube"></div>
        </div>
    </div>

    <!-- Page -->
    <div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">
        <div class="page-content vertical-align-middle animation-slide-top animation-duration-1">
            <h2>Renew Password!</h2>
            <p>Input your new password</p>
            <form id="formResetEmail">
                <div class="form-group">
                    <div class="input-search">
                        <button type="button" class="input-search-btn" style='cursor:pointer;' id='btnEye' tabindex='-1'><i class="icon md-eye" aria-hidden="true"></i></button>
                        <input type="password" class="form-control" id="newPassword" placeholder="New Password">
                        <small id="errorPass" style='color:#f2353c;display:none;'></small>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-search">
                        <button type="button" class="input-search-btn" style='cursor:pointer;' id='btnEye2' tabindex='-1'><i class="icon md-eye" aria-hidden="true"></i></button>
                        <input type="password" class="form-control" id="re-password" placeholder="Re-Password">
                        <small id="errorRe-Pass" style='color:#f2353c;display:none;'></small>
                    </div>
                </div>
                <div class="form-group">
                    <button type="button" id="btnRenewPassword" class="btn btn-primary btn-block btn-round">Renew Your Password</button>
                </div>
            </form>
            <p>Have account already? Please go to <a href="{{ route('b.login') }}">Sign In</a></p>

            <footer class="page-copyright">
                <p>Olshopedia</p>
                <p>© 2020. All RIGHT RESERVED.</p>
            </footer>
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

    <script>
        $(document).ready(function () {

            $('#btnEye').click(function(){
                if($('#newPassword').attr('type') == 'password'){
                    $('#newPassword').attr('type', 'text');
                    $('#btnEye').children().attr('class', 'icon md-eye-off');
                } else if($('#newPassword').attr('type') == 'text'){
                    $('#newPassword').attr('type', 'password');
                    $('#btnEye').children().attr('class', 'icon md-eye');
                }
            });

            $('#btnEye2').click(function(){
                if($('#re-password').attr('type') == 'password'){
                    $('#re-password').attr('type', 'text');
                    $('#btnEye2').children().attr('class', 'icon md-eye-off');
                } else if($('#re-password').attr('type') == 'text'){
                    $('#re-password').attr('type', 'password');
                    $('#btnEye2').children().attr('class', 'icon md-eye');
                }
            });

            $('#re-password').on('input', function(){
                if($('#re-password').hasClass('is-invalid')){
                    $('#re-password').removeClass('is-invalid');
                    $('#re-password').removeClass('animation-shake');
                    $('small#errorRe-Pass').hide();
                }
            });

            $('#newPassword').on('input', function(){
                if($('#newPassword').hasClass('is-invalid')){
                    $('#newPassword').removeClass('is-invalid');
                    $('#newPassword').removeClass('animation-shake');
                    $('small#errorPass').hide();
                }
            });

            //Form Send Reset Password Email
            $("#btnRenewPassword").on('click', function () {
                var hasil;
                var newPass = $('#newPassword').val();
                var retypePass = $('#re-password').val();
                var error = 0;
                if (newPass == '') {
                    $('#newPassword').addClass('is-invalid animation-shake');
                    $('small#errorPass').attr('style', 'color:#f2353c');
                    $('small#errorPass').text('Masukkan password baru!');
                    $('small#errorPass').show();
                    error++
                }
                if (newPass != retypePass) {
                    $('#re-password').addClass('is-invalid animation-shake');
                    $('small#errorRe-Pass').attr('style', 'color:#f2353c');
                    $('small#errorRe-Pass').text('Password tidak sama!');
                    $('small#errorRe-Pass').show();
                    error++;
                }
                if (error == 0) {
                    $('#loader').show();
                    $.ajax({
                        type: 'get',
                        url: "{{ route('b.password-renewPassword') }}",
                        data: {
                            newPass : newPass,
                            email : '{{$user_mail}}',
                        },
                        success: function (data) {
                            hasil = data;
                        },
                        error: function (error, b, c) {
                            swal("Error", '' + c, "error");
                        }
                    }).done(function () {
                        $('#loader').hide();
                        if (hasil.status.data) {
                            swal({
                                title: "Berhasil!",
                                text: hasil.status.pesan,
                                icon: "success"
                            }).then(function (){
                                $(location).attr('href', '{{ route("b.login") }}');
                            });
                        } else {
                            swal("Gagal", "Gagal mengubah password", "error");
                        }
                    });
                }
            });

        });
        (function (document, window, $) {
            'use strict';

            var Site = window.Site;
            $(document).ready(function () {
                Site.run();
            });

        })(document, window, jQuery);
    </script>
</body>

</html>
