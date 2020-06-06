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
</head>

<body style='background:#f1f4f5;'><div class="container-fluid checkout" style="max-width: 1200px;">
    <div class="row">
        <div class="col pt-3 px-lg-5">
            <div class="px-lg-5">
                <h4><a href="/" class="text-dark">CULTURE HERO - Guest Checkout</a></h4>                                      
                <small> Jika Anda sudah memiliki akun silakan  <a href="/login">login</a></small>
            </div>
        </div>
    </div>

    <div class="row flex-column-reverse flex-sm-row">
        <div class="col-sm-7 pt-lg-4 px-lg-5">
            <div class="px-lg-5">
                <div class="d-none d-sm-block">
                    <ul class="nav nav-tab-ck justify-content-center" role="tablist">
                        <li class="nav-item px-4">
                            <a class="nav-link active" data-toggle="tab" id="id1" href="#shipping" role="tab">
                                <span class="step mx-auto">1</span>
                                <small>Pengiriman</small>
                            </a>
                        </li>
                        <li class="nav-item px-4">
                            <a class="nav-link" data-toggle="tab" id="id2" href="#payment" role="tab">
                                <span class="step mx-auto">2</span>
                                <small>Pembayaran</small>
                            </a>
                        </li>
                        <li class="nav-item px-4">
                            <a class="nav-link" data-toggle="tab" id="id3" href="#confirm" role="tab">
                                <span class="step mx-auto">3</span>
                                <small>Review</small>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="tab-content">
                    <div class="tab-pane active" id="shipping" role="tabpanel">
                        <div class="row">
                            <div class="col-md">
                                <h5 class="mt-2">Alamat Pengiriman</h5>
                                <form id="cust_register" role="form" method="post" action="#" enctype="multipart/form-data" data-toggle="validator" novalidate="true">
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label>Nama lengkap</label>
                                            <input type="text" class="form-control" id="name" name="nama" value="" pattern="^[a-zA-Z0-9-/(). ]+$" required="" data-error="Masukkan nama Customer (tanpa spesial karakter)">
                                            <small class="help-block with-errors"></small>
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email" value="" pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" data-error="Format email tidak benar" required="" id="email-guest">
                                            <small class="help-block with-errors"></small>
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label>No. handphone</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="material-icons" style="font-size: 1rem;">phone</i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control telpon" id="phone" name="telpon" pattern="\+?([ -]?\d+)+|\(\d+\)([ -]\d+)" value="" data-error="Masukkan nomor telpon yang valid" required="">
                                            </div>
                                            <small class="help-block with-errors"></small>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="form-group col-sm-12">
                                            <label>Alamat lengkap</label>
                                            <textarea class="form-control" rows="2" id="alamat" name="alamat" required="" data-error="Masukkan alamat dengan lengkap"></textarea>
                                            <small class="help-block with-errors"></small>
                                        </div>

                                        <div class="form-group col-sm-9">
                                            <label>Kota/kecamatan</label>
                                            <div class="form-group ui-widget" data-id="lokasi">
                                                <input type="text" class="form-control ui-autocomplete-input" name="lokasi" id="lokasi-customer" placeholder="Cari Kota/kecamatan..." required="" data-error="Masukkan kota/kecamatan" value="" autocomplete="off">
                                                <span class="glyphicon glyphicon-search form-control-icon" aria-hidden="true"></span>
                                                <small class="help-block with-errors"></small>
                                                
                                                <input type="hidden" name="provinsi" id="id_provinsi" value="">
                                                <input type="hidden" name="kota" id="id_kota" value="">
                                                <input type="hidden" name="kecamatan" id="kecamatan" value="">
                                            </div>
                                        </div>

                                        <!-- JANGAN DIHAPUS
                                        buat jaga2 kalo searching error -->
                                        <!-- <div class="form-group col-sm">
                                            <label>Provinsi</label>
                                            <select name="provinsi" class="form-control" id="provinsi" data-error="Pilih Provinsi" required>
                                                <option value=""> Provinsi </option>
                                                <option value="1"> Bali </option>
                                                <option value="2"> Bangka Belitung </option>
                                                <option value="3"> Banten </option>
                                                <option value="4"> Bengkulu </option>
                                                <option value="5"> DI Yogyakarta </option>
                                                <option value="6"> DKI Jakarta </option>
                                                <option value="7"> Gorontalo </option>
                                                <option value="8"> Jambi </option>
                                                <option value="9"> Jawa Barat </option>
                                                <option value="10"> Jawa Tengah </option>
                                                <option value="11"> Jawa Timur </option>
                                                <option value="12"> Kalimantan Barat </option>
                                                <option value="13"> Kalimantan Selatan </option>
                                                <option value="14"> Kalimantan Tengah </option>
                                                <option value="15"> Kalimantan Timur </option>
                                                <option value="16"> Kalimantan Utara </option>
                                                <option value="17"> Kepulauan Riau </option>
                                                <option value="18"> Lampung </option>
                                                <option value="19"> Maluku </option>
                                                <option value="20"> Maluku Utara </option>
                                                <option value="21"> Nanggroe Aceh Darussalam (NAD) </option>
                                                <option value="22"> Nusa Tenggara Barat (NTB) </option>
                                                <option value="23"> Nusa Tenggara Timur (NTT) </option>
                                                <option value="24"> Papua </option>
                                                <option value="25"> Papua Barat </option>
                                                <option value="26"> Riau </option>
                                                <option value="27"> Sulawesi Barat </option>
                                                <option value="28"> Sulawesi Selatan </option>
                                                <option value="29"> Sulawesi Tengah </option>
                                                <option value="30"> Sulawesi Tenggara </option>
                                                <option value="31"> Sulawesi Utara </option>
                                                <option value="32"> Sumatera Barat </option>
                                                <option value="33"> Sumatera Selatan </option>
                                                <option value="34"> Sumatera Utara </option>
                                                <option value="35"> Luar Negeri </option>
                                            </select>
                                            <small class="help-block with-errors"></small>
                                        </div> --> 
                                        <!-- <div class="form-group col-sm">
                                            <label>Kab / kota</label>
                                            <select name="kota" id="kota" class="form-control" data-error="Pilih Kota" required>
                                                <option value="">Kab / kota</option>
                                            </select>
                                            <small class="help-block with-errors"></small>
                                        </div> 
                                        <div class="form-group col-sm">
                                            <label>Kecamatan</label>
                                            <select type="text" class="form-control" name="kecamatan" id="kecamatan" required data-error="Pilih kecamatan">
                                                <option value="">Kecamatan</option>
                                            </select>
                                            <small class="help-block with-errors"></small>
                                        </div> -->
                                        
                                        <div class="form-group col-sm-3">
                                            <label>Kodepos</label>
                                            <input type="text" class="form-control ui-autocomplete-input" name="kodepos" id="postalcode" value="" autocomplete="off">
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-sm-12">
                                           <h5 class="text-capitalize">Kurir</h5>
                                        </div>

                                        <div class="clearfix"></div>
                                            
                                        <input type="hidden" name="shipperO" id="shipperO" value="2092">
                                        <input type="hidden" id="shipperD" name="shipperD">
                                        <span id="isShipperActive" data-status="1"></span>

                                        <div class="form-group col-sm">
                                            <label class="text-capitalize">nama kurir</label>
                                            <select name="shipperExp" id="shipperExp" class="form-control" data-error="Pilih ekspedisi" required="">
                                               <option value="">Kurir</option>
                                            </select>
                                            <small class="help-block with-errors"></small>
                                        </div>

                                        <div class="form-group col-sm">
                                            <label class="text-capitalize">Berat</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="shipperWeight" id="shipperWeight" value="" readonly="">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Kg</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-sm">
                                            <label><span class="mr-auto">Tarif</span> <a href="javascript:void(0)" id="recalculateOngkir" class="ml-auto">refresh</a></label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Rp</span>
                                                </div> 
                                                <input type="text" class="form-control rupiah" name="shipperOngkir" id="shipperOngkir" value="0" readonly="readonly">
                                            </div>
                                        </div>

                                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
                                        <script>
                                            $( "#postalcode" ).autocomplete({
                                            	minLength: 0,
                                            	source: function(request, response) {            
                                            		var data = $.grep(kodePos, function(value) {
                                            			return value.substring(0, request.term.length).toLowerCase() == request.term.toLowerCase();
                                            		});            
                                            
                                            		response(data);
                                            	}
                                            }).focus(function () {
                                            	$(this).autocomplete("search", "");
                                            });

                                            var kodePos = [];
                                            
                                            $("#lokasi-customer").autocomplete({
                                            minLength: 3,
                                            	source: function (req, add) {
                                            		$.ajax({
                                            			url: "https://app.ngorder.id/API/region",
                                            			dataType: 'json',
                                            			type: 'GET',
                                            			data: { keyword: req.term },
                                            			success: function (data) {
                                            				if (data.data.length == 0) {
                                            					// not found
                                            				} else {
                                            					add(data.data);
                                            				}
                                            			},
                                            		});
                                            	},
                                            	change: function (event, ui) {
                                            		$(this).val((ui.item ? ui.item.fullname : ""));
                                            	},
                                            	select: function (event, ui) {
                                            		if (ui.item == null) {
                                            			
                                            			$(this).val('');
                                            			$('#id_kota').val('');
                                            			$('#kecamatan').val('');
                                            		} else {
                                            			$(this).val(ui.item.fullname);
                                            			
                                            			$('#id_kota').val(ui.item.city.id);
                                            			$('#kecamatan').val(ui.item.subdistrict.id);
                                            			$('#id_provinsi').val(ui.item.province.id);
                                            
                                                        kodePos = ui.item.postal_code;
                                                                                                            
                                                        var isShipperActive = $('#isShipperActive').data('status');
                                                        if (isShipperActive == 1) {
                                                            $("#shipperD").val(ui.item.subdistrict.id);
                                                            triggerShipperGetOngkir();
                                                        }
                                            		}
                                            		
                                            		return false;
                                            	},
                                            })
                                            .autocomplete( "instance" )._renderItem = function( ul, item ) {
                                            return $( "<li>" )
                                            	.append( "" + item.fullname + "")
                                            	.appendTo( ul ) ;
                                            };




                                            $('#recalculateOngkir').on("click", function(e){
                                               var kecamatan = $("#kecamatan").val();
                                                
                                                if( kecamatan.length > 0){
                                                    startShipper();
                                                }
                                            });

                                            function startShipper(){
                                                $('#shipperExp').empty().append('<option value="">Mencari layanan...</option>');
                                                $('#shipperOngkir').val(0);

                                                var shipperOri    = $('#shipperO').val();
                                                var shipperDes    = $('#shipperD').val();
                                                var shipperWeight = $('#shipperWeight').val();
                                                var subTotal     = parseInt($("#tsubtotal").html().replace(/[^0-9]/gi, ''));
                                                var shopID        = 252;
                                                var is_shipper    = 0;

                                                // console.log( SITE + 'shipper/get_domestic_rates?o=' + shipperOri + '&d=' + shipperDes + '&wt=' + shipperWeight + '&v=' + subTotal + '&is_privor=1&is_shipper=' + is_shipper );

                                                $.ajax({
                                                    // url: SITE + 'shipper/get_domestic_rates?o=' + shipperOri + '&d=' + shipperDes + '&wt=' + shipperWeight + '&v=' + subTotal,
                                                    url: SITE + 'API/expedition?shop_id=' + shopID +'&o=' + shipperOri + '&d=' + shipperDes + '&wt=' + shipperWeight + '&v=' + subTotal + '&is_privor=1&is_shipper=' + is_shipper,
                                                    type: 'GET',
                                                    success: function (response) {
                                                        var shipperExp = $('#shipperExp');
                                                        var shipperOngkir = $('#shipperOngkir');
                                                        shipperExp.empty();
                                                        var result = response.data;
                                                        if (result != false) {
                                                            $.each(response.data, function(k, v) {
                                                                var optgroup = $('<optgroup></optgroup>');
                                                                optgroup.attr('label', k);

                                                                $.each(v, function (k, v) {
                                                                    var option = $('<option></option>');
                                                                    var afterDiscount = v.finalRate - v.discount;
                                                                    option.attr('data-id', v.rate_id);
                                                                    option.attr('data-name', v.name);
                                                                    option.attr('data-rate-name', v.rate_name);
                                                                    option.attr('data-min-day', v.min_day);
                                                                    option.attr('data-max-day', v.max_day);
                                                                    option.attr('data-final-rate', v.finalRate);
                                                                    option.attr('data-discount', v.discount);
                                                                    option.attr('data-after-discount', afterDiscount);
                                                                    option.val(v.rate_id);
                                                                    option.text(v.name+' - '+v.rate_name);
                                                                    optgroup.append(option);
                                                                });
                                                                shipperExp.append(optgroup);
                                                            });

                                                            var firstRes          = shipperExp.find('option:first-child').data('after-discount');
                                                            shipperOngkir.val(firstRes);

                                                            $('#shipperExp').change();

                                                        } else {
                                                            var shipperExp = $('#shipperExp');
                                                            shipperExp.empty();
                                                            
                                                            var option = $('<option value=""></option>');
                                                            option.text('No courier available :(');
                                                            shipperExp.append(option);
                                                        }
                                                    },
                                                    error: function(){
                                                        var shipperExp = $('#shipperExp');
                                                        shipperExp.empty();

                                                        var option = $('<option value=""></option>');
                                                        option.text('Layanan bermasalah');
                                                        shipperExp.append(option);

                                                        // console.log('Something wrong!');
                                                    }
                                                });
                                            }

                                            $('#shipperExp').on('change', function(e) {
                                                var finalRate         = $(this).find(':selected').data('after-discount');
                                                var shipperOngkir     = $('#shipperOngkir');
                                                var ongkir            = $('#tshipping');

                                                var subTotal          = parseInt($("#tsubtotal").html().replace(/[^0-9]/gi, ''));
                                                var totalPayment      = $('#ttotal');
                                                var totalPaymentInput = $('#vtotal-price');
                                                var discount          = parseInt($('#discount').val()) || 0;
                                                var totalPaymentInt   = parseInt(subTotal) + parseInt(finalRate) - parseInt(discount);    

                                                shipperOngkir.val(finalRate);
                                                ongkir.text('Rp' + $.number(finalRate, 0, ',', '.'));
                                                ongkir.attr('data-ongkir', finalRate);

                                                totalPayment.text('Rp' + $.number(totalPaymentInt, 0, ',', '.'));
                                                totalPaymentInput.val(totalPaymentInt);
                                                $('#total_bayar').val(totalPaymentInt);
                                                $('#expeditionPeriode').text($(this).find(':selected').data('max-day'));
                                            });
                                        </script>

                                        <div class="form-group col-sm-12 pb-5">
                                            <button type="submit" class="btn btn-primary btn-lg btn-block">Pilih metode pembayaran</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                
                    <div class="tab-pane" id="payment" role="tabpanel">
                        <h5 class="mt-4 mb-1">Pilih metode pembayaran</h5>
                        <small class="d-block mb-4" style="font-size: 12px">Pilih cara termudah untuk melakukan pembayaran</small>

                        <style>
    .product-chooser{
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
            -ms-flex-direction: row;
                flex-direction: row;
        -ms-flex-wrap: wrap;
            flex-wrap: wrap;
        -webkit-box-flex: 1;
            -ms-flex: 1 0 auto;
                flex: 1 0 auto;
        margin-bottom: 1.5rem !important;
    }
    .product-chooser .product-chooser-item.selected:not(.disabled) {
        -webkit-box-shadow: 0 0 0 2px #007bff;
                box-shadow: 0 0 0 2px #007bff;
        background-color: #ebf4ff;
    }
    .product-chooser .product-chooser-item {
        -webkit-box-sizing: border-box;
                box-sizing: border-box;
        width: 100% !important;
        display: inline-block;
        margin: 0 12px 12px 0;
        padding: 12px 16px;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        -webkit-box-shadow: 0 0 0 2px #eee;
                box-shadow: 0 0 0 2px #eee;
        background-color: #fff;
        margin-right: 0 !important;
        margin-bottom: .5rem !important;
    }
    .product-chooser .product-chooser-item input {
        position: absolute;
        left: 0;
        top: 0;
        visibility: hidden;
    }
    .product-chooser .product-chooser-item img {
        min-width: 40px;
        max-width: 60px;
        height: auto;
    }
    .product-chooser-item .text-dark{
        margin: .5rem 0 0 .5rem !important;
        font-size: .975rem;
    }
    .bank-logo {
        width: 100px;
    }
    .invalid-feedback {
        display: none;
    }

    .product-chooser .product-chooser-item.disabled { 
        color: #d3d3d3; 
        -webkit-box-shadow: none; 
        box-shadow: none; 
        background-color: white;
        cursor: default;
    }

    .product-chooser .product-chooser-item.disabled h5 { 
        color: #d3d3d3; 
    }
</style>

<div class="row list-group">
    <div class="col-sm-12">

        
          
        <h6 class="mb-2 tc-text-color">
            <strong>Transfer Bank</strong> (verifikasi manual)
        </h6>
        <div class="product-chooser form-group">
                            <label for="bank" class="lbank product-chooser-item list-bank selected" title="Transfer Bank bca">
                    <img class="bank-logo" src="/assets/img/bank/bca.svg" alt="bca">
                    <input type="radio" class="item-bank d-none" name="bank" value="14899" required="">
                    <span class="text-dark tc-text-color">
                        Transfer Bank                         <span class="text-uppercase">bca</span>
                    </span>
                </label>
                            <label for="bank" class="lbank product-chooser-item list-bank" title="Transfer Bank bni">
                    <img class="bank-logo" src="/assets/img/bank/bni.svg" alt="bni">
                    <input type="radio" class="item-bank d-none" name="bank" value="14982" required="">
                    <span class="text-dark tc-text-color">
                        Transfer Bank                         <span class="text-uppercase">bni</span>
                    </span>
                </label>
                            <label for="bank" class="lbank product-chooser-item list-bank" title="Transfer Bank bri">
                    <img class="bank-logo" src="/assets/img/bank/bri.svg" alt="bri">
                    <input type="radio" class="item-bank d-none" name="bank" value="14919" required="">
                    <span class="text-dark tc-text-color">
                        Transfer Bank                         <span class="text-uppercase">bri</span>
                    </span>
                </label>
                            <label for="bank" class="lbank product-chooser-item list-bank" title="Transfer Bank BSM">
                    <img class="bank-logo" src="/assets/img/bank/bsm.svg" alt="BSM">
                    <input type="radio" class="item-bank d-none" name="bank" value="26710" required="">
                    <span class="text-dark tc-text-color">
                        Transfer Bank                         <span class="text-uppercase">BSM</span>
                    </span>
                </label>
                            <label for="bank" class="lbank product-chooser-item list-bank" title="Transfer Bank mandiriOnline">
                    <img class="bank-logo" src="/assets/img/bank/mandirionline.svg" alt="mandiriOnline">
                    <input type="radio" class="item-bank d-none" name="bank" value="9409" required="">
                    <span class="text-dark tc-text-color">
                        Transfer Bank                         <span class="text-uppercase">mandiriOnline</span>
                    </span>
                </label>
                    </div>
    </div>
</div>

                        <div class="form-group pb-5">
                            <button type="submit" class="btn btn-primary btn-lg btn-block go-to-review">Selanjutnya →</button>
                        </div>
                    </div>

                    <div class="tab-pane" id="confirm" role="tabpanel">
                        <form id="fixedCheckout" role="form" method="post" action="#" enctype="multipart/form-data" data-toggle="validator" novalidate="true">
                            <div class="card mt-3">
                                <div class="card-header">
                                    <div class="d-flex w-100 justify-content-between">
                                        <p class="small text-uppercase m-0">Alamat Pengiriman</p>
                                        <small><a href="#" class="text-muted back-to-shipping"><i class="material-icons" style="font-size: .85rem;">mode_edit</i> ubah data</a></small>
                                        <input type="hidden" name="id_customer" id="id_customer">
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="card-text mb-1" id="r-name" style="font-weight: 700;font-size: 100%;"></p>
                                    <p id="r-address" class="card-text m-0"></p>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex w-100 justify-content-between">
                                        <p class="small text-uppercase m-0">Kurir</p>
                                        <small><a href="#" class="text-muted back-to-shipping"><i class="material-icons" style="font-size: .85rem;">mode_edit</i> ubah data</a></small>
                                    </div>
                                    <input type="hidden" name="ekspedisi_paket" id="ekspedisi_paket">
                                    <input type="hidden" name="ekspedisi_kurir" id="ekspedisi_kurir">
                                    
                                </div>
                                <div class="card-body">
                                    <p class="card-text mb-0" id="r-kurir"></p>
                                    <p class="mb-0 small text-muted">Pesanan Anda akan sampai dalam <span id="expeditionPeriode"></span>  hari</p>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex w-100 justify-content-between">
                                        <p class="small text-uppercase m-0">Pembayaran</p>
                                        <small><a href="#confirm" class="text-muted back-to-payment"><i class="material-icons" style="font-size: .85rem;">mode_edit</i> ubah data</a></small>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="card-text mb-1" id="head-bank">Transfer Bank bca</p>
                                    <p class="card-text mb-0" id="name-bank" style="font-weight: 700;font-size: 100%;"></p>
                                    <p class="card-text mb-0" id="detail-bank"></p>
                                    <input type="hidden" name="bank" id="bank" value="14899">
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex w-100 justify-content-between">
                                        <p class="small text-uppercase m-0">catatan</p>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <textarea name="note" class="form-control" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg btn-block mb-5">Proses orderan</button>
                            <input type="hidden" name="uuid" value="e3ff4514-eb5e-4b1d-a3e0-5d61d30a7e5f">
                            <input type="hidden" name="id_warehouse" value="">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-5 pt-lg-4 pr-lg-5 order-list">
            <div class="px-lg-5">

                <div id="accordion">
                    <div class="card my-2">
                        <div class="card-header py-3 py-md-2">
                            <div class="d-block d-sm-none">
                                <a class="d-inline" data-toggle="collapse" data-target="#cartItemCollapse" aria-expanded="true" aria-controls="cartItemCollapse">
                                    <strong>Detail order</strong>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="7"><path fill="none" fill-rule="evenodd" stroke="#555" stroke-linecap="round" stroke-width="2" d="M1 1l4 4 4-4"></path></svg>
                                    <span class="float-right">Rp100.000</span>
                                </a>
                            </div>
                            <div class="d-none d-sm-block">
                                <strong>Detail order</strong>
                            </div>
                        </div>

                        <div id="cartItemCollapse" class="collapse d-sm-block" data-parent="#accordion">
                            <div class="card-body">
                               
                                <ul class="list-group">
                                                                            <li class="list-group-item count-item p-0 mb-3" id="list7935031">
                                            <div class="media w-100">

                                                <img class="d-flex mr-3" style="width: 64px;" src="https://cepat.b-cdn.net/products/topi-indonesia-15870994741783.jpeg?width=80" onerror="imgError(this);">
                                                <div class="media-body">
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <button type="button" class="btn btn-default btn-xs close d-none" id="7935031">
                                                                <span aria-hidden="true">×</span>
                                                            </button>          

                                                            <p class="product-title 7935031" id="7935031">
                                                                Topi Indonesia Ambigram Classic Cap Bordir Putih                                                            </p>
                                                             <input type="hidden" style="display:none" value="200" class="berat">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <span class="product-amount mt-2">
                                                                1                                                            </span> 
                                                        </div>
                                                        <div class="col-sm">
                                                            <span class="product-price mt-2">
                                                                Rp100.000                                                            </span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </li>
                                                                    </ul>

                                <table class="table total-payment">
                                    <tbody><tr>
                                        <th class="subtotal pl-0">Subtotal</th>
                                        <td class="subtotal pr-0">
                                            <p class="m-0" id="tsubtotal">Rp100.000</p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="shipping pl-0 text-capitalize">Biaya kirim</th>
                                        <td class="shipping pr-0">
                                            <p class="m-0" id="tshipping">-</p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="px-0" width="50%">
                                            <a class="pointer" data-toggle="collapse" href="#collapseCoupon" data-target="#collapseCoupon" role="button" aria-expanded="false" aria-controls="collapseCoupon">
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
                                            <p class="small" style="line-height: 1.25;margin: 10px 0 5px;" id="cAlert"></p>
                                            <span class="text-right" id="tdiscount"></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="total pl-0">Total</th>
                                        <td class="total pr-0">
                                            <h4 class="m-0" id="ttotal">Rp100.000</h4>

                                            <input type="hidden" name="total_berat" id="total_berat" value="1">
                                            <input type="hidden" name="total_realberat" id="total_realberat" value="200">

                                            <input type="text" class="form-control" name="biaya_kirim" id="biaya_kirim" value="" style="display:none">
                                            <input type="hidden" name="total_bayar" id="total_bayar">
                                            <input type="hidden" id="id_kota" name="id_kota" value="151">
                                            <input type="hidden" id="id_kecamatan" name="id_kecamatan" value="2092">
                                        </td>
                                    </tr>
                                </tbody></table>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
</body>

</html>