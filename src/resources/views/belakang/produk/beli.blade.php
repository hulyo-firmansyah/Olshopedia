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
            <div class='col-xxl-12 col-xl-12'>
                <div class="panel animation-slide-top" style='padding:10px;animation-delay:250ms;'>
                    <div class='uiop-ac-wrapper'>
                        <input type='text' class='form-control uiop-ac-search' style='height:40px;' id='cariProduk'
                            placeholder='Cari Produk'>
                        <div class='uiop-ac-option hidden'>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-12'>
                <div class="panel panel-bordered animation-slide-bottom" style='animation-delay:350ms;'>
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Pembelian Produk
                        </h3>
                    </div>
                    <div class='panel-body'>
                        <div class='row mb-15'>
                            <div class='col-xxl-5'>
                                <div class='row mb-10'>
                                    <div class='col-xxl-3'>
                                        <label for='nota_beli' style='width:110px;margin-top:7px'><b>No Nota : </b></label>
                                    </div>
                                    <div class='col-xxl-9'>
                                        <input type='text' name='nota_beli' id='nota_beli' class='form-control' placeholder='Nomer Nota'>
                                        <small id='error-nota_beli' style='color:red' class='hidden'>Tidak boleh kosong!</small>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-xxl-3'>
                                        <label for='tgl_beli' style='width:110px;margin-top:7px'><b>Tanggal Beli : </b></label>
                                    </div>
                                    <div class='col-xxl-9'>
                                        <input type='text' name='tgl_beli' id='tgl_beli' class='form-control' placeholder='Tanggal Beli'>
                                        <small id='error-tgl_beli' style='color:red' class='hidden'>Tidak boleh kosong!</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div  id='tableBeli'>
                            Tidak ada produk yang dipilih!
                        </div>
                    </div>
                    <div class='panel-footer hidden' id='beliDiv-btnSimpan'>
                        <button type='button' class='btn btn-success' data-color="green" data-style="expand-right" id='btnSimpanBeli' onClick='$(this).submitForm()'>Simpan Data Pembelian</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var cacheProduk = {};
var errorValidasi = 0;
var laddaBtn;

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

function parseNamaProduk(v){
    var nama_produk_tampil = v.nama_produk;
    if((v.ukuran != null && v.ukuran != "") && (v.warna != null && v.warna != "")){
        nama_produk_tampil += " ("+v.ukuran+" "+v.warna+") ";
    } else if((v.ukuran != null && v.ukuran != "") && (v.warna == null || v.warna == "")){
        nama_produk_tampil += " ("+v.ukuran+") ";
    } else if((v.ukuran == null || v.ukuran == "") && (v.warna != null && v.warna != "")){
        nama_produk_tampil += " ("+v.warna+") ";
    }
    return nama_produk_tampil;
}

function parseSupplierProduk(v, format = true){
    var cekStok = v.stok.split('|');
    var nama_produk_tampil = '';
    if(format){
        if(cekStok[1] == 'sendiri'){
            nama_produk_tampil += " <span class='orange-700'>[Stok Sendiri]</span> ";
        } else if(cekStok[1] == 'lain'){
            if(v.supplier.id !== null){
                nama_produk_tampil += " <span class='orange-700'>["+v.supplier.nama+"]</span> ";
            } else {
                nama_produk_tampil += " <span class='orange-700'>[</span><span style='color:black;'>?Terhapus?</span><span class='orange-700'>]</span> ";
            }
        }
    } else {
        if(cekStok[1] == 'sendiri'){
            nama_produk_tampil += "Stok Sendiri";
        } else if(cekStok[1] == 'lain'){
            if(v.supplier.id !== null){
                nama_produk_tampil += v.supplier.nama;
            } else {
                nama_produk_tampil += "[?Terhapus?]";
            }
        }
    }
    return nama_produk_tampil;
}

function parseProdukData(source, item, indexCache){
    $.each(source, function(i, v) {
        var nama_produk_tampil = parseNamaProduk(v) + parseSupplierProduk(v);
        if(v.foto != null && v.foto != ''){
            if(v.foto.utama != null){
                var foto = v.foto.utama;
            } else {
                var foto = '{{ asset("photo.png") }}';
            }
        } else {
            var foto = '{{ asset("photo.png") }}';
        }
        let varianCek = typeof $('#tableBeli').data('varian_id') === "undefined" ? [] : $('#tableBeli').data('varian_id');
        if(varianCek.indexOf(v.id_varian) !== -1){
            var btnTambahVarianTampil = '<div class="col-xxl-2 col-xl-3 col-lg-2 col-md-3 text-center" style="padding-top:18px" id="btn-'+v.id_varian+'">'+
                    '<i class="fa fa-check green-700"></i> <span class="green-700">Terpilih</span>'+
                '</div>';
        } else {
            var btnTambahVarianTampil = '<div class="col-xxl-2 col-xl-3 col-lg-2 col-md-3 text-center" style="padding-top:18px" id="btn-'+v.id_varian+'">'+
                    '<button type="button" class="btn btn-primary btn-sm btnPilihVarian"><i class="fa fa-plus"></i> Pilih Produk</button>'+
                '</div>';
        }
        var cekStok = v.stok.split('|');
        item.append(
            '<div class="row" style="margin:3px;padding:3px">'+
                '<textarea class="hidden">'+JSON.stringify(v)+'</textarea>'+
                '<input type="text" class="hidden" value="'+indexCache+'">'+
                '<div class="col-xxl-1 col-xl-1 col-lg-1 col-md-2 text-center">'+
                    '<img class="rounded" width="50" height="50" src="' + foto +'">'+
                '</div>'+
                '<div class="col-xxl-9 col-xl-8 col-lg-8 col-md-7">' +
                nama_produk_tampil +'<br>'+'Stok sisa <span class="green-700">'+cekStok[0]+'</span>'+
                '</div>'+
                btnTambahVarianTampil +
            '</div>');
    });
}

function hitungTotal(){
    let varianCek = typeof $('#tableBeli').data('varian_id') === "undefined" ? [] : $('#tableBeli').data('varian_id');
    if(varianCek.length > 0){
        let list = Array.prototype.slice.call($("#tableBeli-isi tr"));
        var total = 0;
        list.forEach(function(html) {
            let subTotal = $(html).children('td:nth-child(8)').data('total');
            total += subTotal;
        });
        $('#totalHarga').text('Rp '+uangFormat(total));
    }
}

function bersihError(){
    errorValidasi = 0;
    let list = Array.prototype.slice.call($("#tableBeli-isi tr"));
    list.forEach(function(html) {
        if($(html).find('input').hasClass('is-invalid')){
            $(html).find('small').hide();
            $(html).find('input').removeClass('animation-shake is-invalid');
        }
    });
}


(function(world) {

    world.fn.submitForm = function(tipeD) {
        if($("#tableBeli-isi tr").length < 1){
           return alertify.warning('Belum ada produk yang terpilih!').dismissOthers();
        }
        let list = Array.prototype.slice.call($("#tableBeli-isi tr"));
        var data = [];
        list.forEach(function(html) {
            let jumlah = $(html).find('input').val();
            let id = $(html).attr('id').split('-')[1];
            let harga = parseInt($(html).children('td:nth-child(7)').data('harga'));
            if(jumlah == ''){
                $(html).find('small').text('Tidak boleh kosong!');
                $(html).find('small').show();
                $(html).find('input').addClass('animation-shake is-invalid');
                errorValidasi++;
            } else if(jumlah < 1){
                $(html).find('small').text('Tidak boleh kurang dari 1!');
                $(html).find('small').show();
                $(html).find('input').addClass('animation-shake is-invalid');
                errorValidasi++;
            }
            data.push({
                id_varian: id,
                jumlah: jumlah,
                harga_satuan: harga
            });
        });
        var tgl = $('#tgl_beli').val();
        var nota = $('#nota_beli').val();
        if(tgl == ''){
            $('#error-tgl_beli').show();
            $('#tgl_beli').addClass('animation-shake is-invalid');
            errorValidasi++;
        }
        if(nota == ''){
            $('#error-nota_beli').show();
            $('#nota_beli').addClass('animation-shake is-invalid');
            errorValidasi++;
        }
        if(errorValidasi === 0){
            laddaBtn.start();
            var hasil;
            $.ajax({
                url: "{{ route('b.produk-beliProses') }}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: "{{ csrf_token() }}",
                    data: data,
                    tgl: tgl,
                    nota: nota,
                    tipe: 'tambah'
                },
                success: function(data) {
                    hasil = data;
                },
                error: function(xhr, b, c) {
                    swal("Error", '' + c, "error");
                }
            }).done(function() {
                laddaBtn.stop();
                if(hasil.status){
                    swal("Berhasil", ''+hasil.msg, "success").then(() => {
                        swal({
                            title: "Informasi",
                            text: "Apakah anda ingin mencetak data tersebut?",
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
                            dangerMode: false
                        }).then((will) => {
                            if (will) {
                                $(location).attr('href', '{{ route("b.produk-dataBeli_print") }}/'+hasil.id);
                            } else {
                                // alert(location.href);
                                // pageLoad('{{ route("b.produk-beli") }}');
                                $(location).attr('href', location.href);
                            }
                        });
                    });
                } else {
                    swal("Error", '' + hasil.msg, "error");
                }
            });
        }
    }
})(jQuery);

$(document).ready(function(){
    laddaBtn = Ladda.create( document.querySelector('#btnSimpanBeli') );

    @if($msg_sukses = Session::get('msg_success') || $msg_warning = Session::get('msg_warning') || $msg_error = Session::get('msg_error'))
    window.setTimeout(function() {
        $('.alert-semen').animate({
            height: 'toggle'
        }, 'slow');
    }, 8000);
    @endif

    $('#tgl_beli').datepicker({
        format: "dd MM yyyy",
        orientation: 'bottom'
    }).datepicker('setDate', new Date());
    
    alertify.set('notifier','position', 'top-right');

    $('#tgl_beli').on('change', function(){
        if($(this).hasClass('is-invalid')){
            $(this).removeClass('animation-shake is-invalid');
            $('#error-tgl_beli').hide();
            errorValidasi = 0;
        }
    });

    $('#nota_beli').on('input', function(){
        if($(this).hasClass('is-invalid')){
            $(this).removeClass('animation-shake is-invalid');
            $('#error-nota_beli').hide();
            errorValidasi = 0;
        }
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

    $('#tableBeli').on('click', '.btnBatalPilih', function(){
        let varianCek = typeof $('#tableBeli').data('varian_id') === "undefined" ? [] : $('#tableBeli').data('varian_id');
        let id = $(this).data('id');
        if(varianCek.length > 1){
            if($('#lp-'+id).length){
                $('#lp-'+id).remove();
            }
        } else {
            $('#tableBeli').text('Tidak ada produk yang dipilih!');
            $('#beliDiv-btnSimpan').hide();
        }
        varianCek = jQuery.grep(varianCek, function(value) {
            return value != id;
        });
        $('#tableBeli').data('varian_id', varianCek);
        if($('#btn-'+id).length){
            $('#btn-'+id).html('<button type="button" class="btn btn-primary btn-sm btnPilihVarian"><i class="fa fa-plus"></i> Pilih Produk</button>');
        }
        hitungTotal();
    });

    $('#tableBeli').on('input', '.angkaSaja', function(){
        this.value = this.value.replace(/[^0-9]/gi, '');
        let val = this.value;
        let harga = parseInt($(this).parent().parent().children('td:nth-child(7)').data('harga'));
        let divTotal = $(this).parent().parent().children('td:nth-child(8)');
        if(val != ''){
            let total = parseInt(val) * harga;
            divTotal.data('total', total);
            divTotal.text('Rp '+uangFormat(total));
        } else {
            divTotal.data('total', harga);
            divTotal.text('Rp '+uangFormat(harga));
        }
        hitungTotal();
        bersihError();
    });

    $('.uiop-ac-option').on('click', '.btnPilihVarian', function(){
        let data = jQuery.parseJSON($(this).parent().parent().children('textarea').val());
        // console.log(data);
        let varianCek = typeof $('#tableBeli').data('varian_id') === "undefined" ? [] : $('#tableBeli').data('varian_id');
        if(varianCek.indexOf(data.id_varian) !== -1){
           return alertify.warning('Produk tersebut sudah terpilih!').dismissOthers();
        }
        var cekStok = data.stok.split('|');
        if(cekStok[0] > 0){
            var stok = '<span class="green-700">'+uangFormat(cekStok[0])+'</span>';
        } else {
            var stok = '<span class="red-700">'+uangFormat(cekStok[0])+'</span>';
        }
        if(varianCek.length < 1){
            let tabel = 
                "<div class='table-responsive'>"+
                    "<table class='table table-bordered'>"+
                        "<thead>"+
                            "<tr>"+
                                "<td width='3%'><b>No</b></td>"+
                                "<td><b>SKU</b></td>"+
                                "<td><b>Nama Produk</b></td>"+
                                "<td><b>Supplier</b></td>"+
                                "<td width='7%'><b>Stok Sisa</b></td>"+
                                "<td width='10%'><b>Jumlah</b></td>"+
                                "<td><b>Harga Beli</b></td>"+
                                "<td><b>Subtotal</b></td>"+
                                "<td width='5%'><i class='fa fa-gear'></i></td>"+
                            "</tr>"+
                        "</thead>"+
                        "<tbody id='tableBeli-isi'>"+
                            "%!isi_tabel!%"+
                        "</tbody>"+
                        "<tfoot>"+
                            "<tr>"+
                                "<td colspan='7'><b class='float-right'>Total</b></td>"+
                                "<td id='totalHarga' colspan='2'>%!harga_awal!%</td>"+
                            "</tr>"+
                        "</tfoot>"+
                    "</table>"+
                "</div>";
            let data_produk = 
                '<tr id="lp-'+data.id_varian+'">'+
                    '<td>1</td>'+
                    '<td>'+data.sku+'</td>'+
                    '<td>'+parseNamaProduk(data)+'</td>'+
                    '<td>'+parseSupplierProduk(data, false)+'</td>'+
                    '<td>'+stok+'</td>'+
                    '<td><input type="text" class="form-control angkaSaja" value="1" placeholder="Jumlah"><small style="color:red" class="hidden"><br>Tidak boleh kosong!</small></td>'+
                    '<td data-harga="'+data.harga_beli+'">Rp '+uangFormat(data.harga_beli)+'</td>'+
                    '<td data-total="'+data.harga_beli+'">Rp '+uangFormat(data.harga_beli)+'</td>'+
                    '<td><button type="button" class="btnBatalPilih btn btn-danger btn-sm" data-id="'+data.id_varian+'">Batal</button></td>'+
                '</tr>';
            let renderTabel = tabel.replace('%!isi_tabel!%', data_produk).replace('%!harga_awal!%', 'Rp '+uangFormat(data.harga_beli));
            $('#tableBeli').data('varian_id', [data.id_varian]);
            $('#tableBeli').html(renderTabel);
        } else {
            let data_produk = 
                '<tr id="lp-'+data.id_varian+'">'+
                    '<td>'+(varianCek.length+1)+'</td>'+
                    '<td>'+data.sku+'</td>'+
                    '<td>'+parseNamaProduk(data)+'</td>'+
                    '<td>'+parseSupplierProduk(data, false)+'</td>'+
                    '<td>'+stok+'</td>'+
                    '<td><input type="text" class="form-control angkaSaja" value="1" placeholder="Jumlah"><small style="color:red" class="hidden"><br>Tidak boleh kosong!</small></td>'+
                    '<td data-harga="'+data.harga_beli+'">Rp '+uangFormat(data.harga_beli)+'</td>'+
                    '<td data-total="'+data.harga_beli+'">Rp '+uangFormat(data.harga_beli)+'</td>'+
                    '<td><button type="button" class="btnBatalPilih btn btn-danger btn-sm" data-id="'+data.id_varian+'">Batal</button></td>'+
                '</tr>';
            $('#tableBeli-isi').append(data_produk);
            let varian_now = $('#tableBeli').data('varian_id');
            varian_now.push(data.id_varian);
            $('#tableBeli').data('varian_id', varian_now);
        }
        $(this).parent().html('<i class="fa fa-check green-700"></i> <span class="green-700">Terpilih</span>');
        hitungTotal();
        $('#beliDiv-btnSimpan').show();
    });

});

</script>
<!--uiop-->
@endsection