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
    <div class='container'>
        <div class='row'>
            <div class='col-xxl-6'>
            </div>
            <div class='col-xxl-6'>
                <div class='panel p-15 animation-slide-top selectBug' style='animation-delay:300ms'>
                    <div class='d-flex'>
                        <select id='f_tipe' class='mr-10'>
                            <option value='nama_supplier'>Nama Supplier</option>
                            <option value='no_nota' >Nomer Nota</option>
                            <option value='tgl_beli' >Tanggal Pembelian</option>
                        </select>
                        <input type="text" class="form-control mr-10" style='border-color:#3e8ef7' value='' id='f_cari' placeholder='Cari berdasarkan Nama Supplier' autocomplete='off'>
                        <button type="button" class="btn btn-icon btn-primary" id='btnFilter'><i class="icon fa-filter" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-xxl-12'>
                <div class='panel'>
                    <div class='panel-body'>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        
        $('#f_tipe').selectpicker({
            style: 'btn-primary'
        });
    });
</script>
<!--uiop-->
@endsection