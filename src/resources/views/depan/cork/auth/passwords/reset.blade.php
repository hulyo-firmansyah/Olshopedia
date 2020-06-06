<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>{{ $toko->nama_toko }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('template_depan/cork/assets/img/favicon.ico') }}"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('template_depan/cork/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template_depan/cork/assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template_depan/cork/assets/css/authentication/form-2.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('template_depan/cork/assets/css/forms/theme-checkbox-radio.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('template_depan/cork/assets/css/forms/switches.css') }}">
    <script src="{{ asset('template_depan/cork/plugins/sweetalerts/promise-polyfill.js') }}"></script>
    <link href="{{ asset('template_depan/cork/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template_depan/cork/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template_depan/cork/assets/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <style>
    #loader-div {
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
<body class="form no-image-content">
    <div id="loader-div">
        <div class="text-center">
            <div class="spinner-border align-self-center loader-lg" style='color:white;width:100px;height:100px'></div>
        </div>
    </div>
    
    <div class="form-container outer">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">

                        <h1 class="">Change Password</h1>
                        <p class="signup-link recovery">Enter your email and instructions will sent to you!</p>
                        @if ($error = session('error_msg'))
                        <div role="alert" class="alert alert-danger alert-dismissible">
                            <button aria-label="Close" data-dismiss="alert" class="close" type="button">
                                <span aria-hidden="true">×</span>
                            </button>
                            <h4>Some Message</h4>
                            <p style='color:black;'>{{ $error }}</p>
                        </div>
                        @endif
                        <form class="text-left">
                            <div class="form">

                                <div id="password-field" class="field-wrapper input">
                                    <div class="d-flex justify-content-between">
                                        <label for="password">PASSWORD</label>
                                    </div>
                                    <svg style='top:46px;' xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <input id="password" name="password" type="password" class="form-control" value="" placeholder="Password">
                                    <small id="errorPass" style='color:#f2353c;display:none;'></small>
                                    <svg style='top:46px;' xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </div>

                                <div id="re-password-field" class="field-wrapper input mb-2">
                                    <div class="d-flex justify-content-between">
                                        <label for="re-password">PASSWORD CONFIRMATION</label>
                                    </div>
                                    <svg style='top:46px;' xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <input id="re-password" name="password_confirmation" type="password" class="form-control" value="" placeholder="Password Confirmation">
                                    <small id="errorRe-Pass" style='color:#f2353c;display:none;'></small>
                                    <svg style='top:46px;' xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password2" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </div>

                                <div class="d-sm-flex justify-content-between">

                                    <div class="field-wrapper">
                                        <button type="button" class="btn btn-primary" value="" id='btnRenewPassword'>Ganti Password</button>
                                    </div>
                                </div>

                                <p class="signup-link">
                                    Belum punya akun?, <a href="{{ route('d.register', ['domain_toko' => $toko->domain_toko]) }}">Register</a><br>
                                    atau <a href="{{ route('d.login', ['domain_toko' => $toko->domain_toko]) }}">Login</a> jika sudah punya akun.
                                </p>

                            </div>
                        </form>

                    </div>                    
                </div>
            </div>
        </div>
    </div>

    
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('template_depan/cork/assets/js/libs/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('template_depan/cork/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('template_depan/cork/bootstrap/js/bootstrap.min.js') }}"></script>
    
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('template_depan/cork/assets/js/authentication/form-2.js') }}"></script>
    <script src="{{ asset('template_depan/cork/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('template_depan/cork/plugins/sweetalerts/custom-sweetalert.js') }}"></script>

    <script>
        var cache_email = null;

        $(document).ready(function(){
            $('#toggle-password').on('click', function(){
                if($('#password').attr('type') == 'password'){
                    $('#password').attr('type', 'text');
                } else {
                    $('#password').attr('type', 'password');
                }
            });

            $('#toggle-password2').on('click', function(){
                if($('#re-password').attr('type') == 'password'){
                    $('#re-password').attr('type', 'text');
                } else {
                    $('#re-password').attr('type', 'password');
                }
            });

            $('#re-password').on('input', function(){
                if($('#re-password').hasClass('is-invalid')){
                    $('#re-password').removeClass('is-invalid');
                    $('small#errorRe-Pass').hide();
                    $('#toggle-password2').css('right', '13px');
                }
            });

            $('#password').on('input', function(){
                if($('#password').hasClass('is-invalid')){
                    $('#password').removeClass('is-invalid');
                    $('small#errorPass').hide();
                    $('#toggle-password').css('right', '13px');
                }
            });

            //Form Send Reset Password Email
            $("#btnRenewPassword").on('click', function (e) {
                e.preventDefault();
                var hasil;
                var newPass = $('#password').val();
                var retypePass = $('#re-password').val();
                var error = 0;
                if (newPass == '') {
                    $('#password').addClass('is-invalid');
                    $('small#errorPass').text('Masukkan password baru!');
                    $('small#errorPass').show();
                    $('#toggle-password').css('right', '32px');
                    error++
                }
                if (retypePass == '') {
                    $('#re-password').addClass('is-invalid');
                    $('small#errorRe-Pass').text('Masukkan password konfirmasi!');
                    $('small#errorRe-Pass').show();
                    $('#toggle-password2').css('right', '32px');
                    error++
                }
                if (newPass != retypePass) {
                    $('#re-password').addClass('is-invalid');
                    $('small#errorRe-Pass').text('Password tidak sama!');
                    $('small#errorRe-Pass').show();
                    $('#toggle-password2').css('right', '32px');
                    error++;
                }
                // return;
                if (error == 0) {
                    $('#loader').css('display', 'flex');
                    $.ajax({
                        type: 'get',
                        url: "{{ route('d.password-renewPassword', ['domain_toko' => $toko->domain_toko]) }}",
                        data: {
                            newPass : newPass,
                            re_newPass : retypePass,
                            email : '{{$user_mail}}',
                        },
                        success: function (data) {
                            hasil = data;
                        },
                        error: function (error, b, c) {
                            const toast = swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 10000,
                                padding: '2em'
                            });
                            toast({
                                type: 'error',
                                title: ''+c,
                                padding: '2em',
                            });
                        }
                    }).done(function () {
                        $('#loader').hide();
                        const toast = swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 10000,
                            padding: '2em'
                        });
                        if (hasil.status.data) {
                            toast({
                                type: 'success',
                                title: ''+hasil.status.pesan,
                                padding: '2em',
                            });
                            setTimeout(function() {
                                $(location).attr('href', '{{ route("d.login", ["domain_toko" => $toko->domain_toko]) }}');
                            }, 3050);
                        } else {
                            toast({
                                type: 'error',
                                title: ''+hasil.status.pesan,
                                padding: '2em',
                            });
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>