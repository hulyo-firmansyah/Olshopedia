@extends('depan.cork.index')
@section('page')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('d.home', ['domain_toko' => $toko->domain_toko]) }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('d.order', ['domain_toko' => $toko->domain_toko, 'order_slug' => $order_slug]) }}">Order #{{ $order_data->urut_order }}</a></li>
    <li class="breadcrumb-item active" aria-current="page"><span>Konfirmasi Pembayaran</span></li>
</ol>
@endsection
@section('isi')
<!--uiop-->
<div class='container'>
    <div class="row layout-top-spacing justify-content-between">
        <div class="card animated animatedFadeInUp fadeInUp" style='width:100%;'>
            <div class='card-header'>
                <h5>
                    <strong>Konfirmasi Pembayaran</strong>
                    <span>(INV #{{ $order_data->urut_order }})</span>
                </h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Full Name</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" value="Alan Green">
                </div> 
                <div class="form-group">
                    <label for="exampleFormControlInput1">Full Name</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" value="Alan Green">
                </div> 
                <div class="form-group">
                    <label for="exampleFormControlInput1">Full Name</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" value="Alan Green">
                </div> 
                <div class="form-group">
                    <label for="exampleFormControlInput1">Full Name</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" value="Alan Green">
                </div> 
                <div class="form-group">
                    <label for="exampleFormControlInput1">Full Name</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" value="Alan Green">
                </div> 
                <div class="form-group">
                    <label for="exampleFormControlInput1">Full Name</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" value="Alan Green">
                </div> 
                <div class="form-group">
                    <label for="exampleFormControlInput1">Full Name</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" value="Alan Green">
                </div> 
                <div class="form-group">
                    <label for="exampleFormControlInput1">Full Name</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" value="Alan Green">
                </div> 
            </div>
        </div>
    </div>
</div>
<!--uiop-->
@endsection