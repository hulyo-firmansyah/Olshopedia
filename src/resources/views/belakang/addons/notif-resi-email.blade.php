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
            <li class="breadcrumb-item active">Notifikasi Resi via Email</li>
        </ol>
    </div>
</div>
<div class="page-content">
    <div class='container'>
        <div class='row'>
            <div class='col-xxl-12'>
                <div class='panel panel-bordered'>
                    <div class="panel-heading">
                        <h3 class="panel-title">Notifikasi Resi via Email</h3>
                    </div>
                    <div class="panel-body">
                        <div class='container'>
                            <form action="{{ route('b.addons-notifResiEmail_proses') }}" method='post' id='formNotif'>
                                {{ csrf_field() }}
                                <div class='row pb-25' style='border-bottom:1px solid #e4eaec'>
                                    <div class='col-xl-3 col-lg-5 col-md-6 mt-5'>
                                        <b>Aktifkan Addons</b>
                                    </div>
                                    <div class='col-xl-9 col-lg-7 col-md-6'>
                                        <input type='checkbox' name='aktifData' id='aktifData' class='js-switch' @if($cekAddon->notif_resi_email == 1) checked @endif>
                                    </div>
                                </div>
                                <div class='row mt-25 pb-15'>
                                    <div class='col-xxl-3 col-xl-3'>
                                        <b>SMTP Hostname</b>
                                    </div>
                                    <div class='col-xxl-4 col-xl-9'>
                                        <input type="text" class='form-control' name='smtp_hostname' id='smtp-hostname' placeholder='Hostname' @if(isset($addonData)) value='{{ $addonData["smtp"]["hostname"] }}' @endif/>
                                        <small id="error_smtp-hostname" class='red-700 hidden'>SMTP Hostname tidak boleh kosong!</small>
                                    </div>
                                </div>
                                <div class='row mt-15 pb-15'>
                                    <div class='col-xxl-3 col-xl-3'>
                                        <b>SMTP Port</b>
                                    </div>
                                    <div class='col-xxl-2 col-xl-9'>
                                        <input type="text" class='form-control' name='smtp_port' id='smtp-port' style='width:80px' placeholder='Port' @if(isset($addonData)) value='{{ $addonData["smtp"]["port"] }}' @endif/>
                                        <small id="error_smtp-port" class='red-700 hidden'>SMTP Port tidak boleh kosong!</small>
                                    </div>
                                </div>
                                <div class='row mt-15 pb-15'>
                                    <div class='col-xxl-3 col-xl-3'>
                                        <b>SMTP Security</b>
                                    </div>
                                    <div class='col-xxl-1 col-xl-9'>
                                        <select name='smtp_security' id='smtp-security'>
                                            <option value='kosong' @if(isset($addonData) && $addonData["smtp"]["security"] == 'kosong') selected @endif>None</option>
                                            <option value='ssl' @if(isset($addonData) && $addonData["smtp"]["security"] == 'ssl') selected @endif>SSL</option>
                                            <option value='tls' @if(isset($addonData) && $addonData["smtp"]["security"] == 'tls') selected @endif>TLS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class='row mt-15 pb-15'>
                                    <div class='col-xxl-3 col-xl-3'>
                                        <b>SMTP Username</b>
                                    </div>
                                    <div class='col-xxl-4 col-xl-9'>
                                        <input type="text" class='form-control' name='smtp_username' id='smtp-username' placeholder='Username' @if(isset($addonData)) value='{{ $addonData["smtp"]["username"] }}' @endif/>
                                        <small id="error_smtp-username" class='red-700 hidden'>SMTP Username tidak boleh kosong!</small>
                                    </div>
                                </div>
                                <div class='row mt-15 pb-25' style='border-bottom:1px solid #e4eaec'>
                                    <div class='col-xxl-3 col-xl-3'>
                                        <b>SMTP Password</b>
                                    </div>
                                    <div class='col-xxl-4 col-xl-9'>
                                        @if(isset($addonData)) 
                                            <a href='javascript:void(0)' id='ubahPass'>Ubah Password</a>
                                        @else 
                                            <input type="text" class='form-control' name='smtp_password' id='smtp-password' placeholder='Password' autocomplete='off'/>
                                        @endif
                                        <small id="error_smtp-password" class='red-700 hidden'>SMTP Password tidak boleh kosong!</small>
                                    </div>
                                </div>
                                <div class='row mt-25 pb-25' style='border-bottom:1px solid #e4eaec'>
                                    <div class='col-md-3'>
                                        <b>Template</b>
                                    </div>
                                    <div class='col-md-9'>
                                        <div class='row'>
                                            <div class='col-xl-12'>
                                                <input type="radio" name='tipePesan' id='tipePesan1' value='html' @if(isset($addonData) && $addonData["tipe"] == 'html') checked @endif/>
                                                <label for='tipePesan1' class='ml-5 mr-35'>HTML Message</label>
                                                <input type="radio" name='tipePesan' id='tipePesan2' value='plain' @if((isset($addonData) && $addonData["tipe"] == 'plain') || is_null($addonData)) checked @endif/>
                                                <label for='tipePesan2' class='ml-5'>Plain-text Message</label>
                                            </div>
                                        </div>
                                        <div class='row mt-20'>
                                            <div class='col-xl-12'>
                                                <textarea class='form-control' id='pesan' name='pesan'>@if(isset($addonData)) {!! $addonData['pesan'] !!} @endif</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='row mt-25 pb-25' style='border-bottom:1px solid #e4eaec'>
                                    <div class='col-md-3'>
                                        <b>Catatan</b>
                                    </div>
                                    <div class='col-md-9'>
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
                                <div class='row mt-25'>
                                    <div class='col-md-12'>
                                        <button type='button' class='btn btn-primary' id='btnSimpan'>Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
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

    @if(isset($addonData) && $addonData["tipe"] == 'html') 
        $('#pesan').summernote({
            tabsize: 2,
            height: 100,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                ['font', ['superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph', 'style']],
                ['height', ['height']]
            ],
            codeviewFilter: false,
            codeviewIframeFilter: true
        });
    @endif

    $('input[name=tipePesan]').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });

    $('#smtp-security').selectpicker({
        style: 'btn-default btn-outline'
    });

    $('input[name=tipePesan]').on('ifClicked', function() {
        // console.log(this.value);
        // console.log($(this).val());
        if(this.value == 'html'){
            // $('#pesan').val('');
            $('#pesan').summernote({
                tabsize: 2,
                height: 100,
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                    ['font', ['superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph', 'style']],
                    ['height', ['height']]
                ],
                codeviewFilter: false,
                codeviewIframeFilter: true
            });
        } else {
            $('#pesan').summernote('destroy');
            // $('#pesan').val('');
        }
    });

    $('#smtp-password').on('input', () => {
        if($('#smtp-password').hasClass('is-invalid')){
            $('#smtp-password').removeClass('is-invalid animation-shake');
            $('#error_smtp-password').hide();
        }
    });

    $('#smtp-username').on('input', () => {
        if($('#smtp-username').hasClass('is-invalid')){
            $('#smtp-username').removeClass('is-invalid animation-shake');
            $('#error_smtp-username').hide();
        }
    });

    $('#smtp-port').on('input', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
        if($('#smtp-port').hasClass('is-invalid')){
            $('#smtp-port').removeClass('is-invalid animation-shake');
            $('#error_smtp-port').hide();
        }
    });

    $('#smtp-hostname').on('input', () => {
        if($('#smtp-hostname').hasClass('is-invalid')){
            $('#smtp-hostname').removeClass('is-invalid animation-shake');
            $('#error_smtp-hostname').hide();
        }
    });

    $('#ubahPass').on('click', function(e){
        e.preventDefault();
        $(this).parent().prepend("<input type='text' class='form-control' name='smtp_password' id='smtp-password' placeholder='Password' autocomplete='off'/>");
        $(this).remove();
    });

    $('#btnSimpan').on('click', () => {
        var error = 0;
        if($('#aktifData').is(':checked')){
            if($('#smtp-password').val() == ''){
                $('#smtp-password').addClass('is-invalid animation-shake');
                $('#error_smtp-password').show();
                error++;
            }
            if($('#smtp-username').val() == ''){
                $('#smtp-username').addClass('is-invalid animation-shake');
                $('#error_smtp-username').show();
                error++;
            }
            if($('#smtp-port').val() == ''){
                $('#smtp-port').addClass('is-invalid animation-shake');
                $('#error_smtp-port').show();
                error++;
            }
            if($('#smtp-hostname').val() == ''){
                $('#smtp-hostname').addClass('is-invalid animation-shake');
                $('#error_smtp-hostname').show();
                error++;
            }
        }
        if(error === 0){
            $('#formNotif').submit();
        }
    });
})

</script>
<!--uiop-->
@endsection