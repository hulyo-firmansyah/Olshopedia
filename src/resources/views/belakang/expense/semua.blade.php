@extends('belakang.index')
@section('isi')
<!--uiop-->
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('template/global/vendor/jquery-ui/themes/cupertino/jquery-ui.css') }}">
<div class="page-header page-header-bordered">
    <div class='row'>
        <div class='col-md-6'>
            <h1 class="page-title font-size-26 font-weight-100">Expense</h1>
        </div>
        <div class='col-md-6'>
            <div class="page-header-actions">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"
                        onClick="pageLoad('{{ route('b.dashboard') }}')">Dashboard</a></li>
                    <li class="breadcrumb-item active">Expense</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="page-content">
    <div class="panel animation-slide-bottom">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group form-style form-inline">
                        <button class="btn btn-success" data-target="#modTambah" data-toggle="modal" type="button"><i
                                class='fa fa-plus'></i> Tambah Expense Baru</button>
                        @if(($ijin->downloadExcel === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner')
                        <div class="dropdown btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" id="exampleColorDropdown1"
                                data-toggle="dropdown" aria-expanded="false">Menu</button>
                            <div class="dropdown-menu" aria-labelledby="exampleColorDropdown1" role="menu">
                                <a class="dropdown-item" href="{{ route('b.excel-export-expense', ['format' => 'xlsx']) }}"><i class='wb-download'></i> Download Excel File (.xlsx)</a>
                                <a class="dropdown-item" href="{{ route('b.excel-export-expense', ['format' => 'xls']) }}"><i class='wb-download'></i> Download Excel File (.xls)</a>
                                <a class="dropdown-item" href="{{ route('b.excel-export-expense', ['format' => 'csv']) }}"><i class='wb-download'></i> Download Excel File (.csv)</a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-12 form-group">
                <div class="table-responsive">
                    <table class="table" id="table_expense">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama Pengeluaran</th>
                                <th>Harga / Biaya</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
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
<script>   

function hitungSubtotal() {
    var a = $('#harga').val();
    var b = $('#jumlah').val();
    var c = 0;
    if ($('#harga').val() == '') {
        a = 0;
    }
    if ($('#jumlah').val() == '') {
        b = 0;
    }
    d = c = a * b;
    var r = d.toString().split('').reverse().join(''),
        ri = r.match(/\d{1,3}/g);
    var ha = ri.join('.').split('').reverse().join('');
    $('#hiddensubtotal').val(c);
    $('#subtotal').html(ha);
}

function hitungSubtotalE() {
    var a = $('input[name=hargaE]').val();
    var b = $('input[name=jumlahE]').val();
    var c = 0;
    if ($('input[name=hargaE]').val() == '') {
        a = 0;
    }
    if ($('input[name=jumlahE]').val() == '') {
        b = 0;
    }
    d = c = a * b;
    var r = d.toString().split('').reverse().join(''),
        ri = r.match(/\d{1,3}/g);
    var ha = ri.join('.').split('').reverse().join('');
    $('#hiddensubtotalE').val(c);
    $('span#subtotalE').html(ha);
}
var TabelData;
(function(world) {
    world.fn.editE = function() {
        var tgl = jQuery(this).parent().parent().children('td:first').text();
        var harga = jQuery(this).parent().parent().children('td:nth-child(3)').text().split(" ")[1].replace(/[^0-9]/gi, '');
        var jumlah = jQuery(this).parent().parent().children('td:nth-child(4)').text().split(" ")[1].replace(/[^0-9]/gi, '');
        var Pnama = jQuery(this).parent().parent().children('td:nth-child(2)').text().split('<br>');
        var note = jQuery(this).parent().parent().children('td:nth-child(2)').children('small').text();
        var nama = Pnama[0];
        var id = jQuery(this).parent().children('input').val();
        jQuery('input[name=idExE]').val(id);
        jQuery('input[name=nama_pE]').val(nama);
        jQuery('input[name=hargaE]').val(harga);
        jQuery('input[name=jumlahE]').val(jumlah);
        jQuery('textarea#NoteE').val(note);
        jQuery('input[name=tanggalE]').datepicker('setDate', tgl);
        var a = $('input[name=hargaE]').val();
        var b = $('input[name=jumlahE]').val();
        var c = 0;
        if ($('input[name=hargaE]').val() == '') {
            a = 0;
        }
        if ($('input[name=jumlahE]').val() == '') {
            b = 0;
        }
        d = c = a * b;
        var r = d.toString().split('').reverse().join(''),
            ri = r.match(/\d{1,3}/g);
        var ha = ri.join('.').split('').reverse().join('');
        $('#hiddensubtotalE').val(c);
        $('span#subtotalE').html(ha);
    }

    world.fn.hapusE = function(tabelData) {
        var v = jQuery(this).parent().children('input').val();
        swal({
            title: "Peringatan",
            text: "Apakah anda yakin ingin menghapusnya?",
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
                var hasil = '';
                $.ajax({
                    type: 'POST',
                    url: "{{ route('b.expense-proses') }}",
                    data: {
                        id_expense: v,
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
                        swal("Berhasil!", "Berhasil menghapus kategori produk!", "success");
                        tabelData.ajax.reload(null, false);
                    } else {
                        swal("Gagal", "" + hasil.msg, "error");
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
    $('.date-picker').datepicker({
        endDate:'0d',
        format: "dd MM yyyy",
    });
    tabelData = $('#table_expense').DataTable({
        ajax: {
            type: 'GET',
            url: "{{ route('b.expense-getData') }}",
        },
        dom: '<"row"<".col-md-4 .col-xs-12"l><"#tombol.col-md-4 .col-xs-12"><".col-md-4 .col-xs-12"f>>t<"row"<".col-md-6 .col-xs-12"i><".col-md-6 .col-xs-12"p>>',
        lengthMenu: [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
        ],
        // initComplete: function(){
        // $("div[id=tombol]").html("<div class='btn-group' role='group'><a class='btn btn-secondary' href='#'>as</a><a class='btn btn-secondary' href='#'>as</a><a class='btn btn-secondary' href='#'>as</a></div>");
        // }
    });
    $("input[name=btnTambah]").on('click', function() {
        var tgl = $('input[name=tanggal]').val();
        var nama_expense = $('input[name=nama_p]').val();
        var harga = $('input[name=harga]').val();
        var jumlah = $('input[name=jumlah]').val();
        var err = 0;
        if (tgl == '') {
            $('input[name=tanggal]').attr('class', 'form-control is-invalid animation-shake');
            $('small#error_tgl').attr('style', 'color:#f2353c;');
            err++;
        }
        if (nama_expense == '') {
            $('input[name=nama_p]').attr('class', 'form-control is-invalid animation-shake');
            $('small#error_nama').attr('style', 'color:#f2353c;');
            err++;
        }
        if (harga == 0) {
            $('input[name=harga]').attr('class', 'form-control is-invalid animation-shake');
            $('small#error_harga').attr('style', 'color:#f2353c;');
            err++;
        }
        if (jumlah == 0) {
            $('input[name=jumlah]').attr('class', 'form-control is-invalid animation-shake');
            $('small#error_jumlah').attr('style', 'color:#f2353c;');
            err++;
        }
        if (err === 0) {
            var hasil = '';
            $.ajax({
                type: 'POST',
                url: "{{ route('b.expense-proses') }}",
                data: {
                    tanggal: $('input[name=tanggal]').val(),
                    nama_p: $('input[name=nama_p]').val(),
                    harga: $('input[name=harga]').val(),
                    jumlah: $('input[name=jumlah]').val(),
                    note: $('#Note').val(),
                    tipe: 'tambah'
                },
                success: function(data) {
                    hasil = data;
                },
                error: function(error, b, c) {
                    swal("Error", '' + c, "error");
                }
            }).done(function() {
                $('#modTambah').modal('hide');
                if (hasil.sukses) {
                    swal("Berhasil!", "Berhasil menambahkan kategori produk!", "success");
                    tabelData.ajax.reload(null, false);
                } else {
                    swal("Gagal", "" + hasil.msg, "error");
                }
            }).fail(function() {
                $('#modTambah').modal('hide');
            });
            $('input[name=tanggal]').val("");
            $('input[name=nama_p]').val("");
            $('input[name=harga]').val("");
            $('input[name=jumlah]').val("");
            $('#Note').val("");
            $('span#subtotal').html("0");
        }
    });
    $('#modTambah').on('hidden.bs.modal', function(e) {
        $('input[name=nama_p]').attr('class', 'form-control');
        $('small#error_nama').attr('style', 'color:#f2353c;display:none');
        $('input[name=tanggal]').attr('class', 'form-control');
        $('small#error_tgl').attr('style', 'color:#f2353c;display:none');
        $('input[name=harga]').attr('class', 'form-control');
        $('small#error_harga').attr('style', 'color:#f2353c;display:none');
        $('input[name=jumlah]').attr('class', 'form-control');
        $('small#error_jumlah').attr('style', 'color:#f2353c;display:none');
    });
    $("input[name=btnEdit]").on('click', function() {
        var tgl = $('input[name=tanggalE]').val();
        var nama_expense = $('input[name=nama_pE]').val();
        var harga = $('input[name=hargaE]').val();
        var jumlah = $('input[name=jumlahE]').val();
        var err = 0;
        if (tgl == '') {
            $('input[name=tanggalE]').attr('class', 'form-control is-invalid animation-shake');
            $('small#error_tgl').attr('style', 'color:#f2353c;');
            err++;
        }
        if (nama_expense == '') {
            $('input[name=nama_pE]').attr('class', 'form-control is-invalid animation-shake');
            $('small#error_nama').attr('style', 'color:#f2353c;');
            err++;
        }
        if (harga == 0) {
            $('input[name=hargaE]').attr('class', 'form-control is-invalid animation-shake');
            $('small#error_hargaE').attr('style', 'color:#f2353c;');
            err++;
        }
        if (jumlah == 0) {
            $('input[name=jumlahE]').attr('class', 'form-control is-invalid animation-shake');
            $('small#error_jumlahE').attr('style', 'color:#f2353c;');
            err++;
        }
        if (err === 0) {
            var hasil = '';
            $.ajax({
                type: 'POST',
                url: "{{ route('b.expense-proses') }}",
                data: {
                    id_expense: $('input[name=idExE]').val(),
                    tanggal: $('input[name=tanggalE]').val(),
                    nama_p: $('input[name=nama_pE]').val(),
                    harga: $('input[name=hargaE]').val(),
                    jumlah: $('input[name=jumlahE]').val(),
                    note: $('#NoteE').val(),
                    tipe: 'edit'
                },
                success: function(data) {
                    hasil = data;
                },
                error: function(xhr, b, c) {
                    swal("Error", '' + c, "error");
                }
            }).done(function() {
                $('#modEdit').modal('hide');
                if (hasil.sukses) {
                    swal("Berhasil!", "Berhasil mengedit kategori produk!", "success");
                    tabelData.ajax.reload(null, false);
                } else {
                    swal("Gagal", "" + hasil.msg, "error");
                }
            }).fail(function() {
                $('#modEdit').modal('hide');
            });
            $('input[name=tanggalE]').val("");
            $('input[name=nama_pE]').val("");
            $('input[name=hargaE]').val("");
            $('input[name=jumlahE]').val("");
            $('#NoteE').val("");
            $('span#subtotalE').html("0");
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
    <div class="modal-dialog modal-simple" style='max-width:800px;'>
        <div class="modal-content" style='width:800px;'>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTitle">Tambah Expense Baru</h4>
            </div>
            <div class="modal-body">
                <form id="form_expense">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Tanggal</label>
                            <input type="text" class="form-control date-picker" id="Tanggal" name="tanggal"
                                data-date-end-date="0d" required />
                            <small id="error_tgl" style='color:#f2353c;display:none;'>Masukkan Tanggal!</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label>Nama Pengeluaran</label>
                            <input type="text" class="form-control" id="Nama_P" name="nama_p" required />
                            <small id="error_nama" style='color:#f2353c;display:none;'>Masukkan Nama Expense!</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Harga</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" min='0' placeholder='0' class="form-control" onKeyUp='hitungSubtotal()'
                                    id="harga" name="harga" required />
                            </div>
                            <small id="error_harga" style='color:#f2353c;display:none;'>Harga tidak boleh 0!</small>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Jumlah</label>
                            <input type="number" min='0' placeholder='0' class="form-control" id="jumlah"
                                onKeyUp='hitungSubtotal()' name="jumlah" required />
                            <small id="error_jumlah" style='color:#f2353c;display:none;'>Biaya tidak boleh 0!</small>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Subtotal</label>
                            <h4>Rp <input type="hidden" id="hiddensubtotal" name="subtotal"><span id="subtotal">0</span>
                            </h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label>Note</label>
                            <textarea class="form-control" name="note" id="Note"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-primary" value='Tambah' name='btnTambah'>
                <button class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<!-- modal edit-->
<div class="modal fade modal-fade-in-scale-up" id="modEdit" aria-hidden="true" aria-labelledby="exampleModalTitle"
    role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple" style='max-width:800px;'>
        <div class="modal-content" style='width:800px;'>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTitle">Edit Expense</h4>
            </div>
            <div class="modal-body">
                <form id="form_expense_edit">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Tanggal</label>
                            <input type="text" class="form-control date-picker" id="TanggalE" name="tanggalE"
                                data-date-end-date="0d" required />
                            <small id="error_tglE" style='color:#f2353c;display:none;'>Masukkan Tanggal!</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label>Nama Pengeluaran</label>
                            <input type="text" class="form-control" id="Nama_PE" name="nama_pE" required />
                            <input type="hidden" class="form-control" id="idExE" name="idExE" required />
                            <small id="error_namaE" style='color:#f2353c;display:none;'>Masukkan Nama Expense!</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Harga</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" min='0' placeholder='0' class="form-control" onKeyUp='hitungSubtotalE()'
                                    id="hargaE" name="hargaE" required />
                            </div>
                            <small id="error_hargaE" style='color:#f2353c;display:none;'>Harga tidak boleh 0!</small>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Jumlah</label>
                            <input type="number" min='0' placeholder='0' class="form-control" id="jumlahE"
                                onKeyUp='hitungSubtotalE()' name="jumlahE" required />
                            <small id="error_jumlahE" style='color:#f2353c;display:none;'>Biaya tidak boleh 0!</small>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Subtotal</label>
                            <h4>Rp <input type="hidden" id="hiddensubtotalE" name="subtotalE"><span
                                    id="subtotalE">0</span></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label>Note</label>
                            <textarea class="form-control" name="note" id="NoteE"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-primary" value='Edit' name='btnEdit'>
                <button class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!--uiop-->
@endsection