@extends('depan.default.index')
@section('isi')
<!--uiop-->
<style type="text/css">
	.register-form {
		width: 600px;
    	margin: 50px auto;
	}
    .register-form form {
    	margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }
    .register-form h2 {
        margin: 0 0 15px;
    }
    .register-form.form-control, .register-form .btn {
        min-height: 38px;
        border-radius: 2px;
    }
</style>
<div class='row'>
    <div class='col-md-12 text-center'>
        <div class="register-form">
            <form action="{{ route('d.register', ['toko_slug' => $toko->domain_toko]) }}" method="post">
                {{ csrf_field() }}
                <h2 class="text-center">Register</h2>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Fullname" required="required">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Email" required="required">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Username" required="required">
                </div>
                <div class="form-group">
                    <div class='row'>
                        <div class='col-md-6'>
                            <input type="text" class="form-control" placeholder="Password" required="required">
                        </div>
                        <div class='col-md-6'>
                            <input type="text" class="form-control" placeholder="Ulangi Password" required="required">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="No Telepon" required="required">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Log in</button>
                </div>
                <div class="clearfix">
                    <label class="pull-left checkbox-inline"><input type="checkbox"> syarat dan ketentuan syarat dan ketentuan yang berlaku.</label>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready
</script>
<!--uiop-->
@endsection