@extends('belakang.index')
@section('isi')
<!--uiop-->
<div class="page-header page-header-bordered">
    <div class='row'>
        <div class='col-md-6'>
            <h1 class="page-title font-size-26 font-weight-100">Preview Import Produk</h1>
        </div>
        <div class='col-md-6'>
            <div class="page-header-actions">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"
                        onClick="pageLoad('{{ route('b.dashboard') }}')">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);"
                        onClick="pageLoad('{{ route('b.produk-index') }}')">Produk</a></li>
                    <li class="breadcrumb-item active">Preview Import Produk</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="page-content">
    @if ($data['json'] === false)
    <div class='alert alert-danger' role='alert' id='al-error'><i class='fa fa-minus-circle'></i> <b>ERROR : </b> Sepertinya ada yang salah pada data importnya.</div>
    @endif
    @if ($msg_error = Session::get('msg_error'))
    <div class='alert alert-danger' role='alert' id='al-error'><i class='fa fa-minus-circle'></i> <b>ERROR : </b> {{ $msg_error }}</div>
    @endif
    <div class='row'>
        <div class='col-lg-12'>
            <div class="panel panel-bordered animation-slide-top" style='animation-delay:100ms;'>
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <div class='row'>
                            <div class='col-lg-6'>
                                <div class='pt-10'>
                                    Preview File Excel ({{ $namaFile }})
                                </div>
                            </div>
                            <div class='col-lg-6'>
                                <div class='text-right' style='padding:0px'>
                                    <button type='button' class='btn btn-success @if($data["json"] === false || $data["cek"] === 0) disabled @endif' id='btnImport'>Import File</button>
                                </div>
                            </div>
                        </div>
                    </h3>
                </div>
                <div class="panel-body">
                    <div class='row'>
                        <div class='col-md-12'>
                            @if ($data['data'] === false)
                                Data tidak dapat diimport, silahkan ulangi lagi.
                            @else
                                <div class="table-responsive">
                                    <table class='table table-hover' id='table_produk'>
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>No</th>
                                                <th>Gambar</th>
                                                <th width='15%'>Produk</th>
                                                <th>SKU / Kategori</th>
                                                <th>Supplier</th>
                                                <th>Harga Beli</th>
                                                <th>Harga Jual</th>
                                                <th>Harga Reseller</th>
                                                <th>Berat (Gram)</th>
                                                <th>Stok</th>
                                                <th width='18%'>Cek Data</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {!! $data['data'] !!}
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col-xxl-2 col-lg-4'>
            <div class='panel p-15 animation-slide-left selectBug' style='animation-delay:200ms'>
                <div class='d-flex'>
                    <div style='margin-top:8px'>
                        <input type="checkbox" id='pilihSemua' class='pilihCheck'/>
                        <label for='pilihSemua' class='ml-3'>Pilih Semua</label>
                    </div>
                    <button type="button" class="btn btn-icon btn-danger ml-15" id='btnHapus'>Hapus</button>
                </div>
            </div>
        </div>
        <div class='col-xxl-5 col-lg-2'>
        </div>
        <div class='col-xxl-5 col-lg-6'>
            <div class="panel panel-bordered animation-slide-left" style='animation-delay:150ms;'>
                <div class="panel-heading">
                    <h3 class="panel-title">Catatan</h3>
                </div>
                <div class="panel-body">
                    <ul>
                        <li>Produk bisa diimport jika tidak ada kolom yang berwarna merah</li>
                        <li>Jika nama produk sama dengan nama produk yang sudah ada, maka akan diedit</li>
                        <li>Pastikan nama kolom pada file excel tidak dirubah</li>
                        <li>Link Gambar hanya bisa diisi max 7 link</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal gambar -->
<div class="modal fade" id="modGambar" aria-hidden="    " aria-labelledby="exampleModalTitle"
    role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTabs">Gambar ( <span id='namaProd'></span> [<span id='skuProd'></span>] )</h4>
            </div>
            <div class="modal-body">
                <div class="carousel slide" id="exampleCarouselDefault1" data-ride="carousel">
                    <ol class="carousel-indicators carousel-indicators-fall" id='gambarIndi'>
                    </ol>
                    <div class="carousel-inner" role="listbox"id='gambarPath'>
                    </div>
                    <a class="carousel-control-prev" href="#exampleCarouselDefault1" role="button"
                        data-slide="prev">
                        <span class="carousel-control-prev-icon fa-chevron-circle-left"
                            aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#exampleCarouselDefault1" role="button"
                        data-slide="next">
                        <span class="carousel-control-next-icon fa-chevron-circle-right"
                            aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var data_import = '{!! $data["json"] !!}';
var pilih_prod = [];

$(document).ready(function(){

    $('.bisaCek').iCheck({
        checkboxClass: 'icheckbox_flat-blue'
    });

    $('#pilihSemua').iCheck({
        checkboxClass: 'icheckbox_flat-blue'
    });

    $('.bisaCek').on('ifChecked', function(){
        let id = parseInt($(this).parent().parent().parent().attr('id').split('-')[1]);
        if(pilih_prod.indexOf(id) === -1){
            pilih_prod.push(id);
        }
        if(pilih_prod.length === jQuery.parseJSON(data_import).length){
            $('#pilihSemua')[0].checked = true;
            $('#pilihSemua').iCheck('update');
        }
    });

    $('.bisaCek').on('ifUnchecked', function(){
        let id = $(this).parent().parent().parent().attr('id');
        pilih_prod = $.grep(pilih_prod, function(value) {
            return value !== parseInt(id.split('-')[1]);
        });
        if(pilih_prod.length !== jQuery.parseJSON(data_import).length){
            $('#pilihSemua')[0].checked = false;
            $('#pilihSemua').iCheck('update');
        }
    });

    $('#pilihSemua').on('ifChecked', function(){
        $.each(jQuery.parseJSON(data_import), (i, v) => {
            if(pilih_prod.indexOf(v.id_untuk_validasi) === -1){
                pilih_prod.push(v.id_untuk_validasi);
            }
            $('#pilihCheck-'+v.id_untuk_validasi)[0].checked = true;
            $('#pilihCheck-'+v.id_untuk_validasi).iCheck('update');
        });
    });

    $('#pilihSemua').on('ifUnchecked', function(){
        pilih_prod = [];
        $.each(jQuery.parseJSON(data_import), (i, v) => {
            $('#pilihCheck-'+v.id_untuk_validasi)[0].checked = false;
            $('#pilihCheck-'+v.id_untuk_validasi).iCheck('update');
        });
    });

    @if($data["json"] === false || $data["cek"] === 0)
        $('#btnImport').tooltip({
            trigger: 'hover',
            title: 'Data tidak bisa diimport!',
            placement: 'top'
        });
    @endif

    $('#btnHapus').on('click', function(){
        $.each(pilih_prod, (i, v) => {
            $('#tr-'+v).remove();
            var temp = jQuery.parseJSON(data_import);
            temp = $.grep(temp, function(value) {
                return value.id_untuk_validasi !== v;
            });
            data_import = JSON.stringify(temp);
        });
        pilih_prod = [];
        if(pilih_prod.length < 1){
            $('#pilihSemua')[0].checked = false;
            $('#pilihSemua').iCheck('update');
        }
        var cekError = 0;
        $.each(jQuery.parseJSON(data_import), (i2, v2) => {
            cekError += v2.ada_error;
        });
        if(cekError === 0 && jQuery.parseJSON(data_import).length > 0){
            $('#btnImport').removeClass('disabled');
            $('#btnImport').tooltip('dispose');
        }
    });

    $('#btnImport').on('click', function(){
        var cekError = 0;
        $.each(jQuery.parseJSON(data_import), (i2, v2) => {
            cekError += v2.ada_error;
        });
        if(cekError === 0 && jQuery.parseJSON(data_import).length > 0){
            var url = "{{route('b.excel-import-produk-proses')}}";
            var form = $("<form action='"+url+"' method='post'></form>");
            form.append('@csrf');
            form.append('<textarea name="data">'+data_import+'</textarea>');
            $('body').append(form);
            form.submit();
        } 
        return;
    });

    $('#table_produk').on('click', '.btnLihatGambar', function(){
        $('#exampleCarouselDefault1').carousel('dispose');
        var data = $(this).parent().children('textarea').val().split(';');
        var nama_prod = $(this).parent().parent().children('td:nth-child(4)').html().split('<br>');
        var sku_prod = $(this).parent().parent().children('td:nth-child(5)').html().split('<br>');
        $('#namaProd').text(nama_prod[0]);
        $('#skuProd').text(sku_prod[0]);
        $.each(data, (i, v) => {
            if(i == 0){
                $('#gambarIndi').append('<li data-target="#carouselGambar" data-slide-to="0" class="active"></li>');
                $('#gambarPath').append('<div class="carousel-item active"><img class="d-block w-100" src="'+v+'" alt="'+v+'"></div>');
            } else {
                $('#gambarIndi').append('<li data-target="#carouselGambar" data-slide-to="'+i+'"></li>');
                $('#gambarPath').append('<div class="carousel-item"><img class="d-block w-100" src="'+v+'" alt="'+v+'"></div>');
            }
        });
        $('#exampleCarouselDefault1').carousel();
        $('#modGambar').modal('show');
    });

    $('#modGambar').on('hidden.bs.modal', function(){
        $('#gambarPath').html('');
        $('#gambarIndi').html('');
        $('#namaProd').html('');
        $('#skuProd').html('');
    });
});
</script>
<!--uiop-->
@endsection