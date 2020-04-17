@extends('belakang.index')
@section('isi')
<!--uiop-->
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
.selectBug{
    animation-fill-mode: backwards;
    -webkit-animation-fill-mode: backwards;
}
.stokClick:hover{
    border:1px black dotted;
    padding:3px;
    width:80%;
}
.stokClick{
    cursor:pointer;
    text-decoration:none;
}
</style>
<div class="page-header page-header-bordered">
    <div class='row'>
        <div class='col-md-6'>
            @if($tipe == 'arsip') 
                <h1 class="page-title font-size-26 font-weight-100">Produk yang diarsipkan</h1>
            @elseif($tipe == 'semua')
                <h1 class="page-title font-size-26 font-weight-100">Semua Produk</h1>
            @endif
        </div>
        <div class='col-md-6'>
            <div class="page-header-actions">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"
                        onClick="pageLoad('{{ route('b.dashboard') }}')">Dashboard</a></li>
                    @if($tipe == 'arsip') 
                    <li class="breadcrumb-item"><a href="javascript:void(0);"
                        onClick="pageLoad('{{ route('b.produk-index') }}')">Produk</a></li>
                        <li class="breadcrumb-item active">Produk yang diarsipkan</li>
                    @elseif($tipe == 'semua')
                        <li class="breadcrumb-item active">Produk</li>
                    @endif
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="page-content">
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
        <div class='col-xxl-4 col-xl-6'>
            <div class='panel p-15 animation-slide-left selectBug' style='animation-delay:200ms'>
                <div class='d-flex'>
                    <div style='margin-top:8px'>
                        <input type="checkbox" id='selectMultiEventAll' />
                        <label for='selectMultiEventAll' class='ml-3'>Pilih Semua</label>
                    </div>
                    <select id='multiEvent' class='ml-25'>
                        <option value='' selected disabled>-- Pilih Pengaturan --</option>
                        <option value='ubah_kategori'>Ubah Kategori</option>
                        @if($tipe == "arsip")
                            <option value='arsip'>Keluarkan dari Arsip</option>
                        @else
                            <option value='arsip'>Arsipkan</option>
                        @endif
                        @if(($ijin->hapusProduk === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner')
                            <option value='hapus'>Hapus</option>
                        @endif
                    </select>
                    <button type="button" class="btn btn-icon btn-primary ml-15" id='btnAtur'>Atur Langsung</button>
                </div>
            </div>
        </div>
        <div class='col-xxl-4 hidden-xl-down'>
        </div>
        <div class='col-xxl-4 col-xl-6'>
            <div class='panel p-15 animation-slide-right selectBug' style='animation-delay:200ms'>
                <div class='d-flex'>
                    <div class="form-style form-inline ml-15">
                        <a class="btn btn-success" href="javascript:void(0);"
                            onClick="pageLoad('{{ route('b.produk-tambah') }}')">Tambah Produk</a>
                        @if((($ijin->uploadProdukExcel === 1 || $ijin->downloadExcel === 1) && $data_user->role == 'Admin') || $data_user->role == 'Owner')
                            <div class="dropdown btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle" id="exampleColorDropdown1"
                                    data-toggle="dropdown" aria-expanded="false">Menu</button>
                                <div class="dropdown-menu" aria-labelledby="exampleColorDropdown1" role="menu">
                                    @if(($ijin->uploadProdukExcel === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner')
                                        <button class="dropdown-item" style='cursor:pointer' data-target="#modUpload" data-toggle="modal"type="button"><i class='wb-upload'></i> Upload Excel File</button>
                                    @endif
                                    @if(($ijin->downloadExcel === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner')
                                        <a class="dropdown-item" href="{{ route('b.excel-export-produk', ['format' => 'xlsx']) }}?tipe={{ $tipe }}"><i class='wb-download'></i> Download Excel File (.xlsx)</a>
                                        <a class="dropdown-item" href="{{ route('b.excel-export-produk', ['format' => 'xls']) }}?tipe={{ $tipe }}"><i class='wb-download'></i> Download Excel File (.xls)</a>
                                        <a class="dropdown-item" href="{{ route('b.excel-export-produk', ['format' => 'csv']) }}?tipe={{ $tipe }}"><i class='wb-download'></i> Download Excel File (.csv)</a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                    <select id='filterSelect' class='ml-25'>
                        <option value='semua' @if($tipe == 'semua') selected @endif>Semua Produk</option>
                        <option value='arsip' @if($tipe == 'arsip') selected @endif>Produk yang diarsipkan</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col-lg-12'>
            <div class="panel animation-slide-bottom">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table" id="table_produk">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th width="30%">Nama Produk</th>
                                            <th>Stok</th>
                                            <th>Harga Jual Normal</th>
                                            <th>Grosir</th>
                                            <th>Supplier</th>
                                            <th>Kategori</th>
                                            <th width='15%'><span class="site-menu-icon md-settings"></span></th>
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
    </div>
    <div class='row'>
    </div>
</div>
@if(($ijin->uploadProdukExcel === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner')
<!-- Modal excel -->
<div class="modal fade" id="modUpload" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <form method="post" action="{{ route('b.excel-import-produk') }}" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="exampleModalTabs">Upload produk</h4>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div role="alert" class="alert alert-success">
                                </button>
                                <h4>Template</h4>
                                <p>Download template upload produk <a href="{{ route('b.excel-template-produk') }}">disini</a>.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            @csrf
                            <input type="file" name="fileUpload" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"  required="required"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"> Upload</button>
                    <button class="btn btn-default" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
<!-- modal stok -->
<div class="modal fade" id="modStok" aria-hidden="true" aria-labelledby="exampleModalTitle"
    role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTabs">Stok (<span id='namaProd'></span>)</h4>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<!-- modal kategori -->
<div class="modal fade" id="modKategori" aria-hidden="true" aria-labelledby="exampleModalTitle"
    role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTabs">Pengaturan</h4>
            </div>
            <div class="modal-body">
                <div class='row'>
                    <div class='col-md-3'>
                        <label style='padding-top:8px'><b>Kategori Produk</b></label>
                    </div>
                    <div class='col-md-9'>
                        <select id='kategori_prod' name='kategori_prod'>
                            <option value='' selected disabled>-- Pilih Kategori Produk --</option>
                            <option value='kosong'>Tidak berkategori</option>
                            @foreach($kategori_produk as $k)
                            <option value='{{ $k->id_kategori_produk }}' >{{ $k->nama_kategori_produk }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-primary" value='Ubah Kategori' name='btnUbahKat' id='btnUbahKat'>
                <button class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<script>
var tabelData, pilih_prod = [], cek_prod_page = [];
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

(function(world) {

    @if(($ijin->hapusProduk === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner')
    world.fn.hapusP = function(tabelData) {
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
                    type: 'post',
                    url: "{{ route('b.produk-proses') }}",
                    data: {
                        id_produkH: [v],
                        tipe_kirim_produk: '{{ base64_encode("hapus") }}'
                    },
                    success: function(data) {
                        hasil = data;
                    },
                    error: function(xhr, b, c) {
                        console.log({
                            id_produkH: [v],
                            tipe_kirim_produk: '{{ base64_encode("hapus") }}'
                        });
                        swal("Error", '' + c, "error");
                    }
                }).done(function() {
                    if (hasil.sukses) {
                        swal("Berhasil!", "Berhasil menghapus produk!", "success");
                        $('#multiEvent').selectpicker('val', '');
                        pilih_prod = [];
                        cek_prod_page = [];
                        tabelData.ajax.reload(null, false);
                    } else {
                        swal("Gagal", "Gagal menghapus produk!", "error");
                    }
                });
            }
        });
    }
    @endif

})(jQuery);

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {

    alertify.set('notifier','position', 'top-right');
    
    $('#multiEvent').selectpicker({
        style: 'btn-outline btn-default'
    });
    
    $('#filterSelect').selectpicker({
        style: 'btn-outline btn-default'
    });

    $('#kategori_prod').selectpicker({
        style: 'btn-outline btn-default'
    });
    
    $('#selectMultiEventAll').iCheck({
        checkboxClass: 'icheckbox_flat-blue'
    });

    $('#btnUbahKat').on('click', () => {
        if($('#kategori_prod').val() == null){
            return alertify.warning("Silahkan pilih kategori terlebih dahulu");
        }
        $.ajax({
            type: 'post',
            url: "{{ route('b.produk-editLangsung') }}",
            data: {
                id_produk: pilih_prod,
                kategori: $('#kategori_prod').val(),
                tipe_kirim_produk: '{{ base64_encode("ubah_kategori") }}'
            },
            success: function(data) {
                hasil = data;
            },
            error: function(xhr, b, c) {
                console.log({
                    id_produk: pilih_prod,
                    kategori: $('#kategori_prod').val(),
                    tipe_kirim_produk: '{{ base64_encode("ubah_kategori") }}'
                });
                swal("Error", '' + c, "error");
            }
        }).done(function() {
            if (hasil.sukses) {
                swal("Berhasil!", "Berhasil mengedit kategori produk!", "success");
            } else {
                swal("Gagal", "" + hasil.msg, "error");
            }
            pilih_prod = [];
            cek_prod_page = [];
            tabelData.ajax.reload(null, false);
            $('#multiEvent').selectpicker('val', '');
            $('#kategori_prod').selectpicker('val', '');
            $('#selectMultiEventAll')[0].checked = false;
            $('#selectMultiEventAll').iCheck('update');
            $("#modKategori").modal("hide");
        });
    });

    $('#btnAtur').on('click', () => {
        var tipe = $('#multiEvent').val();
        if(pilih_prod < 1){
            return alertify.warning('Silahkan pilih produk terlebih dahulu!').dismissOthers();
        }
        switch(tipe){
            case 'ubah_kategori':
                $("#modKategori").modal("show");
                break;

            case 'arsip':
                if($('#filterSelect').val() == "arsip"){
                    var pesanPeringatan = "Apakah anda yakin ingin mengeluarkan produk yang terpilih dari arsip?";
                    var pesanBerhasil = "Berhasil mengeluarkan produk dari arsip!";
                    var pesanGagal = "Gagal mengeluarkan produk dari arsip!";
                    var dangerCek = false;
                } else {
                    var pesanPeringatan = "Apakah anda yakin ingin memindahkan produk yang terpilih ke arsip?";
                    var pesanBerhasil = "Berhasil memindahkan produk ke arsip!";
                    var pesanGagal = "Gagal memindahkan produk ke arsip!";
                    var dangerCek = true;
                }
                swal({
                    title: "Peringatan",
                    text: pesanPeringatan,
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
                    dangerMode: dangerCek
                }).then((willArsip) => {
                    if (willArsip) {
                        var hasil = '';
                        $.ajax({
                            type: 'post',
                            url: "{{ route('b.produk-editLangsung') }}",
                            data: {
                                id_produk: pilih_prod,
                                tipe: "{{ $tipe }}",
                                tipe_kirim_produk: '{{ base64_encode("arsip") }}'
                            },
                            success: function(data) {
                                hasil = data;
                            },
                            error: function(xhr, b, c) {
                                console.log({
                                    id_produk: pilih_prod,
                                    tipe: "{{ $tipe }}",
                                    tipe_kirim_produk: '{{ base64_encode("arsip") }}'
                                });
                                swal("Error", '' + c, "error");
                            }
                        }).done(function() {
                            if (hasil.sukses) {
                                swal("Berhasil!", pesanBerhasil, "success");
                                tabelData.ajax.reload(null, false);
                            } else {
                                swal("Gagal", pesanGagal, "error");
                            }
                            $('#multiEvent').selectpicker('val', '');
                            $('#selectMultiEventAll')[0].checked = false;
                            $('#selectMultiEventAll').iCheck('update');
                            pilih_prod = [];
                            cek_prod_page = [];
                        });
                    }
                });
                break;

            @if(($ijin->hapusProduk === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner')
            case 'hapus':
                swal({
                    title: "Peringatan",
                    text: "Apakah anda yakin ingin menghapus produk yang terpilih?",
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
                            type: 'post',
                            url: "{{ route('b.produk-proses') }}",
                            data: {
                                id_produkH: pilih_prod,
                                tipe_kirim_produk: '{{ base64_encode("hapus") }}'
                            },
                            success: function(data) {
                                hasil = data;
                            },
                            error: function(xhr, b, c) {
                                console.log({
                                    id_produkH: pilih_prod,
                                    tipe_kirim_produk: '{{ base64_encode("hapus") }}'
                                });
                                swal("Error", '' + c, "error");
                            }
                        }).done(function() {
                            if (hasil.sukses) {
                                swal("Berhasil!", "Berhasil menghapus produk!", "success");
                                tabelData.ajax.reload(null, false);
                            } else {
                                swal("Gagal", "Gagal menghapus produk!", "error");
                            }
                            $('#multiEvent').selectpicker('val', '');
                            $('#selectMultiEventAll')[0].checked = false;
                            $('#selectMultiEventAll').iCheck('update');
                            pilih_prod = [];
                            cek_prod_page = [];
                        });
                    }
                });
                break;
            @endif
        }
    });

    $('#filterSelect').on('changed.bs.select', function(e, clickedIndex, newValue, oldValue){
        // console.log($(this).val());
        if($(this).val() == "arsip"){
            pageLoad("{{ route('b.produk-index') }}?tipe=arsip");
        } else {
            pageLoad("{{ route('b.produk-index') }}");
        }
    });

    $('#selectMultiEventAll').on('ifChecked', () => {
        var list = Array.prototype.slice.call($('.bisaCek'));
        list.forEach(function(html) {
            $(html)[0].checked = true;
            $(html).iCheck('update');
        });
        $.each(tabelData.data(), (i, v) => {
            let id = parseInt($(v[0]).attr('id').split('-')[1]);
            if(pilih_prod.indexOf(id) === -1){
                pilih_prod.push(id);
            }
        });
        // console.log(pilih_prod);
    });

    $("#table_produk").on("ifChanged", ".bisaCek", function(){
        // console.log($(this).attr('id'));
        var id = $(this).attr('id').split('-');
        if($(this)[0].checked === true){
            if(pilih_prod.indexOf(parseInt(id[1])) === -1){
                pilih_prod.push(parseInt(id[1]));
            }
            if(pilih_prod.length === tabelData.data().length){
                $('#selectMultiEventAll')[0].checked = true;
                $('#selectMultiEventAll').iCheck('update');
            }
        } else {
            pilih_prod = $.grep(pilih_prod, function(value) {
                return value !== parseInt(id[1]);
            });
            if(pilih_prod.length !== tabelData.data().length){
                $('#selectMultiEventAll')[0].checked = false;
                $('#selectMultiEventAll').iCheck('update');
            }
        }
        // console.log(pilih_prod);
    });

    $('#selectMultiEventAll').on('ifUnchecked', () => {
        var list = Array.prototype.slice.call($('.bisaCek'));
        list.forEach(function(html) {
            $(html)[0].checked = false;
            $(html).iCheck('update');
        });
        $.each(tabelData.data(), (i, v) => {
            $(v[0])[0].checked = false;
            $(v[0]).iCheck('update');
        });
        pilih_prod = [];
        // console.log(pilih_prod);
    });

    @if($msg_sukses = Session::get('msg_success') || $msg_warning = Session::get('msg_warning') || $msg_error = Session::get('msg_error'))
    window.setTimeout(function() {
        $('.alert-semen').animate({
            height: 'toggle'
        }, 'slow');
    }, 5000);
    @endif

    tabelData = $('#table_produk').DataTable({
        ajax: {
            type: 'GET',
            url: "{{ route('b.produk-getData') }}",
            data: {
                tipe: "{{ $tipe }}"
            }
        },
        order: [[2, "asc"]],
        dom: '<"row"<".col-md-4 .col-xs-12"l><"#tombol.col-md-4 .col-xs-12"><".col-md-4 .col-xs-12"f>>t<"row"<".col-md-6 .col-xs-12"i><".col-md-6 .col-xs-12"p>>',
        lengthMenu: [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
        ]
    });

    tabelData.on('xhr', (e, setting, data) => {
        var halaman = tabelData.page.info().page;
        var dataSrc = setting.json.data;
        if(pilih_prod.length > 0 && ($.inArray(halaman, cek_prod_page) !== -1)){
            $.each(dataSrc, (i, v) => {
                var id = $(v[0]).attr('id');
                if($('#selectMultiEventAll').is(":checked")){
                    $("#"+id).iCheck('check');
                } else {
                    var cek_id = parseInt(id.split('-')[1]);
                    if($.inArray(cek_id, pilih_prod) !== -1){
                        $("#"+id).iCheck('check');
                    }
                }
            });
        } else {
            $.each(dataSrc, (i, v) => {
                var id = $(v[0]).attr('id');
                if($('#selectMultiEventAll').is(":checked")){
                    $("#"+id).prop('checked', true);
                } else {
                    $("#"+id).prop('checked', false);
                }
                $("#"+id).iCheck({
                    checkboxClass: 'icheckbox_flat-blue'
                });
                if($.inArray(halaman, cek_prod_page) === -1){
                    cek_prod_page.push(halaman);
                }
            });
        }
    });

    tabelData.on('draw', (e, data) => {
        // console.log(data);
        var halaman = tabelData.page.info().page;
        var dataSrc = data.json.data;
        if(pilih_prod.length > 0 && ($.inArray(halaman, cek_prod_page) !== -1)){
            $.each(dataSrc, (i, v) => {
                var id = $(v[0]).attr('id');
                if($('#selectMultiEventAll').is(":checked")){
                    $("#"+id).iCheck('check');
                } else {
                    var cek_id = parseInt(id.split('-')[1]);
                    if($.inArray(cek_id, pilih_prod) !== -1){
                        $("#"+id).iCheck('check');
                    }
                }
            });
        } else {
            $.each(dataSrc, (i, v) => {
                var id = $(v[0]).attr('id');
                if($('#selectMultiEventAll').is(":checked")){
                    $("#"+id).prop('checked', true);
                } else {
                    $("#"+id).prop('checked', false);
                }
                $("#"+id).iCheck({
                    checkboxClass: 'icheckbox_flat-blue'
                });
                if($.inArray(halaman, cek_prod_page) === -1){
                    cek_prod_page.push(halaman);
                }
            });
        }
        // console.log("================");
        // console.log("pilih_prod:");
        // console.log(pilih_prod);
        // console.log("cek_prod_page:");
        // console.log(cek_prod_page);
    });

    $("#table_produk").on("click", ".stokClick", function(){
        $("#modStok").modal("show");
        $("#namaProd").text($(this).parent().parent().children("td:nth-child(2)").children("span").text());
        $.ajax({
            url: "{{ route('b.produk-getProdukData') }}",
            method: "get",
            data: {
                id: $(this).attr("data-id")
            },
            beforeSend:function(){
                $("#modStok").find(".modal-body").html('<center><div class="loader vertical-align-middle loader-cube-grid"></div></center>');
            },
            success: function(data){
                $("#modStok").find(".modal-body").html(
                    '<div class="table-responsive">'+
                        '<table class="table" id="table_stokVarian">'+
                            '<thead>'+
                                '<tr>'+
                                    '<th>Foto</th>'+
                                    '<th>SKU</th>'+
                                    '<th>Varian</th>'+
                                    '<th>Stok</th>'+
                                    '<th>Harga Jual</th>'+
                                '</tr>'+
                            '</thead>'+
                            '<tbody id="isiTabel-stokVarian">'+
                            '</tbody>'+
                        '</table>'+
                    '</div>'
                );
                $.each(data, function(i, v){
                    var ukuran = (v.ukuran == null) ? "" : v.ukuran;
                    var warna = (v.warna == null) ? "" : v.warna;
                    var stok = "<a style='text-decoration:none;font-weight:bold' class='stokTooltip' id='stokRiwayat-"+v.id+"' href='{{ route('b.produk-riwayatStok') }}/"+v.id+"'>"+v.stok+"</a>";
                    $("#isiTabel-stokVarian").append(
                        "<tr>"+
                            "<td><img src='"+v.foto+"' width='50' height='50'></td>"+
                            "<td>"+v.sku+"</td>"+
                            "<td>"+ukuran+" "+warna+"</td>"+
                            "<td>"+stok+"</td>"+
                            "<td>Rp "+uangFormat(v.harga_jual_normal)+"</td>"+
                        "</tr>"
                    );
                });
                $('.stokTooltip').tooltip({
                    trigger: 'hover',
                    title: 'Lihat Riwayat Stok',
                    placement: 'top'
                });
            },
            error: function(data){
                console.log(data);
                // alert("asdasdasd");
            }
        });
    });
});
</script>
<!--uiop-->
@endsection