@extends('depan.cork.index')
@section('page')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('d.home', ['domain_toko' => $toko->domain_toko]) }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page"><span>Order</span></li>
</ol>
@endsection
@section('isi')
<!--uiop-->
<!--uiop-->
@endsection