@extends('belakang.index')
@section('isi')
<!--uiop-->
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="page-header page-header-bordered">
    <div class='row'>
        <div class='col-md-6'>
            <h1 class="page-title font-size-26 font-weight-100">@lang("produk_kategori.daftar_kategori_produk")</h1>
        </div>
        <div class='col-md-6'>
            <div class="page-header-actions">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"
                            onClick="pageLoad('{{ route('b.dashboard') }}')">@lang("produk_kategori.dasbor")</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);"
                            onClick="pageLoad('{{ route('b.produk-index') }}')">@lang("produk_kategori.produk")</a></li>
                    <li class="breadcrumb-item active">@lang("produk_kategori.daftar_kategori_produk")</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="page-content">
    <div class='container'>
        <div class="panel animation-slide-bottom">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group form-style form-inline">
                            <button class="btn btn-success" data-target="#modTambah" data-toggle="modal" type="button"><i
                                    class='fa fa-plus'></i> @lang("produk_kategori.tambah_kategori_produk")</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 form-group">
                    <div class="table-responsive">
                        <table class="table" id="table_kategori_produk">
                            <thead>
                                <tr>
                                    <th>@lang("produk_kategori.nama_kategori_produk")</th>
                                    <th><span class="site-menu-icon md-settings"></span></th>
                                </tr>
                            </thead>
                            <tbody id='isiTabel'>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var tabelData;
(function(world) {
    world.fn.editM = function() {
        var t = jQuery(this).parent().parent().children('td:first').html();
        var t2 = jQuery(this).parent().children('input').val();
        jQuery('input[name=id_kategori_produkE]').val(t2);
        jQuery('input[name=nama_kategori_produkE]').val(t);
    }

    world.fn.hapusM = function(tabelData) {
        var v = jQuery(this).parent().children('input').val();
        swal({
            title: "@lang('produk_kategori.swal.peringatan.judul')",
            text: "@lang('produk_kategori.swal.peringatan.msg')",
            icon: "warning",
            buttons: {
                confirm: {
                    text: "@lang('produk_kategori.iya')",
                    value: true,
                    closeModal: true
                },
                cancel: {
                    text: "@lang('produk_kategori.tidak')",
                    value: false,
                    visible: true,
                    closeModal: true,
                }
            },
            dangerMode: true
        }).then((willDelete) => {
            if (willDelete) {
                var hasil = '';
                $.ajax({
                    type: 'post',
                    url: "{{ route('b.produkKategori-proses') }}",
                    data: {
                        id_kategori_produkH: v,
                        tipe: 'hapus'
                    },
                    success: function(data) {
                        hasil = data;
                    },
                    error: function(xhr, b, c) {
                        swal("Error", '' + c, "error");
                    }
                }).done(function() {
                    if (hasil.sukses) {
                        swal("@lang('produk_kategori.swal.berhasil.judul')",
                            "@lang('produk_kategori.swal.berhasil.msg_hapus')", "success");
                        tabelData.ajax.reload(null, false);
                    } else {
                        swal("@lang('produk_kategori.swal.gagal.judul')",
                            "@lang('produk_kategori.swal.gagal.msg_hapus')", "error");
                    }
                });
            }
        });
    }
})(jQuery);
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function() {
    tabelData = $('#table_kategori_produk').DataTable({
        ajax: {
            type: 'get',
            url: "{{ route('b.produkKategori-getData') }}",
        },
        dom: '<"row"<".col-md-4 .col-xs-12"l><"#tombol.col-md-4 .col-xs-12"><".col-md-4 .col-xs-12"f>>t<"row"<".col-md-6 .col-xs-12"i><".col-md-6 .col-xs-12"p>>',
        lengthMenu: [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
        ],
        language: {
            "sEmptyTable": "@lang('produk_kategori.dataTabel.sEmptyTable')",
            "sProcessing": "@lang('produk_kategori.dataTabel.sProcessing')",
            "sLengthMenu": "@lang('produk_kategori.dataTabel.sLengthMenu')",
            "sZeroRecords": "@lang('produk_kategori.dataTabel.sZeroRecords')",
            "sInfo": "@lang('produk_kategori.dataTabel.sInfo')",
            "sInfoEmpty": "@lang('produk_kategori.dataTabel.sInfoEmpty')",
            "sInfoFiltered": "@lang('produk_kategori.dataTabel.sInfoFiltered')",
            "sInfoPostFix": "@lang('produk_kategori.dataTabel.sInfoPostFix')",
            "sSearch": "@lang('produk_kategori.dataTabel.sSearch')",
            "sUrl": "@lang('produk_kategori.dataTabel.sUrl')",
            "oPaginate": {
                "sFirst": "@lang('produk_kategori.dataTabel.oPaginate.sFirst')",
                "sPrevious": "@lang('produk_kategori.dataTabel.oPaginate.sPrevious')",
                "sNext": "@lang('produk_kategori.dataTabel.oPaginate.sNext')",
                "sLast": "@lang('produk_kategori.dataTabel.oPaginate.sLast')"
            }
        },
        // initComplete: function(){
        // $("div[id=tombol]").html("<div class='btn-group' role='group'><a class='btn btn-secondary' href='#'>as</a><a class='btn btn-secondary' href='#'>as</a><a class='btn btn-secondary' href='#'>as</a></div>");
        // }
    });
    $("#namaKatMod").keypress(function(e){
        if(e.keyCode == '13') {
            e.preventDefault();
            $("#btnTamMod").trigger("click");
        }
    });
    $("#namaKatMod_edit").keypress(function(e){
        if(e.keyCode == '13') {
            e.preventDefault();
            $("#btnTamMod_edit").trigger("click");
        }
    });
    $("input[name=btnTambah]").on('click', function() {
        var nama_kategori = $('input[name=nama_kategori_produk]').val();
        if (nama_kategori == '') {
            $('input[name=nama_kategori_produk]').attr('class',
                'form-control is-invalid animation-shake');
            $('small#error_nama').attr('style', 'color:#f2353c;');
        } else {
            var hasil = '';
            $.ajax({
                type: 'post',
                url: "{{ route('b.produkKategori-proses') }}",
                data: {
                    nama_kategori_produk: $('input[name=nama_kategori_produk]').val(),
                    tipe: 'tambah'
                },
                success: function(data) {
                    hasil = data;
                },
                error: function(xhr, b, c) {
                    swal("Error", '' + c, "error");
                }
            }).done(function() {
                $('#modTambah').modal('hide');
                if (hasil.sukses) {
                    swal("@lang('produk_kategori.swal.berhasil.judul')",
                        "@lang('produk_kategori.swal.berhasil.msg_tambah')", "success");
                    tabelData.ajax.reload(null, false);
                } else {
                    swal("@lang('produk_kategori.swal.gagal.judul')",
                        ""+ hasil.msg, "error");
                }
                $('input[name=nama_kategori_produk]').val("");
            }).fail(function() {
                $('#modTambah').modal('hide');
            });
        }
    });
    $('#modTambah').on('hidden.bs.modal', function(e) {
        $('input[name=nama_kategori_produk]').attr('class', 'form-control');
        $('small#error_nama').attr('style', 'color:#f2353c;display:none');
    });
    $("input[name=btnEdit]").on('click', function() {
        var nama_kategori = $('input[name=nama_kategori_produkE]').val();
        if (nama_kategori == '') {
            $('input[name=nama_kategori_produkE]').attr('class',
                'form-control is-invalid animation-shake');
            $('small#error_namaE').attr('style', 'color:#f2353c;');
        } else {
            var hasil = '';
            $.ajax({
                type: 'post',
                url: "{{ route('b.produkKategori-proses') }}",
                data: {
                    nama_kategori_produkE: $('input[name=nama_kategori_produkE]').val(),
                    id_kategori_produkE: $('input[name=id_kategori_produkE]').val(),
                    tipe: 'edit'
                },
                success: function(data) {
                    hasil = data;
                },
                error: function(xhr, b, c) {
                    swal("Error", '' + c, "error");
                }
            }).done(function() {
                console.log(hasil);
                $('#modEdit').modal('hide');
                if (hasil.sukses) {
                    swal("@lang('produk_kategori.swal.berhasil.judul')",
                        "@lang('produk_kategori.swal.berhasil.msg_edit')", "success");
                    tabelData.ajax.reload(null, false);
                } else {
                    swal("@lang('produk_kategori.swal.gagal.judul')",
                        ""+ hasil.msg, "error");
                }
                $('input[name=nama_kategori_produkE]').val("");
            }).fail(function() {
                $('#modEdit').modal('hide');
            });
        }
    });
    $('#modEdit').on('hidden.bs.modal', function(e) {
        $('input[name=nama_kategori_produkE]').attr('class', 'form-control');
        $('small#error_namaE').attr('style', 'color:#f2353c;display:none');
    });
});
</script>
<!-- modal tambah-->
<div class="modal fade modal-fade-in-scale-up" id="modTambah" aria-hidden="true" aria-labelledby="exampleModalTitle"
    role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <form action="#" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">@lang('produk_kategori.tambah_kategori_produk')</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label>@lang('produk_kategori.nama_kategori_produk')</label>
                            <input type="text" class="form-control" name="nama_kategori_produk" id='namaKatMod'>
                            <small id="error_nama"
                                style='color:#f2353c;display:none;'>@lang('produk_kategori.error_nama')</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-primary" value="@lang('produk_kategori.tambah')"
                        name='btnTambah' id='btnTamMod'>
                    <button type="button" class="btn btn-default"
                        data-dismiss="modal">@lang('produk_kategori.batal')</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal edit-->
<div class="modal fade modal-fade-in-scale-up" id="modEdit" aria-hidden="true" aria-labelledby="exampleModalTitle"
    role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <form action="#" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">@lang('produk_kategori.edit_kategori_produk')</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label><b>@lang('produk_kategori.nama_kategori_produk')</b></label>
                            <input type="text" class="form-control" name="nama_kategori_produkE" id='namaKatMod_edit'>
                            <input type="hidden" name="id_kategori_produkE">
                            <small id="error_namaE"
                                style='color:#f2353c;display:none;'>@lang('produk_kategori.error_nama')</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-primary" value="@lang('produk_kategori.edit')" name='btnEdit' id='btnTamMod_edit'>
                    <button type="button" class="btn btn-default"
                        data-dismiss="modal">@lang('produk_kategori.batal')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--uiop-->
@endsection