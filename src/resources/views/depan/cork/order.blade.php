@extends('depan.cork.index')
@section('page')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('d.home', ['domain_toko' => $toko->domain_toko]) }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page"><span>Order</span></li>
</ol>
@endsection
@section('isi')
<!--uiop-->
@php
$produk = json_decode($order_data->produk);
@endphp
<style>
.total-bayar {
    font-size:32px;
    border: 1px solid #14c935;
    color:#14c935;
    padding:10px;
    border-radius:10px;
}
</style>
<div class='container'>
    <div class="row layout-top-spacing justify-content-between">
        <div class="card" style='width:100%;'>
            <div class='card-header'>
                <h5>
                    <strong>Detail pesanan</strong>
                    <span>(INV #{{ $order_data->urut_order }})</span>
                </h5>
            </div>
            <div class="card-body">
                <div class='invoice'>
                    <div class="content-section animated animatedFadeInUp fadeInUp" style='height:unset;'>

                        <div class="row inv--detail-section">

                            <div class="col-sm-7 align-self-center">
                                <p class="inv-to">Invoice Untuk</p>
                            </div>
                            <div class="col-sm-5 align-self-center  text-sm-right order-sm-0 order-1">
                                <p class="inv-detail-title">Dari : {{ $toko->nama_toko }}</p>
                            </div>

                            <div class="col-sm-7 align-self-center">
                                <p class="inv-customer-name">{{ strtoupper($tujuan_kirim->name) }}</p>
                                <p class="inv-street-addr">{{ $tujuan_kirim->alamat }}</p>
                                <p class="inv-email-address">{{ $tujuan_kirim->kecamatan }}, {{ $tujuan_kirim->kabupaten }}, {{ $tujuan_kirim->provinsi }} ({{ $tujuan_kirim->kode_pos }})</p>
                            </div>
                            <div class="col-sm-5 align-self-center  text-sm-right order-2">
                                <p class="inv-list-number"><span class="inv-title">Invoice Number : </span> <span
                                        class="inv-number">#{{ $order_data->urut_order }}</span></p>
                                <p class="inv-created-date"><span class="inv-title">Invoice Date : </span> <span
                                        class="inv-date">{{ date('d F Y', strtotime($order_data->tgl_dibuat)).date(' (H:i:s)', strtotime($order_data->tgl_dibuat)) }}</span></p>
                                <p class="inv-due-date"><span class="inv-title">Due Date : </span> <span class="inv-date">{{ date('d F Y', strtotime($order_data->tgl_expired)).date(' (H:i:s)', strtotime($order_data->tgl_expired)) }}</span></p>
                            </div>
                        </div>

                        <div class="row inv--product-table-section">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="">
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Produk</th>
                                                <th class="text-right" scope="col">Jumlah</th>
                                                <th class="text-right" scope="col">Harga</th>
                                                <th class="text-right" scope="col">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(\App\Http\Controllers\PusatController::genArray($produk->list) as $_p => $p)
                                                <tr>
                                                    <td>{{ ($_p+1) }}</td>
                                                    <td>{{ $p->rawData->nama_produk }}</td>
                                                    <td class="text-right">{{ $p->jumlah }}</td>
                                                    <td class="text-right">Rp {{ \App\Http\Controllers\PusatController::formatUang($p->rawData->harga_jual_normal) }}</td>
                                                    <td class="text-right">Rp {{ \App\Http\Controllers\PusatController::formatUang($p->rawData->harga_jual_normal * $p->jumlah) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-sm-5 col-12 order-sm-0 order-1">
                                <div class="inv--payment-info" style='margin-bottom:unset;'>
                                    <div class="row">
                                        <div class="col-sm-12 col-12">
                                            <h6 class=" inv-title">Payment Info:</h6>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <p class=" inv-subtitle">Bank Name: </p>
                                        </div>
                                        <div class="col-sm-8 col-12">
                                            <p class="">
                                                @php
                                                    $pembayaran = json_decode($order_data->pembayaran);
                                                    echo explode('|', $pembayaran->via)[1];
                                                @endphp
                                            </p>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <p class=" inv-subtitle">No Rekening: </p>
                                        </div>
                                        <div class="col-sm-8 col-12">
                                            <p class="">
                                                @php
                                                    $bank = \DB::table('t_bank')
                                                        ->where('data_of', \App\Http\Controllers\PusatController::dataOfByDomainToko($toko->domain_toko))
                                                        ->where('id_bank', explode('|', $pembayaran->via)[0])
                                                        ->get()->first();
                                                    echo $bank->no_rek;
                                                @endphp
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-7 col-12 order-sm-1 order-0">
                                <div class="inv--total-amounts text-sm-right" style='margin-bottom:unset;'>
                                    <div class="row">
                                        <div class="col-sm-8 col-7">
                                            <p class="">Sub Total: </p>
                                        </div>
                                        <div class="col-sm-4 col-5">
                                            <p class="">
                                                @php
                                                    $total = json_decode($order_data->total);
                                                    echo 'Rp '.\App\Http\Controllers\PusatController::formatUang($total->hargaProduk);
                                                @endphp
                                            </p>
                                        </div>
                                        <div class="col-sm-8 col-7">
                                            <p class="">Expedisi: </p>
                                        </div>
                                        <div class="col-sm-4 col-5">
                                            <p class="">
                                                @php
                                                    $total = json_decode($order_data->total);
                                                    echo 'Rp '.\App\Http\Controllers\PusatController::formatUang($total->hargaOngkir);
                                                @endphp
                                            </p>
                                        </div>
                                        <!-- <div class="col-sm-8 col-7">
                                            <p class="">Tax Amount: </p>
                                        </div>
                                        <div class="col-sm-4 col-5">
                                            <p class="">$700</p>
                                        </div>
                                        <div class="col-sm-8 col-7">
                                            <p class=" discount-rate">Discount : <span class="discount-percentage">5%</span>
                                            </p>
                                        </div>
                                        <div class="col-sm-4 col-5">
                                            <p class="">$700</p>
                                        </div> -->
                                        <div class="col-sm-8 col-7 grand-total-title">
                                            <h4 class="">Total : </h4>
                                        </div>
                                        <div class="col-sm-4 col-5 grand-total-amount">
                                            <h4 class="">
                                                @php
                                                    $total = json_decode($order_data->total);
                                                    echo 'Rp '.\App\Http\Controllers\PusatController::formatUang($total->hargaProduk + $total->hargaOngkir);
                                                @endphp
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='mt-5' style='background:white;border-radius:5px;border: 1px solid rgba(0,0,0,.125);width:100%'>
            <div class="text-center" style='font-size:16px;padding:20px;'>
                <p style='margin-bottom:40px;'>Agar pesanan Anda dapat segera diproses, segera lakukan pembayaran sejumlah:</p>
                <span class="total-bayar">Rp {{ \App\Http\Controllers\PusatController::formatUang($total->hargaProduk + $total->hargaOngkir) }}</span>
                <p class="text-danger mb-2" style='margin-top:40px;'>Note: + Rp47 untuk kode unik</p>
                <p class="mb-4 tc-text-color" style="margin-bottom: 1.5rem;">
                    Mohon selesaikan pembayaran sesuai nominal diatas sebelum::
                    <br>
                    <span class="badge badge-warning tc-text-color" style="font-size: .75rem; font-weight: normal;">
                        {{ date('d F Y', strtotime($order_data->tgl_expired)).date(' (H:i:s)', strtotime($order_data->tgl_expired)) }}
                    </span>
                </p>
                <div class="row no-gutters">
                    <div class="col-sm-6 text-center text-sm-right">
                        <!-- <img class="mr-sm-3" src="/assets/img/bank/bsm.svg" alt="BSM" style="width: 100px;"> -->
                    </div>
                    <div class="col-sm-6 text-left">
                        Transfer Bank {{ $bank->bank }} <p class="h4 lead mb-2"><strong>{{ $bank->no_rek }}</strong></p>
                        Cabang  {{ $bank->cabang }},  An. {{ $bank->atas_nama }} 
                    </div>
                </div>
                <div style='border-bottom: 1px solid rgba(0,0,0,.125);margin-bottom:30px;margin-top:30px;'></div>
                <p>Setelah melakukan transfer silakan konfirmasi dengan klik tombol dibawah ini:</p>
                <a href="/catalog/orders_confirmation/1130258" class="btn btn-lg btn-primary my-2 mb-4"><i class="fa fa-check">done</i>Saya sudah bayar</a>
                <p>Jika anda ingin merubah metode pembayaran silahkan klik: <a data-toggle="modal" data-target="#modalChoosePayment" href="" class='text-warning'>Ganti metode pembayaran</a></p>
                <div style='border-bottom: 1px solid rgba(0,0,0,.125);margin-bottom:30px;margin-top:30px;'></div>
                <p class="small">
                    <span class="tc-text-color">Jika Anda tidak menerima email invoice ini Anda dapat</span>
                    <a class="text-warning" href="/catalog/send_email/1130258/resend">mengirim ulang invoice</a>
                </p>
            </div>
        </div>
    </div>
</div>
<!--uiop-->
@endsection