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
    <div class="row layout-top-spacing justify-content-between">
        <div class="card animated animatedFadeInUp fadeInUp" style='width:100%;'>
            <div class='card-header'>
                <h5>
                    <strong>Detail pesanan</strong>
                    <span>(INV #{{ $order_data->urut_order }})</span>
                </h5>
            </div>
            <div class="card-body">
            </div>
        </div>
    </div>
</div>
<!--uiop-->
@endsection