@extends('depan.default.index')
@section('isi')
<!--uiop-->
<div class='row'>
    <div class='col-lg-6'>
        <h1 class="page-title font-size-26 font-weight-100">Katalog Produk</h1>
    </div>
    <div class='col-lg-6'>
        <div class='text-right' style='margin-top:25px'>
            <div class='form-inline'>
                <label for='sorting'>Urutkan berdasarkan :</label>
                <select id='sorting'>
                    <option value='a-z' @if($sort == 'a-z') selected @endif>A - Z</option>
                    <option value='z-a' @if($sort == 'z-a') selected @endif>Z - A</option>
                    <option value='murah-mahal' @if($sort == 'murah-mahal') selected @endif>Termurah - Termahal</option>
                    <option value='mahal-murah' @if($sort == 'mahal-murah') selected @endif>Termahal - Termurah</option>
                </select>
            </div>
        </div>
    </div>
</div>
<hr>

<div class="row">
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
                    <a href="javascript:void(0)" class="btn btn-primary" role="button" data-id='{{ $p->id_produk }}'>Selengkapnya</a>
                </p>
            </div>
        </div>
    </div>
    @endforeach
</div>
<script>
    $(document).ready(function(){
        $('#sorting').on('change', function(){
            // console.log($(this).val());
            $(location).attr('href', '{{ route("d.home", ["toko_slug" => $toko->domain_toko]) }}?sort='+$(this).val());
        });
    });
</script>
<!--uiop-->
@endsection