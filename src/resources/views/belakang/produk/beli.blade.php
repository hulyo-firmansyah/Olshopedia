@extends('belakang.index')
@section('isi')
<!--uiop-->
<style>

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

.dropify-wrapper {
    width: 180px
}
</style>
<div class="page-header page-header-bordered">
    <div class='row'>
        <div class='col-md-6'>
            <h1 class="page-title font-size-26 font-weight-100">Pembelian Produk</h1>
        </div>
        <div class='col-md-6'>
            <div class="page-header-actions">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"
                        onClick="pageLoad('{{ route('b.dashboard') }}')">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);" onClick="pageLoad('{{ route('b.produk-index') }}')">Produk</a></li>
                    <li class="breadcrumb-item active">Pembelian Produk</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="page-content">
    <div class='container'>
        @if ($msg_sukses = Session::get('msg_success'))
        <div class='alert alert-success alert-semen' role='alert'><i class='fa fa-check'></i> SUCCESS: {{$msg_sukses}}</div>
        @endif
        @if ($msg_warning = Session::get('msg_warning'))
        <div class='alert alert-warning alert-semen' role='alert'><i class='fa fa-warning'></i> WARNING: {{$msg_warning}}</div>
        @endif
        @if ($msg_error = Session::get('msg_error'))
        <div class='alert alert-danger alert-semen' role='alert' id='al-error'><i class='fa fa-minus-circle'></i> <b>ERROR : </b> {{ $msg_error }}</div>
        @endif
        <div class='row'>
            <div class='col-xxl-10 col-xl-8'>
                <div class="panel animation-slide-left" style='padding:10px;animation-delay:250ms;'>
                    <div class='uiop-ac-wrapper'>
                        <input type='text' class='form-control uiop-ac-search' style='height:40px;' id='cariProduk'
                            placeholder='Cari Produk'>
                        <div class='uiop-ac-option hidden'>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-xxl-2 col-xl-4'>
                <div class="panel animation-slide-right text-center" style='padding:10px;animation-delay:300ms;'>
                    <button type='button' class='btn btn-success' onClick='pageLoad("{{ route("b.produk-tambah") }}")'><i class='fa fa-plus'></i> Tambah Produk</button>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-12'>
                <div class="panel panel-bordered animation-slide-bottom" style='animation-delay:350ms;'>
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Tambah Varian Produk
                        </h3>
                    </div>
                    <div class='panel-body'>
                        <div id='tambahVarianDiv-kosong'>
                            Tidak ada produk yang dipilih!
                        </div>
                        <form id="form_varian_tambah" method='post' action='{{ route("b.produk-beliProses") }}' enctype="multipart/form-data">
                            <div id='tambahVarianDiv-isi' class='hidden'>
                                <div class='float-right'>
                                    <button type='button' class='btn btn-danger' id='btnBatalTambahVarian'>Batal</button>
                                </div>
                                <textarea class='hidden'></textarea>
                                <div class='row'>
                                    <div class='col-lg-5'>
                                        <div class='row pb-10 pt-5' style='border-bottom:1px solid #e4eaec'>
                                            <div class='col-xxl-3 col-xl-5 col-lg-6 col-md-6'>
                                                <b>Nama Produk :</b>
                                            </div>
                                            <div class='col-xxl-9 col-xl-7 col-lg-6 col-md-6' id='nama_produk'>
                                                -
                                            </div>
                                        </div>
                                        <div class='row mt-5 pb-10 pt-5' style='border-bottom:1px solid #e4eaec'>
                                            <div class='col-xxl-3 col-xl-5 col-lg-6 col-md-6'>
                                                <b>Kategori :</b>
                                            </div>
                                            <div class='col-xxl-9 col-xl-7 col-lg-6 col-md-6' id='kategori'>
                                                -
                                            </div>
                                        </div>
                                        <div class='row mt-5 pb-10 pt-5' style='border-bottom:1px solid #e4eaec'>
                                            <div class='col-xxl-3 col-xl-5 col-lg-6 col-md-6'>
                                                <b>Supplier :</b>
                                            </div>
                                            <div class='col-xxl-9 col-xl-7 col-lg-6 col-md-6' id='supplier'>
                                                <i>-</i>
                                            </div>
                                        </div>
                                        <div class='row mt-5 pb-10 pt-5' style='border-bottom:1px solid #e4eaec'>
                                            <div class='col-xxl-3 col-xl-5 col-lg-6 col-md-6'>
                                                <b>Berat :</b>
                                            </div>
                                            <div class='col-xxl-9 col-xl-7 col-lg-6 col-md-6' id='berat'>
                                                -
                                            </div>
                                        </div>
                                        <div class='row mt-5 pb-10 pt-5' style='border-bottom:1px solid #e4eaec'>
                                            <div class='col-xxl-3 col-xl-5 col-lg-6 col-md-6'>
                                                <b>Keterangan :</b>
                                            </div>
                                            <div class='col-xxl-9 col-xl-7 col-lg-6 col-md-6' id='ket'>
                                                -
                                            </div>
                                        </div>
                                        <div class='row mt-5'>
                                            <div class='col-xxl-3'>
                                                <b>Daftar Varian :</b>
                                            </div>
                                        </div>
                                        <div class='row mt-5'>
                                            <div class='col-xxl-5'>
                                                <ul id='list_varian'>
                                                    <li>-</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="table-responsive">
                                            <table class="table table_varian" id="table_varian">
                                                <thead style='background:#3e8ef7'>
                                                    <tr>
                                                        <th style="color:white;width:190px" class='text-center'>Foto Produk</th>
                                                        <th style="color:white" class='text-center'>Spesifikasi</th>
                                                        <th style="color:white" colspan='2' class='text-center'>Harga</th>
                                                        <th style="color:white" class='varianDiv_all text-center'>Varian</th>
                                                        <th style="color:white;width:20px;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row varianDiv_all" style="">
                                    <div class="col-md-12 text-center form-group">
                                        <button type='button' class="btn btn-primary btn-outline" id="btnTambahVarianData"><i class='fa fa-plus'></i> Varian</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class='panel-footer hidden' id='tambahVarianDiv-btnSimpan'>
                        <button type='button' class='btn btn-primary' id='btnSimpanVarian' onClick='$(this).submitForm()'>Simpan Varian</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var cacheProduk = {};
var iAkhir_varian = iJumlah_varian = 0;
var varianProduk = [];
var tDiskon = false,
    tTipeDiskon = false,
    tStok = false,
    tWarna = false,
    tUkuran = false;
var offset_prod = '';
var errorValidasi = 0;

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

function tambahForm(offset_prod, callback_ = null){
    var hasil, tU, tW, tD, tR, tTD, tS, hasil2;
    iAkhir_varian++;
    tU = (tUkuran === false) ? "display:none" : "";
    tW = (tWarna === false) ? "display:none" : "";
    tD = (tDiskon === false) ? "display:none" : "";
    tR = "";
    tTD = (tTipeDiskon === false) ? "display:none" : "";
    tS = (tStok === false) ? "input" : "select";
    $.ajax({
        url: "{{ route('b.produk-tambahForm') }}",
        data: {
            i: iAkhir_varian,
            ic_ukuran: tU,
            ic_warna: tW,
            ic_diskon: tD,
            ic_reseller: tR,
            ic_tipe_diskon: tTD,
            ic_stok: tS,
            offset_prod: offset_prod
        },
        type: 'get',
        beforeSend: function() {
            $('#btnTambahVarianData').prop('disabled', function(i, v) {
                return !v;
            });
            $('#table_varian').children('tbody').append(
                "<tr id='loader'><td colspan='6'><div class='example-loading example-well h-150 vertical-align text-center'><div class='loader vertical-align-middle loader-ellipsis'></div></div></td></tr>"
            );
        },
        success: function(data) {
            hasil = data;
        }
    }).done(function() {
        $.ajax({
            url: "{{ route('b.produk-tambahModalFoto') }}",
            data: {
                i: iAkhir_varian
            },
            type: 'get',
            success: function(data2) {
                hasil2 = data2;
            }
        }).done(function() {
            $('#table_varian').children('tbody').children('#loader').remove();
            $('#table_varian').children('tbody').append(hasil);
            $('.page').append(hasil2);
            $('#btnTambahVarianData').prop('disabled', function(i, v) {
                return !v;
            });
            $('#stok-' + iAkhir_varian).selectpicker({
                style: 'btn-outline btn-default'
            });
            $('#hVarian-' + iAkhir_varian).tooltip({
                trigger: 'hover',
                title: 'Hapus Varian',
                placement: 'left'
            });
            for(var ys=1; ys<=7; ys++){
                $('#foto_' + iAkhir_varian + '-' + ys).dropify({
                    // defaultFile: "{{ asset('template/assets/images/default.jpg') }}",
                    height: 176,
                    errorsPosition: 'outside',
                    messages: {
                        'default': 'Drag and drop a file here or click',
                        'replace': 'Drag and drop or click to replace',
                        'remove': '<i class="fa fa-trash"></i>',
                        'error': 'Ooops, something wrong happended.'
                    },
                    error: {
                        'fileSize': 'The file size is too big ({value} max).',
                        'minWidth': 'The image width is too small ({value}px min).',
                        'maxWidth': 'The image width is too big ({value}px max).',
                        'minHeight': 'The image height is too small ({value}px min).',
                        'maxHeight': 'The image height is too big ({value}px max).',
                        'imageFormat': 'The image format is not allowed ({value} only).'
                    }
                });
            }
            if(callback_ !== null) callback_();
        });
        iJumlah_varian++;
        varianProduk.push(iAkhir_varian);
    });
}

function parseProdukData(source, item, indexCache){
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
        // console.log(v);
        var cekStok = v.stok.split('|');
        if(cekStok[1] == 'sendiri'){
            if(v.produk_id == $('#tambahVarianDiv-isi').data('produk_id')){
                var btnTambahVarianTampil = '<div class="col-xxl-2 col-xl-3 col-lg-2 col-md-3 text-center" style="padding-top:18px">'+
                        '<i class="fa fa-check green-700"></i>'+
                    '</div>';
            } else {
                var btnTambahVarianTampil = '<div class="col-xxl-2 col-xl-3 col-lg-2 col-md-3 text-center" style="padding-top:18px">'+
                        '<button type="button" class="btn btn-primary btn-sm btnTambahVarian"><i class="fa fa-plus"></i> Tambah Varian</button>'+
                    '</div>';
            }
            item.append(
                '<div class="row" style="margin:3px;padding:3px">'+
                    '<textarea class="hidden">'+JSON.stringify(v)+'</textarea>'+
                    '<input type="text" class="hidden" value="'+indexCache+'">'+
                    '<div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1 text-center">'+
                        '<img class="rounded" width="50" height="50" src="' + foto +'">'+
                    '</div>'+
                    '<div class="col-xxl-6 col-xl-5 col-lg-6 col-md-4">' +
                    nama_produk_tampil +'<br>'+'Stok sisa <span class="green-700">'+cekStok[0]+'</span>'+
                    '</div>'+
                    '<div class="col-xxl-2 col-xl-3 col-lg-2 col-md-3 text-center" style="padding-top:18px">'+
                        '<button type="button" class="btn btn-info btn-sm btnTambahStok"><i class="fa fa-plus"></i> Tambah Stok</button>'+
                    '</div>' +
                    btnTambahVarianTampil +
                '</div>');
        } else if(cekStok[1] == 'lain' && parseInt(cekStok[0]) === 0){
            if(v.produk_id == $('#tambahVarianDiv-isi').data('produk_id')){
                var btnTambahVarianTampil = '<div class="col-xxl-2 col-xl-3 col-lg-2 col-md-3 text-center" style="padding-top:18px">'+
                        '<i class="fa fa-check green-700"></i>'+
                    '</div>';
            } else {
                var btnTambahVarianTampil = '<div class="col-xxl-2 col-xl-3 col-lg-2 col-md-3 text-center" style="padding-top:18px">'+
                        '<button type="button" class="btn btn-primary btn-sm btnTambahVarian"><i class="fa fa-plus"></i> Tambah Varian</button>'+
                    '</div>';
            }
            item.append(
                '<div class="row" style="margin:3px;padding:3px">'+
                    '<textarea class="hidden">'+JSON.stringify(v)+'</textarea>'+
                    '<input type="text" class="hidden" value="'+indexCache+'">'+
                    '<div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1 text-center">'+
                        '<img class="rounded" width="50" height="50" src="' + foto +'">'+
                    '</div>'+
                    '<div class="col-xxl-6 col-xl-5 col-lg-6 col-md-4">' +
                    nama_produk_tampil +'<br>'+'<span class="red-600">Stok Habis</span>'+
                    '</div>'+
                    '<div class="col-xxl-2 col-xl-3 col-lg-2 col-md-3 text-center" style="padding-top:18px">'+
                        '<button type="button" class="btn btn-info btn-sm btnUbahStok"><i class="fa fa-pencil"></i> Ubah Stok</button>'+
                    '</div>' +
                    btnTambahVarianTampil +
                '</div>');
        }
    });
}


(function(world) {
    world.fn.hapusVarian = function(id_varian) {
        if (iJumlah_varian > 1) {
            var id = id_varian.split('-');
            $('#hVarian-' + id[1]).tooltip('dispose');
            $('#idVarian-' + id[1]).remove();
            $('#modTambahFoto-' + id[1]).remove();
            var t_id = varianProduk.indexOf(parseInt(id[1]));
            varianProduk.splice(t_id, 1);
            iJumlah_varian--;
        }
    }

    world.fn.bersihError = function(elm = this) {
        $(this).attr('class', 'form-control');
        if (elm == 'berat') {
            $(this).parent().parent().children('small').attr('class', '');
            $(this).parent().parent().children('small').empty();
        } else {
            $(this).parent().children('small').attr('class', '');
            $(this).parent().children('small').empty();
        }
    }

    world.fn.submitForm = function(tipeD) {
        var data = $('#form_varian_tambah').serializeArray();
        var cekSupplier = $('#tambahVarianDiv-isi').data('tipe') == 'lain' ? true : false;
        var varian_data = ['harga_beli]', 'diskon]', 'harga_jual]', 'harga_reseller]', 'ukuran]', 'warna]'];
        // console.log(data);
        // return;
        $.each(data, function(i, d) {
            var varian = d.name.split('[');
            $.each(varian_data, function(iV, dV) {
                if (varian[2] == dV) {
                    var iQ = varian[1].split(']');
                    if (dV == 'harga_beli]' && d.value == '') {
                        $('#harga_beli-' + iQ[0]).attr('class',
                            'form-control is-invalid animation-shake');
                        $('small#error_harga_beli-' + iQ[0]).show();
                        $('small#error_harga_beli-' + iQ[0]).attr('class',
                            'invalid-feedback');
                        $('small#error_harga_beli-' + iQ[0]).html((cekSupplier == false ? 'Harga Beli' : 'Harga Bayar ke Supplier')+' tidak boleh kosong!');
                        errorValidasi++;
                    }
                    if (dV == 'harga_beli]' && d.value != '' && parseInt(d.value) > 1000000000) {
                        $('#harga_beli-' + iQ[0]).attr('class',
                            'form-control is-invalid animation-shake');
                        $('small#error_harga_beli-' + iQ[0]).show();
                        $('small#error_harga_beli-' + iQ[0]).attr('class',
                            'invalid-feedback');
                        $('small#error_harga_beli-' + iQ[0]).html((cekSupplier == false ? 'Harga Beli' : 'Harga Bayar ke Supplier')+' tidak boleh lebih dari 1.000.000.000!');
                        errorValidasi++;
                    }
                    if (dV == 'harga_jual]' && d.value == '') {
                        $('#harga_jual-' + iQ[0]).attr('class',
                            'form-control is-invalid animation-shake');
                        $('small#error_harga_jual-' + iQ[0]).show();
                        $('small#error_harga_jual-' + iQ[0]).attr('class',
                            'invalid-feedback');
                        $('small#error_harga_jual-' + iQ[0]).html(
                            'Harga Jual tidak boleh kosong!');
                        errorValidasi++;
                    }
                    if (dV == 'harga_jual]' && d.value != '' && parseInt(d.value) > 1000000000) {
                        $('#harga_jual-' + iQ[0]).attr('class',
                            'form-control is-invalid animation-shake');
                        $('small#error_harga_jual-' + iQ[0]).show();
                        $('small#error_harga_jual-' + iQ[0]).attr('class',
                            'invalid-feedback');
                        $('small#error_harga_jual-' + iQ[0]).html(
                            'Harga Jual tidak boleh lebih dari 1.000.000.000!');
                        errorValidasi++;
                    }
                    if (dV == 'stok]' && d.value != '' && parseInt(d.value) > 1000000) {
                        $('#stok-' + iQ[0]).attr('class',
                            'form-control is-invalid animation-shake');
                        $('small#error_stok-' + iQ[0]).show();
                        $('small#error_stok-' + iQ[0]).attr('class',
                            'invalid-feedback');
                        $('small#error_stok-' + iQ[0]).html(
                            'Stok tidak boleh lebih dari 1.000.000!');
                        errorValidasi++;
                    }
                }
            });
        });
        if (errorValidasi === 0) {
            $.each(varianProduk, (iaa, tya) => {
                $('#form_varian_tambah').append($("#foto_"+tya+"-1").addClass("hidden"));
                $('#form_varian_tambah').append($("#foto_"+tya+"-2").addClass("hidden"));
                $('#form_varian_tambah').append($("#foto_"+tya+"-3").addClass("hidden"));
                $('#form_varian_tambah').append($("#foto_"+tya+"-4").addClass("hidden"));
                $('#form_varian_tambah').append($("#foto_"+tya+"-5").addClass("hidden"));
                $('#form_varian_tambah').append($("#foto_"+tya+"-6").addClass("hidden"));
                $('#form_varian_tambah').append($("#foto_"+tya+"-7").addClass("hidden"));
            });
            $('#form_varian_tambah').append('<input type="text" value="{{ csrf_token() }}" class="hidden" name="_token">');
            $('#form_varian_tambah').append('<input type="text" value="tambah_varian" class="hidden" name="tipe">');
            $('#form_varian_tambah').append('<input type="text" value="'+$('#tambahVarianDiv-isi').data('produk_id')+'" class="hidden" name="produk_id">');
            $('#form_varian_tambah').append('<input type="text" value="'+$('#tambahVarianDiv-isi').data('tipe')+'" class="hidden" name="tipe_supplier">');
            $('#form_varian_tambah').append('<input type="text" value="'+(tTipeDiskon === true ? 'persen' : 'langsung')+'" class="hidden" name="tipe_diskon">');
            // console.log($('#form_varian_tambah').serializeArray());
            $('#form_varian_tambah').submit();
        }
        console.log(errorValidasi);
    }
})(jQuery);

$(document).ready(function(){

    @if($msg_sukses = Session::get('msg_success') || $msg_warning = Session::get('msg_warning') || $msg_error = Session::get('msg_error'))
    window.setTimeout(function() {
        $('.alert-semen').animate({
            height: 'toggle'
        }, 'slow');
    }, 8000);
    @endif
    
    alertify.set('notifier','position', 'top-right');
    
    for(var i=1; i<=7; i++){
        $('#foto_1-'+i).dropify({
            // defaultFile: "{{ asset('template/assets/images/default.jpg') }}",
            height: 166,
            errorsPosition: 'outside',
            messages: {
                'default': 'Drag and drop a file here or click',
                'replace': 'Drag and drop or click to replace',
                'remove': '<i class="fa fa-trash"></i>',
                'error': 'Ooops, something wrong happended.'
            },
            error: {
                'fileSize': 'The file size is too big ({value} max).',
                'minWidth': 'The image width is too small ({value}px min).',
                'maxWidth': 'The image width is too big ({value}px max).',
                'minHeight': 'The image height is too small ({value}px min).',
                'maxHeight': 'The image height is too big ({value}px max).',
                'imageFormat': 'The iowed ({value} only).'
            }
        });
    }
    
    $('#hVarian-1').tooltip({
        trigger: 'hover',
        title: 'Hapus Varian',
        placement: 'left'
    });

    $('#stok-ubahStok').selectpicker({
        style: 'btn-outline btn-default'
    });

    $("#table_varian").on("input", "input[data-rex=number]", function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
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
                    parseProdukData(cacheProduk[cari_prod.replace(/[^a-zA-Z]/gi, '_')], item_prod, cari_prod.replace(/[^a-zA-Z]/gi, '_'));
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
                        // console.log(data);
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
                        parseProdukData(hasilResp, item_prod, cari_prod.replace(/[^a-zA-Z]/gi, '_'));
                    }
                });
            }
        } else {
            item_prod.html('');
            item_prod.hide();
        }
    });

    $(".spin").TouchSpin({
        min: 1,
        max: 100000,
        initval: 1,
        buttondown_class: "btn btn-info btn-outline",
        buttonup_class: "btn btn-info btn-outline"
    });

    $('.uiop-ac-option').on('click', '.btnTambahStok', function(){
        let data = jQuery.parseJSON($(this).parent().parent().children('textarea').val());
        if(data.stok.split('|')[1] == 'sendiri'){
            if($('#tambahVarianDiv-isi').is(':hidden') && typeof $('#tambahVarianDiv-isi').data('id_varian') === 'undefined'){
                if(data.foto != null && data.foto != ''){
                    if(v.foto.utama != null){
                        var foto = data.foto.utama;
                    } else {
                        var foto = '{{ asset("photo.png") }}';
                    }
                } else {
                    var foto = '{{ asset("photo.png") }}';
                }
                let stok_lama = data.stok.split('|')[0];
                $('#foto-tambahStok').attr('src', foto);
                $('#nama-tambahStok').text(data.nama_produk);
                $('#stok-tambahStok').text(stok_lama);
                $('#btn-tambahStok').data('id', data.id_varian);
                $('#btn-tambahStok').data('stok_lama', stok_lama);
                $('#btn-tambahStok').data('index_cache', $(this).parent().parent().children('input').val());
                $('#modTambahStok').modal('show');
            } else {
                alertify.warning('Silahkan batalkan Tambah Varian terlebih dahulu!').dismissOthers();
            }
        } else {
            alertify.warning('Anda melakukan hal yang semestinya!').dismissOthers();
        }
    });

    $('.uiop-ac-option').on('click', '.btnUbahStok', function(){
        let data = jQuery.parseJSON($(this).parent().parent().children('textarea').val());
        if(data.stok.split('|')[1] == 'lain'){
            if($('#tambahVarianDiv-isi').is(':hidden') && typeof $('#tambahVarianDiv-isi').data('id_varian') === 'undefined'){
                if(data.foto != null && data.foto != ''){
                    if(v.foto.utama != null){
                        var foto = data.foto.utama;
                    } else {
                        var foto = '{{ asset("photo.png") }}';
                    }
                } else {
                    var foto = '{{ asset("photo.png") }}';
                }
                let stok_lama = data.stok.split('|')[0];
                $('#foto-ubahStok').attr('src', foto);
                $('#nama-ubahStok').text(data.nama_produk);
                $('#btn-ubahStok').data('id', data.id_varian);
                $('#btn-ubahStok').data('index_cache', $(this).parent().parent().children('input').val());
                $('#modUbahStok').modal('show');
            } else {
                alertify.warning('Silahkan batalkan Tambah Varian terlebih dahulu!').dismissOthers();
            }
        } else {
            alertify.warning('Anda melakukan hal yang semestinya!').dismissOthers();
        }
    });

    $('.uiop-ac-option').on('click', '.btnTambahVarian', function(){
        let data = jQuery.parseJSON($(this).parent().parent().children('textarea').val());
        var hasil = '';
        var hasil_offset = '';
        if($('#tambahVarianDiv-isi').is(':hidden') && typeof $('#tambahVarianDiv-isi').data('id_varian') === 'undefined'){
            $.ajax({
                url: "{{ route('b.ajax-getProdukById') }}",
                type: 'get',
                data: {
                    id: data.produk_id,
                },
                beforeSend: function(){
                    $('#tambahVarianDiv-kosong').addClass('text-center');
                    $('#tambahVarianDiv-kosong').html('<div class="loader vertical-align-middle loader-cube-grid"></div>');
                },
                success: function(data) {
                    hasil = data;
                },
                error: function(a, b, c) {
                    $('#tambahVarianDiv-kosong').removeClass('text-center');
                    $('#tambahVarianDiv-kosong').html(''+c)
                }
            }).done(function() {
                $.ajax({
                    url: "{{ route('b.ajax-getOffsetProdukAkhirById') }}",
                    type: 'get',
                    data: {
                        id: data.produk_id,
                    },
                    success: function(data) {
                        hasil_offset = data;
                    },
                    error: function(a, b, c) {
                        $('#tambahVarianDiv-kosong').removeClass('text-center');
                        $('#tambahVarianDiv-kosong').html(''+c)
                    }
                }).done(function(){
                    offset_prod = 'P'+hasil_offset.offset.produk+'V'+(hasil_offset.offset.sku);
                    iAkhir_varian = hasil_offset.offset.sku;

                    $('#nama_produk').text(data.nama_produk);
                    if(data.kategori.nama !== null && data.kategori.nama !== ''){
                        $('#kategori').text(data.kategori.nama);
                    } else {
                        $('#kategori').html('<i>Tidak Berkategori</i>');
                    }
                    if(data.supplier.nama !== null && data.supplier.nama !== ''){
                        $('#supplier').text(data.supplier.nama);
                        tStok = true;
                    } else {
                        $('#supplier').html('<i>Stok Sendiri</i>');
                        tStok = false;
                    }
                    $('#berat').text(uangFormat(data.berat)+' Gram');
                    if(data.ket !== null && data.ket !== ''){
                        $('#ket').text(data.ket);
                    } else {
                        $('#ket').html('-');
                    }

                    $('#list_varian').text('');
                    // console.log(hasil);
                    $.each(hasil, (i, v) => {
                        var tampilVarian = '<li>'+v.sku+' &nbsp;&nbsp;';
                        if((v.ukuran != null && v.ukuran != "") && (v.warna != null && v.warna != "")){
                            tampilVarian += '('+v.ukuran+' '+v.warna+')</li>';
                            tWarna = true;
                            tUkuran = true;
                        } else if((v.ukuran != null && v.ukuran != "") && (v.warna == null || v.warna == "")){
                            tampilVarian += '('+v.ukuran+')</li>';
                            tWarna = false;
                            tUkuran = true;
                        } else if((v.ukuran == null || v.ukuran == "") && (v.warna != null && v.warna != "")){
                            tampilVarian += '('+v.warna+')</li>';
                            tWarna = true;
                            tUkuran = false;
                        } else {
                            tWarna = true;
                            tUkuran = true;
                        }
                        $('#list_varian').append(tampilVarian);
                    });

                    if(data.diskon_jual !== null){
                        tDiskon = true;
                        if(data.diskon_jual.split('|')[1] == '%'){
                            tTipeDiskon = true;
                        } else {
                            tTipeDiskon = false;
                        }
                    } else {
                        tDiskon = false;
                    }

                    $('#table_varian').children('tbody').html('');
                    
                    tambahForm(offset_prod.split('V')[0], function(){
                        
                        $('#idVarian-'+(parseInt(offset_prod.split('V')[1])+1)).attr('class', 'varianDiv_tetap');

                        $('#tambahVarianDiv-isi').children('textarea').val(JSON.stringify(data));
                        $('#tambahVarianDiv-isi').data('tipe', data.stok.split('|')[1]);
                        $('#tambahVarianDiv-isi').data('produk_id', data.produk_id);
                        $('#tambahVarianDiv-isi').data('id_varian', data.id_varian);

                        $('#tambahVarianDiv-kosong').hide();
                        $('#tambahVarianDiv-kosong').removeClass('text-center');
                        $('#tambahVarianDiv-kosong').html('');
                        $('#tambahVarianDiv-isi').show();
                        $('#tambahVarianDiv-btnSimpan').show();
                        $('.uiop-ac-option').html('');
                        $('.uiop-ac-option').hide();
                        $('#cariProduk').val('');
                    });
                });
            });
        } else {
            alertify.warning('Sudah ada yang terpilih, silahkan batalkan terlebih dahulu!').dismissOthers();
        }
    });

    $('.uangFormat').on('input', function(){
        this.value = this.value.replace(/[^0-9]/gi, '');
    });

    $('#btn-tambahStok').on('click', function(){
        var indexCache = $(this).data('index_cache');
        var hasil = '';
        var id = $(this).data('id');
        var stok_lama = $(this).data('stok_lama');
        var jumlah = $('#jumlah-tambahStok').val();
        if(jumlah > 100000 || jumlah < 1){
            alertify.warning('Stok yang ditambah tidak boleh lebih dari 100,000 atau kurang dari 1!').dismissOthers();
        } else {
            $.ajax({
                url: "{{ route('b.produk-beliProses') }}",
                type: 'post',
                data: {
                    id: id,
                    stok_lama: stok_lama,
                    jumlah: jumlah,
                    tipe: 'tambah_stok',
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    hasil = data;
                },
                error: function(a, b, c) {
                    swal("Error", '' + c, "error");
                }
            }).done(function() {
                if(hasil.status){
                    swal("Berhasil!", "" + hasil.msg, "success");
                } else {
                    swal("Error", '' + hasil.msg, "error");
                }
                $('#modTambahStok').modal('hide');
                if(indexCache in cacheProduk){
                    delete cacheProduk[indexCache];
                }
                $('.uiop-ac-option').html('');
                $('.uiop-ac-option').hide();
                $('#cariProduk').val('');
                $('#jumlah-tambahStok').val(1);
            });
        }
    });

    $('#btn-ubahStok').on('click', function(){
        var indexCache = $(this).data('index_cache');
        var hasil = '';
        var id = $(this).data('id');
        var stok = $('#stok-ubahStok').val();
        // console.log(stok);
        if(stok === null || stok != 1){
            alertify.warning('Stok hanya bisa dirubah ke Tersedia!').dismissOthers();
        } else {
            $.ajax({
                url: "{{ route('b.produk-beliProses') }}",
                type: 'post',
                data: {
                    id: id,
                    stok: parseInt(stok),
                    tipe: 'ubah_stok',
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    hasil = data;
                },
                error: function(a, b, c) {
                    swal("Error", '' + c, "error");
                }
            }).done(function() {
                if(hasil.status){
                    swal("Berhasil!", "" + hasil.msg, "success");
                } else {
                    swal("Error", '' + hasil.msg, "error");
                }
                $('#modUbahStok').modal('hide');
                if(indexCache in cacheProduk){
                    delete cacheProduk[indexCache];
                }
                $('.uiop-ac-option').html('');
                $('.uiop-ac-option').hide();
                $('#cariProduk').val('');
                $('#stok-ubahStok').selectpicker('val', '0');
            });
        }
    });

    $('#btnBatalTambahVarian').on('click', function(){
        if(!$('#tambahVarianDiv-isi').is(':hidden') && typeof $('#tambahVarianDiv-isi').data('id_varian') !== 'undefined'){
            $('#tambahVarianDiv-isi').children('textarea').val('');
            $('#tambahVarianDiv-isi').removeData('produk_id');
            $('#tambahVarianDiv-isi').removeData('id_varian');
            $('#tambahVarianDiv-isi').removeData('tipe');

            $('#nama_produk').text('-');
            $('#kategori').text('-');
            $('#supplier').text('-');
            $('#berat').text('-');
            $('#ket').text('-');
            $('#list_varian').text('');

            $('#tambahVarianDiv-kosong').show();
            $('#tambahVarianDiv-kosong').removeClass('text-center');
            $('#tambahVarianDiv-kosong').html('Tidak ada produk yang dipilih!');
            $('#tambahVarianDiv-isi').hide();
            $('#tambahVarianDiv-btnSimpan').hide();
            $('.uiop-ac-option').html('');
            $('.uiop-ac-option').hide();
            $('#cariProduk').val('');
        }
    });

    $('#btnTambahVarianData').on('click', function(){
        if(!$('#tambahVarianDiv-isi').is(':hidden') && typeof $('#tambahVarianDiv-isi').data('id_varian') !== 'undefined'){
            tambahForm(offset_prod.split('V')[0]);
        }
    });

});

</script>

<!-- modal tambah stok-->
<div class="modal fade modal-fade-in-scale-up" id="modTambahStok" aria-hidden="true" aria-labelledby="exampleModalTitle"
    role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTitle">Tambah Stok Produk</h4>
            </div>
            <div class="modal-body">
                <div class='text-center'>
                    <img class='rounded' width='150' height='150' src='{{ asset("photo.png") }}' id='foto-tambahStok'>
                </div>
                <div class='row mt-15 ml-5 mr-100'>
                    <div class='col-sm-6 mt-10 text-right'>
                        Nama
                    </div>
                    <div class='col-sm-6 mt-10' id='nama-tambahStok'>
                    </div>
                </div>
                <div class='row mt-15 ml-5 mr-100'>
                    <div class='col-sm-6 mt-10 text-right'>
                        Stok Sekarang
                    </div>
                    <div class='col-sm-6 mt-10' id='stok-tambahStok'>
                    </div>
                </div>
                <div class='row mt-15 ml-5 mr-100'>
                    <div class='col-sm-6 mt-10 text-right'>
                        Stok yang bertambah
                    </div>
                    <div class='col-sm-6'>
                        <input name="jumlah-tambahStok" type="text" style="border-color:#28c0de"
                            class="form-control uangFormat spin" id='jumlah-tambahStok'>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-info" id='btn-tambahStok' href='javascript:void(0)'>Tambah Stok</a>
                <button class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- modal ubah stok-->
<div class="modal fade modal-fade-in-scale-up" id="modUbahStok" aria-hidden="true" aria-labelledby="exampleModalTitle"
    role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTitle">Ubah Stok Produk</h4>
            </div>
            <div class="modal-body">
                <div class='text-center'>
                    <img class='rounded' width='150' height='150' src='{{ asset("photo.png") }}' id='foto-ubahStok'>
                </div>
                <div class='row mt-15 ml-5 mr-100'>
                    <div class='col-sm-6 mt-10 text-right'>
                        Nama
                    </div>
                    <div class='col-sm-6 mt-10' id='nama-ubahStok'>
                    </div>
                </div>
                <div class='row mt-15 ml-5 mr-100'>
                    <div class='col-sm-6 mt-10 text-right'>
                        Stok
                    </div>
                    <div class='col-sm-6'>
                        <select id='stok-ubahStok' name='stok-ubahStok'>
                            <option value='0' disabled selected>Habis</option>
                            <option value='1'>Tersedia</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-info" id='btn-ubahStok' href='javascript:void(0)'>Ubah Stok</a>
                <button class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- modal tambah foto 1 -->
<div class="modal fade" id="modTambahFoto-1" aria-hidden="true" aria-labelledby="exampleModalTitle"
    role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTabs">Tambah Foto</h4>
            </div>
            <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab" href="#tabFoto_1-utama" aria-controls="tabFoto_1-utama" role="tab">Utama</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#tabFoto_1-lain" aria-controls="tabFoto_1-lain" role="tab">Lainnya</a></li>
            </ul>
            <div class="modal-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tabFoto_1-utama" role="tabpanel">
                        <center>
                            <input type="file" id="foto_1-1" accept='.jpeg,.jpg,.png,.gif' name='produk[1][foto][1]'>
                        </center>
                    </div>
                    <div class="tab-pane" id="tabFoto_1-lain" role="tabpanel">
                        <center>
                            <div class='d-inline-flex'>
                                <input type="file" id="foto_1-2" accept='.jpeg,.jpg,.png,.gif' name='produk[1][foto][2]'>
                                <input type="file" id="foto_1-3" accept='.jpeg,.jpg,.png,.gif' name='produk[1][foto][3]'>
                                <input type="file" id="foto_1-4" accept='.jpeg,.jpg,.png,.gif' name='produk[1][foto][4]'>
                            </div>
                            <div class='d-inline-flex mt-15'>
                                <input type="file" id="foto_1-5" accept='.jpeg,.jpg,.png,.gif' name='produk[1][foto][5]'>
                                <input type="file" id="foto_1-6" accept='.jpeg,.jpg,.png,.gif' name='produk[1][foto][6]'>
                                <input type="file" id="foto_1-7" accept='.jpeg,.jpg,.png,.gif' name='produk[1][foto][7]'>
                            </div>
                        </center>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!--uiop-->
@endsection