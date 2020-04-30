@extends('depan.default.index')
@section('isi')
<!--uiop-->
<style>
.register-page-div {
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
    <div class='register-page-div'>
        <div class="register-box">
            <div class="card">
                <div class="card-body register-card-body">
                    <p class="login-box-msg">Register Pelanggan</p>
                    @if ($danger = session('error'))
                    <div role="alert" class="alert alert-danger alert-dismissible">
                        <button aria-label="Close" data-dismiss="alert" class="close" type="button">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4>Error</h4>
                        <p>{{ $danger }}</p>
                    </div>
                    @endif
                    <form action="{{ route('d.register', ['domain_toko' => $toko->domain_toko]) }}" method="post">
                        {{ csrf_field() }}
                        <div class="input-group">
                            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name='name' placeholder="Nama Lengkap" value='{{ old("name") }}' >
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        @if ($errors->has('name'))
                        <small id="name-error" class="error invalid-feedback" style='display:block'>{{ $errors->first('name') }}</small>
                        @endif
                        <div class="input-group mt-3">
                            <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" name='email' value='{{ old("email") }}' >
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        @if ($errors->has('email'))
                        <small id="email-error" class="error invalid-feedback" style='display:block'>{{ $errors->first('email') }}</small>
                        @endif
                        <div class="input-group mt-3">
                            <input type="text" class="form-control angkaSaja{{ $errors->has('no_telp') ? ' is-invalid' : '' }}" placeholder="No Telepon" name='no_telp' value='{{ old("no_telp") }}' >
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-phone"></span>
                                </div>
                            </div>
                        </div>
                        @if ($errors->has('no_telp'))
                        <small id="no_telp-error" class="error invalid-feedback" style='display:block'>{{ $errors->first('no_telp') }}</small>
                        @endif
                        <div class="input-group mt-3">
                            <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" name='password' value='{{ old("password") }}' >
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        @if ($errors->has('password'))
                        <small id="password-error" class="error invalid-feedback" style='display:block'>{{ $errors->first('password') }}</small>
                        @endif
                        <div class="input-group mt-3 mb-3">
                            <input type="password" class="form-control" placeholder="Ulangi password" name='password_confirmation' >
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="agreeTerms" name="terms" >
                                    <label for="agreeTerms">
                                        I agree to the <a href="#">terms</a>
                                    </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">Register</button>
                            </div>
                        </div>
                    </form>
            
                    <!-- <div class="social-auth-links text-center">
                        <p>- OR -</p>
                        <a href="#" class="btn btn-block btn-primary">
                            <i class="fab fa-facebook mr-2"></i>
                            Sign up using Facebook
                        </a>
                        <a href="#" class="btn btn-block btn-danger">
                            <i class="fab fa-google-plus mr-2"></i>
                            Sign up using Google+
                        </a>
                    </div> -->
            
                </div>
            </div>
            <div class='text-center'>
                Sudah punya akun? <a href="#">Login</a>
            </div>
        </div>
    </div>
</div>
<!--uiop-->
@endsection