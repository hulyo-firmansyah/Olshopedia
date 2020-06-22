@extends('depan.cork.index')
@section('page')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('d.home', ['domain_toko' => $toko->domain_toko]) }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page"><span>Order #{{ $order_data->urut_order }}</span></li>
</ol>
@endsection
@section('isi')
<!--uiop-->
@php
$produk = json_decode($order_data->produk);
@endphp
<div class='container'>
    <div class="row layout-top-spacing justify-content-between">
        <div class="card animated animatedFadeInUp fadeInUp" style='width:100%;'>
            <div class='card-header'>
                <h5>
                    <strong>Detail pesanan</strong>
                    <span>(Order #{{ $order_data->urut_order }})</span>
                </h5>
            </div>
            <div class="card-body">
                <div class='row'>
                    <div class='col-md-12'>
                        <div class="pearls">
                            @php
                                switch($order_data->state){
                                    case 'bayar':
                                        $state = 1;
                                        break;

                                    case 'proses':
                                        $state = 2;
                                        break;

                                    case 'kirim':
                                        $state = 3;
                                        break;

                                    case 'terima':
                                        $state = 4;
                                        break;

                                    default:
                                        $state = 1;
                                        break;
                                        
                                }
                            @endphp
                            <div class="pearl @if($state === 1) current @else done @endif col-3" id='pearl-kirim'>
                                <div class="pearl-icon">
                                    <svg style='margin-top:-4px;' xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-help-circle"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                </div>
                                <span class="pearl-title">Menunggu konfirmasi pembayaran</span>
                            </div>
                            <div class="pearl @if($state === 2) current @elseif($state > 2) done @endif col-3" id='pearl-bayar'>
                                <div class="pearl-icon">
                                    <svg style='margin-top:-4px;' xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>
                                </div>
                                <span class="pearl-title">Pesanan sedang diproses</span>
                            </div>
                            <div class="pearl @if($state === 3) current @elseif($state > 3) done @endif col-3" id='pearl-bayar'>
                                <div class="pearl-icon">
                                    <svg style='margin-top:-4px;' xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                </div>
                                <span class="pearl-title">Dalam Pengiriman</span>
                            </div>
                            <div class="pearl @if($state === 4) current @elseif($state > 4) done @endif col-3" id='pearl-konfirmasi'>
                                <div class="pearl-icon">
                                    <svg style='margin-top:-4px;' xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                </div>
                                <span class="pearl-title">Sudah sampai</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card animated animatedFadeInUp fadeInUp" style='width:100%;'>
            <div class="card-body">
                <div class='invoice'>
                    <div class="content-section" style='height:unset;'>

                        <div class="row inv--detail-section">

                            <div class="col-sm-7 align-self-center">
                                <p class="inv-to">Penerima</p>
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
                                <p class="inv-list-number"><span class="inv-title">No. Invoice : </span> <span
                                        class="inv-number">#{{ $order_data->urut_order }}</span></p>
                                <p class="inv-created-date"><span class="inv-title">Tanggal Invoice : </span> <span
                                        class="inv-date">{{ date('d F Y', strtotime($order_data->tgl_dibuat)).date(' (H:i:s)', strtotime($order_data->tgl_dibuat)) }}</span></p>
                                <p class="inv-due-date"><span class="inv-title">Tanggal Expired : </span> <span class="inv-date">{{ date('d F Y', strtotime($order_data->tgl_expired)).date(' (H:i:s)', strtotime($order_data->tgl_expired)) }}</span></p>
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
                                            <h6 class=" inv-title">Info Pembayaran:</h6>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <p class=" inv-subtitle">Nama bank: </p>
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
                                                    $bankAdmin = \DB::table('t_bank')
                                                        ->where('data_of', \App\Http\Controllers\PusatController::dataOfByDomainToko($toko->domain_toko))
                                                        ->where('id_bank', explode('|', $pembayaran->via)[0])
                                                        ->get()->first();
                                                    echo $bankAdmin->no_rek;
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
                                            <p class="">Sub Total : </p>
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
                                            <p class="">Expedisi (
                                                @php
                                                    $kurir = explode('|', json_decode($order_data->kurir)->data);
                                                    echo strtoupper($kurir[0]).' '.$kurir[1];
                                                @endphp
                                            ) : </p>
                                        </div>
                                        <div class="col-sm-4 col-5">
                                            <p class="">
                                                @php
                                                    echo 'Rp '.\App\Http\Controllers\PusatController::formatUang($total->hargaOngkir);
                                                @endphp
                                            </p>
                                        </div>
                                        @if($total->kode_unik)
                                            <div class="col-sm-8 col-7">
                                                <p class="">Kode Transfer : </p>
                                            </div>
                                            <div class="col-sm-4 col-5">
                                                <p class="">{{ 'Rp '.\App\Http\Controllers\PusatController::formatUang($total->kode_unik) }}</p>
                                            </div>
                                        @endif
                                        <!-- <div class="col-sm-8 col-7">
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
                                                    $hasil = ($total->hargaProduk + $total->hargaOngkir);
                                                    if(isset($total->kode_unik)){
                                                        $hasil += $total->kode_unik;
                                                    }
                                                    echo 'Rp '.\App\Http\Controllers\PusatController::formatUang($hasil);
                                                    unset($hasil);
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
    </div>
</div>
<script>
    $(document).ready(function(){

    });
</script>
<!--uiop-->
@endsection