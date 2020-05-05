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
</head>

<body class="hold-transition login-page">
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
                            <img src="{{ asset($foto->path) }}" alt="Toko Logo" width='140px' height='140px'>
                        @php
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

                <form action="recover-password.html" method="post">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Request new password</button>
                        </div>
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="login.html">Login</a>
                </p>
                <p class="mb-0">
                    <a href="register.html" class="text-center">Register a new membership</a>
                </p>
            </div>
        </div>
    </div>

    <script src="{{ asset('template_depan/default/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template_depan/default/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template_depan/default/dist/js/adminlte.min.js') }}"></script>

</body>

</html>