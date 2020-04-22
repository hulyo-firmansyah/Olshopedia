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
            <h1 class="page-title font-size-26 font-weight-100">Edit Pembelian Produk ({{ $data_beli->no_nota }})</h1>
        </div>
        <div class='col-md-6'>
            <div class="page-header-actions">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"
                        onClick="pageLoad('{{ route('b.dashboard') }}')">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);" onClick="pageLoad('{{ route('b.produk-index') }}')">Produk</a></li>
                    <li class="breadcrumb-item active">Edit Pembelian Produk ({{ $data_beli->no_nota }})</li>
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
                    <div class='panel-footer' id='beliDiv-btnEdit'>
                        <button type='button' class='btn btn-warning' data-color="yellow" data-style="expand-right" id='btnEditBeli' onClick='$(this).submitForm()'>Edit Data Pembelian</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--uiop-->
@endsection