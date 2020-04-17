@extends('belakang.index')
@section('title', 'Profile')
@section('isi')
<!--uiop-->
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="page-header page-header-bordered">
    <h1 class="page-title font-size-26 font-weight-100">Profile</h1>
    <div class="page-header-actions">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);"
                    onClick="pageLoad('{{ route('b.dashboard') }}')">Dashboard</a></li>
            <li class="breadcrumb-item active">Profile</li>
        </ol>
    </div>
</div>

{{-- Page content --}}
<div class="page-content mt-60">
    <div class='container'>
        <div class="panel animation-slide-bottom">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <h4 class="example-title text-center">Profil User</h4>
                    </div>
                    <div class="col-md-4"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-8">
                        <form id="formUser">
                            <div class="row justify-content-end">
                                <div class="col-md-5 form-group">
                                    <label for="">Email</label>
                                <input type="email" class="form-control" id="email" value="{{$users->email}}" readonly>
                                </div>
                                <div class="col-lg-5 form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" class="form-control" placeholder="Nama Lengkap" id="nama" value="{{$users->name}}">
                                    <small id="error_nama" style='color:#f2353c;display:none;'>Masukkan nama!</small>
                                </div>
                                <div class="col-lg-5 form-group">
                                    <label>No Telepon</label>
                                    <input type="number" class="form-control" placeholder="No Telepon" id="no_telp" value="{{$users->no_telp}}">
                                    <small id="error_no_telp" style='color:#f2353c;display:none;'>Masukkan No Telp!</small>
                                </div>
                                <div class="col-lg-5 form-group">
                                    <label>Role</label>
                                    <select class="form-control" id="role">
                                        <option @if ($users->role == 'Owner')
                                            selected
                                        @endif value="Owner">Owner</option>
                                        <option @if ($users->role == 'Admin')
                                            selected
                                        @endif value="Admin">Admin</option>
                                        <option @if ($users->role == 'Shipper')
                                            selected
                                        @endif value="Shipper">Shipper</option>
                                        <small id="error_role" style='color:#f2353c;display:none;'>Masukkan
                                            role!</small>
                                    </select>
                                </div>
                                <div class="col-lg-5 form-group">
                                    <label>Password</label>
                                    <div class="input-search">
                                        <button type="button" style="height:40px;cursor:pointer;" class="input-search-btn" id='btnEye' tabindex='-1'><i class="icon md-eye" aria-hidden="true"></i></button>
                                        <input type="password" class="form-control" placeholder="Password" id="pass" autocomplete="on" style='border-radius:unset'>
                                        <small id="error_pass1" style='color:#f2353c;display:none;'>Password tidak sama!</small>
                                    </div>
                                </div>
                                <div class="col-lg-5 form-group">
                                    <label>Re Password</label>
                                    <div class="input-search">
                                        <button type="button" style="height:40px;cursor:pointer;" class="input-search-btn" id='btnEye2' tabindex='-1'><i class="icon md-eye" aria-hidden="true"></i></button>
                                        <input type="password" class="form-control" placeholder="Re-enter Password" id="re-pass" style='border-radius:unset'>
                                        <small id="error_re-pass" style='color:#f2353c;display:none;'>Masukkan Kembali Password!</small>
                                    </div>
                                </div>
                                <div class="col-md-10 text-right">
                                    <hr>
                                    <button type="button" class="btn btn-primary" name="btnUpdateProfile">Simpan </button>
                                </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-3">
                    <h5>Ketentuan Role: </h5>
                    <p><strong>Owner </strong>: pemilik usaha, memiliki hak akses tertinggi.</p>
                    <p><strong>Admin </strong>: merupakan Karyawan anda, yang membantu mengelola
                        pemesanan
                        barang.</p>
                    <p><strong>Supplier </strong>: merupakan penyuplai barang pada toko anda.</p>
                    <div class='alert alert-alt alert-info' role='alert'>
                        <h4>Catatan</h4>
                        <p>Password dan Re-Password hanya diisi bila ingin mengganti password saja.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function () {
        $('#role').selectpicker({
            style: 'btn-outline btn-default'
        });

        $('#btnEye').click(function(){
            if($('#pass').attr('type') == 'password'){
                $('#pass').attr('type', 'text');
                $('#btnEye').children().attr('class', 'icon md-eye-off');
            } else if($('#pass').attr('type') == 'text'){
                $('#pass').attr('type', 'password');
                $('#btnEye').children().attr('class', 'icon md-eye');
            }
        });

        $('#btnEye2').click(function(){
            if($('#re-pass').attr('type') == 'password'){
                $('#re-pass').attr('type', 'text');
                $('#btnEye2').children().attr('class', 'icon md-eye-off');
            } else if($('#re-pass').attr('type') == 'text'){
                $('#re-pass').attr('type', 'password');
                $('#btnEye2').children().attr('class', 'icon md-eye');
            }
        });

        $('#pass').password({
            animate: false,
            minimumLength: 0,
            enterPass: '',
            badPass: '<span class="red-800 font-size-14">The password is weak</span>',
            goodPass: '<span class="yellow-800 font-size-14">Good password</span>',
            strongPass: '<span class="green-700 font-size-14">Strong password</span>',
            shortPass: ''
        });

        //Update Profile
        $("button[name=btnUpdateProfile]").on('click', function () {
            var nama = $('#nama').val();
            var no_telp = $('#no_telp').val();
            var role = $('#role').val();
            var pass = $('#pass').val();
            var re_pass = $('#re-pass').val();
            var error = 0;
            if (nama == "") {
                $('#nama').attr('class', 'form-control is-invalid animation-shake');
                $('small#error_ebank').attr('style', 'color:#f2353');
                error++;
            }
            if (no_telp == "") {
                $('#no_telp').attr('class', 'form-control is-invalid animation-shake');
                $('small#error_no_telp').attr('style', 'color:#f2353');
                error++;
            }
            if (role == "") {
                $('#role').attr('class', 'form-control is-invalid animation-shake');
                $('small#error_role').attr('style', 'color:#f2353');
                error++;
            }
            if (pass != "") {
                if (re_pass == "") {
                    $('#re-pass').attr('class', 'form-control is-invalid animation-shake');
                    $('small#error_re-pass').attr('style', 'color:#f2353');
                    error++;
                }
                error++;
            }
            if (pass != re_pass) {
                $('#pass').attr('class', 'form-control is-invalid animation-shake');
                $('small#error_pass1').attr('style', 'color:#f2353');
                $('#re-pass').val('');
                error++;
            }
            if (error == 0) {
                var hasil;
                $.ajax({
                    type: 'post',
                    url: "{{ route('b.profil-update') }}",
                    data: {
                        nama: $('#nama').val(),
                        no_telp: $('#no_telp').val(),
                        role: $('#role').val(),
                        pass: $('#pass').val(),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        hasil = data;
                    },
                    error: function (error, b, c) {
                        swal("Error", '' + c, "error")
                    }
                }).done(function () {
                    if (hasil.status) {
                        swal({
                            title: "Berhasil!",
                            text: "Berhasil Memperbarui Profil!",
                            icon: "success"
                        }).then(function (){
                            $(location).attr("href", "{{ route('b.profil-index') }}");
                        });
                        $('#pass').val('');
                        $('#re-pass').val('');
                    } else {
                        swal("Gagal!", "" + hasil.msg, "error");
                    }
                }).fail(function () {
                    //console.log(hasil.msg);
                })
            }
        })
    });

</script>
<!--uiop-->
@endsection
