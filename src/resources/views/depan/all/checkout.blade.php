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
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
    <style>
    .pearls {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin: 0 0 22px;
    }

    .pearl {
        position: relative;
        padding: 0;
        margin: 0;
        text-align: center;
    }

    .pearl:before,
    .pearl:after {
        position: absolute;
        top: 18px;
        z-index: 0;
        width: 50%;
        height: 4px;
        content: "";
        background-color: #f3f7f9;
    }

    .pearl:before {
        left: 0;
    }

    .pearl:after {
        right: 0;
    }

    .pearl:first-child:before,
    .pearl:last-child:after {
        display: none !important;
    }

    .pearl-number,
    .pearl-icon {
        position: relative;
        z-index: 1;
        display: inline-block;
        width: 36px;
        height: 36px;
        line-height: 32px;
        color: #fff;
        text-align: center;
        background: #ccd5db;
        border: 2px solid #ccd5db;
        border-radius: 50%;
    }

    .pearl-number {
        font-size: 18px;
    }

    .pearl-icon {
        font-size: 18px;
    }

    .pearl-title {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        display: block;
        margin-top: 0.5em;
        margin-bottom: 0;
        font-size: 16px;
        color: #526069;
    }

    .pearl.current:before,
    .pearl.current:after,
    .pearl.active:before,
    .pearl.active:after {
        background-color: #3e8ef7;
    }

    .pearl.current .pearl-number,
    .pearl.current .pearl-icon,
    .pearl.active .pearl-number,
    .pearl.active .pearl-icon {
        color: #3e8ef7;
        background-color: #fff;
        border-color: #3e8ef7;
        -webkit-transform: scale(1.3);
        transform: scale(1.3);
    }

    .pearl.disabled {
        pointer-events: none;
        cursor: auto;
    }

    .pearl.disabled:before,
    .pearl.disabled:after {
        background-color: #f3f7f9;
    }

    .pearl.disabled .pearl-number,
    .pearl.disabled .pearl-icon {
        color: #fff;
        background-color: #ccd5db;
        border-color: #ccd5db;
    }

    .pearl.error:before {
        background-color: #3e8ef7;
    }

    .pearl.error:after {
        background-color: #f3f7f9;
    }

    .pearl.error .pearl-number,
    .pearl.error .pearl-icon {
        color: #ff4c52;
        background-color: #fff;
        border-color: #ff4c52;
    }

    .pearl.done:before,
    .pearl.done:after {
        background-color: #3e8ef7;
    }

    .pearl.done .pearl-number,
    .pearl.done .pearl-icon {
        color: #fff;
        background-color: #3e8ef7;
        border-color: #3e8ef7;
    }

    .pearls-lg .pearl:before,
    .pearls-lg .pearl:after {
        top: 20px;
    }

    .pearls-lg .pearl-title {
        font-size: 18px;
    }

    .pearls-lg .pearl-number,
    .pearls-lg .pearl-icon {
        width: 40px;
        height: 40px;
        line-height: 36px;
    }

    .pearls-lg .pearl-icon {
        font-size: 20px;
    }

    .pearls-lg .pearl-number {
        font-size: 20px;
    }

    .pearls-sm .pearl:before,
    .pearls-sm .pearl:after {
        top: 16px;
    }

    .pearls-sm .pearl-title {
        font-size: 14px;
    }

    .pearls-sm .pearl-number,
    .pearls-sm .pearl-icon {
        width: 32px;
        height: 32px;
        line-height: 28px;
    }

    .pearls-sm .pearl-number {
        font-size: 16px;
    }

    .pearls-sm .pearl-icon {
        font-size: 14px;
    }

    .pearls-xs .pearl:before,
    .pearls-xs .pearl:after {
        top: 12px;
        height: 2px;
    }

    .pearls-xs .pearl-title {
        font-size: 12px;
    }

    .pearls-xs .pearl-number,
    .pearls-xs .pearl-icon {
        width: 24px;
        height: 24px;
        line-height: 20px;
    }

    .pearls-xs .pearl-number {
        font-size: 12px;
    }

    .pearls-xs .pearl-icon {
        font-size: 12px;
    }

    *,
    input,
    select,
    textarea,
    option,
    button {
        outline: none !important;
    }

    .form-control {
        box-shadow: unset;
    }

    .img-order {
        padding: 5px;
        border: 1px solid #ddd;
        border-radius: .25rem;
        background-color: #fff;
    }

    .badge-order {
        background-color: #3e8ef7;
        padding: .25rem .45rem;
        font-size: 12px;
        line-height: 10px;
        color: #fff;
        border-radius: .25rem;
        width: auto;
        font-weight: 700;
    }
    </style>
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
                                        <input type="text" class="form-control" id="nama" name="nama" value="">
                                        <small style='color:red;display:none;' id='error_nama'></small>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class="form-group col-sm-6">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" value="" id='email'>
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
                                        <label>Kota/Kecamatan</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="kecamatan" name="kecamatan">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="fa fa-search" style="font-size: 1rem;"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <small style='color:red;display:none;' id='error_kecamatan'></small>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Kode Pos</label>
                                        <input type="text" class="form-control" name="kodepos"
                                            id="kode_pos" value="">
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
                                            <th class="subtotal pl-0" style='font-size:15px;'>Subtotal</th>
                                            <td class="subtotal pr-0 text-right">
                                                <p class="m-0" id="tsubtotal">Rp100.000</p>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="shipping pl-0" style='font-size:15px;'>Biaya kirim</th>
                                            <td class="shipping pr-0 text-right">
                                                <p class="m-0" id="tshipping">-</p>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="px-0" width="50%">
                                                <a class="pointer" data-toggle="collapse" href="#collapseCoupon"
                                                    data-target="#collapseCoupon" role="button" aria-expanded="false"
                                                    aria-controls="collapseCoupon">
                                                    <small>Punya kode kupon?</small>
                                                </a>
                                            </th>
                                            <td class="text-right px-0" width="50%">
                                                <div class="collapse" id="collapseCoupon">
                                                    <input type="text" class="form-control" name="coupon" id="coupon">
                                                    <input type="hidden" name="coupon_code" id="coupon_code">
                                                    <input type="hidden" name="discount" id="discount">
                                                    <input type="hidden" name="persent" id="persent">

                                                </div>
                                                <p class="small" style="line-height: 1.25;margin: 10px 0 5px;"
                                                    id="cAlert"></p>
                                                <span class="text-right" id="tdiscount"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="total pl-0" style='font-size:15px;'>Total</th>
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
        $(document).ready(function(){

            $('#btnNext').on('click', function(){
                let error = 0;
                let email = $('#email').val();
                if(email == ''){
                    $('#email').addClass('is-invalid');
                    $('#error_email').show();
                    $('#error_email').html('Email tidak boleh kosong!');
                    error++;
                }
                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (!regex.test(email)) {
                    $('#email').addClass('is-invalid');
                    $('#error_email').show();
                    $('#error_email').html('Format email tidak benar!');
                    error++;
                }
            });

            $('#email').on('input', function(){
                if($(this).hasClass('is-invalid')){
                    $('#email').removeClass('is-invalid');
                    $('#error_email').hide();
                }
            });

        });
    </script>
</body>

</html>