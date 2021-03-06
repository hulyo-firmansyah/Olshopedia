@extends('belakang.index')
@section('isi')
<!--uiop-->
<style>
.selectBug{
    animation-fill-mode: backwards;
    -webkit-animation-fill-mode: backwards;
}
</style>
<div class="page-header page-header-bordered">
    <div class='row'>
        <div class='col-md-6'>
            <h1 class="page-title font-size-26 font-weight-100">Data Pembelian Produk</h1>
        </div>
        <div class='col-md-6'>
            <div class="page-header-actions">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"
                        onClick="pageLoad('{{ route('b.dashboard') }}')">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);" onClick="pageLoad('{{ route('b.produk-index') }}')">Produk</a></li>
                    <li class="breadcrumb-item active">Data Pembelian Produk</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="page-content">
    <div class='row'>
        <div class='col-lg-12'>
            <div class="panel animation-slide-bottom">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table" id="table_beli_produk">
                                    <thead>
                                        <tr>
                                            <th>No Nota</th>
                                            <th>Tanggal Beli</th>
                                            <th>Total Beli</th>
                                            <th>Tanggal Dibuat</th>
                                            <th>Tanggal Diedit</th>
                                            <th>Admin</th>
                                            <th width='10%'><span class="site-menu-icon md-settings"></span></th>
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
</div>
<script>
var tabelData;

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

$(document).ready(function(){
    tabelData = $('#table_beli_produk').DataTable({
        ajax: {
            type: 'get',
            url: "{{ route('b.produk-getDataBeli') }}",
        },
        order: [[2, "asc"]],
        dom: '<"row"<".col-md-4 .col-xs-12"l><"#tombol.col-md-4 .col-xs-12"><".col-md-4 .col-xs-12"f>>t<"row"<".col-md-6 .col-xs-12"i><".col-md-6 .col-xs-12"p>>',
        lengthMenu: [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
        ]
    });

    $("#table_beli_produk").on("click", ".btnEdit", function(){
        pageLoad('{{ route("b.produk-dataBeli_edit") }}/'+$(this).data('id'));
    });

    $("#table_beli_produk").on("click", ".btnHapus", function(){
        let id = $(this).data('id');
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
                    url: "{{ route('b.produk-beliProses') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        tipe: 'hapus'
                    },
                    success: function(data) {
                        hasil = data;
                    },
                    error: function(xhr, b, c) {
                        console.log({
                            id: id,
                            tipe: 'hapus'
                        });
                        swal("Error", '' + c, "error");
                    }
                }).done(function() {
                    if (hasil.status) {
                        swal("Berhasil!", ''+hasil.msg, "success");
                        tabelData.ajax.reload(null, false);
                    } else {
                        swal("Gagal", ''+hasil.msg, "error");
                    }
                });
            }
        });
    });

    $("#table_beli_produk").on("click", ".btnDetail", function(){
        $("#modDetail").modal("show");
        $("#notaDetail").text($(this).parent().parent().children("td:first").text());
        $.ajax({
            url: "{{ route('b.produk-getProdukBeliData') }}",
            method: "get",
            data: {
                id: $(this).attr("data-id")
            },
            beforeSend:function(){
                $("#modDetail").find(".modal-body").html('<center><div class="loader vertical-align-middle loader-cube-grid"></div></center>');
            },
            success: function(data){
                // console.log(data);
                $("#modDetail").find(".modal-body").html(
                    '<div class="table-responsive">'+
                        '<table class="table" id="table_detailBeli">'+
                            '<thead>'+
                                '<tr>'+
                                    '<th>Foto</th>'+
                                    '<th>SKU</th>'+
                                    '<th>Nama Produk</th>'+
                                    '<th>Supplier</th>'+
                                    '<th>Harga Beli</th>'+
                                    '<th>Jumlah</th>'+
                                    '<th>Subtotal</th>'+
                                '</tr>'+
                            '</thead>'+
                            '<tbody id="isiTabel-detailBeli">'+
                            '</tbody>'+
                        '</table>'+
                    '</div>'
                );
                var total = 0;
                $.each(data, function(i, v){
                    if(v.terhapus){
                        let subtotal = v.jumlah * v.harga_beli;
                        total += subtotal;
                        $("#isiTabel-detailBeli").append(
                            "<tr>"+
                                "<td><img src='"+v.foto+"' width='50' height='50'></td>"+
                                "<td>[?Terhapus?]</td>"+
                                "<td>[?Terhapus?]</td>"+
                                "<td>[?Terhapus?]</td>"+
                                "<td>Rp "+uangFormat(v.harga_beli)+"</td>"+
                                "<td>"+v.jumlah+"</td>"+
                                "<td>Rp "+uangFormat(subtotal)+"</td>"+
                            "</tr>"
                        );
                    } else {
                        let dataProd = v;
                        var nama_prod_tampil = dataProd.nama_produk;
                        if((dataProd.ukuran != null && dataProd.ukuran != "") && (dataProd.warna != null && dataProd.warna != "")){
                            nama_prod_tampil += " ("+dataProd.ukuran+" "+dataProd.warna+") ";
                        } else if((dataProd.ukuran != null && dataProd.ukuran != "") && (dataProd.warna == null || dataProd.warna == "")){
                            nama_prod_tampil += " ("+dataProd.ukuran+") ";
                        } else if((dataProd.ukuran == null || dataProd.ukuran == "") && (dataProd.warna != null && dataProd.warna != "")){
                            nama_prod_tampil += " ("+dataProd.warna+") ";
                        }
                        let subtotal = v.jumlah * v.harga_beli;
                        total += subtotal;
                        $("#isiTabel-detailBeli").append(
                            "<tr>"+
                                "<td><img src='"+v.foto+"' width='50' height='50'></td>"+
                                "<td>"+v.sku+"</td>"+
                                "<td>"+nama_prod_tampil+"</td>"+
                                "<td>"+v.supplier+"</td>"+
                                "<td>Rp "+uangFormat(v.harga_beli)+"</td>"+
                                "<td>"+v.jumlah+"</td>"+
                                "<td>Rp "+uangFormat(subtotal)+"</td>"+
                            "</tr>"
                        );
                    }
                });
                $("#isiTabel-detailBeli").append(
                    "<tr>"+
                        "<th colspan='6'><span class='float-right' style='color:#526069'>Total</span></th>"+
                        "<td>Rp "+uangFormat(total)+"</td>"+
                    "</tr>"
                );
            },
            error: function(data){
                console.log(data);
                // alert("asdasdasd");
            }
        });
    });

});
</script>
<!-- modal stok -->
<div class="modal fade" id="modDetail" aria-hidden="true" aria-labelledby="exampleModalTitle"
    role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTabs">Detail Pembelian Produk (<span id='notaDetail'></span>)</h4>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<!--uiop-->
@endsection