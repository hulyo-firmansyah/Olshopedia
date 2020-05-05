<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $toko->nama_toko }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('template_depan/default/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('template_depan/default/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template_depan/default/dist/css/adminlte.min.css') }}">
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

<body class="hold-transition login-page">
    <div id="loader">
        <div class="text-center">
            <i class="fas fa-sync-alt fa-spin" style='font-size:5em;color:white;'></i>
        </div>
    </div>
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('d.home', ['domain_toko' => $toko->domain_toko]) }}">
            @php
                if(isset($toko->foto_id)){
                    $foto = \DB::table('t_foto')
                        ->where('data_of', \App\Http\Controllers\PusatController::dataOfByDomainToko($toko->domain_toko))
                        ->where('id_foto', $toko->foto_id)
                        ->get()->first();
                    if(isset($foto->path)){
                        @endphp
                            <img src="{{ asset($foto->path) }}" alt="Toko Logo" width='140px' height='140px'><br>
                        @php
                        echo $toko->nama_toko;
                    } else {
                        echo $toko->nama_toko;
                    }
                } else {
                    echo $toko->nama_toko;
                }
            @endphp
            </a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

                @if ($error = session('error_msg'))
                <div role="alert" class="alert alert-danger alert-dismissible">
                    <button aria-label="Close" data-dismiss="alert" class="close" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4>Some Message</h4>
                    <p style='color:black;'>{{ $error }}</p>
                </div>
                @endif
                <!-- <form action="recover-password.html" method="post"> -->
                    <div class="input-group">
                        <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email" autocomplete='off'>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <small id="error_email" style='color:#f2353c;display:none;'>Masukkan alamat email anda!</small>
                    <div class="row mt-3">
                        <div class="col-12">
                            <button type="button" id="btnResetPassword" class="btn btn-primary btn-block">Reset Your Password</button>
                        </div>
                    </div>
                <!-- </form> -->

                <p class="mt-3 mb-1">
                    <a href="{{ route('d.login', ['domain_toko' => $toko->domain_toko]) }}">Login</a>
                </p>
                <p class="mb-0">
                    <a href="{{ route('d.register', ['domain_toko' => $toko->domain_toko]) }}" class="text-center">Register a new membership</a>
                </p>
            </div>
        </div>
    </div>

    <script src="{{ asset('template_depan/default/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template_depan/default/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template_depan/default/dist/js/adminlte.min.js') }}"></script>
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
                    $('#loader').css('display', 'flex');
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
                            $(document).Toasts('create', {
                                class: 'bg-danger',
                                title: 'Error',
                                autohide: true,
                                delay: 3000,
                                body: ''+c
                            });
                        }
                    }).done(function() {
                        $('#loader').hide();
                        if (hasil.status.data) {
                            $(document).Toasts('create', {
                                class: 'bg-success',
                                title: 'Berhasil',
                                autohide: true,
                                delay: 3000,
                                body: ''+hasil.status.pesan
                            });
                            $('#btnResetPassword').text('Resend Email');
                            cache_email = hasil.email;
                        } else {
                            $(document).Toasts('create', {
                                class: 'bg-danger',
                                title: 'Gagal',
                                autohide: true,
                                delay: 3000,
                                body: ''+hasil.status.pesan
                            });
                        }
                        $('#inputEmail').val('');
                    });
                }
            });

        });
    </script>

</body>

</html>