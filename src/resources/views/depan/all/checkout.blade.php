<!DOCTYPE html>
<html class="no-js css-menubar" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="">
    <meta name="author" content="Olshopedia">

    <title>{{ $toko->nama_toko }}</title>
    <script src="{{ asset('template/global/vendor/jquery/jquery.js') }}"></script>
    <script src="{{ asset('template/global/js/Plugin/sweetalert.js') }}"></script>
    <script src="{{ asset('alertifyjs/alertify.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('alertifyjs/css/alertify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('alertifyjs/css/themes/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('template/global/css/bootstrap.min.css') }}">
    <script src="{{ asset('template/global/vendor/bootstrap/bootstrap.js') }}"></script>

    <link rel="apple-touch-icon" href="{{ asset('template/assets/images/apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('template/assets/images/favicon.ico') }}">

    <link rel="stylesheet" href="{{ asset('template/global/fonts/font-awesome/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/fonts/web-icons/web-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/fonts/material-design/material-design.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/fonts/brand-icons/brand-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/fonts/glyphicons/glyphicons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/checkout_depan.css') }}">
    <link rel="stylesheet" href="{{ asset('jquery-ui-1.12.1.custom/jquery-ui.css') }}">
    <script src='{{ asset("jquery-ui-1.12.1.custom/jquery-ui.js") }}'></script>
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
</head>

<body style='background:#f1f4f5;'>
    <div class="container-fluid checkout" style="max-width: 1200px;">
        <div class="row" style='margin-top:30px'>
            <div class="col pt-3 px-lg-5">
                <div class="px-lg-5">
                    <h4><a href="/" class="text-dark">{{ $toko->nama_toko }} - Guest Checkout</a></h4>
                    <small> Jika Anda sudah memiliki akun silakan <a
                            href="{{ route('d.login', ['domain_toko' => $toko->domain_toko]) }}">login</a></small>
                </div>
            </div>
        </div>

        <hr>

        <div class="row flex-column-reverse flex-sm-row">
            <div class="col-sm-7 pt-lg-4 px-lg-4">
                <div class="d-none d-sm-block">
                    <div class="px-lg-5">
                        <div class="pearls row">
                            <div class="pearl current col-4">
                                <div class="pearl-icon"><i class="icon wb-user" aria-hidden="true"></i></div>
                                <span class="pearl-title">Pengiriman</span>
                            </div>
                            <div class="pearl col-4">
                                <div class="pearl-icon"><i class="icon wb-payment" aria-hidden="true"></i></div>
                                <span class="pearl-title">Pembayaran</span>
                            </div>
                            <div class="pearl col-4">
                                <div class="pearl-icon"><i class="icon wb-check" aria-hidden="true"></i></div>
                                <span class="pearl-title">Konfirmasi</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style='margin-bottom:25px;' id='kirimDiv'>
                    <div class="col-md-12">
                        <div style='background:white;border-radius:10px;'>
                            <div style='border-bottom:1px solid #e4eaec;padding:25px;'>
                                <h3 style='font-size:1.5rem;margin-bottom:0px;'>Alamat Pengiriman</h3>
                            </div>
                            <div style='padding:25px;'>
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <label>Nama Lengkap</label>
                                        <input type="text" class="form-control" id="nama" name="nama">
                                        <small style='color:red;display:none;' id='error_nama'></small>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class="form-group col-sm-6">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" id='email'>
                                        <small style='color:red;display:none;' id='error_email'></small>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label>No. Telepon</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-phone" style="font-size: 1rem;"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="no_telp" name="no_telp">
                                        </div>
                                        <small style='color:red;display:none;' id='error_no_telp'></small>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class="form-group col-sm-12">
                                        <label>Alamat Lengkap</label>
                                        <textarea class="form-control" rows="2" id="alamat" name="alamat"></textarea>
                                        <small style='color:red;display:none;' id='error_alamat'></small>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class="col-sm-9">
                                        <label>Kota/Kecamatan
                                            <span class='ml-10' id='cDari' style='color:#FAA700;font-size:12px'>*mininal 3
                                                karakter</span>
                                            <div id='pesan_kecamatan' style='display:inline-block' class='ml-10'></div>
                                        </label>
                                        <div class="input-group">
                                            <input id="kecamatan" class="ui-autocomplete-input form-control" type="text"
                                                maxlength="100" name="kecamatan" acceskey="k" autocomplete="off"
                                                role="textbox" aria-autocomplete="list" aria-haspopup="true">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id='loaderKecamatan'>
                                                    <i class="fa fa-search" style="font-size: 1rem;"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div id='hasilKecamatan' onMouseOver='pilihKec("over")' onMouseOut='pilihKec("out")'
                                            style='display:none'></div>
                                        <small style='color:red;display:none;' id='error_kecamatan'></small>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Kode Pos</label>
                                        <input type="text" class="form-control" name="kodepos"
                                            id="kodepos">
                                        <small style='color:red;display:none;' id='error_kodepos'></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style='background:white;border-radius:10px;margin-top:20px'>
                            <div style='border-bottom:1px solid #e4eaec;padding:25px;'>
                                <h3 style='font-size:1.5rem;margin-bottom:0px;'>Kurir</h3>
                            </div>
                            <div style='padding:25px;'>
                                <div class='row'>
                                    <div class="form-group col-sm-6">
                                        <label class="text-capitalize">Nama Kurir</label>
                                        <select name="shipperExp" id="shipperExp" class="form-control"
                                            data-error="Pilih ekspedisi" required="">
                                            <option value="">Kurir</option>
                                        </select>
                                        <small class="help-block with-errors"></small>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="text-capitalize">Berat</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="shipperWeight"
                                                id="shipperWeight" value="" readonly="">
                                            <div class="input-group-append">
                                                <span class="input-group-text">Kg</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class="col-sm-12">
                                        <label><span class="mr-auto">Tarif</span></label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="text" class="form-control rupiah" name="shipperOngkir"
                                                id="shipperOngkir" value="0" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style='margin-top:20px'>
                            <div class="form-group col-sm-12">
                                <button type="button" id='btnNext' class="btn btn-primary btn-lg btn-block">Pilih metode pembayaran</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-5 pt-lg-4 pr-lg-5">
                <div style='background:white;border-radius:10px;margin-top:20px'>
                    <div style='border-bottom:1px solid #e4eaec;padding:25px;'>
                        <h3 style='font-size:1.5rem;margin-bottom:0px;'>Detail Order</h3>
                    </div>
                    <div>
                        <div id="cart" class="d-sm-block">
                            <div style="padding:20px;">
                                <ul class="list-group">
                                    <li class="list-group-item p-0 mb-3">
                                        <div class="media w-100">
                                            <img class="d-flex mr-3 img-order" style="width: 64px;"
                                                src="https://cepat.b-cdn.net/products/topi-indonesia-15870994741783.jpeg?width=80">
                                            <div class="media-body">
                                                <div class="row">
                                                    <div class="col-sm">
                                                        <p style='font-size:14px;'>
                                                            Topi Indonesia Ambigram Classic Cap Bordir Putih</p>
                                                        <input type="hidden" style="display:none" value="200"
                                                            class="berat">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm">
                                                        <span class="badge-order mt-2">x 1</span>
                                                    </div>
                                                    <div class="col-sm text-right">
                                                        <span class="product-price mt-2">Rp100.000</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <table class="table" style='margin-bottom:0px;'>
                                    <tbody>
                                        <tr>
                                            <th class="subtotal pl-0" style='font-size:15px;color:#37474f;'>Subtotal</th>
                                            <td class="subtotal pr-0 text-right">
                                                <p class="m-0" id="tsubtotal">Rp100.000</p>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="shipping pl-0" style='font-size:15px;color:#37474f;'>Biaya kirim</th>
                                            <td class="shipping pr-0 text-right">
                                                <p class="m-0" id="tshipping">-</p>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="px-0" width="50%">
                                                <a class="pointer" data-toggle="collapse" href="#kuponDiv"
                                                    data-target="#kuponDiv" role="button" aria-expanded="false"
                                                    aria-controls="collapseCoupon">
                                                    <small>Punya kode kupon?</small>
                                                </a>
                                            </th>
                                            <td class="text-right px-0" width="50%">
                                                <div class="collapse" id="kuponDiv">
                                                    <input type="text" class="form-control" name="coupon" id="kupon" placeholder='Kode Kupon'>
                                                    <input type="hidden" name="coupon_code" id="coupon_code">
                                                    <input type="hidden" name="discount" id="discount">
                                                    <input type="hidden" name="persent" id="persent">

                                                </div>
                                                <p class="small" style="line-height: 1.25;margin: 0px;"
                                                    id="cAlert"></p>
                                                <span class="text-right" id="tdiscount"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="total pl-0" style='font-size:15px;color:#37474f;'>Total</th>
                                            <td class="total pr-0 text-right">
                                                <h4 class="m-0" id="ttotal">Rp100.000</h4>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    var cacheKecamatan = {},
        tampilPilih = false,
        kecamatanOld = '',
        pilihKecamatan = '';

    function pilihKec(tipe = 'over') {
        if(tipe == 'over'){
            if (!tampilPilih) {
                if (!$('#editKecamatan').length)
                    $('#hasilKecamatan').append(
                        '<div id="editKecamatan" style="color:#eb6709;display:inline-block;position:absolute;right:50px;"><div>Edit</div></div>'
                    );
                $('#hasilKecamatan').css({
                    'border': '1px solid #eb6709',
                    'padding': '10px',
                    'cursor': 'pointer'
                });
                tampilPilih = true;
            }
        } else if(tipe == 'out'){
            if (tampilPilih) {
                if ($('#editKecamatan').length)
                    $('#editKecamatan').remove();
                $('#hasilKecamatan').css({
                    'border': '1px solid #e4eaec',
                    'padding': '10px',
                    'cursor': 'default'
                });
                tampilPilih = false;
            }
        }
    }

        $(document).ready(function(){

            $('.angkaSaja').on('input', function(){
                this.value = this.value.replace(/[^0-9]/i, '');
            });

            $('#btnNext').on('click', function(){
                let error = 0;
                let nama = $('#nama').val();
                let email = $('#email').val();
                let no_telp = $('#no_telp').val();
                let alamat = $('#alamat').val();
                let kodepos = $('#kodepos').val();
                let kecamatan = $('#kecamatan').val();
                if(nama == ''){
                    $('#nama').addClass('is-invalid');
                    $('#error_nama').show();
                    $('#error_nama').html('Nama Lengkap tidak boleh kosong!');
                    error++;
                }
                if(email == ''){
                    $('#email').addClass('is-invalid');
                    $('#error_email').show();
                    $('#error_email').html('Email tidak boleh kosong!');
                    error++;
                }
                let regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (!regex.test(email) && email != '') {
                    $('#email').addClass('is-invalid');
                    $('#error_email').show();
                    $('#error_email').html('Format email tidak benar!');
                    error++;
                }
                if(no_telp == ''){
                    $('#no_telp').addClass('is-invalid');
                    $('#error_no_telp').show();
                    $('#error_no_telp').html('No Telpon tidak boleh kosong!');
                    error++;
                }
                regex = /[^0-9]/i;
                if(regex.test(no_telp) && no_telp != ''){
                    $('#no_telp').addClass('is-invalid');
                    $('#error_no_telp').show();
                    $('#error_no_telp').html('No Telpon harus angka saja!');
                    error++;
                }
                if(alamat == ''){
                    $('#alamat').addClass('is-invalid');
                    $('#error_alamat').show();
                    $('#error_alamat').html('Alamat tidak boleh kosong!');
                    error++;
                }
                if(kodepos == ''){
                    $('#kodepos').addClass('is-invalid');
                    $('#error_kodepos').show();
                    $('#error_kodepos').html('Kodepos tidak boleh kosong!');
                    error++;
                }
                if(kodepos == ''){
                    $('#kodepos').addClass('is-invalid');
                    $('#error_kodepos').show();
                    $('#error_kodepos').html('Kodepos tidak boleh kosong!');
                    error++;
                }
                regex = /[0-9]{1,3}\|[0-9]{1,3}\|[0-9]{1,4}/g;
                if(kecamatan == '' || !regex.test(kecamatan) || $('#hasilKecamatan').is(':hidden')){
                    $('#kecamatan').addClass('is-invalid');
                    $('#error_kecamatan').show();
                    $('#error_kecamatan').html('Pilih Kota/Kecamatan terlebih dahulu!');
                    error++;
                }
            });

            $('#email').on('input', function(){
                if($(this).hasClass('is-invalid')){
                    $('#email').removeClass('is-invalid');
                    $('#error_email').hide();
                }
            });

            $('#nama').on('input', function(){
                if($(this).hasClass('is-invalid')){
                    $('#nama').removeClass('is-invalid');
                    $('#error_nama').hide();
                }
            });

            $('#no_telp').on('input', function(){
                if($(this).hasClass('is-invalid')){
                    $('#no_telp').removeClass('is-invalid');
                    $('#error_no_telp').hide();
                }
            });

            $('#alamat').on('input', function(){
                if($(this).hasClass('is-invalid')){
                    $('#alamat').removeClass('is-invalid');
                    $('#error_alamat').hide();
                }
            });

            $('#kodepos').on('input', function(){
                if($(this).hasClass('is-invalid')){
                    $('#kodepos').removeClass('is-invalid');
                    $('#error_kodepos').hide();
                }
            });
            
            $("input#kecamatan").autocomplete({
                minLength: 3,
                source: function(request, response) {
                    var term = request.term;
                    if (term in cacheKecamatan) {
                        response(cacheKecamatan[term]);
                        if(cacheKecamatan[term].length > 0){
                            $("#pesan_kecamatan").html("");
                            $("#loaderKecamatan").html('<i class="fa fa-search" style="font-size: 1rem;"></i>');
                        } else {
                            $("#pesan_kecamatan").html("<span class='badge badge-danger badge-md badge-round'>Tidak ditemukan!</span>");
                            $("#loaderKecamatan").html('<i class="fa fa-search" style="font-size: 1rem;"></i>');
                        }
                        return;
                    }

                    $.ajax({
                        url: "{{ route('b.ajax-cariKecamatan') }}",
                        type: 'get',
                        dataType: "json",
                        data: request,
                        success: function(data) {
                            cacheKecamatan[term] = data;
                            response(data);
                            if(data.length > 0){
                                $("#pesan_kecamatan").html("");
                                $("#loaderKecamatan").html('<i class="fa fa-search" style="font-size: 1rem;"></i>');
                            } else {
                                $("#pesan_kecamatan").html("<span class='badge badge-danger badge-md badge-round'>Tidak ditemukan!</span>");
                                $("#loaderKecamatan").html('<i class="fa fa-search" style="font-size: 1rem;"></i>');
                            }
                        },
                        beforeSend: function(){
                            $("#loaderKecamatan").html(
                                '<div class="loaderDiv">'+
                                    '<svg class="circular-loader"viewBox="25 25 50 50" >'+
                                        '<circle class="loader-path" cx="50" cy="50" r="20" fill="none" stroke="#000000" stroke-width="2" />'+
                                    '</svg>'+
                            '</div>');
                        },
                    });
                },
                open: function(e, ui) {
                    var acData = $(this).data('uiAutocomplete');
                    acData.menu.element.find('div').each(function() {
                        var me = $(this);
                        var t = me.text();
                        me.html('');
                        me.html(t);
                    });
                },
                select: function(event, ui) {
                    let hasil = ui.item.label;
                    $('#hasilKecamatan').html(hasil);
                    $('#hasilKecamatan').show();
                    $("#cDari").hide();
                    $(this).parent().hide();
                    pilihKecamatan = ui.item.value;
                    kecamatanOld = ui.item.label;
                }
            });

            $('#hasilKecamatan').click(function() {
                if($('#kecamatan').hasClass('is-invalid')){
                    $('#kecamatan').removeClass('is-invalid');
                    $('#error_kecamatan').hide();
                }
                $(this).hide();
                $('#hasilKecamatan').html('');
                $('#kecamatan').parent().show();
                $('input#kecamatan').val(kecamatanOld);
                $("#cDari").show();
                pilihKecamatan = "";
            });

            $("#kecamatan").on('input', function(){
                if($('#kecamatan').hasClass('is-invalid')){
                    $('#kecamatan').removeClass('is-invalid');
                    $('#error_kecamatan').hide();
                }
                if($("#pesan_kecamatan").html() != ''){
                    $("#pesan_kecamatan").html('');
                }
            });

        });
    </script>
</body>

</html>