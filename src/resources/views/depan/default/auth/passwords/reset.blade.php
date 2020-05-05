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
                <p class="login-box-msg">You are only one step a way from your new password, recover your password now.
                </p>

                <form action="#" method="post">
                    <div class="input-group">
                        <input type="password" class="form-control" placeholder="Password" id='newPassword' name='password'>
                        <div class="input-group-append" style='cursor:pointer;' id='btnEye'>
                            <div class="input-group-text">
                                <span class="fas fa-eye"></span>
                            </div>
                        </div>
                    </div>
                    <small id="errorPass" style='color:#f2353c;display:none;'></small>
                    <div class="input-group mt-3">
                        <input type="password" class="form-control" placeholder="Confirm Password" id='re-password' name='password_confirmation'>
                        <div class="input-group-append" style='cursor:pointer;' id='btnEye2'>
                            <div class="input-group-text">
                                <span class="fas fa-eye"></span>
                            </div>
                        </div>
                    </div>
                    <small id="errorRe-Pass" style='color:#f2353c;display:none;'></small>
                    <div class="row mt-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block" id='btnRenewPassword'>Change password</button>
                        </div>
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="{{ route('d.login', ['domain_toko' => $toko->domain_toko]) }}">Login</a>
                </p>
            </div>
        </div>
    </div>

    <script src="{{ asset('template_depan/default/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template_depan/default/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template_depan/default/dist/js/adminlte.min.js') }}"></script>
                
    <script>
        $(document).ready(function () {

            $('#btnEye').click(function(){
                if($('#newPassword').attr('type') == 'password'){
                    $('#newPassword').attr('type', 'text');
                    $('#btnEye').find('span').attr('class', 'fas fa-eye-slash');
                } else if($('#newPassword').attr('type') == 'text'){
                    $('#newPassword').attr('type', 'password');
                    $('#btnEye').find('span').attr('class', 'fas fa-eye');
                }
            });

            $('#btnEye2').click(function(){
                if($('#re-password').attr('type') == 'password'){
                    $('#re-password').attr('type', 'text');
                    $('#btnEye2').find('span').attr('class', 'fas fa-eye-slash');
                } else if($('#re-password').attr('type') == 'text'){
                    $('#re-password').attr('type', 'password');
                    $('#btnEye2').find('span').attr('class', 'fas fa-eye');
                }
            });

            $('#re-password').on('input', function(){
                if($('#re-password').hasClass('is-invalid')){
                    $('#re-password').removeClass('is-invalid');
                    $('small#errorRe-Pass').hide();
                }
            });

            $('#newPassword').on('input', function(){
                if($('#newPassword').hasClass('is-invalid')){
                    $('#newPassword').removeClass('is-invalid');
                    $('small#errorPass').hide();
                }
            });


            //Form Send Reset Password Email
            $("#btnRenewPassword").on('click', function (e) {
                e.preventDefault();
                var hasil;
                var newPass = $('#newPassword').val();
                var retypePass = $('#re-password').val();
                var error = 0;
                if (newPass == '') {
                    $('#newPassword').addClass('is-invalid');
                    $('small#errorPass').text('Masukkan password baru!');
                    $('small#errorPass').show();
                    error++
                }
                if (retypePass == '') {
                    $('#re-password').addClass('is-invalid');
                    $('small#errorRe-Pass').text('Masukkan password konfirmasi!');
                    $('small#errorRe-Pass').show();
                    error++
                }
                if (newPass != retypePass) {
                    $('#re-password').addClass('is-invalid');
                    $('small#errorRe-Pass').text('Password tidak sama!');
                    $('small#errorRe-Pass').show();
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
                            $(document).Toasts('create', {
                                class: 'bg-danger',
                                title: 'Error',
                                autohide: true,
                                delay: 3000,
                                body: ''+c
                            });
                        }
                    }).done(function () {
                        $('#loader').hide();
                        if (hasil.status.data) {
                            $(document).Toasts('create', {
                                class: 'bg-success',
                                title: 'Berhasil',
                                autohide: true,
                                delay: 3000,
                                body: ''+hasil.status.pesan
                            });
                            setTimeout(function() {
                                $(location).attr('href', '{{ route("d.login", ["domain_toko" => $toko->domain_toko]) }}');
                            }, 3050);
                        } else {
                            $(document).Toasts('create', {
                                class: 'bg-danger',
                                title: 'Gagal',
                                autohide: true,
                                delay: 3000,
                                body: ''+hasil.status.pesan
                            });
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>