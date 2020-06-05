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

                        <h1 class="">Password Recovery</h1>
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

                                <div id="email-field" class="field-wrapper input">
                                    <div class="d-flex justify-content-between">
                                        <label for="email">EMAIL</label>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign"><circle cx="12" cy="12" r="4"></circle><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path></svg>
                                    <input id="inputEmail" name="email" type="text" class="form-control" value="" placeholder="Email">
                                    <small id="error_email" style='color:#f2353c;display:none;'>Masukkan alamat email anda!</small>
                                </div>

                                <div class="d-sm-flex justify-content-between">

                                    <div class="field-wrapper">
                                        <button type="button" class="btn btn-primary" value="" id='btnResetPassword'>Reset</button>
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
            $("#inputEmail").keypress(function(e){
                if(e.keyCode == '13') {
                    $("#btnResetPassword").trigger('click');
                }
            });

            $('#inputEmail').on('input', function(){
                if($(this).val() == cache_email){
                    $('#btnResetPassword').text('Resend Email');
                } else {
                    $('#btnResetPassword').text('Reset Your Password');
                }
            });

            //Form Send Reset Password Email
            $("#btnResetPassword").on('click', function() {
                var hasil;
                var email = $('#inputEmail').val();
                var error = 0
                if (email == "") {
                    $('#inputEmail').addClass('is-invalid');
                    $('small#error_email').show();
                    error++;
                }
                if (error == 0){
                    $('#loader-div').css('display', 'flex');
                    $.ajax({
                        type: 'get',
                        url: "{{ route('d.password-email', ['domain_toko' => $toko->domain_toko]) }}",
                        data: {
                            email: email
                        },
                        success: function(data) {
                            hasil = data;
                        },
                        error: function(error, b, c) {
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
                    }).done(function() {
                        $('#loader-div').hide();
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
                            $('#btnResetPassword').text('Resend Email');
                            cache_email = hasil.email;
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