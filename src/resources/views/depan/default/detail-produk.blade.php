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
        <div class='row' style='margin-top:20px'>
            <div class='col-md-12'>
                <label>Jumlah</label>
            </div>
            <div class='col-md-5 col-lg-3'>
                <input type='text' class='form-control' name='jumlah' id='jumlah' placeholder='Jumlah' value='1'>
            </div>
        </div>
        <div class='d-flex flex-column flex-md-row' style='margin-top:30px'>
            <button type='button' class='btn btn-primary'><i class='fa fa-shopping-cart'></i> Masukkan ke Keranjang</button>
            <button type='button' class='btn btn-default'><i class='fa fa-whatsapp'></i> Beli Via Whatsapp</button>
        </div>
        <div style='margin-top:30px'>
            <label>Share:</label>
            <div class="d-flex">
                <a class='btn btn-default' style='margin-right:5px;' target='_blank' href='http://www.facebook.com/sharer.php?u={{ urlencode(url()->current()) }}'><i class="fa fa-facebook"></i></a>
                <a class='btn btn-default' style='margin-right:5px;' target='_blank' href='https://twitter.com/share?url={{ urlencode(url()->current()) }}'><i class="fa fa-twitter"></i></a>
                <a class='btn btn-default' style='margin-right:5px;' target='_blank' href='https://plus.google.com/share?url={{ urlencode(url()->current()) }}'><i class="fa fa-google-plus"></i></a>
                <a class='btn btn-default' style='margin-right:5px;' target='_blank' href='https://telegram.me/share/url?url={{ urlencode(url()->current()) }}&text={{ $produk->nama_produk }}'><i class="fa fa-telegram"></i></a>
                <a class='btn btn-default' target='_blank' href='https://api.whatsapp.com/send?phone=&text={{ urlencode(url()->current()) }}'><i class="fa fa-whatsapp"></i></a>
            </div>
        </div>
        @if(isset($produk->ket) && $produk->ket !== '')
        <div style='margin-top:40px'>
            <ul class="nav nav-tabs">
                <li role="presentation" class="active"><a href="#tabDeskripsi" data-toggle='tab'>Deskripsi</a></li>
                <!-- <li role="presentation"><a href="#tab2" data-toggle='tab'>Profile</a></li> -->
            </ul>
            <div class="tab-content" style='padding-top:20px'>
                <div class="tab-pane active" id="tabDeskripsi" role="tabpanel">
                    {{ $produk->ket }}
                </div>
                <!-- <div class="tab-pane" id="tab2" role="tabpanel">
                    Mnesarchum velit cumanum utuntur tantam deterritum, democritum vulgo contumeliae
                    abest studuisse quanta telos. Inmensae. Arbitratu dixisset
                    invidiae ferre constituto gaudeat contentam, omnium nescius,
                    consistat interesse animi, amet fuisset numen graecos incidunt
                    euripidis praesens, homines religionis dirigentur postulant.
                    Magnum utrumvis gravitate appareat fabulae facio perveniri
                    fruenda indicaverunt texit, frequenter probet diligenter
                    sententia meam distinctio theseo legerint corporis quoquo,
                    optari futurove expedita.
                </div> -->
            </div>
        </div>
        @endif
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