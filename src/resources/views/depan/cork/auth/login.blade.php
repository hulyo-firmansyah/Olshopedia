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
    
        <h1 class="">Sign In</h1>
        <p class="">Log in to your account to continue.</p>
        
        <form class="text-left">
            <div class="form">
    
                <div id="username-field" class="field-wrapper input">
                    <label for="username">USERNAME</label>
                    <svg style='top:52px' xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <input id="username" name="username" type="text" class="form-control" placeholder="e.g John_Doe">
                </div>
    
                <div id="password-field" class="field-wrapper input mb-2">
                    <div class="d-flex justify-content-between">
                        <label for="password">PASSWORD</label>
                        <a href="auth_pass_recovery_boxed.html" class="forgot-pass-link">Forgot Password?</a>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    <input id="password" name="password" type="password" class="form-control" placeholder="Password">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </div>
                <div class="d-sm-flex justify-content-between">
                    <div class="field-wrapper">
                        <button type="submit" class="btn btn-primary" value="">Log In</button>
                    </div>
                </div>
    
                <div class="division">
                        <span>OR</span>
                </div>
    
                <div class="social">
                    <a href="javascript:void(0);" class="btn social-fb">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg> 
                        <span class="brand-name">Facebook</span>
                    </a>
                    <a href="javascript:void(0);" class="btn social-github">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
                        <span class="brand-name">Github</span>
                    </a>
                </div>
    
                <p class="signup-link">Not registered ? <a href="auth_register_boxed.html">Create an account</a></p>
    
            </div>
        </form>
    
    </div> 
</div>
<script>
    $(document).ready(function(){
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