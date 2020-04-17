@extends('belakang.index')
@section('isi')
<!--uiop-->
@php
    //echo "<pre>".print_r($data, true)."</pre>";
@endphp
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="page-header page-header-bordered">
    <div class='row'>
        <div class='col-md-6'>
            <h1 class="page-title font-size-26 font-weight-100">Track Resi</h1>
        </div>
        <div class='col-md-6'>
            <div class="page-header-actions">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"
                            onClick="pageLoad('{{ route('b.dashboard') }}')">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);"
                            onClick="pageLoad('{{ route('b.order-index') }}')">Order</a></li>
                    <li class="breadcrumb-item active">Track Resi</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="page-content">
    @if ($msg_sukses = Session::get('msg_success'))
    <div class='alert alert-success' id='alert-sukses' role='alert'><i class='fa fa-check'></i> SUCCESS: {{$msg_sukses}}
    </div>
    @endif
    <div class='container'>
        <div class='row'>
            <div class='col-md-8'>
                <div class="panel panel-bordered panel-primary animation-slide-top" style='animation-delay:100ms;'>
                    <div class="panel-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <label style='font-size:18px'><b>Kurir</b></label>
                                <div>{{$data->summary->courier_name}}</div>
                            </div>
                            <div>
                                <label style='font-size:18px'><b>Resi</b></label>
                                <div>{{$data->summary->waybill_number}}</div>
                            </div>
                            <div>
                                <label style='font-size:18px'><b>Status</b></label>
                                <div>{{$data->delivery_status->status}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="timeline timeline-simple">
                    @foreach($data->manifest as $iM => $vM)
                        <li class="timeline-item @if(($iM+1)%2 == 0)timeline-reverse @endif animation-slide-bottom" style='animation-delay:{{ $iM+5 }}00ms;'>
                            <div class="timeline-dot @if(($iM+1)%2 == 0)bg-green-500 @endif"></div>
                            <div class="timeline-info">
                                <time datetime="2017-05-15">{{ date("d M Y", strtotime($vM->manifest_date)) }} &nbsp; ({{ $vM->manifest_time }})</time>
                            </div>
                            <div class="timeline-content">
                                <div class="card card-shadow">
                                    <div class="card-block p-30">
                                        <p class="card-text">
                                            {{ $vM->manifest_description }}
                                            @php
                                                if($vM->city_name != ""){
                                                    echo "[".$vM->city_name."]";
                                                }
                                            @endphp
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class='col-md-4'>
                <div class="panel panel-bordered panel-primary animation-slide-right" style='animation-delay:100ms;'>
                    <div class="panel-body">
                        <div>
                            <span><b>Pengirim:</b></span><br>
                            <div style='position: relative;padding: 15px;background-color: #f3f7fa;border: 1px solid #eee;overflow-wrap: break-word;'
                                class='m-5'>
                                <div style='font-size:20px'>{{$data->details->shippper_name}}</div>
                                {{$data->details->shipper_address1}}
                                @php
                                    if($data->details->shipper_address2 != ""){
                                        echo "<br>".$data->details->shipper_address2;
                                    }
                                    if($data->details->shipper_address3 != ""){
                                        echo "<br>".$data->details->shipper_address3;
                                    }
                                @endphp
                            </div>
                        </div>
                        <div class='mt-20'>
                            <span><b>Dikirim Kepada:</b></span><br>
                            <div style='position: relative;padding: 15px;background-color: #f3f7fa;border: 1px solid #eee;overflow-wrap: break-word;'
                                class='m-5'>
                                <div style='font-size:20px'>{{$data->details->receiver_name}}</div>
                                {{$data->details->receiver_address1}}
                                @php
                                    if($data->details->receiver_address2 != ""){
                                        echo "<br>".$data->details->receiver_address2;
                                    }
                                    if($data->details->receiver_address3 != ""){
                                        echo "<br>".$data->details->receiver_address3;
                                    }
                                @endphp
                                <br>{{$data->details->receiver_city}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function uangFormat(number) {
    var sp = number.toString().split("").reverse();
    var yt = 0;
    var te = "";
    $.each(sp, function(i, v) {
        if (yt === 3) {
            te += ".";
            yt = 0;
        }
        te += v;
        yt++;
    });
    var hasil = te.split("").reverse().join("");
    return hasil;
}

function uangToAngka(data, tipe = false) {
    if (tipe) {
        var angkaTemp = data.split("").reverse();
    } else {
        var angkaTemp = data.split(" ")[1].split("").reverse();
    }
    var hasil = "";
    $.each(angkaTemp, function(i, v) {
        if (v === ".") return true;
        hasil += v;
    });
    return parseInt(hasil.split("").reverse().join(""));
}

$(document).ready(function() {


    @if($msg_sukses = Session::get('msg_success'))
    window.setTimeout(function() {
        $('#alert-sukses').animate({
            height: 'toggle'
        }, 'slow');
    }, 5000);
    @endif
});
</script>
<!--uiop-->
@endsection