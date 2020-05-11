@extends('depan.cork.index')
@section('page')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('d.home', ['domain_toko' => $toko->domain_toko]) }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page"><span>{{ $produk->nama_produk }}</span></li>
</ol>
@endsection
@section('isi')
<!--uiop-->
<div class='container'>
    <div class="row layout-top-spacing justify-content-between">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-6" id='gambarDiv'>
                        <h3 class="d-inline-block d-sm-none">{{ $produk->nama_produk }}</h3>
                        <div class="col-12">
                            <img src="{{ $produk->varian[0]->foto->utama }}" class="product-image" alt="Product Image">
                        </div>
                        <div class="col-12 product-image-thumbs">
                            @php
                                $img_i = 0;
                                if(isset($produk->varian[0]->foto->utama)){
                                    if($img_i === 0){
                                        @endphp
                                            <div class="product-image-thumb active"><img src="{{ $produk->varian[0]->foto->utama }}" alt="Product Image"></div>
                                        @php
                                    } else {
                                        @endphp
                                            <div class="product-image-thumb"><img src="{{ $produk->varian[0]->foto->utama }}" alt="Product Image"></div>
                                        @php
                                    }
                                    $img_i++;
                                }
                                foreach(\App\Http\Controllers\PusatController::genArray($produk->varian[0]->foto->lain) as $ll){
                                    if($img_i === 0){
                                        @endphp
                                            <div class="product-image-thumb active"><img src="{{ $ll }}" alt="Product Image"></div>
                                        @php
                                    } else {
                                        @endphp
                                            <div class="product-image-thumb"><img src="{{ $ll }}" alt="Product Image"></div>
                                        @php
                                    }
                                    $img_i++;
                                }
                            @endphp
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <h3 class="my-3">{{ $produk->nama_produk }}</h3>
                        <hr>
                        <h5 class="mt-4">Varian</h5>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            @php
                                foreach(\App\Http\Controllers\PusatController::genArray($produk->varian) as $i => $v){
                                    $btnTampil = '';
                                    if(($v->ukuran != null && $v->ukuran != "") && ($v->warna != null && $v->warna != "")){
                                        $btnTampil .= "<span class='text-lg'>".$v->ukuran."</span><br>".$v->warna;
                                    } else if(($v->ukuran != null && $v->ukuran != "") && ($v->warna == null || $v->warna == "")){
                                        $btnTampil .= "<span class='text-lg'>".$v->ukuran."</span>";
                                    } else if(($v->ukuran == null || $v->ukuran == "") && ($v->warna != null && $v->warna != "")){
                                        $btnTampil .= "<span class='text-lg'>".$v->warna."</span>";
                                    }
                                    if($btnTampil === ''){
                                        $btnTampil = "<span class='text-lg'>".($i+1)."</span>";
                                    }
                                    @endphp
                                    @php
                                    if($i == 0){
                                        @endphp
                                        <label class="btn btn-primary text-center">
                                            <input type="radio" name="varian_pilihan" id="varian_pilihan-{{($i+1)}}" value='{{ $v->id_varian }}' autocomplete="off">
                                            {!! $btnTampil !!}
                                        </label>
                                        @php
                                    } else {
                                        @endphp
                                        <label class="btn btn-default text-center">
                                            <input type="radio" name="varian_pilihan" id="varian_pilihan-{{($i+1)}}" value='{{ $v->id_varian }}' autocomplete="off">
                                            {!! $btnTampil !!}
                                        </label>
                                        @php
                                    }
                                }
                            @endphp
                        </div>
                        <div class="mt-4" id='hargaDiv'>
                            <h5>Harga</h5>
                            <h4 class="mb-0">
                                {{ \App\Http\Controllers\PusatController::formatUang($produk->varian[0]->harga_jual_normal, true) }}
                            </h4>
                        </div>
                        <h5 class="mt-4">Jumlah</h5>
                        <div class='row'>
                            <div class='col-lg-5'>
                                <input type='text' class='form-control' name='jumlah' id='jumlah' placeholder='Jumlah' value='1'>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type='button' id='btnTambahCart' class="btn btn-primary btn-md" data-ip='{{ $produk->id_produk }}' data-iv='{{ $produk->varian[0]->id_varian }}'>
                                <i class="fas fa-cart-plus fa-lg mr-2"></i>
                                Tambahkan ke Keranjang
                            </button>
                        </div>
                        <div class="mt-5 product-share">
                            <a href="http://www.facebook.com/sharer.php?u={{ urlencode(url()->current()) }}" target='_blank' class="text-gray">
                                <i class="fab fa-facebook-square fa-2x"></i>
                            </a>
                            <a href="https://twitter.com/share?url={{ urlencode(url()->current()) }}" target='_blank' class="text-gray">
                                <i class="fab fa-twitter-square fa-2x"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="w-100">
                        <div class="nav nav-tabs" id="product-tab" role="tablist">
                            <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc" 
                                role="tab" aria-controls="product-desc" aria-selected="true">Deskripsi</a>
                            <a class="nav-item nav-link" id="product-rating-tab" data-toggle="tab" href="#product-rating"
                                role="tab" aria-controls="product-rating" aria-selected="false">Review</a>
                        </div>
                    </div>
                    <div class="tab-content p-3" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="product-desc" role="tabpanel"aria-labelledby="product-desc-tab">
                            {{ $produk->ket }} 
                        </div>
                        <div class="tab-pane fade" id="product-rating" role="tabpanel" aria-labelledby="product-rating-tab">
                            -
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--uiop-->
@endsection