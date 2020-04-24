@extends('depan.default.index')
@section('isi')
<!--uiop-->
<div class="page-header page-header-bordered">
    <div class='row'>
        <div class='col-md-12'>
            <ol class="breadcrumb">
                @if($r['cari'] !== '')
                    <li class="breadcrumb-item">
                        <a href='{{ route("d.home", ["toko_slug" => $toko->domain_toko]) }}'>Home</a>
                    </li>
                    <li class="breadcrumb-item active">Pencarian Produk</li>
                @else
                    <li class="breadcrumb-item active">Home</li>
                @endif
            </ol>
        </div>
    </div>
</div>
<div class='row'>
    <div class='col-lg-6'>
        @if($r['cari'] !== '')
            <h1 class="page-title font-size-26 font-weight-100">Pencarian Produk</h1>
        @else
            <h1 class="page-title font-size-26 font-weight-100">Katalog Produk</h1>
        @endif
    </div>
    <div class='col-lg-6'>
        <div class='text-right' style='margin-top:25px'>
            <div class='form-inline'>
                <label for='sorting'>Urutkan berdasarkan :</label>
                <select id='sorting'>
                    <option value='a-z' @if($r['sort'] == 'a-z') selected @endif>A - Z</option>
                    <option value='z-a' @if($r['sort'] == 'z-a') selected @endif>Z - A</option>
                    <option value='murah-mahal' @if($r['sort'] == 'murah-mahal') selected @endif>Termurah - Termahal</option>
                    <option value='mahal-murah' @if($r['sort'] == 'mahal-murah') selected @endif>Termahal - Termurah</option>
                </select>
            </div>
        </div>
    </div>
</div>
<hr>

<div class="row" id='produk-list'>
    @if(count($produk) > 0)
        @foreach(\App\Http\Controllers\PusatController::genArray($produk) as $p)
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="thumbnail">
                <img src="{{ asset('photo.png') }}" alt="..." width='240px' height='240px'>
                <div class="caption">
                    <h3>{{ $p->nama_produk }}</h3>
                    @php
                        if($p->termurah !== $p->termahal){
                            @endphp
                            <p>{{ \App\Http\Controllers\PusatController::formatUang($p->termurah, true).' - '.\App\Http\Controllers\PusatController::formatUang($p->termahal, true) }}</p>
                            @php
                        } else {
                            @endphp
                            <p>{{ \App\Http\Controllers\PusatController::formatUang($p->termurah, true) }}</p>
                            @php
                        }
                    @endphp
                    <p>{{ $p->ket ?? '' }}</p>
                    <p class='text-right'>
                        <a href="javascript:void(0)" class="btn btn-primary btnDetailProduk" role="button" data-id='{{ $p->id_produk }}'>Selengkapnya</a>
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
<script>
    $(document).ready(function(){
        $('#sorting').on('change', function(){
            // console.log($(this).val());
            $(location).attr('href', '{{ route("d.home", ["toko_slug" => $toko->domain_toko]) }}?sort='+$(this).val()+'@if($r["cari"] !== "")&q={{$r["cari"]}}@endif');
        });

        $('.btnDetailProduk').on('click', function(){
            let id = $(this).data('id');
            $(location).attr('href', '{{ route("d.home", ["toko_slug" => $toko->domain_toko]) }}/produk/'+id);
        })
    });
</script>
<!--uiop-->
@endsection