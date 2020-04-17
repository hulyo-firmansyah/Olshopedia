<!DOCTYPE html>
<html class="no-js css-menubar" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="bootstrap admin template">
    <meta name="author" content="NickmanUiop">

    <title>Olshopedia</title>
    <script src="{{ asset('template/global/vendor/jquery/jquery.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('alertifyjs/css/themes/bootstrap.min.css') }}">
    <link rel="apple-touch-icon" href="{{ asset('template/assets/images/apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('template/assets/images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('template/global/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/css/bootstrap-extend.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/fonts/font-awesome/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/vendor/icheck/icheck.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/vendor/icheck/polaris.css') }}">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
    <style>
    @media print {
        @page{
            margin:5mm;
            padding:0;
            size: auto;
        }

        #non-printable {
            display:none!important;
        }

        #printable, #printable * {
            visibility: visible;
            color-adjust: exact;
            -webkit-print-color-adjust: exact; 
            print-color-adjust: exact;
        }

        .setiap-ship-a6 {
            clear: both;
            float:none;
            padding:5mm;
            height:100%;
        }

        .setiap-ship-a6 table{
            width:148mm;
            height:194mm;
        }

        .invoice-tr-black {
            color:white!important;
            background-color:black!important;
        }

        .break-page {
            page-break-after: always;
        }

        .cek-break-page {
            page-break-inside:avoid;
            page-break-after:auto
        }
        
    }
    @media only screen and (max-width: 1265px) {
        .block-table {
            display: block !important;
        }
    }
    body {
        background-color: #f0f0f0;
    }
    #printable {
        padding:10px;
    }
    #non-printable {
        height: auto;
        padding: 15px;
        background-color: #2e3035;
        color:#888;
        margin: -10px -10px 0 -10px;
    }
    .block-table {
        display: table-cell;
        vertical-align: top;
        width: auto;
        padding: 20px;
    }
    .block-table-in {
        display: table-cell;
        vertical-align: top;
        width: auto;
    }
    .print-label {
        border: 1px solid #000!important;
        background-color: #fff;
    }
    #printable td.label {
        padding-top: 20px;
        padding-left: 20px;
    }
    #printable td{
        padding-right: 20px;
        padding-left: 20px;
    }
    .bagian-diprint {
        border:1px solid black;
    }
    .label {
        padding:0px;
    }
    .list-produk {
        list-style: none;
        margin-left: 0;
        padding-left: 0;
    }
    .expedisi-box {
        text-align: left;
        border: 1px solid #000;
        margin: 5px 0;
        font-weight: 700;
        padding: 10px 15px;
        font-size: 14px;
        color:black;
    }
    .resi-box {
        text-align: left;
        border: 1px solid #000;
        margin: 5px 0 15px;
        font-weight: 700;
        padding: 10px 15px;
        font-size: 14px;
        color:black;
    }
    td.ship-v2_from {
        width: 20px;
        vertical-align: top;
        padding-right: 0!important;
        border-bottom:1px solid black;
        padding: 1rem 0;
    }
    td.ship-v2_from-nama {
        vertical-align: top;
        border-bottom:1px solid black;
        padding: 1rem 0;
    }
    td.ship-v2_expedisi {
        text-align:center;
        border-bottom:1px solid black;
        border-left:1px solid black;
    }
    td.ship-v2_to {
        padding: 1rem 0;
        border-bottom:1px solid black;
        width: 20px;
        vertical-align: top;
        padding-right: 0!important;
    }
    td.ship-v2_to-ket {
        padding: 1rem 0;
        border-bottom:1px solid black;
    }
    td.ship-v2_to-ket span {
        text-transform:uppercase;
        letter-spacing:1px;
        color:black;
    }
    td.ship-v2_to b {
        padding-bottom:.25rem;
        line-height:1.4;
        margin-bottom:20px;
    }
    td.ship-v2_order {
        padding: 1rem 0;
    }
    td.ship-v2_order p {
        color:black;
    }
    td.ship-v2_order .total {
        margin-top:2rem!important;
        color:black;
    }
    td.ship-v2_jumlah-produk {
        text-align:right;
        white-space:nowrap;
        padding-left:10px;
    }
    td.ship-a6_jumlah-produk {
        text-align:right;
        white-space:nowrap;
        padding-left:10px;
    }
    td.ship-v2_admin {
        color:black;
        width: 20px;
        vertical-align: top;
        padding-right: 0!important;
        border-top:1px solid black;
        padding: 1rem 0;
    }
    .setiap-ship-v2{
        float:left;
        width:50%;
        padding-right:2mm;
        padding-left:2mm;
    }
    .setiap-ship-a6{
        float:left;
        width:105mm;
        padding-right:2mm;
        padding-left:2mm;
        color:black;
    }
    .setiap-ship-a6 table{
        height:140mm;
    }
    td.ship-a6_logo{
        border-left: 0;
        border-right: 1px solid #222;
        border-bottom: 1px solid #222;
        width: 60px;
    }
    td.ship-a6_kurir{
        border-bottom: 1px solid #222;
        padding: 1rem 0;
        vertical-align:middle;
    }
    td.ship-a6_berat{
        text-align:center;
        border-bottom: 1px solid #222;
        border-left: 1px solid #222;
    }
    td.ship-a6_berat .weight{
        font-size: 1.7rem;
    }
    .bb{
        border-bottom: 1px solid #222;
    }
    td.ship-a6_paket{
        height: 200px;
        max-height: 200px;
        overflow: hidden;
    }
    td.ship-a6_admin{
        border-top: 1px solid #222;
    }
    .invoice-tr-black {
        border: 1px solid #333;
        margin-bottom: 6px;
        background: #333;
        line-height: 1em;
        font-size: 12px;
        color: #fff;
    }
    .invoice-tr-list-harga {
        line-height: 1.55em;
        font-size: 12px;
    }
    .invoice-thermal-88mm {    
        width: 88mm;
        max-width: 88mm;
        font-family: Inconsolata,monospace;
        text-transform: uppercase;
        padding: 10px;
        color: #000!important;
        font-size: 10px!important;
    }
    .invoice-thermal-88mm hr{   
        border: .5px dashed;
    }
    .invoice-thermal-88mm .toko{   
        padding: 0;
        margin: .5em 0 0;
        font-size: 1rem!important;
    }
    </style>
</head>
<body onAfterPrint="afterPrint()">
    <div id='non-printable'>
        <div class='block-table'>
            <a href='{{ route("b.order-index") }}' class='btn btn-dark'><i class='fa fa-arrow-left'></i> Kembali ke Order</a> 
        </div>
        <div class='block-table'>
            <div style='display:inline-block;'>
                <p style="padding: 0 0 5px; margin: 0;"><b>CETAK :</b></p>
                <input type="radio" class='iCheck' name="print" id="print-ship" value="ship" checked="checked">
                <label for="print-ship">Shipping Label</label>
                <br>
                <input type="radio" class='iCheck' name="print" id="print-ship-v2" value="ship-v2">
                <label for="print-ship-v2">Shipping Label v2</label>
                <br>
                <input type="radio" class='iCheck' name="print" id="print-ship-a6" value="ship-a6">
                <label for="print-ship-a6">Shipping Label (A6)</label>
                <br>
                <input type="radio" class='iCheck' name="print" id="print-invoice" value="invoice">
                <label for="print-invoice">Invoice</label>
                <br>
                <input type="radio" class='iCheck' name="print" id="print-invoice-thermal-88mm" value="invoice-thermal-88mm">
                <label for="print-invoice-thermal-88mm">Invoice (Thermal 80mm)</label>
            </div>
        </div>
        <div class='block-table'>
            <form method="post" action="#" id='pengaturanForm'>
				<div id="bagian-ship">
					<p style="padding: 0 0 5px; margin: 0;"><b>PENGATURAN:</b></p>
                    <div class='block-table-in'>
                        <div>
                            <input type="checkbox" class='iCheck' id="print-ship_detail-order" name="print-ship_detail-order" @if(is_null($print) || isset($print->ship->detail_order)) checked @endif>
                            <label for='print-ship_detail-order'>Detail Order</label>
                        </div>
                        <div>
                            <input type="checkbox" class='iCheck' id="print-ship_logo-toko" name="print-ship_logo-toko" @if(is_null($print) || isset($print->ship->logo_toko)) checked @endif>
                            <label for='print-ship_logo-toko'>Logo Toko</label>
                        </div>
                        <div>
                            <input type="checkbox" class='iCheck' id="print-ship_info-toko" name="print-ship_info-toko" @if(is_null($print) || isset($print->ship->info_toko)) checked @endif>
                            <label for='print-ship_info-toko'>Info Toko</label>
                        </div>
                        <div>
                            <input type="checkbox" class='iCheck' id="print-ship_kurir" name="print-ship_kurir" @if(is_null($print) || isset($print->ship->kurir)) checked @endif>
                            <label for='print-ship_kurir'>Expedisi/Kurir</label>
                        </div>
                        <div style='margin-bottom:-127px' class='mt-10' id='area-print-ship_knob-no-order'>
                            @if(is_null($print) || isset($print->ship->no_order))
                                <label for='print-ship_knob-no-order' style='padding: 0 0 5px; margin: 0;'>Font Size No Order:</label><br>
                                <input type='text' class='knob-no-order' id='print-ship_knob-no-order' value='@if(is_null($print)) 14 @elseif(isset($print->ship->knob_no_order)) {{$print->ship->knob_no_order}}  @else 14 @endif' name='print-ship_knob-no-order'>
                            @endif
                        </div>
                    </div>
                    <div class='block-table-in'>
                        <div class='ml-20'>
                            <input type="checkbox" class='iCheck' id="print-ship_biaya-kurir" name="print-ship_biaya-kurir" @if(is_null($print) || isset($print->ship->biaya_kurir)) checked @endif>
                            <label for='print-ship_biaya-kurir'>Biaya Expedisi/Kurir</label>
                        </div>
                        <div class='ml-20'>
                            <input type="checkbox" class='iCheck' id="print-ship_no-order" name="print-ship_no-order" @if(is_null($print) || isset($print->ship->no_order)) checked @endif>
                            <label for='print-ship_no-order'>No. Order</label>
                        </div>
                        <div class='ml-20'>
                            <input type="checkbox" class='iCheck' id="print-ship_fragile-sign" name="print-ship_fragile-sign" @if(is_null($print) || isset($print->ship->fragile_sign)) checked @endif>
                            <label for='print-ship_fragile-sign'>Fragile Sign</label>
                        </div>
                        <div class='ml-20'>
                            <input type="checkbox" class='iCheck' id="print-ship_total-produk" name="print-ship_total-produk" @if(is_null($print) || isset($print->ship->total_produk)) checked @endif>
                            <label for='print-ship_total-produk'>Total Produk</label>
                        </div>
                    </div>
                    <div class='block-table-in'>
                        <div class='ml-20'>
                            <input type="checkbox" class='iCheck' id="print-ship_tgl-order" name="print-ship_tgl-order" @if(is_null($print) || isset($print->ship->tgl_order)) checked @endif>
                            <label for='print-ship_tgl-order'>Tanggal Order</label>
                        </div>
                        <div class='ml-20'>
                            <input type="checkbox" class='iCheck' id="print-ship_list-produk" name="print-ship_list-produk" @if(is_null($print) || isset($print->ship->list_produk)) checked @endif>
                            <label for='print-ship_list-produk'>List Produk</label>
                        </div>
                        <div class='ml-20'>
                            <input type="checkbox" class='iCheck' id="print-ship_no-resi" name="print-ship_no-resi" @if(is_null($print) || isset($print->ship->no_resi)) checked @endif>
                            <label for='print-ship_no-resi'>No. Resi</label>
                        </div>
                        <div class='ml-20'>
                            <input type="checkbox" class='iCheck' id="print-ship_nama-admin" name="print-ship_nama-admin" @if(is_null($print) || isset($print->ship->nama_admin)) checked @endif>
                            <label for='print-ship_nama-admin'>Nama Admin</label>
                        </div>
                    </div>
				</div>

				<div id="bagian-ship-v2" style='display:none'>
					<p style="padding: 0 0 5px; margin: 0;"><b>PENGATURAN:</b></p>
                    <div class='block-table-in'>
                        <div>
                            <input type="checkbox" class='iCheck' id="print-ship-v2_detail-order" name="print-ship-v2_detail-order" @if(is_null($print) || isset($print->ship_v2->detail_order)) checked @endif>
                            <label for='print-ship-v2_detail-order'>Detail Order</label>
                        </div>
                        <div>
                            <input type="checkbox" class='iCheck' id="print-ship-v2_kurir" name="print-ship-v2_kurir" @if(is_null($print) || isset($print->ship_v2->kurir)) checked @endif>
                            <label for='print-ship-v2_kurir'>Expedisi/Kurir</label>
                        </div>
                        <div>
                            <input type="checkbox" class='iCheck' id="print-ship-v2_biaya-kurir" name="print-ship-v2_biaya-kurir" @if(is_null($print) || isset($print->ship_v2->biaya_kurir)) checked @endif>
                            <label for='print-ship-v2_biaya-kurir'>Biaya Expedisi/Kurir</label>
                        </div>
                        <div>
                            <input type="checkbox" class='iCheck' id="print-ship-v2_no-order" name="print-ship-v2_no-order" @if(is_null($print) || isset($print->ship_v2->no_order)) checked @endif>
                            <label for='print-ship-v2_no-order'>No. Order</label>
                        </div>
                        <div style='margin-bottom:-127px' class='mt-10' id='area-print-ship-v2_knob-no-order'>
                            @if(is_null($print) || isset($print->ship_v2->no_order))
                                <label for='print-ship-v2_knob-no-order' style='padding: 0 0 5px; margin: 0;'>Font Size No Order:</label><br>
                                <input type='text' class='knob-no-order' id='print-ship-v2_knob-no-order' value='@if(is_null($print)) 14 @elseif(isset($print->ship_v2->knob_no_order)) {{$print->ship_v2->knob_no_order}}  @else 14 @endif' name='print-ship-v2_knob-no-order'>
                            @endif
                        </div>
                    </div>
                    <div class='block-table-in'>
                        <div class='ml-20'>
                            <input type="checkbox" class='iCheck' id="print-ship-v2_tgl-order" name="print-ship-v2_tgl-order" @if(is_null($print) || isset($print->ship_v2->tgl_order)) checked @endif>
                            <label for='print-ship-v2_tgl-order'>Tanggal Order</label>
                        </div>
                        <div class='ml-20'>
                            <input type="checkbox" class='iCheck' id="print-ship-v2_list-produk" name="print-ship-v2_list-produk" @if(is_null($print) || isset($print->ship_v2->list_produk)) checked @endif>
                            <label for='print-ship-v2_list-produk'>List Produk</label>
                        </div>
                        <div class='ml-20'>
                            <input type="checkbox" class='iCheck' id="print-ship-v2_nama-admin" name="print-ship-v2_nama-admin" @if(is_null($print) || isset($print->ship_v2->nama_admin)) checked @endif>
                            <label for='print-ship-v2_nama-admin'>Nama Admin</label>
                        </div>
                        <div class='ml-20'>
                            <input type="checkbox" class='iCheck' id="print-ship-v2_total-produk" name="print-ship-v2_total-produk" @if(is_null($print) || isset($print->ship_v2->total_produk)) checked @endif>
                            <label for='print-ship-v2_total-produk'>Total Produk</label>
                        </div>
                    </div>
				</div>

				<div id="bagian-ship-a6" style='display:none'>
					<p style="padding: 0 0 5px; margin: 0;"><b>PENGATURAN:</b></p>
                    <div class='block-table-in'>
                        <div>
                            <input type="checkbox" class='iCheck' id="print-ship-a6_nama-admin" name="print-ship-a6_nama-admin" @if(is_null($print) || isset($print->ship_a6->nama_admin)) checked @endif>
                            <label for='print-ship-a6_nama-admin'>Nama Admin</label>
                        </div>
                        <div>
                            <input type="checkbox" class='iCheck' id="print-ship-a6_biaya-kurir" name="print-ship-a6_biaya-kurir" @if(is_null($print) || isset($print->ship_a6->biaya_kurir)) checked @endif>
                            <label for='print-ship-a6_biaya-kurir'>Biaya Expedisi/Kurir</label>
                        </div>
                        <div>
                            <input type="checkbox" class='iCheck' id="print-ship-a6_detail-produk" name="print-ship-a6_detail-produk" @if(is_null($print) || isset($print->ship_a6->detail_produk)) checked @endif>
                            <label for='print-ship-a6_detail-produk'>Detail Produk</label>
                        </div>
                        <div>
                            <input type="checkbox" class='iCheck' id="print-ship-a6_total-produk" name="print-ship-a6_total-produk" @if(is_null($print) || isset($print->ship_a6->total_produk)) checked @endif>
                            <label for='print-ship-a6_total-produk'>Total Produk</label>
                        </div>
                    </div>
				</div>

				<div id="bagian-invoice" style='display:none'>
					<p style="padding: 0 0 5px; margin: 0;"><b>PENGATURAN:</b></p>
                    <div class='block-table-in'>
                        <div>
                            <input type="checkbox" class='iCheck' id="print-invoice_no-rek" name="print-invoice_no-rek" @if(is_null($print) || isset($print->invoice->no_rek)) checked @endif>
                            <label for='print-invoice_no-rek'>No. Rekening</label>
                        </div>
                        <div>
                            <input type="checkbox" class='iCheck' id="print-invoice_sku" name="print-invoice_sku" @if(is_null($print) || isset($print->invoice->sku)) checked @endif>
                            <label for='print-invoice_sku'>SKU</label>
                        </div>
                        <div>
                            <input type="checkbox" class='iCheck' id="print-invoice_nama-admin" name="print-invoice_nama-admin" @if(is_null($print) || isset($print->invoice->nama_admin)) checked @endif>
                            <label for='print-invoice_nama-admin'>Nama Admin</label>
                        </div>
                        <div>
                            <input type="checkbox" class='iCheck' id="print-invoice_total-produk" name="print-invoice_total-produk" @if(is_null($print) || isset($print->invoice->total_produk)) checked @endif>
                            <label for='print-invoice_total-produk'>Total Produk</label>
                        </div>
                    </div>
				</div>

				<div id="bagian-invoice-thermal-88mm" style='display:none'>
					<p style="padding: 0 0 5px; margin: 0;"><b>PENGATURAN:</b></p>
                    <div class='block-table-in'>
                        <div>
                            <input type="checkbox" class='iCheck' id="print-invoice-thermal-88mm_no-rek" name="print-invoice-thermal-88mm_no-rek" @if(is_null($print) || isset($print->invoice_thermal_88mm->no_rek)) checked @endif>
                            <label for='print-invoice-thermal-88mm_no-rek'>No. Rekening</label>
                        </div>
                        <div>
                            <input type="checkbox" class='iCheck' id="print-invoice-thermal-88mm_kurir" name="print-invoice-thermal-88mm_kurir" @if(is_null($print) || isset($print->invoice_thermal_88mm->kurir)) checked @endif>
                            <label for='print-invoice-thermal-88mm_kurir'>Expedisi/Kurir</label>
                        </div>
                        <div>
                            <input type="checkbox" class='iCheck' id="print-invoice-thermal-88mm_nama-admin" name="print-invoice-thermal-88mm_nama-admin" @if(is_null($print) || isset($print->invoice_thermal_88mm->nama_admin)) checked @endif>
                            <label for='print-invoice-thermal-88mm_nama-admin'>Nama Admin</label>
                        </div>
                        <div>
                            <input type="checkbox" class='iCheck' id="print-invoice-thermal-88mm_detail-invoice" name="print-invoice-thermal-88mm_detail-invoice" @if(is_null($print) || isset($print->invoice_thermal_88mm->detail_invoice)) checked @endif>
                            <label for='print-invoice-thermal-88mm_detail-invoice'>Detail Invoice</label>
                        </div>
                    </div>
                    <div class='block-table-in'>
                        <div class='ml-20'>
                            <input type="checkbox" class='iCheck' id="print-invoice-thermal-88mm_nama-toko" name="print-invoice-thermal-88mm_nama-toko" @if(is_null($print) || isset($print->invoice_thermal_88mm->nama_toko)) checked @endif>
                            <label for='print-invoice-thermal-88mm_nama-toko'>Nama Toko</label>
                        </div>
                        <div class='ml-20'>
                            <input type="checkbox" class='iCheck' id="print-invoice-thermal-88mm_ket-toko" name="print-invoice-thermal-88mm_ket-toko" @if(is_null($print) || isset($print->invoice_thermal_88mm->ket_toko)) checked @endif>
                            <label for='print-invoice-thermal-88mm_ket-toko'>Keterangan Toko</label>
                        </div>
                        <div class='ml-20'>
                            <input type="checkbox" class='iCheck' id="print-invoice-thermal-88mm_alamat-toko" name="print-invoice-thermal-88mm_alamat-toko" @if(is_null($print) || isset($print->invoice_thermal_88mm->alamat_toko)) checked @endif>
                            <label for='print-invoice-thermal-88mm_alamat-toko'>Alamat Toko</label>
                        </div>
                        <div class='ml-20'>
                            <input type="checkbox" class='iCheck' id="print-invoice-thermal-88mm_alamat-pengirim" name="print-invoice-thermal-88mm_alamat-pengirim" @if(is_null($print) || isset($print->invoice_thermal_88mm->alamat_pengirim)) checked @endif>
                            <label for='print-invoice-thermal-88mm_alamat-pengirim'>Alamat Pengirim</label>
                        </div>
                    </div>
                    <div class='block-table-in'>
                        <div class='ml-20'>
                            <input type="checkbox" class='iCheck' id="print-invoice-thermal-88mm_total-produk" name="print-invoice-thermal-88mm_total-produk" @if(is_null($print) || isset($print->invoice_thermal_88mm->total_produk)) checked @endif>
                            <label for='print-invoice-thermal-88mm_total-produk'>Total Produk</label>
                        </div>
                    </div>
				</div>

			</form>
        </div>
        <div class='block-table'>
            <button class='btn btn-dark' onClick='window.print()'><i class='fa fa-print'></i> Print</button> 
            <button class='btn btn-dark ml-15' id='btnSimpan'><i class='fa fa-check'></i> Simpan Pengaturan</button> 
        </div>
    </div>
    <div id='printable'>
        <div id='printable-ship'>
            @foreach(App\Http\Controllers\PusatController::genArray($data) as $d)
                @php
                    $produk_data = json_decode($d['order']->produk);
                @endphp
                <table width="100%" border="0" cellspacing="0" class="print-label mb-10 cek-break-page" data-id='{{ $d["order"]->id_order }}'>
                    <tbody>
                        <tr>
                            <td width="20%" rowspan="3" class="text-center div-print-ship_logo-toko" style='@if(isset($print) && !isset($print->ship->logo_toko)) display:none; @endif'>
                                <img class="" src="{{ $d['toko']->foto }}" width="120">
                                <div class='div-print-ship_info-toko' style='@if(isset($print) && !isset($print->ship->info_toko)) display:none; @endif'>
                                    <h4 style="margin:10px 0 5px;">{{ strtoupper($d['toko']->nama_toko) }}</h4>
                                    <p>{{ $d['toko']->deskripsi_toko }}</p>
                                </div>
                            </td>
                            <td class="label">
                                <h4 class="mt-0 div-print-ship_no-order" style="font-size: @if(is_null($print)) 14px; @elseif(isset($print->ship->knob_no_order)) {{$print->ship->knob_no_order}}px;  @else 14px; @endif margin-bottom: 8px;@if(isset($print) && !isset($print->ship->no_order)) display:none; @endif" id='no-order_print_ship'>Order #{{ $d['order']->id_order }}</h4>
                                <b style='color:black'>Kepada:</b>
                            </td>
                            <td class="label" valign='bottom'>
                                <b style='color:black;@if(isset($print) && !isset($print->ship->detail_order)) display:none; @endif' class='div-print-ship_detail-order'>
                                    <span style="font-size: 14px;">Order</span>
                                    <span class='div-print-ship_tgl-order' style='@if(isset($print) && !isset($print->ship->tgl_order)) display:none; @endif'>({{ $d['order']->tanggal_order }})</span>
                                </b>
                            </td>
                            <td width="30%" rowspan="3" style="border-left: 1px solid;@if(isset($print) && !isset($print->ship->fragile_sign)) display:none; @endif" class='text-center div-print-ship_fragile-sign'>
                                <img src="{{ asset('fragile-svg.svg') }}" alt="">
                                <p>JANGAN DIBANTING!</p>
                            </td>
                        </tr>
                        <tr>
                            <td width="40%" valign="top">
                                <p class="m-0">{{ ucwords(strtolower($d['tujuan']->name)) }}</p>
                                <p class="mt-0 mb-10">
                                    {{ $d['tujuan']->alamat }}<br>
                                    Kec. {{ $d['tujuan']->kecamatan }},  {{ $d['tujuan']->kabupaten }}<br>
                                    {{ $d['tujuan']->provinsi }} - {{ $d['tujuan']->kode_pos }}<br>
                                    @if(isset($d['tujuan']->email))
                                        <b>Email:</b> {{ $d['tujuan']->email }}
                                    @endif
                                    @if(isset($d['tujuan']->no_telp))
                                        <br><b>No Telp:</b> {{ $d['tujuan']->no_telp }}
                                    @endif
                                </p>
                            </td>
                            <td width="30%" valign="top">
                                <span class='div-print-ship_detail-order' style='@if(isset($print) && !isset($print->ship->detail_order)) display:none; @endif'>
                                    <ul style="font-size: 12px;" class="list-produk div-print-ship_list-produk">
                                        @foreach(App\Http\Controllers\PusatController::genArray($produk_data->list) as $lp)
                                            <li class="d-flex justify-content-between">
                                                <div>
                                                    - &nbsp;{{ ucwords(strtolower($lp->rawData->nama_produk)) }}
                                                    @php
                                                        if((isset($lp->rawData->ukuran) && $lp->rawData->ukuran !== '') && (isset($lp->rawData->warna) && $lp->rawData->warna !== '')){
                                                            echo " (".$lp->rawData->ukuran." ".$lp->rawData->warna.") ";
                                                        } else if((isset($lp->rawData->ukuran) && $lp->rawData->ukuran !== '') && (is_null($lp->rawData->warna) || $lp->rawData->warna == '')){
                                                            echo " (".$lp->rawData->ukuran.") ";
                                                        } else if((is_null($lp->rawData->ukuran) || $lp->rawData->ukuran == '') && (isset($lp->rawData->warna) && $lp->rawData->warna !== '')){
                                                            echo " (".$lp->rawData->warna.") ";
                                                        }
                                                    @endphp
                                                </div>
                                                <div class="text-right" style="padding-left: 10px;white-space: nowrap;">x {{ $lp->jumlah }}</div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="d-flex justify-content-between">
                                        <span class="label div-print-ship_total-produk" style='@if(isset($print) && !isset($print->ship->total_produk)) display:none; @endif'>
                                            <b style='color:black'>Total Produk:</b>
                                        </span>
                                        <span class="label div-print-ship_total-produk" style='@if(isset($print) && !isset($print->ship->total_produk)) display:none; @endif'>
                                            <b style='color:black'>{{ $d['order']->total_produk }}</b>
                                        </span>
                                    </div>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="label mb-0">
                                    <b style='color:black'>Pengirim:</b> 
                                </p>
                                <p class="mt-0 mb-10">
                                    {{ ucwords(strtolower($d['toko']->nama_toko)) }}<br>{{ $d['toko']->no_telp_toko }}		
                                </p>
                                <span class='div-print-ship_nama-admin' style='@if(isset($print) && !isset($print->ship->nama_admin)) display:none; @endif'>
                                    <p class="label mb-0">
                                        <b style='color:black'>Admin:</b>
                                    </p>
                                    <p class="pb-10 mt-0">
                                        {{ ucwords(strtolower($d['order']->nama_admin)) }}
                                    </p>
                                </span>
                            </td>
                            <td>
                                <div class="expedisi-box div-print-ship_kurir" style='@if(isset($print) && !isset($print->ship->kurir)) display:none; @endif'>
                                    @php
                                        $kurir = json_decode($d['order']->kurir);
                                        if($kurir->tipe == 'toko'){
                                            echo 'Ambil di Toko';
                                        } else if($kurir->tipe == 'kurir'){
                                            echo ucwords(strtolower($kurir->data->nama));
                                        } else if($kurir->tipe == 'expedisi'){
                                            echo strtoupper(explode('|', $kurir->data)[0]);
                                        }
                                    @endphp
                                    <span>({{ App\Http\Controllers\PusatController::formatUang($produk_data->totalBerat) }} Gram)</span>
                                    <div style="margin-top: 4px;" class='div-print-ship_biaya-kurir' style='@if(isset($print) && !isset($print->ship->biaya_kurir)) display:none; @endif'>
                                        Biaya Kirim:&nbsp;
                                        @php
                                            if($kurir->tipe == 'toko'){
                                                echo 'Rp 0';
                                            } else if($kurir->tipe == 'kurir'){
                                                echo App\Http\Controllers\PusatController::formatUang($kurir->data->harga, true);
                                            } else if($kurir->tipe == 'expedisi'){
                                                echo App\Http\Controllers\PusatController::formatUang(explode('|', $kurir->data)[2], true);
                                            }
                                        @endphp
                                    </div>
                                </div>
                                <div class='resi-box div-print-ship_no-resi' style='@if(isset($print) && !isset($print->ship->no_resi)) display:none; @endif'>
                                    NO RESI : &nbsp;&nbsp;{{ $d['order']->resi }}	 	
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endforeach
        </div>
        <div id='printable-ship-v2' style='display:none;'>
            @foreach(App\Http\Controllers\PusatController::genArray($data) as $d)
                @php
                    $produk_data = json_decode($d['order']->produk);
                @endphp
                <div class='setiap-ship-v2 cek-break-page' data-id='{{ $d["order"]->id_order }}'>
                    <table width="100%" border="0" cellspacing="0" class='print-label mb-10'>
                        <tbody>
                            <tr>
                                <td class="ship-v2_from">
                                    <b style='color:black'>FROM:</b>
                                </td>
                                <td class="ship-v2_from-nama">
                                    {{ strtoupper($d['toko']->nama_toko) }} ({{ $d['toko']->no_telp_toko }})				
                                </td>
                                <td class="ship-v2_expedisi div-print-ship-v2_kurir" style='@if(isset($print) && !isset($print->ship_v2->kurir)) display:table-column; @endif'>
                                    <b style='color:black'>
                                        @php
                                            $kurir = json_decode($d['order']->kurir);
                                            if($kurir->tipe == 'toko'){
                                                echo 'Ambil di Toko';
                                            } else if($kurir->tipe == 'kurir'){
                                                echo ucwords(strtolower($kurir->data->nama));
                                            } else if($kurir->tipe == 'expedisi'){
                                                echo strtoupper(explode('|', $kurir->data)[0]);
                                            }
                                        @endphp
                                    </b>
                                    <b style='color:black;@if(isset($print) && !isset($print->ship_v2->biaya_kurir)) display:none; @endif' class='div-print-ship-v2_biaya-kurir'>
                                        &nbsp;-&nbsp;
                                        @php
                                            if($kurir->tipe == 'toko'){
                                                echo 'Rp 0';
                                            } else if($kurir->tipe == 'kurir'){
                                                echo App\Http\Controllers\PusatController::formatUang($kurir->data->harga, true);
                                            } else if($kurir->tipe == 'expedisi'){
                                                echo App\Http\Controllers\PusatController::formatUang(explode('|', $kurir->data)[2], true);
                                            }
                                        @endphp
                                    </b>
                                    <br>
                                    <span>({{ App\Http\Controllers\PusatController::formatUang($produk_data->totalBerat) }} Gram)</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="ship-v2_to">
                                    <b style='color:black'>TO:</b>
                                </td>
                                <td class="ship-v2_to-ket" colspan="2">
                                    <span><b>{{ ucwords(strtolower($d['tujuan']->name)) }}</b></span><br>
                                    {{ $d['tujuan']->alamat }}<br>
                                    Kec. {{ $d['tujuan']->kecamatan }},  {{ $d['tujuan']->kabupaten }}<br>
                                    {{ $d['tujuan']->provinsi }} - {{ $d['tujuan']->kode_pos }}<br>
                                    @if(isset($d['tujuan']->email))
                                        <b>Email:</b> {{ $d['tujuan']->email }}
                                    @endif
                                    @if(isset($d['tujuan']->no_telp))
                                        <br><b>No Telp:</b> {{ $d['tujuan']->no_telp }}
                                    @endif
                                </td>
                            </tr>
                            <tr class='div-print-ship-v2_detail-order' style='@if(isset($print) && !isset($print->ship_v2->detail_order)) display:none; @endif'>
                                <td class="ship-v2_order" colspan="3">
                                    <p>
                                        <b style="font-size: @if(is_null($print)) 14px; @elseif(isset($print->ship_v2->knob_no_order)) {{$print->ship_v2->knob_no_order}}px;  @else 14px; @endif">
                                            <span id='no-order_print_ship-v2'>Order <span class='div-print-ship-v2_no-order' style='@if(isset($print) && !isset($print->ship_v2->no_order)) display:none; @endif'>#{{ $d['order']->id_order }}</span></span>
                                        </b>
                                        <b class='div-print-ship-v2_tgl-order' style='@if(isset($print) && !isset($print->ship_v2->tgl_order)) display:none; @endif'>({{ $d['order']->tanggal_order }})</b>
                                    </p>
                                    <ul class="list-produk m-0 div-print-ship-v2_list-produk" style='@if(isset($print) && !isset($print->ship_v2->list_produk)) display:none; @endif'>
                                        @foreach(App\Http\Controllers\PusatController::genArray($produk_data->list) as $lp)
                                            <li class="d-flex justify-content-between">
                                                <div>
                                                    - &nbsp;{{ ucwords(strtolower($lp->rawData->nama_produk)) }}
                                                    @php
                                                        if((isset($lp->rawData->ukuran) && $lp->rawData->ukuran !== '') && (isset($lp->rawData->warna) && $lp->rawData->warna !== '')){
                                                            echo " (".$lp->rawData->ukuran." ".$lp->rawData->warna.") ";
                                                        } else if((isset($lp->rawData->ukuran) && $lp->rawData->ukuran !== '') && (is_null($lp->rawData->warna) || $lp->rawData->warna == '')){
                                                            echo " (".$lp->rawData->ukuran.") ";
                                                        } else if((is_null($lp->rawData->ukuran) || $lp->rawData->ukuran == '') && (isset($lp->rawData->warna) && $lp->rawData->warna !== '')){
                                                            echo " (".$lp->rawData->warna.") ";
                                                        }
                                                    @endphp
                                                </div>
                                                <div class="ship-v2_jumlah-produk">x {{ $lp->jumlah }}</div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class='total d-flex justify-content-between'>
                                        <b class='div-print-ship-v2_total-produk' style='@if(isset($print) && !isset($print->ship_v2->total_produk)) display:none; @endif'>TOTAL PRODUK</b>
                                        <b class='div-print-ship-v2_total-produk' style='@if(isset($print) && !isset($print->ship_v2->total_produk)) display:none; @endif'>{{ $d['order']->total_produk }}</b>
                                    </div>
                                </td>
                            </tr>
                            <tr class='div-print-ship-v2_nama-admin' style='@if(isset($print) && !isset($print->ship_v2->nama_admin)) display:none; @endif'>
                                <td class="ship-v2_admin">
                                    <strong>ADMIN:</strong>
                                </td>
                                <td class="ship-v2_admin-nama" colspan="2">
                                    {{ ucwords(strtolower($d['order']->nama_admin)) }}		
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
        <div id='printable-ship-a6' style='display:none;'>
            @foreach(App\Http\Controllers\PusatController::genArray($data) as $d)
            @php
                $produk_data = json_decode($d['order']->produk);
            @endphp
            <div class='setiap-ship-a6' data-id='{{ $d["order"]->id_order }}'>
                <table width="100%" border="0" cellspacing="0" class="print-label mb-10">
                    <tbody>
                        <tr style="height: 90px">
                            <td class="ship-a6_logo" colspan="2">
                                <img src="{{ ucwords(strtolower($d['toko']->foto)) }}" alt="MANUAL" width="50px">
                            </td>
                            <td class="ship-a6_kurir" colspan="3" style='font-size:20px'>
                                <span>
                                    @php
                                        $kurir = json_decode($d['order']->kurir);
                                        if($kurir->tipe == 'toko'){
                                            echo 'Ambil di Toko';
                                        } else if($kurir->tipe == 'kurir'){
                                            echo ucwords(strtolower($kurir->data->nama));
                                        } else if($kurir->tipe == 'expedisi'){
                                            echo strtoupper(explode('|', $kurir->data)[0]);
                                        }
                                    @endphp
                                </span>
                            </td>
                            <td class="ship-a6_berat">
                                <span class="weight">
                                    {{ App\Http\Controllers\PusatController::formatUang($produk_data->totalBerat) }}
                                </span>Gram
                            </td>
                        </tr>
                        <tr>
                            <td class="bb" colspan="6">
                                <div>
                                    <span>PENGIRIM: </span>
                                    <span>{{ strtoupper($d['toko']->nama_toko) }} ({{ $d['toko']->no_telp_toko }})</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="bb" colspan="6">
                                <div>
                                    <span>KEPADA:</span>
                                    <span>
                                        {{ ucwords(strtolower($d['tujuan']->name)) }}
                                        @if(isset($d['tujuan']->no_telp))
                                            ({{ $d['tujuan']->no_telp }})
                                        @endif
                                    </span>
                                    <br>
                                    <br>
                                    <span>ALAMAT PENGIRIMAN:</span><br>
                                    {{ $d['tujuan']->alamat }}<br>
                                    Kec. {{ $d['tujuan']->kecamatan }},  {{ $d['tujuan']->kabupaten }}<br>
                                    {{ $d['tujuan']->provinsi }} - {{ $d['tujuan']->kode_pos }}<br>
                                </div>
                            </td>
                        </tr>
                        <tr class='div-print-ship-a6_detail-produk' style='@if(isset($print) && !isset($print->ship_a6->detail_produk)) display:none; @endif'>
                            <td class="bb" colspan="6">
                                <div class='ship-a6_paket'>
                                    <span>ISI PAKET:</span>
                                    <ul class="list-produk m-0">
                                        @foreach(App\Http\Controllers\PusatController::genArray($produk_data->list) as $lp)
                                            <li class="d-flex justify-content-between">
                                                <div>
                                                    - &nbsp;{{ ucwords(strtolower($lp->rawData->nama_produk)) }}
                                                    @php
                                                        if((isset($lp->rawData->ukuran) && $lp->rawData->ukuran !== '') && (isset($lp->rawData->warna) && $lp->rawData->warna !== '')){
                                                            echo " (".$lp->rawData->ukuran." ".$lp->rawData->warna.") ";
                                                        } else if((isset($lp->rawData->ukuran) && $lp->rawData->ukuran !== '') && (is_null($lp->rawData->warna) || $lp->rawData->warna == '')){
                                                            echo " (".$lp->rawData->ukuran.") ";
                                                        } else if((is_null($lp->rawData->ukuran) || $lp->rawData->ukuran == '') && (isset($lp->rawData->warna) && $lp->rawData->warna !== '')){
                                                            echo " (".$lp->rawData->warna.") ";
                                                        }
                                                    @endphp
                                                </div>
                                                <div class="ship-a6_jumlah-produk">
                                                    x {{ $lp->jumlah }}							
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="d-flex justify-content-between mt-3">
                                        <span class='div-print-ship-a6_total-produk' style='@if(isset($print) && !isset($print->ship_a6->total_produk)) display:none; @endif'>TOTAL PRODUK:</span>
                                        <span class='div-print-ship-a6_total-produk' style='@if(isset($print) && !isset($print->ship_a6->total_produk)) display:none; @endif'>{{ $d['order']->total_produk }}</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="pb-0" colspan="5">
                                <div class="d-flex">
                                    <div class="pr-3" style="width: 85px">
                                        <span class='div-print-ship-a6_biaya-kurir' style='@if(isset($print) && !isset($print->ship_a6->biaya_kurir)) display:none; @endif'>Biaya Kirim</span>
                                    </div>
                                    <div>
                                        <span class='div-print-ship-a6_biaya-kurir' style='@if(isset($print) && !isset($print->ship_a6->biaya_kurir)) display:none; @endif'>:</span>
                                        <span class='div-print-ship-a6_biaya-kurir' style='@if(isset($print) && !isset($print->ship_a6->biaya_kurir)) display:none; @endif'>
                                            @php
                                                if($kurir->tipe == 'toko'){
                                                    echo 'Rp 0';
                                                } else if($kurir->tipe == 'kurir'){
                                                    echo App\Http\Controllers\PusatController::formatUang($kurir->data->harga, true);
                                                } else if($kurir->tipe == 'expedisi'){
                                                    echo App\Http\Controllers\PusatController::formatUang(explode('|', $kurir->data)[2], true);
                                                }
                                            @endphp
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="pr-3" style="width: 85px">
                                        <span>Total Biaya</span>
                                    </div>
                                    <div>
                                        <span>:</span>
                                        <span>{{ App\Http\Controllers\PusatController::formatUang($d['order']->total_harga, true) }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-right">
				                <h4 class="m-0">Order #{{ $d['order']->id_order }}</h4>
			                </td>
                        </tr>
                        <tr class='div-print-ship-a6_nama-admin' style='@if(isset($print) && !isset($print->ship_a6->nama_admin)) display:none; @endif'>
                            <td class="ship-a6_admin" colspan="6">
                                <div class="d-flex">
                                    <div class="pr-3" style="width: 85px">Admin</div>
                                    <div>: {{ ucwords(strtolower($d['order']->nama_admin)) }}</div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class='break-page'></div>
            @endforeach
        </div>
        <div id='printable-invoice' style='display:none;'>
            @foreach(App\Http\Controllers\PusatController::genArray($data) as $d)
                @php
                    $totalBerat = $totalJumlah = $totalHarga = 0;
                    $produk_data = json_decode($d['order']->produk);
                @endphp
                <table width="100%" border="0" cellspacing="0" class="print-label mb-10 cek-break-page" font-size="12px;" style="display: table;padding:0;color:black;" data-id='{{ $d["order"]->id_order }}'>
                    <tbody>
                        <tr style="margin: 0;padding: 20px;">
                            <td style="margin: 0;" width="10%">
                                <img class="img-logo" id='foto-invoice' src="{{ $d['toko']->foto }}" style="width: 94px">
                            </td>
                            <td colspan="3" style="margin: 0;vertical-align: top;">
                                <h3 style="padding:0; margin: 0.5em 0 0;">{{ strtoupper($d['toko']->nama_toko) }}</h3>
                                <p class="mt-0">{{ $d['toko']->deskripsi_toko }}</p>
                            </td>
                            <td colspan="2" style="margin: 0;vertical-align: top;">
                                <h5 style="padding:0; margin:0.5em 0;">
                                    <b>Tanggal:</b>
                                    <span style="clear:both;display:block;font-weight: normal;">{{ $d['order']->tanggal_order }}</span>
                                </h5>
                                <h5 style="padding:0; margin:0.5em 0;">
                                    <b>Nomor Invoice:</b>
                                    @php
                                        $tanggalToInv = date('Y.m.d', strtotime($d['order']->tanggal_order));
                                    @endphp
                                    <span style="clear:both;display:block;font-weight: normal;">INV.{{$tanggalToInv}}.{{$d["order"]->id_order}}</span>
                                </h5>
                                <h5 style="padding:0; margin:0.5em 0;@if(isset($print) && !isset($print->invoice->nama_admin)) display:none; @endif" class='div-print-invoice_nama-admin'>
                                    <b>Admin:</b>
                                    <span style="clear:both;display:block;font-weight: normal;">{{ ucwords(strtolower($d['order']->nama_admin)) }}</span>
                                </h5>
                            </td>
                        </tr>
                        <tr style="margin: 0; padding: 20px;">
                            <td colspan="4">
                                <p class="mb-0" style="line-height: 1em;margin: 0;padding: 20px 0 0;">
                                <b style='color:black;'>Kepada <span>{{ ucwords(strtolower($d['tujuan']->name)) }}</span></b>
                                </p>
                                <p class="mt-0" style="font-size: 12px;line-height: 2em;">Terima kasih telah berbelanja di 
                                {{ ucwords(strtolower($d['toko']->nama_toko)) }}. Berikut adalah rincian orderan Anda:
                                </p>
                            </td>
                            <td colspan="2">
                                @php
                                    if($d['tipe_bayar'] === 'belum'){
                                        echo '<b><span style="color: #F2353C;">BELUM BAYAR</span></b>';
                                    } else if($d['tipe_bayar'] === 'cicil'){
                                        echo '<b><span style="color: #EB6709;">CICIL</span> (Sudah Membayar '.App\Http\Controllers\PusatController::formatUang($d['sudah_bayar'], true).')</b>';
                                    } else if($d['tipe_bayar'] === 'lunas'){
                                        echo '<b><span style="color:  #05A85C;">LUNAS</span> ('.$d['terakhir_tgl_bayar'].')</b>';
                                    }
                                @endphp
                                
                            </td>
                        </tr>
                        <tr class='invoice-tr-black'>
                            <td colspan="2" style="padding: 10px 20px; width: 45%;">Nama Produk</td>
                            <td style="padding: 10px 20px; width: 10%;">Jumlah</td>
                            <td style="padding: 10px 20px; width: 15%;">Berat</td>
                            <td class="text-right" style="padding: 10px 20px; width: 15%;">Harga</td>
                            <td class="text-right" style="padding: 10px 20px; width: 15%;">Subtotal</td>
                        </tr>
                        @foreach(App\Http\Controllers\PusatController::genArray($produk_data->list) as $lp)
                            <tr class='invoice-tr-list-harga'>
                                <td colspan="2">
                                    {{ ucwords(strtolower($lp->rawData->nama_produk)) }}
                                    @php
                                        if((isset($lp->rawData->ukuran) && $lp->rawData->ukuran !== '') && (isset($lp->rawData->warna) && $lp->rawData->warna !== '')){
                                            echo " (".$lp->rawData->ukuran." ".$lp->rawData->warna.") ";
                                        } else if((isset($lp->rawData->ukuran) && $lp->rawData->ukuran !== '') && (is_null($lp->rawData->warna) || $lp->rawData->warna == '')){
                                            echo " (".$lp->rawData->ukuran.") ";
                                        } else if((is_null($lp->rawData->ukuran) || $lp->rawData->ukuran == '') && (isset($lp->rawData->warna) && $lp->rawData->warna !== '')){
                                            echo " (".$lp->rawData->warna.") ";
                                        }
                                        $totalJumlah += $lp->jumlah;
                                    @endphp
                                    <span class='float-right div-print-invoice_sku' style='@if(isset($print) && !isset($print->invoice->sku)) display:none; @endif'>{{$lp->rawData->sku}}</span>
                                </td>
                                <td>
                                    {{$lp->jumlah}}			
                                </td>
                                <td>
                                    @php
                                        $berat = ((float)$lp->rawData->berat * (float)$lp->jumlah) / 1000;
                                        $totalBerat += $berat;
                                        echo $berat.' Kg';
                                    @endphp		
                                </td>
                                <td class="text-right">
                                    {{App\Http\Controllers\PusatController::formatUang($lp->rawData->harga_jual_normal, true)}}
                                </td>
                                <td class="text-right">
                                    @php
                                        $harga_jual_total = (int)$lp->rawData->harga_jual_normal * (int)$lp->jumlah;
                                        echo App\Http\Controllers\PusatController::formatUang($harga_jual_total, true);
                                        $totalHarga += $harga_jual_total;
                                    @endphp		
                                </td>
                            </tr>
                        @endforeach
                        <tr class='invoice-tr-list-harga'>
                            <td colspan="2">
                                <b>
                                    @php
                                        $kurir = json_decode($d['order']->kurir);
                                        if($kurir->tipe == 'toko'){
                                            echo 'Ambil di Toko';
                                        } else if($kurir->tipe == 'kurir'){
                                            echo ucwords(strtolower($kurir->data->nama));
                                        } else if($kurir->tipe == 'expedisi'){
                                            echo strtoupper(explode('|', $kurir->data)[0]);
                                        }
                                    @endphp
                                </b>
                            </td>
                            <td></td>
                            <td>
                                <span>{{ $totalBerat }}</span>
                                Kg
                            </td>
                            <td class="text-right">
                                @php
                                    if($kurir->tipe == 'toko'){
                                        echo 'Rp 0';
                                    } else if($kurir->tipe == 'kurir'){
                                        echo App\Http\Controllers\PusatController::formatUang($kurir->data->harga, true);
                                        $totalHarga += $kurir->data->harga;
                                    } else if($kurir->tipe == 'expedisi'){
                                        echo App\Http\Controllers\PusatController::formatUang(explode('|', $kurir->data)[2], true);
                                        $totalHarga += explode('|', $kurir->data)[2];
                                    }
                                @endphp
                            </td>
                            <td class="text-right">
                                @php
                                    if($kurir->tipe == 'toko'){
                                        echo 'Rp 0';
                                    } else if($kurir->tipe == 'kurir'){
                                        echo App\Http\Controllers\PusatController::formatUang($kurir->data->harga, true);
                                    } else if($kurir->tipe == 'expedisi'){
                                        echo App\Http\Controllers\PusatController::formatUang(explode('|', $kurir->data)[2], true);
                                    }
                                @endphp
                            </td>
                        </tr>
                        @if(!is_null($d['order']->diskonOrder))
                            @foreach($d['order']->diskonOrder as $do)
                                @php
                                    $totalHarga += $do->harga;
                                @endphp
                                <tr class='invoice-tr-list-harga'>
                                    <td colspan="5">
                                        <span>Diskon - {{ $do->nama }}</span>
                                    </td>
                                    <td class="text-right">
                                        {{ App\Http\Controllers\PusatController::formatUang($do->harga, true) }}
                                    </td>
                                </tr>
                            @endforeach
                        @else 
                            <tr class='invoice-tr-list-harga'>
                                <td colspan="5">
                                    <span>Diskon</span>
                                </td>
                                <td class="text-right">
                                    Rp 0 
                                </td>
                            </tr>
                        @endif
                        @if(!is_null($d['order']->biayaLain))
                            @foreach($d['order']->biayaLain as $bl)
                                @php
                                    $totalHarga += $bl->harga;
                                @endphp
                                <tr class='invoice-tr-list-harga'>
                                    <td colspan="5">
                                        <span>Biaya Tambahan - {{ $bl->nama }}</span>
                                    </td>
                                    <td class="text-right">
                                        {{ App\Http\Controllers\PusatController::formatUang($bl->harga, true) }}
                                    </td>
                                </tr>
                            @endforeach
                        @else 
                            <tr class='invoice-tr-list-harga'>
                                <td colspan="5">
                                    <span>Biaya Tambahan</span>
                                </td>
                                <td class="text-right">
                                    Rp 0 
                                </td>
                            </tr>
                        @endif
                        <tr class='invoice-tr-list-harga'>
                            <td colspan="2">
                                <span><b>TOTAL</b></span>
                            </td>
                            <td>
                                <span class='div-print-invoice_total-produk' style='@if(isset($print) && !isset($print->invoice->total_produk)) display:none; @endif'><b>{{ $totalJumlah }}</b></span>
                            </td>
                            <td colspan="2"></td>
                            <td class="text-right">
                                <span><b>{{ App\Http\Controllers\PusatController::formatUang($totalHarga, true) }}</b></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <hr style="border-color: #ddd; border-style: dotted;">
                            </td>
                        </tr>
                        <tr class='div-print-invoice_no-rek' style='@if(isset($print) && !isset($print->invoice->no_rek)) display:none; @endif'>
                            <td style="vertical-align: top;margin: 0;padding: 10px 0;">
                                <p style="line-height: 1em;margin: 0;padding: 0 0 0 20px;font-size:12px;">Rekening Pembayaran</p>
                            </td>
                            <td colspan="5">
                                <div class="row">
                                    <div class="col-md-4">
                                        @if($d['via_bayar'] === 'CASH' || $d['via_bayar'] === '[?Terhapus?]' || $d['via_bayar'] === '-' )
                                            <p style="font-size: 12px;line-height: 1.25em;margin:0;padding: 10px 0;">
                                                <span style="font-weight: bold; font-size:16px; text-transform: capitalize;">{{$d['via_bayar']}}</span>
                                            </p>
                                        @else
                                            <p style="font-size: 12px;line-height: 1.25em;margin:0;padding: 10px 0;">
                                                <span style="font-weight: bold; font-size:16px; text-transform: capitalize;">{{$d['via_bayar']->bank}}</span><br>
                                                No Rekening {{$d['via_bayar']->no_rek}}<br>
                                                A.n. {{ucwords(strtolower($d['via_bayar']->atas_nama))}}				
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;margin: 0;padding: 10px 0;">
                                <p style="line-height: 1em;margin: 0;padding: 0 0 0 20px;font-size:12px;">Alamat Pengiriman:</p>
                            </td>
                            <td colspan="5">
                                <p style="font-size: 12px;line-height: 1.25em;margin:0;padding: 5px 0 10px;">
                                <span style="font-weight: bold; font-size:16px; text-transform: capitalize;">{{ ucwords(strtolower($d['tujuan']->name)) }}</span><br>
                                    {{ $d['tujuan']->alamat }}&nbsp;
                                    Kec. {{ $d['tujuan']->kecamatan }},  {{ $d['tujuan']->kabupaten }}&nbsp;
                                    {{ $d['tujuan']->provinsi }} - {{ $d['tujuan']->kode_pos }}<br>
                                    @if(isset($d['tujuan']->email))
                                        <b style='color:#76838f'>Email:</b> {{ $d['tujuan']->email }}
                                    @endif
                                    @if(isset($d['tujuan']->no_telp))
                                        <br><b style='color:#76838f'>No Telp:</b> {{ $d['tujuan']->no_telp }}
                                    @endif
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endforeach
        </div>
        <div id='printable-invoice-thermal-88mm' style='display:none;'>
            @foreach(App\Http\Controllers\PusatController::genArray($data) as $d)
                @php
                    $totalBerat = $totalJumlah = $totalHarga = 0;
                    $produk_data = json_decode($d['order']->produk);
                @endphp
                <table cellspacing="0" class="print-label invoice-thermal-88mm mb-10 cek-break-page">
                    <tbody>
                        <tr>
                            <td colspan="6" class="text-center">
                                <h3 class="toko div-print-invoice-thermal-88mm_nama-toko" style='@if(isset($print) && !isset($print->invoice_thermal_88mm->nama_toko)) display:none; @endif'>{{ $d['toko']->nama_toko }}</h3>
                                <p class="mb-0 div-print-invoice-thermal-88mm_ket-toko" style='@if(isset($print) && !isset($print->invoice_thermal_88mm->ket_toko)) display:none; @endif'>{{ $d['toko']->deskripsi_toko }}</p>
                                <p class="mb-0 div-print-invoice-thermal-88mm_alamat-toko" style='@if(isset($print) && !isset($print->invoice_thermal_88mm->alamat_toko)) display:none; @endif'>{{ $d['toko']->alamat_toko }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <hr>
                            </td>
                        </tr>
                        <tr class="mb-3">
                            <td colspan="3">
                                <span>Status:
                                    @php
                                        if($d['tipe_bayar'] === 'belum'){
                                            echo '<span>BELUM BAYAR</span>';
                                        } else if($d['tipe_bayar'] === 'cicil'){
                                            echo '<span>CICIL</span>';
                                        } else if($d['tipe_bayar'] === 'lunas'){
                                            echo '<span>LUNAS</span>';
                                        }
                                    @endphp
                                </span>	
                                <span>({{ date('j M Y', strtotime($d['order']->tanggal_order)) }})</span>
                            </td>
                            <td class="text-right" colspan="3">
                                To:<span>{{ $d['tujuan']->name }}</span>
                            </td>
                        </tr>
                        <tr class='div-print-invoice-thermal-88mm_detail-invoice' style='@if(isset($print) && !isset($print->invoice_thermal_88mm->detail_invoice)) display:none; @endif'>
                            <td colspan="6">
                                <hr>
                            </td>
                        </tr>
                        <tr class='div-print-invoice-thermal-88mm_detail-invoice' style='@if(isset($print) && !isset($print->invoice_thermal_88mm->detail_invoice)) display:none; @endif'>
                            <td colspan="3">
                                <span>{{ date('j F Y', strtotime($d['order']->tanggal_order)) }}</span>
                            </td>
                            <td class="text-right" colspan="3">
                                @php
                                    $tanggalToInv = date('Y.m.d', strtotime($d['order']->tanggal_order));
                                @endphp
                                <span>INV.{{$tanggalToInv}}.{{$d["order"]->id_order}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Nama Produk</td>
                            <td class="text-center" style="width: 5mm">Qty</td>
                            <td style="width: 10mm">Berat</td>
                            <td class="text-right">Harga</td>
                            <td class="text-right">Subtotal</td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <hr>
                            </td>
                        </tr>
                        @foreach(App\Http\Controllers\PusatController::genArray($produk_data->list) as $lp)
                            <tr>
                                <td colspan="2">
                                    <span>
                                        {{ ucwords(strtolower($lp->rawData->nama_produk)) }}&nbsp;
                                        @php
                                            if((isset($lp->rawData->ukuran) && $lp->rawData->ukuran !== '') && (isset($lp->rawData->warna) && $lp->rawData->warna !== '')){
                                                echo $lp->rawData->ukuran." ".$lp->rawData->warna;
                                            } else if((isset($lp->rawData->ukuran) && $lp->rawData->ukuran !== '') && (is_null($lp->rawData->warna) || $lp->rawData->warna == '')){
                                                echo $lp->rawData->ukuran;
                                            } else if((is_null($lp->rawData->ukuran) || $lp->rawData->ukuran == '') && (isset($lp->rawData->warna) && $lp->rawData->warna !== '')){
                                                echo $lp->rawData->warna;
                                            }
                                            $totalJumlah += $lp->jumlah;
                                        @endphp
                                    </span>
                                </td>
                                <td class="text-center">
                                    {{$lp->jumlah}}			
                                </td>
                                <td>
                                    @php
                                        $berat = ((float)$lp->rawData->berat * (float)$lp->jumlah) / 1000;
                                        $totalBerat += $berat;
                                        echo $berat.' Kg';
                                    @endphp				
                                </td>
                                <td class="text-right">
                                    {{ str_replace('.', ',', App\Http\Controllers\PusatController::formatUang($lp->rawData->harga_jual_normal)) }}
                                </td>
                                <td class="text-right">
                                    @php
                                        $harga_jual_total = (int)$lp->rawData->harga_jual_normal * (int)$lp->jumlah;
                                        echo str_replace('.', ',', App\Http\Controllers\PusatController::formatUang($harga_jual_total));
                                        $totalHarga += $harga_jual_total;
                                    @endphp		
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2">
                                <b>
                                    @php
                                        $kurir = json_decode($d['order']->kurir);
                                        if($kurir->tipe == 'toko'){
                                            echo 'Ambil di Toko';
                                        } else if($kurir->tipe == 'kurir'){
                                            echo ucwords(strtolower($kurir->data->nama));
                                        } else if($kurir->tipe == 'expedisi'){
                                            echo strtoupper(explode('|', $kurir->data)[0]);
                                        }
                                    @endphp
                                </b>
                            </td>
                            <td></td>
                            <td>
                                <span>{{ $totalBerat }}</span>Kg
                            </td>
                            <td class="text-right">
                                @php
                                    if($kurir->tipe == 'toko'){
                                        echo '0';
                                    } else if($kurir->tipe == 'kurir'){
                                        echo str_replace('.', ',', App\Http\Controllers\PusatController::formatUang($kurir->data->harga));
                                        $totalHarga += $kurir->data->harga;
                                    } else if($kurir->tipe == 'expedisi'){
                                        echo str_replace('.', ',', App\Http\Controllers\PusatController::formatUang(explode('|', $kurir->data)[2]));
                                        $totalHarga += explode('|', $kurir->data)[2];
                                    }
                                @endphp
                            </td>
                            <td class="text-right">
                                @php
                                    if($kurir->tipe == 'toko'){
                                        echo '0';
                                    } else if($kurir->tipe == 'kurir'){
                                        echo str_replace('.', ',', App\Http\Controllers\PusatController::formatUang($kurir->data->harga));
                                    } else if($kurir->tipe == 'expedisi'){
                                        echo str_replace('.', ',', App\Http\Controllers\PusatController::formatUang(explode('|', $kurir->data)[2]));
                                    }
                                @endphp
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <hr>
                            </td>
                        </tr>
                        @if(!is_null($d['order']->diskonOrder))
                            @foreach($d['order']->diskonOrder as $do)
                                @php
                                    $totalHarga += $do->harga;
                                @endphp
                                <tr>
                                    <td colspan="5">
                                        <span>Diskon - {{ $do->nama }}</span>
                                    </td>
                                    <td class="text-right">
                                        {{ str_replace('.', ',', App\Http\Controllers\PusatController::formatUang($do->harga)) }}
                                    </td>
                                </tr>
                            @endforeach
                        @else 
                            <tr>
                                <td colspan="5">
                                    <span>Diskon</span>
                                </td>
                                <td class="text-right">
                                    0 
                                </td>
                            </tr>
                        @endif
                        @if(!is_null($d['order']->biayaLain))
                            @foreach($d['order']->biayaLain as $bl)
                                @php
                                    $totalHarga += $bl->harga;
                                @endphp
                                <tr>
                                    <td colspan="5">
                                        <span>Biaya Tambahan - {{ $bl->nama }}</span>
                                    </td>
                                    <td class="text-right">
                                        {{ str_replace('.', ',', App\Http\Controllers\PusatController::formatUang($bl->harga)) }}
                                    </td>
                                </tr>
                            @endforeach
                        @else 
                            <tr>
                                <td colspan="5">
                                    <span>Biaya Tambahan</span>
                                </td>
                                <td class="text-right">
                                    0 
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="6">
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <span>TOTAL</span>
                            </td>
                            <td class="text-center">
                                <span class='div-print-invoice-thermal-88mm_total-produk' style='@if(isset($print) && !isset($print->invoice_thermal_88mm->total_produk)) display:none; @endif'>{{ $totalJumlah }}</span>
                            </td>
                            <td colspan="2">
                            </td>
                            <td class="text-right">
                                <span>{{ str_replace('.', ',', App\Http\Controllers\PusatController::formatUang($totalHarga)) }}</span>
                            </td>
                        </tr>
                        <tr class='div-print-invoice-thermal-88mm_no-rek' style='@if(isset($print) && !isset($print->invoice_thermal_88mm->no_rek)) display:none; @endif'>
                            <td colspan="6">
                                <hr>
                            </td>
                        </tr>
                        <tr class='div-print-invoice-thermal-88mm_no-rek' style='@if(isset($print) && !isset($print->invoice_thermal_88mm->no_rek)) display:none; @endif'>
                            <td colspan="6">
                                @if($d['via_bayar'] === 'CASH' || $d['via_bayar'] === '[?Terhapus?]')
                                    <p>Via Pembayaran</p>
                                @else
                                    <p>Rekening Pembayaran</p>
                                @endif
                            </td>
                        </tr>
                        <tr class='div-print-invoice-thermal-88mm_no-rek' style='@if(isset($print) && !isset($print->invoice_thermal_88mm->no_rek)) display:none; @endif'>
                            <td colspan="6">
                                <div class="row">
                                    <div class="col-md-4">
                                        @if($d['via_bayar'] === 'CASH' || $d['via_bayar'] === '[?Terhapus?]' || $d['via_bayar'] === '-' )
                                            <p><span>{{$d['via_bayar']}}</span></p>
                                        @else
                                            <p>
                                                <span>{{$d['via_bayar']->bank}}</span><br>
                                                No Rekening {{$d['via_bayar']->no_rek}}<br>
                                                A.n. {{ucwords(strtolower($d['via_bayar']->atas_nama))}}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <hr class='div-print-invoice-thermal-88mm_alamat-pengirim' style='@if(isset($print) && !isset($print->invoice_thermal_88mm->alamat_pengirim)) display:none; @endif'>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="mt-2">
                                <span class='div-print-invoice-thermal-88mm_alamat-pengirim' style='@if(isset($print) && !isset($print->invoice_thermal_88mm->alamat_pengirim)) display:none; @endif'>Alamat Pengiriman:</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <span class='div-print-invoice-thermal-88mm_alamat-pengirim' style='@if(isset($print) && !isset($print->invoice_thermal_88mm->alamat_pengirim)) display:none; @endif'>
                                    {{ $d['tujuan']->alamat }}&nbsp;
                                    Kec. {{ $d['tujuan']->kecamatan }},  {{ $d['tujuan']->kabupaten }}&nbsp;
                                    {{ $d['tujuan']->provinsi }} - {{ $d['tujuan']->kode_pos }}<br>
                                    @if(isset($d['tujuan']->email))
                                        Email: {{ $d['tujuan']->email }}
                                    @endif
                                    @if(isset($d['tujuan']->no_telp))
                                        <br>No Telp: {{ $d['tujuan']->no_telp }}
                                    @endif
                                </span>
                                <span class='div-print-invoice-thermal-88mm_kurir' style='@if(isset($print) && !isset($print->invoice_thermal_88mm->kurir)) display:none; @endif'><br>
                                    Kurir:
                                    @php
                                        $kurir = json_decode($d['order']->kurir);
                                        if($kurir->tipe == 'toko'){
                                            echo 'Ambil di Toko';
                                        } else if($kurir->tipe == 'kurir'){
                                            echo ucwords(strtolower($kurir->data->nama));
                                        } else if($kurir->tipe == 'expedisi'){
                                            echo strtoupper(explode('|', $kurir->data)[0]);
                                        }
                                    @endphp    
                                </span>
                            </td>
                        </tr>
                        <tr class='div-print-invoice-thermal-88mm_nama-admin' style='@if(isset($print) && !isset($print->invoice_thermal_88mm->nama_admin)) display:none; @endif'>
                            <td colspan="6">
                                <hr>
                            </td>
                        </tr>
                        <tr class='div-print-invoice-thermal-88mm_nama-admin' style='@if(isset($print) && !isset($print->invoice_thermal_88mm->nama_admin)) display:none; @endif'>
                            <td colspan="6" class="mt-2">
                                <span>Admin: {{ ucwords(strtolower($d['order']->nama_admin)) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="6">
                                <span class="text-center" style="display: block; padding-top: 1.5rem;">Terima kasih</span>
                                <br>
                                <span>telah berbelanja di {{ $d['toko']->nama_toko }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endforeach
        </div>
    </div>
    <script>
        function hideAllBagian(){
            $('#bagian-ship').hide();
            $('#bagian-ship-v2').hide();
            $('#bagian-ship-a6').hide();
            $('#bagian-invoice').hide();
            $('#bagian-invoice-thermal-88mm').hide();
        }

        function hideAllPrintable(){
            $('#printable-ship').hide();
            $('#printable-ship-v2').hide();
            $('#printable-ship-a6').hide();
            $('#printable-invoice').hide();
            $('#printable-invoice-thermal-88mm').hide();
        }

        function afterPrint(){
            let data = '{{ $id_target }}';
            // alert(data);
        }

        $(document).ready(function(){

            @if(is_null($print) || isset($print->ship->no_order))
                $('#print-ship_knob-no-order').knob({
                    'min':12,
                    'max':50,
                    'fgColor': '#008C4D',
                    'bgColor': '#212224',
                    'width':84,
                    'lineCap': 'round',
                    'change': function(v){
                        $('#no-order_print_ship').css('font-size', v+'px');
                    }
                });
            @endif
            @if(is_null($print) || isset($print->ship_v2->no_order))
                $('#print-ship-v2_knob-no-order').knob({
                    'min':12,
                    'max':50,
                    'fgColor': '#008C4D',
                    'bgColor': '#212224',
                    'width':84,
                    'lineCap': 'round',
                    'change': function(v){
                        $('#no-order_print_ship-v2').css('font-size', v+'px');
                    }
                });
            @endif

            $('.iCheck').iCheck({
                radioClass: 'iradio_polaris',
                checkboxClass: 'icheckbox_polaris'
            });

            $('input[name=print]').on('ifClicked', function(){
                hideAllBagian();
                hideAllPrintable();
                $('#bagian-'+this.value).show();
                $('#printable-'+this.value).show();
            });

            $('.iCheck').on('ifToggled', function(){
                if($(this).attr('type') == 'checkbox'){
                    let id = $(this).attr('id');
                    if($(this).iCheck('update')[0].checked){
                        if($(this).attr('id') == 'print-ship-v2_kurir'){
                            $('.div-'+id).attr('style', 'display:table-cell');
                        } else {
                            $('.div-'+id).show();
                        }

                        if($(this).attr('id') == 'print-invoice_nama-admin'){
                            $('#foto-invoice').attr('style', 'width:94px');
                        }
                        if($(this).attr('id') == 'print-ship_no-order'){
                            let defaultVal = @if(is_null($print)) 14 @elseif(isset($print->ship->knob_no_order)) {{$print->ship->knob_no_order}}  @else 14 @endif;
                            $('#area-print-ship_knob-no-order').html(
                                "<label for='print-ship_knob-no-order' style='padding: 0 0 5px; margin: 0;'>Font Size No Order:</label><br>"+
                                "<input type='text' class='knob-no-order' id='print-ship_knob-no-order' value='"+defaultVal+"' name='print-ship_knob-no-order'>");
                            $('#print-ship_knob-no-order').knob({
                                'min':12,
                                'max':50,
                                'fgColor': '#008C4D',
                                'bgColor': '#212224',
                                'width':84,
                                'lineCap': 'round',
                                'change': function(v){
                                    $('#no-order_print_ship').css('font-size', v+'px');
                                }
                            });
                        }
                        if($(this).attr('id') == 'print-ship-v2_no-order'){
                            let defaultVal = @if(is_null($print)) 14 @elseif(isset($print->ship_v2->knob_no_order)) {{$print->ship_v2->knob_no_order}}  @else 14 @endif;
                            $('#area-print-ship-v2_knob-no-order').html(
                                "<label for='print-ship-v2_knob-no-order' style='padding: 0 0 5px; margin: 0;'>Font Size No Order:</label><br>"+
                                "<input type='text' class='knob-no-order' id='print-ship-v2_knob-no-order' value='"+defaultVal+"' name='print-ship-v2_knob-no-order'>");
                            $('#print-ship-v2_knob-no-order').knob({
                                'min':12,
                                'max':50,
                                'fgColor': '#008C4D',
                                'bgColor': '#212224',
                                'width':84,
                                'lineCap': 'round',
                                'change': function(v){
                                    $('#no-order_print_ship-v2').css('font-size', v+'px');
                                }
                            });
                        }
                    } else {
                        if($(this).attr('id') == 'print-ship-v2_kurir'){
                            $('.div-'+id).attr('style', 'display:table-column');
                        } else {
                            $('.div-'+id).hide();
                        }
                        
                        if($(this).attr('id') == 'print-invoice_nama-admin'){
                            $('#foto-invoice').attr('style', 'width:64px');
                        }
                        if($(this).attr('id') == 'print-ship_no-order'){
                            $('#print-ship_knob-no-order').remove();
                            $('#area-print-ship_knob-no-order').html('');
                        }
                        if($(this).attr('id') == 'print-ship-v2_no-order'){
                            $('#print-ship-v2_knob-no-order').remove();
                            $('#area-print-ship-v2_knob-no-order').html('');
                        }
                    }
                }
            });

            $('#btnSimpan').on('click', function(){
                let data = $('#pengaturanForm').serializeArray();
                let hasil = {};
                var lamaIndex = '';
                // console.log(data);
                $.each(data, (i, v) => {
                    let kolom = v.name.split('_');
                    kolom[0] = kolom[0].replace(/-/g, '_');
                    kolom[1] = kolom[1].replace(/-/g, '_');
                    if(lamaIndex !== kolom[0]) {
                        hasil[kolom[0]] = {};
                        lamaIndex = kolom[0];
                    }
                    if(kolom[1] === 'knob_no_order'){
                        hasil[kolom[0]][kolom[1]] = parseInt(v.value); 
                    } else {
                        hasil[kolom[0]][kolom[1]] = v.value == 'on' ? 1 : 0; 
                    }
                });
                // return console.log(hasil);
                $.ajax({
                    type: 'post',
                    url: "{{ route('b.print-simpan') }}",
                    data: {
                        data: JSON.stringify(hasil),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        hasil = data;
                    },
                    error: function (error, b, c) {
                        swal("Error", '' + c, "error");
                    }
                }).done(function () {
                    if (hasil.status) {
                        swal("Berhasil!", "" + hasil.msg, "success");
                    } else {
                        swal("Gagal!", "" + hasil.msg, "error");
                    }
                });
            });
        });
    </script>
    <script src="{{ asset('template/global/vendor/bootstrap/bootstrap.js') }}"></script>
    <script src="{{ asset('template/global/vendor/icheck/icheck.min.js') }}"></script>
    <script src="{{ asset('template/global/vendor/jquery-knob/jquery.knob.min.js') }}"></script>
    <script src="{{ asset('template/global/js/Plugin/sweetalert.js') }}"></script>
</body>
</html>