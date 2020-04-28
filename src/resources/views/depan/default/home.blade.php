@extends('depan.default.index')
@section('isi')
<!--uiop-->
<style>
.thumbnail {
    display: block;
    padding: 4px;
    margin-bottom: 20px;
    line-height: 1.42857143;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    -webkit-transition: border .2s ease-in-out;
    -o-transition: border .2s ease-in-out;
    transition: border .2s ease-in-out;
}
.thumbnail .caption {
    padding: 9px;
    color: #333;
}
</style>
<div class="content-header">
    <div class='container'>
        @if($r['cari'] !== '')
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Pencarian Produk</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a
                            href="{{ route('d.home', ['domain_toko' => $toko->domain_toko]) }}">Home</a></li>
                    <li class="breadcrumb-item active">Pencarian Produk</li>
                </ol>
            </div>
        </div>
        @else
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Home</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Home</li>
                </ol>
            </div>
        </div>
        @endif
    </div>
</div>

<hr>

<div class="content">
    <div class='container'>
        <div class='row'>
            <div class='col-md-12'>
                <select id='sorting' height='100%'>
                    <option value='a-z' @if($r['sort']=='a-z' || $r['sort']==='' ) selected @endif>A - Z</option>
                    <option value='z-a' @if($r['sort']=='z-a' ) selected @endif>Z - A</option>
                    <option value='murah-mahal' @if($r['sort']=='murah-mahal' ) selected @endif>Termurah - Termahal</option>
                    <option value='mahal-murah' @if($r['sort']=='mahal-murah' ) selected @endif>Termahal - Termurah</option>
                </select>
            </div>
        </div>
        <div class="row" id='produk-list' style='margin-top:25px'>
            @if(count($produk) > 0)
                @foreach(\App\Http\Controllers\PusatController::genArray($produk) as $p)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card card-default color-palette-box thumbnail">
                        @php
                            $cekFoto = false;
                            $genVarian = \App\Http\Controllers\PusatController::genArray($p->varian);
                            foreach($genVarian as $v){
                                if(isset($v->foto->utama)){
                                    $foto = $v->foto->utama;
                                    $cekFoto = true;
                                    $genVarian->send('stop');
                                }
                            }
                            if(!$cekFoto){
                                $foto = asset('photo.png');
                            }
                        @endphp
                        <center style='padding:5px'>
                            <img src="{{ $foto }}" alt="..." width='240px' height='240px'>
                        </center>
                        <div class="caption">
                            <h3>{{ $p->nama_produk }}</h3>
                            @php
                                if($p->termurah !== $p->termahal){
                                    @endphp
                                    <p>{{ \App\Http\Controllers\PusatController::formatUang($p->termurah, true).' - '.\App\Http\Controllers\PusatController::formatUang($p->termahal, true) }}
                                    </p>
                                    @php
                                } else {
                                    @endphp
                                    <p>{{ \App\Http\Controllers\PusatController::formatUang($p->termurah, true) }}</p>
                                    @php
                                }
                            @endphp
                            <p>{{ $p->ket ?? '' }}</p>
                            <p class='text-right'>
                                <a href="javascript:void(0)" class="btn btn-primary btnDetailProduk" role="button"
                                    data-url='{{ $p->produk_url }}'>Selengkapnya</a>
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                @if($r['cari'] !== '')
                <div class="col-xxl-12">
                    <p>Produk tidak ditemukan!</p>
                </div>
                @else
                <div class="col-xxl-12">
                    <p>Tidak ada produk di Toko ini!</p>
                </div>
                @endif
            @endif
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    $('#sorting').select2({
        theme: 'bootstrap4'
    });

    $('#sorting').on('change', function() {
        // console.log($(this).val());
        $(location).attr('href', '{{ route("d.home", ["domain_toko" => $toko->domain_toko]) }}?sort=' +
            $(this).val() + '@if($r["cari"] !== "")&q={{$r["cari"]}}@endif');
    });

    $('.btnDetailProduk').on('click', function() {
        let url = $(this).data('url');
        $(location).attr('href',
            '{{ route("d.home", ["domain_toko" => $toko->domain_toko]) }}/produk/' + url);
    })
});
</script>
<!--uiop-->
@endsection