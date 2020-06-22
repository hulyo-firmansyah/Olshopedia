@extends('depan.cork.index')
@section('page')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('d.home', ['domain_toko' => $toko->domain_toko]) }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page"><span>Order #{{ $order_data->urut_order }}</span></li>
</ol>
@endsection
@section('isi')
<!--uiop-->
<div class='container'>
</div>
<!--uiop-->
@endsection