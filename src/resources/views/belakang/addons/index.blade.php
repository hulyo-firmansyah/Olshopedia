@extends('belakang.index')
@section('isi')
<!--uiop-->
<style type="text/css">
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
    }
</style>

<div id="loader">
    <div class="layout-full vertical-align text-center">
        <div class="loader vertical-align-middle loader-cube"></div>
    </div>
</div>

<div class="page-header page-header-bordered">
    <h1 class="page-title font-size-26 font-weight-100">Addons</h1>
    <div class="page-header-actions">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);"
                    onClick="pageLoad('{{ route('b.dashboard') }}')">Dashboard</a></li>
            <li class="breadcrumb-item active">Addons</li>
        </ol>
    </div>
</div>
<div class="page-content">
    <div class='container'>
        @if ($msg_sukses = Session::get('msg_success'))
        <div class='alert alert-success alert-semen' role='alert'><i class='fa fa-check'></i> SUCCESS: {{$msg_sukses}}</div>
        @endif
        <div class='row'>
            <div class='col-xxl-4 col-xl-6'>
                <div class='panel animation-scale-up' style='animation-delay:100ms'>
                    <div class='panel-body'>
                        <div class="well">
                            <h2 class="h3"><span class="fe fe-message-square"></span> Notifikasi Resi via Email <span class='orange-600'>(Beta)</span></h2>
                            <p>Kirim notifikasi resi secara otomatis melalui <strong>Email</strong> kepada customer setelah Anda menginput Nomor Resi di data order.</p>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <small>Status</small>
                                    <p class="mt-0">
                                        @if($cekAddon->notif_resi_email === 1)
                                            <strong class='green-600'>Aktif</strong>
                                        @else 
                                            <strong class='red-600'>Tidak Aktif</strong>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6">
                                </div>
                            </div>	
                            <div class='row'>
                                <div class='col-md-12'>
                                    <a href="javascript:void(0)" onClick='pageLoad("{{ route("b.addons-notifResiEmail") }}")' class="btn btn-default btn-outline float-right"><i class="fa fa-gear"></i> Setting</a>
                                </div>
                            </div>
                            @if($cekAddon->notif_resi_email === 1)
                            <hr>
                            <div class="d-flex mt-10 pt-10">
                                <input type='text' id='emailTujuanTest-notifResiEmail' class='form-control mr-10' placeholder='Email Tujuan'>
                                <button type='button' class='btn btn-primary' id='kirimTest-notifResiEmail'><i class='fa fa-send'></i> Kirim Test</button>
                            </div>	
                            <small id="error_emailTujuan-notifResiEmail" class='red-700 hidden'>Email Tujuan tidak boleh kosong!</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-xxl-4 col-xl-6'>
                <div class='panel animation-scale-up' style='animation-delay:200ms'>
                    <div class='panel-body'>
                        <div class="well">
                            <h2 class="h3"><span class="fe fe-message-square"></span> Notifikasi Whatsapp <span class='orange-600'>(Beta)</span></h2>
                            <p>
                                Kirim notifikasi secara otomatis melalui <strong>Whatsapp</strong> kepada customer.<br>
                                
                            </p>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <small>Status</small>
                                    <p class="mt-0">
                                        @if($cekAddon->notif_wa === 1)
                                            <strong class='green-600'>Aktif</strong>
                                        @else 
                                            <strong class='red-600'>Tidak Aktif</strong>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6">
                                </div>
                            </div>	
                            <div class='row'>
                                <div class='col-md-12'>
                                    <a href="javascript:void(0)" onClick='pageLoad("{{ route("b.addons-notifWa") }}")' class="btn btn-default btn-outline float-right"><i class="fa fa-gear"></i> Setting</a>
                                </div>
                            </div>
                            @if($cekAddon->notif_wa === 1)
                            <hr>
                            <div class="d-flex mt-10 pt-10">
                                <input type='text' id='waTujuanTest-notifWa' class='form-control mr-10' placeholder='Nomor Whatsapp Tujuan'>
                                <button type='button' class='btn btn-primary' id='kirimTest-notifWa'><i class='fa fa-send'></i> Kirim Test</button>
                            </div>	
                            <small id="error_waTujuanTest-notifWa" class='red-700 hidden'>Nomor Whatsapp Tujuan tidak boleh kosong!<br></small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class='col-xxl-4 col-xl-6'>
                <div class='panel'>
                    <div class='panel-body'>
                        dasfad
                    </div>
                </div>
            </div>
            <div class='col-xxl-4 col-xl-6'>
                <div class='panel'>
                    <div class='panel-body'>
                        dasfad
                    </div>
                </div>
            </div>
            <div class='col-xxl-4 col-xl-6'>
                <div class='panel'>
                    <div class='panel-body'>
                        dasfad
                    </div>
                </div>
            </div>
            <div class='col-xxl-4 col-xl-6'>
                <div class='panel'>
                    <div class='panel-body'>
                        dasfad
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</div>
<script>

function cekEmail(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
}

$(document).ready(function(){

    
    @if($msg_sukses = Session::get('msg_success'))
    window.setTimeout(function() {
        $('.alert-semen').animate({
            height: 'toggle'
        }, 'slow');
    }, 5000);
    @endif

    @if($cekAddon->notif_resi_email === 1)
        $('#kirimTest-notifResiEmail').on('click', function(){
            var isi = $('#emailTujuanTest-notifResiEmail').val();
            if(isi == ''){
                $('#emailTujuanTest-notifResiEmail').addClass('is-invalid animation-shake');
                $('#error_emailTujuan-notifResiEmail').html('Email Tujuan tidak boleh kosong!');
                $('#error_emailTujuan-notifResiEmail').show();
            } else {
                if(!cekEmail(isi)){
                    $('#emailTujuanTest-notifResiEmail').addClass('is-invalid animation-shake');
                    $('#error_emailTujuan-notifResiEmail').html('Masukkan Email yang valid!');
                    $('#error_emailTujuan-notifResiEmail').show();
                } else {
                    $('#loader').show();
                    var hasil = '';
                    $.ajax({
                        type: 'post',
                        url: "{{ route('b.addons-notifResiEmail_test') }}",
                        data: {
                            email: isi,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            hasil = data;
                        },
                        error: function(error, b, c) {
                            swal("Error", '' + c, "error")
                        }
                    }).done(function() {
                        $('#loader').hide();
                        if (hasil.status) {
                            swal("Berhasil!", '' + hasil.msg, "success");
                        } else {
                            swal("Gagal!", "" + hasil.msg, "error");
                        }
                    }).fail(function() {
                        
                    });
                }
            }
        });

        $('#emailTujuanTest-notifResiEmail').on('input', function(){
            if($('#emailTujuanTest-notifResiEmail').hasClass('is-invalid')){
                $('#emailTujuanTest-notifResiEmail').removeClass('is-invalid animation-shake');
                $('#error_emailTujuan-notifResiEmail').hide();
            }
        });
    @endif

    @if($cekAddon->notif_wa === 1)
        $('#waTujuanTest-notifWa').on('input', function(){
            this.value = this.value.replace(/[^0-9]/gi, '');
        });

        $('#kirimTest-notifWa').on('click', function(){
            var isi = $('#waTujuanTest-notifWa').val();
            if(isi == ''){
                $('#waTujuanTest-notifWa').addClass('is-invalid animation-shake');
                $('#error_waTujuanTest-notifWa').html('Nomor Whatsapp Tujuan tidak boleh kosong!');
                $('#error_waTujuanTest-notifWa').show();
            } else {
                if(isi.split('')[0] == '0'){
                    $('#waTujuanTest-notifWa').addClass('is-invalid animation-shake');
                    $('#error_waTujuanTest-notifWa').html('Nomor Whatsapp Tujuan harus diawali dengan kode negara, seperti 62 untuk kode negara Indonesia!');
                    $('#error_waTujuanTest-notifWa').show();
                } else {
                    $('#loader').show();
                    var hasil = '';
                    $.ajax({
                        type: 'post',
                        url: "{{ route('b.addons-notifWa_test') }}",
                        data: {
                            no: isi,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            hasil = data;
                        },
                        error: function(error, b, c) {
                            swal("Error", '' + c, "error")
                        }
                    }).done(function() {
                        $('#loader').hide();
                        if (hasil.status) {
                            swal("Berhasil!", '' + hasil.msg, "success");
                        } else {
                            swal("Gagal!", "" + hasil.msg, "error");
                        }
                    }).fail(function() {
                        
                    });
                }
            }
        });

        $('#waTujuanTest-notifWa').on('input', function(){
            if($('#waTujuanTest-notifWa').hasClass('is-invalid')){
                $('#waTujuanTest-notifWa').removeClass('is-invalid animation-shake');
                $('#error_waTujuanTest-notifWa').hide();
            }
        });
    @endif

});

</script>
<!--uiop-->
@endsection