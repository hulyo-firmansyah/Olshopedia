@extends('depan.default.index')
@section('isi')
<!--uiop-->
<style>
.btnFotoPilih {
    cursor:pointer;
}
</style>
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
    <div class='col-sm-5'>
        @php
            $cekFoto = false;
            $genVarian = \App\Http\Controllers\PusatController::genArray($produk->varian);
            foreach($genVarian as $v){
                if(isset($v->foto->utama)){
                    $foto_awal = $v->foto->utama;
                    $cekFoto = true;
                    $genVarian->send('stop');
                }
            }
            if(!$cekFoto){
                $foto_awal = asset('photo.png');
            }
        @endphp
        <a href='{{ $foto_awal }}'>
            <img src="{{ $foto_awal }}" alt="image utama" class="img-thumbnail" width='100%' id='foto-utama' style='margin-bottom:20px'>
        </a>
        @php
            $img_i = 0;
            $img_count = 0;
            foreach(\App\Http\Controllers\PusatController::genArray($produk->varian) as $v){
                $img_count += (isset($v->foto->utama) ? 1 : 0) + count($v->foto->lain);
                if(isset($v->foto->utama)){
                    if($img_i === 0){
                        echo "<div class='row'>";
                    }
                    echo "<div class='col-xs-3' style='padding:5px;'><img src='".$v->foto->utama."' alt='image list' id='lu-".$v->id_varian."' class='img-thumbnail btnFotoPilih' width='120' height='120'></div>";
                    $img_i++;
                    if($img_i % 4 === 0){
                        $img_i = 0;
                        echo "</div>";
                    }
                }
                foreach(\App\Http\Controllers\PusatController::genArray($v->foto->lain) as $ll){
                    if($img_i === 0){
                        echo "<div class='row'>";
                    }
                    echo "<div class='col-xs-3' style='padding:5px;'><img src='".$ll."' alt='image list' class='img-thumbnail btnFotoPilih' width='120' height='120'></div>";
                    $img_i++;
                    if($img_i % 4 === 0){
                        $img_i = 0;
                        echo "</div>";
                    }
                }
            }
            if($img_count % 4 !== 0){
                echo "</div>";
            }
        @endphp
    </div>
    <div class='col-sm-7'>
        <h1>{{ $produk->nama_produk }}</h1>
        <div class='row' style='margin-top:30px'>
            <div class='col-md-12'>
                <label>Varian</label>
            </div>
            <div class='col-md-12'>
                @php
                    foreach(\App\Http\Controllers\PusatController::genArray($produk->varian) as $i => $v){
                        $btnTampil = '';
                        if(($v->ukuran != null && $v->ukuran != "") && ($v->warna != null && $v->warna != "")){
                            $btnTampil .= " (".$v->ukuran." "+$v->warna.") ";
                        } else if(($v->ukuran != null && $v->ukuran != "") && ($v->warna == null || $v->warna == "")){
                            $btnTampil .= " (".$v->ukuran.") ";
                        } else if(($v->ukuran == null || $v->ukuran == "") && ($v->warna != null && $v->warna != "")){
                            $btnTampil .= " (".$v->warna.") ";
                        }
                        if($btnTampil === ''){
                            $btnTampil = ($i+1);
                        }
                        @endphp
                        @php
                        if($i == 0){
                            @endphp
                            <button class='btn btn-primary btnPilihVarian' type='button' data-id='lu-{{ $v->id_varian }}'>{{ $btnTampil }}</button>
                            @php
                        } else {
                            @endphp
                            <button class='btn btn-default btnPilihVarian' type='button' data-id='lu-{{ $v->id_varian }}'>{{ $btnTampil }}</button>
                            @php
                        }
                    }
                @endphp
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){

        $('.btnFotoPilih').on('click', function(){
            let src = $(this).attr('src');
            $('#foto-utama').attr('src', src);
        });

        $('.btnPilihVarian').on('click', function(){
            let list = Array.prototype.slice.call($(this).parent().children());
            var this_ = this;
            list.forEach(function(html) {
                if($(html).hasClass('btn-primary') && html !== this_){
                    $(html).removeClass('btn-primary');
                    $(html).addClass('btn-default');
                }
            });
            if($(this).hasClass('btn-default')){
                $(this).removeClass('btn-default');
                $(this).addClass('btn-primary');
                let id_src = $(this).data('id');
                let src = $('#'+id_src).attr('src');
                $('#foto-utama').attr('src', src);
            }
        });

    });
</script>
<!--uiop-->
@endsection