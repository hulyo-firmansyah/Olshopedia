@extends('belakang.index')
@section('isi')
<!--uiop-->
@php
//echo "<pre>".print_r($data_order, true)."</pre>";
@endphp
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
.selectBug{
    animation-fill-mode: backwards;
    -webkit-animation-fill-mode: backwards;
}

#btnCari:hover {
    cursor: pointer;
}

.filter-box {
    position: relative;
    padding: 0px 15px 15px 20px;
    background-color: #eceff2;
    border: 1px solid #DDD;
    /* border-bottom: 1px solid #E4EAEC;
    border-top: 1px solid #E4EAEC; */
    border-radius: 10px;
    /* box-shadow: 0px 10px 10px -6px rgba(0,0,0,0.58); */
}

.btnResi:hover{
    -webkit-box-shadow: 4px 5px 11px -3px rgba(0,0,0,0.75);
    -moz-box-shadow: 4px 5px 11px -3px rgba(0,0,0,0.75);
    box-shadow: 4px 5px 11px -3px rgba(0,0,0,0.75);
    cursor:pointer;
}

.row-list-order {
    position: relative;
    width: 100%;
    background-color: #fff;
    border: 2px solid rgba(0, 0, 0, 0.15);
    margin-bottom: 20px;
    padding: 15px;
    display: table;
    border-radius: 1rem !important;
    box-shadow: 5px 10px 8px #888888;
}

.row-list-order-updated {
    background-color: #ffe282;
}

.row-list-order-head {
    border-bottom: 1px dashed rgba(0, 0, 0, 0.15);
    /* padding: 1.25rem .5rem 1rem; */
}

.row-list-order-body {
    padding: 1.5rem .5rem 1.25rem;
}

.row-list-order-footer {
    border-top: 1px dashed rgba(0, 0, 0, 0.15);
    padding-left: 15px;
    padding-top: 20px;
}

.total-bayar-info {
    width: 80%;
    padding: 15px;
    font-size: 20px;
    border-radius: 10px;
}

.bayar-lunas {
    background: #C2FADC;
    border: 1px solid #72E8AB;
}

.bayar-cicil {
    background: #FFF6B5;
    border: 1px solid #FFED78;
}

.bayar-belum {
    background: #FFDBDC;
    border: 1px solid #FFBFC1;
}
</style>
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
                    <li class="breadcrumb-item active">Semua Order</li>
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
    <ul class="row justify-content-center" style='list-style-type: none;'>
        <li class="p-5 animation-slide-top" style='animation-delay:100ms'>
            <a class="btn btn-round p-15 btn-primary" href="javascript:void(0)">
                <i class="icon wb-search" aria-hidden="true"></i>
                Cancel Order
            </a>
        </li>
        <li class="p-5 animation-slide-top" style='animation-delay:200ms'>
            <a class="btn btn-round p-15" style='background-color:white;color:#37474F' href="javascript:void(0)">
                <i class="icon wb-search" aria-hidden="true"></i>
                Rejected Order
            </a>
        </li>
        <li class="p-5 animation-slide-top" style='animation-delay:300ms'>
            <a class="btn btn-round p-15" style='background-color:white;color:#37474F' href="javascript:void(0)">
                <i class="icon wb-search" aria-hidden="true"></i>
                Expired Order
            </a>
        </li>
    </ul>
    <div class="container">
        <div class='row'>
            <div class='col-md-12'>
                @php
                foreach($order as $o){
                echo $o;
                }
                @endphp
            </div>
        </div>
        {{ $data_order->links('vendor.pagination.bootstrap-4') }}
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
    
    @foreach($popover as $iP => $vP)
        @if(is_null($vP['pemesan']))
            $('#myPop-{{$iP+1}}').attr('style', 'cursor:default');
        @else
            $('#myPop-{{$iP+1}}').webuiPopover({
                content: "<div><span class='text-muted'>Alamat</span><br>"+
                    "{{ $vP['pemesan']->alamat }}<br>{{ $vP['pemesan']->kecamatan }}, {{ $vP['pemesan']->kabupaten }}<br>"+
                    "{{ strtoupper($vP['pemesan']->provinsi) }}&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;{{ $vP['pemesan']->kode_pos }}<br><br>"+
                    "</div><div><span class='text-muted'>Kontak</span><br>"+
                    "<b>Telp:</b> &nbsp;&nbsp;{{ $vP['pemesan']->no_telp }}<br><b>Email:</b> &nbsp;&nbsp;{{ $vP['pemesan']->email }}"+
                    "</div><br><a href='javascript:void(0)' "+
                    "onClick='$(\"#myPop-{{$iP+1}}\").webuiPopover(\"destroy\");pageLoad(\"{{ route('b.customer-history', ['id_user' => $vP['pemesan']->user_id]) }}\")' "+
                    "class='btn btn-success btn-block btn-round btn-sm'>History Order</a>",
                width: 320,
                animation: "pop",
                placement: "right",
                trigger:"hover"
            });
        @endif

        @if(is_null($vP['tujuan']))
            $('#myPop-{{$iP+1}}-2').attr('style', 'cursor:default');
        @else
            $('#myPop-{{$iP+1}}-2').webuiPopover({
                content: "<div><span class='text-muted'>Alamat</span><br>"+
                    "{{ $vP['tujuan']->alamat }}<br>{{ $vP['tujuan']->kecamatan }}, {{ $vP['tujuan']->kabupaten }}<br>"+
                    "{{ strtoupper($vP['tujuan']->provinsi) }}&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;{{ $vP['tujuan']->kode_pos }}<br><br>"+
                    "</div><div><span class='text-muted'>Kontak</span><br>"+
                    "<b>Telp:</b> &nbsp;&nbsp;{{ $vP['tujuan']->no_telp }}<br><b>Email:</b> &nbsp;&nbsp;{{ $vP['tujuan']->email }}"+
                    "</div><br><a href='javascript:void(0)' "+
                    "onClick='$(\"#myPop-{{$iP+1}}-2\").webuiPopover(\"destroy\");pageLoad(\"{{ route('b.customer-history', ['id_user' => $vP['tujuan']->user_id]) }}\")' "+
                    "class='btn btn-success btn-block btn-round btn-sm'>History Order</a>",
                width: 320,
                animation: "pop",
                placement: "right",
                trigger:"hover"
            });
        @endif
    @endforeach
    
    $(".btnResi").click(function(){
        var url = "{{ route('b.order-trackResi') }}?ff="+$(this).parent().parent().parent().parent().parent().parent().data("id");
        $(location).attr('href', url);
    });

    $('.icek').iCheck({
        checkboxClass: 'icheckbox_flat-blue'
    });

    $("#btnFilter").click(function() {
        $(".filter-box").slideToggle("slow");
    });

    $('.state-order-bayar').tooltip({
        trigger: 'hover',
        title: 'Menunggu pembayaran',
        placement: 'top'
    });
    
    $('.state-order-proses').tooltip({
        trigger: 'hover',
        title: 'Order sedang diproses',
        placement: 'top'
    });
    
    $('.state-order-kirim').tooltip({
        trigger: 'hover',
        title: 'Barang sedang dikirim',
        placement: 'top'
    });
    
    $('.state-order-terima').tooltip({
        trigger: 'hover',
        title: 'Barang sudah diterima Customer',
        placement: 'top'
    });

    $(".btnKembaliOrder").on("click", function(){
        var id_order = $(this).parent().parent().parent().attr("data-id");
        var url = "{{route('b.order-proses')}}";
        var form = $("<form action='"+url+"' method='post'></form>");
        form.append('{{ csrf_field() }}');
        form.append('<input name="tipeKirim" value="kembali_order">');
        form.append('<input name="id_order" value="'+id_order+'">');
        $('body').append(form);
        form.submit();
    });

    $(".btnDetailOrder").on("click", function(e){
        e.preventDefault();
        pageLoad($(this).attr('href'));
    });

    $(".btnHapusOrder").on("click", function(){
        var id_order = $(this).parent().parent().parent().attr("data-id");
        swal({
            title: "Peringatan",
            text: "Apakah anda yakin ingin menghapusnya?",
            icon: "warning",
            buttons: {
                confirm: {
                    text: "Iya",
                    value: true,
                    closeModal: true
                },
                cancel: {
                    text: "Tidak",
                    value: false,
                    visible: true,
                    closeModal: true,
                }
            },
            dangerMode: true
        }).then((willDelete) => {
            if (willDelete) {
                var url = "{{route('b.order-proses')}}";
                var form = $("<form action='"+url+"' method='post'></form>");
                form.append('{{ csrf_field() }}');
                form.append('<input name="tipeKirim" value="hapus_order">');
                form.append('<input name="id_order" value="'+id_order+'">');
                $('body').append(form);
                form.submit();
            }
        });
    });
        

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