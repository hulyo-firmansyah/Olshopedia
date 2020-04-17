@extends('belakang.index')
@section('isi')
<!--uiop-->
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
.ui-helper-hidden {
    display: none;
}

.ui-helper-hidden-accessible {
    position: absolute !important;
    clip: rect(1px 1px 1px 1px);
    clip: rect(1px, 1px, 1px, 1px);
}

.ui-helper-reset {
    margin: 0;
    padding: 0;
    border: 0;
    outline: 0;
    line-height: 1.3;
    text-decoration: none;
    font-size: 100%;
    list-style: none;
}

.ui-helper-clearfix:before,
.ui-helper-clearfix:after {
    content: "";
    display: table;
}

.ui-helper-clearfix:after {
    clear: both;
}

.ui-helper-clearfix {
    zoom: 1;
}

.ui-helper-zfix {
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    position: absolute;
    opacity: 0;
    filter: Alpha(Opacity=0);
}


/* Interaction Cues
----------------------------------*/
.ui-state-disabled {
    cursor: default !important;
}


/* Icons
----------------------------------*/

/* states and images */
.ui-icon {
    display: block;
    text-indent: -99999px;
    overflow: hidden;
    background-repeat: no-repeat;
}


/* Misc visuals
----------------------------------*/

/* Overlays */
.ui-widget-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

/* IE/Win - Fix animation bug - #4615 */
.ui-accordion {
    width: 100%;
}

.ui-accordion .ui-accordion-header {
    cursor: pointer;
    position: relative;
    margin-top: 1px;
    zoom: 1;
}

.ui-accordion .ui-accordion-li-fix {
    display: inline;
}

.ui-accordion .ui-accordion-header-active {
    border-bottom: 0 !important;
}

.ui-accordion .ui-accordion-header a {
    display: block;
    font-size: 1em;
    padding: .5em .5em .5em .7em;
}

.ui-accordion-icons .ui-accordion-header a {
    padding-left: 2.2em;
}

.ui-accordion .ui-accordion-header .ui-icon {
    position: absolute;
    left: .5em;
    top: 50%;
    margin-top: -8px;
}

.ui-accordion .ui-accordion-content {
    padding: 1em 2.2em;
    border-top: 0;
    margin-top: -2px;
    position: relative;
    top: 1px;
    margin-bottom: 2px;
    overflow: auto;
    display: none;
    zoom: 1;
}

.ui-accordion .ui-accordion-content-active {
    display: block;
}

.ui-autocomplete {
    position: absolute;
    cursor: default;
    width: 100px;
    overflow-y: auto;
    overflow-x: hidden;
    max-height: 350px;
}

/* workarounds */
* html .ui-autocomplete {
    width: 1px;
}

/* without this, the menu expands to 100% in IE6 */

/*
 * jQuery UI Menu 1.8.23
 *
 * Copyright 2010, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Menu#theming
 */
.ui-menu {
    list-style: none;
    padding: 2px;
    margin: 0;
    display: block;
    float: left;
    border-radius: 5px;
}

.ui-menu .ui-menu {
    margin-top: -3px;
}

.ui-menu .ui-menu-item {
    margin: 0;
    padding: 1px;
    zoom: 1;
    float: left;
    clear: left;
    width: 100%;
    border-bottom: 1px solid #e3e3e3;
}

.ui-menu .ui-menu-item div {
    text-decoration: none;
    display: block;
    padding: .2em .4em;
    line-height: 1.5;
    zoom: 1;
}

.ui-menu-item .ui-menu-item-wrapper.ui-state-active {
    background: #e3e3e3 !important;
    border: 1px solid #e3e3e3;
    color: black;
}

.ui-menu .ui-menu-item div.ui-state-hover,
.ui-menu .ui-menu-item div.ui-state-active {
    font-weight: normal;
    margin: -1px;
}

.uiop-ac-wrapper {
    min-height: 40px;
    box-sizing: border-box;
    background-color: #55E6FA;
    overflow: hidden;
}

.uiop-ac-search {
    padding: 10px;
}

.uiop-ac-wrapper .uiop-ac-option {
    width: 250px;
    background-color: #fff;
    max-height: 380px;
    overflow-y: auto;
    overflow-x: hidden;
    top: 100%;
    width: 100%;
    left: 0;
    z-index: 4;
    border-top: 0;
    border-bottom-right-radius: 4px;
    border-bottom-left-radius: 4px;
    border: 1px solid rgba(0, 0, 0, .1);
    border-top: 0;
    box-shadow: 0 4px 6px 0 rgba(32, 33, 36, .28);
}

.uiop-ac-wrapper .uiop-ac-option div {
    transition: all 0.2s ease-out;
    padding: 10px;
}

.uiop-ac-wrapper .uiop-ac-option div:hover {
    background-color: #f0f0f0;
}

.tr-ongkir:hover {
    background-color: #f0f0f0;
    cursor: pointer;
}
</style>
<div class="page-header page-header-bordered">
    <h1 class="page-title font-size-26 font-weight-100">Edit Order (Order #{{ $data_edit['order']->urut_order }})</h1>
    <div class="page-header-actions">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);"
                    onClick="pageLoad('{{ route('b.dashboard') }}')">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0);"
                    onClick="pageLoad('{{ route('b.order-index') }}')">Order</a></li>
            <li class="breadcrumb-item active">Edit Order (Order #{{ $data_edit['order']->urut_order }})</li>
        </ol>
    </div>
</div>
<div class="page-content">
    @if ($msg_sukses = Session::get('msg_success'))
    <div class='alert alert-success' id='alert-sukses' role='alert'><i class='fa fa-check'></i> SUCCESS: {{$msg_sukses}}
    </div>
    @endif
    <form id="form_order_tambah" method='post' action='#'>
        <div class='row'>
            <div class='col-md-4'>
                <div class="panel panel-bordered panel-primary animation-slide-left" style='animation-delay:100ms;'>
                    <div class="panel-heading">
                        <h3 class="panel-title pt-10 pl-10 pb-10" style='font-size:15px;'>Detail</h3>
                    </div>
                    <div class="panel-body">
                        <div class='form-group'>
                            <input type='text' id='pemesanKat' style='display:none;'>
                            <label>
                                <b>Pemesan</b>
                                <div id='loaderPemesan' style='display:inline-block' class='ml-10'></div>
                            </label>
                            <button class='btn btn-default btn-outline btn-sm float-right' id='btnPemesanC'
                                onClick='$("#tipe_custumerM").val("Pemesan")' data-target="#modTambah"
                                data-toggle="modal" type="button"><i class='fa fa-plus'></i>
                                Customer</button>
                            <input id="idPemesan" class="ui-autocomplete-input form-control" type="text" maxlength="100"
                                name="q" acceskey="b" autocomplete="off" placeholder="Cari Customer" role="textbox"
                                aria-autocomplete="list" aria-haspopup="true">
                            <div id='hasilCariPemesan' onMouseOver='pilihover()' onMouseOut='pilihout()'
                                style='display:none'></div>
                        </div>
                        <div class='form-group'>
                            <label>
                                <b>Dikirm Kepada</b>
                                <div id='loaderUntukKirim' style='display:inline-block' class='ml-10'></div>
                            </label>
                            <button class='btn btn-default btn-outline btn-sm float-right' id='btnUntukKirimC'
                                onClick='$("#tipe_custumerM").val("UntukKirim")' data-target="#modTambah"
                                data-toggle="modal" type="button"><i class='fa fa-plus'></i>
                                Customer</button>
                            <input id="idUntukKirim" class="ui-autocomplete-input form-control" type="text"
                                maxlength="100" name="q" acceskey="b" autocomplete="off" placeholder="Cari Customer"
                                role="textbox" aria-autocomplete="list" aria-haspopup="true">
                            <div id='hasilUntukKirim' onMouseOver='pilihover(true)' onMouseOut='pilihout(true)'
                                style='display:none'></div>
                        </div>
                        <div class='form-group'>
                            <label>
                                <b>Pengirim Dari</b>
                                <span class='ml-10' id='cDari' style='color:#FAA700;font-size:12px'>*mininal 3
                                    karakter</span>
                                <div id='loaderDariKirim' style='display:inline-block' class='ml-10'></div>
                            </label>
                            <input id="idDariKirim" class="ui-autocomplete-input form-control" type="text"
                                maxlength="100" name="q" acceskey="b" autocomplete="off" placeholder="Cari Kecamatan"
                                role="textbox" aria-autocomplete="list" aria-haspopup="true">
                            <div id='hasilDariKirim' onMouseOver='pilihover2()' onMouseOut='pilihout2()'
                                style='display:none'></div>
                        </div>
                        <div class='form-group'>
                            <label><b>Tanggal Order</b></label>
                            <div class="input-group input-group-icon">
                                <input type="text" class="form-control date-picker" id="tanggalOrder"
                                    name="tanggalOrder" />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="icon wb-calendar" aria-hidden="true"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($order_source['cek'] == 'on' || !is_null($data_edit['order']->order_source_id))
                            <div class='form-group'>
                                <label><b>Order Source</b></label>
                                <select class='form-control' id='orderSource'>
                                    <option value='' selected>-- Pilih Sumber Order --</option>
                                    @foreach($order_source['data'] as $os)
                                        <option value='{{ $os->id_order_source }}'>{{ $os->kategori }} - {{ $os->keterangan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class='form-group'>
                            <label><b>Catatan</b></label>
                            <textarea class='form-control' id="catatanOrder">{{ json_decode($data_edit['order']->catatan)->data }}</textarea>
                        </div>
                        <div class='form-group'>
                            <input type="checkbox" name='cNote' id='icNote' @if(json_decode($data_edit['order']->catatan)->print === true) checked @endif/>
                            <span>Tambahkan Catatan di Print Label</span>
                        </div>
                    </div>
                </div>
                <div class="panel panel-bordered panel-primary animation-slide-left" style='animation-delay:200ms;'>
                    <div class="panel-heading">
                        <h3 class="panel-title pt-10 pl-10 pb-10" style='font-size:15px;'>Pembayaran</h3>
                    </div>
                    <div class="panel-body">
                        <div class='form-group'>
                            <label><b>Status Pembayaran</b></label>
                            <select class='form-control' id='statusBayar'>
                                <option value='belum'>Belum Lunas</option>
                                <option value='cicil'>Cicilan</option>
                                <option value='lunas'>Sudah Lunas</option>
                            </select>
                        </div>
                        <div class='form-group hidden' id='tglBayar'>
                            <label><b>Tanggal Bayar</b></label>
                            <div class="input-group input-group-icon">
                                <input type="text" class="form-control date-picker" id="tanggalBayar"
                                    name="tanggalBayar" />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="icon wb-calendar" aria-hidden="true"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='form-group hidden' id='viaBayar'>
                            <label><b>Pembayaran Via</b></label>
                            <div class="dropdown" style='width:100%'>
                                <button type="button" class="btn btn-default btn-outline text-right" id="btnViaBayar"
                                    data-toggle="dropdown" aria-expanded="true" style='width:100%'>
                                    <!-- <span style='font-size:8px' class=''>&#9660;</span> -->
                                    <span class="filter-option pull-left">-- Pilih Pembayaran --</span>&nbsp;<span
                                        style='font-size:8px'>&#9660;</span>
                                </button>
                                <div class="dropdown-menu" role="menu" style='width:100%'>
                                    <a class="dropdown-item pilihViaBayar" href="javascript:void(0)" role="menuitem">
                                        <span>CASH</span>
                                    </a>
                                    {!! $bank_list !!}
                                    <!-- <a class="dropdown-item" href="javascript:void(0)" role="menuitem">
                                        <img src="https://app.ngorder.id/assets/img/bank/bca.svg" style='max-width:90px;display:inline-block' alt="BCA">
                                        <span style='display:inline-block'>BCA 35g4-5gfd-fgd</span>
                                    </a> -->
                                </div>
                            </div>
                            <!-- <select class='form-control' id="viaBayarSelect">
                                <option data-thumbnail="{{asset('photo.png')}}" value='chrome'>Chrome</option>
                            </select> -->
                        </div>
                        <div class='form-group hidden' id='nomBayar'>
                            <label><b>Nominal Pembayaran</b></label>
                            <input type="text" class="form-control uangFormat" id="nominalBayar" name="nominalBayar" />
                        </div>
                        @if(json_decode($data_edit["bayar"])->count > 0)
                        <div class='form-group' id='nomBayar'>
                            <label><b>Riwayat Pembayaran</b></label>
                            <div style='border:1px solid #e4eaec;padding:10px' id='historyBayarDiv'>
                            @foreach(json_decode($data_edit["bayar"])->data as $i_bD => $bD)
                                @if($i_bD == 0)
                                    <div data-id='bayar-{{ $bD->id_bayar }}'>
                                @else
                                    <div style='border-top:1px solid #e4eaec;' data-id='bayar-{{ $bD->id_bayar }}' class='mt-10 pt-10'>
                                @endif
                                    @php
                                        $tgl = date('j M Y', strtotime($bD->tgl_bayar));
                                        echo $tgl;
                                        unset($tgl);
                                        if($bD->via == 'CASH'){
                                            echo ' ('.$bD->via.') ';
                                        } else {
                                            $bank = explode('|', $bD->via);
                                            $no_rek = \DB::table('t_bank')
                                                ->where('data_of', App\Http\Controllers\PusatController::dataOfCek())
                                                ->where('id_bank', $bank[0])
                                                ->select('no_rek')
                                                ->get()->first();
                                            echo ' ('.$bank[1].' - '.$no_rek->no_rek.') ';
                                        }
                                    @endphp
                                    <span class='float-right'>
                                        <span class='jumlahBayarRiwayat'>{{ App\Http\Controllers\PusatController::formatUang($bD->nominal, true) }}</span>&nbsp;&nbsp;
                                        <a href='javascript:void(0)' class='hapusHistoryBayar'><i class='fa fa-trash red-800 historyBayar'></i></a>
                                        <!-- <a href='javascript:void(0)' class='hapusHistoryBayar'><div class='loader loader-circle' style='width:10px;height:10px'></div></a> -->
                                    </span>
                                </div>
                            @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @if(json_decode($data_edit['order']->kurir)->tipe == 'expedisi')
                    <div class="panel panel-bordered panel-primary animation-slide-left" style='animation-delay:300ms;'>
                        <div class="panel-heading">
                            <h3 class="panel-title pt-10 pl-10 pb-10" style='font-size:15px;'>Resi</h3>
                        </div>
                        <div class="panel-body">
                            <!-- <div class='form-group'>
                                <label><b>Resi</b></label> -->
                                <input type='text' name='resi' id='resiData' value='{{ $data_edit["order"]->resi }}' placeholder='Resi' class='form-control'>
                            <!-- </div> -->
                        </div>
                    </div>
                @endif
            </div>
            <div class='col-md-8'>
                <div class="panel animation-slide-right" style='padding:10px;animation-delay:300ms;'>
                    <div class='uiop-ac-wrapper'>
                        <input type='text' class='form-control uiop-ac-search' style='height:40px;' id='cariProduk'
                            placeholder='Cari Produk'>
                        <div class='uiop-ac-option hidden'>
                        </div>
                    </div>
                </div>
                <div class="panel panel-bordered panel-primary animation-slide-right" id='panelOrder' style='animation-delay:400ms;'>
                    <div class="panel-heading">
                        <h3 class="panel-title pt-10 pl-10 pb-10" style='font-size:15px;'>Orderan</h3>
                    </div>
                    <div class="panel-body">
                        <div><b>Total Berat Produk : </b>&nbsp;&nbsp;&nbsp;&nbsp;<div id='totalBerat'
                                style='display:inline-block'>0</div>&nbsp;Kg</div><br>
                        <div class="table-responsive">
                            <table class="table" id="table_order">
                                <thead>
                                    <tr>
                                        <th width="30%">Nama</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th class='text-right'>Subtotal</th>
                                        <th width="5%"></th>
                                    </tr>
                                </thead>
                                <tbody id='produk-list-kosong'>
                                    <tr class='text-center' style=''>
                                        <td colspan="4">Belum ada produk yang ditambahkan</td>
                                    </tr>
                                </tbody>
                                <tbody id='produk-list' style="display:none;">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2">Total Harga Produk</th>
                                        <th id="jumlahStok"></th>
                                        <th id="jumlahHarga" class="text-right"></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-bordered panel-primary animation-slide-right" style='animation-delay:500ms;'>
                    <div class="panel-heading">
                        <h3 class="panel-title pt-10 pl-10 pb-10" style='font-size:15px;'>Kurir</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table" id="table_ongkir">
                                <thead>
                                    <tr>
                                        <th width="30%">Kurir</th>
                                        <th>Kategori</th>
                                        <th>Etd</th>
                                        <th class='text-right'>Tarif</th>
                                    </tr>
                                </thead>
                                <tbody id='expedisi-list'>
                                </tbody>
                                <tbody id='kurir-list'>
                                    <tr class='tr-ongkir tro-toko'>
                                        <td>Ambil di Toko</td>
                                        <td>Manual</td>
                                        <td>-</td>
                                        <td class='text-right'>Rp 0</td>
                                    </tr>
                                    <tr class='tr-ongkir tro-kur'>
                                        <td>Nama Kurir</td>
                                        <td>Manual</td>
                                        <td>-</td>
                                        <td class='text-right'>Rp 0</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan='3'>Ongkos Kirim</th>
                                        <th class='text-right' id='ongkir'>Rp 0</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class='row' style='display:none;' id='ongKurir'>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <label><b>Nama Kurir</b></label>
                                    <input type="text" class="form-control disabled" id="namaKurir"
                                        placeholder='Nama Kurir' />
                                </div>
                            </div>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <label><b>Tarif</b></label>
                                    <input type="text" class="form-control disabled" id="tarifKurir" placeholder='0' />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-bordered panel-primary animation-slide-right" style='animation-delay:600ms;'>
                    <div class="panel-heading">
                        <h3 class="panel-title pt-10 pl-10 pb-10" style='font-size:15px;'>Total Akhir</h3>
                    </div>
                    <div class="panel-body">
                        <button type='button' class='btn btn-success btn-outline btn-sm'
                            data-target="#tambahDiskonOrder" data-toggle="modal"><i class='fa fa-plus'></i> Diskon
                            Order</button>
                        <button type='button' class='btn btn-success btn-outline btn-sm' data-target="#tambahBiayaLain"
                            data-toggle="modal"><i class='fa fa-plus'></i> Biaya Lain</button><br>
                        <div class="table-responsive">
                            <table class="table" id="table_ongkir">
                                <thead>
                                    <tr>
                                        <th width="50%">Nama</th>
                                        <th class='text-right'>Harga/Tarif</th>
                                        <th class='text-center' width="5%"></th>
                                    </tr>
                                </thead>
                                <tbody id='total-list'>
                                    <tr id='totalHargaProduk'>
                                        <td>Total Harga Produk</td>
                                        <td class='text-right'>Rp 0</td>
                                        <td></td>
                                    </tr>
                                    <tr id='totalOngkir'>
                                        <td>Ongkos Kirim</td>
                                        <td class='text-right'>Rp 0</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                <tbody id='biayaLain-list'>
                                </tbody>
                                <tbody id='diskonOrder-list'>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th class='text-right' id='totalHarga'>Rp 0</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-xxl-6 hidden-xl-down'>
                    </div>
                    <div class='col-xxl-6'>
                        <button class="btn btn-success btn-block animation-slide-bottom mt-10"
                            style='animation-delay:800ms;' type="button" id="btnsimpan_produk"
                            onClick='simpan_order()'>Simpan Order</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
var pemesanOld = '',
    untukKirimOld = '',
    dariKirimOld = '',
    pilihUntuk = '',
    pilihDari = '';
var tampilPilih = false,
    tampilPilih2 = false,
    tampilPilih3 = false,
    sudahCekOngkir = false;
var limit = 90;
var prodTam = [],
    cacheProvinsiAll = [];
var cacheCust = {},
    cacheDariKirim = {},
    cacheKabupaten = {},
    cacheKecamatan = {},
    cacheKecamatan_Kabupaten = {},
    cacheCekOngkir = {},
    cacheProduk = {};
var temp_harga_edit = {};
temp_harga_edit.cek = false; 
temp_harga_edit.data = '';
temp_harga_edit.id = '';
var isCekTemp_harga_edit = false;
var kat_customer = {!! $kat_customer !!};


var simpan_order = function(tipeKirim = "simpan") {
    var data = {};
    var error = [];
    if ($("#hasilCariPemesan").text() == "") {
        error.push({
            id: "#idPemesan",
            msg: "Pemesan belum diisi!"
        });
    }
    if ($("#hasilUntukKirim").text() == "") {
        error.push({
            id: "#idUntukKirim",
            msg: "Tujuan Pengiriman belum diisi!"
        });
    }
    if ($("#hasilDariKirim").text() == "") {
        error.push({
            id: "#idDariKirim",
            msg: "Pengirim dari belum diisi!"
        });
    }
    if ($("#tanggalOrder").val() == "") {
        error.push({
            id: "#tanggalOrder",
            msg: "Tanggal Order belum diisi!"
        });
    }
    if ($("#statusBayar").val() == "cicil" && $('#statusBayar').val() != "{!! json_decode($data_edit['order']->pembayaran)->status !!}") {
        if($("#tanggalBayar").val() == ""){
            error.push({
                id:"#tanggalBayar",
                msg:"Tanggal Bayar belum diisi!"
            });
        }
        if($("#btnViaBayar").children(".filter-option").text() == "-- Pilih Pembayaran --" || $("#btnViaBayar").children(".filter-option").text() == ""){
            error.push({
                id:"#btnViaBayar",
                msg:"Belum memilih via pembayaran!"
            });
        }
        if($("#nominalBayar").val() == ""){
            error.push({
                id:"#nominalBayar",
                msg:"Nominal Bayar belum diisi!"
            });
        }
    } else if ($("#statusBayar").val() == "lunas" && $('#statusBayar').val() != "{!! json_decode($data_edit['order']->pembayaran)->status !!}") {
        if($("#tanggalBayar").val() == ""){
            error.push({
                id:"#tanggalBayar",
                msg:"Tanggal Bayar belum diisi!"
            });
        }
        if($("#btnViaBayar").children(".filter-option").text() == "-- Pilih Pembayaran --" || $("#btnViaBayar").children(".filter-option").text() == ""){
            error.push({
                id:"#btnViaBayar",
                msg:"Belum memilih via pembayaran!"
            });
        }
    } else if($("#produk-list tr").length == 0){
        error.push({
            id:"#panelOrder",
            msg:"Belum ada produk yang ditambahkan!"
        });
    }
    if (error.length > 0) {
        var datError = "<ul style='padding-left:40px'>";
        $.each(error, function(i, v) {
            if(v.id == "#btnViaBayar"){
                $(v.id).addClass("animation-shake");
                $(v.id).attr("style", "border-color:#FAA700;width:100%");
            } else if(v.id == "#panelOrder"){
                $(v.id).removeClass("panel-primary");
                $(v.id).removeClass("animation-slide-right");
                $(v.id).addClass("animation-shake panel-warning");
            } else {
                $(v.id).addClass("animation-shake");
                $(v.id).attr("style", "border-color:#FAA700;");
            }
            datError += "<li>"+v.msg+"</li>";
        });
        datError += "</ul>";
        if($("#alert-error").length){
            $("#alert-error").remove();
        }
        $(".page-content").prepend(
    '<div role="alert" id="alert-error" class="alert alert-warning alert-dismissible">'+
        '<button aria-label="Close" data-dismiss="alert" class="close" type="button">'+
            '<span aria-hidden="true">×</span>'+
        '</button>'+
        '<h4><i class="fa fa-warning"></i> Warning</h4>'+
        datError+
    '</div>');
    } else if(error.length == 0){
        data.id_order = '{{ $data_edit["order"]->id_order }}';
        data.resi = $('#resiData').length > 0 ? $('#resiData').val() : null;
        // data.redirect = tipeKirim;
        data.src = "app";
        data.kat_customer = JSON.stringify(kat_customer);
        data.idPemesan_customer = $("#idPemesan").val();
        data.idUntukKirim_customer = $("#idUntukKirim").val();
        data.idDariKirim_kecamatan = $("#idDariKirim").val()+"|"+$('#hasilDariKirim').text();
        data.tanggalOrder = $("#tanggalOrder").val();
        data.catatan = $("#catatanOrder").val();
        data.catatanPrint = $('#icNote')[0].checked.toString();
        // data.catatanPrint = ($('#icNote').iCheck('update')[0].checked == true) ? "true" : "false";
        if(typeof $("#btnViaBayar").data('idb') !== 'undefined'){
            var data_via_bayar = $("#btnViaBayar").data('idb')+"|"+$.trim($("#btnViaBayar").children(".filter-option").text());
        } else {
            var data_via_bayar = $.trim($("#btnViaBayar").children(".filter-option").text());
        }
        data.pembayaran = {
            status: $("#statusBayar").val(),
            tanggalBayar: $("#tanggalBayar").val(),
            via: data_via_bayar
        };
        if(data.pembayaran.status == "lunas"){
            data.pembayaran.nominal = uangToAngka($("#totalHarga").text());
        } else {
            data.pembayaran.nominal = $("#nominalBayar").val();
        }
        // if(data.pembayaran.status == "lunas" || data.pembayaran.status == "cicil"){
        //     data.state = "proses";
        // } else {
        //     data.state = "bayar";
        // }
        data.state = "{!! $data_edit['order']->state !!}";
        data.produk = {};
        data.produk.totalBerat = ($("#totalBerat").text().replace(",", ".") * 1000);
        if($("#produk-list tr").length == 0){
            data.produk.list = [];
        } else if($("#produk-list tr").length > 0){
            var tempProd = [];
            var list = Array.prototype.slice.call($("#produk-list tr"));
            list.forEach(function(html) {
                tempProd.push({
                    rawData: jQuery.parseJSON($(html).children("td:first").children("textarea").val()),
                    jumlah: parseInt($(html).children(".jumlahHitung").text())
                });
            });
            data.produk.list = tempProd;
            tempProd = list = undefined;
        }
        data.kurir = {};
        if($(".tr-ongkir-selected").hasClass("tro-expedisi")){
            data.kurir.tipe = "expedisi";
            data.kurir.data = $(".tr-ongkir-selected").children("td:first").children("input").val();
        } else if($(".tr-ongkir-selected").hasClass("tro-toko")) {
            data.kurir.tipe = "toko";
        } else if($(".tr-ongkir-selected").hasClass("tro-kur")) {
            data.kurir.tipe = "kurir";
            data.kurir.data = {
                nama: $("#namaKurir").val(),
                harga: parseInt($("#tarifKurir").val()) || 0
            };
        }
        data.total = {};
        data.total.hargaProduk = uangToAngka($("#totalHargaProduk").children("td:nth-child(2)").text());
        data.total.hargaOngkir = uangToAngka($("#totalOngkir").children("td:nth-child(2)").text());
        if($("#biayaLain-list tr").length == 0){
            data.total.biayaLain = null;
        } else if($("#biayaLain-list tr").length > 0){
            var tempLain = [];
            var list = Array.prototype.slice.call($("#biayaLain-list tr"));
            list.forEach(function(html) {
                tempLain.push({
                    nama: $(html).children("td:first").text().split("(")[0],
                    harga: uangToAngka($(html).children("td:nth-child(2)").text())
                });
            });
            data.total.biayaLain = tempLain;
            tempLain = list = undefined;
        }
        if($("#diskonOrder-list tr").length == 0){
            data.total.diskonOrder = null;
        } else if($("#diskonOrder-list tr").length > 0){
            var tempDiskon = [];
            var list = Array.prototype.slice.call($("#diskonOrder-list tr"));
            list.forEach(function(html) {
                tempDiskon.push({
                    nama: $(html).children("td:first").text().split("(")[0],
                    harga: uangToAngka($(html).children("td:nth-child(2)").text().split(" ")[2], true)
                });
            });
            data.total.diskonOrder = tempDiskon;
            tempDiskon = list = undefined;
        }
        if($("#produk-list tr").length == 0){
            data.total.diskonProduk = null;
        } else if($("#produk-list tr").length > 0){
            var tempDiskon_ = [];
            var list_ = Array.prototype.slice.call($("#produk-list tr"));
            list_.forEach(function(html) {
                var isi_ = $(html).children('td:nth-child(2)').children('.diskonHitung').text();
                if(isi_ != ''){
                    if (isi_.split(" ")[1] == "Rp") {
                        var diskon__ = uangToAngka(isi_.split(" ")[2].replace(")", ""), true);
                        var tipe_ = '*';
                    } else {
                        var diskon__ = uangToAngka(isi_.split(" ")[1].replace("%", ''), true);
                        var tipe_ = '%';
                    }
                    var data_ = jQuery.parseJSON($(html).children('td:first').children('textarea').text());
                    tempDiskon_.push({
                        id_varian: data_.id_varian,
                        harga: diskon__,
                        tipe: tipe_
                    });
                }
            });
            if(tempDiskon_.length == 0){
                tempDiskon_ = null;
            }
            data.total.diskonProduk = tempDiskon_;
            tempDiskon_ = list_ = data_ = diskon__ = tipe_ = undefined;
        }
        data.order_source = ($('#orderSource').length == 0) ? null : ($('#orderSource').val() == '' ? null : $('#orderSource').val());
        data.pemesan_kat = $('#pemesanKat').val();
        if(!jQuery.isEmptyObject(data)){
            // console.log(data);
            var url = "{{route('b.order-editProses')}}";
            var form = $("<form action='"+url+"' method='post'></form>");
            form.append('{{ csrf_field() }}');
            form.append('<textarea name="dataRaw">'+JSON.stringify(data)+'</textarea>');
            form.append('<textarea name="dataRaw">'+JSON.stringify(data)+'</textarea>');
            $('body').append(form);
            form.submit();
        }
    }
    // console.log("error: ", error);
    // console.log("data: ", data);
}

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

function hapusIsi() {
    $('#error_namaC').html(" ");
    $('#error_namaC').hide();
    $('#error_emailC').html(" ");
    $('#error_emailC').hide();
    $('#error_provinsiC').html(" ");
    $('#error_provinsiC').hide();
    $('#error_kabupatenC').html(" ");
    $('#error_kabupatenC').hide();
    $('#error_kecamatanC').html(" ");
    $('#error_kecamatanC').hide();
    $('#error_kode_posC').html(" ");
    $('#error_kode_posC').hide();
    $('#error_no_telpC').html(" ");
    $('#error_no_telpC').hide();
    $('#error_alamatC').html(" ");
    $('#error_alamatC').hide();
    $('#namaC').removeClass("animation-shake");
    $('#namaC').removeClass("is-invalid");
    $('#namaC').val("");
    $('#emailC').removeClass("animation-shake");
    $('#emailC').removeClass("is-invalid");
    $('#emailC').val("");
    $('#provinsiC').parent().children('button').removeClass("animation-shake");
    $('#provinsiC').selectpicker('val', '');
    $('#kabupatenC').parent().children('button').removeClass("animation-shake");
    $('#kabupatenC').selectpicker('val', '');
    $('#kecamatanC').parent().children('button').removeClass("animation-shake");
    $('#kecamatanC').selectpicker('val', '');
    $('#kategoriC').selectpicker('val', 'Customer');
    $('#kode_posC').removeClass("animation-shake");
    $('#kode_posC').removeClass("is-invalid");
    $('#kode_posC').val("");
    $('#no_telpC').removeClass("animation-shake");
    $('#no_telpC').removeClass("is-invalid");
    $('#no_telpC').val("");
    $('#alamatC').removeClass("animation-shake");
    $('#alamatC').removeClass("is-invalid");
    $('#alamatC').val("");
}

function pilihover(tipe = false) {
    if (!tipe) {
        if (!tampilPilih) {
            if (!$('#editPemesan').length)
                $('#hasilCariPemesan').append(
                    '<div id="editPemesan" style="text-align:center;color:#eb6709;width:100%"><div>Edit</div></div>');
            $('#hasilCariPemesan').css({
                'border': '1px solid #eb6709',
                'padding': '10px',
                'cursor': 'pointer'
            });
            tampilPilih = true;
        }
    } else {
        if (!tampilPilih2) {
            if (!$('#editUntukKirim').length)
                $('#hasilUntukKirim').append(
                    '<div id="editUntukKirim" style="text-align:center;color:#eb6709;width:100%"><div>Edit</div></div>'
                );
            $('#hasilUntukKirim').css({
                'border': '1px solid #eb6709',
                'padding': '10px',
                'cursor': 'pointer'
            });
            tampilPilih2 = true;
        }
    }
}

function pilihout(tipe = false) {
    if (!tipe) {
        if (tampilPilih) {
            if ($('#editPemesan').length)
                $('#editPemesan').remove();
            $('#hasilCariPemesan').css({
                'border': 'none',
                'padding': '0px',
                'cursor': 'default'
            });
            tampilPilih = false;
        }
    } else {
        if (tampilPilih2) {
            if ($('#editUntukKirim').length)
                $('#editUntukKirim').remove();
            $('#hasilUntukKirim').css({
                'border': 'none',
                'padding': '0px',
                'cursor': 'default'
            });
            tampilPilih2 = false;
        }
    }
}

function pilihover2() {
    if (!tampilPilih3) {
        if (!$('#editDariKirim').length)
            $('#hasilDariKirim').append(
                '<div id="editDariKirim" style="color:#eb6709;display:inline-block;position:absolute;right:50px;"><div>Edit</div></div>'
            );
        $('#hasilDariKirim').css({
            'border': '1px solid #eb6709',
            'padding': '10px',
            'cursor': 'pointer'
        });
        tampilPilih3 = true;
    }
}

function pilihout2() {
    if (tampilPilih3) {
        if ($('#editDariKirim').length)
            $('#editDariKirim').remove();
        $('#hasilDariKirim').css({
            'border': 'none',
            'padding': '0px',
            'cursor': 'default'
        });
        tampilPilih3 = false;
    }
}

function parseHtml(me) {
    var t = me.split('|');
    if (t[6] == "Dropshipper") {
        var kategoriC = "<span class='badge badge-outline badge-info ml-10 badge-lg' style='display:inline-block'>" + t[
            6] + "</span>";
    } else if (t[6] == "Reseller") {
        var kategoriC = "<span class='badge badge-outline badge-success ml-10 badge-lg' style='display:inline-block'>" +
            t[6] + "</span>";
    } else {
        var kategoriC = "";
    }
    return "<h4 class='mb-0 mt-1'><b>" + t[0] + "</b>" + kategoriC + "</h4><small><span>" + t[1] +
        "</span><br><span>Kec. " + t[2] +
        ", " + t[3] + "</span><br><span>" + t[4] + ", " + t[5] + "</span></small>";
}

function parseProdukData(source, item){
    $.each(source, function(i, v) {
        var nama_produk_tampil = v.nama_produk;
        if((v.ukuran != null && v.ukuran != "") && (v.warna != null && v.warna != "")){
            nama_produk_tampil += " ("+v.ukuran+" "+v.warna+") ";
        } else if((v.ukuran != null && v.ukuran != "") && (v.warna == null || v.warna == "")){
            nama_produk_tampil += " ("+v.ukuran+") ";
        } else if((v.ukuran == null || v.ukuran == "") && (v.warna != null && v.warna != "")){
            nama_produk_tampil += " ("+v.warna+") ";
        }
        if(v.foto != null && v.foto != ''){
            if(v.foto.utama != null){
                var foto = v.foto.utama;
            } else {
                var foto = '{{ asset("photo.png") }}';
            }
        } else {
            var foto = '{{ asset("photo.png") }}';
        }
        var stok = v.stok.split("|");
        if (stok[1] == "sendiri" && stok[0] == 0) {
            var tampilStok = '';
            var tampilButton =
                '<button type="button" class="btn btn-sm btn-danger disabled" style="margin-top:10px"><i class="fa fa-close"></i> Stok tidak tersedia</button>';
        } else if (stok[1] == "sendiri" && stok[0] > 0) {
            var tampilStok =
                '<input name="jumlah_produk" type="text" style="border-color:#28c0de" class="form-control uangFormat spin_' +
                v.id_varian + '-' + v.produk_id + '">';
            var tampilButton =
                '<button type="button" class="btn btn-sm btn-success btnTam" style="margin-top:10px"><i class="fa fa-plus"></i> Tambahkan</button>';
        } else if (stok[1] == "lain" && stok[0] == 1) {
            var tampilStok =
                '<input name="jumlah_produk" type="text" style="border-color:#28c0de" class="form-control uangFormat spin_' +
                v.id_varian + '-' + v.produk_id + '">';
            var tampilButton =
                '<button type="button" class="btn btn-sm btn-success btnTam" style="margin-top:10px"><i class="fa fa-plus"></i> Tambahkan</button>';
        } else if (stok[1] == "lain" && stok[0] == 0) {
            var tampilStok = "";
            var tampilButton =
                '<button type="button" class="btn btn-sm btn-danger disabled" style="margin-top:10px"><i class="fa fa-close"></i> Stok tidak tersedia</button>';
        }
        if (stok[1] == "sendiri") {
            var maxStok = stok[0];
        } else if (stok[1] == "lain") {
            var maxStok = 100;
        }
        var cekCustomerRole = null;
        if ($("#pemesanKat").val() != "") {
            cekCustomerRole = $("#pemesanKat").val();
        }
        if (v.diskon_jual == null || (v.diskon_jual.split("|")[1] ==
                "%" && v.diskon_jual.split("|")[0] == 0)) {
            if(cekCustomerRole == "Reseller"){
                var hargaTampil = "Rp " + uangFormat((v.harga_jual_reseller == null ? v.harga_jual_normal : v.harga_jual_reseller));
            } else {
                var hargaTampil = "Rp " + uangFormat(v.harga_jual_normal);
            }
        } else {
            var hitungHarga = v.diskon_jual.split("|")[0];
            var tipeHitungHarga = v.diskon_jual.split("|")[1];
            if (tipeHitungHarga == "%") {
                if(cekCustomerRole == "Reseller"){
                    var hargaAwal = (v.harga_jual_reseller == null) ? v.harga_jual_normal : v.harga_jual_reseller;
                } else {
                    var hargaAwal = v.harga_jual_normal;
                }
                var hargaDiskon = Math.round(((parseInt(hitungHarga) *
                    hargaAwal) / 100)) || 0;
                var hargaAkhir = hargaAwal - hargaDiskon;
            } else if (tipeHitungHarga == "*") {
                if(cekCustomerRole == "Reseller"){
                    var hargaAwal = (v.harga_jual_reseller == null) ? v.harga_jual_normal : v.harga_jual_reseller;
                } else {
                    var hargaAwal = v.harga_jual_normal;
                }
                var hargaAkhir = hargaAwal - parseInt(hitungHarga);
            }
            var hargaTampil = "<s>Rp " + uangFormat(hargaAwal) + "</s> Rp " + uangFormat(
                    hargaAkhir);
            nama_produk_tampil += '&nbsp;&nbsp;<span class="badge badge-danger badge-round" style="font-size:12px;vertical-align:middle">Diskon</span>';
        }
        if(v.harga_grosir == 1){
            nama_produk_tampil += '&nbsp;&nbsp;<span class="badge badge-success badge-round" style="font-size:12px;vertical-align:middle">Grosir</span>';
        }
        item.append(
            '<div class="row" style="margin:3px;padding:3px"><div class="col-xxl-1 col-lg-2 col-md-3 col-sm-3 text-center"><img class="rounded" width="50" height="50" src="' +
            foto +
            '"></div><div class="col-xxl-6 col-lg-4 col-md-9 col-sm-9">' +
            nama_produk_tampil +
            '<br>' + hargaTampil +
            '</div><div class="col-xxl-3 col-lg-4 col-md-6 col-sm-6">' +
            tampilStok + '</div>' +
            '<div class="col-xxl-1 col-md-2 col-lg-2 col-sm-2 text-center">' +
            tampilButton + '</div></div>');

        $(".spin_" + v.id_varian + "-" + v.produk_id).TouchSpin({
            min: 1,
            max: maxStok,
            initval: 1,
            buttondown_class: "btn btn-info btn-outline",
            buttonup_class: "btn btn-info btn-outline"
        });
        $(".spin_" + v.id_varian + "-" + v.produk_id).parent().attr(
            'style', "width:180px");
        $('.toolbtn').tooltip({
            trigger: 'hover',
            title: 'Stok Tidak Tersedia',
            placement: 'top'
        });
    });
}

function cekProdTam() {
    var juml = $("#produk-list tr").length;
    if (juml === 0) {
        $("#produk-list-kosong").show();
        $("#produk-list").hide();
        $("#expedisi-list").html("");
    } else {
        $("#produk-list-kosong").hide();
        $("#produk-list").show();
    }
    sudahCekOngkir = false;
}

function hitungSubTotal() {
    var juml = $("#produk-list tr").length;
    if (juml > 0) {
        var list = Array.prototype.slice.call($('.jumlahHitung'));
        var hasilHitung = 0;
        list.forEach(function(html) {
            hasilHitung += parseInt($(html).text());
        });
        $('#jumlahStok').text(hasilHitung);

        var list2 = Array.prototype.slice.call($('.uangHitung'));
        var hasilHitung2 = 0;
        list2.forEach(function(html2) {
            hasilHitung2 += uangToAngka($(html2).text());
        });
        $('#jumlahHarga').text("Rp " + uangFormat(hasilHitung2));
    } else if (juml === 0) {
        $("#jumlahStok").text("");
        $("#jumlahHarga").text("");
    }
    cekTotalHarga("produk");
}

function cekTotalHarga(tipe) {
    if (tipe == "produk") {
        if ($("#jumlahHarga").text() == "") {
            var hargaProduk = "Rp 0";
        } else {
            var hargaProduk = $("#jumlahHarga").text();
        }
        $("#totalHargaProduk").children("td:nth-child(2)").text(hargaProduk);
    } else if (tipe == "ongkir") {
        $("#totalOngkir").children("td:nth-child(2)").text($("#ongkir").text());
    }
    hitungTotalHarga();
}

function hitungTotalHarga() {
    var totalHargaProduk = uangToAngka($("#totalHargaProduk").children("td:nth-child(2)").text());
    var totalOngkir = uangToAngka($("#totalOngkir").children("td:nth-child(2)").text());
    if ($("#biayaLain-list tr").length == 0) {
        var hasilSemen = totalHargaProduk + totalOngkir;
    } else {
        var hasilSemen = totalHargaProduk + totalOngkir;
        var list = Array.prototype.slice.call($("#biayaLain-list tr"));
        list.forEach(function(html) {
            var angkaBiaya = uangToAngka($(html).children("td:nth-child(2)").text().split(" ")[1], true);
            hasilSemen += angkaBiaya;
        });
    }
    if ($("#diskonOrder-list tr").length == 0) {
        var hasil = hasilSemen;
        hasil = "Rp " + uangFormat(hasil);
    } else {
        var tempHasil = hasilSemen;
        var list = Array.prototype.slice.call($("#diskonOrder-list tr"));
        list.forEach(function(html) {
            var angkaDis = uangToAngka($(html).children("td:nth-child(2)").children("div").text().split(" ")[2],
                true);
            tempHasil -= angkaDis;
        });
        var hasil = tempHasil;
        if (hasil < 0) {
            hasil = parseInt(hasil.toString().replace("-", ''));
            hasil = "- Rp " + uangFormat(hasil);
        } else {
            hasil = "Rp " + uangFormat(hasil);
        }
    }
    $("#totalHarga").text(hasil);
}

function loadAwalOrderan(dataProd, jumlahProd, dataLamaProd){
    var cekCustomerRole = null;
    if ($("#pemesanKat").val() != "") {
        cekCustomerRole = $("#pemesanKat").val();
    }
    if(cekCustomerRole == null){
        alertify.warning('Pilih Pemesan terlebih dahulu!').dismissOthers();
        return;
    }
    var id_varianProd = dataProd.id_varian;
    var totalBerat = parseInt($("#totalBerat").text().replace(",", ".")) * 1000;
    var hasilBerat = totalBerat + (parseInt(dataProd.berat) * parseInt(jumlahProd));
    var grosir = [];
    if (typeof dataProd.harga_grosir !== "undefined") {
        $.each(dataProd.harga_grosir, function(i, v) {
            grosir.push(v);
        });
    }
    var berat = parseFloat($("#totalBerat").text().replace(",", ".")) + ((parseFloat(dataProd.berat) / 1000) * parseFloat(jumlahProd));
    $("#totalBerat").text(berat.toFixed(3).replace(".", ","));
    sudahCekOngkir = false;
    if(dataProd.foto_id != null && dataProd.foto_id != ''){
        if(dataProd.foto_id.utama != null){
            var foto = dataProd.foto_id.utama;
        } else {
            var foto = '{{ asset("photo.png") }}';
        }
    } else {
        var foto = '{{ asset("photo.png") }}';
    }
    var diskonTampil = "";
    if(cekCustomerRole == "Reseller"){
        var ketemu_grosir = false;
        if (typeof dataProd.harga_grosir !== "undefined") {
            if(kat_customer.reseller.grosir == 1){
                var subTotal, hargaAsli = 0;
                $.each(dataProd.harga_grosir, function(i, v) {
                    var rentan = v.rentan.split("-");
                    for (var i2 = parseInt(rentan[0]); i2 <= parseInt(rentan[1]); i2++) {
                        if (parseInt(jumlahProd) == parseInt(i2)) {
                            subTotal = parseInt(v.harga) * parseInt(jumlahProd);
                            hargaAsli = parseInt(v.harga);
                            ketemu_grosir = true;
                            return false;
                        }
                    }
                });
            }
        }
        if(!ketemu_grosir){
            if (dataProd.diskon_jual == null) {
                var subTotal = ((dataProd.harga_jual_reseller == null) ? dataProd.harga_jual_normal : dataProd.harga_jual_reseller) * parseInt(jumlahProd);
                var hargaAsli = ((dataProd.harga_jual_reseller == null) ? dataProd.harga_jual_normal : dataProd.harga_jual_reseller);
            } else {
                if(kat_customer.reseller.diskon == 1){
                    var hitungHarga = dataProd.diskon_jual.split("|")[0];
                    var tipeHitungHarga = dataProd.diskon_jual.split("|")[1];
                    if (tipeHitungHarga == "%") {
                        var hargaAwal = hargaAsli = ((dataProd.harga_jual_reseller == null) ? dataProd.harga_jual_normal : dataProd.harga_jual_reseller);
                        var hargaDiskon = Math.round(((parseInt(hitungHarga) * hargaAwal) / 100)) || 0;
                        var hargaAkhir = hargaAwal - hargaDiskon;
                        diskonTampil = "(Diskon " + hitungHarga + "%)";
                    } else if (tipeHitungHarga == "*") {
                        var hargaAsli = ((dataProd.harga_jual_reseller == null) ? dataProd.harga_jual_normal : dataProd.harga_jual_reseller);
                        var hargaAkhir = ((dataProd.harga_jual_reseller == null) ? dataProd.harga_jual_normal : dataProd.harga_jual_reseller) - parseInt(hitungHarga);
                        diskonTampil = "(Diskon Rp " + uangFormat(parseInt(hitungHarga)) + ")";
                    }
                    var subTotal = hargaAkhir * parseInt(jumlahProd);
                } else {
                    var subTotal = ((dataProd.harga_jual_reseller == null) ? dataProd.harga_jual_normal : dataProd.harga_jual_reseller) * parseInt(jumlahProd);
                    var hargaAsli = ((dataProd.harga_jual_reseller == null) ? dataProd.harga_jual_normal : dataProd.harga_jual_reseller);
                }
            }
        }
    } else if(cekCustomerRole == "Customer"){
        var ketemu_grosir = false;
        if (typeof dataProd.harga_grosir !== "undefined") {
            if(kat_customer.customer.grosir == 1){
                var subTotal, hargaAsli = 0;
                $.each(dataProd.harga_grosir, function(i, v) {
                    var rentan = v.rentan.split("-");
                    for (var i2 = parseInt(rentan[0]); i2 <= parseInt(rentan[1]); i2++) {
                        if (parseInt(jumlahProd) == parseInt(i2)) {
                            subTotal = parseInt(v.harga) * parseInt(jumlahProd);
                            hargaAsli = parseInt(v.harga);
                            ketemu_grosir = true;
                            return false;
                        }
                    }
                });
            }
        }
        if(!ketemu_grosir){
            if (dataProd.diskon_jual == null) {
                var subTotal = dataProd.harga_jual_normal * parseInt(jumlahProd);
                var hargaAsli = dataProd.harga_jual_normal;
            } else {
                if(kat_customer.customer.diskon == 1){
                    var hitungHarga = dataProd.diskon_jual.split("|")[0];
                    var tipeHitungHarga = dataProd.diskon_jual.split("|")[1];
                    if (tipeHitungHarga == "%") {
                        var hargaAwal = hargaAsli = dataProd.harga_jual_normal;
                        var hargaDiskon = Math.round(((parseInt(hitungHarga) * hargaAwal) / 100)) || 0;
                        var hargaAkhir = hargaAwal - hargaDiskon;
                        diskonTampil = "(Diskon " + hitungHarga + "%)";
                    } else if (tipeHitungHarga == "*") {
                        var hargaAsli = dataProd.harga_jual_normal;
                        var hargaAkhir = dataProd.harga_jual_normal - parseInt(hitungHarga);
                        diskonTampil = "(Diskon Rp " + uangFormat(parseInt(hitungHarga)) + ")";
                    }
                    var subTotal = hargaAkhir * parseInt(jumlahProd);
                } else {
                    var subTotal = dataProd.harga_jual_normal * parseInt(jumlahProd);
                    var hargaAsli = dataProd.harga_jual_normal;
                }
            }
        }
    } else if(cekCustomerRole == "Dropshipper"){
        var ketemu_grosir = false;
        if (typeof dataProd.harga_grosir !== "undefined") {
            if(kat_customer.dropshipper.grosir == 1){
                var subTotal, hargaAsli = 0;
                $.each(dataProd.harga_grosir, function(i, v) {
                    var rentan = v.rentan.split("-");
                    for (var i2 = parseInt(rentan[0]); i2 <= parseInt(rentan[1]); i2++) {
                        if (parseInt(jumlahProd) == parseInt(i2)) {
                            subTotal = parseInt(v.harga) * parseInt(jumlahProd);
                            hargaAsli = parseInt(v.harga);
                            ketemu_grosir = true;
                            return false;
                        }
                    }
                });
            }
        }
        if(!ketemu_grosir){
            if (dataProd.diskon_jual == null) {
                var subTotal = dataProd.harga_jual_normal * parseInt(jumlahProd);
                var hargaAsli = dataProd.harga_jual_normal;
            } else {
                if(kat_customer.dropshipper.diskon == 1){
                    var hitungHarga = dataProd.diskon_jual.split("|")[0];
                    var tipeHitungHarga = dataProd.diskon_jual.split("|")[1];
                    if (tipeHitungHarga == "%") {
                        var hargaAwal = hargaAsli = dataProd.harga_jual_normal;
                        var hargaDiskon = Math.round(((parseInt(hitungHarga) * hargaAwal) / 100)) || 0;
                        var hargaAkhir = hargaAwal - hargaDiskon;
                        diskonTampil = "(Diskon " + hitungHarga + "%)";
                    } else if (tipeHitungHarga == "*") {
                        var hargaAsli = dataProd.harga_jual_normal;
                        var hargaAkhir = dataProd.harga_jual_normal - parseInt(hitungHarga);
                        diskonTampil = "(Diskon Rp " + uangFormat(parseInt(hitungHarga)) + ")";
                    }
                    var subTotal = hargaAkhir * parseInt(jumlahProd);
                } else {
                    var subTotal = dataProd.harga_jual_normal * parseInt(jumlahProd);
                    var hargaAsli = dataProd.harga_jual_normal;
                }
            }
        }
    }
    var nama_prod_tampil = dataProd.nama_produk;
    if((dataProd.ukuran != null && dataProd.ukuran != "") && (dataProd.warna != null && dataProd.warna != "")){
        nama_prod_tampil += " ("+dataProd.ukuran+" "+dataProd.warna+") ";
    } else if((dataProd.ukuran != null && dataProd.ukuran != "") && (dataProd.warna == null || dataProd.warna == "")){
        nama_prod_tampil += " ("+dataProd.ukuran+") ";
    } else if((dataProd.ukuran == null || dataProd.ukuran == "") && (dataProd.warna != null && dataProd.warna != "")){
        nama_prod_tampil += " ("+dataProd.warna+") ";
    }
    if(!dataLamaProd){
        nama_prod_tampil += " <span class='red-200'>[Terhapus]</span>";
    }
    dataProd.foto_id = JSON.stringify(dataProd.foto_id);
    $("#produk-list").append(
        "<tr class='trDiv' id='trP-" + id_varianProd +"'>" +
            "<td>" +
                "<textarea id='ta-" + id_varianProd + "' class='hidden'>" + JSON.stringify(dataProd) + "</textarea>" +
                "<div class='d-flex'><img class='rounded' width='50' height='50' src='" + foto + "'>" +
                "<div class='ml-15 mt-3'>" + nama_prod_tampil + "</div></div>" +
            "</td>" +
            "<td>" +
                "Rp " + uangFormat(hargaAsli) +
                "<br><div class='diskonHitung' style='color:#F2353C'>" +
            diskonTampil + "</div></td>" +
            "<td class='jumlahHitung'>" +
                jumlahProd +
            "</td>" +
            "<td class='text-right uangHitung'>" +
                "Rp " + uangFormat(subTotal) +
            "</td>" +
            "<td><a style='cursor:pointer;' onClick='$(this).parent().parent().attr(\"style\", \"background-color: #f0f0f0;\");$(this).popover(\"show\")' href='javascript:void(0)' id='myPop-" +
                id_varianProd + "'>" +
                "<i class='glyphicon glyphicon-option-horizontal'></i>" +
            "</a></td>" +
        "</tr>");
    prodTam.push(id_varianProd+'|'+dataProd.stok.split('|')[1]);
    // alertify.success('Produk berhasil ditambahkan!');
    $('#myPop-' + id_varianProd).webuiPopover({
        content: "<div class='text-center'><button class='btn btn-sm btn-outline-success mr-5 ml--40' type='button'" +
            " data-target='#tambahDiskonProd' data-toggle='modal'onClick='tamDiskon(\"#ta-" +
            id_varianProd + "\", \"#myPop-" + id_varianProd + "\");'" +
            "><i class=' fa fa-plus'></i> Diskon Produk</button>" +
            "<button class='btn btn-sm btn-outline-warning mr-5' type='button' data-target='#editProd' data-toggle='modal'" +
            " onClick='editProd(\"#ta-" + id_varianProd +
            "\", \"#myPop-" + id_varianProd +
            "\");'><i class='fa fa-pencil'></i> Edit</button>" +
            "<button class='btn btn-sm btn-outline-danger mr-5' type='button' onClick='hapusProd(\"#trP-" +
            id_varianProd +
            "\")'><i class='fa fa-trash-o'></i> Hapus</button></div>",
        width: 320,
        animation: "pop"
    });
    $('#myPop-' + id_varianProd).on('hidden.webui.popover', function() {
        $(this).parent().parent().attr("style",
            "background-color: #ffffff;");
    })
    cekProdTam();
    hitungSubTotal();
}

function tamDiskon(dataSrc, webUIhide) {
    $(webUIhide).webuiPopover("hide");
    var id = webUIhide.split("-")[1];
    var hargaAwal = "Rp " + uangFormat(uangToAngka($("#trP-" + id).children("td:nth-child(2)").text()));
    var data = jQuery.parseJSON($(dataSrc).text());
    var diskon = $("#trP-" + id).children("td:nth-child(2)").children(".diskonHitung").text();
    if (diskon != "") {
        $("#btnTamDis").val("Edit Diskon");
    } else {
        $("#btnTamDis").val("Tambah Diskon");
    }
    $("#namaTamDis").html(data.nama_produk + "&nbsp;&nbsp;<div id='diskonNamaTamDis' style='color:#F2353C'>" + diskon +
        "</div>");
    if(data.foto != null && data.foto != ''){
        if(data.foto.utama != null){
            var foto = data.foto.utama;
        } else {
            var foto = '{{ asset("photo.png") }}';
        }
    } else {
        var foto = '{{ asset("photo.png") }}';
    }
    $("#fotoTamDis").attr("src", foto);
    $("#drP").val(webUIhide);
    $("#hargaAwalTamDis").val(hargaAwal);
    var pusat = $("#trP-" + id).children("td:nth-child(2)").children(".diskonHitung");
    if (pusat.text() != "") {
        var isi = pusat.text();
        if (isi.split(" ")[1] == "Rp") {
            $("#diskonTamDis").val(uangToAngka(isi.split(" ")[2].replace(")", ""), true));
            var hargaAwal = uangToAngka($("#hargaAwalTamDis").val());
            var hargaAkhir = hargaAwal - parseInt($("#diskonTamDis").val()) || 0;
            $("#hargaAkhirTamDis").val("Rp " + uangFormat(hargaAkhir));
            $('#tipeDiskon').selectpicker('val', 'Rp');
            $("#tempatDiskonPersen").hide();
        } else {
            $("#diskonTamDis").val(uangToAngka(isi.split(" ")[1].replace("%", ''), true));
            var hargaAwal = uangToAngka($("#hargaAwalTamDis").val());
            var hargaDiskon = Math.round(((parseInt($("#diskonTamDis").val()) * hargaAwal) / 100)) || 0;
            var hargaAkhir = hargaAwal - hargaDiskon;
            $("#diskonPersenTamDis").val("Rp " + uangFormat(hargaDiskon));
            $("#hargaAkhirTamDis").val("Rp " + uangFormat(hargaAkhir));
            $('#tipeDiskon').selectpicker('val', '%');
            $("#tempatDiskonPersen").show();
        }
    } else {
        $('#tipeDiskon').selectpicker('val', 'Rp');
        $("#tempatDiskonPersen").hide();
    }
}

function editProd(dataSrc, webUIhide) {
    $(webUIhide).webuiPopover("hide");
    var data = jQuery.parseJSON($(dataSrc).text());
    $("#taEdit").text($(dataSrc).text());
    if(data.foto != null && data.foto != ''){
        if(data.foto.utama != null){
            var foto = data.foto.utama;
        } else {
            var foto = '{{ asset("photo.png") }}';
        }
    } else {
        var foto = '{{ asset("photo.png") }}';
    }
    $("#fotoEditProd").attr("src", foto);
    var stok = data.stok.split("|");
    if (stok[1] == "sendiri") {
        var maxStok = stok[0];
    } else if (stok[1] == "lain") {
        var maxStok = 100;
    }
    var stokLawas = $(dataSrc).parent().parent().children(".jumlahHitung").text();
    var hargaLawas = $(dataSrc).parent().parent().children(".uangHitung").text();
    var diskon = $(dataSrc).parent().parent().children("td:nth-child(2)").children(".diskonHitung").text();
    $("#stokEditProd").val(stokLawas);
    $("#stokEditProd").TouchSpin({
        min: 1,
        max: maxStok,
        buttondown_class: "btn btn-info btn-outline",
        buttonup_class: "btn btn-info btn-outline"
    });
    $("#stokEditProd").trigger("touchspin.updatesettings", {
        max: maxStok
    });
    $("#hargaEditProd").val(hargaLawas);
    $("#namaEditProd").html(data.nama_produk + "&nbsp;&nbsp;<div id='diskonEditProd' style='color:#F2353C'>" + diskon + "</div>");
}

function hapusProd(idSrc) {
    var id = idSrc.split("-")[1];
    var stok = $(idSrc).children("td:nth-child(3)").text();
    prodTam = jQuery.grep(prodTam, function(value) {
        return value.split('|')[0] != id;
    });
    $.ajax({
        url: "{{ route('b.ajax-getProdukDetail') }}",
        type: 'get',
        dataType: "json",
        data: {
            id: id
        },
        success: function(data) {
            var berat = parseFloat($("#totalBerat").text().replace(",", ".")) - ((parseFloat(data.berat) / 1000) * parseFloat(stok));
            if (berat == 0) {
                $("#totalBerat").text(berat);
            } else {
                $("#totalBerat").text(berat.toFixed(3).replace(".", ","));
            }
        }
    });
    sudahCekOngkir = false;
    $('#myPop-' + id).webuiPopover('destroy');
    $(idSrc).remove();
    alertify.success('Berhasil menghapus produk!');
    cekProdTam();
    hitungSubTotal();
}

function editOnChange() {
    var data = jQuery.parseJSON($("#taEdit").text());
    var stok = data.stok.split("|");
    var tempHarga = $("#trP-" + data.id_varian).children("td:nth-child(2)").html().split("<br>");
    if(!isCekTemp_harga_edit){
        temp_harga_edit.cek = false;
        temp_harga_edit.data = $("#trP-" + data.id_varian).children("td:nth-child(2)").html();
        temp_harga_edit.id = data.id_varian;
        isCekTemp_harga_edit = true;
    }
    if (stok[1] == "sendiri") {
        var maxStok = parseInt(stok[0]);
    } else if (stok[1] == "lain") {
        var maxStok = 100;
    }
    var stokAkhir = parseInt($("#stokEditProd").val());
    var cekCustomerRole = null;
    if ($("#pemesanKat").val() != "") {
        cekCustomerRole = $("#pemesanKat").val();
    }
    if(cekCustomerRole == 'Reseller'){
        var hargaNormal = (data.harga_jual_reseller == null ? data.harga_jual_normal : data.harga_jual_reseller);
    } else {
        var hargaNormal = data.harga_jual_normal;
    }
    if (stokAkhir <= maxStok && stokAkhir > 0) {
        var isi = $("#diskonEditProd").text();
        var grosir = [];
        if((kat_customer.reseller.grosir == 1 && cekCustomerRole == 'Reseller') ||
            (kat_customer.dropshipper.grosir == 1 && cekCustomerRole == 'Dropshipper') ||
            (kat_customer.customer.grosir == 1 && cekCustomerRole == 'Customer')){
            if (typeof data.harga_grosir !== "undefined") {
                $.each(data.harga_grosir, function(i, v) {
                    grosir.push(v);
                });
            }
        }
        if ((data.diskon_jual == null && isi == "") || (data.diskon_jual != null && isi == "")) {
            if (grosir.length == 0) {
                var hargaAkhir = hargaNormal * parseInt(stokAkhir);
                tempHarga[0] = "Rp " + uangFormat(hargaNormal);
            } else {
                var ketemu = false;
                var hargaAkhir;
                $.each(grosir, function(i, v) {
                    var rentan = v.rentan.split("-");
                    for (var i2 = parseInt(rentan[0]); i2 <= parseInt(rentan[1]); i2++) {
                        if (parseInt(stokAkhir) == parseInt(i2)) {
                            hargaAkhir = parseInt(v.harga) * parseInt(stokAkhir);
                            tempHarga[0] = "Rp " + uangFormat(v.harga);
                            ketemu = true;
                            return false;
                        }
                    }
                });
                if (!ketemu) {
                    var hargaAkhir = hargaNormal * parseInt(stokAkhir);
                    tempHarga[0] = "Rp " + uangFormat(hargaNormal);
                }
            }
        } else {
            if (grosir.length == 0) {
                var hargaAsli = hargaNormal;
            } else {
                var ketemu = false;
                var hargaAkhir;
                $.each(grosir, function(i, v) {
                    var rentan = v.rentan.split("-");
                    for (var i2 = parseInt(rentan[0]); i2 <= parseInt(rentan[1]); i2++) {
                        if (parseInt(stokAkhir) == parseInt(i2)) {
                            hargaAsli = parseInt(v.harga);
                            ketemu = true;
                            return false;
                        }
                    }
                });
                if (!ketemu) {
                    var hargaAsli = hargaNormal;
                }
            }
            if((kat_customer.reseller.diskon == 1 && cekCustomerRole == 'Reseller') || (kat_customer.dropshipper.diskon == 1 && cekCustomerRole == 'Dropshipper') ||
                (kat_customer.customer.diskon == 1 && cekCustomerRole == 'Customer')){
                if (isi.split(" ")[1] == "Rp") {
                    var diskon = uangToAngka(isi.split(" ")[2].replace(")", ""), true);
                    var harga2 = (hargaAsli - diskon) * parseInt(stokAkhir);
                } else {
                    var diskon = uangToAngka(isi.split(" ")[1].replace("%", ''), true);
                    var hargaDiskon = Math.round(((diskon * hargaAsli) / 100)) || 0;
                    var harga2 = (hargaAsli - hargaDiskon) * parseInt(stokAkhir);
                }
                tempHarga[0] = "Rp " + uangFormat(hargaAsli);
                var hargaAkhir = harga2;
            } else {
                var hargaAkhir = hargaNormal * parseInt(stokAkhir);
                tempHarga[0] = "Rp " + uangFormat(hargaNormal);
            }
        }
        // console.log(hargaAkhir);
        $("#trP-" + data.id_varian).children("td:nth-child(2)").html(tempHarga.join("<br>"));
        $("#hargaEditProd").val("Rp " + uangFormat(hargaAkhir));
    }
}

function cekToDanFrom(tipeKecamatan = false) {
    var isiTo = $("#idUntukKirim").val();
    var hasilTo = $("#hasilUntukKirim").text();
    var isiFrom = $("#idDariKirim").val();
    var hasilFrom = $("#hasilDariKirim").text();
    var totalBerat = parseFloat($("#totalBerat").text().replace(",", ".")) * 1000;
    var expedisi = {!! $cekOngkir !!};
    // var expedisi = ["jne", "tiki", "pos", "pcp", "esl", "rpx", "pandu", "wahana", "sicepat", "jnt", "pahala", "cahaya", "sap", "jet", "indah", "dse", "slis", "first", "ncs", "star", "lion", "ninja", "idl", "rex"];
    // var expedisi = ["jne", "tiki", "pos", "lion", "ninja", "sicepat", "wahana", "jnt", "sap", "rpx"];
    // console.log("totalBerat: "+totalBerat);
    // console.log("isiTo: "+isiTo);
    // console.log("hasilTo: "+hasilTo);
    // console.log("isiFrom: "+isiFrom);
    // console.log("hasilFrom: "+hasilFrom);
    // console.log("pilihUntuk: "+pilihUntuk);
    // console.log("pilihDari: "+pilihDari);
    // console.log(sudahCekOngkir);
    if (!tipeKecamatan) {
        if (pilihUntuk != "" && hasilTo != "" && pilihDari != "" && hasilFrom != "" && totalBerat != 0) {
            // console.log("kocak");
            if (sudahCekOngkir === false) {
                $("#expedisi-list").html("");
                // console.log("mantab");
                var asal = pilihDari.split("|")[1];
                var tujuan = pilihUntuk.split("|")[1];
                var notifCek = alertify.message('Sedang cek ongkir...', 0);
                var t_asal = asal.replace(/[^a-zA-Z0-9]/gi, '');
                var t_tujuan = tujuan.replace(/[^a-zA-Z0-9]/gi, '');
                var t_total = totalBerat.toString();
                var t_term = t_asal+"_"+t_tujuan+"_"+totalBerat.toString();
                // console.log("=========");
                $.each(expedisi, function(key, val) {
                    var term = t_term+"_"+val;
                    if(term in cacheCekOngkir){
                        if (cacheCekOngkir[term].status.code === 200) {
                            var hasil = cacheCekOngkir[term].results[0];
                            $.each(hasil.costs, function(i, v) {
                                var kategori = (v.service != v.description) ? v
                                    .description + " (" + v.service + ")" : v
                                    .description;
                                if (hasil.name == "POS Indonesia (POS)") {
                                    var etd = v.cost[0].etd.split(" ")[0] + " Hari";
                                } else if(hasil.name == "21 Express"){
                                    var etd = v.cost[0].etd;
                                } else {
                                    var etd = (v.cost[0].etd == "" ? "-" : v.cost[0].etd + " Hari");
                                }
                                var code = val+"|"+v.service+"|"+v.cost[0].value.toString();
                                $("#expedisi-list").append(
                                    "<tr class='tr-ongkir tro-expedisi'>" +
                                    "<td><input type='hidden' value='"+code+"'>" + hasil.name + "</td>" +
                                    "<td>" + kategori + "</td>" +
                                    "<td>" + etd + "</td>" +
                                    "<td class='text-right'>Rp " + uangFormat(v
                                        .cost[0].value) + "</td>" +
                                    "</tr>"
                                );
                            });
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
                                berat: totalBerat,
                                v: val
                            },
                            success: function(data) {
                                cacheCekOngkir[term] = data;
                                // console.log("kurir: "+val);
                                // console.log(data);
                                if (data.status.code === 200) {
                                    var hasil = data.results[0];
                                    // console.log(hasil);
                                    // if(hasil.costs.length == 0){
                                    //     $("#expedisi-list").append(
                                    //         "<tr class='tr-ongkir tro-expedisi'>" +
                                    //         "<td>" + hasil.name + "</td>" +
                                    //         "<td>?</td>" +
                                    //         "<td>? Hari</td>" +
                                    //         "<td class='text-right'>Rp ?</td>" +
                                    //         "</tr>"
                                    //     );
                                    // } else {
                                    $.each(hasil.costs, function(i, v) {
                                        // console.log(v);
                                        var kategori = (v.service != v.description) ? v
                                            .description + " (" + v.service + ")" : v
                                            .description;
                                        if (hasil.name == "POS Indonesia (POS)") {
                                            var etd = v.cost[0].etd.split(" ")[0] + " Hari";
                                        } else if(hasil.name == "21 Express"){
                                            var etd = v.cost[0].etd;
                                        } else {
                                            var etd = (v.cost[0].etd == "" ? "-" : v.cost[0].etd + " Hari");
                                        }
                                        var code = val+"|"+v.service+"|"+v.cost[0].value.toString();
                                        $("#expedisi-list").append(
                                            "<tr class='tr-ongkir tro-expedisi'>" +
                                            "<td><input type='hidden' value='"+code+"'>" + hasil.name + "</td>" +
                                            "<td>" + kategori + "</td>" +
                                            "<td>" + etd + "</td>" +
                                            "<td class='text-right'>Rp " + uangFormat(v
                                                .cost[0].value) + "</td>" +
                                            "</tr>"
                                        );
                                    });
                                    // }
                                    if(key == expedisi.length-1) notifCek.dismiss();
                                } else {
                                    console.log("error "+val+": " + JSON.stringify(data));
                                }
                                // console.log("======================");
                            }
                        });
                    }
                });
                // console.log(hasilCekOngkir);
                // $.each(hasilCekOngkir, function(key, val){
                //     console.log("asd");
                //     console.log(val);
                // });
                sudahCekOngkir = true;
            }
        }
    } else {
        if (pilihUntuk != "" && hasilTo != "" && pilihDari != "" && hasilFrom != "" && totalBerat != 0) {
            if (sudahCekOngkir === false) {
                $("#expedisi-list").html("");
                var asal = pilihDari.split("|")[2];
                var tujuan = pilihUntuk.split("|")[2];
                var notifCek = alertify.message('Sedang cek ongkir...', 0);
                var t_asal = asal.replace(/[^a-zA-Z0-9]/gi, '');
                var t_tujuan = tujuan.replace(/[^a-zA-Z0-9]/gi, '');
                var t_total = totalBerat.toString();
                var t_term = t_asal+"_"+t_tujuan+"_"+totalBerat.toString();
                $.each(expedisi, function(key, val) {
                    var term = t_term+"_"+val;
                    if(term in cacheCekOngkir){
                        if (cacheCekOngkir[term].status.code === 200) {
                            var hasil = cacheCekOngkir[term].results[0];
                            $.each(hasil.costs, function(i, v) {
                                setTimeout(function(){
                                    var kategori = (v.service != v.description) ? v
                                        .description + " (" + v.service + ")" : v
                                        .description;
                                    if (hasil.name == "POS Indonesia (POS)") {
                                        var etd = v.cost[0].etd.split(" ")[0] + " Hari";
                                    } else if(hasil.name == "21 Express"){
                                        var etd = v.cost[0].etd;
                                    } else {
                                        var etd = (v.cost[0].etd == "" ? "-" : v.cost[0].etd + " Hari");
                                    }
                                    var code = val+"|"+v.service+"|"+v.cost[0].value.toString();
                                    $("#expedisi-list").append(
                                        "<tr class='tr-ongkir tro-expedisi'>" +
                                        "<td><input type='hidden' value='"+code+"'>" + hasil.name + "</td>" +
                                        "<td>" + kategori + "</td>" +
                                        "<td>" + etd + "</td>" +
                                        "<td class='text-right'>Rp " + uangFormat(v
                                            .cost[0].value) + "</td>" +
                                        "</tr>"
                                    );
                                }, 500);
                            });
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
                                berat: totalBerat,
                                v: val
                            },
                            success: function(data) {
                                cacheCekOngkir[term] = data;
                                if (data.status.code === 200) {
                                    var hasil = data.results[0];
                                    // console.log(hasil);
                                    $.each(hasil.costs, function(i, v) {
                                        var kategori = (v.service != v.description) ? v
                                            .description + " (" + v.service + ")" : v
                                            .description;
                                        if (hasil.name == "POS Indonesia (POS)") {
                                            var etd = v.cost[0].etd.split(" ")[0] + " Hari";
                                        } else if(hasil.name == "21 Express"){
                                            var etd = v.cost[0].etd;
                                        } else {
                                            var etd = (v.cost[0].etd == "" ? "-" : v.cost[0].etd + " Hari");
                                        }
                                        var code = val+"|"+v.service+"|"+v.cost[0].value.toString();
                                        $("#expedisi-list").append(
                                            "<tr class='tr-ongkir tro-expedisi'>" +
                                            "<td><input type='hidden' value='"+code+"'>" + hasil.name + "</td>" +
                                            "<td>" + kategori + "</td>" +
                                            "<td>" + etd + "</td>" +
                                            "<td class='text-right'>Rp " + uangFormat(v
                                                .cost[0].value) + "</td>" +
                                            "</tr>"
                                        );
                                    });
                                    if(key == expedisi.length-1) notifCek.dismiss();
                                } else {
                                    console.log("error "+val+": " + JSON.stringify(data));
                                }
                            }
                        });
                    }
                });
                sudahCekOngkir = true;
            }
        }
    }
}

function hapusOrder(idSrc) {
    var id = idSrc.split("-")[1];
    $('#myPopTot-' + id).webuiPopover('destroy');
    $(idSrc).remove();
    alertify.success('Berhasil menghapus Diskon Order!');
    hitungTotalHarga();
}

function hapusBiaya(idSrc) {
    var id = idSrc.split("-")[1];
    $('#myPopBiaya-' + id).webuiPopover('destroy');
    $(idSrc).remove();
    alertify.success('Berhasil menghapus Biaya Lain!');
    hitungTotalHarga();
}

function editOrder(mpt) {
    $(mpt).webuiPopover("hide");
    var id = mpt.split("-")[1];
    $("#taOrder").val(mpt);
    var nama = $.trim($("#trOrder-" + id).children("td:first").text().split("(")[0]);
    var value = uangToAngka($("#trOrder-" + id).children("td:nth-child(2)").children("div").text().split(" ")[2], true);
    $("#nominalEditDisOr").val(value);
    $("#namaEditDisOr").val(nama);
}

function editBiaya(mpt) {
    $(mpt).webuiPopover("hide");
    var id = mpt.split("-")[1];
    $("#taBiaya").val(mpt);
    var nama = $.trim($("#trBiaya-" + id).children("td:first").text().split("(")[0]);
    var value = uangToAngka($("#trBiaya-" + id).children("td:nth-child(2)").text().split(" ")[1], true);
    $("#nominalEditBiaya").val(value);
    $("#namaEditBiaya").val(nama);
}

$(document).ready(() => {

    setInterval(function() {
        // if($('#ubahKurirCekS').is(':checked') === true){
            // console.log(sudahCekOngkir);
            cekToDanFrom(true);
        // }
    }, 1000);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    alertify.set('notifier','position', 'top-right');

    $(".tro-toko").addClass("tr-ongkir-selected");
    $(".tro-toko").attr("style", "background-color:#0099B8;color:white;");

    $('#passwordC').password({
        animate: false,
        minimumLength: 0,
        enterPass: '',
        badPass: '<span class="red-800 font-size-14">The password is weak</span>',
        goodPass: '<span class="yellow-800 font-size-14">Good password</span>',
        strongPass: '<span class="green-700 font-size-14">Strong password</span>',
        shortPass: ''
    });

    $('#btnEye').click(function(){
        if($('#passwordC').attr('type') == 'password'){
            $('#passwordC').attr('type', 'text');
            $('#btnEye').children().attr('class', 'icon md-eye-off');
        } else if($('#passwordC').attr('type') == 'text'){
            $('#passwordC').attr('type', 'password');
            $('#btnEye').children().attr('class', 'icon md-eye');
        }
    });
    @if($msg_sukses = Session::get('msg_success'))
    window.setTimeout(function() {
        $('#alert-sukses').animate({
            height: 'toggle'
        }, 'slow');
    }, 5000);
    @endif

    $('#tanggalOrder').datepicker({
        format: "dd MM yyyy",
        orientation: 'bottom'
    }).datepicker('setDate', new Date()).on('changeDate', function(ev) {
        var dateOrder = new Date(ev.date.valueOf());
        $('#tanggalBayar').datepicker('setStartDate', dateOrder);
    });
    $('#tanggalBayar').datepicker({
            format: "dd MM yyyy",
            orientation: 'top'
    }).datepicker('setDate', new Date()).datepicker("setStartDate", new Date());
    $('#icNote').iCheck({
        checkboxClass: 'icheckbox_flat-blue'
    });
    $('#kategoriC').selectpicker({
        style: 'btn-outline btn-default'
    });
    $('#provinsiC').selectpicker({
        liveSearch: true,
        style: 'btn-outline btn-default'
    });
    $('#kecamatanC').selectpicker({
        liveSearch: true,
        style: 'btn-outline btn-default'
    });
    $('#kabupatenC').selectpicker({
        liveSearch: true,
        style: 'btn-outline btn-default'
    });
    $('#tipeDiskon').selectpicker({
        style: 'btn-outline btn-default'
    });
    $('#statusBayar').selectpicker({
        style: 'btn-outline btn-default'
    });
    @if($order_source['cek'] == 'on' || !is_null($data_edit['order']->order_source_id))
        $('#orderSource').selectpicker({
            style: 'btn-outline btn-default'
        });
    @endif
    var list_checkbox = Array.prototype.slice.call($('.js-switch'));
    list_checkbox.forEach(function(html) {
        var switchery = new Switchery(html, {
            color: '#3e8ef7',
            size: 'small'
        });
    });
    
    $(document).on('input', '.uangFormat', function(event) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });


    //load awal pemesan
    var data_pemesan = jQuery.parseJSON('{!! $data_edit["pemesan"] !!}');
    var hasil = parseHtml(data_pemesan.label);
    $('#hasilCariPemesan').html(hasil);
    $('#hasilCariPemesan').show();
    $('#btnPemesanC').hide();
    $('#idPemesan').val(data_pemesan.value);
    $('#idPemesan').hide();
    var pemOld = data_pemesan.label.split('|');
    pemesanOld = pemOld[0];
    $("#pemesanKat").val(pemOld[pemOld.length - 1]);
    pemOld = hasil = data_pemesan = undefined;

    //load awal untuk kirim
    var data_untuk_kirim = jQuery.parseJSON('{!! $data_edit["untuk_kirim"] !!}');
    var hasil = parseHtml(data_untuk_kirim.label);
    $('#hasilUntukKirim').html(hasil);
    $('#hasilUntukKirim').show();
    $('#btnUntukKirimC').hide();
    $('#idUntukKirim').val(data_untuk_kirim.value);
    $('#idUntukKirim').hide();
    var ukOld = data_untuk_kirim.label.split('|');
    untukKirimOld = ukOld[0];
    pilihUntuk = data_untuk_kirim.alamat;
    ukOld = hasil = data_untuk_kirim = tempPilihUntuk = undefined;

    //load awal dari kirim
    var data_dari_kirim = jQuery.parseJSON('{!! $data_edit["dari_kirim"] !!}');
    var hasil = data_dari_kirim.label;
    $('#hasilDariKirim').html(hasil);
    $('#hasilDariKirim').show();
    $("#cDari").hide();
    $('#idDariKirim').val(data_dari_kirim.value);
    $('#idDariKirim').hide();
    pilihDari = data_dari_kirim.value;
    dariKirimOld = data_dari_kirim.label;
    hasil = data_dari_kirim = undefined;

    //load awal orderan
    var data_orderan = jQuery.parseJSON('{!! $data_edit["produk"] !!}');
    $.each(data_orderan, (i, v) => {
        loadAwalOrderan(v.rawData, v.jumlah, v.data_lama);
    });
    data_orderan = undefined;

    //load awal kurir
    var data_ongkir = jQuery.parseJSON('{!! $data_edit["ongkir"] !!}');
    var data_pilih_ongkir = jQuery.parseJSON('{!! $data_edit["order"]->kurir !!}');
    $.each(data_ongkir, (iK, data) => {
        cacheCekOngkir[data.term] = data;
        if (data.status.code === 200) {
            var hasil = data.results[0];
            // console.log(hasil);
            $.each(hasil.costs, function(i, v) {
                var kategori = (v.service != v.description) ? v
                    .description + " (" + v.service + ")" : v
                    .description;
                if (hasil.name == "POS Indonesia (POS)") {
                    var etd = v.cost[0].etd.split(" ")[0] + " Hari";
                } else if(hasil.name == "21 Express"){
                    var etd = v.cost[0].etd;
                } else {
                    var etd = (v.cost[0].etd == "" ? "-" : v.cost[0].etd + " Hari");
                }
                var code = iK+"|"+v.service+"|"+v.cost[0].value.toString();
                $("#expedisi-list").append(
                    "<tr class='tr-ongkir tro-expedisi'>" +
                    "<td><input type='hidden' value='"+code+"'>" + hasil.name + "</td>" +
                    "<td>" + kategori + "</td>" +
                    "<td>" + etd + "</td>" +
                    "<td class='text-right'>Rp " + uangFormat(v
                        .cost[0].value) + "</td>" +
                    "</tr>"
                );
            });
        } else {
            console.log("error "+iK+": " + JSON.stringify(data));
        }
    });
    sudahCekOngkir = true;
    if(data_pilih_ongkir.tipe == 'expedisi'){
        var list = Array.prototype.slice.call($(".tro-expedisi"));
        list.forEach(function(html) {
            let data = $(html).children("td:first").children("input").val();
            if(data == data_pilih_ongkir.data){
                let list2 = Array.prototype.slice.call($(".tr-ongkir"));
                list2.forEach((html2) => {
                    if ($(html2).hasClass("tr-ongkir-selected")) {
                        $(html2).attr("style", "");
                        $(html2).removeClass("tr-ongkir-selected");
                    }
                });
                $(html).addClass("tr-ongkir-selected");
                $(html).attr("style", "background-color:#0099B8;color:white;");
                $("#ongkir").text($(html).children("td:nth-child(4)").text());
                cekTotalHarga("ongkir");
                return false;
            }
        });
    } else if(data_pilih_ongkir.tipe == 'kurir'){
        $("#ongKurir").slideDown("slow");
        $("#namaKurir").removeClass("disabled");
        $("#tarifKurir").removeClass("disabled");
        $("#namaKurir").val(data_pilih_ongkir.data.nama);
        $("#tarifKurir").val(data_pilih_ongkir.data.harga);
        if (data_pilih_ongkir.data.nama == "") {
            var valTemp = "Nama Kurir";
        } else {
            var valTemp = data_pilih_ongkir.data.nama;
        }
        $(".tro-kur").children("td:first").text(valTemp);
        if (data_pilih_ongkir.data.harga == "") {
            var valTemp2 = "0";
        } else {
            var valTemp2 = data_pilih_ongkir.data.harga;
        }
        var val = "Rp " + uangFormat(valTemp2);
        $(".tro-kur").children("td:nth-child(4)").text(val);
        $("#ongkir").text(val);
        val = valTemp2 = valTemp = undefined;
        var list = Array.prototype.slice.call($(".tr-ongkir"));
        list.forEach(function(html) {
            if ($(html).hasClass("tr-ongkir-selected")) {
                $(html).attr("style", "");
                $(html).removeClass("tr-ongkir-selected");
            }
        });
        $('.tro-kur').addClass("tr-ongkir-selected");
        $('.tro-kur').attr("style", "background-color:#0099B8;color:white;");
        $("#ongkir").text($('.tro-kur').children("td:nth-child(4)").text());
        cekTotalHarga("ongkir");
    }
    data_ongkir = data_pilih_ongkir = undefined;

    //load awal pembayaran
    var data_bayar = jQuery.parseJSON('{!! $data_edit["bayar"] !!}');
    // console.log(data_bayar);
    $('#statusBayar').selectpicker('val', data_bayar.status);
    if (data_bayar.status == "belum") {
        $("#tglBayar").slideUp("slow");
        $("#viaBayar").slideUp("slow");
        $("#nomBayar").slideUp("slow");
    } else if (data_bayar.status == "cicil") {
        $("#tglBayar").slideDown("slow");
        $("#viaBayar").slideDown("slow");
        $("#nomBayar").slideDown("slow");
    } else if (data_bayar.status == "lunas") {
        $("#tglBayar").slideDown("slow");
        $("#viaBayar").slideDown("slow");
        $("#nomBayar").slideUp("slow");
    }
    data_bayar = undefined;
    $('.historyBayar').tooltip({
        trigger: 'hover',
        title: 'Hapus riwayat pembayaran',
        placement: 'top'
    });

    //load awal diskon order dan biaya lain
    var data_total = jQuery.parseJSON('{!! $data_edit["order"]->total !!}');
    if(data_total.diskonOrder !== null){
        $.each(data_total.diskonOrder, (i, v) => {
            let nomDiskon = v.harga;
            let namaDiskon = v.nama;
            $("#diskonOrder-list").append("<tr id='trOrder-" + nomDiskon + "'>" +
                "<td>" + namaDiskon + " (Diskon Order)</td>" +
                "<td class='text-right'><div style='color:#F2353C;'>- Rp " + uangFormat(nomDiskon) +
                "</div></td>" +
                "<td><a style='cursor:pointer;' onClick='$(this).parent().parent().attr(\"style\", \"background-color: #f0f0f0;\");$(this).popover(\"show\")' href='javascript:void(0)' id='myPopTot-" +
                nomDiskon + "'>" +
                "<i class='glyphicon glyphicon-option-horizontal'></i>" +
                "</a></td>" +
                "</tr>"
            );
            $('#myPopTot-' + nomDiskon).webuiPopover({
                content: "<button class='btn btn-sm btn-outline-warning mr-5' type='button' data-target='#editDiskonOrder' data-toggle='modal'" +
                    " onClick='editOrder(\"#myPopTot-" + nomDiskon +
                    "\");'><i class='fa fa-pencil'></i> Edit</button>" +
                    "<button class='btn btn-sm btn-outline-danger mr-5' type='button' onClick='hapusOrder(\"#trOrder-" +
                    nomDiskon + "\")'><i class='fa fa-trash-o'></i> Hapus</button></div>",
                width: 185,
                animation: "pop"
            });
            $('#myPopTot-' + nomDiskon).on('hidden.webui.popover', function() {
                $(this).parent().parent().attr("style", "background-color: #ffffff;");
            })
        });
        hitungTotalHarga();
    }
    if(data_total.biayaLain !== null){
        $.each(data_total.biayaLain, (i, v) => {
            let nomBiaya = v.harga;
            let namaBiaya = v.nama;
            $("#biayaLain-list").append("<tr id='trBiaya-" + nomBiaya + "'>" +
                "<td>" + namaBiaya + " (Biaya Lain)</td>" +
                "<td class='text-right'>Rp " + uangFormat(nomBiaya) + "</td>" +
                "<td><a style='cursor:pointer;' onClick='$(this).parent().parent().attr(\"style\", \"background-color: #f0f0f0;\");$(this).popover(\"show\")' href='javascript:void(0)' id='myPopBiaya-" +
                nomBiaya + "'>" +
                "<i class='glyphicon glyphicon-option-horizontal'></i>" +
                "</a></td>" +
                "</tr>"
            );
            $('#myPopBiaya-' + nomBiaya).webuiPopover({
                content: "<button class='btn btn-sm btn-outline-warning mr-5' type='button' data-target='#editBiayaLain' data-toggle='modal'" +
                    " onClick='editBiaya(\"#myPopBiaya-" + nomBiaya +
                    "\");'><i class='fa fa-pencil'></i> Edit</button>" +
                    "<button class='btn btn-sm btn-outline-danger mr-5' type='button' onClick='hapusBiaya(\"#trBiaya-" +
                    nomBiaya + "\")'><i class='fa fa-trash-o'></i> Hapus</button></div>",
                width: 185,
                animation: "pop"
            });
            $('#myPopBiaya-' + nomBiaya).on('hidden.webui.popover', function() {
                $(this).parent().parent().attr("style", "background-color: #ffffff;");
            })
        });
        hitungTotalHarga();
    }

    
    //modal tambah customer
    $('#modTambah').on('hidden.bs.modal', function() {
        hapusIsi();
    });

    $("#modTambah").on("input", "#no_telpC", function(){
        this.value = this.value.replace(/[^0-9\+]/g, '');
    });

    $("#modTambah").on("input", "#kode_posC", function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
    $('#provinsiC').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
        $('#provinsiC').selectpicker('setStyle', 'animation-shake', 'remove');
        if (!$('#error_provinsiC').is(':hidden')) $('#error_provinsiC').hide();
        var val = $(this).val();
        var term = val.replace(/[^a-zA-Z]/gi, '');
        $('#kabupatenC').html(
            '<option value="" disabled selected>-- Pilih Kabupaten --</option>');
        if(term in cacheKabupaten){
            // console.log("provinsi -> kabupaten (cache)");
            $.each(cacheKabupaten[term], function(i2, v2) {
                $('#kabupatenC').append("<option value='" + v2.type + " " + v2.kabupaten_nama + "'>" + v2.type + " " + v2.kabupaten_nama + "</option>");
            });
            $('#kabupatenC').selectpicker('refresh');
        } else {
            // console.log("provinsi -> kabupaten (ajax)");
            $.ajax({
                url: "{{ route('b.ajax-getWilayah') }}",
                type: 'get',
                data: {
                    term: val
                },
                dataType: 'json',
                success: function(data) {
                    cacheKabupaten[term] = data;
                    $.each(data, function(i2, v2) {
                        $('#kabupatenC').append("<option value='" + v2.type + " " + v2.kabupaten_nama + "'>" + v2.type + " " + v2.kabupaten_nama + "</option>");
                    });
                    $('#kabupatenC').selectpicker('refresh');
                }
            });
        }
        var term2 = term+"1";
        $('#kecamatanC').html(
            '<option value="" disabled selected>-- Pilih Kecamatan --</option>');
        if(term2 in cacheKecamatan){
            // console.log("provinsi -> kecamatan (cache)");
            $.each(cacheKecamatan[term2], function(i3, v3) {
                $('#kecamatanC').append("<option value='" + v3.kecamatan.nama +
                    "'>" + v3.kecamatan.nama + "</option>");
            });
            $('#kecamatanC').selectpicker('refresh');
        } else {
            // console.log("provinsi -> kecamatan (ajax)");
            $.ajax({
                url: "{{ route('b.ajax-getWilayahDetail') }}",
                type: 'get',
                data: {
                    term: val,
                    tipe: "1"
                },
                dataType: 'json',
                success: function(data) {
                    cacheKecamatan[term2] = data;
                    $.each(data, function(i3, v3) {
                        $('#kecamatanC').append("<option value='" + v3.kecamatan.nama + "'>" + v3.kecamatan.nama + "</option>");
                    });
                    $('#kecamatanC').selectpicker('refresh');
                }
            });
        }
        if (!$('#error_kabupatenC').is(':hidden')) $('#error_kabupatenC').hide();
        if (!$('#error_kecamatanC').is(':hidden')) $('#error_kecamatanC').hide();
    });

    $('#kabupatenC').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
        $('#kabupatenC').selectpicker('setStyle', 'animation-shake', 'remove');
        if (!$('#error_kabupatenC').is(':hidden')) $('#error_kabupatenC').hide();
        var pilihKab = $(this).val();
        var provinsiPilih = '';
        var term = pilihKab.replace(/[^a-zA-Z]/gi, '');
        if(cacheProvinsiAll.length > 0){
            // console.log("kabupaten -> provinsi (cache)");
            $.each(cacheProvinsiAll, function(i, v) {
                $.each(v.kabupaten, function(key, val) {
                    var tempPilih = val.type + ' ' + val.kabupaten_nama;
                    if (pilihKab === tempPilih) {
                        provinsiPilih = v.provinsi;
                        return false;
                    }
                });
                if (provinsiPilih != '') return false;
            });
            $('#provinsiC').selectpicker('val', provinsiPilih);
        } else {
            // console.log("kabupaten -> provinsi (ajax)");
            $.ajax({
                url: "{{ route('b.ajax-getWilayah') }}",
                type: 'get',
                dataType: 'json',
                success: function(data) {
                    cacheProvinsiAll = data;
                    $.each(data, function(i, v) {
                        $.each(v.kabupaten, function(key, val) {
                            var tempPilih = val.type + ' ' + val.kabupaten_nama;
                            if (pilihKab === tempPilih) {
                                provinsiPilih = v.provinsi;
                                return false;
                            }
                        });
                        if (provinsiPilih != '') return false;
                    });
                    $('#provinsiC').selectpicker('val', provinsiPilih);
                }
            });
        }
        var term2 = term+"2";
        $('#kecamatanC').html('<option value="" disabled selected>-- Pilih Kecamatan --</option>');
        if(term2 in cacheKecamatan_Kabupaten){
            // console.log("kabupaten -> kecamatan (cache)");
            $.each(cacheKecamatan_Kabupaten[term2], function(i3, v3) {
                $('#kecamatanC').append("<option value='" + v3.kecamatan.nama + "'>" + v3.kecamatan.nama + "</option>");
            });
            $('#kecamatanC').selectpicker('refresh');
        } else {
            // console.log("kabupaten -> kecamatan (ajax)");
            $.ajax({
                url: "{{ route('b.ajax-getWilayahDetail') }}",
                type: 'get',
                data: {
                    term: pilihKab,
                    tipe: "2"
                },
                dataType: 'json',
                success: function(data) {
                    cacheKecamatan_Kabupaten[term2] = data;
                    $.each(data, function(i3, v3) {
                        $('#kecamatanC').append("<option value='" + v3.kecamatan.nama + "'>" + v3.kecamatan.nama + "</option>");
                    });
                    $('#kecamatanC').selectpicker('refresh');
                }
            });
        }
        if (!$('#error_provinsiC').is(':hidden')) $('#error_provinsiC').hide();
        if (!$('#error_kecamatanC').is(':hidden')) $('#error_kecamatanC').hide();
    });

    $('#kecamatanC').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
        $('#kecamatanC').selectpicker('setStyle', 'animation-shake', 'remove');
        if (!$('#error_kecamatanC').is(':hidden')) $('#error_kecamatanC').hide();
        if (!$('#error_provinsiC').is(':hidden')) $('#error_provinsiC').hide();
        if (!$('#error_kabupatenC').is(':hidden')) $('#error_kabupatenC').hide();
    });
		
    $('#namaC').on('input', function(){
        if($('small#error_namaC').is(':visible')){
            $('small#error_namaC').hide();
            $('#namaC').removeClass('is-invalid animation-shake');
        }
    });
    
    $('#emailC').on('input', function(){
        if($('small#error_emailC').is(':visible')){
            $('small#error_emailC').hide();
            $('#emailC').removeClass('is-invalid animation-shake');
        }
    });
    
    $('#passwordC').on('input', function(){
        if($('small#error_passwordC').is(':visible')){
            $('small#error_passwordC').hide();
            $('#passwordC').removeClass('is-invalid animation-shake');
        }
    });
    
    $('#kode_posC').on('input', function(){
        if($('small#error_kode_posC').is(':visible')){
            $('small#error_kode_posC').hide();
            $('#kode_posC').removeClass('is-invalid animation-shake');
        }
    });
    
    $('#no_telpC').on('input', function(){
        if($('small#error_no_telpC').is(':visible')){
            $('small#error_no_telpC').hide();
            $('#no_telpC').removeClass('is-invalid animation-shake');
        }
    });
    
    $('#alamatC').on('input', function(){
        if($('small#error_alamatC').is(':visible')){
            $('small#error_alamatC').hide();
            $('#alamatC').removeClass('is-invalid animation-shake');
        }
    });


    //tambah customer
    $('#btnTambah').click(function() {
        var errorValidasi = 0;
        var data = $('#form_customer').serializeArray();
        if ($("#provinsiC").val() == null) {
            data.push({
                name: "provinsiC",
                value: ""
            });
        }
        if ($("#kabupatenC").val() == null) {
            data.push({
                name: "kabupatenC",
                value: ""
            });
        }
        if ($("#kecamatanC").val() == null) {
            data.push({
                name: "kecamatanC",
                value: ""
            });
        }
        var namaData = {
            namaC: "Nama Lengkap",
            emailC: "Email",
            provinsiC: "Provinsi",
            kabupatenC: "Kabupaten",
            kecamatanC: "Kecamatan",
            kode_posC: "Kode Pos",
            no_telpC: "Nomor Telepon",
            alamatC: "Alamat",
			passwordC: "Password",
        };
        $.each(data, (i, v) => {
            if (v.name != "tipe_customerM" && v.value == "") {
                if (v.name == 'provinsiC' || v.name == 'kabupatenC' || v.name == 'kecamatanC') {
                    $('#' + v.name).selectpicker('setStyle', 'animation-shake', 'add');
                } else {
                    $('#' + v.name).attr('class', 'form-control is-invalid animation-shake');
                }
                $('#error_' + v.name).show();
                $('#error_' + v.name).attr('class', 'invalid-feedback');
                $('#error_' + v.name).html(namaData[v.name] + ' tidak boleh kosong!');
                errorValidasi++;
            }
            if (v.name == "namaC" && v.value.length > 191) {
                $('#' + v.name).attr('class', 'form-control is-invalid animation-shake');
                $('#error_' + v.name).show();
                $('#error_' + v.name).attr('class', 'invalid-feedback');
                $('#error_' + v.name).html(namaData[v.name] +
                    ' tidak boleh lebih dari 191 karakter!');
                errorValidasi++;
            }
            if (v.name == "emailC" && v.value != "") {
                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (!regex.test(v.value)) {
                    $('#' + v.name).attr('class', 'form-control is-invalid animation-shake');
                    $('#error_' + v.name).show();
                    $('#error_' + v.name).attr('class', 'invalid-feedback');
                    $('#error_' + v.name).html('Masukkan ' + namaData[v.name] + ' yang benar!');
                    errorValidasi++;
                }
            }
            if (v.name == "kategoriC") {
                if (v.value != "Customer" && v.value != "Reseller" && v.value !=
                    "Dropshipper") {
                    v.value = "Customer";
                }
            }
        });
        if (errorValidasi == 0) {
            var hasil = {};
            $.each(data, function(i, v) {
                hasil[v.name] = v.value;
            })
            hasil.tipeKirim = 'tambah_customer';
            // return console.log(hasil);
            var resp = '';
            $.ajax({
                type: 'post',
                url: "{{ route('b.order-proses') }}",
                data: hasil,
                success: function(datares) {
                    resp = datares;
                },
                error: function(xhr, b, c) {
                    console.log(xhr, b, c);
                    swal("Error", '' + c, "error");
                }
            }).done(function() {
                $('#modTambah').modal('hide');
                if (resp.sukses) {
                    swal("Berhasil!", "Berhasil menambah Customer!", "success");
                    $('#pemesanKat').val(hasil.kategoriC);
                    var htmltoParse = hasil.namaC + "|" + hasil.alamatC + "|" + hasil.kecamatanC + "|" + hasil.kabupatenC + "|" + hasil.provinsiC + "|" +
                        hasil.kode_posC + "|" + hasil.kategoriC;
                    var hasilParse = parseHtml(htmltoParse);
                    $('#btn' + hasil.tipe_customerM + 'C').hide();
                    $("input#id" + hasil.tipe_customerM).hide();
                    var valOld = htmltoParse.split('|');
                    if (hasil.tipe_customerM == "UntukKirim") {
                        $("#id"+ hasil.tipe_customerM).val(resp.last_id);
                        $('#hasil' + hasil.tipe_customerM).html(hasilParse);
                        $('#hasil' + hasil.tipe_customerM).show();
                        untukKirimOld = valOld[0];
                        if($("#loaderUntukKirim").html() != ''){
                            $("#loaderUntukKirim").html('');
                        }
                    } else if (hasil.tipe_customerM == "Pemesan") {
                        $("#id"+ hasil.tipe_customerM).val(resp.last_id);
                        $('#hasilCari' + hasil.tipe_customerM).html(hasilParse);
                        $('#hasilCari' + hasil.tipe_customerM).show();
                        pemesanOld = valOld[0];
                        if($("#loaderPemesan").html() != ''){
                            $("#loaderPemesan").html('');
                        }
                    }
                    hapusIsi();
                    cacheCust = {};
                } else {
                    swal("Gagal", "" + resp.msg, "error");
                }
            }).fail(function() {
                $('#modTambah').modal('hide');
            });
        }
    });


    //pemesan
    $('#idPemesan').on('click', function(e, ui) {
        if($(this).hasClass("animation-shake")){
            $(this).removeClass("animation-shake");
            $(this).attr("style", "");
        }
        if($("#alert-error").is(":visible")){
            $("#alert-error").delay(3000).slideUp("slow");
        }
    });

    $("input#idPemesan").on('input', function(){
        if($("#loaderPemesan").html() != ''){
            $("#loaderPemesan").html('');
        }
    });

    $("input#idPemesan").autocomplete({
        source: function(request, response) {
            var term = request.term;
            if (term in cacheCust) {
                response(cacheCust[term]);
                if(cacheCust[term].length > 0){
                    $("#loaderPemesan").html("");
                } else {
                    $("#loaderPemesan").html("<span class='badge badge-danger badge-md badge-round'>Tidak ditemukan!</span>");
                }
                return;
            }

            $.ajax({
                url: "{{ route('b.ajax-getCustomer') }}",
                type: 'get',
                dataType: "json",
                data: {
                    search: request.term
                },
                success: function(data) {
                    cacheCust[term] = data;
                    response(data);
                    if(data.length > 0){
                        $("#loaderPemesan").html("");
                    } else {
                        $("#loaderPemesan").html("<span class='badge badge-danger badge-md badge-round'>Tidak ditemukan!</span>");
                    }
                },
                beforeSend: function(){
                    $("#loaderPemesan").html("<div class='loader vertical-align-middle loader-rotate-plane' style='height:20px;width:20px'></div>");
                },
            });
        },
        open: function(e, ui) {
            var acData = $(this).data('uiAutocomplete');
            acData.menu.element.find('div').each(function() {
                var me = $(this);
                var t = parseHtml(me.text());
                me.html(' ');
                me.html(t);
            });
        },
        select: function(event, ui) {
            var hasil = parseHtml(ui.item.label);
            $('#hasilCariPemesan').html(hasil);
            $('#hasilCariPemesan').show();
            $('#btnPemesanC').hide();
            $(this).hide();
            var pemOld = ui.item.label.split('|');
            pemesanOld = pemOld[0];
            $("#pemesanKat").val(pemOld[pemOld.length - 1]);
        }
    });

    $('#hasilCariPemesan').click(function() {
        if($("#produk-list tr").length > 0){
            $('#panelOrder').removeClass("panel-primary");
            $('#panelOrder').removeClass("animation-slide-right");
            $('#panelOrder').addClass("animation-shake panel-warning");
            return alertify.warning('Jika pemesan akan diedit maka data orderan harus kosong!').dismissOthers();
        }
        $(this).hide();
        $('#hasilCariPemesan').html('');
        $('input#idPemesan').show();
        $('#btnPemesanC').show();
        $('input#idPemesan').val(pemesanOld);
        $("#pemesanKat").val("");
    });


    //untuk kirim
    $('#idUntukKirim').on('autocompleteselect', function(e, ui) {
        var tempPilihUntuk = ui.item.label.split("|")[2];
        $.ajax({
            url: "{{ route('b.ajax-cariKecamatan') }}",
            type: 'get',
            dataType: "json",
            data: {
                term: tempPilihUntuk
            },
            success: function(data) {
                if (typeof data !== 'undefined' && data.length > 0) {
                    pilihUntuk = data[0].value;
                } else {
                    pilihUntuk = "";
                }
            },
            error: function(a,b,c){
                console.log('==========');
                console.log('line 1868:');
                console.log(a,b,c);
                console.log('==========');
            }
        });
    });

    $("input#idUntukKirim").on('input', function(){
        if($("#loaderUntukKirim").html() != ''){
            $("#loaderUntukKirim").html('');
        }
    });
    
    $("input#idUntukKirim").autocomplete({
        source: function(request, response) {
            var term = request.term;
            if (term in cacheCust) {
                response(cacheCust[term]);
                if(cacheCust[term].length > 0){
                    $("#loaderUntukKirim").html("");
                } else {
                    $("#loaderUntukKirim").html("<span class='badge badge-danger badge-md badge-round'>Tidak ditemukan!</span>");
                }
                return;
            }
            
            $.ajax({
                url: "{{ route('b.ajax-getCustomer') }}",
                type: 'get',
                dataType: "json",
                data: {
                    search: request.term
                },
                success: function(data) {
                    cacheCust[term] = data;
                    response(data);
                    if(data.length > 0){
                        $("#loaderUntukKirim").html("");
                    } else {
                        $("#loaderUntukKirim").html("<span class='badge badge-danger badge-md badge-round'>Tidak ditemukan!</span>");
                    }
                },
                beforeSend: function(){
                    $("#loaderUntukKirim").html("<div class='loader vertical-align-middle loader-rotate-plane' style='height:20px;width:20px'></div>");
                },
            });
        },
        open: function(e, ui) {
            var acData = $(this).data('uiAutocomplete');
            acData.menu.element.find('div').each(function() {
                var me = $(this);
                var t = parseHtml(me.text());
                me.html(' ');
                me.html(t);
            });
        },
        select: function(event, ui) {
            var hasil = parseHtml(ui.item.label);
            $('#hasilUntukKirim').html(hasil);
            $('#hasilUntukKirim').show();
            $('#btnUntukKirimC').hide();
            $(this).hide();
            var ukOld = ui.item.label.split('|');
            untukKirimOld = ukOld[0];
        }
    });
    
    $('#hasilUntukKirim').click(function() {
        $(this).hide();
        $('#hasilUntukKirim').html('');
        $('input#idUntukKirim').show();
        $('#btnUntukKirimC').show();
        $('input#idUntukKirim').val(untukKirimOld);
        pilihUntuk = "";
        sudahCekOngkir = false;
        $("#expedisi-list").html("");
        $("#ongkir").text("Rp 0");
        $(".tro-toko").addClass(".tr-ongkir-selected");
        $(".tro-toko").attr("style", "background-color:#0099B8;color:white;");
    });
    
    $('#idUntukKirim').on('click', function(e, ui) {
        if($(this).hasClass("animation-shake")){
            $(this).removeClass("animation-shake");
            $(this).attr("style", "");
        }
        if($("#alert-error").is(":visible")){
            $("#alert-error").delay(3000).slideUp("slow");
        }
    });


    //dari kirim
    $('#hasilDariKirim').click(function() {
        $(this).hide();
        $('#hasilDariKirim').html('');
        $('input#idDariKirim').show();
        $('#btnDariKirimC').show();
        $('input#idDariKirim').val(dariKirimOld);
        $("#cDari").show();
        pilihDari = "";
        sudahCekOngkir = false;
        $("#expedisi-list").html("");
        $(".tro-toko").addClass(".tr-ongkir-selected");
        $(".tro-toko").attr("style", "background-color:#0099B8;color:white;");
    });

    $('#idDariKirim').on('click', function(e, ui) {
        if($(this).hasClass("animation-shake")){
            $(this).removeClass("animation-shake");
            $(this).attr("style", "");
        }
        if($("#alert-error").is(":visible")){
            $("#alert-error").delay(3000).slideUp("slow");
        }
    });
    
    $("input#idDariKirim").autocomplete({
        minLength: 3,
        source: function(request, response) {
            var term = request.term;
            if (term in cacheDariKirim) {
                response(cacheDariKirim[term]);
                if(cacheDariKirim[term].length > 0){
                    $("#loaderDariKirim").html("");
                } else {
                    $("#loaderDariKirim").html("<span class='badge badge-danger badge-md badge-round'>Tidak ditemukan!</span>");
                }
                return;
            }

            $.ajax({
                url: "{{ route('b.ajax-cariKecamatan') }}",
                type: 'get',
                dataType: "json",
                data: request,
                success: function(data) {
                    cacheDariKirim[term] = data;
                    response(data);
                    if(data.length > 0){
                        $("#loaderDariKirim").html("");
                    } else {
                        $("#loaderDariKirim").html("<span class='badge badge-danger badge-md badge-round'>Tidak ditemukan!</span>");
                    }
                },
                beforeSend: function(){
                    $("#loaderDariKirim").html("<div class='loader vertical-align-middle loader-rotate-plane' style='height:20px;width:20px'></div>");
                },
            });
        },
        open: function(e, ui) {
            var acData = $(this).data('uiAutocomplete');
            acData.menu.element.find('div').each(function() {
                var me = $(this);
                var t = me.text();
                me.html(' ');
                me.html(t);
            });
        },
        select: function(event, ui) {
            var hasil = ui.item.label;
            $('#hasilDariKirim').html(hasil);
            $('#hasilDariKirim').show();
            $("#cDari").hide();
            $(this).hide();
            pilihDari = ui.item.value;
            dariKirimOld = ui.item.label;
        }
    });
    
    $("input#idDariKirim").on('input', function(){
        if($("#loaderDariKirim").html() != ''){
            $("#loaderDariKirim").html('');
        }
    });


    //cari produk
    var item_prod = $('.uiop-ac-option'),
        cariProduk = $('#cariProduk');

    cariProduk.keyup(function(e) {
        var cari_prod = $(this).val();
        var hasilResp;
        if (cari_prod != '') {
            item_prod.show();
            if(cari_prod.replace(/[^a-zA-Z]/gi, '_') in cacheProduk){
                item_prod.html('');
                if(cacheProduk[cari_prod.replace(/[^a-zA-Z]/gi, '_')] == ''){
                    item_prod.html('<div>Tidak ditemukan!</div>');
                } else {
                    parseProdukData(cacheProduk[cari_prod.replace(/[^a-zA-Z]/gi, '_')], item_prod);
                }
            } else {
                $.ajax({
                    url: "{{ route('b.ajax-getProduk') }}",
                    dataType: 'json',
                    type: 'get',
                    data: {
                        'cari': cari_prod
                    },
                    beforeSend: function(){
                        item_prod.html("<div class='vertical-align text-center'><div class='loader vertical-align-middle loader-circle'></div></div>");
                    },
                    success: function(data) {
                        hasilResp = data;
                        cacheProduk[cari_prod.replace(/[^a-zA-Z]/gi, '_')] = data;
                    },
                    error: function(a, b, c) {
                        item_prod.html("");
                    }
                }).done(function() {
                    item_prod.html('');
                    if (hasilResp == '') {
                        item_prod.html('<div>Tidak ditemukan!</div>');
                    } else {
                        parseProdukData(hasilResp, item_prod);
                    }
                });
            }
        } else {
            item_prod.html('');
            item_prod.hide();
        }
    });

    $('.uiop-ac-option').on('click', '.btnTam', function() {
        var cekCustomerRole = null;
        if ($("#pemesanKat").val() != "") {
            cekCustomerRole = $("#pemesanKat").val();
        }
        if(cekCustomerRole == null){
            alertify.warning('Pilih Pemesan terlebih dahulu!').dismissOthers();
            return;
        }
        var inputJumlah = $(this).parent().parent().children("div:nth-child(3)").children().children("input");
        var classListInput = inputJumlah.attr("class").split(" ");
        var classID = jQuery.grep(classListInput, function(n, i) {
            var regexSpin = /spin_[0-9\-]+/g;
            return regexSpin.test(n);
        });
        var id_varianProd = classID[0].split("_")[1].split("-")[0];
        var dataProd;
        var boleh = true;
        var bolehSupp = true;
        $.each(prodTam, function(i, v) {
            if (v.split('|')[0] === id_varianProd) {
                boleh = false;
                return false;
            }
        })
        if (boleh) {
            $.ajax({
                url: "{{ route('b.ajax-getProdukDetail') }}",
                type: 'get',
                dataType: "json",
                data: {
                    id: id_varianProd
                },
                success: function(data) {
                    dataProd = data;
                },
                error: function(xhr, b, c) {
                    console.log(c);
                }
            }).done(function() {
                // console.log(dataProd);
                $.each(prodTam, function(i, v) {
                    if(v.split('|')[1] !== dataProd.stok.split('|')[1]){
                        bolehSupp = false;
                        return false;
                    }
                });
                if(!bolehSupp){
                    alertify.warning('Supplier Lain dan Produk Sendiri tidak dapat dijadikan dalam satu orderan!').dismissOthers();
                } else {
                    var totalBerat = parseInt($("#totalBerat").text().replace(",", ".")) * 1000;
                    var hasilBerat = totalBerat + (parseInt(dataProd.berat) * parseInt(inputJumlah.val()));
                    var grosir = [];
                    if (typeof dataProd.harga_grosir !== "undefined") {
                        $.each(dataProd.harga_grosir, function(i, v) {
                            grosir.push(v);
                        });
                    }
                    var berat = parseFloat($("#totalBerat").text().replace(",", ".")) + ((parseFloat(dataProd.berat) / 1000) * parseFloat(inputJumlah.val()));
                    $("#totalBerat").text(berat.toFixed(3).replace(".", ","));
                    sudahCekOngkir = false;
                    if(dataProd.foto != null && dataProd.foto != ''){
                        if(dataProd.foto.utama != null){
                            var foto = dataProd.foto.utama;
                        } else {
                            var foto = '{{ asset("photo.png") }}';
                        }
                    } else {
                        var foto = '{{ asset("photo.png") }}';
                    }
                    var diskonTampil = "";
                    if(cekCustomerRole == "Reseller"){
                        var ketemu_grosir = false;
                        if (typeof dataProd.harga_grosir !== "undefined") {
                            if(kat_customer.reseller.grosir == 1){
                                var subTotal, hargaAsli = 0;
                                $.each(dataProd.harga_grosir, function(i, v) {
                                    var rentan = v.rentan.split("-");
                                    for (var i2 = parseInt(rentan[0]); i2 <= parseInt(rentan[1]); i2++) {
                                        if (parseInt(inputJumlah.val()) == parseInt(i2)) {
                                            subTotal = parseInt(v.harga) * parseInt(inputJumlah.val());
                                            hargaAsli = parseInt(v.harga);
                                            ketemu_grosir = true;
                                            return false;
                                        }
                                    }
                                });
                            }
                        }
                        if(!ketemu_grosir){
                            if (dataProd.diskon_jual == null) {
                                var subTotal = ((dataProd.harga_jual_reseller == null) ? dataProd.harga_jual_normal : dataProd.harga_jual_reseller) * parseInt(inputJumlah.val());
                                var hargaAsli = ((dataProd.harga_jual_reseller == null) ? dataProd.harga_jual_normal : dataProd.harga_jual_reseller);
                            } else {
                                if(kat_customer.reseller.diskon == 1){
                                    var hitungHarga = dataProd.diskon_jual.split("|")[0];
                                    var tipeHitungHarga = dataProd.diskon_jual.split("|")[1];
                                    if (tipeHitungHarga == "%") {
                                        var hargaAwal = hargaAsli = ((dataProd.harga_jual_reseller == null) ? dataProd.harga_jual_normal : dataProd.harga_jual_reseller);
                                        var hargaDiskon = Math.round(((parseInt(hitungHarga) * hargaAwal) / 100)) || 0;
                                        var hargaAkhir = hargaAwal - hargaDiskon;
                                        diskonTampil = "(Diskon " + hitungHarga + "%)";
                                    } else if (tipeHitungHarga == "*") {
                                        var hargaAsli = ((dataProd.harga_jual_reseller == null) ? dataProd.harga_jual_normal : dataProd.harga_jual_reseller);
                                        var hargaAkhir = ((dataProd.harga_jual_reseller == null) ? dataProd.harga_jual_normal : dataProd.harga_jual_reseller) - parseInt(hitungHarga);
                                        diskonTampil = "(Diskon Rp " + uangFormat(parseInt(hitungHarga)) + ")";
                                    }
                                    var subTotal = hargaAkhir * parseInt(inputJumlah.val());
                                } else {
                                    var subTotal = ((dataProd.harga_jual_reseller == null) ? dataProd.harga_jual_normal : dataProd.harga_jual_reseller) * parseInt(inputJumlah.val());
                                    var hargaAsli = ((dataProd.harga_jual_reseller == null) ? dataProd.harga_jual_normal : dataProd.harga_jual_reseller);
                                }
                            }
                        }
                    } else if(cekCustomerRole == "Customer"){
                        var ketemu_grosir = false;
                        if (typeof dataProd.harga_grosir !== "undefined") {
                            if(kat_customer.customer.grosir == 1){
                                var subTotal, hargaAsli = 0;
                                $.each(dataProd.harga_grosir, function(i, v) {
                                    var rentan = v.rentan.split("-");
                                    for (var i2 = parseInt(rentan[0]); i2 <= parseInt(rentan[1]); i2++) {
                                        if (parseInt(inputJumlah.val()) == parseInt(i2)) {
                                            subTotal = parseInt(v.harga) * parseInt(inputJumlah.val());
                                            hargaAsli = parseInt(v.harga);
                                            ketemu_grosir = true;
                                            return false;
                                        }
                                    }
                                });
                            }
                        }
                        if(!ketemu_grosir){
                            if (dataProd.diskon_jual == null) {
                                var subTotal = dataProd.harga_jual_normal * parseInt(inputJumlah.val());
                                var hargaAsli = dataProd.harga_jual_normal;
                            } else {
                                if(kat_customer.customer.diskon == 1){
                                    var hitungHarga = dataProd.diskon_jual.split("|")[0];
                                    var tipeHitungHarga = dataProd.diskon_jual.split("|")[1];
                                    if (tipeHitungHarga == "%") {
                                        var hargaAwal = hargaAsli = dataProd.harga_jual_normal;
                                        var hargaDiskon = Math.round(((parseInt(hitungHarga) * hargaAwal) / 100)) || 0;
                                        var hargaAkhir = hargaAwal - hargaDiskon;
                                        diskonTampil = "(Diskon " + hitungHarga + "%)";
                                    } else if (tipeHitungHarga == "*") {
                                        var hargaAsli = dataProd.harga_jual_normal;
                                        var hargaAkhir = dataProd.harga_jual_normal - parseInt(hitungHarga);
                                        diskonTampil = "(Diskon Rp " + uangFormat(parseInt(hitungHarga)) + ")";
                                    }
                                    var subTotal = hargaAkhir * parseInt(inputJumlah.val());
                                } else {
                                    var subTotal = dataProd.harga_jual_normal * parseInt(inputJumlah.val());
                                    var hargaAsli = dataProd.harga_jual_normal;
                                }
                            }
                        }
                    } else if(cekCustomerRole == "Dropshipper"){
                        var ketemu_grosir = false;
                        if (typeof dataProd.harga_grosir !== "undefined") {
                            if(kat_customer.dropshipper.grosir == 1){
                                var subTotal, hargaAsli = 0;
                                $.each(dataProd.harga_grosir, function(i, v) {
                                    var rentan = v.rentan.split("-");
                                    for (var i2 = parseInt(rentan[0]); i2 <= parseInt(rentan[1]); i2++) {
                                        if (parseInt(inputJumlah.val()) == parseInt(i2)) {
                                            subTotal = parseInt(v.harga) * parseInt(inputJumlah.val());
                                            hargaAsli = parseInt(v.harga);
                                            ketemu_grosir = true;
                                            return false;
                                        }
                                    }
                                });
                            }
                        }
                        if(!ketemu_grosir){
                            if (dataProd.diskon_jual == null) {
                                var subTotal = dataProd.harga_jual_normal * parseInt(inputJumlah.val());
                                var hargaAsli = dataProd.harga_jual_normal;
                            } else {
                                if(kat_customer.dropshipper.diskon == 1){
                                    var hitungHarga = dataProd.diskon_jual.split("|")[0];
                                    var tipeHitungHarga = dataProd.diskon_jual.split("|")[1];
                                    if (tipeHitungHarga == "%") {
                                        var hargaAwal = hargaAsli = dataProd.harga_jual_normal;
                                        var hargaDiskon = Math.round(((parseInt(hitungHarga) * hargaAwal) / 100)) || 0;
                                        var hargaAkhir = hargaAwal - hargaDiskon;
                                        diskonTampil = "(Diskon " + hitungHarga + "%)";
                                    } else if (tipeHitungHarga == "*") {
                                        var hargaAsli = dataProd.harga_jual_normal;
                                        var hargaAkhir = dataProd.harga_jual_normal - parseInt(hitungHarga);
                                        diskonTampil = "(Diskon Rp " + uangFormat(parseInt(hitungHarga)) + ")";
                                    }
                                    var subTotal = hargaAkhir * parseInt(inputJumlah.val());
                                } else {
                                    var subTotal = dataProd.harga_jual_normal * parseInt(inputJumlah.val());
                                    var hargaAsli = dataProd.harga_jual_normal;
                                }
                            }
                        }
                    }
                    var nama_prod_tampil = dataProd.nama_produk;
                    if((dataProd.ukuran != null && dataProd.ukuran != "") && (dataProd.warna != null && dataProd.warna != "")){
                        nama_prod_tampil += " ("+dataProd.ukuran+" "+dataProd.warna+") ";
                    } else if((dataProd.ukuran != null && dataProd.ukuran != "") && (dataProd.warna == null || dataProd.warna == "")){
                        nama_prod_tampil += " ("+dataProd.ukuran+") ";
                    } else if((dataProd.ukuran == null || dataProd.ukuran == "") && (dataProd.warna != null && dataProd.warna != "")){
                        nama_prod_tampil += " ("+dataProd.warna+") ";
                    }
                    $("#produk-list").append(
                        "<tr class='trDiv' id='trP-" + id_varianProd +"'>" +
                            "<td>" +
                                "<textarea id='ta-" + id_varianProd + "' class='hidden'>" + JSON.stringify(dataProd) + "</textarea>" +
                                "<div class='d-flex'><img class='rounded' width='50' height='50' src='" + foto + "'>" +
                                "<div class='ml-15 mt-3'>" + nama_prod_tampil + "</div></div>" +
                            "</td>" +
                            "<td>" +
                                "Rp " + uangFormat(hargaAsli) +
                                "<br><div class='diskonHitung' style='color:#F2353C'>" +
                            diskonTampil + "</div></td>" +
                            "<td class='jumlahHitung'>" +
                                inputJumlah.val() +
                            "</td>" +
                            "<td class='text-right uangHitung'>" +
                                "Rp " + uangFormat(subTotal) +
                            "</td>" +
                            "<td><a style='cursor:pointer;' onClick='$(this).parent().parent().attr(\"style\", \"background-color: #f0f0f0;\");$(this).popover(\"show\")' href='javascript:void(0)' id='myPop-" +
                                id_varianProd + "'>" +
                                "<i class='glyphicon glyphicon-option-horizontal'></i>" +
                            "</a></td>" +
                        "</tr>");
                    prodTam.push(id_varianProd+'|'+dataProd.stok.split('|')[1]);
                    alertify.success('Produk berhasil ditambahkan!');
                    $('#myPop-' + id_varianProd).webuiPopover({
                        content: "<div class='text-center'><button class='btn btn-sm btn-outline-success mr-5 ml--40' type='button'" +
                            " data-target='#tambahDiskonProd' data-toggle='modal'onClick='tamDiskon(\"#ta-" +
                            id_varianProd + "\", \"#myPop-" + id_varianProd + "\");'" +
                            "><i class=' fa fa-plus'></i> Diskon Produk</button>" +
                            "<button class='btn btn-sm btn-outline-warning mr-5' type='button' data-target='#editProd' data-toggle='modal'" +
                            " onClick='editProd(\"#ta-" + id_varianProd +
                            "\", \"#myPop-" + id_varianProd +
                            "\");'><i class='fa fa-pencil'></i> Edit</button>" +
                            "<button class='btn btn-sm btn-outline-danger mr-5' type='button' onClick='hapusProd(\"#trP-" +
                            id_varianProd +
                            "\")'><i class='fa fa-trash-o'></i> Hapus</button></div>",
                        width: 320,
                        animation: "pop"
                    });
                    $('#myPop-' + id_varianProd).on('hidden.webui.popover', function() {
                        $(this).parent().parent().attr("style",
                            "background-color: #ffffff;");
                    })
                    cekProdTam();
                    hitungSubTotal();
                }
            });
        } else {
            alertify.warning('Produk telah ditambahkan sebelumnya!').dismissOthers();
        }
    });


    //panel order
    $('#panelOrder').on('mouseover', function(e, ui) {
        if($(this).hasClass("animation-shake")){
            $(this).removeClass("animation-shake");
            $(this).removeClass("panel-warning");
            $(this).addClass("panel-primary");
        }
        if($("#alert-error").is(":visible")){
            $("#alert-error").delay(3000).slideUp("slow");
        }
    });


    //diskon produk
    $('#tipeDiskon').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
        if ($(this).val() == "Rp") {
            $("#tempatDiskonPersen").hide();
        } else if ($(this).val() == "%") {
            $("#tempatDiskonPersen").show();
        }
    });

    $("#tambahDiskonProd").on('input', '.diskonTipe', function(event) {
        if ($("#diskonNamaTamDis").text() != "" && this.value == "") {
            $("#btnTamDis").val("Hapus Diskon");
        } else if ($("#diskonNamaTamDis").text() != "" && this.value != "") {
            $("#btnTamDis").val("Edit Diskon");
        }
        if ($("#tipeDiskon").val() == "Rp") {
            if (this.value > uangToAngka($("#hargaAwalTamDis").val()))
                this.value = uangToAngka($("#hargaAwalTamDis").val());
            var hargaAwal = uangToAngka($("#hargaAwalTamDis").val());
            var hargaAkhir = hargaAwal - parseInt(($("#diskonTamDis").val() == "" ? 0 : $("#diskonTamDis").val()));
            $("#hargaAkhirTamDis").val("Rp " + uangFormat(hargaAkhir));
        } else if ($("#tipeDiskon").val() == "%") {
            if (this.value > 100)
                this.value = 100;
            var hargaAwal = uangToAngka($("#hargaAwalTamDis").val());
            var hargaDiskon = Math.round(((parseInt($("#diskonTamDis").val()) * hargaAwal) / 100)) || 0;
            var hargaAkhir = hargaAwal - hargaDiskon;
            $("#diskonPersenTamDis").val("Rp " + uangFormat(hargaDiskon));
            $("#hargaAkhirTamDis").val("Rp " + uangFormat(hargaAkhir));
        }
    });
    
    $('#tipeDiskon').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
        $("#diskonTamDis").val("");
        $("#diskonPersenTamDis").val("");
        $("#hargaAkhirTamDis").val("");
    });

    $("#btnTamDis").click(function() {
        var id = $("#drP").val().split("-")[1];
        var pusat = $("#trP-" + id).children("td:nth-child(2)").children(".diskonHitung");
        if (pusat.text() != "" && $("#diskonTamDis").val() == "") {
            pusat.text("");
            var hargaAwal = uangToAngka($("#trP-" + id).children("td:nth-child(2)").text().split("<br>")[0]);
            var jumlahAwal = parseInt($("#trP-" + id).children("td:nth-child(3)").text());
            var hasilAkhir = "Rp " + uangFormat(hargaAwal * jumlahAwal);
            $("#trP-" + id).children(".uangHitung").text(hasilAkhir);
            alertify.success('Berhasil menghapus diskon!');
        } else if (pusat.text() == "" && $("#diskonTamDis").val() != "") {
            if ($("#tipeDiskon").val() == "Rp") {
                pusat.text("(Diskon Rp " + uangFormat($("#diskonTamDis").val()) + ")");
            } else if ($("#tipeDiskon").val() == "%") {
                pusat.text("(Diskon " + $("#diskonTamDis").val() + "%)");
            }
            alertify.success('Berhasil menambah diskon!');
        } else if (pusat.text() != "" && $("#diskonTamDis").val() != "") {
            if ($("#tipeDiskon").val() == "Rp") {
                pusat.text("(Diskon Rp " + uangFormat($("#diskonTamDis").val()) + ")");
            } else if ($("#tipeDiskon").val() == "%") {
                pusat.text("(Diskon " + $("#diskonTamDis").val() + "%)");
            }
            alertify.success('Berhasil mengedit diskon!');
        }
        if ($("#hargaAkhirTamDis").val() != "")
            $("#trP-" + id).children(".uangHitung").text("Rp " + uangFormat(uangToAngka($(
                "#hargaAkhirTamDis").val()) * parseInt($("#trP-" + id).children(
                "td:nth-child(3)").text())));
        hitungSubTotal();
        $("#tambahDiskonProd").modal("hide");
    });
    
    $("#tambahDiskonProd").on('hidden.bs.modal', function() {
        $("#diskonTamDis").val("");
        $("#diskonPersenTamDis").val("");
        $("#hargaAkhirTamDis").val("");
    });


    //edit jumlah produk
    $("#editProd").on("change", "#stokEditProd", function() {
        editOnChange();
    });

    $("#editProd").on('hidden.bs.modal', function(){
        if(!temp_harga_edit.cek){
            $("#trP-" + temp_harga_edit.id).children("td:nth-child(2)").html(temp_harga_edit.data);
        }
        isCekTemp_harga_edit = false;
        temp_harga_edit.cek = false;
    });
    
    $("#btnEditProd").click(function() {
        temp_harga_edit.cek = true;
        var data = jQuery.parseJSON($("#taEdit").text());
        var pusat = $("#trP-" + data.id_varian);
        var stokLawas = pusat.children(".jumlahHitung").text();
        var beratLawas = parseFloat($("#totalBerat").text().replace(",", ".")) - ((parseFloat(data.berat) / 1000) * parseFloat(stokLawas));
        pusat.children(".jumlahHitung").text($("#stokEditProd").val());
        var beratBaru = parseFloat(beratLawas) + ((parseFloat(data.berat) / 1000) * parseFloat($("#stokEditProd").val()));
        $("#totalBerat").text(beratBaru.toFixed(3).replace(".", ","));
        pusat.children(".uangHitung").text($("#hargaEditProd").val());
        sudahCekOngkir = false;
        alertify.success('Berhasil mengedit produk!');
        hitungSubTotal();
        $('#editProd').modal('hide');
    });


    //panel kurir
    $("#table_ongkir").on("click", ".tr-ongkir", function() {
        var list = Array.prototype.slice.call($(".tr-ongkir"));
        list.forEach(function(html) {
            if ($(html).hasClass("tr-ongkir-selected")) {
                $(html).attr("style", "");
                $(html).removeClass("tr-ongkir-selected");
            }
        });
        $(this).addClass("tr-ongkir-selected");
        $(this).attr("style", "background-color:#0099B8;color:white;");
        $("#ongkir").text($(this).children("td:nth-child(4)").text());
        if (!$(this).hasClass(".tro-kur")) {
            $("#ongKurir").slideUp("slow");
            $("#namaKurir").addClass("disabled");
            $("#tarifKurir").addClass("disabled");
        }
        cekTotalHarga("ongkir");
    });

    $("#table_ongkir").on("click", ".tro-kur", function() {
        $("#ongKurir").slideDown("slow");
        $("#namaKurir").removeClass("disabled");
        $("#tarifKurir").removeClass("disabled");
    });

    $("#ongKurir").on('input', '#tarifKurir', function(event) {
        this.value = this.value.replace(/[^0-9,-.]/g, '');
        if (this.value == "") {
            valTemp = "0";
        } else {
            valTemp = this.value;
        }
        var val = "Rp " + uangFormat(valTemp);
        $(".tro-kur").children("td:nth-child(4)").text(val);
        $("#ongkir").text(val);
        cekTotalHarga("ongkir");
    });

    $("#ongKurir").on('input', '#namaKurir', function(event) {
        if (this.value == "") {
            valTemp = "Nama Kurir";
        } else {
            valTemp = this.value;
        }
        $(".tro-kur").children("td:first").text(valTemp);
    });



    //panel total
    $("#tambahDiskonOrder").on('hidden.bs.modal', function() {
        if ($("#namaTamDisOr").hasClass("is-invalid"))
            $("#namaTamDisOr").removeClass("is-invalid animation-shake");
        $("#namaTamDisOr").val("");
        $("#nominalTamDisOr").val("");
    });

    $("#tambahDiskonOrder").on('input', '#namaTamDisOr', function(event) {
        if ($("#namaTamDisOr").hasClass("is-invalid"))
            $("#namaTamDisOr").removeClass("is-invalid animation-shake");
    });
    
    $("#btnTamBiaya").click(function() {
        var namaBiaya = $("#namaTamBiaya").val();
        if (namaBiaya == "") {
            $("#namaTamBiaya").addClass("animation-shake is-invalid");
            return;
        }
        var nomBiaya = ($("#nominalTamBiaya").val() == "") ? "0" : $("#nominalTamBiaya").val();
        if (parseInt(nomBiaya) != 0) {
            $("#biayaLain-list").append("<tr id='trBiaya-" + nomBiaya + "'>" +
                "<td>" + namaBiaya + " (Biaya Lain)</td>" +
                "<td class='text-right'>Rp " + uangFormat(nomBiaya) + "</td>" +
                "<td><a style='cursor:pointer;' onClick='$(this).parent().parent().attr(\"style\", \"background-color: #f0f0f0;\");$(this).popover(\"show\")' href='javascript:void(0)' id='myPopBiaya-" +
                nomBiaya + "'>" +
                "<i class='glyphicon glyphicon-option-horizontal'></i>" +
                "</a></td>" +
                "</tr>"
            );
            $('#myPopBiaya-' + nomBiaya).webuiPopover({
                content: "<button class='btn btn-sm btn-outline-warning mr-5' type='button' data-target='#editBiayaLain' data-toggle='modal'" +
                    " onClick='editBiaya(\"#myPopBiaya-" + nomBiaya +
                    "\");'><i class='fa fa-pencil'></i> Edit</button>" +
                    "<button class='btn btn-sm btn-outline-danger mr-5' type='button' onClick='hapusBiaya(\"#trBiaya-" +
                    nomBiaya + "\")'><i class='fa fa-trash-o'></i> Hapus</button></div>",
                width: 185,
                animation: "pop"
            });
            $('#myPopBiaya-' + nomBiaya).on('hidden.webui.popover', function() {
                $(this).parent().parent().attr("style", "background-color: #ffffff;");
            })
            alertify.success('Berhasil menambah Biaya Lain!');
            hitungTotalHarga();
            $("#tambahBiayaLain").modal("hide");
        } else {
            alertify.warning('Nominal tidak boleh 0!');
        }
    });

    $("#tambahBiayaLain").on('hidden.bs.modal', function() {
        if ($("#namaTamBiaya").hasClass("is-invalid"))
            $("#namaTamBiaya").removeClass("is-invalid animation-shake");
        $("#namaTamBiaya").val("");
        $("#nominalTamBiaya").val("");
    });

    $("#tambahBiayaLain").on('input', '#namaTamBiaya', function(event) {
        if ($("#namaTamBiaya").hasClass("is-invalid"))
            $("#namaTamBiaya").removeClass("is-invalid animation-shake");
    });
    
    $("#btnTamDisOrder").click(function() {
        var namaDiskon = $("#namaTamDisOr").val();
        if (namaDiskon == "") {
            $("#namaTamDisOr").addClass("animation-shake is-invalid");
            return;
        }
        var nomDiskon = ($("#nominalTamDisOr").val() == "") ? "0" : $("#nominalTamDisOr").val();
        if (parseInt(nomDiskon) != 0) {
            $("#diskonOrder-list").append("<tr id='trOrder-" + nomDiskon + "'>" +
                "<td>" + namaDiskon + " (Diskon Order)</td>" +
                "<td class='text-right'><div style='color:#F2353C;'>- Rp " + uangFormat(nomDiskon) +
                "</div></td>" +
                "<td><a style='cursor:pointer;' onClick='$(this).parent().parent().attr(\"style\", \"background-color: #f0f0f0;\");$(this).popover(\"show\")' href='javascript:void(0)' id='myPopTot-" +
                nomDiskon + "'>" +
                "<i class='glyphicon glyphicon-option-horizontal'></i>" +
                "</a></td>" +
                "</tr>"
            );
            $('#myPopTot-' + nomDiskon).webuiPopover({
                content: "<button class='btn btn-sm btn-outline-warning mr-5' type='button' data-target='#editDiskonOrder' data-toggle='modal'" +
                    " onClick='editOrder(\"#myPopTot-" + nomDiskon +
                    "\");'><i class='fa fa-pencil'></i> Edit</button>" +
                    "<button class='btn btn-sm btn-outline-danger mr-5' type='button' onClick='hapusOrder(\"#trOrder-" +
                    nomDiskon + "\")'><i class='fa fa-trash-o'></i> Hapus</button></div>",
                width: 185,
                animation: "pop"
            });
            $('#myPopTot-' + nomDiskon).on('hidden.webui.popover', function() {
                $(this).parent().parent().attr("style", "background-color: #ffffff;");
            })
            alertify.success('Berhasil menambah Diskon Order!');
            hitungTotalHarga();
            $("#tambahDiskonOrder").modal("hide");
        } else {
            alertify.warning('Nominal tidak boleh 0!');
        }
    });

    $("#editDiskonOrder").on("click", "#btnEditDisOrder", function() {
        var id = $("#taOrder").val().split("-")[1];
        var namaDiskon = $("#namaEditDisOr").val();
        if (namaDiskon == "") {
            $("#namaEditDisOr").addClass("animation-shake is-invalid");
            return;
        }
        var nomDiskon = ($("#nominalEditDisOr").val() == "") ? "0" : $("#nominalEditDisOr").val();
        if (parseInt(nomDiskon) != 0) {
            $("#trOrder-" + id).html(
                "<td>" + namaDiskon + " (Diskon Order)</td>" +
                "<td class='text-right'><div style='color:#F2353C;'>- Rp " + uangFormat(nomDiskon) +
                "</div></td>" +
                "<td><a style='cursor:pointer;' onClick='$(this).parent().parent().attr(\"style\", \"background-color: #f0f0f0;\");$(this).popover(\"show\")' href='javascript:void(0)' id='myPopTot-" +
                id + "'>" +
                "<i class='glyphicon glyphicon-option-horizontal'></i>" +
                "</a></td>"
            );
            $('#myPopTot-' + id).webuiPopover({
                content: "<button class='btn btn-sm btn-outline-warning mr-5' type='button' data-target='#editDiskonOrder' data-toggle='modal'" +
                    " onClick='editOrder(\"#myPopTot-" + id +
                    "\");'><i class='fa fa-pencil'></i> Edit</button>" +
                    "<button class='btn btn-sm btn-outline-danger mr-5' type='button' onClick='hapusOrder(\"#trOrder-" +
                    id + "\")'><i class='fa fa-trash-o'></i> Hapus</button></div>",
                width: 185,
                animation: "pop"
            });
            $('#myPopTot-' + id).on('hidden.webui.popover', function() {
                $(this).parent().parent().attr("style", "background-color: #ffffff;");
            })
            alertify.success('Berhasil mengedit Diskon Order!');
            hitungTotalHarga();
            $("#editDiskonOrder").modal("hide");
        } else {
            alertify.warning('Nominal tidak boleh 0!');
        }
    });

    $("#editBiayaLain").on("click", "#btnEditBiaya", function() {
        var id = $("#taBiaya").val().split("-")[1];
        var namaBiaya = $("#namaEditBiaya").val();
        if (namaBiaya == "") {
            $("#namaEditBiaya").addClass("animation-shake is-invalid");
            return;
        }
        var nomBiaya = ($("#nominalEditBiaya").val() == "") ? "0" : $("#nominalEditBiaya").val();
        if (parseInt(nomBiaya) != 0) {
            $("#trBiaya-" + id).html(
                "<td>" + namaBiaya + " (Biaya Lain)</td>" +
                "<td class='text-right'>Rp " + uangFormat(nomBiaya) + "</td>" +
                "<td><a style='cursor:pointer;' onClick='$(this).parent().parent().attr(\"style\", \"background-color: #f0f0f0;\");$(this).popover(\"show\")' href='javascript:void(0)' id='myPopBiaya-" +
                id + "'>" +
                "<i class='glyphicon glyphicon-option-horizontal'></i>" +
                "</a></td>"
            );
            $('#myPopBiaya-' + id).webuiPopover({
                content: "<button class='btn btn-sm btn-outline-warning mr-5' type='button' data-target='#editBiayaLain' data-toggle='modal'" +
                    " onClick='editBiaya(\"#myPopBiaya-" + id +
                    "\");'><i class='fa fa-pencil'></i> Edit</button>" +
                    "<button class='btn btn-sm btn-outline-danger mr-5' type='button' onClick='hapusBiaya(\"#trBiaya-" +
                    id + "\")'><i class='fa fa-trash-o'></i> Hapus</button></div>",
                width: 185,
                animation: "pop"
            });
            $('#myPopBiaya-' + id).on('hidden.webui.popover', function() {
                $(this).parent().parent().attr("style", "background-color: #ffffff;");
            })
            alertify.success('Berhasil mengedit Biaya Lain!');
            hitungTotalHarga();
            $("#editBiayaLain").modal("hide");
        } else {
            alertify.warning('Nominal tidak boleh 0!');
        }
    });


    //panel pembayaran
    $('#statusBayar').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
        var val = $(this).val();
        if (val == "belum") {
            $("#tglBayar").slideUp("slow");
            $("#viaBayar").slideUp("slow");
            $("#nomBayar").slideUp("slow");
        } else if (val == "cicil") {
            $("#tglBayar").slideDown("slow");
            $("#viaBayar").slideDown("slow");
            $("#nomBayar").slideDown("slow");
        } else if (val == "lunas") {
            $("#tglBayar").slideDown("slow");
            $("#viaBayar").slideDown("slow");
            $("#nomBayar").slideUp("slow");
        }
    });

    $('#nominalBayar').on('click', function(e, ui) {
        if($(this).hasClass("animation-shake")){
            $(this).removeClass("animation-shake");
            $(this).attr("style", "");
        }
        if($("#alert-error").is(":visible")){
            $("#alert-error").delay(3000).slideUp("slow");
        }
    });
    
    $("#nomBayar").on('input', '#nominalBayar', function(event) {
        var total = uangToAngka($("#totalHarga").text());
        if (parseInt(this.value) > total) {
            alertify.warning('Nominal Pembayaran tidak boleh melebihi Total Tagihan Pembayaran!').dismissOthers();
            this.value = total;
        }
    });

    $('#historyBayarDiv').on('click', '.hapusHistoryBayar', function(){
        var badan = $(this).parent().parent();
        var id = badan.data('id').split('-')[1];
        var ini = $(this);
        swal({
            title: "Peringatan",
            text: "Apakah anda yakin ingin menghapus riwayat pembayaran tersebut?",
            icon: "warning",
            buttons: {
                confirm: {
                    text: "Iya",
                    value: true,
                    closeModal: true
                },
                cancel: {
                    text: "Tidak",
                    value: false,
                    visible: true,
                    closeModal: true,
                }
            },
            dangerMode: true
        }).then((willDelete) => {
            if (willDelete) {
                // alert('asd');
                var hasil = '';
                $.ajax({
                    type: 'post',
                    url: "{{ route('b.order-proses') }}",
                    data: {
                        id: id,
                        id_order: '{{ $data_edit["order"]->id_order }}',
                        tipeKirim: 'hapus_riwayat_bayar'
                    },
                    beforeSend: function(){
                        ini.html("<div class='loader loader-circle' style='width:10px;height:10px'></div>");
                    },
                    success: function (data) {
                        hasil = data;
                    },
                    error: function (xhr, b, c) {
                        swal("Error", '' + c, "error");
                    }
                }).done(function () {
                    // console.log(hasil);
                    if(hasil.sukses){
                        $('#historyBayarDiv').html('');
                        if(hasil.data.length > 0){
                            $.each(hasil.data, (i, v) => {
                                if(i == 0){
                                    var spanAwal = "<div data-id='bayar-"+v.id_bayar+"'>";
                                } else {
                                    var spanAwal = "<div style='border-top:1px solid #e4eaec;' data-id='bayar-"+v.id_bayar+"' class='mt-10 pt-10'>";
                                }
                                $('#historyBayarDiv').append(
                                    spanAwal+
                                        v.tgl_tampil+
                                        v.bank_tampil+
                                        "<span class='float-right'>"+
                                            "<span class='jumlahBayarRiwayat'>Rp "+uangFormat(v.nominal)+"</span>&nbsp;&nbsp;"+
                                            "<a href='javascript:void(0)' class='hapusHistoryBayar'><i class='fa fa-trash red-800 historyBayar'></i></a>"+
                                        "</span>"+
                                    "</div>"
                                );
                            });
                        } else {
                            $('#historyBayarDiv').html('Kosong');
                        }
                        $('.historyBayar').tooltip({
                            trigger: 'hover',
                            title: 'Hapus riwayat pembayaran',
                            placement: 'top'
                        });
                    }
                });
            }
        });
    });

    $('#btnViaBayar').on('click', function(e, ui) {
        if($(this).hasClass("animation-shake")){
            $(this).removeClass("animation-shake");
            $(this).attr("style", "width:100%");
        }
        if($("#alert-error").is(":visible")){
            $("#alert-error").delay(3000).slideUp("slow");
        }
    });

    $("#viaBayar").on('click', '.pilihViaBayar', function(event) {
        $("#btnViaBayar").html('<span class="filter-option pull-left">' + $(this).text() +
            '</span>&nbsp;<span style="font-size:8px">&#9660;</span>');
        if(typeof $(this).data('idb') !== 'undefined'){
            $("#btnViaBayar").data('idb', $(this).data('idb'));
        } else {
            if(typeof $("#btnViaBayar").data('idb') !== 'undefined'){
                $("#btnViaBayar").removeData('idb')
            }
        }
    });

    
});

</script>


<!-- modal edit biaya lain-->
<div class="modal fade modal-fade-in-scale-up" id="editBiayaLain" aria-hidden="true" aria-labelledby="exampleModalTitle"
    role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTitle">Edit Diskon Order</h4>
            </div>
            <div class="modal-body">
                <textarea id='taBiaya' class='hidden'></textarea>
                <div class='row mt-15 ml-5 mr-100'>
                    <div class='col-md-6 mt-10 text-right'>
                        Nama Biaya Lain
                    </div>
                    <div class='col-md-6'>
                        <input type="text" class="form-control" id='namaEditBiaya'>
                    </div>
                </div>
                <div class='row mt-15 ml-5 mr-100'>
                    <div class='col-md-6 mt-10 text-right'>
                        Nominal
                    </div>
                    <div class='col-md-6'>
                        <input type="text" class="form-control uangFormat" id='nominalEditBiaya'>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-warning" value='Edit Biaya Lain' name='btnEditBiaya'
                    id='btnEditBiaya'>
                <button class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- modal tambah biaya lain-->
<div class="modal fade modal-fade-in-scale-up" id="tambahBiayaLain" aria-hidden="true"
    aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTitle">Tambah Biaya Lain</h4>
            </div>
            <div class="modal-body">
                <div class='row mt-15 ml-5 mr-100'>
                    <div class='col-md-6 mt-10 text-right'>
                        Nama Biaya Lain
                    </div>
                    <div class='col-md-6'>
                        <input type="text" class="form-control" id='namaTamBiaya'>
                    </div>
                </div>
                <div class='row mt-15 ml-5 mr-100'>
                    <div class='col-md-6 mt-10 text-right'>
                        Nominal
                    </div>
                    <div class='col-md-6'>
                        <input type="text" class="form-control uangFormat" id='nominalTamBiaya'>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-success" value='Tambah Biaya Lain' name='btnTamBiaya'
                    id='btnTamBiaya'>
                <button class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- modal edit diskon order-->
<div class="modal fade modal-fade-in-scale-up" id="editDiskonOrder" aria-hidden="true"
    aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTitle">Edit Diskon Order</h4>
            </div>
            <div class="modal-body">
                <textarea id='taOrder' class='hidden'></textarea>
                <div class='row mt-15 ml-5 mr-100'>
                    <div class='col-md-6 mt-10 text-right'>
                        Nama Diskon
                    </div>
                    <div class='col-md-6'>
                        <input type="text" class="form-control" id='namaEditDisOr'>
                    </div>
                </div>
                <div class='row mt-15 ml-5 mr-100'>
                    <div class='col-md-6 mt-10 text-right'>
                        Nominal
                    </div>
                    <div class='col-md-6'>
                        <input type="text" class="form-control uangFormat diskonTipeOrder" id='nominalEditDisOr'>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-warning" value='Edit Diskon' name='btnEditDis' id='btnEditDisOrder'>
                <button class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- modal tambah diskon order-->
<div class="modal fade modal-fade-in-scale-up" id="tambahDiskonOrder" aria-hidden="true"
    aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTitle">Tambah Diskon Order</h4>
            </div>
            <div class="modal-body">
                <div class='row mt-15 ml-5 mr-100'>
                    <div class='col-md-6 mt-10 text-right'>
                        Nama Diskon
                    </div>
                    <div class='col-md-6'>
                        <input type="text" class="form-control" id='namaTamDisOr'>
                    </div>
                </div>
                <div class='row mt-15 ml-5 mr-100'>
                    <div class='col-md-6 mt-10 text-right'>
                        Nominal
                    </div>
                    <div class='col-md-6'>
                        <input type="text" class="form-control uangFormat diskonTipeOrder" id='nominalTamDisOr'>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-success" value='Tambah Diskon' name='btnTamDis' id='btnTamDisOrder'>
                <button class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- modal tambah diskon produk-->
<div class="modal fade modal-fade-in-scale-up" id="tambahDiskonProd" aria-hidden="true"
    aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTitle">Tambah Diskon Produk</h4>
            </div>
            <div class="modal-body">
                <input id='drP' type='text' class='hidden'>
                <div class='text-center'>
                    <img class='rounded' width='150' height='150' src='{{ asset("photo.png") }}' id='fotoTamDis'>
                </div>
                <div class='row mt-15 ml-5 mr-100'>
                    <div class='col-md-6 mt-10 text-right'>
                        Nama
                    </div>
                    <div class='col-md-6 mt-10' id='namaTamDis'>
                    </div>
                </div>
                <div class='row mt-15 ml-5 mr-100'>
                    <div class='col-md-6 mt-10 text-right'>
                        Harga Awal
                    </div>
                    <div class='col-md-6'>
                        <input type="text" class="form-control uangFormat" id='hargaAwalTamDis' readonly>
                    </div>
                </div>
                <div class='row mt-15 ml-5 mr-100'>
                    <div class='col-md-6 mt-10 text-right'>
                        Tipe Diskon
                    </div>
                    <div class='col-md-6'>
                        <div class='input-group'>
                            <select id='tipeDiskon' class='form-control'>
                                <option vlaue='Rp'>Rp</option>
                                <option value='%'>%</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class='row mt-15 ml-5 mr-100'>
                    <div class='col-md-6 mt-10 text-right'>
                        Diskon
                    </div>
                    <div class='col-md-6'>
                        <input type="text" class="form-control uangFormat diskonTipe" id='diskonTamDis'>
                    </div>
                </div>
                <div class='row mt-15 ml-5 mr-100' style='display:none;' id='tempatDiskonPersen'>
                    <div class='col-md-6 mt-10 text-right'>
                        Potongan Harga
                    </div>
                    <div class='col-md-6'>
                        <input type="text" class="form-control uangFormat disabled" id='diskonPersenTamDis' readonly>
                    </div>
                </div>
                <div class='row mt-15 ml-5 mr-100'>
                    <div class='col-md-6 mt-10 text-right'>
                        Harga Akhir
                    </div>
                    <div class='col-md-6'>
                        <input type="text" class="form-control uangFormat disabled" id='hargaAkhirTamDis' readonly>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-success" value='Tambah Diskon' name='btnTamDis' id='btnTamDis'>
                <button class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- modal edit produk-->
<div class="modal fade modal-fade-in-scale-up" id="editProd" aria-hidden="true" aria-labelledby="exampleModalTitle"
    role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTitle">Edit Produk</h4>
            </div>
            <div class="modal-body">
                <textarea id='taEdit' class='hidden'></textarea>
                <div class='text-center'>
                    <img class='rounded' width='150' height='150' src='{{ asset("photo.png") }}' id='fotoEditProd'>
                </div>
                <div class='row mt-15 ml-5 mr-100'>
                    <div class='col-md-6 mt-10 text-right'>
                        Nama
                    </div>
                    <div class='col-md-6 mt-10' id='namaEditProd'>
                    </div>
                </div>
                <div class='row mt-15 ml-5 mr-100'>
                    <div class='col-md-6 mt-10 text-right'>
                        Jumlah
                    </div>
                    <div class='col-md-6'>
                        <input name="jumlah_produkEdit" type="text" style="border-color:#28c0de"
                            class="form-control uangFormat" id='stokEditProd'>
                    </div>
                </div>
                <div class='row mt-15 ml-5 mr-100'>
                    <div class='col-md-6 mt-10 text-right'>
                        Harga
                    </div>
                    <div class='col-md-6'>
                        <input name="harga_produkEdit" type="text" class="form-control uangFormat disabled"
                            id='hargaEditProd' readonly>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-warning" value='Edit' name='btnEditProd' id='btnEditProd'>
                <button class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- modal tambah customer-->
<div class="modal fade modal-fade-in-scale-up" id="modTambah" aria-hidden="true" aria-labelledby="exampleModalTitle"
    role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple" style='max-width:800px;'>
        <div class="modal-content" style='width:800px;'>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTitle">Tambah Customer</h4>
            </div>
            <div class="modal-body">
                <form id="form_customer">
                    <input type='hidden' name='tipe_customerM' id='tipe_custumerM'>
                    <div class='row'>
                        <div class="col-md-4 form-group">
                            <label>Kategori Customer</label>
                            <select name='kategoriC' class='form-control' id='kategoriC'>
                                <option value='Customer'>Customer</option>
                                <option value='Reseller'>Reseller</option>
                                <option value='Dropshipper'>Dropshipper</option>
                            </select>
                        </div>
                        <div class="col-md-8 form-group">
                            <label>Nama Lengkap</label>
                            <input type='text' name='namaC' class='form-control' id='namaC'>
                            <small id="error_namaC" class='hidden'></small>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-md-6 form-group">
                            <label>Email</label>
                            <input type='email' name='emailC' class='form-control' id='emailC'>
                            <small id="error_emailC" class='hidden'></small>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Password</label>
                            <div class="input-search">
                                <button type="button" style="height:40px;cursor:pointer" class="input-search-btn" id='btnEye' tabindex='-1'><i class="icon md-eye-off" aria-hidden="true"></i></button>
                                <input type='text' name='passwordC' class='form-control' id='passwordC' placeholder="Password"
                                    value='{{$pass}}' autocomplete="on" style='border-radius:unset'>
                                <small id="error_passwordC" class="hidden"></small>
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-md-4 form-group">
                            <label>Provinsi</label>
                            <select name='provinsiC' class='form-control' id='provinsiC'>
                                <option value='' disabled selected>-- Pilih Provinsi --</option>
                                @php
                                $wilayah = json_decode($wilayah_indonesia);
                                foreach($wilayah as $w){
                                echo "<option value='".$w->provinsi."'>".$w->provinsi."</option>";
                                }
                                @endphp
                            </select>
                            <small id="error_provinsiC" class='hidden'></small>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Kabupaten/Kota</label>
                            <select name='kabupatenC' class='form-control' id='kabupatenC'>
                                <option value='' disabled selected>-- Pilih Kabupaten --</option>
                                @php
                                $wilayah = json_decode($wilayah_indonesia);
                                foreach($wilayah as $w){
                                foreach($w->kabupaten as $k){
                                echo "<option value='".$k->type." ".$k->kabupaten_nama."'>".$k->type."
                                    ".$k->kabupaten_nama."</option>";
                                }
                                }
                                @endphp
                            </select>
                            <small id="error_kabupatenC" class='hidden'></small>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Kecamatan</label>
                            <select name='kecamatanC' class='form-control' id='kecamatanC'>
                                <option value='' disabled selected>-- Pilih Kecamatan --</option>
                            </select>
                            <small id="error_kecamatanC" class='hidden'></small>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-md-4 form-group">
                            <label>Kode Pos</label>
                            <input type='text' name='kode_posC' class='form-control' id='kode_posC'>
                            <small id="error_kode_posC" class='hidden'></small>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>No telepon</label>
                            <div class='input-group'>
                                <div class='input-group-prepend'>
                                    <span class='input-group-text'><i class='glyphicon glyphicon-earphone'></i></span>
                                </div>
                                <input type='text' name='no_telpC' class='form-control' id='no_telpC'>
                            </div>
                            <small id="error_no_telpC" class='hidden'></small>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-md-12 form-group">
                            <label>Alamat</label>
                            <textarea name='alamatC' id='alamatC' class='form-control'></textarea>
                            <small id="error_alamatC" class='hidden'></small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-primary" value='Tambah' name='btnTambah' id='btnTambah'>
                <button class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!--uiop-->
@endsection