@extends('depan.default.index')
@section('isi')
<!--uiop-->
<div class="page-header page-header-bordered">
    <div class='row'>
        <div class='col-md-12'>
            <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href='{{ route("d.home", ["toko_slug" => $toko->domain_toko]) }}'>Home</a>
                    </li>
                    <li class="breadcrumb-item active">{{ $produk->nama_produk }}</li>
            </ol>
        </div>
    </div>
</div> 
<div class='row'>
    <div class='col-md-5'>
        @php
            $cekFoto = false;
            $genVarian = \App\Http\Controllers\PusatController::genArray($produk->varian);
            foreach($genVarian as $v){
                if(count($v->foto->utama) > 0){
                    $foto_awal = $v->foto->utama[0];
                    $cekFoto = true;
                    $genVarian->send('stop');
                }
            }
            if(!$cekFoto){
                $foto_awal = asset('photo.png');
            }
        @endphp
        <img src="{{ $foto_awal }}" alt="image utama" class="img-rounded" width='100%'>
        @php
            $img_i = 0;
            foreach(\App\Http\Controllers\PusatController::genArray($produk->varian) as $v){
                foreach(\App\Http\Controllers\PusatController::genArray($v->foto->list) as $l){
                    if($img_i % 4 === 0){
                        @endphp
                        <div class='row'>
                        @php
                    }
                    @endphp
                    <div class='col-lg-3' style='padding:5px;'>
                        <img src="{{ $l }}" alt="image list" class="img-thumbnail" width='120' height='120'>
                    </div>
                    @php
                    $img_i++;
                    if($img_i % 4 === 0){
                        @endphp
                        </div>
                        @php
                    }
                }
            }
        @endphp
        </div>
    </div>
    <div class='col-md-7'>
        asdasd
    </div>
</div>
<!--uiop-->
@endsection