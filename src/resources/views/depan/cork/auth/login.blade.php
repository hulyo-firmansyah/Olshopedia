@extends('depan.cork.index')
@section('page')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('d.home', ['domain_toko' => $toko->domain_toko]) }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page"><span>Login</span></li>
</ol>
@endsection
@section('isi')
<!--uiop-->
<style>
.login-form {
    margin-right: auto;
    margin-left: auto;
    max-width:480px;
    margin-top:35px;
}
.login-form .form-content{
    display: block;
    width: 100%;
    padding: 25px;
    background: #fff;
    text-align: center;
    border-radius: 15px;
    border: 1px solid #e0e6ed;
    -webkit-box-shadow: 0 4px 6px 0 rgba(85, 85, 85, 0.0901961), 0 1px 20px 0 rgba(0, 0, 0, 0.08), 0px 1px 11px 0px rgba(0, 0, 0, 0.06);
    -moz-box-shadow: 0 4px 6px 0 rgba(85, 85, 85, 0.0901961), 0 1px 20px 0 rgba(0, 0, 0, 0.08), 0px 1px 11px 0px rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 6px 0 rgba(85, 85, 85, 0.0901961), 0 1px 20px 0 rgba(0, 0, 0, 0.08), 0px 1px 11px 0px rgba(0, 0, 0, 0.06);
}
.login-form .form-content h1 {
    font-size: 32px;
    color: #3b3f5c;
}
.login-form .form-content > p {
    font-size: 13px;
    color: #888ea8;
    font-weight: 600;
    margin-bottom: 35px;
}
.login-form form .field-wrapper.input {
    padding: 11px 0px 16px 0;
    border-bottom: none;
    position: relative;
}
.login-form form .field-wrapper label {
    font-size: 10px;
    font-weight: 700;
    color: #3b3f5c;
    margin-bottom: 8px;
}
.login-form form .field-wrapper svg:not(.feather-eye) {
    position: absolute;
    left: 12px;
    color: #888ea8;
    fill: rgba(0, 23, 55, 0.08);
    width: 20px;
    height: 20px;
    top:46px;
}
.login-form form .field-wrapper input {
    display: inline-block;
    vertical-align: middle;
    border-radius: 6px;
    min-width: 50px;
    max-width: 635px;
    width: 100%;
    -ms-transition: all 0.2s ease-in-out 0s;
    transition: all 0.2s ease-in-out 0s;
    color: #3b3f5c;
    font-weight: 600;
    font-size: 16px;
    padding: 13px 35px 13px 46px;
}
.login-form form .field-wrapper svg.feather-eye {
    position: absolute;
    right: 13px;
    color: #888ea8;
    fill: rgba(0, 23, 55, 0.08);
    width: 17px;
    cursor: pointer;
    top:46px;
}
.login-form form .field-wrapper {
    width: 100%;
}
.login-form form .division {
    text-align: center;
    font-size: 13px;
    margin: 35px 0 38px 0;
}
.login-form form .social {
    text-align: center;
}
.login-form form .social a.social-fb {
    margin-right: 15px;
}
.login-form form .social a {
    background: transparent;
    box-shadow: none;
    border: 1px solid #e0e6ed;
    padding: 12px 10px;
    width: 181px;
}
.login-form p.signup-link {
    font-size: 14px;
    color: #3b3f5c;
    font-weight: 700;
    margin-bottom: 15px;
    text-align: center;
    margin-top: 50px;
}
.login-form form .field-wrapper button.btn {
    align-self: center;
    width: 100%;
    padding: 11px 14px;
    font-size: 16px;
    letter-spacing: 2px;
}
.login-form p.signup-link a {
    color: #1b55e2;
    border-bottom: 1px solid;
}
</style>
<div class='login-form'>
    <div class="form-content">
    
        <h1 class="">Login</h1>
        <p class="">Login to your account to continue.</p>
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
        
        <form class="text-left" action="{{ route('d.login', ['domain_toko' => $toko->domain_toko]) }}" method="post" id='formLogin'>
            {{ csrf_field() }}
            <div class="form">
    
                <div id="email-field" class="field-wrapper input">
                    <label for="email">EMAIL</label>
                    <svg style='top:52px' xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign register"><circle cx="12" cy="12" r="4"></circle><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path></svg>
                    <input id="email" name="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email">
                    <div class="invalid-feedback" id='error_email' style="display: @if ($errors->has('email')) block; @else none; @endif">{{ $errors->first('email') }}</div>
                </div>
    
                <div id="password-field" class="field-wrapper input mb-2">
                    <div class="d-flex justify-content-between">
                        <label for="password">PASSWORD</label>
                        <a href="auth_pass_recovery_boxed.html" class="forgot-pass-link">Forgot Password?</a>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    <input id="password" name="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password">
                    <div class="invalid-feedback" id='error_password' style="display:  @if ($errors->has('password')) block; @else none; @endif">{{ $errors->first('password') }}</div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </div>
                <div class="d-sm-flex justify-content-between">
                    <div class="field-wrapper">
                        <button type="submit" class="btn btn-primary" value="" id='btnSubmit'>Login</button>
                    </div>
                </div>
    
                <p class="signup-link">Not registered ? <a href="{{ route('d.register', ['domain_toko' => $toko->domain_toko]) }}">Create an account</a></p>
    
            </div>
        </form>
    
    </div> 
</div>
<script>
    $(document).ready(function(){

        $('#btnSubmit').on('click', function(e){
            e.preventDefault();
            let data = $('#formLogin').serializeArray();
            let error = 0;
            $.each(data, (i, v) => {
                if(v.value == ''){
                    if(v.name == 'password'){
                        $('#toggle-password').css('right', '35px');
                        $('#error_'+v.name).text('Password tidak boleh kosong!');
                    } else if(v.name == 'email'){
                        $('#error_'+v.name).text('Email tidak boleh kosong!');
                    }
                    $('#'+v.name).addClass('is-invalid');
                    $('#error_'+v.name).show();
                    error++;
                }
            });

            if(error === 0) $('#formLogin').submit();
        });

        $('#email').on('input', function(){
            if($(this).hasClass('is-invalid')){
                $(this).removeClass('is-invalid');
                $('#error_email').hide();
            }
        });

        $('#password').on('input', function(){
            if($(this).hasClass('is-invalid')){
                $(this).removeClass('is-invalid');
                $('#error_password').hide();
                $('#toggle-password').css('right', '13px');
            }
        });

        var togglePassword = document.getElementById("toggle-password");
        var formContent = document.getElementsByClassName('form-content')[0]; 
        var getFormContentHeight = formContent.clientHeight;

        var formImage = document.getElementsByClassName('form-image')[0];
        if (formImage) {
            var setFormImageHeight = formImage.style.height = getFormContentHeight + 'px';
        }
        if (togglePassword) {
            togglePassword.addEventListener('click', function() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
            });
        }
    });
</script>
<!--uiop-->
@endsection