@extends('belakang.index')
@section('isi')
<!--uiop-->
<style>
.dropify-wrapper {
    width: 180px
}
.box-foto {
    box-shadow: 0px 0px 5px 0px #11c26d;
    padding: 5px;
    border-radius: 20px;
    margin-bottom: 10px;
    display:block;
}
</style>
<div class="page-header page-header-bordered">
    <div class='row'>
        <div class='col-md-6'>
            <h1 class="page-title font-size-26 font-weight-100">Tambah Produk</h1>
        </div>
        <div class='col-md-6'>
            <div class="page-header-actions">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"
                        onClick="pageLoad('{{ route('b.dashboard') }}')">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);"
                        onClick="pageLoad('{{ route('b.produk-index') }}')">Produk</a></li>
                    <li class="breadcrumb-item active">Tambah Produk</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="page-content">
    @if ($msg_sukses = Session::get('msg_success'))
    <div class='alert alert-success' role='alert' id='al-success'><i class='fa fa-check'></i> SUCCESS: {{$msg_sukses}}</div>
    @endif
    @if ($msg_error = Session::get('msg_error'))
    <div class='alert alert-danger' role='alert' id='al-error'><i class='fa fa-minus-circle'></i> ERROR: {{$msg_error}}</div>
    @endif
    <form id="form_produk_tambah" method='post' action='{{ route("b.produk-proses") }}' enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-lg-9">
                <div class="panel animation-slide-left">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label><b>Nama Produk</b></label>
                                <input type="text" class="form-control" id="nama_produk" name="nama_produk" value='{{ old("nama_produk") }}'
                                    placeholder="Masukkan Nama Produk"
                                    onKeyDown='$(this).bersihError();errorValidasi = 0'>
                                <small id="error_nama_produk" class='hidden'></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label><b>Supplier</b></label>
                                <select class="form-control" name="supplier" id="sSupplier" >
                                    <option value='0' @if($msg_error = Session::get('msg_error')) @if(old('supplier') == 0) selected @endif @endif>Stok sendiri</option>
                                    @foreach($supplier as $su)
                                        <option value='{{ $su->id_supplier }}' @if($msg_error = Session::get('msg_error')) @if(old('supplier') == $su->id_supplier) selected @endif @endif>{{ $su->nama_supplier }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label><b>Kategori</b></label>
                                <select class="form-control" name="kategori" id="sKategori">
                                    <option value='#' disabled selected>-- Pilih Kategori --</option>
                                    @foreach($kategori as $k)
                                    <option value='{{ $k->id_kategori_produk }}' @if($msg_error = Session::get('msg_error')) @if(old('kategori', null) != null && old('kategori', null) == $k->id_kategori_produk) selected @endif @endif>{{ $k->nama_kategori_produk }}</option>
                                    @endforeach
                                </select>
                                <small>Tambahkan Kategori Di menu <a href='javascript:void(0)'
                                        onClick="pageLoad('{{ route('b.produkKategori-index') }}')">Kategori</a></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label><b>Keterangan</b></label>
                                <textarea class="form-control" name="keterangan" id="keterangan"
                                    placeholder="Isi Keterangan">{{ old("keterangan") }}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-12 form-group">
                                <label><b>Berat (Gram)</b></label>
                                <div class="input-group">
                                    <input type="text" min="1" class="form-control" name="berat"
                                        onKeyDown='$(this).bersihError("berat");errorValidasi = 0'
                                        onMouseDown='$(this).bersihError("berat");errorValidasi = 0' value='{{ old("berat") }}'/>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Gr</span>
                                    </div>
                                </div>
                                <small id="error_berat" class='hidden'></small>
                            </div>
                            <div class="col-md-2 col-sm-12 form-group varianDiv_all" style="
                                                    @if($msg_error = Session::get('msg_error'))
                                                        @if(old('sVarian', null) == null)
                                                            display:none
                                                        @endif
                                                    @else
                                                        display:none
                                                    @endif
                                                        ">
                                <label><b>Kategori Varian</b></label>
                                <ul class="list-unstyled">
                                    <li class="mb-5">
                                        <input type="checkbox" name='sUkuran' id='icUkuran' @if($msg_error = Session::get('msg_error')) @if(old('sUkuran', null) != null) checked @endif @endif/>
                                        <label for='icUkuran' class='ml-5'>Ukuran</label>
                                    </li>
                                    <li class="mb-5">
                                        <input type="checkbox" name='sWarna' id='icWarna'  @if($msg_error = Session::get('msg_error')) @if(old('sWarna', null) != null) checked @endif @endif/>
                                        <label for='icWarna' class='ml-5'>Warna</label>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-2 col-sm-12 form-group diskonDiv" style="
                                                    @if($msg_error = Session::get('msg_error'))
                                                        @if(old('sDiskon', null) == null)
                                                            display:none
                                                        @endif
                                                    @else
                                                        display:none
                                                    @endif
                                                        ">
                                <label><b>Tipe Diskon</b></label>
                                <ul class="list-unstyled">
                                    <li class="mb-5">
                                        <input type="radio" name='tDiskon' id='icDiskon1' value='persen' @if($msg_error = Session::get('msg_error')) 
                                                                                                            @if(old('sDiskon', null) != null) 
                                                                                                                @if(old('tDiskon') == 'persen') 
                                                                                                                    checked 
                                                                                                                @endif
                                                                                                            @endif 
                                                                                                        @else  
                                                                                                            checked
                                                                                                        @endif/>
                                        <label for='icDiskon1' class='ml-5'>Persen</label>
                                    </li>
                                    <li class="mb-5">
                                        <input type="radio" name='tDiskon' id='icDiskon2' value='langsung' @if($msg_error = Session::get('msg_error')) @if(old('sDiskon', null) != null) @if(old('tDiskon') == 'langsung') checked @endif @endif @endif/>
                                        <label for='icDiskon2' class='ml-5'>Harga Langsung</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table class="table table_varian" id="table_varian"  onMouseEnter='mouseOverDiskon()' onMouseLeave='mouseOutDiskon()'>
                                        <thead style='background:#3e8ef7'>
                                            <tr>
                                                <th style="color:white;width:190px" class='text-center'>Foto Produk</th>
                                                <th style="color:white" class='text-center'>Spesifikasi</th>
                                                <th style="color:white" colspan='2' class='text-center'>Harga</th>
                                                <th style="color:white;
                                                    @if($msg_error = Session::get('msg_error'))
                                                        @if(old('sVarian', null) == null)
                                                            display:none
                                                        @endif
                                                    @else
                                                        display:none
                                                    @endif
                                                        " class='varianDiv_all text-center'>
                                                    Varian</th>
                                                <th style="color:white;width:20px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($msg_error = Session::get('msg_error'))
                                                {!! $varian_form !!}
                                            @else
                                            <tr id='idVarian-1' class='varianDiv_tetap'>
                                                <td>
                                                    
                                                    <!-- <input type="file" id="gambar-1" accept='image/*'
                                                            name='produk[1][gambar]'> -->
                                                    <button class="btn btn-success btn-block btn-outline" style='height:100%' data-target="#modTambahFoto-1" data-toggle="modal" type="button"><i class='fa fa-plus'></i> Tambahkan Foto</button>
                                                </td>
                                                <td>
                                                    <span class="lbl">SKU</span>
                                                    <input type="text"
                                                        style="min-width:230px;max-width:100%;width:100%;position:relative"
                                                        class="form-control sku form-200" name="produk[1][sku]"
                                                        id='sku-1' value="{{ $offset_prod }}">
                                                    <span class="lbl">Stok</span>
                                                    <div id='stokDiv-1' class='stokDiv'>
                                                        <input type="text" name="produk[1][stok]" id='stok-1'
                                                            class="form-control jumlah_stok form-100"
                                                            style="min-width:230px;max-width:100%;width:100%;position:relative"
                                                            placeholder='0' data-rex="number"
                                                        onKeyDown='$(this).bersihError();errorValidasi = 0'
                                                        onMouseDown='$(this).bersihError();errorValidasi = 0' />
                                                        <small id="error_stok-1" class='hidden'></small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="label-harga_beli-1">Harga Beli</span>
                                                    <input type="text" id="harga_beli-1" name='produk[1][harga_beli]'
                                                        class="form-control harga_beli harbel1"
                                                        onKeyDown='$(this).bersihError();errorValidasi = 0'
                                                        onMouseDown='$(this).bersihError();errorValidasi = 0' data-rex="number"
                                                        style="min-width:230px;max-width:100%;width:100%;position:relative" />
                                                    <small id="error_harga_beli-1" class='hidden'></small>
                                                    <div class='diskonDiv' style="
                                                    @if($msg_error = Session::get('msg_error'))
                                                        @if(old('sDiskon', null) == null)
                                                            display:none
                                                        @endif
                                                    @else
                                                        display:none
                                                    @endif
                                                        ">
                                                        <span>Diskon Jual</span>
                                                        <div class="input-group"
                                                            style="min-width:230px;max-width:100%;width:100%;position:relative">
                                                            <input type="text" class="form-control" placeholder="0"
                                                                name='produk[1][diskon]' id="diskon-1"  data-rex="number"/>
                                                            <div class="input-group-append diskonDiv_persen">
                                                                <span class="input-group-text">%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="lbl">Harga Jual Normal</span>
                                                    <input type="text" name='produk[1][harga_jual]' id="harga_jual-1"
                                                        onKeyDown='$(this).bersihError("harga_jual");errorValidasi = 0' data-rex="number"
                                                        onMouseDown='$(this).bersihError("harga_jual");errorValidasi = 0'
                                                        style="min-width:230px;max-width:100%;width:100%;position:relative"
                                                        class="form-control rentangCekError">
                                                    <small id="error_harga_jual-1" class='hidden'></small>
                                                    <div class="lbl resellerDiv" style='display:none'>Harga Jual
                                                        Reseller</div>
                                                    <input type="text" name='produk[1][harga_reseller]' data-rex="number"
                                                        id="harga_reseller-1"
                                                        style="min-width:230px;max-width:100%;width:100%;position:relative;display:none"
                                                        class="form-control resellerDiv" />
                                                </td>
                                                <td class='varianDiv_all' style='display:none'>
                                                    <span class="lbl size varianDiv_ukuran"
                                                        style='display:none'>Ukuran</span>
                                                    <input type="text" pattern="^[a-zA-Z0-9-/+&.() ]+$"
                                                        name='produk[1][ukuran]' id='ukuran-1'
                                                        style="min-width:230px;max-width:100%;width:100%;position:relative;display:none"
                                                        class="form-control size form-100 mbtm-10 varianDiv_ukuran"
                                                        maxlength="150" />
                                                    <span class="lbl warna varianDiv_warna"
                                                        style='display:none'>Warna</span>
                                                    <input type="text" pattern="^[a-zA-Z0-9-/+&.,() ]+$"
                                                        name='produk[1][warna]' id='warna-1'
                                                        style="min-width:230px;max-width:100%;width:100%;position:relative;display:none"
                                                        class="form-control warna form-100 mbtm-10 varianDiv_warna"
                                                        maxlength="150" />
                                                </td>
                                                <td>
                                                    <button
                                                        class="btn btn-danger btn-pure icon fa fa-close varianDiv_all"
                                                        style='display:none' type="button" id='hVarian-1'
                                                        onClick='$(this).hapusVarian($(this).attr("id"))'>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row varianDiv_all" style="
                                                    @if($msg_error = Session::get('msg_error'))
                                                        @if(old('sVarian', null) == null)
                                                            display:none
                                                        @endif
                                                    @else
                                                        display:none
                                                    @endif
                                                        ">
                            <div class="col-md-12 text-center form-group">
                                <button type='button' class="btn btn-primary btn-outline" id="btn_tambah_varian"><i
                                        class='fa fa-plus'></i> Varian</button>
                            </div>
                        </div>
                        <div class="row" id='grosirDiv' style="
                                                    @if($msg_error = Session::get('msg_error'))
                                                        @if(old('sGrosir', null) == null)
                                                            display:none
                                                        @endif
                                                    @else
                                                        display:none
                                                    @endif
                                                        ">
                            <div class="col-md-7 form-group">
                                <label><b>Grosir</b></label>
                                <div class="table-responsive">
                                    <table class="table" id="table_grosir">
                                        <thead style='background:#3e8ef7'>
                                            <tr>
                                                <th width="50%" class="text-center" style='color:white;'>Rentang</th>
                                                <th width="50%" class="text-center" style='color:white;'>Harga Satuan
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control rentangCekError"
                                                            name='rentan[1][min]' value='{{ old("rentan")[1]["min"] ?? "" }}'/>
                                                        <div class="input-group-prepend input-group-append">
                                                            <span class="input-group-text"><i
                                                                    class='fa fa-minus'></i></span>
                                                        </div>
                                                        <input type="text" class="form-control rentangCekError"
                                                            name='rentan[1][max]' value='{{ old("rentan")[1]["max"] ?? "" }}'/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Rp.</span>
                                                        </div>
                                                        <input type="text" class="form-control rentangCekError"
                                                            name='rentan[1][harga_grosir]' value='{{ old("rentan")[1]["harga_grosir"] ?? "" }}'/>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control rentangCekError"
                                                            name='rentan[2][min]' value='{{ old("rentan")[2]["min"] ?? "" }}'/>
                                                        <div class="input-group-prepend input-group-append">
                                                            <span class="input-group-text"><i
                                                                    class='fa fa-minus'></i></span>
                                                        </div>
                                                        <input type="text" class="form-control rentangCekError"
                                                            name='rentan[2][max]' value='{{ old("rentan")[2]["max"] ?? "" }}'/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Rp.</span>
                                                        </div>
                                                        <input type="text" class="form-control rentangCekError"
                                                            name='rentan[2][harga_grosir]' value='{{ old("rentan")[2]["harga_grosir"] ?? "" }}'/>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control rentangCekError"
                                                            name='rentan[3][min]' value='{{ old("rentan")[3]["min"] ?? "" }}'/>
                                                        <div class="input-group-prepend input-group-append">
                                                            <span class="input-group-text"><i
                                                                    class='fa fa-minus'></i></span>
                                                        </div>
                                                        <input type="text" class="form-control rentangCekError"
                                                            name='rentan[3][max]' value='{{ old("rentan")[3]["max"] ?? "" }}'/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Rp.</span>
                                                        </div>
                                                        <input type="text" class="form-control rentangCekError"
                                                            name='rentan[3][harga_grosir]' value='{{ old("rentan")[3]["harga_grosir"] ?? "" }}'/>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control rentangCekError"
                                                            name='rentan[4][min]' value='{{ old("rentan")[4]["min"] ?? "" }}'/>
                                                            <div class="input-group-prepend input-group-append">
                                                            <span class="input-group-text"><i
                                                                    class='fa fa-minus'></i></span>
                                                        </div>
                                                        <input type="text" class="form-control rentangCekError"
                                                            name='rentan[4][max]' value='{{ old("rentan")[4]["max"] ?? "" }}'/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Rp.</span>
                                                        </div>
                                                        <input type="text" class="form-control rentangCekError"
                                                            name='rentan[4][harga_grosir]' value='{{ old("rentan")[4]["harga_grosir"] ?? "" }}'/>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control rentangCekError"
                                                            name='rentan[5][min]' value='{{ old("rentan")[5]["min"] ?? "" }}'/>
                                                        <div class="input-group-prepend input-group-append">
                                                            <span class="input-group-text"><i
                                                                    class='fa fa-minus'></i></span>
                                                        </div>
                                                        <input type="text" class="form-control rentangCekError"
                                                            name='rentan[5][max]' value='{{ old("rentan")[5]["max"] ?? "" }}'/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Rp.</span>
                                                        </div>
                                                        <input type="text" class="form-control rentangCekError"
                                                            name='rentan[5][harga_grosir]' value='{{ old("rentan")[5]["harga_grosir"] ?? "" }}'/>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class='col-md-5 form-group'>
                                <label><b>Catatan</b></label>
                                <ul>
                                    <li>Rentang jumlah dimulai dari 2 (jika kurang tidak bisa digunakan)</li>
                                    <li>Jika akan menambah harga grosir, maka harga varian produk harus sama</li>
                                </ul>
                                <label><b>Contoh</b></label>
                                <ul>
                                    <li>Rentang: 2 - 5 (Harga: Rp 10.000)</li>
                                    <li>Rentang: 6 - 10 (Harga: Rp 8.000)</li>
                                </ul>
                                <div id='error_grosir' style='color:#ff4c52;display:none;'>
                                    <label><b>Error Grosir</b></label>
                                    <ul id='error_grosir_list'>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="panel animation-slide-right">
                    <div class="panel-body">
                        <h4 class="text-center">Produk Setting</h4>
                        <hr>
                        <div class='text-center form-group'>
                            <div class='row'>
                                <div class='col-md-6 col-sm-6'>
                                    <label>Varian</label>
                                </div>
                                <div class='col-md-6 col-sm-6'>
                                    <input type="checkbox" id="toggleVarian" class='js-switch' name="sVarian" @if($msg_error = Session::get('msg_error')) @if(old('sVarian', null) != null) checked @endif @endif/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-6 col-sm-6'>
                                    <label>Grosir</label>
                                </div>
                                <div class='col-md-6 col-sm-6'>
                                    <input type="checkbox" id="toggleGrosir" class='js-switch' name="sGrosir" @if($msg_error = Session::get('msg_error')) @if(old('sGrosir', null) != null) checked @endif @endif/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-6 col-sm-6'>
                                    <label>Diskon Jual</label>
                                </div>
                                <div class='col-md-6 col-sm-6'>
                                    <input type="checkbox" id="toggleDiskon" class='js-switch' name="sDiskon" @if($msg_error = Session::get('msg_error')) @if(old('sDiskon', null) != null) checked @endif @endif/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-6 col-sm-6'>
                                    <label>Reseller</label>
                                </div>
                                <div class='col-md-6 col-sm-6'>
                                    <input type="checkbox" id="toggleReseller" class='js-switch' name="sReseller" @if($msg_error = Session::get('msg_error')) @if(old('sReseller', null) != null) checked @endif @endif/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-primary btn-block" type="button" id="simpan_produk"
                                onClick='$(this).submitForm("simpan")'>Simpan
                                Produk</button>
                            <button class="btn btn-info btn-block" type="button" id="simpan_produk_tambah"
                                onClick='$(this).submitForm("tambah")'>Simpan dan
                                Tambah Produk</button>
                            <a href="javascript:void(0);" class='btn btn-warning btn-block' onClick="pageLoad('{{ route('b.produk-index') }}')">Kembali</a>
                        </div>
                    </div>
                </div>
                <div class='alert dark alert-alt alert-info' role='alert' style='display:none' id='tips_diskon'>
                    <h4>Catatan Diskon</h4>
                    <p>Diskon Jual yang bertipe persen diskon maximal 100%, semisal diisi lebih maka akan tetap tersimpan 100%.</p>
                </div>
                @if ($msg_error = Session::get('msg_error'))
                    <div class='alert dark alert-alt alert-success' role='alert'>
                        <h4>Catatan Foto Produk</h4>
                        <p>Jika terjadi error saat menambahkan produk dan produk sebelumnya yang mau ditambahkan ada fotonya, maka silahkan ulangi menambahkan foto tersebut.</p>
                    </div>
                @endif
            </div>
        </div>
        <input type='hidden' name='jumlah_varian'>
        <input type='hidden' name='tData'>
        <input type='hidden' name='tipe_kirim_produk' value='{{ base64_encode("tambah") }}'>
    </form>
</div>

@if($msg_error = Session::get('msg_error'))
    @foreach(old("produk") as $opr => $oprv)
        <!-- modal tambah foto {{ $opr }} -->
        <div class="modal fade" id="modTambahFoto-{{ $opr }}" aria-hidden="true" aria-labelledby="exampleModalTitle"
            role="dialog" tabindex="-1">
            <div class="modal-dialog modal-simple modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="exampleModalTabs">Tambah Foto</h4>
                    </div>
                    <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                        <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab" href="#tabFoto_{{ $opr }}-utama" aria-controls="tabFoto_{{ $opr }}-utama" role="tab">Utama</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#tabFoto_{{ $opr }}-lain" aria-controls="tabFoto_{{ $opr }}-lain" role="tab">Lainnya</a></li>
                    </ul>
                    <div class="modal-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabFoto_{{ $opr }}-utama" role="tabpanel">
                                <center>
                                    <input type="file" id="foto_{{ $opr }}-1" accept='.jpeg,.jpg,.png,.gif' name='produk[{{ $opr }}][foto][1]'>
                                </center>
                            </div>
                            <div class="tab-pane" id="tabFoto_{{ $opr }}-lain" role="tabpanel">
                                <center>
                                    <div class='d-inline-flex'>
                                        <input type="file" id="foto_{{ $opr }}-2" accept='.jpeg,.jpg,.png,.gif' name='produk[{{ $opr }}][foto][2]'>
                                        <input type="file" id="foto_{{ $opr }}-3" accept='.jpeg,.jpg,.png,.gif' name='produk[{{ $opr }}][foto][3]'>
                                        <input type="file" id="foto_{{ $opr }}-4" accept='.jpeg,.jpg,.png,.gif' name='produk[{{ $opr }}][foto][4]'>
                                    </div>
                                    <div class='d-inline-flex mt-15'>
                                        <input type="file" id="foto_{{ $opr }}-5" accept='.jpeg,.jpg,.png,.gif' name='produk[{{ $opr }}][foto][5]'>
                                        <input type="file" id="foto_{{ $opr }}-6" accept='.jpeg,.jpg,.png,.gif' name='produk[{{ $opr }}][foto][6]'>
                                        <input type="file" id="foto_{{ $opr }}-7" accept='.jpeg,.jpg,.png,.gif' name='produk[{{ $opr }}][foto][7]'>
                                    </div>
                                </center>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
<!-- modal tambah foto 1 -->
<div class="modal fade" id="modTambahFoto-1" aria-hidden="true" aria-labelledby="exampleModalTitle"
    role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTabs">Tambah Foto</h4>
            </div>
            <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab" href="#tabFoto_1-utama" aria-controls="tabFoto_1-utama" role="tab">Utama</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#tabFoto_1-lain" aria-controls="tabFoto_1-lain" role="tab">Lainnya</a></li>
            </ul>
            <div class="modal-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tabFoto_1-utama" role="tabpanel">
                        <center>
                            <input type="file" id="foto_1-1" accept='.jpeg,.jpg,.png,.gif' name='produk[1][foto][1]'>
                        </center>
                    </div>
                    <div class="tab-pane" id="tabFoto_1-lain" role="tabpanel">
                        <center>
                            <div class='d-inline-flex'>
                                <input type="file" id="foto_1-2" accept='.jpeg,.jpg,.png,.gif' name='produk[1][foto][2]'>
                                <input type="file" id="foto_1-3" accept='.jpeg,.jpg,.png,.gif' name='produk[1][foto][3]'>
                                <input type="file" id="foto_1-4" accept='.jpeg,.jpg,.png,.gif' name='produk[1][foto][4]'>
                            </div>
                            <div class='d-inline-flex mt-15'>
                                <input type="file" id="foto_1-5" accept='.jpeg,.jpg,.png,.gif' name='produk[1][foto][5]'>
                                <input type="file" id="foto_1-6" accept='.jpeg,.jpg,.png,.gif' name='produk[1][foto][6]'>
                                <input type="file" id="foto_1-7" accept='.jpeg,.jpg,.png,.gif' name='produk[1][foto][7]'>
                            </div>
                        </center>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style='border-top:1px solid #e4eaec;'>
                <button type='button' class='btn btn-success mt-15'>Tambahkan</button>
                <button type='button' class='btn btn-default mt-15'>Batal</button>
            </div>
        </div>
    </div>
</div>
@endif
<script>
@php
    if($msg_error = Session::get('msg_error')){
        $ols_ = [];
        foreach(old("produk") as $i_ols => $ols){
            $ols_[] = (int)$i_ols;
        }
        echo "var varianProduk = ".json_encode($ols_).";";
        sort($ols_, SORT_NUMERIC);
        echo "var iJumlah_varian = ".count(old("produk")).";";
        echo "var iAkhir_varian = ".$ols_[count($ols_)-1].";";
		if(old("sUkuran") == 'on' && old('sUkuran', null) != null){
			echo "var tUkuran = true;";
		} else {
			echo "var tUkuran = false;";
		}
		if(old("sWarna") == 'on' && old('sWarna', null) != null){
			echo "var tWarna = true;";
		} else {
			echo "var tWarna = false;";
		}
		if(old("sDiskon") == 'on' && old('sDiskon', null) != null){
			echo "var tDiskon = true;";
		} else {
			echo "var tDiskon = false;";
		}
		if(old("tDiskon") == 'persen' && old('tDiskon', null) != null){
			echo "var tTipeDiskon = true;";
		} else {
			echo "var tTipeDiskon = false;";
		}
		if(old("sReseller") == 'on' && old('sReseller', null) != null){
			echo "var tReseller = true;";
		} else {
			echo "var tReseller = false;";
		}
    } else {
        echo "var iAkhir_varian = iJumlah_varian = 1;var tUkuran = tWarna = tDiskon = tReseller = false;var tTipeDiskon = true;var varianProduk = [1];";
    }
@endphp
var cekJumlahVarian;
var errorValidasi = 0;
var varian_data = ['harga_beli]', 'diskon]', 'harga_jual]', 'harga_reseller]', 'ukuran]', 'warna]', 'stok]'];
var grosir_data = ['min]', 'max]', 'harga_grosir]'];
var offset_prod = '{{ $offset_prod }}'.split('V')[0];

function mouseOverDiskon(){
    if($('#toggleDiskon').is(':checked')){
        $("#tips_diskon").show();
        $("#tips_diskon").attr("class", "alert dark alert-alt alert-info animation-slide-right");
    }
}

function mouseOutDiskon(){
    if($('#toggleDiskon').is(':checked') || $('#tips_diskon').is(':visible')){
        $("#tips_diskon").attr("class", "alert dark alert-alt alert-info animation-reverse animation-slide-left");
        $("#tips_diskon").hide();
    }
}

(function(world) {
    world.fn.hapusVarian = function(id_varian) {
        if (iJumlah_varian > 1) {
            var id = id_varian.split('-');
            $('#hVarian-' + id[1]).tooltip('dispose');
            $('#idVarian-' + id[1]).remove();
            $('#modTambahFoto-' + id[1]).remove();
            var t_id = varianProduk.indexOf(parseInt(id[1]));
            varianProduk.splice(t_id, 1);
            iJumlah_varian--;
        }
    }

    world.fn.bersihError = function(elm = this) {
        if(elm == 'harga_jual'){
            $(this).attr('class', 'form-control rentangCekError');
        } else {
            $(this).attr('class', 'form-control');
        }
        if (elm == 'berat') {
            $(this).parent().parent().children('small').attr('class', '');
            $(this).parent().parent().children('small').empty();
        } else {
            $(this).parent().children('small').attr('class', '');
            $(this).parent().children('small').empty();
        }
    }

    world.fn.submitForm = function(tipeD) {
        clearInterval(cekJumlahVarian);
        var data = $('#form_produk_tambah').serializeArray();
        var cekGrosir = false;
        var cekSupplier = false;
        var temp_grosir_min = [], temp_grosir_max = [], cek_harga_jual = [];
        var tanpaCharSpesial = /[^a-zA-z0-9 ]/gm;
        // return console.log(data);
        $.each(data, function(i, d) {
            if(d.name == 'sGrosir' && d.value == 'on'){
                cekGrosir = true;
                return false;
            }
        });
        $.each(data, function(i, d) {
            if (d.value == '' && d.name == 'nama_produk') {
                $('#nama_produk').attr('class', 'form-control is-invalid animation-shake');
                $('#error_nama_produk').show();
                $('#error_nama_produk').attr('class', 'invalid-feedback');
                $('#error_nama_produk').html('Nama Produk tidak boleh kosong!');
                errorValidasi++;
            }
            if (d.value != '' && d.name == 'nama_produk' && d.value.length > 35) {
                $('#nama_produk').attr('class', 'form-control is-invalid animation-shake');
                $('#error_nama_produk').show();
                $('#error_nama_produk').attr('class', 'invalid-feedback');
                $('#error_nama_produk').html('Nama Produk tidak boleh lebih dari 35 karakter!');
                errorValidasi++;
            }
            if (d.value != '' && d.name == 'nama_produk' && tanpaCharSpesial.test(d.value)) {
                $('#nama_produk').attr('class', 'form-control is-invalid animation-shake');
                $('#error_nama_produk').show();
                $('#error_nama_produk').attr('class', 'invalid-feedback');
                $('#error_nama_produk').html('Nama Produk hanya bisa menggunakan a-z, A-Z, 0-9!');
                errorValidasi++;
            }
            if (d.value == '' && d.name == 'berat') {
                $('input[name=berat]').attr('class', 'form-control is-invalid animation-shake');
                $('small#error_berat').show();
                $('small#error_berat').attr('class', 'invalid-feedback');
                $('small#error_berat').html('Berat tidak boleh kosong!');
                errorValidasi++;
            }
            if (d.value != '' && d.name == 'berat' && parseInt(d.value) > 1000000) {
                $('input[name=berat]').attr('class', 'form-control is-invalid animation-shake');
                $('small#error_berat').show();
                $('small#error_berat').attr('class', 'invalid-feedback');
                $('small#error_berat').attr('style', 'display:inline;');
                $('small#error_berat').html('Berat tidak boleh lebih dari 1000Kg!');
                errorValidasi++;
            }
            if(d.name == 'supplier' && d.value != '0'){
                cekSupplier = true;
            }
            var varian = d.name.split('[');
            $.each(varian_data, function(iV, dV) {
                if (varian[2] == dV) {
                    var iQ = varian[1].split(']');
                    if (dV == 'harga_beli]' && d.value == '') {
                        $('#harga_beli-' + iQ[0]).attr('class',
                            'form-control is-invalid animation-shake');
                        $('small#error_harga_beli-' + iQ[0]).show();
                        $('small#error_harga_beli-' + iQ[0]).attr('class',
                            'invalid-feedback');
                        $('small#error_harga_beli-' + iQ[0]).html((cekSupplier == false ? 'Harga Beli' : 'Harga Bayar ke Supplier')+' tidak boleh kosong!');
                        errorValidasi++;
                    }
                    if (dV == 'harga_beli]' && d.value != '' && parseInt(d.value) > 1000000000) {
                        $('#harga_beli-' + iQ[0]).attr('class',
                            'form-control is-invalid animation-shake');
                        $('small#error_harga_beli-' + iQ[0]).show();
                        $('small#error_harga_beli-' + iQ[0]).attr('class',
                            'invalid-feedback');
                        $('small#error_harga_beli-' + iQ[0]).html((cekSupplier == false ? 'Harga Beli' : 'Harga Bayar ke Supplier')+' tidak boleh lebih dari 1.000.000.000!');
                        errorValidasi++;
                    }
                    if (dV == 'harga_jual]' && d.value == '') {
                        $('#harga_jual-' + iQ[0]).attr('class',
                            'form-control is-invalid animation-shake');
                        $('small#error_harga_jual-' + iQ[0]).show();
                        $('small#error_harga_jual-' + iQ[0]).attr('class',
                            'invalid-feedback');
                        $('small#error_harga_jual-' + iQ[0]).html(
                            'Harga Jual tidak boleh kosong!');
                        errorValidasi++;
                    }
                    if (dV == 'harga_jual]' && d.value != '' && parseInt(d.value) > 1000000000) {
                        $('#harga_jual-' + iQ[0]).attr('class',
                            'form-control is-invalid animation-shake');
                        $('small#error_harga_jual-' + iQ[0]).show();
                        $('small#error_harga_jual-' + iQ[0]).attr('class',
                            'invalid-feedback');
                        $('small#error_harga_jual-' + iQ[0]).html(
                            'Harga Jual tidak boleh lebih dari 1.000.000.000!');
                        errorValidasi++;
                    }
                    if (dV == 'harga_jual]' && d.value != '') {
                        cek_harga_jual.push(parseInt(d.value));
                    }
                    if (dV == 'stok]' && d.value != '' && parseInt(d.value) > 1000000) {
                        $('#stok-' + iQ[0]).attr('class',
                            'form-control is-invalid animation-shake');
                        $('small#error_stok-' + iQ[0]).show();
                        $('small#error_stok-' + iQ[0]).attr('class',
                            'invalid-feedback');
                        $('small#error_stok-' + iQ[0]).html(
                            'Stok tidak boleh lebih dari 1.000.000!');
                        errorValidasi++;
                    }
                }
            });
            if(cekGrosir){
                var grosir = d.name.split('[');
                if(grosir[0] == 'rentan'){
                    var index_grosir = grosir[1].split('')[0];
                    if (grosir[2] == "min]" && d.value != '') {
                        temp_grosir_min.push(parseInt(d.value));
                    }
                    if (grosir[2] == "max]" && d.value != '') {
                        temp_grosir_max.push(parseInt(d.value));
                    }
                }
            }
        });
        var cek_harga_unique = cek_harga_jual.filter((value, index, self) => { 
            return self.indexOf(value) === index;
        });
        if(cek_harga_unique.length > 1 && cekGrosir){
            if($('#error_grosir_unique').length == 0){
                $('#error_grosir_list').append('<li id="error_grosir_unique">Grosir tidak bisa ditambah, jika harga jual varian produk tidak sama!</li>');
            }
            if(!$('#error_grosir').is(':visible')){
                $('#table_grosir').addClass('animation-shake');
                $('#table_grosir').children('thead').attr('style', 'background:#ff4c52');
                $('#error_grosir').show();
            }
            errorValidasi++;
        }
        // console.log(temp_grosir_min);
        // console.log(temp_grosir_max);
        if(cekGrosir){
            $.each(temp_grosir_max, function(iA, vA){
                $.each(temp_grosir_min, function(iI, vI){
                    if(iA == iI){
                        // console.log('==================== Same');
                        // console.log('Min['+iI+']: '+vI);
                        // console.log('Max['+iA+']: '+vA);
                        // console.log('---');
                        if(vA < vI){
                            // console.log('Max['+iA+'] < Min['+iI+'] = true');
                            if($('#error_grosir_max').length == 0){
                                $('#error_grosir_list').append('<li id="error_grosir_max">Max tidak boleh kurang dari Min!</li>');
                            }
                            if(!$('#error_grosir').is(':visible')){
                                $('#table_grosir').addClass('animation-shake');
                                $('#table_grosir').children('thead').attr('style', 'background:#ff4c52');
                                $('#error_grosir').show();
                            }
                            errorValidasi++;
                        }
                    }
                });
            });
            $.each(temp_grosir_min, function(iI, vI){
                if(vI < 2){
                    if($('#error_grosir_min1').length == 0){
                        $('#error_grosir_list').append('<li id="error_grosir_min1">Min tidak boleh kurang dari 2!</li>');
                    }
                    if(!$('#error_grosir').is(':visible')){
                        $('#table_grosir').addClass('animation-shake');
                        $('#table_grosir').children('thead').attr('style', 'background:#ff4c52');
                        $('#error_grosir').show();
                    }
                    errorValidasi++;
                }
                if(iI > 0){
                    // console.log('==================== Min');
                    // console.log('Min['+iI+']: '+vI);
                    // console.log('Min['+(iI-1)+']: '+temp_grosir_min[iI-1]);
                    // console.log('Max['+(iI-1)+']: '+temp_grosir_max[iI-1]);
                    // console.log('---');
                    if(vI <= temp_grosir_min[iI-1]){
                        // console.log('Min['+iI+'] < Min['+(iI-1)+'] = true');
                        if($('#error_grosir_minToMin').length == 0){
                            $('#error_grosir_list').append('<li id="error_grosir_minToMin">Min tidak boleh kurang dari Min sebelumnya!</li>');
                        }
                        if(!$('#error_grosir').is(':visible')){
                            $('#table_grosir').addClass('animation-shake');
                            $('#table_grosir').children('thead').attr('style', 'background:#ff4c52');
                            $('#error_grosir').show();
                        }
                        errorValidasi++;
                    }
                    if(vI <= temp_grosir_max[iI-1]){
                        // console.log('Min['+iI+'] < Max['+(iI-1)+'] = true');
                        if($('#error_grosir_minToMax').length == 0){
                            $('#error_grosir_list').append('<li id="error_grosir_minToMax">Min tidak boleh kurang dari Max sebelumnya!</li>');
                        }
                        if(!$('#error_grosir').is(':visible')){
                            $('#table_grosir').addClass('animation-shake');
                            $('#table_grosir').children('thead').attr('style', 'background:#ff4c52');
                            $('#error_grosir').show();
                        }
                        errorValidasi++;
                    }
                }
            });
            $.each(temp_grosir_max, function(iA, vA){
                if(vA < 2){
                    if($('#error_grosir_max1').length == 0){
                        $('#error_grosir_list').append('<li id="error_grosir_max1">Max tidak boleh kurang dari 2!</li>');
                    }
                    if(!$('#error_grosir').is(':visible')){
                        $('#table_grosir').addClass('animation-shake');
                        $('#table_grosir').children('thead').attr('style', 'background:#ff4c52');
                        $('#error_grosir').show();
                    }
                    errorValidasi++;
                }
                if(iA > 0){
                    // console.log('==================== Max');
                    // console.log('Max['+iA+']: '+vA);
                    // console.log('Max['+(iA-1)+']: '+temp_grosir_max[iA-1]);
                    // console.log('Min['+(iA-1)+']: '+temp_grosir_min[iA-1]);
                    // console.log('---');
                    if(vA <= temp_grosir_min[iA-1]){
                        // console.log('Max['+iA+'] < Min['+(iA-1)+'] = true');
                        if($('#error_grosir_maxToMin').length == 0){
                            $('#error_grosir_list').append('<li id="error_grosir_maxToMin">Max tidak boleh kurang dari Min sebelumnya!</li>');
                        }
                        if(!$('#error_grosir').is(':visible')){
                            $('#table_grosir').addClass('animation-shake');
                            $('#table_grosir').children('thead').attr('style', 'background:#ff4c52');
                            $('#error_grosir').show();
                        }
                        errorValidasi++;
                    }
                    if(vA <= temp_grosir_max[iA-1]){
                        // console.log('Max['+iA+'] < Max['+(iA-1)+'] = true');
                        if($('#error_grosir_maxToMax').length == 0){
                            $('#error_grosir_list').append('<li id="error_grosir_maxToMax">Max tidak boleh kurang dari Max sebelumnya!</li>');
                        }
                        if(!$('#error_grosir').is(':visible')){
                            $('#table_grosir').addClass('animation-shake');
                            $('#table_grosir').children('thead').attr('style', 'background:#ff4c52');
                            $('#error_grosir').show();
                        }
                        errorValidasi++;
                    }
                }
            });
        }
        // return;
        // console.log(errorValidasi);
        if (errorValidasi === 0) {
            $('input[name=tData]').val(tipeD);
            var jumlah_varian = parseInt($("input[name=jumlah_varian]").val());
            // for(var tya=1; tya<=jumlah_varian; tya++){
            $.each(varianProduk, (iaa, tya) => {
                $('#form_produk_tambah').append($("#foto_"+tya+"-1").addClass("hidden"));
                $('#form_produk_tambah').append($("#foto_"+tya+"-2").addClass("hidden"));
                $('#form_produk_tambah').append($("#foto_"+tya+"-3").addClass("hidden"));
                $('#form_produk_tambah').append($("#foto_"+tya+"-4").addClass("hidden"));
                $('#form_produk_tambah').append($("#foto_"+tya+"-5").addClass("hidden"));
                $('#form_produk_tambah').append($("#foto_"+tya+"-6").addClass("hidden"));
                $('#form_produk_tambah').append($("#foto_"+tya+"-7").addClass("hidden"));
            });
            // }
            // var dataHasil = $('#form_produk_tambah').serializeArray();
            // $('#form_produk_tambah').append($("<textarea>").attr("name", "dataHasil").val(JSON.stringify(dataHasil)));
            $('#form_produk_tambah').submit();
        } else {
            cekJumlahVarian = setInterval(function() {
                $('input[name=jumlah_varian]').val(iJumlah_varian);
            }, 300);
        }
    }
})(jQuery);
$(document).ready(function() {
    $('.rentangCekError').on('input', function(){
        errorValidasi = 0;
        if($('#error_grosir').is(':visible')){
            $('#table_grosir').removeClass('animation-shake');
            $('#table_grosir').children('thead').attr('style', 'background:#3e8ef7');
            $('#error_grosir_list').html('');
            $('#error_grosir').hide();
        }
    });

    $('#table_varian').on('input', '.rentangCekError', function(){
        errorValidasi = 0;
        if($('#error_grosir').is(':visible')){
            $('#table_grosir').removeClass('animation-shake');
            $('#table_grosir').children('thead').attr('style', 'background:#3e8ef7');
            $('#error_grosir_list').html('');
            $('#error_grosir').hide();
        }
    });

    $("#sSupplier").change(function() {
        errorValidasi = 0;
    });

    $("#table_grosir").on("input", "input", function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $("#table_varian").on("input", "input[data-rex=number]", function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $(".panel").on("input", "input[name=berat]", function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
    @if($msg_error = Session::get('msg_error'))
        @if(old('supplier', 0) != 0)
            @foreach(old("produk") as $opr => $oprv)
                $('#stok-{{ $opr }}').selectpicker({
                    style: 'btn-outline btn-default'
                });
            @endforeach
        @endif
    @endif
    @if($msg_sukses = Session::get('msg_success'))
    window.setTimeout(function() {
        $('#al-success').animate({
            height: 'toggle'
        }, 'slow');
    }, 5000);
    @endif
    @if($msg_error = Session::get('msg_error'))
    window.setTimeout(function() {
        $('#al-error').animate({
            height: 'toggle'
        }, 'slow');
    }, 8000);
    @endif

    cekJumlahVarian = setInterval(function() {
        // console.log(varianProduk);
        $('input[name=jumlah_varian]').val(iJumlah_varian);
    }, 300);

    $.fn.selectpicker.Constructor.BootstrapVersion = '4';
    $('#sKategori').selectpicker({
        liveSearch: true,
        style: 'btn-outline btn-default'
    });
    $('#sSupplier').selectpicker({
        liveSearch: true,
        style: 'btn-outline btn-default'
    });

@if($msg_error = Session::get('msg_error'))
    @foreach(old("produk") as $opr => $oprv)
        for(var i=1; i<=7; i++){
            $('#foto_{{ $opr }}-'+i).dropify({
                // defaultFile: "{{ asset('template/assets/images/default.jpg') }}",
                height: 166,
                errorsPosition: 'outside',
                messages: {
                    'default': 'Drag and drop a file here or click',
                    'replace': 'Drag and drop or click to replace',
                    'remove': '<i class="fa fa-trash"></i>',
                    'error': 'Ooops, something wrong happended.'
                },
                error: {
                    'fileSize': 'The file size is too big ({value} max).',
                    'minWidth': 'The image width is too small ({value}px min).',
                    'maxWidth': 'The image width is too big ({value}px max).',
                    'minHeight': 'The image height is too small ({value}px min).',
                    'maxHeight': 'The image height is too big ({value}px max).',
                    'imageFormat': 'The iowed ({value} only).'
                }
            });
        }
    @endforeach
@else
    var dropify_1 = [];
    for(var i=1; i<=7; i++){
        dropify_1[i] = $('#foto_1-'+i).dropify({
            // defaultFile: "{{ asset('template/assets/images/default.jpg') }}",
            height: 166,
            errorsPosition: 'outside',
            messages: {
                'default': 'Drag and drop a file here or click',
                'replace': 'Drag and drop or click to replace',
                'remove': '<i class="fa fa-trash"></i>',
                'error': 'Ooops, something wrong happended.'
            },
            error: {
                'fileSize': 'The file size is too big ({value} max).',
                'minWidth': 'The image width is too small ({value}px min).',
                'maxWidth': 'The image width is too big ({value}px max).',
                'minHeight': 'The image height is too small ({value}px min).',
                'maxHeight': 'The image height is too big ({value}px max).',
                'imageFormat': 'The iowed ({value} only).'
            }
        });
        dropify_1[i].on('dropify.afterClear', function(event, element){
            let box = $('#idVarian-1').children('td:first');
            box.children('.box-foto[data-id=box-foto-'+i+']').remove();
        });
        dropify_1[i].on('change', function(){
            let filename = $(this).val().split('\\')[2];
            let box = $('#idVarian-1').children('td:first');
            if(box.children('.box-foto[data-id=box-foto-'+i+']').length < 1){
                box.prepend("<span class='box-foto' data-id='box-foto-"+i+"'>"+filename+"</span>");
            } else {
                box.children('.box-foto[data-id=box-foto-'+i+']').text(filename);
            }
        });
    }
@endif
@if($msg_error = Session::get('msg_error'))
    @foreach(old("produk") as $opr => $oprv)
        $('#hVarian-{{ $opr }}').tooltip({
            trigger: 'hover',
            title: 'Hapus Varian',
            placement: 'left'
        });
    @endforeach
@else
    $('#hVarian-1').tooltip({
        trigger: 'hover',
        title: 'Hapus Varian',
        placement: 'left'
    });
@endif
    $('#icUkuran').iCheck({
        checkboxClass: 'icheckbox_flat-blue'
    });
    $('#icWarna').iCheck({
        checkboxClass: 'icheckbox_flat-blue'
    });
    $('input[type=radio]').iCheck({
        radioClass: 'iradio_flat-blue'
    });
    var list_checkbox = Array.prototype.slice.call($('.js-switch'));
    list_checkbox.forEach(function(html) {
        var switchery = new Switchery(html, {
            color: '#3e8ef7',
            size: 'small'
        });
    });


    $('#toggleGrosir').change(function() {
        if ($(this).is(':checked')) {
            $('#grosirDiv').show();
        } else {
            $('#grosirDiv').hide();
        }
    });
    $('#toggleReseller').change(function() {
        var ini = $(this);
        tReseller = ini.is(':checked');
        var list_diskonDiv = Array.prototype.slice.call($('.resellerDiv'));
        list_diskonDiv.forEach(function(html) {
            if (ini.is(':checked')) {
                $(html).show();
            } else {
                $(html).hide();
            }
        });
    });
    $('#toggleDiskon').change(function() {
        var ini = $(this);
        tDiskon = ini.is(':checked');
        var list_diskonDiv = Array.prototype.slice.call($('.diskonDiv'));
        list_diskonDiv.forEach(function(html) {
            if (ini.is(':checked')) {
                $(html).show();
            } else {
                $(html).hide();
            }
        });
    });
    $('input[name=tDiskon]').on('ifChecked', function(e) {
        var ini = $(e.target);
        if (ini.is(':checked') && ini.attr('id') == 'icDiskon1') {
            tTipeDiskon = true;
            $('.diskonDiv_persen').show();
        } else if (ini.is(':checked') && ini.attr('id') == 'icDiskon2') {
            tTipeDiskon = false;
            $('.diskonDiv_persen').hide();
        }
    });
    $('#toggleVarian').change(function() {
        var cek = false;
        var ini = $(this);
        var list_diskonDiv = Array.prototype.slice.call($('.varianDiv_all'));
        list_diskonDiv.forEach(function(html) {
            if (ini.is(':checked')) {
                $(html).show();
            } else {
                $(html).hide();
            }
        });
        if (!ini.is(':checked')) {
            if ($('.varianDiv_tetap').length) {
                var list_diskonDiv_hilang = Array.prototype.slice.call($('.varianDiv_hilang'));
                list_diskonDiv_hilang.forEach(function(html) {
                    $(html).remove();
                    iAkhir_varian = iJumlah_varian = 1;
                    varianProduk = [1];
                });
            } else {
                var list_diskonDiv_hilang = Array.prototype.slice.call($('.varianDiv_hilang'));
                list_diskonDiv_hilang.forEach(function(html) {
                    if (!cek) {
                        cek = !cek;
                        $(html).attr('id', 'idVarian-1');
                        $(html).children('td:last').children('button').attr('id', 'hVarian-1');
                        $(html).children('td:last').children('button').attr('class',
                            'btn btn-danger btn-pure icon fa fa-close varianDiv_all');
                        $(html).children('td:last').children('button').attr('style',
                            'display:none');
                        $(html).children('td:nth-child(2)').children('input:first').attr('name',
                            'produk[1][sku]');
                        $(html).children('td:nth-child(2)').children('input:first').attr('id',
                            'sku-1');
                        $(html).children('td:nth-child(2)').children('div').attr('id',
                            'stokDiv-1');
                        $(html).children('td:nth-child(2)').children('div').children().attr(
                            'name',
                            'produk[1][stok]');
                        $(html).children('td:nth-child(2)').children('div').children().attr(
                            'id',
                            'stok-1');
                        $(html).children('td:nth-child(3)').children('span:first').attr('class',
                            'label-harga_beli-1');
                        $(html).children('td:nth-child(3)').children('input:first').attr('name',
                            'produk[1][harga_beli]');
                        $(html).children('td:nth-child(3)').children('input:first').attr('id',
                            'harga_beli-1');
                        $(html).children('td:nth-child(3)').children('small:first').attr('id',
                            'error_harga_beli-1');
                        $(html).children('td:nth-child(3)').children('div').children('div')
                            .children('input').attr('name', 'produk[1][diskon]');
                        $(html).children('td:nth-child(3)').children('div').children('div')
                            .children('input').attr('id', 'diskon-1');
                        $(html).children('td:nth-child(4)').children('input:first').attr('name',
                            'produk[1][harga_jual]');
                        $(html).children('td:nth-child(4)').children('input:first').attr('id',
                            'harga_jual-1');
                        $(html).children('td:nth-child(4)').children('small:first').attr('id',
                            'error_harga_jual-1');
                        $(html).children('td:nth-child(4)').children('input:last').attr('name',
                            'produk[1][harga_reseller]');
                        $(html).children('td:nth-child(4)').children('input:last').attr('id',
                            'harga_reseller-1');
                        $(html).children('td:nth-child(5)').children('input:first').attr('name',
                            'produk[1][ukuran]');
                        $(html).children('td:nth-child(5)').children('input:first').attr('id',
                            'ukuran-1');
                        $(html).children('td:nth-child(5)').children('small:first').attr('id',
                            'error_ukuran-1');
                        $(html).children('td:nth-child(5)').children('input:last').attr('name',
                            'produk[1][warna]');
                        $(html).children('td:nth-child(5)').children('input:last').attr('id',
                            'warna-1');
                        $(html).children('td:nth-child(5)').children('small:last').attr('id',
                            'error_warna-1');
                    } else {
                        $(html).remove();
                        iAkhir_varian = iJumlah_varian = 1;
                        varianProduk = [1];
                    }
                });
            }
        }
    });
    $('#icUkuran').on('ifToggled', function(e) {
        var ini = tUkuran = e.target.checked;
        var list_diskonDiv_switch = Array.prototype.slice.call($('.varianDiv_ukuran'));
        list_diskonDiv_switch.forEach(function(html) {
            if (ini) {
                $(html).show();
            } else {
                $(html).hide();
            }
        });

    });
    $('#icWarna').on('ifToggled', function(e) {
        var ini = tWarna = e.target.checked;
        var list_diskonDiv_switch = Array.prototype.slice.call($('.varianDiv_warna'));
        list_diskonDiv_switch.forEach(function(html) {
            if (ini) {
                $(html).show();
            } else {
                $(html).hide();
            }
        });
    });

    $('#btn_tambah_varian').click(function() {
        var hasil, tU, tW, tD, tR, tTD, tS, hasil2;
        iAkhir_varian++;
        tU = (tUkuran === false) ? "display:none" : "";
        tW = (tWarna === false) ? "display:none" : "";
        tD = (tDiskon === false) ? "display:none" : "";
        tR = (tReseller === false) ? "display:none" : "";
        tTD = (tTipeDiskon === false) ? "display:none" : "";
        $.ajax({
            url: "{{ route('b.produk-tambahForm') }}",
            data: {
                i: iAkhir_varian,
                ic_ukuran: tU,
                ic_warna: tW,
                ic_diskon: tD,
                ic_reseller: tR,
                ic_tipe_diskon: tTD,
                offset_prod: offset_prod
            },
            type: 'get',
            beforeSend: function() {
                $('#btn_tambah_varian').prop('disabled', function(i, v) {
                    return !v;
                });
                $('#table_varian').children('tbody').append(
                    "<tr id='loader'><td colspan='6'><div class='example-loading example-well h-150 vertical-align text-center'><div class='loader vertical-align-middle loader-ellipsis'></div></div></td></tr>"
                );
            },
            success: function(data) {
                hasil = data;
            }
        }).done(function() {
            $.ajax({
                url: "{{ route('b.produk-tambahModalFoto') }}",
                data: {
                    i: iAkhir_varian
                },
                type: 'get',
                success: function(data2) {
                    hasil2 = data2;
                }
            }).done(function() {
                $('#table_varian').children('tbody').children('#loader').remove();
                $('#table_varian').children('tbody').append(hasil);
                $('.page').append(hasil2);
                $('#btn_tambah_varian').prop('disabled', function(i, v) {
                    return !v;
                });
                $('#stok-' + iAkhir_varian).selectpicker({
                    style: 'btn-outline btn-default'
                });
                $('#hVarian-' + iAkhir_varian).tooltip({
                    trigger: 'hover',
                    title: 'Hapus Varian',
                    placement: 'left'
                });
                for(var ys=1; ys<=7; ys++){
                    $('#foto_' + iAkhir_varian + '-' + ys).dropify({
                        // defaultFile: "{{ asset('template/assets/images/default.jpg') }}",
                        height: 176,
                        errorsPosition: 'outside',
                        messages: {
                            'default': 'Drag and drop a file here or click',
                            'replace': 'Drag and drop or click to replace',
                            'remove': '<i class="fa fa-trash"></i>',
                            'error': 'Ooops, something wrong happended.'
                        },
                        error: {
                            'fileSize': 'The file size is too big ({value} max).',
                            'minWidth': 'The image width is too small ({value}px min).',
                            'maxWidth': 'The image width is too big ({value}px max).',
                            'minHeight': 'The image height is too small ({value}px min).',
                            'maxHeight': 'The image height is too big ({value}px max).',
                            'imageFormat': 'The image format is not allowed ({value} only).'
                        }
                    });
                }
            });
            iJumlah_varian++;
            varianProduk.push(iAkhir_varian);
        });
    });

});
</script>
<!--uiop-->
@endsection