<!DOCTYPE html>
<html class="no-js css-menubar" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="">
    <meta name="author" content="Olshopedia">

    <title>{{ $toko->nama_toko }}</title>
    <link rel="stylesheet" href="{{ asset('template/global/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('alertifyjs/css/alertify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('alertifyjs/css/themes/bootstrap.min.css') }}">


    <link rel="apple-touch-icon" href="{{ asset('template/assets/images/apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('template/assets/images/favicon.ico') }}">

    <link rel="stylesheet" href="{{ asset('template/global/fonts/font-awesome/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/fonts/web-icons/web-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/fonts/material-design/material-design.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/fonts/brand-icons/brand-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/fonts/glyphicons/glyphicons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/checkout_depan.css') }}">
    <link rel="stylesheet" href="{{ asset('jquery-ui-1.12.1.custom/jquery-ui.css') }}">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://raw.githack.com/ttskch/select2-bootstrap4-theme/master/dist/select2-bootstrap4.css" rel="stylesheet" />
    <script src="{{ asset('template/global/vendor/jquery/jquery.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="{{ asset('template/global/vendor/bootstrap/bootstrap.js') }}"></script>
    <script src="{{ asset('alertifyjs/alertify.min.js') }}"></script>
    <script src="{{ asset('template/global/js/Plugin/sweetalert.js') }}"></script>
    <script src='{{ asset("jquery-ui-1.12.1.custom/jquery-ui.js") }}'></script>
</head>

<body style='background:#f1f4f5;'>
    <div class="container-fluid checkout" style="max-width: 1200px;">
        <div class="row" style='margin-top:30px'>
            <div class="col pt-3 px-lg-5">
                <div class="px-lg-5">
                    <h4><a href="/" class="text-dark">{{ $toko->nama_toko }} - Guest Checkout</a></h4>
                    <small> Jika Anda sudah memiliki akun silakan <a href="{{ route('d.login', ['domain_toko' => $toko->domain_toko]) }}">login</a></small>
                </div>
            </div>
        </div>

        <hr>

        <div class="row flex-column-reverse flex-sm-row">
            <div class="col-sm-7 pt-lg-4 px-lg-4">
                <div class="d-none d-sm-block">
                    <div class="px-lg-5">
                        <div class="pearls row">
                            <div class="pearl current col-4" id='pearl-kirim'>
                                <div class="pearl-icon"><i class="icon wb-user" aria-hidden="true"></i></div>
                                <span class="pearl-title">Pengiriman</span>
                            </div>
                            <div class="pearl col-4" id='pearl-bayar'>
                                <div class="pearl-icon"><i class="icon wb-payment" aria-hidden="true"></i></div>
                                <span class="pearl-title">Pembayaran</span>
                            </div>
                            <div class="pearl col-4" id='pearl-konfirmasi'>
                                <div class="pearl-icon"><i class="icon wb-check" aria-hidden="true"></i></div>
                                <span class="pearl-title">Konfirmasi</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style='margin-bottom:25px;' id='kirimDiv'>
                    <div class="col-md-12">
                        <div class='box-in-checkout' style=''>
                            <div class='judul'>
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
                                            <input type="text" class="form-control angkaSaja" id="no_telp" name="no_telp">
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
                                        <input type="text" class="form-control angkaSaja" name="kodepos"
                                            id="kodepos">
                                        <small style='color:red;display:none;' id='error_kodepos'></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='box-in-checkout' style='margin-top:20px'>
                            <div class='judul'>
                                <h3 style='font-size:1.5rem;margin-bottom:0px;'>Kurir</h3>
                            </div>
                            <div style='padding:25px;'>
                                <div class='row'>
                                    <div class="form-group col-sm-8">
                                        <label class="text-capitalize">Nama Kurir</label>
                                        <select id='kurir' width='100%'>
                                            <option value="" disabled selected>-- Pilih Kurir --</option>
                                        </select>
                                        <small style='color:red;display:none;' id='error_kurir'></small>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label class="text-capitalize">Berat</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="berat"
                                                id="berat" readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Gram</span>
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
                                            <input type="text" class="form-control" name="tarif"
                                                id="tarif" value="0" readonly>
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
                <div class="row" style='margin-bottom:25px;display:none;' id='bayarDiv'>
                    <div class="col-md-12">
                        <div class='box-in-checkout' style=''>
                            <div class='judul'>
                                <h3 style='font-size:1.5rem;margin-bottom:0px;'>Metode Pembayaran</h3>
                            </div>
                            <div style='padding:25px;'>
                                <div class='row'>
                                    <div class='col-sm-12'>
                                        <b style='color:black;'>Transfer Bank</b> (verifikasi manual)
                                        <div class="pilih-bank form-group" style='margin-top:10px'>
                                            <label for="bank-bca" class="pilih-bank-item selected" title="Transfer Bank bca">
                                                <img class="bank-logo" src="https://culturehero.id/assets/img/bank/bca.svg" alt="bca">
                                                <input type="radio" class="item-bank d-none" name="bank" value='bca' id='bank-bca' checked>
                                                <span class="text-dark tc-text-color">
                                                    Transfer Bank <span class="text-uppercase">bca</span>
                                                </span>
                                            </label>
                                            <label for="bank-bni" class="pilih-bank-item" title="Transfer Bank bni">
                                                <img class="bank-logo" src="https://culturehero.id/assets/img/bank/bni.svg" alt="bni">
                                                <input type="radio" class="item-bank d-none" name="bank" value='bni' id='bank-bni'>
                                                <span class="text-dark tc-text-color">
                                                    Transfer Bank <span class="text-uppercase">bni</span>
                                                </span>
                                            </label>
                                            <label for="bank-bri" class="pilih-bank-item" title="Transfer Bank bri">
                                                <img class="bank-logo" src="https://culturehero.id/assets/img/bank/bri.svg" alt="bri">
                                                <input type="radio" class="item-bank d-none" name="bank" value='bri'id='bank-bri'>
                                                <span class="text-dark tc-text-color">
                                                    Transfer Bank <span class="text-uppercase">bri</span>
                                                </span>
                                            </label>
                                            <label for="bank-bsm" class="pilih-bank-item" title="Transfer Bank BSM">
                                                <img class="bank-logo" src="https://culturehero.id/assets/img/bank/bsm.svg" alt="BSM">
                                                <input type="radio" class="item-bank d-none" name="bank" value='bsm' id='bank-bsm'>
                                                <span class="text-dark tc-text-color">
                                                    Transfer Bank <span class="text-uppercase">BSM</span>
                                                </span>
                                            </label>
                                            <label for="bank-mandiri-online" class="pilih-bank-item" title="Transfer Bank mandiriOnline">
                                                <img class="bank-logo" src="https://culturehero.id/assets/img/bank/mandirionline.svg" alt="mandiriOnline">
                                                <input type="radio" class="item-bank d-none" name="bank" value="mandiri-online" id='bank-mandiri-online'>
                                                <span class="text-dark tc-text-color">
                                                    Transfer Bank <span class="text-uppercase">mandiriOnline</span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style='margin-top:20px'>
                            <div class="form-group col-sm-12">
                                <button type="button" id='btnNext2' class="btn btn-primary btn-lg btn-block">Selanjutnya</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style='margin-bottom:25px;display:none;' id='konfirmasiDiv'>
                    <div class="col-md-12">
                        <div class='box-in-checkout' style=''>
                            <div class='judul'>
                                <h3 style='font-size:1.5rem;margin-bottom:0px;'>Alamat Pengiriman</h3>
                            </div>
                            <div style='padding:25px;'>
                                <div class='row'>
                                    <div class='col-sm-12' id='save-kirim'>
                                        -
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='box-in-checkout' style='margin-top:20px;'>
                            <div class='judul'>
                                <h3 style='font-size:1.5rem;margin-bottom:0px;'>Kurir</h3>
                            </div>
                            <div style='padding:25px;'>
                                <div class='row'>
                                    <div class='col-sm-12' id='save-kurir'>
                                        -
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='box-in-checkout' style='margin-top:20px;'>
                            <div class='judul'>
                                <h3 style='font-size:1.5rem;margin-bottom:0px;'>Pembayaran</h3>
                            </div>
                            <div style='padding:25px;'>
                                <div class='row'>
                                    <div class='col-sm-12' id='save-bayar'>
                                        -
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='box-in-checkout' style='margin-top:20px;'>
                            <div class='judul'>
                                <h3 style='font-size:1.5rem;margin-bottom:0px;'>Catatan</h3>
                            </div>
                            <div style='padding:25px;'>
                                <div class='row'>
                                    <div class='col-sm-12' id='save-note'>
                                        <textarea rows='3' class='form-control' placeholder='Catatan'></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style='margin-top:20px'>
                            <div class="form-group col-sm-12">
                                <button type="button" id='btnNext2' class="btn btn-primary btn-lg btn-block">Proses Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-5 pt-lg-4 pr-lg-5">
                <div class='box-in-checkout' style='margin-top:20px'>
                    <div class='judul'>
                        <h3 style='font-size:1.5rem;margin-bottom:0px;'>Detail Order</h3>
                    </div>
                    <div>
                        <div id="cart" class="d-sm-block">
                            <div style="padding:20px;">
                                <ul class="list-group" id='list-produk'>
                                    @php
                                        $i = 0;
                                        $total = 0;
                                        foreach(\App\Http\Controllers\PusatController::genArray($cart) as $i_c => $c){
                                            $data_prod = \DB::table('t_varian_produk')
                                                ->join('t_produk', 't_produk.id_produk', 't_varian_produk.produk_id')
                                                ->where('t_varian_produk.data_of', \App\Http\Controllers\PusatController::dataOfByDomainToko($toko->domain_toko))
                                                ->where('t_varian_produk.id_varian', $c->attributes->id_varian)
                                                ->where('t_varian_produk.produk_id', $c->attributes->id_produk)
                                                ->select(
                                                    't_produk.nama_produk',
                                                    't_produk.berat',
                                                    't_varian_produk.ukuran',
                                                    't_varian_produk.warna',
                                                    't_varian_produk.stok',
                                                    't_varian_produk.harga_jual_normal',
                                                    't_varian_produk.harga_jual_reseller',
                                                    't_varian_produk.foto_id',
                                                    't_varian_produk.diskon_jual'
                                                )
                                                ->get()->first();
                                            if(isset($data_prod)){
                                                $stok = explode('|', $data_prod->stok);
                                                if($c->quantity < (int)$stok[0]){
                                                    $harga = $data_prod->harga_jual_normal * $c->quantity;
                                                    $total += $harga;
                                                    $nama_varian = null;
                                                    if((isset($data_prod->ukuran) && $data_prod->ukuran !== '') && (isset($data_prod->warna) && $data_prod->warna !== '')){
                                                        $nama_varian = ' ('.$data_prod->ukuran.' '.$data_prod->warna.')';
                                                    } else if((isset($data_prod->ukuran) && $data_prod->ukuran !== '') && (!isset($data_prod->warna) || $data_prod->warna === '')){
                                                        $nama_varian = ' ('.$data_prod->ukuran.')';
                                                    } else if((!isset($data_prod->ukuran) || $data_prod->ukuran === '') && (isset($data_prod->warna) && $data_prod->warna !== '')){
                                                        $nama_varian = ' ('.$data_prod->warna.')';
                                                    }
                                                    if(isset($data_prod->foto_id)){
                                                        $fotoSrc = json_decode($data_prod->foto_id);
                                                        if(!is_null($fotoSrc->utama) && is_numeric($fotoSrc->utama)){
                                                            $fotoUtama = \DB::table('t_foto')
                                                                ->where('id_foto', $fotoSrc->utama)
                                                                ->where('data_of', \App\Http\Controllers\PusatController::dataOfByDomainToko($toko->domain_toko))
                                                                ->get()->first();
                                                            $gambar = asset($fotoUtama->path);
                                                            unset($fotoUtama);
                                                        } else if(!is_null($fotoSrc->utama) && filter_var($fotoSrc->utama, FILTER_VALIDATE_URL)){
                                                            $gambar = $fotoSrc->utama;
                                                        }
                                                    } else {
                                                        $gambar = asset('photo.png');
                                                    }
                                                    @endphp
                                                    <li class="list-group-item p-0 mb-3" data-berat='{{ $data_prod->berat }}' data-harga='{{ $harga }}'>
                                                        <div class="media w-100">
                                                            <img class="d-flex mr-3 img-order" style="width: 64px;"
                                                                src="{{ $gambar }}">
                                                            <div class="media-body">
                                                                <div class="row">
                                                                    <div class="col-sm">
                                                                        <p style='font-size:14px;'>{{ $data_prod->nama_produk.(isset($nama_varian) ? ' '.$nama_varian : '') }}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm">
                                                                        <span class="badge-order mt-2">x {{ $c->quantity }}</span>
                                                                    </div>
                                                                    <div class="col-sm text-right">
                                                                        <span class="product-price mt-2">{{ \App\Http\Controllers\PusatController::formatUang($harga, true) }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    @php
                                                }
                                            }
                                        }
                                    @endphp
                                </ul>
                                <table class="table" style='margin-bottom:0px;'>
                                    <tbody>
                                        <tr>
                                            <th class="subtotal pl-0" style='font-size:15px;color:#37474f;'>Subtotal</th>
                                            <td class="subtotal pr-0 text-right">
                                                <p class="m-0" id="subtotal" data-harga='{{ $total }}'>{{ \App\Http\Controllers\PusatController::formatUang($total, true) }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="shipping pl-0" style='font-size:15px;color:#37474f;'>Biaya kirim</th>
                                            <td class="shipping pr-0 text-right">
                                                <p class="m-0" id="biaya_kirim" data-harga='0'>-</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="px-0" width="50%">
                                                <a data-toggle="collapse" href="#kuponDiv"
                                                    data-target="#kuponDiv" role="button" aria-expanded="false">
                                                    <small>Punya kode kupon?</small>
                                                </a>
                                            </th>
                                            <td class="text-right px-0" width="50%">
                                                <div class="collapse" id="kuponDiv">
                                                    <input type="text" class="form-control" name="coupon" id="kupon" placeholder='Kode Kupon'>
                                                </div>
                                                <p class="small" style="line-height: 1.25;margin: 0px;"
                                                    id="cAlert"></p>
                                                <span class="text-right" id="tdiscount"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="total pl-0" style='font-size:15px;color:#37474f;'>Total</th>
                                            <td class="total pr-0 text-right">
                                                <h4 class="m-0" id="total" data-harga='{{ $total }}'>{{ \App\Http\Controllers\PusatController::formatUang($total, true) }}</h4>
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
        cacheCekOngkir = {},
        pilihKecamatan = '';

    
    function uangFormat(number) {
        var sp = number.toString().split("").reverse();
        var yt = 0;
        var te = "";
        $.each(sp, function(i, v) {
            if (yt === 3) {
                te += ".";
                yt = 0;
            }
            te += v;
            yt++;
        });
        var hasil = te.split("").reverse().join("");
        return hasil;
    }

    function uangToAngka(data, tipe = false) {
        if (tipe) {
            var angkaTemp = data.split("").reverse();
        } else {
            var angkaTemp = data.split(" ")[1].split("").reverse();
        }
        var hasil = "";
        $.each(angkaTemp, function(i, v) {
            if (v === ".") return true;
            hasil += v;
        });
        return parseInt(hasil.split("").reverse().join(""));
    }

    function cekOngkir(){
        let expedisi = {!! $cekOngkir !!};
        let asal_alamat = '{{ $alamat_toko_offset }}';
        let tujuan_alamat = pilihKecamatan;
        var berat = $('#berat').val();
        let asal = asal_alamat.split("|")[1];
        let tujuan = tujuan_alamat.split("|")[1];
        var notifCek = alertify.message('Sedang cek ongkir...', 0);
        var t_asal = asal.replace(/[^0-9]/gi, '');
        var t_tujuan = tujuan.replace(/[^0-9]/gi, '');
        var t_total = berat.toString();
        var t_term = t_asal+"_"+t_tujuan+"_"+berat.toString();
        $.each(expedisi, function(key, val) {
            let term = t_term+"_"+val;
            if(term in cacheCekOngkir){
                if (cacheCekOngkir[term].status.code === 200) {
                    var hasil = cacheCekOngkir[term].results[0];
                    if(hasil.costs.length > 0){
                        $('#kurir').append('<optgroup label="'+hasil.code.toUpperCase()+'">');
                        $.each(hasil.costs, function(i, v) {
                            var kategori = (v.service != v.description) ? v
                                .description + " (" + v.service + ")" : v
                                .description;
                            var nama = hasil.code.toUpperCase()+' - '+kategori;
                            $.each(v.cost, function(index, value) {
                                if (hasil.name == "POS Indonesia (POS)") {
                                    var etd = ' [' + value.etd.split(" ")[0] + " Hari" + ']';
                                } else if(hasil.name == "21 Express"){
                                    var etd = ' [' + value.etd + ']';
                                } else {
                                    var etd = (value.etd == "" ? "" : ' [' + value.etd + " Hari" + ']');
                                }
                                nama += etd;
                                let code = val+"|"+v.service+"|"+value.value.toString();
                                let newOption = new Option(nama, code, false, false);
                                $('#kurir').append(newOption);
                            });
                        });
                        $('#kurir').append('</optgroup>');
                        $('#kurir').trigger('change');
                    }
                    if(key == expedisi.length-1) notifCek.dismiss();
                } else {
                    console.log("error "+val+": " + JSON.stringify(cacheCekOngkir[term]));
                }
            } else {
                $.ajax({
                    url: "{{ route('b.order-cekOngkir') }}",
                    type: 'get',
                    dataType: "json",
                    data: {
                        dari: asal,
                        untuk: tujuan,
                        berat: berat,
                        v: val
                    },
                    success: function(data) {
                        cacheCekOngkir[term] = data;
                        if (data.status.code === 200) {
                            var hasil = data.results[0];
                            if(hasil.costs.length > 0){
                                $('#kurir').append('<optgroup label="'+hasil.code.toUpperCase()+'">');
                                $.each(hasil.costs, function(i, v) {
                                    var kategori = (v.service != v.description) ? v
                                        .description + " (" + v.service + ")" : v
                                        .description;
                                    var nama = hasil.code.toUpperCase()+' - '+kategori;
                                    $.each(v.cost, function(index, value) {
                                        if (hasil.name == "POS Indonesia (POS)") {
                                            var etd = ' [' + value.etd.split(" ")[0] + " Hari" + ']';
                                        } else if(hasil.name == "21 Express"){
                                            var etd = ' [' + value.etd + ']';
                                        } else {
                                            var etd = (value.etd == "" ? "" : ' [' + value.etd + " Hari" + ']');
                                        }
                                        nama += etd;
                                        let code = val+"|"+v.service+"|"+value.value.toString();
                                        let newOption = new Option(nama, code, false, false);
                                        $('#kurir').append(newOption);
                                    });
                                });
                                $('#kurir').append('</optgroup>');
                                $('#kurir').trigger('change');
                            }
                            if(key == expedisi.length-1) notifCek.dismiss();
                        } else {
                            console.log("error "+val+": " + JSON.stringify(data));
                        }
                    }
                });
            }
        });
    }

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

    function hitungTotal(){
        let list_produk = Array.prototype.slice.call($('#list-produk li'));
        var total = 0;
        list_produk.forEach(function(html) {
           total += parseInt($(html).attr('data-harga'));
        });
        total += parseInt($('#biaya_kirim').attr('data-harga'));
        $('#total').text('Rp '+uangFormat(total));
        $('#total').attr('data-harga', total);
    }

    $(document).ready(function(){

        let list_produk = Array.prototype.slice.call($('#list-produk li'));
        var berat_total = 0;
        list_produk.forEach(function(html) {
            berat_total += $(html).data('berat');
        });
        $('#berat').val(berat_total);

        
        $('#kurir').select2({
            theme: 'bootstrap4',
            width: '100%'
        });

        alertify.set('notifier','position', 'top-right');

        $('.angkaSaja').on('input', function(){
            this.value = this.value.replace(/[^0-9]/i, '');
        });

        $('.pilih-bank-item').on('click', function(){
            let list_bank = Array.prototype.slice.call($('.pilih-bank .pilih-bank-item'));
            var _this = $(this);
            list_bank.forEach(function(html) {
                if($(html).hasClass('selected')){
                    $(html).removeClass('selected');
                }
            });
            _this.addClass('selected');
        });

        $('#btnNext').on('click', function(){
            let error = 0;
            let nama = $('#nama').val();
            let email = $('#email').val();
            let no_telp = $('#no_telp').val();
            let alamat = $('#alamat').val().replace(/(<([^>]+)>)/ig, "");
            let kodepos = $('#kodepos').val().replace(/(<([^>]+)>)/ig, "");
            let kecamatan = $('#kecamatan').val();
            let kurir = $('#kurir').val();
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
            if(kurir == '' || typeof kurir === 'undefined' || kurir === null){
                $('#kurir').addClass('is-invalid');
                $('#error_kurir').show();
                $('#error_kurir').html('Silahkan pilih kurir terlebih dahulu!');
                error++;
            }
            regex = /[0-9]{1,3}\|[0-9]{1,3}\|[0-9]{1,4}/g;
            if(kecamatan == '' || !regex.test(kecamatan) || $('#hasilKecamatan').is(':hidden')){
                $('#kecamatan').addClass('is-invalid');
                $('#error_kecamatan').show();
                $('#error_kecamatan').html('Pilih Kota/Kecamatan terlebih dahulu!');
                error++;
            }
            if(error < 1){
                $('#kirimDiv').hide();
                $('#bayarDiv').show();
                if($('#pearl-kirim').hasClass('current')){
                    $('#pearl-kirim').removeClass('current');
                }
                if(!$('#pearl-kirim').hasClass('done')){
                    $('#pearl-kirim').addClass('done');
                }
                if(!$('#pearl-bayar').hasClass('current')){
                    $('#pearl-bayar').addClass('current');
                }
                if($('#pearl-bayar').hasClass('done')){
                    $('#pearl-bayar').removeClass('done');
                }
                $('#save-kirim').html($('#hasilKecamatan').text()+' ('+kodepos+')<br>'+alamat);
            }
        });

        $('#btnNext2').on('click', function(){
            let bayar = $('#bayarDiv').find('input[type=radio]:checked');
            $('#save-bayar').text(bayar.parent('label').children('span').text());
            $('#kirimDiv').hide();
            $('#bayarDiv').hide();
            $('#konfirmasiDiv').show();
            if($('#pearl-kirim').hasClass('current')){
                $('#pearl-kirim').removeClass('current');
            }
            if(!$('#pearl-kirim').hasClass('done')){
                $('#pearl-kirim').addClass('done');
            }
            if($('#pearl-bayar').hasClass('current')){
                $('#pearl-bayar').removeClass('current');
            }
            if(!$('#pearl-bayar').hasClass('done')){
                $('#pearl-bayar').addClass('done');
            }
            if(!$('#pearl-konfirmasi').hasClass('current')){
                $('#pearl-konfirmasi').addClass('current');
            }
            if($('#pearl-konfirmasi').hasClass('done')){
                $('#pearl-konfirmasi').removeClass('done');
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
                kecamatanOld = ui.item.label;
                pilihKecamatan = ui.item.value;
                cekOngkir();
            }
        });

        $('#kurir').on('change', function(){
            if($(this).hasClass('is-invalid')){
                $(this).removeClass('is-invalid');
                $('#error_kurir').hide();
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
            pilihKecamatan = '';
            $('#kurir').html('<option value="" disabled selected>-- Pilih Kurir --</option>').trigger('change');
            $('#tarif').val(0);
            $('#biaya_kirim').attr('data-harga', 0);
            $('#biaya_kirim').text('-');
            hitungTotal();
        });

        $("#kecamatan").on('input', function(){
            if($('#kecamatan').hasClass('is-invalid')){
                $('#kecamatan').removeClass('is-invalid');
                $('#error_kecamatan').hide();
            }
            if($("#pesan_kecamatan").html() != ''){
                $("#pesan_kecamatan").html('');
            }
            $('#kurir').html('<option value="" disabled selected>-- Pilih Kurir --</option>').trigger('change');
            $('#tarif').val(0);
            $('#biaya_kirim').attr('data-harga', 0);
            $('#biaya_kirim').text('-');
            hitungTotal();
        });

        $('#kurir').on('select2:select', function (e) {
            let data = e.params.data;
            let harga = data.id.split('|')[2];
            $('#tarif').val(uangFormat(harga));
            $('#biaya_kirim').attr('data-harga', harga);
            $('#biaya_kirim').text('Rp '+uangFormat(harga));
            hitungTotal();
            let kurir = data.text.split('[');
            if(kurir.length < 2){
                $('#save-kurir').html(kurir);
            } else {
                $('#save-kurir').html(kurir[0]+'<br><small>Barang anda akan sampai dalam '+kurir[1].split(']')[0]+'</small>');
            }
        });

    });
    </script>
</body>

</html>