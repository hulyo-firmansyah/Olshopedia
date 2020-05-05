@extends('depan.default.index')
@section('isi')
<!--uiop-->
<style>
.login-page-div {
    -ms-flex-align:center;
    align-items:center;
    display:-ms-flexbox;
    display:flex;
    -ms-flex-direction: column;
    flex-direction: column;
    height: 85vh;
    -ms-flex-pack: center;
    justify-content: center;
}
</style>
<div class="content">
    <div class='login-page-div'>
        <div class="login-box">
            <div class="card">
                <div class="card-body login-card-body">
                    <h3 class="login-box-msg">Login</h3>
                    @if ($danger = session('error'))
                    <div role="alert" class="alert alert-danger alert-dismissible">
                        <button aria-label="Close" data-dismiss="alert" class="close" type="button">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4>Error</h4>
                        <p>{{ $danger }}</p>
                    </div>
                    @endif
                    @if ($warning = session('warning'))
                    <div role="alert" class="alert alert-warning alert-dismissible">
                        <button aria-label="Close" data-dismiss="alert" class="close" type="button">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4>Warning</h4>
                        <p>{{ $warning }}</p>
                    </div>
                    @endif
                    @if ($sukses = session('sukses'))
                    <div role="alert" class="alert alert-success alert-dismissible">
                        <button aria-label="Close" data-dismiss="alert" class="close" type="button">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4>Berhasil</h4>
                        <p>{!! $sukses !!}</p>
                    </div>
                    @endif
                    @if ($token = session('user_token'))
                    <input type="hidden" id="h_tokenEmail" value="{{$token}}">
                    @endif
                    <form action="{{ route('d.login', ['domain_toko' => $toko->domain_toko]) }}" method="post" id='formLogin'>
                        {{ csrf_field() }}
                        <div class="input-group">
                            <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" name='email'>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        @if ($errors->has('email'))
                        <small id="password-error" class="error invalid-feedback" style='display:block'>{{ $errors->first('email') }}</small>
                        @endif
                        <div class="input-group mt-3 mb-3">
                            <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" name='password'>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        @if ($errors->has('password'))
                        <small id="password-error" class="error invalid-feedback" style='display:block'>{{ $errors->first('password') }}</small>
                        @endif
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="remember" name='remember'>
                                    <label for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block" id='btnSubmit'>Login</button>
                            </div>
                        </div>
                    </form>
    
                    <!-- <div class="social-auth-links text-center mb-3">
                        <p>- OR -</p>
                        <a href="#" class="btn btn-block btn-primary">
                            <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                        </a>
                        <a href="#" class="btn btn-block btn-danger">
                            <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                        </a>
                    </div> -->
    
                    <p class="mb-1">
                        <a href="#">Lupa Password?</a>
                    </p>
                </div>
            </div>
            <div class='text-center'>
                Belum punya akun? <a href="{{ route('d.register', ['domain_toko' => $toko->domain_toko]) }}">Register</a>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        
        $('#btnSubmit').on('click', function(e){
            e.preventDefault();

            let data = $('#formLogin').serializeArray();
            $.each(data, (i, v) => {
                if(v.name === 'remember'){
                    $('#remember').val(v.value === 'on' ? 1 : 0);
                }
            });

            $('#formLogin').submit();
        });

            // Resend Email
            $('.resendMail').on('click', function () {
                $('#loader').css('display', 'flex');
                var hasil;
                var token = $('#h_tokenEmail').val();
                $.ajax({
                    type: 'post',
                    url: "{{ route('d.email-resendMail', ['domain_toko' => $toko->domain_toko]) }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        token: token,
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
                    if (hasil.status) {
                        $(document).Toasts('create', {
                            class: 'bg-success',
                            title: 'Berhasil',
                            autohide: true,
                            delay: 3000,
                            body: 'Berhasil mengirim ulang email verifikasi!'
                        });
                    } else {
                        $(document).Toasts('create', {
                            class: 'bg-danger',
                            title: 'Gagal',
                            autohide: true,
                            delay: 3000,
                            body: ''+hasil.msg
                        });
                    }
                }).fail(function () {});
            })
    });
</script>
<!--uiop-->
@endsection