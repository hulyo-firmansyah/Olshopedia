@extends('depan.cork.index')
@section('page')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('d.home', ['domain_toko' => $toko->domain_toko]) }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page"><span>Register</span></li>
</ol>
@endsection
@section('isi')
<!--uiop-->
<style>
.register-form {
    margin-right: auto;
    margin-left: auto;
    max-width:480px;
    margin-top:35px;
}
.register-form .form-content{
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
.register-form form .field-wrapper {
    width:100%;
}
.register-form .form-content h1 {
    font-size: 32px;
    color: #3b3f5c;
}
.register-form .form-content > p {
    font-size: 13px;
    color: #888ea8;
    font-weight: 600;
    margin-bottom: 35px;
}
.register-form form .field-wrapper.input {
    padding: 11px 0px 16px 0;
    border-bottom: none;
    position: relative;
}
.register-form form .field-wrapper label {
    font-size: 10px;
    font-weight: 700;
    color: #3b3f5c;
    margin-bottom: 8px;
}
.register-form form .field-wrapper svg:not(.feather-eye) {
    position: absolute;
    left: 12px;
    color: #888ea8;
    fill: rgba(0, 23, 55, 0.08);
    width: 20px;
    height: 20px;
    top:46px;
}
.register-form form .field-wrapper input {
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
.register-form form .field-wrapper svg.feather-eye {
    position: absolute;
    right: 13px;
    color: #888ea8;
    fill: rgba(0, 23, 55, 0.08);
    width: 17px;
    cursor: pointer;
    top:46px;
}
.register-form form .field-wrapper {
    width: 100%;
}
.register-form form .division {
    text-align: center;
    font-size: 13px;
    margin: 35px 0 38px 0;
}
.register-form form .social {
    text-align: center;
}
.register-form form .social a.social-fb {
    margin-right: 15px;
}
.register-form form .social a {
    background: transparent;
    box-shadow: none;
    border: 1px solid #e0e6ed;
    padding: 12px 10px;
    width: 181px;
}
.register-form p.signup-link {
    font-size: 14px;
    color: #3b3f5c;
    font-weight: 700;
    margin-bottom: 15px;
    text-align: center;
    margin-top: 50px;
}
.register-form form .field-wrapper button.btn {
    align-self: center;
    width: 100%;
    padding: 11px 14px;
    font-size: 16px;
    letter-spacing: 2px;
}
.register-form form p.signup-link a {
    color: #1b55e2;
    border-bottom: 1px solid;
}
.register-form form .field-wrapper .n-chk .new-control-indicator {
    top: 2px;
    border: 1px solid #bfc9d4;
    background-color: #f1f2f3;
}
.register-form form .field-wrapper input {
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
.register-form form .field-wrapper.terms_condition {
    margin-bottom: 20px; 
}
.register-form form .field-wrapper.terms_condition label {
    font-size: 14px;
    color: #888ea8;
    padding-left: 31px;
    font-weight: 100;
}
.register-form form .field-wrapper.terms_condition a {
    color: #1b55e2;
}
.register-form p.signup-link.register {
    font-size: 13px;
    color: #888ea8;
    font-weight: 600;
    margin-bottom: 25px;
    margin-top: 0;
}
</style>
<div class='register-form'>
    <div class="form-content">

        <h1 class="">Register</h1>
        <p class="signup-link register">Already have an account? <a href="{{ route('d.login', ['domain_toko' => $toko->domain_toko]) }}">Log in</a></p>
        @if ($danger = session('error'))
        <div role="alert" class="alert alert-danger alert-dismissible">
            <button aria-label="Close" data-dismiss="alert" class="close" type="button">
                <span aria-hidden="true">×</span>
            </button>
            <h4>Error</h4>
            <p>{{ $danger }}</p>
        </div>
        @endif
        <form class="text-left"  action="{{ route('d.register', ['domain_toko' => $toko->domain_toko]) }}" method="post">
            {{ csrf_field() }}
            <div class="form">

                <div id="name-field" class="field-wrapper input">
                    <label for="name">NAMA LENGKAP</label>
                    <svg style='top:52px' xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <input id="name" name="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Nama Lengkap">
                    @if ($errors->has('name'))
                        <div id="error_name" class="invalid-feedback" style='display:block'>{{ $errors->first('name') }}</div>
                    @endif
                </div>

                <div id="email-field" class="field-wrapper input">
                    <label for="email">EMAIL</label>
                    <svg style='top:52px' xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign register"><circle cx="12" cy="12" r="4"></circle><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path></svg>
                    <input id="email" name="email" type="text" value="" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email">
                    @if ($errors->has('email'))
                        <div id="error_email" class="invalid-feedback" style='display:block'>{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <div id="no_telp-field" class="field-wrapper input">
                    <label for="no_telp">NOMOR TELEPON</label>
                    <svg style='top:52px;' xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                    <input id="no_telp" name="no_telp" type="text" value="" class="form-control ph-number{{ $errors->has('no_telp') ? ' is-invalid' : '' }}" placeholder="Nomor Telepon">
                    @if ($errors->has('no_telp'))
                        <div id="error_no_telp" class="invalid-feedback" style='display:block'>{{ $errors->first('no_telp') }}</div>
                    @endif
                </div>

                <div id="password-field" class="field-wrapper input">
                    <div class="d-flex justify-content-between">
                        <label for="password">PASSWORD</label>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    <input id="password" name="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password">
                    @if ($errors->has('password'))
                        <div id="error_password" class="invalid-feedback" style='display:block'>{{ $errors->first('password') }}</div>
                    @endif
                    <svg style="{{ $errors->has('password') ? ' right:36px;' : '' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </div>

                <div id="password2-field" class="field-wrapper input mb-2">
                    <div class="d-flex justify-content-between">
                        <label for="password2">PASSWORD CONFIRMATION</label>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    <input id="password2" name="password2" type="password" class="form-control{{ $errors->has('password2') ? ' is-invalid' : '' }}" placeholder="Password">
                    @if ($errors->has('password2'))
                        <div id="error_password2" class="invalid-feedback" style='display:block'>{{ $errors->first('password2') }}</div>
                    @endif
                    <svg style="{{ $errors->has('password2') ? ' right:36px;' : '' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password2" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </div>

                <div class="field-wrapper terms_condition">
                    <div class="n-chk">
                        <label class="new-control new-checkbox checkbox-primary">
                            <input type="checkbox" class="new-control-input">
                            <span class="new-control-indicator"></span><span>I agree to the <a href="javascript:void(0);">  terms and conditions </a></span>
                        </label>
                    </div>

                </div>

                <div class="d-sm-flex justify-content-between">
                    <div class="field-wrapper">
                        <button type="submit" class="btn btn-primary" value="">Register</button>
                    </div>
                </div>

            </div>
        </form>

    </div> 
</div>
<script>
    $(document).ready(function(){

        $('#name').on('input', function(){
            if($(this).hasClass('is-invalid')){
                $(this).removeClass('is-invalid');
                $('#error_name').hide();
            }
        });

        $('#email').on('input', function(){
            if($(this).hasClass('is-invalid')){
                $(this).removeClass('is-invalid');
                $('#error_email').hide();
            }
        });

        $('#no_telp').on('input', function(){
            if($(this).hasClass('is-invalid')){
                $(this).removeClass('is-invalid');
                $('#error_no_telp').hide();
            }
        });

        $('#password').on('input', function(){
            if($(this).hasClass('is-invalid')){
                $(this).removeClass('is-invalid');
                $('#error_password').hide();
                $('#toggle-password').css('right', '13px');
            }
        });

        $('#password2').on('input', function(){
            if($(this).hasClass('is-invalid')){
                $(this).removeClass('is-invalid');
                $('#error_password2').hide();
                $('#toggle-password2').css('right', '13px');
            }
        });

        $(".ph-number").inputmask({mask:"(+99) 999-9999-9999"});

        var togglePassword = document.getElementById("toggle-password");
        var togglePassword2 = document.getElementById("toggle-password2");
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
        if (togglePassword2) {
            togglePassword2.addEventListener('click', function() {
                var x = document.getElementById("password2");
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