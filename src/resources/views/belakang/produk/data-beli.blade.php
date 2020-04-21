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

});
</script>
<!--uiop-->
@endsection