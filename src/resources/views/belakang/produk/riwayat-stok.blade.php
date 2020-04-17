@extends('belakang.index')
@section('isi')
<!--uiop-->
<div class="page-header page-header-bordered">
    <div class='row'>
        <div class='col-md-6'>
            <h1 class="page-title font-size-26 font-weight-100">Riwayat Stok</h1>
        </div>
        <div class='col-md-6'>
            <div class="page-header-actions">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"
                        onClick="pageLoad('{{ route('b.dashboard') }}')">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);"
                        onClick="pageLoad('{{ route('b.produk-index') }}')">Produk</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);"
                        onClick="pageLoad('{{ route('b.produk-detail', $varian->id_produk) }}')">Detail Produk ({{ $varian->nama_produk }})</a></li>
                    <li class="breadcrumb-item active">Riwayat Stok ({{ $varian->sku }})</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="page-content">
    <div class='container'>
        <div class="panel panel-bordered animation-slide-top" style='animation-delay:100ms;'>
            <div class="panel-heading">
                <h3 class="panel-title">{{ $varian->nama_produk }} ({{ $varian->sku }})</h3>
            </div>
            <div class="panel-body">
                <div class='row'>
                    <div class='col-md-12'>
                        <div class="table-responsive">
                            <table class='table table-hover' id='table_riwayat-stok'>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Masuk</th>
                                        <th>Keluar</th>
                                        <th>Sisa Stok</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var tabelData;
$(document).ready(function(){
    
    tabelData = $('#table_riwayat-stok').DataTable({
        ajax: {
            type: 'get',
            url: "{{ route('b.produk-getRiwayatStok') }}",
            data: {
                id: "{{ $id_varian }}"
            }
        },
        dom: '<"row"<".col-md-4 .col-xs-12"l><"#tombol.col-md-4 .col-xs-12"><".col-md-4 .col-xs-12"f>>t<"row"<".col-md-6 .col-xs-12"i><".col-md-6 .col-xs-12"p>>',
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        // initComplete: function(){
        // $("div[id=tombol]").html("<div class='btn-group' role='group'><a class='btn btn-secondary' href='#'>as</a><a class='btn btn-secondary' href='#'>as</a><a class='btn btn-secondary' href='#'>as</a></div>");
        // }
    });

});
</script>
<!--uiop-->
@endsection