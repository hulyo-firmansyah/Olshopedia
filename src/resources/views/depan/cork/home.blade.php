@extends('depan.cork.index')
@section('page')
    @if($r['cari'] !== '')
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('d.home', ['domain_toko' => $toko->domain_toko]) }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><span>Pencarian Produk</span></li>
        </ol>
    @else
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><span>Home</span></li>
        </ol>
    @endif
@endsection
@section('isi')
<!--uiop-->
<div class='container'>
    <div class="row layout-top-spacing justify-content-between">
        <div class='col-xl-4 col-lg-5 col-md-6'>
            <div class="search-input-group-style input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg></span>
                </div>
                <input type="text" class="form-control" placeholder="Cari Produk"
                    aria-label="Username" aria-describedby="basic-addon1">
            </div>
        </div>
    
        <div class='col-xl-3 col-lg-4 col-md-6'>
            <select id='sorting' height='100%' class="form-control basic">
                <option value='a-z' @if($r['sort']=='a-z' || $r['sort']==='' ) selected @endif>A - Z</option>
                <option value='z-a' @if($r['sort']=='z-a' ) selected @endif>Z - A</option>
                <option value='murah-mahal' @if($r['sort']=='murah-mahal' ) selected @endif>Termurah - Termahal</option>
                <option value='mahal-murah' @if($r['sort']=='mahal-murah' ) selected @endif>Termahal - Termurah</option>
            </select>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
});
</script>
<!--uiop-->
@endsection