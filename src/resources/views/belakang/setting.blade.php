@extends('belakang.index')
@section('title', 'Settings')
@section('isi')
<!--uiop-->
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="page-header page-header-bordered">
    <h1 class="page-title font-size-26 font-weight-100">Settings</h1>
    <div class="page-header-actions">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);"
                    onClick="pageLoad('{{ route('b.dashboard') }}')">Dashboard</a></li>
            <li class="breadcrumb-item active">Settings</li>
        </ol>
    </div>
</div>

{{-- Hiddens Data --}}
<input type="hidden" id="h_storeId" value="{{$store->id_store}}">
<input type="hidden" id="h_fotoId" value="{{$store->foto_id}}">
<input type="hidden" id="h_namaToko" value="{{$store->nama_toko}}">
{{-- End of Hiddens Data --}}

<div class="page-content">
    @if ($msg_sukses = Session::get('msg_success'))
    <div class='alert alert-success' role='alert' id='al-success'><i class='fa fa-check'></i> SUCCESS: {{$msg_sukses}}</div>
    @endif
    @if ($msg_error = Session::get('msg_error'))
    <div class='alert alert-danger' role='alert' id='al-error'><i class='fa fa-minus-circle'></i> ERROR: {{$msg_error}}</div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="nav-tabs-horizontal nav-tabs-inverse nav-tabs-animate animation-slide-top" style='animation-delay:80ms'>
                <ul class="nav nav-tabs nav-tabs-solid" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-toggle="tab" href="#umumSide" aria-controls="umumSide"
                            role="tab" aria-expanded="true">
                            <i class="icon wb-settings"></i>Umum
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-toggle="tab" href="#tokoSide" aria-controls="tokoSide"
                            role="tab" aria-expanded="true">
                            <i class="icon md-store"></i>Toko
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-toggle="tab" href="#orderSide" aria-controls="orderSide" role="tab" id='orderSideTombol'
                            aria-expanded="false">
                            <i class="icon md-shopping-cart"></i>Order
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-toggle="tab" href="#cekOngkirSide" aria-controls="orderSide" role="tab"
                            aria-expanded="false">
                            <i class="icon fa-map-signs"></i>Cek Ongkir
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-toggle="tab" href="#productSide" aria-controls="productSide"
                            role="tab" aria-expanded="true">
                            <i class="icon fa-cubes"></i>Product
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-toggle="tab" href="#customerSide" aria-controls="customerSide"
                            role="tab" aria-expanded="true">
                            <i class="icon wb-users"></i>Customer
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-toggle="tab" href="#paymentSide" aria-controls="paymentSide" id='paymentSideTombol'
                            role="tab" aria-expanded="true">
                            <i class="icon fa-bank"></i>Payment
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-toggle="tab" href="#templateSide" aria-controls="templateSide"
                            role="tab" aria-expanded="true">
                            <i class="icon wb-library"></i>StoreFront
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-toggle="tab" href="#userSide" aria-controls="userSide" role="tab" id='userSideTombol'
                            aria-expanded="true">
                            <i class="icon fa-users"></i>User
                        </a>
                    </li>
                </ul>

                <!-- -- Setting toko -- -->
                <div class="tab-content">
                    <!-- -- Pengaturan toko -- -->
                    <div class="tab-pane active animation-slide-top" id="tokoSide" role="tabpanel">
                        <form autocomplete="off" id="formToko">
                            <div class="row">
                                <div class="col-xxl-3">
                                    <h5 class="example-title">Logo Toko</h5>
                                    <div class="example">
                                        <input type='text' class='hidden' name='logoTemp' id='logoTemp' value="{{ $tmp_logo['id'] }}" />
                                        <input type="file" id="logoToko" accept="image/*" name="logoToko" />
                                    </div>
                                </div>
                                <div class="col-xxl-9">
                                    <h5 class="example-title">Pengaturan Toko</h5>
                                    <div class="panel-body container-fluid">
                                        <div class="form-group form-material">
                                            <label class="form-control-label" for="namaToko">Nama Toko</label>
                                            <input type="text" class="form-control" id="namaToko" name="namaToko"
                                                placeholder="Nama Toko" value="{{$store->nama_toko}}" />
                                        </div>
                                        <div class="form-group form-material">
                                            <label class="form-control-label" for="no_telpToko">No Hp</label>
                                            <input type="text" class="form-control" id="no_telpToko"
                                                name="no_telpToko" placeholder="No HP"
                                                value="{{$store->no_telp_toko}}" />
                                        </div>
                                        <div class="form-group form-material">
                                            <label class="form-control-label" for="deskripsiToko">Deskripsi</label>
                                            <textarea class="form-control" id="deskripsiToko" name="deskripsiToko"
                                                rows="3"
                                                placeholder="Deskripsi">{{$store->deskripsi_toko}}</textarea>
                                        </div>
                                        <div class="form-group form-material">
                                            <label class="form-control-label" for="alamatToko">Alamat</label>
                                            <textarea class="form-control" id="alamatToko" name="alamatToko"
                                                rows="3" placeholder="Alamat">{{$store->alamat_toko}}</textarea>
                                        </div>
                                        <div class="form-group form-material">
                                            <button type="button" class="btn btn-primary"
                                                name="btnUpdateToko">Simpan </button>
                                            <button type="reset" class="btn btn-default btn-outline"
                                                id="resetFromToko">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- -- Pengaturan umum -- -->
                    <div class="tab-pane animation-slide-top" id="umumSide" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h4 class="example-title">Pengaturan Umum</h4>
                            </div>
                        </div>
                        <hr>
                        <div class='row ml-10 mr-10'>
                            <div class='col-xxl-6 p-15' style="border:1px solid #e4eaec;">
                                Hapus Data Cache &nbsp;<i class='icon fa-question-circle' id='cache-help'></i>
                                <span class='float-right'>
                                    <button type='button' class='btn btn-danger btn-xs' id='btnHapusDataCache'>Hapus Cache</button>
                                </span>
                            </div>
                            <div class='col-xxl-6 p-15' style="border:1px solid #e4eaec;">
                                Log Aktivitas
                                <span class='float-right'>
                                    <a href="javascript:void(0)" onClick="pageLoad('{{ route('b.log-index') }}')" class='btn btn-primary btn-xs'>Lihat Log Aktifitas</a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- -- Pengaturan order -- -->
                    <div class="tab-pane animation-slide-top" id="orderSide" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h4 class="example-title">Pengaturan Order</h4>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xxl-5">
                                <div class="example">
                                    <form autocomplete="off">
                                        <div class="form-group form-material">
                                            <label class="form-control-label" for="inputText">Simpan order dengan
                                                nama</label><br>
                                            <p id="order_nama_on" class='@if($store->s_order_nama == "off") hidden @endif'>On: Input order dengan mencantumkan nama customer,
                                                dan default
                                                ekspedisi COD.</p>
                                            <p id="order_nama_off" class='@if($store->s_order_nama == "on") hidden @endif'>Off: Input order dengan tidak mencantumkan nama
                                                customer, dan
                                                default ekspedisi COD.</p>
                                            <input type="checkbox" class="js-switch" id="namaOrder" name="namaOrder"
                                                @if($store->s_order_nama == "on") Checked @endif/>
                                        </div>
                                        <div class="form-group form-material">
                                            <label class="form-control-label" for="inputText">Tampilkan
                                                Logo</label><br>
                                            <p id="logo_on" class='@if($store->s_tampil_logo == "off") hidden @endif'>On: Tampilkan logo di semua shipping label.</p>
                                            <p id="logo_off" class='@if($store->s_tampil_logo == "on") hidden @endif'>Off: Sembunyikan logo di semua shipping label.</p>
                                            <input type="checkbox" class="js-switch" id="tampilLogo"
                                                name="tampilLogo" @if($store->s_tampil_logo == "on") Checked @endif />
                                        </div>
                                        <div class="form-group form-material">
                                            <label class="form-control-label" for="inputText">Order
                                                Source</label><br>
                                            <p id="source_on" class='@if($store->s_order_source == "off") hidden @endif'>On: Aktifkan order source.</p>
                                            <p id="source_off" class='@if($store->s_order_source == "on") hidden @endif'>Off: Nonaktifkan order source.</p>
                                            <input type="checkbox" class="js-switch" id="orderSource"
                                                name="orderSource" @if($store->s_order_source == "on") Checked @endif />
                                        </div>
                                        <div class="form-group form-material">
                                            <button type="button" class="btn btn-primary"
                                                name="btnUpdateOrderSource">Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <hr>
                            </div>
                            <div class="col-xxl-7">
                                <div class="form-group form-material">
                                    <span><b>Data Order Source</b></span>
                                    <button type="button" data-target="#tambahOrderSource" data-toggle="modal"
                                        class="btn btn-success btn-xs float-right"><i class="icon fa-plus"></i>
                                        Tambah Order Source</button><br><br>
                                    <div class='table-responsive'>
                                        <table class="table table-hover table-striped w-full" id="tableOrderSource">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Nama & Keterangan</th>
                                                    <th>Status</th>
                                                    <th><span class="site-menu-icon md-settings"></span></th>
                                                </tr>
                                            </thead>
                                            <tbody id="isiTableOrderSource">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group form-material">
                                    <span><b>Data Filter Order</b></span>
                                    <div class='table-responsive'>
                                        <table class="table table-hover table-striped w-full" id="tableFilterOrder">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Nama Filter</th>
                                                    <th><span class="site-menu-icon md-settings"></span></th>
                                                </tr>
                                            </thead>
                                            <tbody id="isiTablefilterOrder">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- -- Pengaturan cek ongkir -- -->
                    <div class="tab-pane animation-slide-top" id="cekOngkirSide" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h4 class="example-title">Pengaturan Cek Ongkir</h4>
                            </div>
                        </div>
                        <hr>
                        <p>
                            Mengaktifkan atau Menonaktifkan pengecekan ongkos kirim.
                        </p>
                        <div class='row ml-10 mr-10'>
                            <div class='col-xxl-3 col-xl-4 col-lg-6 p-10' style="border:1px solid #e4eaec;">
                                Jalur Nugraha Ekakurir (JNE)
                                <span class='float-right'>
                                    <input type='checkbox' name='ongkir_jne' id='ongkir_jne' class='js-switch' @if($cekOngkir->jne) checked @endif>
                                </span>
                            </div>
                            <div class='col-xxl-3 col-xl-4 col-lg-6 p-10' style="border:1px solid #e4eaec;">
                                POS Indonesia (POS)
                                <span class='float-right'>
                                    <input type='checkbox' name='ongkir_pos' id='ongkir_pos' class='js-switch' @if($cekOngkir->pos) checked @endif>
                                </span>
                            </div>
                            <div class='col-xxl-3 col-xl-4 col-lg-6 p-10' style="border:1px solid #e4eaec;">
                                Citra Van Titipan Kilat (TIKI)
                                <span class='float-right'>
                                    <input type='checkbox' name='ongkir_tiki' id='ongkir_tiki' class='js-switch' @if($cekOngkir->tiki) checked @endif>
                                </span>
                            </div>
                            <div class='col-xxl-3 col-xl-4 col-lg-6 p-10' style="border:1px solid #e4eaec;">
                                Priority Cargo and Package (PCP)
                                <span class='float-right'>
                                    <input type='checkbox' name='ongkir_pcp' id='ongkir_pcp' class='js-switch' @if($cekOngkir->pcp) checked @endif>
                                </span>
                            </div>
                            <div class='col-xxl-3 col-xl-4 col-lg-6 p-10' style="border:1px solid #e4eaec;">
                                Eka Sari Lorena (ESL)
                                <span class='float-right'>
                                    <input type='checkbox' name='ongkir_esl' id='ongkir_esl' class='js-switch' @if($cekOngkir->esl) checked @endif>
                                </span>
                            </div>
                            <div class='col-xxl-3 col-xl-4 col-lg-6 p-10' style="border:1px solid #e4eaec;">
                                RPX Holding (RPX)
                                <span class='float-right'>
                                    <input type='checkbox' name='ongkir_rpx' id='ongkir_rpx' class='js-switch' @if($cekOngkir->rpx) checked @endif>
                                </span>
                            </div>
                            <div class='col-xxl-3 col-xl-4 col-lg-6 p-10' style="border:1px solid #e4eaec;">
                                Pandu Logistics (PANDU)
                                <span class='float-right'>
                                    <input type='checkbox' name='ongkir_pandu' id='ongkir_pandu' class='js-switch' @if($cekOngkir->pandu) checked @endif>
                                </span>
                            </div>
                            <div class='col-xxl-3 col-xl-4 col-lg-6 p-10' style="border:1px solid #e4eaec;">
                                Wahana Prestasi Logistik (WAHANA)
                                <span class='float-right'>
                                    <input type='checkbox' name='ongkir_wahana' id='ongkir_wahana' class='js-switch' @if($cekOngkir->wahana) checked @endif>
                                </span>
                            </div>
                            <div class='col-xxl-3 col-xl-4 col-lg-6 p-10' style="border:1px solid #e4eaec;">
                                SiCepat Express (SICEPAT)
                                <span class='float-right'>
                                    <input type='checkbox' name='ongkir_sicepat' id='ongkir_sicepat' class='js-switch' @if($cekOngkir->sicepat) checked @endif>
                                </span>
                            </div>
                            <div class='col-xxl-3 col-xl-4 col-lg-6 p-10' style="border:1px solid #e4eaec;">
                                J&T Express (J&T)
                                <span class='float-right'>
                                    <input type='checkbox' name='ongkir_jnt' id='ongkir_jnt' class='js-switch' @if($cekOngkir->jnt) checked @endif>
                                </span>
                            </div>
                            <div class='col-xxl-3 col-xl-4 col-lg-6 p-10' style="border:1px solid #e4eaec;">
                                Pahala Kencana Express (PAHALA)
                                <span class='float-right'>
                                    <input type='checkbox' name='ongkir_pahala' id='ongkir_pahala' class='js-switch' @if($cekOngkir->pahala) checked @endif>
                                </span>
                            </div>
                            <div class='col-xxl-3 col-xl-4 col-lg-6 p-10' style="border:1px solid #e4eaec;">
                                SAP Express (SAP)
                                <span class='float-right'>
                                    <input type='checkbox' name='ongkir_sap' id='ongkir_sap' class='js-switch' @if($cekOngkir->sap) checked @endif>
                                </span>
                            </div>
                            <div class='col-xxl-3 col-xl-4 col-lg-6 p-10' style="border:1px solid #e4eaec;">
                                JET Express (JET)
                                <span class='float-right'>
                                    <input type='checkbox' name='ongkir_jet' id='ongkir_jet' class='js-switch' @if($cekOngkir->jet) checked @endif>
                                </span>
                            </div>
                            <div class='col-xxl-3 col-xl-4 col-lg-6 p-10' style="border:1px solid #e4eaec;">
                                Solusi Ekspres (SLIS)
                                <span class='float-right'>
                                    <input type='checkbox' name='ongkir_slis' id='ongkir_slis' class='js-switch' @if($cekOngkir->slis) checked @endif>
                                </span>
                            </div>
                            <div class='col-xxl-3 col-xl-4 col-lg-6 p-10' style="border:1px solid #e4eaec;">
                                21 Express (DSE)
                                <span class='float-right'>
                                    <input type='checkbox' name='ongkir_dse' id='ongkir_dse' class='js-switch' @if($cekOngkir->dse) checked @endif>
                                </span>
                            </div>
                            <div class='col-xxl-3 col-xl-4 col-lg-6 p-10' style="border:1px solid #e4eaec;">
                                First Logistics (FIRST)
                                <span class='float-right'>
                                    <input type='checkbox' name='ongkir_first' id='ongkir_first' class='js-switch' @if($cekOngkir->first) checked @endif>
                                </span>
                            </div>
                            <div class='col-xxl-3 col-xl-4 col-lg-6 p-10' style="border:1px solid #e4eaec;">
                                Nusantara Card Semesta (NCS)
                                <span class='float-right'>
                                    <input type='checkbox' name='ongkir_ncs' id='ongkir_ncs' class='js-switch' @if($cekOngkir->ncs) checked @endif>
                                </span>
                            </div>
                            <div class='col-xxl-3 col-xl-4 col-lg-6 p-10' style="border:1px solid #e4eaec;">
                                Star Cargo (STAR)
                                <span class='float-right'>
                                    <input type='checkbox' name='ongkir_star' id='ongkir_star' class='js-switch' @if($cekOngkir->star) checked @endif>
                                </span>
                            </div>
                            <div class='col-xxl-3 col-xl-4 col-lg-6 p-10' style="border:1px solid #e4eaec;">
                                Lion Parcel (LION)
                                <span class='float-right'>
                                    <input type='checkbox' name='ongkir_lion' id='ongkir_lion' class='js-switch' @if($cekOngkir->lion) checked @endif>
                                </span>
                            </div>
                            <div class='col-xxl-3 col-xl-4 col-lg-6 p-10' style="border:1px solid #e4eaec;">
                                Ninja Xpress (NINJA)
                                <span class='float-right'>
                                    <input type='checkbox' name='ongkir_ninja' id='ongkir_ninja' class='js-switch' @if($cekOngkir->ninja) checked @endif>
                                </span>
                            </div>
                            <div class='col-xxl-3 col-xl-4 col-lg-6 p-10' style="border:1px solid #e4eaec;">
                                IDL Cargo (IDL)
                                <span class='float-right'>
                                    <input type='checkbox' name='ongkir_idl' id='ongkir_idl' class='js-switch' @if($cekOngkir->idl) checked @endif>
                                </span>
                            </div>
                            <div class='col-xxl-3 col-xl-4 col-lg-6 p-10' style="border:1px solid #e4eaec;">
                                Royal Express Indonesia (REX)
                                <span class='float-right'>
                                    <input type='checkbox' name='ongkir_rex' id='ongkir_rex' class='js-switch' @if($cekOngkir->rex) checked @endif>
                                </span>
                            </div>
                            <div class='col-xxl-3 col-xl-4 col-lg-6 p-10' style="border:1px solid #e4eaec;">
                                Indah Logistic (INDAH)
                                <span class='float-right'>
                                    <input type='checkbox' name='ongkir_indah' id='ongkir_indah' class='js-switch' @if($cekOngkir->indah) checked @endif>
                                </span>
                            </div>
                            <div class='col-xxl-3 col-xl-4 col-lg-6 p-10' style="border:1px solid #e4eaec;">
                                Cahaya Ekspress Logistik (CAHAYA)
                                <span class='float-right'>
                                    <input type='checkbox' name='ongkir_cahaya' id='ongkir_cahaya' class='js-switch' @if($cekOngkir->cahaya) checked @endif>
                                </span>
                            </div>
                        </div>
                        <br>
                        <button type='button' name='btnSimpanCekOngkir' id='btnSimpanCekOngkir' class='btn btn-primary'>Simpan</button>
                    </div>

                    <!-- -- Pengaturan produk -- -->
                    <div class="tab-pane animation-slide-top" id="productSide" role="tabpanel">
                        <div class="row justify-content-center">
                            <div class="col-md-12 text-center">
                                <h4 class="example-title">Pengaturan Produk</h4>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="example">
                                    <form autocomplete="off">
                                        <div class="form-group form-material">
                                            <label class="form-control-label" for="inputText">Stock / Limit
                                                Produk</label>
                                            <input type="number" class="form-control" id="stockLimit"
                                                name="stockLimit" placeholder=""
                                                value="{{$store->stok_produk_limit}}" />
                                            <small class="text-help mt-15">Apabila stok produk mencapai limit produk ini, maka akan akan muncul notifikasi</small>
                                        </div>
                                        <div class="form-group form-material">
                                            <button type="button" class="btn btn-primary"
                                                name="btnUpdateStockLimit">Simpan
                                            </button>
                                            <button type="reset" class="btn btn-default btn-outline">Reset</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>

                    <!-- -- Pengaturan customer -- -->
                    <div class="tab-pane animation-slide-top" id="customerSide" role="tabpanel">
                        <div class="row justify-content-center">
                            <div class="col-md-12 text-center">
                                <h4 class="example-title">Pengaturan Customer</h4>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class='col-md-3'></div>
                            <div class="col-md-6">
                                <form action="">
                                    <h5>Pengaturan</h5>
                                    <div class="example table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th width="40%">Kategori</th>
                                                    <th width="20%">Grosir</th>
                                                    <th width="20%">Diskon</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Customer</td>
                                                    <td>
                                                        <input type="checkbox" class="js-switch" id="grosirCustomer"
                                                            name="grosirCustomer" @if($kat_customer->customer->grosir){ checked } @endif />
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class="js-switch" id="diskonCustomer"
                                                            name="diskonCustomer" @if($kat_customer->customer->diskon){ checked } @endif/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Dropshipper</td>
                                                    <td>
                                                        <input type="checkbox" class="js-switch"
                                                            id="grosirDropshipper" name="grosirDropshipper" @if($kat_customer->dropshipper->grosir){ checked } @endif /></td>
                                                    <td>
                                                        <input type="checkbox" class="js-switch"
                                                            id="diskonDropshipper" name="diskonDropshipper" @if($kat_customer->dropshipper->diskon){ checked } @endif /></td>
                                                </tr>
                                                <tr>
                                                    <td>Reseller</td>
                                                    <td>
                                                        <input type="checkbox" class="js-switch" id="grosirReseller"
                                                            name="grosirReseller" @if($kat_customer->reseller->grosir){ checked } @endif />
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class="js-switch" id="diskonReseller"
                                                            name="diskonReseller" @if($kat_customer->reseller->diskon){ checked } @endif />
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group form-material">
                                            <button type="button" class="btn btn-primary"
                                                name="btnUpdateSGD">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class='col-md-3'></div>
                        </div>
                    </div>

                    <!-- -- Pengaturan payment -- -->
                    <div class="tab-pane animation-slide-top" id="paymentSide" role="tabpanel">
                        <div class="row justify-content-end">
                            <div class="col-md-6">
                                <h4 class="example-title">Pengaturan Payment</h4>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-success" data-target="#tambahPayment" data-toggle="modal"
                                    type="button"><i class='fa fa-plus'></i> Tambah Bank</button>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xxl-2">
                                <h5>Rekening Bank</h5>
                                <p>Anda dapat menambahkan rekening bank untuk digunakan pada pilihan pembayaran di form order</p>
                            </div>
                            <div class="col-xxl-10">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped w-full" id="tablePayment">
                                        <thead>
                                            <tr>
                                                <td>No</td>
                                                <td>Bank</td>
                                                <td>No Rekening</td>
                                                <td>Atas Nama</td>
                                                <td><span class="site-menu-icon md-settings"></span></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- -- Penagturan template -- -->
                    <div class="tab-pane animation-slide-top" id="templateSide" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <h4 class="example-title">Pengaturan StoreFront</h4>
                            </div>
                            <div class="col-md-3">
                                <div class="input-search">
                                    <a href='javascript:void(0)' class="input-search-btn" style='margin-top:8px' id='btnCari'><i class="icon wb-search"
                                            style='color:#0bb2d4' aria-hidden="true"></i></a>
                                    <input type="text" class="form-control" id='queryCari' style='border-color:#0bb2d4' name="queryCari"
                                        placeholder="Pencarian...">
                                </div>
                            </div>
                            <div class='col-md-3'></div>
                        </div>
                        <hr>
                        <div class="row justify-content-center">
                        </div>
                        <div class="row">
                            @foreach ($piece as $item)
                            <div class="col-md-3">
                                <div class="overlay overlay-hover mb-15">
                                    <img src="{{asset('template_depan/'.$item[0].'/thumb/1.png')}}" alt="" class="img-thumbnail">
                                    <div
                                        class="overlay-panel overlay-background overlay-fade text-center vertical-align">
                                        <button type="button" class="btn btn-success align-middle" data-target="#preview{{ $item[0] }}" data-toggle="modal" onClick="$('button[name=btnPilihTemplate]').data('id', '{{$item[0]}}');">
                                            <i class="icon md-eye"></i>Preview</button>
                                    </div>
                                </div>
                                <p class="text-center pb-4">{!! $item[1] !!} &nbsp; {{ucwords($item[0])}}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- -- Pengaturan user -- -->
                    <div class="tab-pane animation-slide-top" id="userSide" role="tabpanel">
                        <div class="row justify-content-end">
                            <div class="col-md-6">
                                <h4 class="example-title">Pengaturan User</h4>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-success" data-target="#tambahUser" data-toggle="modal" type="button"><i
                                        class='fa fa-plus'></i> Tambah User</button>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xxl-9">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped w-full" id="tableUser">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Akses</th>
                                                <th><span class="site-menu-icon md-settings"></span></th>
                                            </tr>
                                        </thead>
                                        <tbody id="isiTabelUser">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <br>
                            <div class="col-xxl-3">
                                <h5>Ketentuan Role: </h5>
                                <p><strong>Owner</strong>, pemilik usaha, memiliki hak akses tertinggi.</p>
                                <p><strong>Admin </strong>, merupakan Karyawan anda, yang membantu mengelola pemesanan barang.</p>
                                <p><strong>Shipper</strong>, merupakan orang yang bertugas mengirim barang, memiliki hak akses sebatas mengetahui barang yang dipesan dan melakukan input nomor Resi pengiriman.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal tambah Order Source  -->
<div class="modal fade modal-fade-in-scale-up" id="tambahOrderSource" aria-hidden="true"
    aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTitle">Tambah Order Source</h4>
            </div>
            <div class="modal-body">
                <form id="formOrderSource">
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label>Kategori</label>
                            <select class="form-control" name="kategoriOs" id="kategoriOs">
                                <option value="" disabled selected>-- Pilih Kategori --</option>
                                <option value="Tokopedia">Tokopedia</option>
                                <option value="Bukalapak">Bukalapak</option>
                                <option value="WhatsApp">WhatsApp</option>
                            </select>
                            <small id="error_kate" style='color:#f2353c;' class='hidden'>Silahkan pilih Kategori!</small>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="">Status</label><br>
                            <input type="checkbox" class="js-switch form-control" id="statusOs" name="statusOs" />
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-lg-12 form-group">
                            <label for="">Keterangan</label>
                            <textarea class="form-control" name="ketOs" placeholder="Keterangan" id="ketOs"></textarea>
                            <small class="text-help">Kosongkan jika tidak ada Keterangan!</small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" name='btnTambahOrderSource'>Tambah</button>
                <button class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- -- Modal edit Order Source -- -->
<div class="modal fade modal-fade-in-scale-up" id="editOrderSource" aria-hidden="true"
    aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTitle">Edit Order Source</h4>
            </div>
            <div class="modal-body">
                <input class='hidden' id='dataID-os' value="">
                <div class="row">
                    <div class="col-lg-6 form-group">
                        <label>Kategori</label>
                        <select class="form-control" name="editKategoriOs" id="editKategoriOs">
                            <option value="" disabled selected>- Pilih kategori</option>
                            <option value="Tokopedia">Tokopedia</option>
                            <option value="Bukalapak">Bukalapak</option>
                            <option value="WhatsApp">WhatsApp</option>
                        </select>
                        <small id="error_kate" style='color:#f2353c;' class='hidden'>Silahkan pilih Kategori!</small>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label for="">Status</label><br>
                        <input type="checkbox" class="js-switch form-control" id="editStatusOs" name="editStatusOs" />
                    </div>
                </div>
                <div class='row'>
                    <div class="col-lg-12 form-group">
                        <label for="">Keterangan</label>
                        <textarea class="form-control" name="editKetOs" placeholder="Keterangan" id="editKetOs"></textarea>
                        <small class="text-help">Kosongkan jika tidak ada Keterangan!</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-warning" name='btnEditOrderSource'>Update</button>
                <button class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- -- Modal tambah payment -- -->
<div class="modal fade modal-fade-in-scale-up" id="tambahPayment" aria-hidden="true" aria-labelledby="exampleModalTitle"
    role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTitle">Tambah Bank</h4>
            </div>
            <div class="modal-body">
                <form id="formTambahBank">
                    <div class="row">
                        <div class="col-lg-5 form-group">
                            <label>Bank</label>
                            <select class="form-control" name="bank" id="bank">
                                <option value="" disabled selected>-- Pilih Bank --</option>
                                <option value="BCA">BCA</option>
                                <option value="BRI">BRI</option>
                                <option value="Mandiri">Mandiri</option>
                            </select>
                            <small id="error_bank" style='color:#f2353c;display:none;'>Pilih Bank Yang Telah disediakan!</small>
                        </div>
                        <div class="col-lg-7 form-group">
                            <label for="">Cabang</label>
                            <input type="text" class="form-control" name="cabang" placeholder="Cabang"
                                id="cabang">
                            <small id="error_cabang" style='color:#f2353c;display:none;'>Masukkan Cabang!</small>
                        </div>
                        <div class="col-lg-5 form-group">
                            <label>No Rekening</label>
                            <input type="text" class="form-control" name="no_rek" placeholder="No Rekening"
                                id="no_rek">
                            <small id="error_no_rek" style='color:#f2353c;display:none;'>Masukkan No Rekening Dengan Benar!</small>
                        </div>
                        <div class="col-lg-7 form-group">
                            <label>Atas Nama</label>
                            <input type="text" class="form-control" name="nama" placeholder="Nama" id="nama">
                            <small id="error_nama" style='color:#f2353c;display:none;'>Masukkan Nama!</small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" name='btnTambahPayment'>Tambah</button>
                <button class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- -- Modal update payment -- -->
<div class="modal fade modal-fade-in-scale-up" id="updatePayment" aria-hidden="true" aria-labelledby="exampleModalTitle"
    role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTitle">Update Bank</h4>
            </div>
            <div class="modal-body">
                <form id="formUpdateBank">
                    <div class="row">
                        <div class="col-lg-5 form-group">
                            <label>Bank</label>
                            <select class="form-control" id="edit_bank">
                                <option value="" disabled selected>- Pilih bank</option>
                                <option value="BCA">BCA</option>
                                <option value="BRI">BRI</option>
                                <option value="Mandiri">Mandiri</option>
                            </select>
                            <small id="error_ebank" style='color:#f2353c;display:none;'>Pilih Bank Yang Telah disediakan!</small>
                        </div>
                        <div class="col-lg-7 form-group">
                            <label for="">Cabang</label>
                            <input type="text" class="form-control" placeholder="Cabang" id="edit_cabang">
                            <small id="error_ecabang" style='color:#f2353c;display:none;'>Masukkan Cabang!</small>
                        </div>
                        <div class="col-lg-5 form-group">
                            <label>No Rekening</label>
                            <input type="text" class="form-control" placeholder="No Rekening" id="edit_no_rek">
                            <small id="error_eno_rek" style='color:#f2353c;display:none;'>Masukkan No Rekening Dengan Benar!</small>
                        </div>
                        <div class="col-lg-7 form-group">
                            <label>Atas Nama</label>
                            <input type="text" class="form-control" placeholder="Nama" id="edit_nama">
                            <small id="error_enama" style='color:#f2353c;display:none;'>Masukkan Nama!</small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-warning" name='btnUpdatePayment'>Update</button>
                <button class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- -- Modal preview template -- -->
@foreach ($piece as $item)
    <div class="modal fade" id="preview{{$item[0]}}" aria-hidden="true" aria-labelledby="exampleMultipleOne" role="dialog"
        tabindex="-1">
        <div class="modal-dialog modal-simple modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Preview</h4>
                </div>
                <div class="modal-body">
                    <div class="example-wrap m-lg-0">
                        <div class="example">
                            <div class="carousel slide" id="exampleCarouselDefault1" data-ride="carousel">
                                <ol class="carousel-indicators carousel-indicators-fall">
                                    <li class="active" data-slide-to="0" data-target="#exampleCarouselDefault1"></li>
                                    <li data-slide-to="1" data-target="#exampleCarouselDefault1"></li>
                                    <li data-slide-to="2" data-target="#exampleCarouselDefault1"></li>
                                    <li data-slide-to="3" data-target="#exampleCarouselDefault1"></li>
                                    <li data-slide-to="4" data-target="#exampleCarouselDefault1"></li>
                                    <li data-slide-to="5" data-target="#exampleCarouselDefault1"></li>
                                </ol>
                                <div class="carousel-inner" role="listbox">
                                    <div class="carousel-item active">
                                        <img class="w-full" src="{{asset('template_depan/'.$item[0].'/thumb/1.png')}}" alt="..." />
                                    </div>
                                    <div class="carousel-item">
                                        <img class="w-full" src="{{asset('template_depan/'.$item[0].'/thumb/2.png')}}" alt="..." />
                                    </div>
                                    <div class="carousel-item">
                                        <img class="w-full" src="{{asset('template_depan/'.$item[0].'/thumb/3.png')}}" alt="..." />
                                    </div>
                                    <div class="carousel-item">
                                        <img class="w-full" src="{{asset('template_depan/'.$item[0].'/thumb/4.png')}}" alt="..." />
                                    </div>
                                    <div class="carousel-item">
                                        <img class="w-full" src="{{asset('template_depan/'.$item[0].'/thumb/5.png')}}" alt="..." />
                                    </div>
                                    <div class="carousel-item">
                                        <img class="w-full" src="{{asset('template_depan/'.$item[0].'/thumb/6.png')}}" alt="..." />
                                    </div>
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
                <div class="modal-footer">
                    <button type="submit" name="btnPilihTemplate" class="btn btn-primary"
                        data-dismiss="modal">Pilih</button>
                    <button type="submit" class="btn btn-light" data-dismiss="modal">kembali</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

<!-- -- Modal tambah user -- -->
<div class="modal fade modal-fill-in" id="tambahUser" aria-hidden="true" aria-labelledby="exampleModalTitle" data-backdrop="static" data-keyboard="false"
    role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTitle">Tambah User</h4>
            </div>
            <div class="modal-body">
                <form id="formTambahUser">
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control" name="namaUser" placeholder="Nama Lengkap"
                                id="namaUser">
                            <small id="error_namaUser" style='color:#f2353c;display:none;'>Masukkan Nama
                                Lengkap!</small>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="emailUser" placeholder="Email"
                                id="emailUser">
                            <small id="error_emailUser" style='color:#f2353c;display:none;'>Masukkan Email!</small>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-lg-6 form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" name="usernameUser" placeholder="Username"
                                id="usernameUser">
                            <small id="error_usernameUser" style='color:#f2353c;display:none;'>Masukkan username</small>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>No Telpon</label>
                            <input type="text" class="form-control" name="no_telpUser" placeholder="No Telepon"
                                id="no_telpUser">
                            <small id="error_no_telpUser" style='color:#f2353c;display:none;'>Masukkan no telepon dengan
                                benar!</small>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-lg-6 form-group">
                            <label for="">Password</label>
                            <div class="input-search">
                                <button type="button" style="height:40px;cursor:pointer;" class="input-search-btn" id='btnEye' tabindex='-1'><i class="icon md-eye" aria-hidden="true"></i></button>
                                <input type="password" name="passwordUser" class="form-control" placeholder="Password" id="passwordUser" autocomplete="on" style='border-radius:unset'>
                                <small id="error_passwordUser" style='color:#f2353c;display:none;'>Masukkan Password!</small>
                            </div>
                            <!-- <div class="input-group">
                                <input type="password" class="form-control" name="passwordUser" value=""
                                    id="passwordUser" placeholder="Password" autocomplete='on'>
                                <div class="input-group-append">
                                    <button type='button' style='cursor:pointer' class='input-group-text' id='btnEye' tabindex='-1'><i class='fa fa-eye'></i></button>
                                </div>
                            </div>
                            <small id="error_passwordUser" style='color:#f2353c;display:none;'>Masukkan Password!</small> -->
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="">Konfirmasi Password</label>
                            <div class="input-search">
                                <button type="button" style="height:40px;cursor:pointer;" class="input-search-btn" id='btnEye2' tabindex='-1'><i class="icon md-eye" aria-hidden="true"></i></button>
                                <input type="password" name="passwordUser2" class="form-control" placeholder="Password" id="passwordUser2" autocomplete="on" style='border-radius:unset'>
                                <small id="error_passwordUser2" style='color:#f2353c;display:none;'>Password tidak sama!</small>
                            </div>
                            <!-- <div class="input-group">
                                <input type="password" class="form-control" name="passwordUser2" value=""
                                    id="passwordUser2" placeholder="Konfirmasi Password" autocomplete='on'>
                                <div class="input-group-append">
                                    <button type='button' style='cursor:pointer' class='input-group-text'id='btnEye2' tabindex='-1'><i class='fa fa-eye'></i></button>
                                </div>
                            </div>
                            <small id="error_passwordUser2" style='color:#f2353c;display:none;'>Password tidak sama!</small> -->
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-lg-3 form-group">
                            <label>Role</label>
                            <select class="form-control" name="roleUser" id="roleUser">
                                <option value="" disabled selected>-- Pilih Role --</option>
                                <option value="Owner">Owner</option>
                                <option value="Admin">Admin</option>
                                <option value="Shipper">Shipper</option>
                            </select>
                            <small id="error_roleUser" style='color:#f2353c;display:none;'>Silahkan Pilih Role!</small>
                        </div>
                    </div>
                    <div class='row hidden' id='aksesDiv'>
                        <div class="col-lg-12 form-group">
                            <label>Akses Admin</label>
                            <div class='row ml-10 mr-10'>
                                <div class='col-lg-6 p-15' style="border:1px solid #e4eaec;">
                                    Menu Expense &nbsp;<i class='icon fa-question-circle ijin_menu-expense'></i>
                                    <span class='float-right'>
                                        <input type='checkbox' name='i_menuExpense' id='i_menuExpense' class='js-switch2'>
                                    </span>
                                </div>
                                <div class='col-lg-6 p-15' style="border:1px solid #e4eaec;">
                                    Menu Analisa &nbsp;<i class='icon fa-question-circle ijin_menu-analisa'></i>
                                    <span class='float-right'>
                                        <input type='checkbox' name='i_melihatAnalisa' id='i_melihatAnalisa' class='js-switch2'>
                                    </span>
                                </div>
                                <div class='col-lg-6 p-15' style="border:1px solid #e4eaec;">
                                    Hapus Produk
                                    <span class='float-right'>
                                        <input type='checkbox' name='i_hapusProduk' id='i_hapusProduk' class='js-switch2'>
                                    </span>
                                </div>
                                <div class='col-lg-6 p-15' style="border:1px solid #e4eaec;">
                                    Upload Produk Via Excel
                                    <span class='float-right'>
                                        <input type='checkbox' name='i_uploadProdukExcel' id='i_uploadProdukExcel' class='js-switch2'>
                                    </span>
                                </div>
                                <div class='col-lg-6 p-15' style="border:1px solid #e4eaec;">
                                    Download Excel
                                    <span class='float-right'>
                                        <input type='checkbox' name='i_downloadExcel' id='i_downloadExcel' class='js-switch2'>
                                    </span>
                                </div>
                                <div class='col-lg-6 p-15' style="border:1px solid #e4eaec;">
                                    Hapus Customer
                                    <span class='float-right'>
                                        <input type='checkbox' name='i_hapusCustomer' id='i_hapusCustomer' class='js-switch2'>
                                    </span>
                                </div>
                                <div class='col-lg-6 p-15' style="border:1px solid #e4eaec;">
                                    Edit Customer
                                    <span class='float-right'>
                                        <input type='checkbox' name='i_editCustomer' id='i_editCustomer' class='js-switch2'>
                                    </span>
                                </div>
                                <div class='col-lg-6 p-15' style="border:1px solid #e4eaec;">
                                    Edit Order
                                    <span class='float-right'>
                                        <input type='checkbox' name='i_editOrder' id='i_editOrder' class='js-switch2'>
                                    </span>
                                </div>
                                <div class='col-lg-6 p-15' style="border:1px solid #e4eaec;">
                                    Edit Order dari Admin lain &nbsp;<i class='icon fa-question-circle ijin_edit-order-admin-lain'></i>
                                    <span class='float-right'>
                                        <input type='checkbox' name='i_editOrderAdminLain' id='i_editOrderAdminLain' class='js-switch2'>
                                    </span>
                                </div>
                                <div class='col-lg-6 p-15' style="border:1px solid #e4eaec;">
                                    Cancel Order &nbsp;<i class='icon fa-question-circle ijin_cancel-order'></i>
                                    <span class='float-right'>
                                        <input type='checkbox' name='i_cancelOrder' id='i_cancelOrder' class='js-switch2'>
                                    </span>
                                </div>
                                <div class='col-lg-6 p-15' style="border:1px solid #e4eaec;">
                                    Melihat Omset (Net Sales dan Gross Profit)
                                    <span class='float-right'>
                                        <input type='checkbox' name='i_melihatOmset' id='i_melihatOmset' class='js-switch2'>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" name='btnTambahUser'>Tambah</button>
                <button class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- -- Modal edit user -- -->
<div class="modal fade modal-fill-in" id="editUser" aria-hidden="true" aria-labelledby="exampleModalTitle" data-backdrop="static" data-keyboard="false"
    role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTitle">Edit User</h4>
            </div>
            <div class="modal-body">
                <form id="formEditUser">
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control" name="namaUser_edit" placeholder="Nama Lengkap"
                                id="namaUser_edit">
                            <small id="error_namaUser_edit" style='color:#f2353c;display:none;'>Masukkan Nama
                                Lengkap!</small>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="emailUser_edit" placeholder="Email"
                                id="emailUser_edit">
                            <small id="error_emailUser_edit" style='color:#f2353c;display:none;'>Masukkan Email!</small>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-lg-6 form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" name="usernameUser_edit" placeholder="Username"
                                id="usernameUser_edit">
                            <small id="error_usernameUser_edit" style='color:#f2353c;display:none;'>Masukkan username</small>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>No Telpon</label>
                            <input type="text" class="form-control" name="no_telpUser_edit" placeholder="No Telepon"
                                id="no_telpUser_edit">
                            <small id="error_no_telpUser_edit" style='color:#f2353c;display:none;'>Masukkan no telepon dengan
                                benar!</small>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-lg-6 form-group">
                            <label for="">Password Baru</label>
                            <div class="input-search">
                                <button type="button" style="height:40px;cursor:pointer;" class="input-search-btn" id='btnEye_edit' tabindex='-1'><i class="icon md-eye" aria-hidden="true"></i></button>
                                <input type="password" name="passwordUser_edit" class="form-control" placeholder="Password" id="passwordUser_edit" autocomplete="on" style='border-radius:unset'>
                                <small id="note_passwordUser_edit" class='text-muted'>Jangan diisi bila tidak ingin merubah password!</small><br>
                                <small id="error_passwordUser_edit" style='color:#f2353c;display:none;'>Masukkan Password!</small>
                            </div>
                            <!-- <div class="input-group">
                                <input type="password" class="form-control" name="passwordUser_edit" value=""
                                    id="passwordUser_edit" placeholder="Password" autocomplete='on'>
                                <div class="input-group-append">
                                    <button type='button' style='cursor:pointer' class='input-group-text' id='btnEye_edit' tabindex='-1'><i class='fa fa-eye'></i></button>
                                </div>
                            </div>
                            <small id="note_passwordUser_edit" class='text-muted'>Jangan diisi bila tidak ingin merubah password!</small><br>
                            <small id="error_passwordUser_edit" style='color:#f2353c;display:none;'>Masukkan Password!</small> -->
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="">Konfirmasi Password Baru</label>
                            <div class="input-search">
                                <button type="button" style="height:40px;cursor:pointer;" class="input-search-btn" id='btnEye2_edit' tabindex='-1'><i class="icon md-eye" aria-hidden="true"></i></button>
                                <input type="password" name="passwordUser2_edit" class="form-control" placeholder="Password" id="passwordUser2_edit" autocomplete="on" style='border-radius:unset'>
                                <small id="note_passwordUser2_edit" class='text-muted'>Jangan diisi bila tidak ingin merubah password!</small><br>
                                <small id="error_passwordUser2_edit" style='color:#f2353c;display:none;'>Masukkan Password!</small>
                            </div>
                            <!-- <div class="input-group">
                                <input type="password" class="form-control" name="passwordUser2_edit" value=""
                                    id="passwordUser2_edit" placeholder="Konfirmasi Password" autocomplete='on'>
                                <div class="input-group-append">
                                    <button type='button' style='cursor:pointer' class='input-group-text'id='btnEye2_edit' tabindex='-1'><i class='fa fa-eye'></i></button>
                                </div>
                            </div>
                            <small id="note_passwordUser2_edit" class='text-muted'>Jangan diisi bila tidak ingin merubah password!</small><br>
                            <small id="error_passwordUser2_edit" style='color:#f2353c;display:none;'>Password tidak sama!</small> -->
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-lg-3 form-group">
                            <label>Role</label>
                            <select class="form-control" name="roleUser_edit" id="roleUser_edit">
                                <option value="" disabled selected>-- Pilih Role --</option>
                                <option value="Owner">Owner</option>
                                <option value="Admin">Admin</option>
                                <option value="Shipper">Shipper</option>
                            </select>
                            <small id="error_roleUser_edit" style='color:#f2353c;display:none;'>Silahkan Pilih Role!</small>
                        </div>
                    </div>
                    <div class='row hidden' id='aksesDiv_edit'>
                        <div class="col-lg-12 form-group">
                            <label>Akses Admin</label>
                            <div class='row ml-10 mr-10'>
                                <div class='col-lg-6 p-15' style="border:1px solid #e4eaec;">
                                    Menu Expense &nbsp;<i class='icon fa-question-circle ijin_menu-expense'></i>
                                    <span class='float-right'>
                                        <input type='checkbox' name='i_menuExpense_edit' id='i_menuExpense_edit' class='js-switch2'>
                                    </span>
                                </div>
                                <div class='col-lg-6 p-15' style="border:1px solid #e4eaec;">
                                    Menu Analisa &nbsp;<i class='icon fa-question-circle ijin_menu-analisa'></i>
                                    <span class='float-right'>
                                        <input type='checkbox' name='i_melihatAnalisa_edit' id='i_melihatAnalisa_edit' class='js-switch2'>
                                    </span>
                                </div>
                                <div class='col-lg-6 p-15' style="border:1px solid #e4eaec;">
                                    Hapus Produk
                                    <span class='float-right'>
                                        <input type='checkbox' name='i_hapusProduk_edit' id='i_hapusProduk_edit' class='js-switch2'>
                                    </span>
                                </div>
                                <div class='col-lg-6 p-15' style="border:1px solid #e4eaec;">
                                    Upload Produk Via Excel
                                    <span class='float-right'>
                                        <input type='checkbox' name='i_uploadProdukExcel_edit' id='i_uploadProdukExcel_edit' class='js-switch2'>
                                    </span>
                                </div>
                                <div class='col-lg-6 p-15' style="border:1px solid #e4eaec;">
                                    Download Excel
                                    <span class='float-right'>
                                        <input type='checkbox' name='i_downloadExcel_edit' id='i_downloadExcel_edit' class='js-switch2'>
                                    </span>
                                </div>
                                <div class='col-lg-6 p-15' style="border:1px solid #e4eaec;">
                                    Hapus Customer
                                    <span class='float-right'>
                                        <input type='checkbox' name='i_hapusCustomer_edit' id='i_hapusCustomer_edit' class='js-switch2'>
                                    </span>
                                </div>
                                <div class='col-lg-6 p-15' style="border:1px solid #e4eaec;">
                                    Edit Customer
                                    <span class='float-right'>
                                        <input type='checkbox' name='i_editCustomer_edit' id='i_editCustomer_edit' class='js-switch2'>
                                    </span>
                                </div>
                                <div class='col-lg-6 p-15' style="border:1px solid #e4eaec;">
                                    Edit Order
                                    <span class='float-right'>
                                        <input type='checkbox' name='i_editOrder_edit' id='i_editOrder_edit' class='js-switch2'>
                                    </span>
                                </div>
                                <div class='col-lg-6 p-15' style="border:1px solid #e4eaec;">
                                    Edit Order dari Admin lain &nbsp;<i class='icon fa-question-circle ijin_edit-order-admin-lain'></i>
                                    <span class='float-right'>
                                        <input type='checkbox' name='i_editOrderAdminLain_edit' id='i_editOrderAdminLain_edit' class='js-switch2'>
                                    </span>
                                </div>
                                <div class='col-lg-6 p-15' style="border:1px solid #e4eaec;">
                                    Cancel Order &nbsp;<i class='icon fa-question-circle ijin_cancel-order'></i>
                                    <span class='float-right'>
                                        <input type='checkbox' name='i_cancelOrder_edit' id='i_cancelOrder_edit' class='js-switch2'>
                                    </span>
                                </div>
                                <div class='col-lg-6 p-15' style="border:1px solid #e4eaec;">
                                    Melihat Omset (Net Sales dan Gross Profit)
                                    <span class='float-right'>
                                        <input type='checkbox' name='i_melihatOmset_edit' id='i_melihatOmset_edit' class='js-switch2'>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" name='btnEditUser'>Edit</button>
                <button class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- modal nama filter-->
<div class="modal fade modal-fade-in-scale-up" id="filterMod" aria-hidden="true" aria-labelledby="exampleModalTitle"
    role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTitle">Edit Filter</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label>Nama Filter</label>
                        <input type="text" class="form-control" id="nama_filterMod" name="nama_filter"/>
                        <small id="error_namaFilter" class='hidden'></small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-warning" value='Edit' name='btnEditFilter' id='btnEditFilterMod'>
                <button class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<script>
var cacheKabupaten = {},
    cacheKecamatan = {},
    cacheKecamatan_Kabupaten = {};
var cacheProvinsiAll = [];
var isTrue_provinsi = false,
    isTrue_kabupaten = false,
    isTrue_kecamatan = false;
var tabelDataOrderSource, tabelDataPayment, tableDataUser, tableFilterOrder;

function cekEmail(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
}

// Document ready
$(document).ready(function() {
    	
    $.fn.dataTable.ext.errMode = 'throw';
    
    $('#cache-help').tooltip({
        trigger: 'hover',
        title: 'Data Cache digunakan untuk mempercepat loading page.',
        placement: 'top'
    });
    
    $('.ijin_menu-expense').tooltip({
        trigger: 'hover',
        title: 'Bisa mengakses Menu Expense, dan bisa menambahkan, mengedit, serta mengahapus Expense.',
        placement: 'top'
    });
    
    $('.ijin_menu-analisa').tooltip({
        trigger: 'hover',
        title: 'Bisa mengakses Menu Analisa.',
        placement: 'top'
    });

    $('.ijin_edit-order-admin-lain').tooltip({
        trigger: 'hover',
        title: 'Bisa mengedit order dari admin lain.',
        placement: 'top'
    });

    $('.ijin_cancel-order').tooltip({
        trigger: 'hover',
        title: 'Bisa mengcancel order.',
        placement: 'top'
    });

    $('#btnEye').click(function(){
        if($('#passwordUser').attr('type') == 'password'){
            $('#passwordUser').attr('type', 'text');
            $('#btnEye').children().attr('class', 'icon md-eye-off');
        } else if($('#passwordUser').attr('type') == 'text'){
            $('#passwordUser').attr('type', 'password');
            $('#btnEye').children().attr('class', 'icon md-eye');
        }
    });

    $('#passwordUser').password({
        animate: false,
        minimumLength: 0,
        enterPass: '',
        badPass: '<span class="red-800 font-size-14">The password is weak</span>',
        goodPass: '<span class="yellow-800 font-size-14">Good password</span>',
        strongPass: '<span class="green-700 font-size-14">Strong password</span>',
        shortPass: ''
    });

    $('#btnEye2').click(function(){
        if($('#passwordUser2').attr('type') == 'password'){
            $('#passwordUser2').attr('type', 'text');
            $('#btnEye2').children().attr('class', 'icon md-eye-off');
        } else if($('#passwordUser2').attr('type') == 'text'){
            $('#passwordUser2').attr('type', 'password');
            $('#btnEye2').children().attr('class', 'icon md-eye');
        }
    });

    $('#btnEye_edit').click(function(){
        if($('#passwordUser_edit').attr('type') == 'password'){
            $('#passwordUser_edit').attr('type', 'text');
            $('#btnEye_edit').children().attr('class', 'icon md-eye-off');
        } else if($('#passwordUser_edit').attr('type') == 'text'){
            $('#passwordUser_edit').attr('type', 'password');
            $('#btnEye_edit').children().attr('class', 'icon md-eye');
        }
    });

    $('#passwordUser_edit').password({
        animate: false,
        minimumLength: 0,
        enterPass: '',
        badPass: '<span class="red-800 font-size-14">The password is weak</span>',
        goodPass: '<span class="yellow-800 font-size-14">Good password</span>',
        strongPass: '<span class="green-700 font-size-14">Strong password</span>',
        shortPass: ''
    });

    $('#btnEye2_edit').click(function(){
        if($('#passwordUser2_edit').attr('type') == 'password'){
            $('#passwordUser2_edit').attr('type', 'text');
            $('#btnEye2_edit').children().attr('class', 'icon md-eye-off');
        } else if($('#passwordUser2_edit').attr('type') == 'text'){
            $('#passwordUser2_edit').attr('type', 'password');
            $('#btnEye2_edit').children().attr('class', 'icon md-eye');
        }
    });


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

    //SelectPicker
    $('#lokasiPengiriman').selectpicker({
        liveSearch: true,
        style: 'btn-outline btn-default'
    });
    $('#lokasiPengirimanEdit').selectpicker({
        liveSearch: true,
        style: 'btn-outline btn-default'
    });
    $('#kategoriOs').selectpicker({
        style: 'btn-outline btn-default'
    });
    $('#editKategoriOs').selectpicker({
        style: 'btn-outline btn-default'
    });
    $('#bank').selectpicker({
        style: 'btn-outline btn-default'
    });
    $('#edit_bank').selectpicker({
        style: 'btn-outline btn-default'
    });
    $('#roleUser').selectpicker({
        style: 'btn-outline btn-default'
    });
    $('#roleUser_edit').selectpicker({
        style: 'btn-outline btn-default'
    });
    $('#provinsiS').selectpicker({
        liveSearch: true,
        style: 'btn-outline btn-default'
    });
    $('#kabupatenS').selectpicker({
        liveSearch: true,
        style: 'btn-outline btn-default'
    });
    $('#kecamatanS').selectpicker({
        liveSearch: true,
        style: 'btn-outline btn-default'
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#no_telpToko').on('input', function(){
        this.value = this.value.replace(/[^0-9]/gi, '');
    });

    $('#no_telpUser').on('input', function(){
        this.value = this.value.replace(/[^0-9]/gi, '');
    });

    //DataTable
    $('#orderSideTombol').on('click', function(){
        //Get data order source
        if (!$.fn.DataTable.isDataTable('#tableOrderSource')) {
            tabelDataOrderSource = $('#tableOrderSource').DataTable({
                ajax: {
                    type: 'get',
                    url: "{{ route('b.setting-getOrderSourceData') }}",
                },
                "paging": false,
                "info": false,
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }],
                "order": [
                    [1, 'asc']
                ]
            });
        }
        tabelDataOrderSource.on('order.dt search.dt', function() {
            tabelDataOrderSource.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

        //Get data filter order
        if (!$.fn.DataTable.isDataTable('#tableFilterOrder')) {
            tabelDataFilterOrder = $('#tableFilterOrder').DataTable({
                ajax: {
                    type: 'get',
                    url: "{{ route('b.setting-getFilterOrderData') }}",
                },
                "paging": false,
                "info": false,
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }],
                "order": [
                    [1, 'asc']
                ]
            });
        }
        tabelDataFilterOrder.on('order.dt search.dt', function() {
            tabelDataFilterOrder.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    });

    $('#paymentSideTombol').on('click', function(){
        //Get data payment
        if (!$.fn.DataTable.isDataTable('#tablePayment')) {
            tabelDataPayment = $('#tablePayment').DataTable({
                ajax: {
                    type: 'get',
                    url: "{{ route('b.setting-getPaymentData') }}",
                },
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }],
                "order": [
                    [1, 'asc']
                ]
            });
        }
        tabelDataPayment.on('order.dt search.dt', function() {
            tabelDataPayment.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    });

    $('#userSideTombol').on('click', function(){
        //Get data user table
        if (!$.fn.DataTable.isDataTable('#tableUser')) {
            tableDataUser = $('#tableUser').DataTable({
                ajax: {
                    type: 'get',
                    url: "{{ route('b.setting-getUserData') }}",
                },
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }],
                "order": [
                    [1, 'asc']
                ]
            });
        }
        tableDataUser.on('order.dt search.dt', function() {
            tableDataUser.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    });


    $('#provinsiS').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
        $('#provinsiS').selectpicker('setStyle', 'animation-shake', 'remove');
        if (!$('#error_provinsiS').is(':hidden')) $('#error_provinsiS').hide();
        var val = $(this).val();
        $('#kabupatenS').html(
            '<option value="" disabled selected>-- Pilih Kabupaten --</option>');
        var term = val.replace(/[^a-zA-Z]/gi, '');
        if(term in cacheKabupaten){
            $.each(cacheKabupaten[term], function(i2, v2) {
                $('#kabupatenS').append("<option value='" + v2.type + " " + v2
                    .kabupaten_nama + "'>" + v2.type + " " + v2
                    .kabupaten_nama + "</option>");
            });
            $('#kabupatenS').selectpicker('refresh');
        } else {
            $.ajax({
                url: "{{ route('b.ajax-getWilayah') }}",
                type: 'get',
                data: {
                    term: val
                },
                dataType: 'json',
                success: function(data) {
                    cacheKabupaten[term] = data;
                    $.each(data, function(i2, v2) {
                        $('#kabupatenS').append("<option value='" + v2.type + " " + v2
                            .kabupaten_nama + "'>" + v2.type + " " + v2
                            .kabupaten_nama + "</option>");
                    });
                    $('#kabupatenS').selectpicker('refresh');
                }
            });
        }
        var term2 = term+"1";
        $('#kecamatanS').html(
            '<option value="" disabled selected>-- Pilih Kecamatan --</option>');
        if(term2 in cacheKecamatan){
            $.each(cacheKecamatan[term2], function(i3, v3) {
                $('#kecamatanS').append("<option value='" + v3.kecamatan.nama +
                    "'>" + v3.kecamatan.nama + "</option>");
            });
            $('#kecamatanS').selectpicker('refresh');
        } else {
            $.ajax({
                url: "{{ route('b.ajax-getWilayahDetail') }}",
                type: 'get',
                data: {
                    term: val,
                    tipe: "1"
                },
                dataType: 'json',
                success: function(data) {
                    cacheKecamatan[term2] = data;
                    $.each(data, function(i3, v3) {
                        $('#kecamatanS').append("<option value='" + v3.kecamatan.nama +
                            "'>" + v3.kecamatan.nama + "</option>");
                    });
                    $('#kecamatanS').selectpicker('refresh');
                }
            });
        }
        if (!$('#error_kabupatenS').is(':hidden')) $('#error_kabupatenS').hide();
        if (!$('#error_kecamatanS').is(':hidden')) $('#error_kecamatanS').hide();
    });


    $('#kabupatenS').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
        $('#kabupatenS').selectpicker('setStyle', 'animation-shake', 'remove');
        if (!$('#error_kabupatenS').is(':hidden')) $('#error_kabupatenS').hide();
        var pilihKab = $(this).val();
        var provinsiPilih = '';
        var term = pilihKab.replace(/[^a-zA-Z]/gi, '');
        if(cacheProvinsiAll.length > 0){
            $.each(cacheProvinsiAll, function(i, v) {
                $.each(v.kabupaten, function(key, val) {
                    var tempPilih = val.type + ' ' + val.kabupaten_nama;
                    if (pilihKab === tempPilih) {
                        provinsiPilih = v.provinsi;
                        return false;
                    }
                });
                if (provinsiPilih != '') return false;
            });
            $('#provinsiS').selectpicker('val', provinsiPilih);
        } else {
            $.ajax({
                url: "{{ route('b.ajax-getWilayah') }}",
                type: 'get',
                dataType: 'json',
                success: function(data) {
                    cacheProvinsiAll = data;
                    $.each(data, function(i, v) {
                        $.each(v.kabupaten, function(key, val) {
                            var tempPilih = val.type + ' ' + val.kabupaten_nama;
                            if (pilihKab === tempPilih) {
                                provinsiPilih = v.provinsi;
                                return false;
                            }
                        });
                        if (provinsiPilih != '') return false;
                    });
                    $('#provinsiS').selectpicker('val', provinsiPilih);
                }
            });
        }
        var term2 = term+"2";
        $('#kecamatanS').html(
            '<option value="" disabled selected>-- Pilih Kecamatan --</option>');
        if(term2 in cacheKecamatan_Kabupaten){
            $.each(cacheKecamatan_Kabupaten[term2], function(i3, v3) {
                $('#kecamatanS').append("<option value='" + v3.kecamatan.nama +
                    "'>" + v3.kecamatan.nama + "</option>");
            });
            $('#kecamatanS').selectpicker('refresh');
        } else {
            $.ajax({
                url: "{{ route('b.ajax-getWilayahDetail') }}",
                type: 'get',
                data: {
                    term: pilihKab,
                    tipe: "2"
                },
                dataType: 'json',
                success: function(data) {
                    cacheKecamatan_Kabupaten[term2] = data;
                    $.each(data, function(i3, v3) {
                        $('#kecamatanS').append("<option value='" + v3.kecamatan.nama +
                            "'>" + v3.kecamatan.nama + "</option>");
                    });
                    $('#kecamatanS').selectpicker('refresh');
                }
            });
        }
        if (!$('#error_provinsiS').is(':hidden')) $('#error_provinsiS').hide();
        if (!$('#error_kecamatanS').is(':hidden')) $('#error_kecamatanS').hide();
    });

    $('#kecamatanS').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
        $('#kecamatanS').selectpicker('setStyle', 'animation-shake', 'remove');
        if (!$('#error_kecamatanS').is(':hidden')) $('#error_kecamatanS').hide();
        if (!$('#error_provinsiS').is(':hidden')) $('#error_provinsiS').hide();
        if (!$('#error_kabupatenS').is(':hidden')) $('#error_kabupatenS').hide();
    });

    // Upload Photo
    @php
        if($tmp_logo['path'] != ""){
            echo "var logo_path = '".asset($tmp_logo['path'])."';";
        } else {
            echo "var logo_path = '';";
        }
    @endphp
    var logo_toko = $('#logoToko').dropify({
        height: 166,
        defaultFile: logo_path,
        errorsPosition: 'outside',
        messages: {
            'default': 'Drag and drop a file here or click',
            'replace': 'Drag and drop or click to replace',
            'remove': '<i class="glyphicon-trash"></i>',
            'error': 'Ooops, something wrong happended.'
        },
        error: {
            'fileSize': 'The file size is too big ({value} max).',
            'minWidth': 'The image width is too small ({value}px min).',
            'maxWidth': 'The image width is too big ({value}px max).',
            'minHeight': 'The image height is too small ({value}px min).',
            'maxHeight': 'The image height is too big ({value}px max).',
            'imageFormat': 'The iowed ({value} only).'
        },
        tpl: {
            wrap: '<div class="dropify-wrapper"></div>',
            loader: '<div class="dropify-loader"></div>',
            filename: '<p class="dropify-filename"><span class="file-icon"></span> <span class="dropify-filename-inner"></span></p>',
            errorsContainer: '<div class="dropify-errors-container"><ul></ul></div>'
        }
    });
    logo_toko.on('dropify.afterClear', function(event, element){
        var val = $('#logoTemp').val();
        $('#logoTemp').val('hapus+'+val);
    });

    // Swithchery
    var list_checkbox = Array.prototype.slice.call($('.js-switch'));
    list_checkbox.forEach(function(html) {
        var switchery = new Switchery(html, {
            color: '#3e8ef7',
            size: 'medium'
        });
    });

    var list_checkbox2 = Array.prototype.slice.call($('.js-switch2'));
    list_checkbox2.forEach(function(html) {
        var switchery = new Switchery(html, {
            color: '#c4c4c4',
            size: 'medium'
        });
    });

    // Nama Order
    $('#namaOrder').change(function() {
        if ($(this).is(':checked')) {
            $('#order_nama_on').show();
            $('#order_nama_off').hide();
        } else {
            $('#order_nama_on').hide();
            $('#order_nama_off').show();
        }
    })

    // Logo Toko
    $('#tampilLogo').change(function() {
        if ($(this).is(':checked')) {
            $('#logo_on').show();
            $('#logo_off').hide();
        } else {
            $('#logo_on').hide();
            $('#logo_off').show();
        }
    })

    // Order Source
    $('#orderSource').change(function() {
        if ($(this).is(':checked')) {
            $('#source_on').show();
            $('#source_off').hide();
        } else {
            $('#source_on').hide();
            $('#source_off').show();
        }
    })

    $('#btnEditFilterMod').on('click', function(){
        var id = $(this).data('id');
        var nama_filter = $('#nama_filterMod').val();
        var hasil;
        $.ajax({
            type: 'post',
            url: "{{ route('b.setting-proses') }}",
            data: {
                id: id,
                nama_filter: nama_filter,
                dd: "{{ $key['e_filter_order']['dd'] }}",
                tt: "{{ $key['e_filter_order']['tt'] }}",
            },
            success: function(data) {
                hasil = data;
            },
            error: function(error, b, c) {
                swal("Error", '' + c, "error")
            }
        }).done(function() {
            console.log(hasil);
            $('#filterMod').modal('hide');
            if (hasil.sukses) {
                swal("Berhasil!", "Berhasil mengedit Filter Order!", "success");
                tabelDataFilterOrder.ajax.reload(null, false);
            } else {
                swal("Gagal!", "" + hasil.msg, "error");
            }
        }).fail(function() {
            $('#filterMod').modal('hide');
        });
    })

    //Update Form Toko
    $("button[name=btnUpdateToko]").on('click', function() {
        var url = "{{ route('b.setting-proses') }}";
        var form = $("<form action='"+url+"' method='post' enctype='multipart/form-data'></form>");
        $('#namaToko').clone().appendTo(form);
        $('#no_telpToko').clone().appendTo(form);
        $('#deskripsiToko').clone().appendTo(form);
        $('#alamatToko').clone().appendTo(form);
        $('#namaToko').clone().appendTo(form);
        form.append($('#logoToko'));
        form.append($('#logoTemp'));
        form.append('@csrf');
        form.append("<input name='dd' value='{{ $key['e_toko']['dd'] }}'>");
        form.append("<input name='tt' value='{{ $key['e_toko']['tt'] }}'>");
        $('body').append(form);
        form.submit();
    });

    //Update Order Source
    $("button[name=btnUpdateOrderSource]").on('click', function() {
        $.ajax({
            type: 'post',
            url: "{{ route('b.setting-proses') }}",
            data: {
                storeId: '{{ $store->id_store }}',
                namaOrder: $('#namaOrder').is(":checked") ? 1 : 0,
                tampilLogo: $('#tampilLogo').is(":checked") ? 1 : 0,
                orderSource: $('#orderSource').is(":checked") ? 1 : 0,
                dd: "{{ $key['s_order_source']['dd'] }}",
                tt: "{{ $key['s_order_source']['tt'] }}"
            },
            success: function(data) {
                hasil = data;
            },
            error: function(error, b, c) {
                swal("Error", '' + c, "error");
            }
        }).done(function() {
            if (hasil.status) {
                swal("Berhasil!", "Berhasil memperbarui pengaturan Order Source!", "success");
            } else if (hasil.msg == 0) {
                swal("Gagal", "" + "Tidak ada yang dirubah!", "warning");
            } else {
                swal("Gagal", "" + hasil.msg, "error");
            }
        }).fail(function() {
            console.log("Error 1354: ");
            console.log(hasil.msg);
        })
    });

    //Update stock limit produk
    $("button[name=btnUpdateStockLimit]").on('click', function() {
        $.ajax({
            type: 'post',
            url: "{{ route('b.setting-proses') }}",
            data: {
                storeId: "{{ $store->id_store }}",
                stockLimit: $('#stockLimit').val(),
                dd: "{{ $key['e_stok_limit']['dd'] }}",
                tt: "{{ $key['e_stok_limit']['tt'] }}"
            },
            success: function(data) {
                hasil = data;
            },
            error: function(error, b, c) {
                swal("Error", '' + c, "error")
            }
        }).done(function() {
            if (hasil.status) {
                swal("Berhasil", "Berhasil memperbarui stock limit!", "success");
            } else if (hasil.msg == 0) {
                swal("Gagal!", "Tidak ada yang dirubah!", "warning");
            } else {
                swal("Gagal", "" + hasil.msg, "error");
            }
        }).fail(function() {
            // console.log(hasil.msg)
        })
    });

    //Update Status Grosir Diskon
    $("button[name=btnUpdateSGD]").on('click', function() {
        $.ajax({
            type: 'post',
            url: "{{ route('b.setting-proses') }}",
            data: {
                storeId: "{{ $store->id_store }}",
                grosirCustomer: $('#grosirCustomer').is(":checked") ? 1 : 0,
                diskonCustomer: $('#diskonCustomer').is(":checked") ? 1 : 0,
                grosirDropshipper: $('#grosirDropshipper').is(":checked") ? 1 : 0,
                diskonDropshipper: $('#diskonDropshipper').is(":checked") ? 1 : 0,
                grosirReseller: $('#grosirReseller').is(":checked") ? 1 : 0,
                diskonReseller: $('#diskonReseller').is(":checked") ? 1 : 0,
                dd: "{{ $key['e_kat_customer']['dd'] }}",
                tt: "{{ $key['e_kat_customer']['tt'] }}"
            },
            success: function(data) {
                hasil = data;
            },
            error: function(error, b, c) {
                swal("Error", '' + c, "error")
            }
        }).done(function() {
            if (hasil.status) {
                swal("Berhasil!", "Berhasil memperbarui pengaturan customer!", "success");
            } else if (hasil.msg == 0) {
                swal("Gagal!", "Tidak ada yang dirubah!", "warning");
            } else {
                swal("Gagal!", "" + hasil.msg, "error");
            }
        }).fail(function() {
            // console.log(hasil.msg);
        })
    })

    //Update Payment
    $("button[name=btnUpdatePayment]").on('click', function() {
        var bank = $('#edit_bank').val();
        var cabang = $('#edit_cabang').val();
        var no_rek = $('#edit_no_rek').val();
        var nama = $('#edit_nama').val();
        var id = $('#updatePayment').data('ids');
        var error = 0;
        if (bank == null) {
            $('#edit_bank').selectpicker('setStyle', 'animation-shake', 'add');
            $('small#error_ebank').attr('style', 'color:#f2353c');
            $('small#error_ebank').show();
            error++;
        }
        if (cabang == "") {
            $('#edit_cabang').addClass('is-invalid animation-shake');
            $('small#error_ecabang').attr('style', 'color:#f2353c');
            $('small#error_ecabang').show();
            error++;
        }
        if (no_rek == "") {
            $('#edit_no_rek').addClass('is-invalid animation-shake');
            $('small#error_eno_rek').attr('style', 'color:#f2353c');
            $('small#error_eno_rek').show();
            error++;
        }
        if (nama == "") {
            $('#edit_nama').addClass('is-invalid animation-shake');
            $('small#error_enama').attr('style', 'color:#f2353c');
            $('small#error_enama').show();
            error++;
        }
        if (error == 0) {
            $.ajax({
                type: 'post',
                url: "{{ route('b.setting-proses') }}",
                data: {
                    id: id,
                    bank: $('#edit_bank').val(),
                    cabang: $('#edit_cabang').val(),
                    no_rek: $('#edit_no_rek').val(),
                    nama: $('#edit_nama').val(),
                    dd: "{{ $key['e_bank']['dd'] }}",
                    tt: "{{ $key['e_bank']['tt'] }}",
                },
                success: function(data) {
                    hasil = data;
                },
                error: function(error, b, c) {
                    swal("Error", '' + c, "error")
                }
            }).done(function() {
                $('#updatePayment').modal('hide');
                if (hasil.status) {
                    swal("Berhasil!", "Berhasil memperbarui payment!", "success");
                    tabelDataPayment.ajax.reload(null, false);
                } else if (hasil.msg == 0) {
                    swal("Gagal!", "Nothing changed!", "warning");
                } else {
                    swal("Gagal!", "" + hasil.msg, "error");
                }
            }).fail(function() {
                $('#updatePayment').modal('hide');
            })
        }
    })

    // Tambah Order Source
    $("button[name=btnTambahOrderSource]").click(function() {
        var kategoriOs = $('#kategoriOs').val();
        if(kategoriOs != null){
            var hasil = '';
            $.ajax({
                type: 'post',
                url: "{{ route('b.setting-proses') }}",
                data: {
                    storeId: '{{$store->id_store}}',
                    kategoriOs: $('#kategoriOs').val(),
                    ketOs: $('#ketOs').val(),
                    status: $('#statusOs').is(":checked") ? 1 : 0,
                    dd: '{{ $key["t_order_source"]["dd"] }}',
                    tt: '{{ $key["t_order_source"]["tt"] }}'
                },
                success: function(data) {
                    hasil = data;
                },
                error: function(error, b, c) {
                    swal("Error", '' + c, "error")
                }
            }).done(function() {
                $('#tambahOrderSource').modal('hide');
                if (hasil.status) {
                    swal("Berhasil!", "Berhasil menambah order source!", "success");
                    tabelDataOrderSource.ajax.reload(null, false);
                } else {
                    swal("Gagal!", "" + hasil.msg, "error");
                }
            }).fail(function() {
                $('#tambahOrderSource').modal('hide');
            })
        } else {
            $('#kategoriOs').selectpicker('setStyle', 'animation-shake', 'add');
            $('small#error_kate').attr('style', 'color:#f2353c;');
            $('small#error_kate').show();
        }
    })

    $('#kategoriOs').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        if($('small#error_kate').is(":visible")){
            $('#kategoriOs').selectpicker('setStyle', 'animation-shake', 'remove');
            $('small#error_kate').hide();
        }
    });

    $("#tambahOrderSource").on("hide.bs.modal", function(){
        if(!$('small#error_kate').is(":hidden")){
            $('#kategoriOs').selectpicker('setStyle', 'animation-shake', 'remove');
            $('small#error_kate').hide();
        }
    });

    $("#tambahOrderSource").on("hidden.bs.modal", function(){
        $('#kategoriOs').selectpicker('val', '');
        $('#ketOs').val('');
        if($('#statusOs').is(':checked')){
            $('#statusOs').trigger('click');
        }
    });

    $('#bank').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        if($('small#error_bank').is(":visible")){
            $('#bank').selectpicker('setStyle', 'animation-shake', 'remove');
            $('small#error_bank').hide();
        }
    });

    $('#btnSimpanCekOngkir').on('click', function(){
        var ongkir = {};
        ongkir.jne = $('#ongkir_jne').is(':checked') ? 1 : 0;
        ongkir.pos = $('#ongkir_pos').is(':checked') ? 1 : 0;
        ongkir.tiki = $('#ongkir_tiki').is(':checked') ? 1 : 0;
        ongkir.pcp = $('#ongkir_pcp').is(':checked') ? 1 : 0;
        ongkir.esl = $('#ongkir_esl').is(':checked') ? 1 : 0;
        ongkir.rpx = $('#ongkir_rpx').is(':checked') ? 1 : 0;
        ongkir.pandu = $('#ongkir_pandu').is(':checked') ? 1 : 0;
        ongkir.wahana = $('#ongkir_wahana').is(':checked') ? 1 : 0;
        ongkir.sicepat = $('#ongkir_sicepat').is(':checked') ? 1 : 0;
        ongkir.jnt = $('#ongkir_jnt').is(':checked') ? 1 : 0;
        ongkir.pahala = $('#ongkir_pahala').is(':checked') ? 1 : 0;
        ongkir.sap = $('#ongkir_sap').is(':checked') ? 1 : 0;
        ongkir.jet = $('#ongkir_jet').is(':checked') ? 1 : 0;
        ongkir.slis = $('#ongkir_slis').is(':checked') ? 1 : 0;
        ongkir.dse = $('#ongkir_dse').is(':checked') ? 1 : 0;
        ongkir.first = $('#ongkir_first').is(':checked') ? 1 : 0;
        ongkir.ncs = $('#ongkir_ncs').is(':checked') ? 1 : 0;
        ongkir.star = $('#ongkir_star').is(':checked') ? 1 : 0;
        ongkir.lion = $('#ongkir_lion').is(':checked') ? 1 : 0;
        ongkir.ninja = $('#ongkir_ninja').is(':checked') ? 1 : 0;
        ongkir.idl = $('#ongkir_idl').is(':checked') ? 1 : 0;
        ongkir.rex = $('#ongkir_rex').is(':checked') ? 1 : 0;
        ongkir.indah = $('#ongkir_indah').is(':checked') ? 1 : 0;
        ongkir.cahaya = $('#ongkir_cahaya').is(':checked') ? 1 : 0;
        $.ajax({
            type: 'post',
            url: "{{ route('b.setting-proses') }}",
            data: {
                cekongkir:JSON.stringify(ongkir),
                dd: "{{ $key['e_cek_ongkir']['dd'] }}",
                tt: "{{ $key['e_cek_ongkir']['tt'] }}",
            },
            success: function(data) {
                hasil = data;
            },
            error: function(error, b, c) {
                swal("Error", '' + c, "error");
            }
        }).done(function() {
            if (hasil.status) {
                swal("Berhasil!", "Berhasil mengedit Cek Ongkir!", "success");
                tableDataUser.ajax.reload(null, false);
            } else {
                swal("Gagal!", "" + hasil.msg, "error");
            }
        });
    });

    $('#btnHapusDataCache').on('click', function(){
        $.ajax({
            type: 'post',
            url: "{{ route('b.setting-proses') }}",
            data: {
                dd: "{{ $key['h_data_cache']['dd'] }}",
                tt: "{{ $key['h_data_cache']['tt'] }}",
            },
            success: function(data) {
                hasil = data;
            },
            error: function(error, b, c) {
                swal("Error", '' + c, "error");
            }
        }).done(function() {
            swal("Berhasil!", "Berhasil menghapus Data Cache!", "success");
        });
    });

    $("#tambahPayment").on("hide.bs.modal", function(){
        $('#bank').selectpicker('val', '');
        $('#cabang').val('');
        $('#no_rek').val('');
        $('#nama').val('');
        if($('small#error_bank').is(":visible")){
            $('#bank').selectpicker('setStyle', 'animation-shake', 'remove');
            $('small#error_bank').hide();
        }
        if($('small#error_cabang').is(":visible")){
            $('#cabang').removeClass('is-invalid animation-shake');
            $('small#error_cabang').hide();
        }
        if($('small#error_no_rek').is(":visible")){
            $('#no_rek').removeClass('is-invalid animation-shake');
            $('small#error_no_rek').hide();
        }
        if($('small#error_nama').is(":visible")){
            $('#nama').removeClass('is-invalid animation-shake');
            $('small#error_nama').hide();
        }
    });

    $('#cabang').on('input', function(e){
        if($('small#error_cabang').is(":visible")){
            $('#cabang').removeClass('is-invalid animation-shake');
            $('small#error_cabang').hide();
        }
    })

    $('#no_rek').on('input', function(e){
        if($('small#error_no_rek').is(":visible")){
            $('#no_rek').removeClass('is-invalid animation-shake');
            $('small#error_no_rek').hide();
        }
    })

    $('#nama').on('input', function(e){
        if($('small#error_nama').is(":visible")){
            $('#nama').removeClass('is-invalid animation-shake');
            $('small#error_nama').hide();
        }
    })

    $('#edit_cabang').on('input', function(e){
        if($('small#error_ecabang').is(":visible")){
            $('#edit_cabang').removeClass('is-invalid animation-shake');
            $('small#error_ecabang').hide();
        }
    })

    $('#edit_no_rek').on('input', function(e){
        if($('small#error_eno_rek').is(":visible")){
            $('#edit_no_rek').removeClass('is-invalid animation-shake');
            $('small#error_eno_rek').hide();
        }
    })

    $('#edit_nama').on('input', function(e){
        if($('small#error_enama').is(":visible")){
            $('#edit_nama').removeClass('is-invalid animation-shake');
            $('small#error_enama').hide();
        }
    })

    //Tambah Payment
    $("button[name=btnTambahPayment]").on('click', function() {
        var bank = $('#bank').val();
        var cabang = $('#cabang').val();
        var no_rek = $('#no_rek').val();
        var nama = $('#nama').val();
        var error = 0;
        if (bank == null) {
            $('#bank').selectpicker('setStyle', 'animation-shake', 'add');
            $('small#error_bank').attr('style', 'color:#f2353c');
            $('small#error_bank').show();
            error++;
        }
        if (cabang == "") {
            $('#cabang').addClass('is-invalid animation-shake');
            $('small#error_cabang').attr('style', 'color:#f2353c');
            $('small#error_cabang').show();
            error++;
        }
        if (no_rek == "") {
            $('#no_rek').addClass('is-invalid animation-shake');
            $('small#error_no_rek').attr('style', 'color:#f2353c');
            $('small#error_no_rek').show();
            error++;
        }
        if (nama == "") {
            $('#nama').addClass('is-invalid animation-shake');
            $('small#error_nama').attr('style', 'color:#f2353c');
            $('small#error_nama').show();
            error++;
        }
        if (error == 0) {
            var hasil = '';
            $.ajax({
                type: 'post',
                url: "{{ route('b.setting-proses') }}",
                data: {
                    bank: bank,
                    cabang: cabang,
                    no_rek: no_rek,
                    nama: nama,
                    dd: "{{ $key['t_bank']['dd'] }}",
                    tt: "{{ $key['t_bank']['tt'] }}",
                },
                success: function(data) {
                    hasil = data;
                },
                error: function(error, b, c) {
                    swal("Error", '' + c, "error")
                }
            }).done(function() {
                $('#tambahPayment').modal('hide');
                if (hasil.status) {
                    swal("Berhasil!", "Berhasil menambah bank!", "success");
                    tabelDataPayment.ajax.reload(null, false);
                } else {
                    swal("Gagal!", "" + hasil.msg, "error");
                }
            }).fail(function() {
                $('#tambahPayment').modal('hide');
            })
        }
    })

    //Update Template
    $("button[name=btnPilihTemplate]").on('click', function() {
        var id = $(this).data('id');
        var hasil = '';
        $.ajax({
            type: 'post',
            url: "{{ route('b.setting-proses') }}",
            data: {
                template: id,
                dd: "{{ $key['e_template']['dd'] }}",
                tt: "{{ $key['e_template']['tt'] }}",
            },
            success: function(data) {
                hasil = data;
            },
            error: function(error, b, c) {
                swal("Error", '' + c, "error")
            }
        }).done(function() {
            $('#modalPreviewTemplate').modal('hide');
            if (hasil.status) {
                swal("Berhasil!", "Berhasil mengganti Template!", "success");
            } else {
                swal("Gagal!", "" + hasil.msg, "error");
            }
        }).fail(function() {
            $('#modalPreviewTemplate').modal('hide');
        })
    })

    $('#roleUser').on('changed.bs.select', function(){
        if($('small#error_roleUser').is(':visible')){
            $('small#error_roleUser').hide();
            $('#roleUser').selectpicker('setStyle', 'animation-shake', 'remove');
        }
        if($(this).val() == "Admin"){
            $('#aksesDiv').show();
        } else {
            $('#aksesDiv').hide();
        }
        if($('#i_menuExpense').is(':checked')){
            $('#i_menuExpense').trigger('click');
        }
    });

    $('#roleUser_edit').on('changed.bs.select', function(){
        if($('small#error_roleUser_edit').is(':visible')){
            $('small#error_roleUser_edit').hide();
            $('#roleUser_edit').selectpicker('setStyle', 'animation-shake', 'remove');
        }
        if($(this).val() == "Admin"){
            $('#aksesDiv_edit').show();
        } else {
            $('#aksesDiv_edit').hide();
        }
        if($('#i_menuExpense_edit').is(':checked')){
            $('#i_menuExpense_edit').trigger('click');
        }
    });

    $('#tambahUser').on('hide.bs.modal', function(){
        if($('#i_menuExpense').is(':checked')){
            $('#i_menuExpense').trigger('click');
        }
        if($('#i_melihatAnalisa').is(':checked')){
            $('#i_melihatAnalisa').trigger('click');
        }
        if($('#i_hapusProduk').is(':checked')){
            $('#i_hapusProduk').trigger('click');
        }
        if($('#i_uploadProdukExcel').is(':checked')){
            $('#i_uploadProdukExcel').trigger('click');
        }
        if($('#i_downloadExcel').is(':checked')){
            $('#i_downloadExcel').trigger('click');
        }
        if($('#i_hapusCustomer').is(':checked')){
            $('#i_hapusCustomer').trigger('click');
        }
        if($('#i_editCustomer').is(':checked')){
            $('#i_editCustomer').trigger('click');
        }
        if($('#i_editOrder').is(':checked')){
            $('#i_editOrder').trigger('click');
        }
        if($('#i_editOrderAdminLain').is(':checked')){
            $('#i_editOrderAdminLain').trigger('click');
        }
        if($('#i_cancelOrder').is(':checked')){
            $('#i_cancelOrder').trigger('click');
        }
        if($('#i_melihatOmset').is(':checked')){
            $('#i_melihatOmset').trigger('click');
        }
        if($('small#error_namaUser').is(':visible')){
            $('small#error_namaUser').hide();
            $('#namaUser').removeClass('is-invalid animation-shake');
        }
        if($('small#error_emailUser').is(':visible')){
            $('small#error_emailUser').hide();
            $('#emailUser').removeClass('is-invalid animation-shake');
        }
        if($('small#error_roleUser').is(':visible')){
            $('small#error_roleUser').hide();
            $('#roleUser').selectpicker('setStyle', 'animation-shake', 'remove');
        }
        if($('small#error_usernameUser').is(':visible')){
            $('small#error_usernameUser').hide();
            $('#usernameUser').removeClass('is-invalid animation-shake');
        }
        if($('small#error_no_telpUser').is(':visible')){
            $('small#error_no_telpUser').hide();
            $('#no_telpUser').removeClass('is-invalid animation-shake');
        }
        if($('small#error_alamatUser').is(':visible')){
            $('small#error_alamatUser').hide();
            $('#alamatUser').removeClass('is-invalid animation-shake');
        }
        if($('small#error_passwordUser').is(':visible')){
            $('small#error_passwordUser').hide();
            $('#passwordUser').removeClass('is-invalid animation-shake');
        }
        if($('small#error_passwordUser2').is(':visible')){
            $('small#error_passwordUser2').hide();
            $('#passwordUser2').removeClass('is-invalid animation-shake');
        }
    });

    $('#editUser').on('hide.bs.modal', function(){
        if($('#i_menuExpense_edit').is(':checked')){
            $('#i_menuExpense_edit').trigger('click');
        }
        if($('#i_melihatAnalisa_edit').is(':checked')){
            $('#i_melihatAnalisa_edit').trigger('click');
        }
        if($('#i_hapusProduk_edit').is(':checked')){
            $('#i_hapusProduk_edit').trigger('click');
        }
        if($('#i_uploadProdukExcel_edit').is(':checked')){
            $('#i_uploadProdukExcel_edit').trigger('click');
        }
        if($('#i_downloadExcel_edit').is(':checked')){
            $('#i_downloadExcel_edit').trigger('click');
        }
        if($('#i_hapusCustomer_edit').is(':checked')){
            $('#i_hapusCustomer_edit').trigger('click');
        }
        if($('#i_editCustomer_edit').is(':checked')){
            $('#i_editCustomer_edit').trigger('click');
        }
        if($('#i_editOrder_edit').is(':checked')){
            $('#i_editOrder_edit').trigger('click');
        }
        if($('#i_editOrderAdminLain_edit').is(':checked')){
            $('#i_editOrderAdminLain_edit').trigger('click');
        }
        if($('#i_cancelOrder_edit').is(':checked')){
            $('#i_cancelOrder_edit').trigger('click');
        }
        if($('#i_melihatOmset_edit').is(':checked')){
            $('#i_melihatOmset_edit').trigger('click');
        }
        if($('small#error_namaUser_edit').is(':visible')){
            $('small#error_namaUser_edit').hide();
            $('#namaUser_edit').removeClass('is-invalid animation-shake');
        }
        if($('small#error_emailUser_edit').is(':visible')){
            $('small#error_emailUser_edit').hide();
            $('#emailUser_edit').removeClass('is-invalid animation-shake');
        }
        if($('small#error_roleUser_edit').is(':visible')){
            $('small#error_roleUser_edit').hide();
            $('#roleUser_edit').selectpicker('setStyle', 'animation-shake', 'remove');
        }
        if($('small#error_usernameUser_edit').is(':visible')){
            $('small#error_usernameUser_edit').hide();
            $('#usernameUser_edit').removeClass('is-invalid animation-shake');
        }
        if($('small#error_no_telpUser_edit').is(':visible')){
            $('small#error_no_telpUser_edit').hide();
            $('#no_telpUser_edit').removeClass('is-invalid animation-shake');
        }
        if($('small#error_alamatUser_edit').is(':visible')){
            $('small#error_alamatUser_edit').hide();
            $('#alamatUser_edit').removeClass('is-invalid animation-shake');
        }
        if($('small#error_passwordUser_edit').is(':visible')){
            $('small#error_passwordUser_edit').hide();
            $('#passwordUser_edit').removeClass('is-invalid animation-shake');
        }
        if($('small#error_passwordUser2_edit').is(':visible')){
            $('small#error_passwordUser2_edit').hide();
            $('#passwordUser2_edit').removeClass('is-invalid animation-shake');
        }
    });

    $('#namaUser').on("input", function(){
        if($('small#error_namaUser').is(':visible')){
            $('small#error_namaUser').hide();
            $('#namaUser').removeClass('is-invalid animation-shake');
        }
    });

    $('#emailUser').on("input", function(){
        if($('small#error_emailUser').is(':visible')){
            $('small#error_emailUser').hide();
            $('#emailUser').removeClass('is-invalid animation-shake');
        }
    });
    
    $('#usernameUser').on("input", function(){
        if($('small#error_usernameUser').is(':visible')){
            $('small#error_usernameUser').hide();
            $('#usernameUser').removeClass('is-invalid animation-shake');
        }
    });
    
    $('#no_telpUser').on("input", function(){
        if($('small#error_no_telpUser').is(':visible')){
            $('small#error_no_telpUser').hide();
            $('#no_telpUser').removeClass('is-invalid animation-shake');
        }
    });
    
    $('#passwordUser').on("input", function(){
        if($('small#error_passwordUser').is(':visible')){
            $('small#error_passwordUser').hide();
            $('#passwordUser').removeClass('is-invalid animation-shake');
        }
    });

    $('#passwordUser2').on("input", function(){
        if($('small#error_passwordUser2').is(':visible')){
            $('small#error_passwordUser2').hide();
            $('#passwordUser2').removeClass('is-invalid animation-shake');
        }
    });

    $('#namaUser_edit').on("input", function(){
        if($('small#error_namaUser_edit').is(':visible')){
            $('small#error_namaUser_edit').hide();
            $('#namaUser_edit').removeClass('is-invalid animation-shake');
        }
    });

    $('#emailUser_edit').on("input", function(){
        if($('small#error_emailUser_edit').is(':visible')){
            $('small#error_emailUser_edit').hide();
            $('#emailUser_edit').removeClass('is-invalid animation-shake');
        }
    });
    
    $('#usernameUser_edit').on("input", function(){
        if($('small#error_usernameUser_edit').is(':visible')){
            $('small#error_usernameUser_edit').hide();
            $('#usernameUser_edit').removeClass('is-invalid animation-shake');
        }
    });
    
    $('#no_telpUser_edit').on("input", function(){
        if($('small#error_no_telpUser_edit').is(':visible')){
            $('small#error_no_telpUser_edit').hide();
            $('#no_telpUser_edit').removeClass('is-invalid animation-shake');
        }
    });
    
    $('#passwordUser_edit').on("input", function(){
        if($('small#error_passwordUser_edit').is(':visible')){
            $('small#error_passwordUser_edit').hide();
            $('#passwordUser_edit').removeClass('is-invalid animation-shake');
        }
    });

    $('#passwordUser2_edit').on("input", function(){
        if($('small#error_passwordUser2_edit').is(':visible')){
            $('small#error_passwordUser2_edit').hide();
            $('#passwordUser2_edit').removeClass('is-invalid animation-shake');
        }
    });

    // Tambah User
    $("button[name=btnTambahUser]").on('click', function() {
        var namaUser = $('#namaUser').val();
        var emailUser = $('#emailUser').val();
        var no_telpUser = $('#no_telpUser').val();
        var roleUser = $('#roleUser').val();
        var usernameUser = $('#usernameUser').val();
        var passwordUser = $('#passwordUser').val();
        var passwordUser2 = $('#passwordUser2').val();
        var error = 0;
        if (namaUser == "") {
            $('#namaUser').addClass('is-invalid animation-shake');
            $('small#error_namaUser').attr('style', 'color:#f2353c;');
            $('small#error_namaUser').show();
            error++;
        }
        if (emailUser == "") {
            $('#emailUser').addClass('is-invalid animation-shake');
            $('small#error_emailUser').attr('style', 'color:#f2353c;');
            $('small#error_emailUser').text('Masukkan Email!');
            $('small#error_emailUser').show();
            error++;
        }
        if(emailUser != "" && !cekEmail(emailUser)){
            $('#emailUser').addClass('is-invalid animation-shake');
            $('small#error_emailUser').attr('style', 'color:#f2353c;');
            $('small#error_emailUser').text('Masukkan Email yang valid!');
            $('small#error_emailUser').show();
            error++;
        }
        if (roleUser == null) {
            $('#roleUser').selectpicker('setStyle', 'animation-shake', 'add');
            $('small#error_roleUser').attr('style', 'color:#f2353c;');
            $('small#error_roleUser').html('Silahkan Pilih Role!');
            $('small#error_roleUser').show();
            error++;
        }
        if (usernameUser == "") {
            $('#usernameUser').addClass('is-invalid animation-shake');
            $('small#error_usernameUser').attr('style', 'color:#f2353c;');
            $('small#error_usernameUser').show();
            error++;
        }
        if (no_telpUser == 0) {
            $('#no_telpUser').addClass('is-invalid animation-shake');
            $('small#error_no_telpUser').attr('style', 'color:#f2353c;');
            $('small#error_no_telpUser').show();
            error++;
        }
        if(passwordUser == ''){
            $('#passwordUser').addClass('is-invalid animation-shake');
            $('small#error_passwordUser').attr('style', 'color:#f2353c;');
            $('small#error_passwordUser').show();
            error++;
        }
        if(passwordUser2 == ''){
            $('#passwordUser2').addClass('is-invalid animation-shake');
            $('small#error_passwordUser2').attr('style', 'color:#f2353c;');
            $('small#error_passwordUser2').html('Masukkan Password Konfirmasi!');
            $('small#error_passwordUser2').show();
            error++;
        }
        if(passwordUser != passwordUser2){
            $('#passwordUser2').addClass('is-invalid animation-shake');
            $('small#error_passwordUser2').attr('style', 'color:#f2353c;');
            $('small#error_passwordUser2').html('Password tidak sama!');
            $('small#error_passwordUser2').show();
            error++;
        }
        if($('#roleUser').val() in ['Owner', 'Admin', 'Shipper']){
            $('#roleUser').selectpicker('setStyle', 'animation-shake', 'add');
            $('small#error_roleUser').attr('style', 'color:#f2353c;');
            $('small#error_roleUser').html('Anda melakukan hal yang tidak semestinya!');
            $('small#error_roleUser').show();
            error++;
        }
        if (error === 0) {
            if($('#roleUser').val() == "Admin"){
                var ijin = {};
                ijin.menuExpense = $('#i_menuExpense').is(':checked') ? 1 : 0;
                ijin.melihatAnalisa = $('#i_melihatAnalisa').is(':checked') ? 1 : 0;
                ijin.hapusProduk = $('#i_hapusProduk').is(':checked') ? 1 : 0;
                ijin.uploadProdukExcel = $('#i_uploadProdukExcel').is(':checked') ? 1 : 0;
                ijin.downloadExcel = $('#i_downloadExcel').is(':checked') ? 1 : 0;
                ijin.hapusCustomer = $('#i_hapusCustomer').is(':checked') ? 1 : 0;
                ijin.editCustomer = $('#i_editCustomer').is(':checked') ? 1 : 0;
                ijin.editOrder = $('#i_editOrder').is(':checked') ? 1 : 0;
                ijin.editOrderAdminLain = $('#i_editOrderAdminLain').is(':checked') ? 1 : 0;
                ijin.cancelOrder = $('#i_cancelOrder').is(':checked') ? 1 : 0;
                ijin.melihatOmset = $('#i_melihatOmset').is(':checked') ? 1 : 0;
            }
            var hasil = '';
            $.ajax({
                type: 'post',
                url: "{{ route('b.setting-proses') }}",
                data: {
                    namaUser: namaUser,
                    usernameUser: usernameUser,
                    emailUser: emailUser,
                    passUser: passwordUser,
                    no_telpUser: no_telpUser,
                    roleUser: $('#roleUser').val(),
                    ijinUser: ($('#roleUser').val() == "Admin") ? JSON.stringify(ijin) : null,
                    dd: "{{ $key['t_user']['dd'] }}",
                    tt: "{{ $key['t_user']['tt'] }}",
                },
                success: function(data) {
                    hasil = data;
                },
                error: function(error, b, c) {
                    swal("Error", '' + c, "error")
                }
            }).done(function() {
                $('#tambahUser').modal('hide');
                if (hasil.status) {
                    swal("Berhasil!", "Berhasil menambah User!", "success");
                    tableDataUser.ajax.reload(null, false);
                    $('#namaUser').val('');
                    $('#emailUser').val('');
                    $('#roleUser').selectpicker('val', '');
                    $('#usernameUser').val('');
                    $('#no_telpUser').val('');
                    $('#passwordUser').val('');
                    $('#passwordUser2').val('');
                    $('#aksesDiv').hide();
                } else {
                    swal("Gagal!", "" + hasil.msg, "error");
                }
            }).fail(function() {
                $('#tambahUser').modal('hide');
            })
        }
    });

    // Update User
    $("button[name=btnEditUser]").on('click', function() {
        var namaUser_edit = $('#namaUser_edit').val();
        var emailUser_edit = $('#emailUser_edit').val();
        var no_telpUser_edit = $('#no_telpUser_edit').val();
        var roleUser_edit = $('#roleUser_edit').val();
        var usernameUser_edit = $('#usernameUser_edit').val();
        var passwordUser_edit = $('#passwordUser_edit').val();
        var passwordUser2_edit = $('#passwordUser2_edit').val();
        var error_edit = 0;
        if (namaUser_edit == "") {
            $('#namaUser_edit').addClass('is-invalid animation-shake');
            $('small#error_namaUser_edit').attr('style', 'color:#f2353c;');
            $('small#error_namaUser_edit').show();
            error_edit++;
        }
        if (emailUser_edit == "") {
            $('#emailUser_edit').addClass('is-invalid animation-shake');
            $('small#error_emailUser_edit').attr('style', 'color:#f2353c;');
            $('small#error_emailUser_edit').text('Masukkan Email!');
            $('small#error_emailUser_edit').show();
            error_edit++;
        }
        if(emailUser_edit != "" && !cekEmail(emailUser_edit)){
            $('#emailUser_edit').addClass('is-invalid animation-shake');
            $('small#error_emailUser_edit').attr('style', 'color:#f2353c;');
            $('small#error_emailUser_edit').text('Masukkan Email yang valid!');
            $('small#error_emailUser_edit').show();
            error_edit++;
        }
        if (roleUser_edit == null) {
            $('#roleUser_edit').selectpicker('setStyle', 'animation-shake', 'add');
            $('small#error_roleUser_edit').attr('style', 'color:#f2353c;');
            $('small#error_roleUser_edit').html('Silahkan Pilih Role!');
            $('small#error_roleUser_edit').show();
            error_edit++;
        }
        if(passwordUser_edit != ''){
            if(passwordUser2_edit == ''){
                $('#passwordUser2_edit').addClass('is-invalid animation-shake');
                $('small#error_passwordUser2_edit').attr('style', 'color:#f2353c;');
                $('small#error_passwordUser2_edit').html('Masukkan Password Konfirmasi!');
                $('small#error_passwordUser2_edit').show();
                error_edit++;
            }
            if(passwordUser_edit != passwordUser2_edit){
                $('#passwordUser2_edit').addClass('is-invalid animation-shake');
                $('small#error_passwordUser2_edit').attr('style', 'color:#f2353c;');
                $('small#error_passwordUser2_edit').html('Password tidak sama!');
                $('small#error_passwordUser2_edit').show();
                error_edit++;
            }
        }
        if (usernameUser_edit == "") {
            $('#usernameUser_edit').addClass('is-invalid animation-shake');
            $('small#error_usernameUser_edit').attr('style', 'color:#f2353c;');
            $('small#error_usernameUser_edit').show();
            error_edit++;
        }
        if (no_telpUser_edit == 0) {
            $('#no_telpUser_edit').addClass('is-invalid animation-shake');
            $('small#error_no_telpUser_edit').attr('style', 'color:#f2353c;');
            $('small#error_no_telpUser_edit').show();
            error_edit++;
        }
        if($('#roleUser_edit').val() in ['Owner', 'Admin', 'Shipper']){
            $('#roleUser_edit').selectpicker('setStyle', 'animation-shake', 'add');
            $('small#error_roleUser_edit').attr('style', 'color:#f2353c;');
            $('small#error_roleUser_edit').html('Anda melakukan hal yang tidak semestinya!');
            $('small#error_roleUser_edit').show();
            error_edit++;
        }
        if (error_edit === 0) {
            if($('#roleUser_edit').val() == "Admin"){
                var ijin_edit = {};
                ijin_edit.menuExpense = $('#i_menuExpense_edit').is(':checked') ? 1 : 0;
                ijin_edit.melihatAnalisa = $('#i_melihatAnalisa_edit').is(':checked') ? 1 : 0;
                ijin_edit.hapusProduk = $('#i_hapusProduk_edit').is(':checked') ? 1 : 0;
                ijin_edit.uploadProdukExcel = $('#i_uploadProdukExcel_edit').is(':checked') ? 1 : 0;
                ijin_edit.downloadExcel = $('#i_downloadExcel_edit').is(':checked') ? 1 : 0;
                ijin_edit.hapusCustomer = $('#i_hapusCustomer_edit').is(':checked') ? 1 : 0;
                ijin_edit.editCustomer = $('#i_editCustomer_edit').is(':checked') ? 1 : 0;
                ijin_edit.editOrder = $('#i_editOrder_edit').is(':checked') ? 1 : 0;
                ijin_edit.editOrderAdminLain = $('#i_editOrderAdminLain_edit').is(':checked') ? 1 : 0;
                ijin_edit.cancelOrder = $('#i_cancelOrder_edit').is(':checked') ? 1 : 0;
                ijin_edit.melihatOmset = $('#i_melihatOmset_edit').is(':checked') ? 1 : 0;
            }
            var hasil = '';
            $.ajax({
                type: 'post',
                url: "{{ route('b.setting-proses') }}",
                data: {
                    id: $(this).data('id'),
                    namaUser: namaUser_edit,
                    usernameUser: usernameUser_edit,
                    emailUser: emailUser_edit,
                    passUser: passwordUser_edit,
                    no_telpUser: no_telpUser_edit,
                    roleUser: $('#roleUser_edit').val(),
                    ijinUser: ($('#roleUser_edit').val() == "Admin") ? JSON.stringify(ijin_edit) : null,
                    dd: "{{ $key['e_user']['dd'] }}",
                    tt: "{{ $key['e_user']['tt'] }}",
                },
                success: function(data) {
                    hasil = data;
                },
                error: function(error, b, c) {
                    swal("Error", '' + c, "error");
                }
            }).done(function() {
                $('#editUser').modal('hide');
                if (hasil.status) {
                    swal("Berhasil!", "Berhasil mengedit User!", "success");
                    tableDataUser.ajax.reload(null, false);
                } else {
                    swal("Gagal!", "" + hasil.msg, "error");
                }
            }).fail(function() {
                $('#editUser').modal('hide');
            })
        }
    });

    // Update Data Order Source
    $("button[name=btnEditOrderSource]").on('click', function() {
        var editKategoriOs = $('#editKategoriOs').val();
        if (editKategoriOs != null) {
            var hasil = '';
            $.ajax({
                type: 'post',
                url: "{{ route('b.setting-proses') }}",
                data: {
                    id: $("#dataID-os").val(),
                    kategoriOs: $('#editKategoriOs').val(),
                    ketOs: $('#editKetOs').val(),
                    status: $('#editStatusOs').is(":checked") ? 1 : 0,
                    dd: '{{ $key["e_order_source"]["dd"] }}',
                    tt: '{{ $key["e_order_source"]["tt"] }}'
                },
                success: function(data) {
                    hasil = data;
                },
                error: function(error, b, c) {
                    swal("Error", '' + c, "error")
                }
            }).done(function() {
                $('#editOrderSource').modal('hide');
                if (hasil.status) {
                    swal("Berhasil!", "Berhasil memperbarui order source!", "success");
                    tabelDataOrderSource.ajax.reload(null, false);
                } else {
                    swal("Gagal!", "" + hasil.msg, "error");
                }
            }).fail(function() {
                $('#editOrderSource').modal('hide');
            })
        } else {
            $('#editKategoriOs').selectpicker('setStyle', 'animation-shake', 'add');
            $('small#error_ekate').attr('style', 'color:#f2353c;');
            $('small#error_ekate').show();
        }
    });

    
    $('#editOrderSource').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        if(!$('small#error_ekate').is(":hidden")){
            $('#editKategoriOs').selectpicker('setStyle', 'animation-shake', 'remove');
            $('small#error_ekate').hide();
        }
    });

    $("#editOrderSource").on("hide.bs.modal", function(){
        if(!$('small#error_ekate').is(":hidden")){
            $('#editKategoriOs').selectpicker('setStyle', 'animation-shake', 'remove');
            $('small#error_ekate').hide();
        }
    });

    $("#editOrderSource").on("hidden.bs.modal", function(){
        $('#editKategoriOs').selectpicker('val', '');
        $('#editKetOs').val('');
        if($('#editStatusOs').is(':checked')){
            $('#editStatusOs').trigger('click');
        }
    });

});
// end of document ready

(function(world) {

    // Edit Order Source
    world.fn.editOrderSource = function() {
        var id = $(this).data('id');
        $("#dataID-os").val(id);
        var hasil;
        $.ajax({
            type: 'get',
            url: '{{ route("b.setting-getOrderSourceData") }}',
            data: {
                v: id
            },
            success: function(data) {
                hasil = data;
            }
        }).done(function() {
            $('#editKategoriOs').selectpicker('val', hasil.kategori);
            $('#editKetOs').val(hasil.keterangan);
            if (hasil.status == 1) {
                if (!$('#editStatusOs').is(':checked')) {
                    $('#editStatusOs').trigger('click');
                }
            } else {
                if ($('#editStatusOs').is(':checked')) {
                    $('#editStatusOs').trigger('click');
                }
            }

        })
    }

    // Edit Payment (Get Data)
    world.fn.updatePayment = function() {
        var id = $(this).data("id");
        var hasil;
        $.ajax({
            type: 'get',
            url: "{{ route('b.setting-getPaymentData') }}",
            data: {
                v: id
            },
            success: function(data) {
                hasil = data;
            }
        }).done(function() {
            $('#edit_bank').selectpicker('val', hasil.bank);
            $('#edit_cabang').val(hasil.cabang);
            $('#edit_no_rek').val(hasil.no_rek);
            $('#edit_nama').val(hasil.atas_nama);
            $('#updatePayment').data('ids', id);
        })
    }


    //Delete data order source
    world.fn.hapusOrderSource = function(tabelData) {
        var id = $(this).data('id');
        swal({
            title: "Peringatan",
            text: "Apakah anda yakin ingin menghapus data order source?",
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
                },
            },
            dangerMode: true
        }).then((willDelete) => {
            if (willDelete) {
                var hasil = '';
                $.ajax({
                    type: 'post',
                    url: "{{ route('b.setting-proses') }}",
                    data: {
                        id: id,
                        dd: "{{ $key['h_order_source']['dd'] }}",
                        tt: "{{ $key['h_order_source']['tt'] }}",
                    },
                    success: function(data) {
                        hasil = data;
                    },
                    error: function(xhr, b, c) {
                        swal("Error", '' + c, "error");
                    }
                }).done(function() {
                    if (hasil.sukses) {
                        swal("Berhasil!", "Berhasil menghapus data order source!",
                            "success");
                        tabelDataOrderSource.ajax.reload(null, false);
                    } else {
                        swal("Gagal", "" + hasil.msg, "error");
                    }
                });
            }
        });
    }

    //Delete data payment
    world.fn.hapusPayment = function(tabelData) {
        var id = $(this).data('id');
        swal({
            title: "Peringatan",
            text: "Apakah anda yakin ingin menghapus data bank?",
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
                },
            },
            dangerMode: true
        }).then((willDelete) => {
            if (willDelete) {
                var hasil = '';
                $.ajax({
                    type: 'post',
                    url: "{{ route('b.setting-proses') }}",
                    data: {
                        id: id,
                        dd: "{{ $key['h_bank']['dd'] }}",
                        tt: "{{ $key['h_bank']['tt'] }}",
                    },
                    success: function(data) {
                        hasil = data;
                    },
                    error: function(xhr, b, c) {
                        swal("Error", '' + c, "error");
                    }
                }).done(function() {
                    if (hasil.sukses) {
                        swal("Berhasil!", "Berhasil menghapus data payment!", "success");
                        tabelDataPayment.ajax.reload(null, false);
                    } else {
                        swal("Gagal", "" + hasil.msg, "error");
                    }
                });
            }
        });
    }


    // Get User Data
    world.fn.editUser = function() {
        var id = $(this).data('id');
        var hasil;
        $.ajax({
            type: 'get',
            url: '{{ route("b.setting-getUserData") }}',
            data: {
                v: id
            },
            success: function(data) {
                hasil = data;
            }
        }).done(function() {
            if(hasil.role == "Admin"){
                $('#aksesDiv_edit').show();
            }
            $('#namaUser_edit').val(hasil.name);
            $('#emailUser_edit').val(hasil.email);
            $('#no_telpUser_edit').val(hasil.no_telp);
            $('#roleUser_edit').selectpicker('val', hasil.role);
            $('#usernameUser_edit').val(hasil.username);
            if(hasil.ijin != null){
                var ijin = jQuery.parseJSON(hasil.ijin);
                if(ijin.menuExpense == 1){
                    $('#i_menuExpense_edit').trigger('click');
                }
                if(ijin.melihatAnalisa == 1){
                    $('#i_melihatAnalisa_edit').trigger('click');
                }
                if(ijin.hapusProduk == 1){
                    $('#i_hapusProduk_edit').trigger('click');
                }
                if(ijin.uploadProdukExcel == 1){
                    $('#i_uploadProdukExcel_edit').trigger('click');
                }
                if(ijin.downloadExcel == 1){
                    $('#i_downloadExcel_edit').trigger('click');
                }
                if(ijin.hapusCustomer == 1){
                    $('#i_hapusCustomer_edit').trigger('click');
                }
                if(ijin.editCustomer == 1){
                    $('#i_editCustomer_edit').trigger('click');
                }
                if(ijin.editOrder == 1){
                    $('#i_editOrder_edit').trigger('click');
                }
                if(ijin.editOrderAdminLain == 1){
                    $('#i_editOrderAdminLain_edit').trigger('click');
                }
                if(ijin.cancelOrder == 1){
                    $('#i_cancelOrder_edit').trigger('click');
                }
                if(ijin.melihatOmset == 1){
                    $('#i_melihatOmset_edit').trigger('click');
                }
            }
            $('button[name=btnEditUser]').data('id', id);
        });
    }

    //Delete User
    world.fn.hapusUser = function(tabelData) {
        var id = $(this).data('id');
        swal({
            title: "Peringatan",
            text: "Apakah anda yakin ingin menghapus User?",
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
                },
            },
            dangerMode: true
        }).then((willDelete) => {
            if (willDelete) {
                var hasil = '';
                $.ajax({
                    type: 'post',
                    url: "{{ route('b.setting-proses') }}",
                    data: {
                        id: id,
                        dd: "{{ $key['h_user']['dd'] }}",
                        tt: "{{ $key['h_user']['tt'] }}",
                    },
                    success: function(data) {
                        hasil = data;
                    },
                    error: function(xhr, b, c) {
                        swal("Error", '' + c, "error");
                    }
                }).done(function() {
                    if (hasil.sukses) {
                        swal("Berhasil!", "Berhasil menghapus User!", "success");
                        tableDataUser.ajax.reload(null, false);
                    } else {
                        swal("Gagal", "" + hasil.msg, "error");
                    }
                });
            }
        });
    }

    
    // Get Filter Data
    world.fn.editFilter_order = function() {
        var id = $(this).data('id');
        var hasil;
        $.ajax({
            type: 'get',
            url: '{{ route("b.setting-getFilterOrderData") }}',
            data: {
                v: id
            },
            success: function(data) {
                hasil = data;
            }
        }).done(function() {
            $('#nama_filterMod').val(hasil.nama_filter);
            $('#btnEditFilterMod').data('id', id);
        });
    }
    
    // delete Filter Data
    world.fn.hapusFilter_order = function() {
        var id = $(this).data('id');
        swal({
            title: "Peringatan",
            text: "Apakah anda yakin ingin menghapus Filter Order?",
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
                },
            },
            dangerMode: true
        }).then((willDelete) => {
            if (willDelete) {
                var hasil = '';
                $.ajax({
                    type: 'post',
                    url: "{{ route('b.setting-proses') }}",
                    data: {
                        id: id,
                        dd: "{{ $key['h_filter_order']['dd'] }}",
                        tt: "{{ $key['h_filter_order']['tt'] }}",
                    },
                    success: function(data) {
                        hasil = data;
                    },
                    error: function(xhr, b, c) {
                        swal("Error", '' + c, "error");
                    }
                }).done(function() {
                    if (hasil.sukses) {
                        swal("Berhasil!", "Berhasil menghapus Filter Order!", "success");
                        tabelDataFilterOrder.ajax.reload(null, false);
                    } else {
                        swal("Gagal", "" + hasil.msg, "error");
                    }
                });
            }
        });
    }

})(jQuery);


// Carausel img template interval
// $('.carousel').carousel({
//     interval: 800
// })

// copyToClipboard
function copyToClipboard(copyText) {
    copyText.select();
    document.execCommand("copy");
}
</script>
<!--uiop-->
@endsection