@extends('belakang.index')
@section('isi')
<!--uiop-->
<div class="page-header page-header-bordered">
    <h1 class="page-title font-size-26 font-weight-100">Addons</h1>
    <div class="page-header-actions">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);"
                    onClick="pageLoad('{{ route('b.dashboard') }}')">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0);"
                    onClick="pageLoad('{{ route('b.addons-index') }}')">Addons</a></li>
            <li class="breadcrumb-item active">Notifikasi Whatsapp</li>
        </ol>
    </div>
</div>
<div class="page-content">
    <div class='container'>
        <div class='row'>
            <div class='col-xxl-12'>
                <div class="panel nav-tabs-horizontal">
                    <div class="panel-heading">
                        <h3 class="panel-title">Notifikasi Whatsapp</h3>
                    </div>
                    <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#exampleTopHome" aria-controls="exampleTopHome" role="tab" aria-expanded="true" aria-selected="false">
                                <i class="icon fa-key" aria-hidden="true"></i>Utama
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#exampleTopComponents" aria-controls="exampleTopComponents" role="tab" aria-selected="false">
                                <i class="icon wb-plugin" aria-hidden="true"></i>Komponen
                            </a>
                        </li>
                        <li class="dropdown nav-item" style="display: none;">
                            <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false">Dropdown </a>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" data-toggle="tab" href="#exampleTopHome" aria-controls="exampleTopHome" role="tab"><i class="icon wb-plugin" aria-hidden="true"></i>Home</a>
                                <a class="dropdown-item" data-toggle="tab" href="#exampleTopComponents" aria-controls="exampleTopComponents" role="tab"><i class="icon wb-user" aria-hidden="true"></i>Components</a>
                            </div>
                        </li>
                    </ul>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="exampleTopHome" role="tabpanel">
                                <div class='container'>
                                    <!-- {{ csrf_field() }} -->
                                    <div class='row pb-25' style='border-bottom:1px solid #e4eaec'>
                                        <div class='col-xl-3 col-lg-5 col-md-6 mt-5'>
                                            <b>Aktifkan Addons</b>
                                        </div>
                                        <div class='col-xl-9 col-lg-7 col-md-6'>
                                            <input type='checkbox' name='aktifData' id='aktifData' class='js-switch' @if($cekAddon->notif_wa === 1) checked @endif>
                                        </div>
                                    </div>
                                    <div class='row mt-25 pb-25'>
                                        <div class='col-xxl-3 col-xl-3'>
                                            <b>Autonotif API Key</b>
                                        </div>
                                        <div class='col-xxl-4 col-xl-9'>
                                            <input type="text" class='form-control' name='api_key' id='api-key' placeholder='Autonotif API Key' @if(isset($addonData)) value='{{ $addonData["key"] }}' @endif/>
                                            <small id="error_api-key" class='red-700 hidden'>API Key tidak boleh kosong!<br></small>
                                            <small>
                                                Addons ini menggunakan API dari autonotif, untuk mendapatkan API Key silahkan mengunjungi <a href='https://www.autonotif.com/' target='_blank'>autonotif.com</a>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="exampleTopComponents" role="tabpanel">
                                <div class='container'>
                                    <div class='row pb-25' id='notifWa-resiUpdate-divBtn'>
                                        <div class='col-xl-3 col-lg-5 col-md-6 mt-5'>
                                            <b>Notifikasi Resi Update</b>
                                        </div>
                                        <div class='col-xl-9 col-lg-7 col-md-6'>
                                            <input type='checkbox' name='notifWa_resiUpdate' id='notifWa-resiUpdate' class='js-switch2' @if(isset($addonData) && $addonData['resi_update']['aktif'] === true) checked @endif>
                                            <small id="notifWa-resiUpdate" class='red-700 hidden'>Template tidak boleh kosong!<br></small>
                                        </div>
                                    </div>
                                    <div  id='notifWa-resiUpdate-div' style="@if(!isset($addonData) || $addonData['resi_update']['aktif'] === false) display:none; @endif">
                                        <div class='row'>
                                            <div class='col-xl-3 col-lg-5 col-md-6 mt-5'>
                                                <b>Template Pesan</b>
                                            </div>
                                            <div class='col-xl-9 col-lg-7 col-md-6'>
                                                <textarea name='notifWa_resiUpdate_tmp' id='notifWa-resiUpdate-tmp' rows='5' class='form-control'>@if(isset($addonData)) {{ $addonData["resi_update"]['tmp'] }} @endif</textarea>
                                                <small id="error_notifWa-resiUpdate-tmp" class='red-700 hidden'>Template tidak boleh kosong!<br></small>
                                            </div>
                                        </div>
                                        <div class='row mt-25'>
                                            <div class='col-xl-3 col-lg-5 col-md-6 mt-5'>
                                                <b>Catatan</b>
                                            </div>
                                            <div class='col-xl-9 col-lg-7 col-md-6'>
                                                Tag yang bisa digunakan:<br>
                                                <ul>
                                                        <li>%nama_customer% &nbsp;:&nbsp; Nama Customer</li>
                                                        <li>%resi% &nbsp;:&nbsp; Resi</li>
                                                        <li>%nama_toko% &nbsp;:&nbsp; Nama Toko</li>
                                                        <li>%id_order% &nbsp;:&nbsp; ID Order</li>
                                                        <li>%kurir% &nbsp;:&nbsp; Kurir</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='panel-footer pt-15' style='border-top:1px solid #e4eaec'>
                        <button type='button' class='btn btn-primary' id='btnSimpan'>Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

$(document).ready(() => {
    // Swithchery
    var list_checkbox = Array.prototype.slice.call($('.js-switch'));
    list_checkbox.forEach(function(html) {
        var switchery = new Switchery(html, {
            color: '#00bf26',
            secondaryColor: '#ff1c1c',
            size: 'medium'
        });
    });

    var list_checkbox = Array.prototype.slice.call($('.js-switch2'));
    list_checkbox.forEach(function(html) {
        var switchery = new Switchery(html, {
            color: '#3e8ef7',
            size: 'medium'
        });
    });

    $('#api-key').on('input', () => {
        if($('#api-key').hasClass('is-invalid')){
            $('#api-key').removeClass('is-invalid animation-shake');
            $('#error_api-key').hide();
        }
    });

    $('#notifWa-resiUpdate').on('change', function() {
        // console.log('asd');
        if($(this).is(':checked')){
            $('#notifWa-resiUpdate-div').show();
            // $('#notifWa-resiUpdate-divBtn').attr('style', '');
        } else {
            $('#notifWa-resiUpdate-div').hide();
            // $('#notifWa-resiUpdate-divBtn').attr('style', 'border-bottom:1px solid #e4eaec');
        }
    });

    $('#notifWa-resiUpdate-tmp').on('input', function(){
        if($('#notifWa-resiUpdate-tmp').hasClass('is-invalid')){
            $('#notifWa-resiUpdate-tmp').removeClass('is-invalid animation-shake');
            $('#error_notifWa-resiUpdate-tmp').hide();
        }
    });

    $('#btnSimpan').on('click', () => {
        var error = 0;
        if($('#aktifData').is(':checked')){
            if($('#api-key').val() == ''){
                $('#api-key').addClass('is-invalid animation-shake');
                $('#error_api-key').show();
                error++;
            }
            if($('#notifWa-resiUpdate').is(':checked') && $('#notifWa-resiUpdate-tmp').val() == ''){
                $('#notifWa-resiUpdate-tmp').addClass('is-invalid animation-shake');
                $('#error_notifWa-resiUpdate-tmp').show();
                error++;
            }
        }
        // console.log($('#api-key').val());
        if(error === 0){
            var url = "{{route('b.addons-notifWa_proses')}}";
            var form = $("<form action='"+url+"' method='get'></form>");
            $('#aktifData').clone().appendTo(form);
            $('#api-key').clone().appendTo(form);
            $('#notifWa-resiUpdate').clone().appendTo(form);
            $('#notifWa-resiUpdate-tmp').clone().appendTo(form);
            // console.log(form);
            $('body').append(form);
            form.submit();
        }
    });
})

</script>
<!--uiop-->
@endsection