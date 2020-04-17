@extends('belakang.index')
@section('isi')
<!--uiop-->
@php
//echo "<pre>".print_r($data_order, true)."</pre>";
@endphp
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
.selectBug{
    animation-fill-mode: backwards;
    -webkit-animation-fill-mode: backwards;
}

#btnCari:hover {
    cursor: pointer;
}

.filterBtnDefault {
    background-color:white;
    color:#37474F;
}

.filterBtnAktif {
    background-color:#3e8ef7;
    color:white;
}

.filter-box {
    position: relative;
    padding: 0px 15px 15px 20px;
    background-color: #eceff2;
    border: 1px solid #DDD;
    /* border-bottom: 1px solid #E4EAEC;
    border-top: 1px solid #E4EAEC; */
    border-radius: 10px;
    /* box-shadow: 0px 10px 10px -6px rgba(0,0,0,0.58); */
}

.btnResi:hover{
    -webkit-box-shadow: 4px 5px 11px -3px rgba(0,0,0,0.75);
    -moz-box-shadow: 4px 5px 11px -3px rgba(0,0,0,0.75);
    box-shadow: 4px 5px 11px -3px rgba(0,0,0,0.75);
    cursor:pointer;
}

.row-list-order {
    position: relative;
    width: 100%;
    background-color: #fff;
    border: 2px solid rgba(0, 0, 0, 0.15);
    margin-bottom: 20px;
    padding: 15px;
    display: table;
    border-radius: 1rem !important;
    box-shadow: 5px 10px 8px #888888;
}

.row-list-order-updated {
    background-color: #ffe282;
}

.row-list-order-head {
    border-bottom: 1px dashed rgba(0, 0, 0, 0.15);
    /* padding: 1.25rem .5rem 1rem; */
}

.row-list-order-body {
    padding: 1.5rem .5rem 1.25rem;
}

.row-list-order-footer {
    border-top: 1px dashed rgba(0, 0, 0, 0.15);
    padding-left: 15px;
    padding-top: 20px;
}

.total-bayar-info {
    width: 80%;
    padding: 15px;
    font-size: 20px;
    border-radius: 10px;
}

.bayar-lunas {
    background: #C2FADC;
    border: 1px solid #72E8AB;
}

.bayar-cicil {
    background: #FFF6B5;
    border: 1px solid #FFED78;
}

.bayar-belum {
    background: #FFDBDC;
    border: 1px solid #FFBFC1;
}
</style>
<div class="page-header page-header-bordered">
    <div class='row'>
        <div class='col-md-6'>
            <h1 class="page-title font-size-26 font-weight-100">Order</h1>
        </div>
        <div class='col-md-6'>
            <div class="page-header-actions">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"
                            onClick="pageLoad('{{ route('b.dashboard') }}')">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);"
                            onClick="pageLoad('{{ route('b.order-index') }}')">Order</a></li>
                    <li class="breadcrumb-item active">Semua Order</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="page-content">
    @if ($msg_sukses = Session::get('msg_success'))
    <div class='alert alert-success' id='alert-sukses' role='alert'><i class='fa fa-check'></i> SUCCESS: {{$msg_sukses}}
    </div>
    @endif
    @if ($msg_error = Session::get('msg_error'))
    <div class='alert alert-danger' id='alert-error' role='alert'><i class='fa fa-minus-circle'></i> ERROR: {{$msg_error}}
    </div>
    @endif
    <ul class="row justify-content-center" style='list-style-type: none;'>
        <li class="p-5 animation-slide-top animation-delay-100">
            <a class="btn btn-round p-15 btnFilterClick btn-primary" data-id='f_semua' href="javascript:void(0)">
                <i class="icon wb-search" aria-hidden="true"></i>
                Semua Order
            </a>
        </li>
        <li class="p-5 animation-slide-top animation-delay-200">
            <a class="btn btn-round p-15 btnFilterClick filterBtnDefault" data-id='f_belum_bayar' href="javascript:void(0)">
                <i class="icon wb-search" aria-hidden="true"></i>
                Belum Bayar
            </a>
        </li>
        <li class="p-5 animation-slide-top animation-delay-300">
            <a class="btn btn-round p-15 btnFilterClick filterBtnDefault" data-id='f_belum_lunas' href="javascript:void(0)">
                <i class="icon wb-search" aria-hidden="true"></i>
                Belum Lunas
            </a>
        </li>
        <li class="p-5 animation-slide-top animation-delay-400">
            <a class="btn btn-round p-15 btnFilterClick filterBtnDefault" data-id='f_belum_proses' href="javascript:void(0)">
                <i class="icon wb-search" aria-hidden="true"></i>
                Belum Diproses
            </a>
        </li>
        <li class="p-5 animation-slide-top animation-delay-500">
            <a class="btn btn-round p-15 btnFilterClick filterBtnDefault" data-id='f_belum_resi' href="javascript:void(0)">
                <i class="icon wb-search" aria-hidden="true"></i>
                Belum Ada Resi
            </a>
        </li>
        <li class="p-5 animation-slide-top animation-delay-600">
            <a class="btn btn-round p-15 btnFilterClick filterBtnDefault" data-id='f_dalam_proses' href="javascript:void(0)">
                <i class="icon wb-search" aria-hidden="true"></i>
                Pengiriman Dalam Proses
            </a>
        </li>
        <li class="p-5 animation-slide-top animation-delay-700">
            <a class="btn btn-round p-15 btnFilterClick filterBtnDefault" data-id='f_kirim_berhasil' href="javascript:void(0)">
                <i class="icon wb-search" aria-hidden="true"></i>
                Pengiriman Berhasil
            </a>
        </li>
        {!! $data_filter !!}
    </ul>
    <div class='container'>
        <div class='row'>
            <div class='col-md-6'>
                <div class="form-group animation-slide-left selectBug">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <select id='tipeCari'>
                                <option value="order_id">Order ID</option>
                                <option value="nama_cust">Nama Customer</option>
                                <option value="nama_prod">Nama Produk</option>
                                <option value="resi">No Resi</option>
                                <option value="sku">SKU Produk</option>
                                <option value="no_telp">No Telp Customer</option>
                            </select>
                        </div>
                        <div class="input-search">
                            <a href='javascript:void(0)' class="input-search-btn" style='margin-top:8px' id='btnCari'><i class="icon wb-search"
                                    style='color:#0bb2d4' aria-hidden="true"></i></a>
                            <input type="text" class="form-control" id='queryCari' style='border-color:#0bb2d4' name="queryCari"
                                placeholder="Pencarian...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-right">
                <div class="form-group animation-slide-right selectBug" style="animation-delay:200ms">
                    <a class="btn btn-success btn-icon mr-10" href="javascript:void(0);"
                        onClick="pageLoad('{{ route('b.order-tambah') }}')"><i class='fa fa-plus'></i> Tambah Order
                        Baru</a>
                    <button type="button" class="btn btn-info mr-10" id='btnFilter'><i class='fa fa-filter'></i>
                        Filter</button>
                    @if(($ijin->downloadExcel === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner')
                    <div class="dropdown btn-group">
                        <button type="button" class="btn bg-indigo-700 white dropdown-toggle" id="exampleColorDropdown1"
                            data-toggle="dropdown" aria-expanded="false">Menu</button>
                        <div class="dropdown-menu" aria-labelledby="exampleColorDropdown1" role="menu">
                            <a class="dropdown-item" href="{{ route('b.excel-export-order', ['format' => 'xlsx']) }}"><i class='wb-download'></i> Download Excel File (.xlsx)</a>
                            <a class="dropdown-item" href="{{ route('b.excel-export-order', ['format' => 'xls']) }}"><i class='wb-download'></i> Download Excel File (.xls)</a>
                            <a class="dropdown-item" href="{{ route('b.excel-export-order', ['format' => 'csv']) }}"><i class='wb-download'></i> Download Excel File (.csv)</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="filter-box mb-20 hidden">
            <span style='font-size:25px' class='mt-10'>Filter Box</span>
            <div class='row mt-10'>
                <div class='col-md-8'>
                    <div class='row'>
                        <div class='col-md-3 form-group'>
                            <label>Admin</label>
                            <select class='form-control' id='filter-admin' name='f_admin'>
                                <option value='0'>Semua</option>
                                <option value='store'>StoreFront</option>
                            </select>
                        </div>
                        <div class='col-md-3 form-group'>
                            <label>Pembayaran</label>
                            <select class='form-control' id='filter-bayar' name='f_bayar'>
                                <option value='0'>Semua</option>
                                <option value='belum'>Belum Bayar</option>
                                <option value='cicil'>Cicilan</option>
                                <option value='lunas'>Lunas</option>
                            </select>
                        </div>
                        <div class='col-md-3 form-group'>
                            <label>Pengiriman</label>
                            <select class='form-control' id='filter-kirim' name='f_kirim'>
                                <option value='0'>Semua</option>
                                <option value='belum_proses'>Belum Diproses</option>
                                <option value='belum_resi'>Belum Ada Resi</option>
                                <option value='dalam_kirim'>Dalam Pengiriman</option>
                                <option value='sudah_tujuan'>Sudah Sampai Tujuan</option>
                            </select>
                        </div>
                        <div class='col-md-3 form-group'>
                            <label>Via Pembayaran</label>
                            <select class='form-control' id='filter-via' name='f_via'>
                                <option value='0'>Semua</option>
                                <option value='cash'>CASH</option>
                            </select>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-3 form-group'>
                            <label>Kurir</label>
                            <select class='form-control' id='filter-kurir' name='f_kurir'>
                                <option value='0'>Semua</option>
                                <option value='input'>Input Manual</option>
                                <option value='toko'>Ambil Di Toko</option>
                                <option value='jne'>Jalur Nugraha Ekakurir (JNE)</option>
                                <option value='pos'>POS Indonesia (POS)</option>
                                <option value='tiki'>Citra Van Titipan Kilat (TIKI)</option>
                                <option value='pcp'>Priority Cargo and Package (PCP)</option>
                                <option value='esl'>Eka Sari Lorena (ESL)</option>
                                <option value='rpx'>RPX Holding (RPX)</option>
                                <option value='pandu'>Pandu Logistics (PANDU)</option>
                                <option value='wahana'>Wahana Prestasi Logistik (WAHANA)</option>
                                <option value='sicepat'>SiCepat Express (SICEPAT)</option>
                                <option value='jnt'>J&T Express (J&T)</option>
                                <option value='pahala'>Pahala Kencana Express (PAHALA)</option>
                                <option value='sap'>SAP Express (SAP)</option>
                                <option value='jet'>JET Express (JET)</option>
                                <option value='slis'>Solusi Ekspres (SLIS)</option>
                                <option value='dse'>21 Express (DSE)</option>
                                <option value='first'>First Logistics (FIRST)</option>
                                <option value='ncs'>Nusantara Card Semesta (NCS)</option>
                                <option value='star'>Star Cargo (STAR)</option>
                                <option value='lion'>Lion Parcel (LION)</option>
                                <option value='ninja'>Ninja Xpress (NINJA)</option>
                                <option value='idl'>IDL Cargo (IDL)</option>
                                <option value='rex'>Royal Express Indonesia (REX)</option>
                                <option value='indah'>Indah Logistic (INDAH)</option>
                                <option value='cahaya'>Cahaya Ekspress Logistik (CAHAYA)</option>
                            </select>
                        </div>
                        @if($order_source['cek'] == 'on')
                        <div class='col-md-5 form-group'>
                            <div class='form-group'>
                                <label>Order Source</label>
                                <select class='form-control' id='filter-orderSource' name='f_orderSource'>
                                    <option value='0' selected>Semua</option>
                                    @foreach($order_source['data'] as $os)
                                        <option value='{{ $os->id_order_source }}'>{{ $os->kategori }} - {{ $os->keterangan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
                        <div class='col-md-3 form-group'>
                            <label>Label Print</label>
                            <div class="btn-group" data-toggle="buttons" role="group">
                                <label class="btn btn-outline btn-info active">
                                    <input type="radio"  name='f_print' class='hidden' autocomplete="off" value="0"
                                        checked>
                                    <!-- <i class="icon wb-check text-active" aria-hidden="true"></i>  -->
                                    Semua
                                </label>
                                <label class="btn btn-outline btn-info">
                                    <input type="radio" name='f_print' class='hidden' autocomplete="off" value="print">
                                    <!-- <i class="icon wb-check text-active" aria-hidden="true"></i>  -->
                                    Printed
                                </label>
                                <label class="btn btn-outline btn-info">
                                    <input type="radio" name='f_print' class='hidden' autocomplete="off" value="belum_print">
                                    <!-- <i class="icon wb-check text-active" aria-hidden="true"></i> -->
                                    Unprinted
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='col-md-4' style='border-left:1px solid #ddd'>
                    <div class='row'>
                        <div class='col-md-12 form-group'>
                            <label>Tanggal</label><br>
                            <div class="btn-group" data-toggle="buttons" role="group">
                                <label class="btn btn-outline btn-info active">
                                    <input type="radio" name='f_tglTipe' class='hidden' autocomplete="off" value="bayar"
                                        checked>
                                    <!-- <i class="icon wb-check text-active" aria-hidden="true"></i>  -->
                                    Bayar
                                </label>
                                <label class="btn btn-outline btn-info">
                                    <input type="radio" name='f_tglTipe' class='hidden' autocomplete="off" value="order">
                                    <!-- <i class="icon wb-check text-active" aria-hidden="true"></i>  -->
                                    Order
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-12 form-group'>
                            <label>Dari - Sampai</label><br>
                            <div class="input-group">
                                <input type="text" class="form-control" id='datepickerDari' name='f_tglDari' autocomplete='off'>
                                <div class="input-group-addon">Sampai</div>
                                <input type="text" class="form-control" id="datepickerSampai" name='f_tglSampai' autocomplete='off'>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='row'>
                <div class='col-md-12'>
                    <button type='button' class='btn btn-primary' id='btnUseFilter'>Gunakan Filter</button>
                    <button type='button' class='btn btn-success' id='btnSimpanFilter'>Simpan Filter</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class='row mb-20'>
            <div class='col-md-12 animation-slide-left' style='font-size:20px;animation-delay:300ms'>
                <span style='font-weight:bold;color:black;'>{{ $data_order->total() }}</span><span style='color:black'> Order yang ditemukan</span>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-12'>
                @php
                foreach($order as $o){
                echo $o;
                }
                @endphp
            </div>
        </div>
        @if($data_order->total() > 0)
        <div class='row'>
            <div class='col-xxl-3 col-xl-6'>
                <div class='panel p-15 animation-slide-left' style='animation-delay:300ms'>
                    <div class='d-flex'>
                        <div style='margin-top:8px'>
                            <input type="checkbox" id='pilihSemua'/>
                            <label for='pilihSemua' class='ml-3'>Pilih Semua</label>
                        </div>
                        <button type="button" class="btn btn-icon btn-primary btn-outline ml-15" id='btnPrintAll'><i class='fa fa-print'></i> Print Semua</button>
                    </div>
                </div>
            </div>
        </div>
        @endif
        {{ $data_order->links('vendor.pagination.bootstrap-4') }}
    </div>
</div>
<script>
var pilih_order = [];

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

$(document).ready(function() {

    $('.icek').on('ifChecked', function(){
        let id = parseInt($(this).parent().parent().parent().parent().parent().data('urut'));
        // console.log(id);
        if(pilih_order.indexOf(id) === -1){
            pilih_order.push(id);
        }
        if(pilih_order.length === parseInt('{{ $data_order->total() }}')){
            $('#pilihSemua')[0].checked = true;
            $('#pilihSemua').iCheck('update');
        }
        // console.log(pilih_order);
    });

    $('.icek').on('ifUnchecked', function(){
        let id = parseInt($(this).parent().parent().parent().parent().parent().data('urut'));
        pilih_order = $.grep(pilih_order, function(value) {
            return value !== parseInt(id);
        });
        if(pilih_order.length !== parseInt('{{ $data_order->total() }}')){
            $('#pilihSemua')[0].checked = false;
            $('#pilihSemua').iCheck('update');
        }
        // console.log(pilih_order);
    });

    $('#pilihSemua').on('ifChecked', function(){
        $.each(jQuery.parseJSON('{{ $list_order_json }}'), (i, v) => {
            if(pilih_order.indexOf(v) === -1){
                pilih_order.push(v);
            }
            $('#pilihCheck-'+v)[0].checked = true;
            $('#pilihCheck-'+v).iCheck('update');
        });
        // console.log(pilih_order);
    });

    $('#pilihSemua').on('ifUnchecked', function(){
        pilih_order = [];
        $.each(jQuery.parseJSON('{{ $list_order_json }}'), (i, v) => {
            $('#pilihCheck-'+v)[0].checked = false;
            $('#pilihCheck-'+v).iCheck('update');
        });
        // console.log(pilih_order);
    });

    $('#btnPrintAll').on('click', function(){
        if(pilih_order.length > 0){
            let url = "{{ route('b.print-index') }}";
            $(location).attr('href', url+'/'+pilih_order.join('-'));
        }
    });

    @foreach($popover as $iP => $vP)
        @if(is_null($vP['pemesan']))
            $('#myPop-{{$iP+1}}').attr('style', 'cursor:default');
        @else
            $('#myPop-{{$iP+1}}').webuiPopover({
                content: "<div><span class='text-muted'>Alamat</span><br>"+
                    "{{ $vP['pemesan']->alamat }}<br>{{ $vP['pemesan']->kecamatan }}, {{ $vP['pemesan']->kabupaten }}<br>"+
                    "{{ strtoupper($vP['pemesan']->provinsi) }}&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;{{ $vP['pemesan']->kode_pos }}<br><br>"+
                    "</div><div><span class='text-muted'>Kontak</span><br>"+
                    "<b>Telp:</b> &nbsp;&nbsp;{{ $vP['pemesan']->no_telp }}<br><b>Email:</b> &nbsp;&nbsp;{{ $vP['pemesan']->email }}"+
                    "</div><br><a href='javascript:void(0)' "+
                    "onClick='$(\"#myPop-{{$iP+1}}\").webuiPopover(\"destroy\");pageLoad(\"{{ route('b.customer-history', ['id_user' => $vP['pemesan']->user_id]) }}\")' "+
                    "class='btn btn-success btn-block btn-round btn-sm'>History Order</a>",
                width: 320,
                animation: "pop",
                placement: "right",
                trigger:"hover"
            });
        @endif

        @if(is_null($vP['tujuan']))
            $('#myPop-{{$iP+1}}-2').attr('style', 'cursor:default');
        @else
            $('#myPop-{{$iP+1}}-2').webuiPopover({
                content: "<div><span class='text-muted'>Alamat</span><br>"+
                    "{{ $vP['tujuan']->alamat }}<br>{{ $vP['tujuan']->kecamatan }}, {{ $vP['tujuan']->kabupaten }}<br>"+
                    "{{ strtoupper($vP['tujuan']->provinsi) }}&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;{{ $vP['tujuan']->kode_pos }}<br><br>"+
                    "</div><div><span class='text-muted'>Kontak</span><br>"+
                    "<b>Telp:</b> &nbsp;&nbsp;{{ $vP['tujuan']->no_telp }}<br><b>Email:</b> &nbsp;&nbsp;{{ $vP['tujuan']->email }}"+
                    "</div><br><a href='javascript:void(0)' "+
                    "onClick='$(\"#myPop-{{$iP+1}}-2\").webuiPopover(\"destroy\");pageLoad(\"{{ route('b.customer-history', ['id_user' => $vP['tujuan']->user_id]) }}\")' "+
                    "class='btn btn-success btn-block btn-round btn-sm'>History Order</a>",
                width: 320,
                animation: "pop",
                placement: "right",
                trigger:"hover"
            });
        @endif
    @endforeach
    
    @if ($id_update = Session::get('id_update'))

        $(".row-list-order[data-id={{$id_update}}]").addClass("row-list-order-updated");

        $(".row-list-order-updated").delay(2000).animate({backgroundColor:"#fff"}, 5000);

        setTimeout(function(){
            var list = Array.prototype.slice.call($(".row-list-order"));
            list.forEach(function(html) {
                if($(html).hasClass("row-list-order-updated")){
                    $(html).removeClass("row-list-order-updated");
                }
            });
        }, 10000);
    @endif

    $('#tipeCari').selectpicker({
        style: 'btn-info',
        width: '155px'
    });

    $('#filter-bayar').selectpicker({
        style: 'btn-default btn-outline'
    });

    $('#filter-admin').selectpicker({
        style: 'btn-default btn-outline'
    });

    $('#filter-kirim').selectpicker({
        style: 'btn-default btn-outline'
    });

    $('#filter-via').selectpicker({
        style: 'btn-default btn-outline'
    });

    $('#filter-kurir').selectpicker({
        style: 'btn-default btn-outline'
    });

    @if($order_source['cek'] == 'on')
        $('#filter-orderSource').selectpicker({
            style: 'btn-outline btn-default'
        });
    @endif

    $('.icek').iCheck({
        checkboxClass: 'icheckbox_flat-blue'
    });

    $('#pilihSemua').iCheck({
        checkboxClass: 'icheckbox_flat-blue'
    });

    $("#btnFilter").click(function() {
        $(".filter-box").slideToggle("slow");
    });

    $('.state-order-bayar').tooltip({
        trigger: 'hover',
        title: 'Menunggu pembayaran',
        placement: 'top'
    });
    
    $('.state-order-proses').tooltip({
        trigger: 'hover',
        title: 'Order sedang diproses',
        placement: 'top'
    });
    
    $('.state-order-kirim').tooltip({
        trigger: 'hover',
        title: 'Barang sedang dikirim',
        placement: 'top'
    });
    
    $('.state-order-terima').tooltip({
        trigger: 'hover',
        title: 'Barang sudah diterima Customer',
        placement: 'top'
    });
        
    $("#tanggalBayar").datepicker({
        format: "dd MM yyyy",
        orientation: 'bottom'
    }).datepicker('setDate', new Date())
    .datepicker("setStartDate", new Date());
        
    $("#datepickerDari").datepicker({
        format: "dd M yyyy",
        orientation: 'bottom'
    }).on('changeDate', function(ev) {
        var dateOrder = new Date(ev.date.valueOf());
        $('#datepickerSampai').datepicker('setStartDate', dateOrder);
    });
        
    $("#datepickerSampai").datepicker({
        format: "dd M yyyy",
        orientation: 'bottom'
    }).on('changeDate', function(ev) {
        var dateOrder = new Date(ev.date.valueOf());
        $('#datepickerDari').datepicker('setEndDate', dateOrder);
    });

    
    var objSwitch = new Switchery(document.querySelector("#toggleCicilan"), {
        color: '#3e8ef7'
    });

    $(".btnUpdateResi").on("click", function(){
        var id_order = $(this).parent().parent().parent().attr("data-id");
        $(".row-list-order[data-id="+id_order+"]").children(".row-list-order-body").children("div:last").children("div:first").children("span").append(
            "<div class='d-flex mt-5'>"+
                "<input type='text' class='form-control' style='width:80%' placeholder='Masukkan Resi..' data-id='"+id_order+"' name='dataResi'>"+
                "<button class='btn btn-success btn-sm btnSimpanResi'>Simpan</button>"+
            "</div>"
        );
        $(this).remove();
    });

    $(".btnFilterClick").click(function(){
        var id = $(this).data("id");
        var gagal = false;
        switch(id){
            case "f_semua":
                var url = "{{ route('b.order-index') }}";
                break;

            case "f_belum_bayar":
                var url = "{{ route('b.order-filter') }}?f_id="+id+"&f_admin=0&f_bayar=belum&f_kirim=0&f_via=0&f_kurir=0&f_print=0&f_tglTipe=bayar&f_tglDari=&f_tglSampai=";
                break;

            case "f_belum_lunas":
                var url = "{{ route('b.order-filter') }}?f_id="+id+"&f_admin=0&f_bayar=cicil&f_kirim=0&f_via=0&f_kurir=0&f_print=0&f_tglTipe=bayar&f_tglDari=&f_tglSampai=";
                break;

            case "f_belum_proses":
                var url = "{{ route('b.order-filter') }}?f_id="+id+"&f_admin=0&f_bayar=0&f_kirim=belum_proses&f_via=0&f_kurir=0&f_print=0&f_tglTipe=bayar&f_tglDari=&f_tglSampai=";
                break;

            case "f_belum_resi":
                var url = "{{ route('b.order-filter') }}?f_id="+id+"&f_admin=0&f_bayar=0&f_kirim=belum_resi&f_via=0&f_kurir=0&f_print=0&f_tglTipe=bayar&f_tglDari=&f_tglSampai=";
                break;

            case "f_dalam_proses":
                var url = "{{ route('b.order-filter') }}?f_id="+id+"&f_admin=0&f_bayar=0&f_kirim=dalam_kirim&f_via=0&f_kurir=0&f_print=0&f_tglTipe=bayar&f_tglDari=&f_tglSampai=";
                break;
                
            case "f_kirim_berhasil":
                var url = "{{ route('b.order-filter') }}?f_id="+id+"&f_admin=0&f_bayar=0&f_kirim=sudah_tujuan&f_via=0&f_kurir=0&f_print=0&f_tglTipe=bayar&f_tglDari=&f_tglSampai=";
                break;
            
            default:
                var te = $(this).parent().children("textarea").val();
                // console.log(te);
                if(te != ""){
                    var data = jQuery.parseJSON($(this).parent().children("textarea").val());
                    // console.log(data);
                    // console.log(data.f_orderSource);
                    var tglDari = (data.f_tglDari == null) ? "" : data.f_tglDari;
                    var tglSampai = (data.f_tglSampai == null) ? "" : data.f_tglSampai;
                    var url = "{{ route('b.order-filter') }}?f_id="+id+"&f_admin="+data.f_admin+"&f_bayar="+data.f_bayar+"&f_kirim="+data.f_kirim+"&f_via="+data.f_via+"&f_kurir="+data.f_kurir+"&f_print="+data.f_print+"&f_tglTipe="+data.f_tglTipe+"&f_tglDari="+tglDari+"&f_tglSampai="+tglSampai;
                    @if($order_source['cek'] == 'on')
                        url += "&f_orderSource="+data.f_orderSource;
                    @endif
                } else {
                    gagal = true;
                }
                break;
        }
        if(!gagal){
            // window.location.href = url;
            pageLoad(url);
        }
        return;
    });

    $("#btnUseFilter").on("click", function(){
        var url = "{{route('b.order-filter')}}";
        var form = $("<form action='"+url+"' method='get'></form>");
        form.append($("#filter-admin"));
        form.append($("#filter-bayar"));
        form.append($("#filter-kirim"));
        form.append($("#filter-via"));
        form.append($("#filter-kurir"));
        form.append($("#filter-print"));
        @if($order_source['cek'] == 'on')
        form.append($("#filter-orderSource"));
        @endif
        form.append($("input[name=f_print]"));
        form.append($("input[name=f_tglTipe]"));
        $("#datepickerDari").clone().appendTo(form);
        $("#datepickerSampai").clone().appendTo(form);
        // form.append($("#datepickerDari"));
        // form.append($("#datepickerSampai"));
        $('body').append(form);
        form.submit();
    });

    $("#btnSimpanFilter").on("click", function(){
        $("#filterMod").modal("show");
    });

    $("#btnSimpanFilterMod").on("click", function(){
        var val = $("#nama_filterMod").val();
        if(val != ""){
            $("#filterMod").modal("hide");
            var url = "{{route('b.order-proses')}}";
            var form = $("<form action='"+url+"' method='post'></form>");
            form.append($("#filter-admin"));
            form.append($("#filter-bayar"));
            form.append($("#filter-kirim"));
            form.append($("#filter-via"));
            form.append($("#filter-kurir"));
            form.append($("#filter-print"));
            @if($order_source['cek'] == 'on')
            form.append($("#filter-orderSource"));
            @endif
            form.append($("input[name=f_print]"));
            form.append($("input[name=f_tglTipe]"));
            form.append($("#nama_filterMod"));
            form.append("<input type='text' name='tipeKirim' value='filter_save'>");
            form.append('@csrf');
            $("#datepickerDari").clone().appendTo(form);
            $("#datepickerSampai").clone().appendTo(form);
            // form.append($("#datepickerDari"));
            // form.append($("#datepickerSampai"));
            $('body').append(form);
            // console.log(form);
            form.submit();
        } else {
            $("#nama_filterMod").addClass("animation-shake is-invalid");
            $('#error_nama').show();
            $('#error_nama').attr('class', 'invalid-feedback');
            $('#error_nama').html('Nama tidak boleh kosong!');
        }
    });

    $("#nama_filterMod").on("input", function(){
        if($("#nama_filterMod").hasClass("is-invalid")){
            $("#nama_filterMod").removeClass("is-invalid");
            $("#nama_filterMod").removeClass("animation-shake");
            $('#error_nama').hide();
            $('#error_nama').html('');
        }
        this.value = this.value.replace(/[^0-9a-zA-Z]/g, '');
    });

    $(".row-list-order").on("click", ".btnSimpanResi", function(){
        var resi = $(this).parent().children("input");
        var id_order = resi.attr("data-id");
        var url = "{{route('b.order-proses')}}";
        var form = $("<form action='"+url+"' method='post'></form>");
        form.append('{{ csrf_field() }}');
        form.append('<input name="tipeKirim" value="update_resi">');
        form.append('<input name="id_order" value="'+id_order+'">');
        form.append('<input name="resi" value="'+resi.val()+'">');
        $('body').append(form);
        form.submit();
    });

    $(".btnRiwayatBayar").on("click", function(){
        var id_order = $(this).parent().parent().parent().attr("data-id");
        var urut_order = $(this).parent().parent().parent().attr("data-urut");
        if($("#dataBayar-"+id_order).text() != ""){
            var riwayat = jQuery.parseJSON($("#dataBayar-"+id_order).text()).riwayat;
            $("#modRiwayat-urutOrder").text(urut_order);
            $("#isiTabel-riwayat").html("");
            var totalBayar = uangToAngka($(".row-list-order[data-id="+id_order+"]").find(".total-bayar").text());
            var tTotal = 0;
            $.each(riwayat, function(i, v){
                tTotal += v.nominal;
                if(tTotal < totalBayar){
                    var badge = "<span class='badge badge-warning' style='font-size:15px;cursor:default'>CICIL</span>";
                } else if(tTotal == totalBayar){
                    var badge = "<span class='badge badge-success' style='font-size:15px;cursor:default'>LUNAS</span>";
                }
                var bank_via = v.via.split("|").length == 2 ? v.via.split("|")[1] : v.via.split("|")[0];
                $("#isiTabel-riwayat").append(
                    "<tr>"+
                        "<td>"+v.tgl_bayar+"</td>"+
                        "<td class='text-right'>Rp "+uangFormat(v.nominal)+"</td>"+
                        "<td>"+bank_via+"</td>"+
                        "<td class='text-right'>"+badge+"</td>"+
                    "</tr>"
                );
            });
        }
    });

    $(".btnTandaiTerima").on("click", function(){
        var id_order = $(this).parent().parent().parent().attr("data-id");
        var url = "{{route('b.order-proses')}}";
        var form = $("<form action='"+url+"' method='post'></form>");
        form.append('{{ csrf_field() }}');
        form.append('<input name="tipeKirim" value="tandai_terima">');
        form.append('<input name="id_order" value="'+id_order+'">');
        $('body').append(form);
        form.submit();
    });

    $('.btnBayarMod').on("click", function(){
        var orderId = $(this).attr("data-id");
        var urutOrder = $(this).attr("data-urut");
        $("#modBayar-orderId").text(orderId);
        $("#modBayar-urutOrder").text(urutOrder);
        if(document.querySelector('#toggleCicilan').checked){
            $('#toggleCicilan').trigger('click');
        }
        if($("#dataBayar-"+orderId).text() != ""){
            var data = $.parseJSON($("#dataBayar-"+orderId).text());
            var bank_via = data.bayar.via.split("|");
            if(bank_via.length == 2){
                var bank_via_tampil = bank_via[1];
                $('#btnViaBayar').data('idb', bank_via[0]);
            } else {
                var bank_via_tampil = bank_via[0];
            }
            $("#btnViaBayar").children(".filter-option").text(bank_via_tampil);
            $('#toggleCicilan').trigger('click');
            $('#toggleCicilan').prop("disabled", true);
            objSwitch.disable();
            $("#nominalDiv").show();
            if(data.riwayat.length > 0){
                $("#riwayatBayar").children("div").html("<label>Riwayat Pembayaran</label><ul></ul>");
                $.each(data.riwayat, function(i, v){
                    $("#riwayatBayar").children("div").children("ul").append(
                        "<li>"+v.tgl_bayar+"<span class='pl-80'>Rp "+uangFormat(v.nominal)+"</span></li>"
                    );
                });
                $("#riwayatBayar").show();
            }
        }
    });

    $("#bayarMod").on("click", "#btnSimpan", function(){
        var data = {};
        data.tgl_bayar = $("#tanggalBayar").val();
        if(typeof $("#btnViaBayar").data('idb') !== 'undefined'){
            var data_via_bayar = $("#btnViaBayar").data('idb')+"|"+$.trim($("#btnViaBayar").children(".filter-option").text());
        } else {
            var data_via_bayar = $.trim($("#btnViaBayar").children(".filter-option").text());
        }
        data.via = data_via_bayar;
        data.nominal = $("#bayarMod").find("#nominal").val();
        data.id_order = $("#modBayar-orderId").text();
        data.cicil_state = document.querySelector('#toggleCicilan').checked == "" ? "0" : document.querySelector('#toggleCicilan').checked;
        var resiDiv = $(".row-list-order[data-id="+data.id_order+"]").find(".resiDiv");
        if($.trim(resiDiv.text()) == "-" || resiDiv.length == 0){
            var cekResi = "false";
        } else {
            var cekResi = "true";
        }
        if(data.via != "-- Pilih Pembayaran --"){
            if((data.nominal == "" && !document.querySelector('#toggleCicilan').checked) || (data.nominal != "" && document.querySelector('#toggleCicilan').checked)){
                // console.log(data);
                var url = "{{route('b.order-proses')}}";
                var form = $("<form action='"+url+"' method='post'></form>");
                form.append('{{ csrf_field() }}');
                form.append('<input name="tipeKirim" value="update_bayar">');
                form.append('<input name="resiCek" value="'+cekResi+'">');
                form.append('<textarea name="dataRaw">'+JSON.stringify(data)+'</textarea>');
                $('body').append(form);
                form.submit();
            } else {
                alertify.warning('Isi nominal pembayaran!');
            }
        } else{
            alertify.warning('Pilih via pembayaran!');
        }
        // var dataLawas = $.parseJSON($("#dataBayar-"+$("#modBayar-orderId").text()).text()).bayar;
        // console.log(dataLawas);
    });

    @if(($ijin->cancelOrder === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner')
    $(".btnCancelOrder").on("click", function(){
        swal({
            title: "Peringatan",
            text: "Apakah anda yakin ingin meng-cancel data order ini?",
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
                var id_order = $(this).parent().parent().parent().parent().parent().attr("data-id");
                var url = "{{route('b.order-proses')}}";
                var form = $("<form action='"+url+"' method='post'></form>");
                form.append('{{ csrf_field() }}');
                form.append('<input name="tipeKirim" value="cancel_order">');
                form.append('<input name="id_order" value="'+id_order+'">');
                $('body').append(form);
                form.submit();
            }
        });
    });
    @endif

    $("#bayarMod").on('hidden.bs.modal', function() {
        $("#nominalDiv").hide();
        $("#tanggalBayar").datepicker('setDate', new Date());
        if(objSwitch.isDisabled()){
            objSwitch.enable();
            $('#toggleCicilan').trigger('click');
        }
        $("#riwayatBayar").children("div").html("");
        $("#riwayatBayar").hide();
        $("#nominal").val("");
        $("#btnViaBayar").children(".filter-option").text("-- Pilih Pembayaran --");
    });

    $("#btnCari").on("click", function(){
        var url = "{{route('b.order-search')}}";
        var form = $("<form action='"+url+"' method='get'></form>");
        form.append('<input name="tipe" value="'+$("#tipeCari").val()+'">');
        form.append('<input name="queryCari" value="'+$("#queryCari").val()+'">');
        $('body').append(form);
        form.submit();
    });

    $("#queryCari").keypress(function(e){
        if(e.keyCode == '13') {
            $("#btnCari").trigger("click");
        }
    });

    $(".btnLacakResi").click(function(){
        var url = "{{ route('b.order-lacakResi') }}/"+$(this).parent().parent().parent().data("id");
        $(location).attr('href', url);
    });

    $(".btnResi").click(function(){
        var url = "{{ route('b.order-trackResi') }}?ff="+$(this).parent().parent().parent().parent().parent().parent().data("id");
        $(location).attr('href', url);
    });

    document.querySelector('#toggleCicilan').onchange = function() {
        if ($(this).is(':checked')) {
            $('#nominalDiv').show();
        } else {
            $('#nominalDiv').hide();
            $("#nominal").val("");
        }
    };

    $("#viaBayar").on('input', '#nominal', function(event) {
        var id = $("#modBayar-orderId").text();
        var bayarKurang = $(".row-list-order[data-id="+id+"]").children(".row-list-order-body").find(".bayarStat").text() == "" ?
            0 : uangToAngka($.trim($(".row-list-order[data-id="+id+"]").children(".row-list-order-body").find(".bayarStat").text()).split(" ")[2], true);
        var bayarTotal = uangToAngka($(".row-list-order[data-id="+id+"]").children(".row-list-order-body").find(".total-bayar").text());
        this.value = this.value.replace(/[^0-9]/g, '');
        if(bayarKurang == 0){
            if(this.value > bayarTotal){
                this.value = bayarTotal;
            }
        } else {
            if(this.value > bayarKurang){
                this.value = bayarKurang;
            }
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

    // $('#filter-tanggalDari').datepicker({
    //     format: "dd MM yyyy",
    //     orientation: 'bottom'
    // });

    // $('#filter-tanggalSampai').datepicker({
    //     format: "dd MM yyyy",
    //     orientation: 'bottom'
    // });

    // $('.input-daterange input').each(function() {
        // $(this).datepicker({
        //     format: "dd M yyyy",
        //     orientation: 'bottom'
        // });
        // $(this).datepicker('clearDates');
    // });

    @if($msg_sukses = Session::get('msg_success'))
    window.setTimeout(function() {
        $('#alert-sukses').animate({
            height: 'toggle'
        }, 'slow');
    }, 5000);
    @endif

    @if($msg_error = Session::get('msg_error'))
    window.setTimeout(function() {
        $('#alert-error').animate({
            height: 'toggle'
        }, 'slow');
    }, 5000);
    @endif
});
</script>
<!-- modal update bayar-->
<div class="modal fade modal-fade-in-scale-up" id="bayarMod" aria-hidden="true" aria-labelledby="exampleModalTitle"
    role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTitle">Pembayaran (Order #<span id='modBayar-orderId' class='hidden'></span><span id='modBayar-urutOrder'></span>)</h4>
            </div>
            <div class="modal-body">
                <form id="form_pembayaran">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Tanggal Pembayaran</label>
                            <input type="text" class="form-control" id="tanggalBayar" name="tanggalbayar"/>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Toggle Cicilan</label><br>
                            <input type="checkbox" id="toggleCicilan" name="togglecicilan"/>
                        </div>
                    </div>
                    <div class="row" id='viaBayar'>
                        <div class="col-md-6 form-group">
                            <label>Pembayaran Via</label>
                            <div class="dropdown" style='width:100%'>
                                <button type="button" class="btn btn-default btn-outline text-right" id="btnViaBayar"
                                    data-toggle="dropdown" aria-expanded="true" style='width:100%'>
                                    <span class="filter-option pull-left">-- Pilih Pembayaran --</span>&nbsp;<span
                                        style='font-size:8px'>&#9660;</span>
                                </button>
                                <div class="dropdown-menu" role="menu" style='width:100%'>
                                    <a class="dropdown-item pilihViaBayar" href="javascript:void(0)" role="menuitem">
                                        <span>CASH</span>
                                    </a>
                                    {!! $bank_list !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group hidden" id='nominalDiv'>
                            <label>Nominal</label>
                            <input type="text" class="form-control" id="nominal" name="nominal"/>
                        </div>
                    </div>
                    <div class='row hidden' id='riwayatBayar'>
                        <div class='col-md-12 form-group'>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-primary" value='Simpan' name='btnSimpan' id='btnSimpan'>
                <button class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<!-- modal riwayat bayar-->
<div class="modal fade modal-fade-in-scale-up" id="riwayatMod" aria-hidden="true" aria-labelledby="exampleModalTitle"
    role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header" style='border-bottom: 1px solid #e4eaec;'>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTitle">Riwayat Pembayaran (Order #<span id='modRiwayat-urutOrder'></span><span id='modRiwayat-orderId' class='hidden'></span>)</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table" id="table_riwayatBayar">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th class='text-right'>Nominal</th>
                                <th>Via</th>
                                <th class='text-right'>Status</th>
                            </tr>
                        </thead>
                        <tbody id='isiTabel-riwayat'>
                            <tr>
                                <td colspan='4' class='text-center'>Kosong</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- modal nama filter-->
<div class="modal fade modal-fade-in-scale-up" id="filterMod" aria-hidden="true" aria-labelledby="exampleModalTitle"
    role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTitle">Simpan Filter</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label>Nama Filter</label>
                        <input type="text" class="form-control" id="nama_filterMod" name="nama_filter"/>
                        <small id="error_nama" class='hidden'></small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-success" value='Simpan' name='btnSimpan' id='btnSimpanFilterMod'>
                <button class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<!--uiop-->
@endsection