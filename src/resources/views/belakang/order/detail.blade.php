@extends('belakang.index')
@section('isi')
<!--uiop-->
@php
//echo "<pre>".print_r($data, true)."</pre>";
@endphp
<div class="page-header page-header-bordered">
    <div class='row'>
        <div class='col-md-6'>
            <h1 class="page-title font-size-26 font-weight-100">Order</h1>
        </div>
        <div class='col-md-6'>
            <div class="page-header-actions">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"
                            onClick="pageLoad('{{ route('b.dashboard') }}')">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);"
                            onClick="pageLoad('{{ route('b.order-index') }}')">Order</a></li>
                    <li class="breadcrumb-item active">Detail Order (Order #{{ $data->order->urut_order }})</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="page-content">
    <div class='container'>
        <div class="panel animation-slide-top" style='animation-delay:100ms;'>
            <div class="panel-body">
                <div class='row' style='border-bottom:1px solid #bbbdbb;padding-bottom:10px'>
                    <div class='col-md-6'>
                        <b style='font-size:20px'>Order #{{ $data->order->urut_order }}</b>
                    </div>
                    <div class='col-md-6 text-right pr-25 pt-10'>
                        asdasd
                    </div>
                </div>
                <div class='row mt-15' style='border-bottom:1px solid #bbbdbb;padding-bottom:25px'>
                    <div class='col-md-7'>
                        <span style='font-weight:bold;color:black'>Dikirim Kepada:</span><br>
                        <div style='position: relative;padding: 15px;background-color: #f3f7fa;border: 1px solid #eee;width:60%;overflow-wrap: break-word;'
                            class='ml-5 mt-10'>
                            <div style='font-size:20px'>{{ strtoupper($data->tujuan->name) }}</div>
                            {{ $data->tujuan->alamat }}<br>
                            {{ $data->tujuan->kecamatan }}, {{ $data->tujuan->kabupaten }}<br>
                            {{ strtoupper($data->tujuan->provinsi) }}&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;{{ $data->tujuan->kode_pos }}<br><br>
                            Telp: &nbsp;&nbsp;{{ $data->tujuan->no_telp }}<br>
                            Email: &nbsp;&nbsp;{{ $data->tujuan->email }}
                        </div>
                    </div>
                    <div class='col-md-5 text-right'>
                        <span style='font-weight:bold;color:black'>Pembayaran</span><br>
                        @php
                        $tipe_bayar = json_decode($data->order->pembayaran)->status;
                        if($tipe_bayar == "lunas"){
                            echo "<span style='color:green;font-size:26px'>".strtoupper($tipe_bayar)."</span><br>";
                            echo $data->bayar[count($data->bayar)-1]->tgl_bayar."<br>";
                            $t_via = $data->bayar[count($data->bayar)-1]->via;
                            if($t_via == "CASH"){
                                echo $data->bayar[count($data->bayar)-1]->via;
                            } else {
                                echo explode('|', $data->bayar[count($data->bayar)-1]->via)[1];
                            }
                        } else if($tipe_bayar == "cicil"){
                            echo "<span style='color:#ffd70d;font-size:26px'>".strtoupper($tipe_bayar)."</span>";
                        } else if($tipe_bayar == "belum"){
                            echo "<span style='color:red;font-size:26px'>".strtoupper($tipe_bayar." bayar")."</span>";
                        }
                        @endphp
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-12'>
                        <div class='table-responsive'>
                            <table class='table'>
                                <thead>
                                    <tr>
                                        <td style='font-weight:bold;color:black'>Barang</td>
                                        <td class='text-right' style='font-weight:bold;color:black'>Harga</td>
                                    </tr>
                                </thead>
                                {!! $data->hargaList !!}
                            </table>
                        </div>
                    </div>
                </div>
                <div class='row' style='border-top:1px solid #bbbdbb;padding-top:15px'>
                    <div class='col-md-12'>
                        {!! $riwayatTampil !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="panel animation-slide-bottom" style='animation-delay:100ms;'>
            <div class="panel-body">
                <div class="d-flex justify-content-around">
                    <div class="p-2 text-center">
                        <span style='font-weight:bold;color:black;font-size:25px'>{{ $totalBeli }}</span><br>
                        <span style='font-size:15px'>Total @if($cekTipeProduk == 'sendiri') Harga Beli @elseif($cekTipeProduk == 'lain') Harga Bayar ke Supplier @endif</span>
                    </div>
                    <div class="p-2 text-center">
                        <span style='font-weight:bold;color:black;font-size:25px'>{{ $totalJual }}</span><br>
                        <span style='font-size:15px'>Total Harga Jual</span>
                    </div>
                    <div class="p-2 text-center">
                        <span style='font-weight:bold;color:black;font-size:25px'>{{ $totalUntung }}</span><br>
                        <span style='font-size:15px'>Total Keuntungan</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--uiop-->
@endsection