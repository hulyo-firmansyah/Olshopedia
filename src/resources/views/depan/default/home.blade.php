@extends('depan.default.index')
@section('isi')
<!--uiop-->
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
                <a href="javascript:void(0)" class="btn btn-primary" role="button">Selengkapnya</a>
            </p>
        </div>
    </div>
</div>
@endforeach
<!--uiop-->
@endsection