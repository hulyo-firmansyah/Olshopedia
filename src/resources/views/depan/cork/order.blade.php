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
<style>
.total-bayar {
    font-size:32px;
    border: 1px solid #14c935;
    color:#14c935;
    padding:10px;
    border-radius:10px;
}
.pilih-bank {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: horizontal;
  -webkit-box-direction: normal;
  -ms-flex-direction: row;
  flex-direction: row;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;
  -webkit-box-flex: 1;
  -ms-flex: 1 0 auto;
  flex: 1 0 auto;
  margin-bottom: 1.5rem !important;
}
.pilih-bank .pilih-bank-item.selected:not(.disabled),
.pilih-bank .pilih-bank-item.selected {
  background-color: #ebf4ff;
  box-shadow: 0 0 0 2px #007bff;
  -webkit-box-shadow: 0 0 0 2px #007bff;
}
.pilih-bank .pilih-bank-item:hover {
  background-color: #f0f0f0;
}
.pilih-bank .pilih-bank-item {
  -webkit-box-sizing: border-box;
  -webkit-box-shadow: 0 0 0 2px #eee;
  box-shadow: 0 0 0 2px #eee;
  box-sizing: border-box;
  width: 100% !important;
  margin: 0 12px 12px 0;
  padding: 14px 18px;
  border-radius: 5px;
  margin-right: 0 !important;
  margin-bottom: .5rem !important;
  cursor: pointer;
  display: inline-block;
  position: relative;
  background-color: #fff;
}
.pilih-bank .pilih-bank-item img {
  height: auto;
  max-width: 60px;
  min-width: 40px;
}
.pilih-bank .pilih-bank-item input {
  top: 0;
  left: 0;
  visibility: hidden;
  position: absolute;
}
.pilih-bank-item .text-dark {
  font-size: .975rem;
  margin: .5rem 0 0 .5rem !important;
}
</style>
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
                <div class='invoice'>
                    <div class="content-section" style='height:unset;'>

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
                                                    $total = json_decode($order_data->total);
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
        <div class='mt-5 animated animatedFadeInUp fadeInUp' style='background:white;border-radius:5px;border: 1px solid rgba(0,0,0,.125);width:100%'>
            <div class="text-center" style='font-size:16px;padding:20px;'>
                <p style='margin-bottom:40px;'>Agar pesanan Anda dapat segera diproses, segera lakukan pembayaran sejumlah:</p>
                <span class="total-bayar">Rp {{ \App\Http\Controllers\PusatController::formatUang($total->hargaProduk + $total->hargaOngkir + $total->kode_unik) }}</span>
                <p class="text-danger mb-2" style='margin-top:40px;'>Note: +Rp {{ $total->kode_unik }} untuk kode unik</p>
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
                        Transfer Bank {{ $bankAdmin->bank }} <p class="h4 lead mb-2"><strong>{{ $bankAdmin->no_rek }}</strong></p>
                        Cabang  {{ $bankAdmin->cabang }},  An. {{ $bankAdmin->atas_nama }} 
                    </div>
                </div>
                <div style='border-bottom: 1px solid rgba(0,0,0,.125);margin-bottom:30px;margin-top:30px;'></div>
                <p>Setelah melakukan transfer silakan konfirmasi dengan klik tombol dibawah ini:</p>
                <a href="{{ route('d.konfirmasi-bayar', ['domain_toko' => $toko->domain_toko, 'order_slug' => $order_slug]) }}" class="btn btn-lg btn-primary my-2 mb-4">konfirmasi pembayaran</a>
                <p>Jika anda ingin merubah metode pembayaran silahkan klik: 
                    <span id='bagianAdaTimer'>
                        @if($timer === 0)
                            <a data-toggle="modal" data-target="#pilihMetodebayar" href="" class='text-warning'>Ganti metode pembayaran></span></a>
                        @else
                            <span class='text-danger'>Tunggu countdown selesai, untuk bisa ganti metode pembayaran lagi <span class='timerDiv'></span></span>
                        @endif
                    </span>
                </p>
                <div style='border-bottom: 1px solid rgba(0,0,0,.125);margin-bottom:30px;margin-top:30px;'></div>
                <p class="small">
                    <span class="tc-text-color">Jika Anda tidak menerima email invoice ini, Anda dapat</span>
                    <span id='bagianAdaTimer2'>
                        @if($timer === 0)
                            <a class="text-warning" href="javascript:void(0)" id='sendInvoice'>mengirim ulang invoice</a>
                        @else
                            <span class='text-danger'>Tunggu countdown selesai, untuk bisa mengirim invoice lagi <span class='timerDiv'></span></span>
                        @endif
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="pilihMetodebayar" tabindex="-1" role="dialog" aria-labelledby="pilihMetodeBayarLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pilihMetodeBayarLabel">Pilih Metode Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <div class='row'>
                    <div class='col-sm-12'>
                        <b style='color:black;'>Transfer Bank</b> (verifikasi manual)
                        <div class="pilih-bank form-group" style='margin-top:10px'>
                            @foreach(\App\Http\Controllers\PusatController::genArray($bank) as $b_ => $b)
                                <label for="bank-{{ strtolower($b->bank) }}" class="pilih-bank-item @if($b->id_bank.'|'.$b->bank === $bankAdmin->id_bank.'|'.$bankAdmin->bank) selected @endif" title="Transfer Bank bca">
                                    <input type="radio" class="item-bank d-none" name="bank" value='{{ $b->id_bank }}|{{ $b->bank }}' id='bank-{{ strtolower($b->bank) }}' @if($b->id_bank.'|'.$b->bank === $bankAdmin->id_bank.'|'.$bankAdmin->bank) checked @endif>
                                    <span class="text-dark tc-text-color">
                                        Transfer Bank {{ $b->bank }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id='btnPilihMetode'>Simpan</button>
            </div>
        </div>
    </div>
</div>
<script>
    var timer_interval = null,
        time_ = {!! $timer !!};

        
    function showTimer() {
        if (time_ < 1) {
            $('.timerDiv').hide();
            $('#bagianAdaTimer').html('<a data-toggle="modal" data-target="#pilihMetodebayar" href="" class="text-warning">Ganti metode pembayaran</span></a>');
            $('#bagianAdaTimer2').html('<a class="text-warning" href="javascript:void(0)" id="sendInvoice">mengirim ulang invoice</a>');
            clearInterval(timer_interval);
            return;
        }
        function pad(value) {
                return (value < 10 ? '0' : '') + value;
        }
        $('.timerDiv').text('('+Math.floor(time_ / 60) + ':' + pad(time_ % 60)+')');
        time_--;
    }

    $(document).ready(function(){
        
        showTimer();
        timer = setInterval(showTimer, 1000);

        $('#bagianAdaTimer2').on('click', '#sendInvoice', function(e){
            e.preventDefault();

            const toast = swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 0,
                padding: '2em'
            });
            $.ajax({
                url: "{{ route('d.proses', ['domain_toko' => $toko->domain_toko]) }}",
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    order_id: '{{ $order_slug }}',
                    v: {{ $tujuan_kirim->user_id }},
                    tipe: 'send_invoice',
                },
                beforeSend: function(){
                    toast({
                        type: '',
                        title: 'Loading...',
                        padding: '2em',
                    });
                },
                success: function(data) {
                    toast.close();
                    if(data.status){
                        const toast2 = swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            padding: '2em'
                        });
                        toast2({
                            type: 'success',
                            title: ''+data.pesan,
                            padding: '2em',
                        }).then(function(){
                            $(location).attr('href', '{{ route("d.order", ["domain_toko" => $toko->domain_toko]) }}/{{ $order_slug }}');
                        });
                    } else {
                        const toast2 = swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            padding: '2em'
                        });
                        toast2({
                            type: 'error',
                            title: ''+data.pesan,
                            padding: '2em',
                        });
                    }
                },
                error: function(a, b, c){
                    toast.close();
                    const toast2 = swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        padding: '2em'
                    });
                    toast2({
                        type: 'error',
                        title: ''+c,
                        padding: '2em',
                    });
                }
            });
        })

        
        $('.pilih-bank-item').on('click', function(){
            let list_bank = Array.prototype.slice.call($('.pilih-bank .pilih-bank-item'));
            var _this = $(this);
            list_bank.forEach(function(html) {
                if($(html).hasClass('selected')){
                    $(html).removeClass('selected');
                }
            });
            _this.addClass('selected');
            data_needs_saving = true;
        });

        $('#btnPilihMetode').on('click', function(){
            let bank = $('.pilih-bank').children('label.selected').children('input[type=radio]').val();
            const toast = swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 0,
                padding: '2em'
            });
            $('#pilihMetodebayar').modal('hide');
            $.ajax({
                url: "{{ route('d.proses', ['domain_toko' => $toko->domain_toko]) }}",
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    bank: bank,
                    order_id: '{{ $order_slug }}',
                    v: {{ $tujuan_kirim->user_id }},
                    tipe: 'ganti_metode_bayar',
                },
                beforeSend: function(){
                    toast({
                        type: '',
                        title: 'Loading...',
                        padding: '2em',
                    });
                },
                success: function(data) {
                    toast.close();
                    if(data.status){
                        const toast2 = swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            padding: '2em'
                        });
                        toast2({
                            type: 'success',
                            title: ''+data.pesan,
                            padding: '2em',
                        }).then(function(){
                            $(location).attr('href', '{{ route("d.order", ["domain_toko" => $toko->domain_toko]) }}/{{ $order_slug }}');
                        });
                    } else {
                        const toast2 = swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            padding: '2em'
                        });
                        toast2({
                            type: 'error',
                            title: ''+data.pesan,
                            padding: '2em',
                        });
                    }
                },
                error: function(a, b, c){
                    toast.close();
                    const toast2 = swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        padding: '2em'
                    });
                    toast2({
                        type: 'error',
                        title: ''+c,
                        padding: '2em',
                    });
                }
            });
        });

    });
</script>
<!--uiop-->
@endsection