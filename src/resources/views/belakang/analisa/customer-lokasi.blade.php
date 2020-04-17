@extends('belakang.index')
@section('isi')
<!--uiop-->
<style>
.selectBug{
    animation-fill-mode: backwards;
    -webkit-animation-fill-mode: backwards;
}
</style>
<div class="page-header page-header-bordered">
    <h1 class="page-title font-size-26 font-weight-100">Best Produk</h1>
    <div class="page-header-actions">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);"
                    onClick="pageLoad('{{ route('b.dashboard') }}')">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0);"
                    onClick="pageLoad('{{ route('b.analisa-index') }}')">Analisa</a></li>
            <li class="breadcrumb-item active">Best Produk</li>
        </ol>
    </div>
</div>
<div class="page-content">
    <div class='container'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='float-right animation-slide-top selectBug' style='animation-delay:300ms'>
                    <div class='panel p-15'>
                        <div class='d-flex'>
                            <div class="input-group">
                                <input type="text" class="form-control" style='border-color:#0bb2d4' value='{{ $tanggal["dari"] }}' id='datepickerDari' placeholder='Dari Tanggal' name='f_tglDari' autocomplete='off'>
                                <div class="input-group-addon bg-cyan-600 white">-</div>
                                <input type="text" class="form-control" style='border-color:#0bb2d4' value='{{ $tanggal["sampai"] }}' id="datepickerSampai" placeholder='Sampai Tanggal' name='f_tglSampai' autocomplete='off'>
                            </div>
                            <button type="button" class="btn btn-icon btn-info ml-10" id='btnFilter'><i class="icon fa-filter" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-12'>
                <div class='panel panel-info panel-line animation-slide-bottom' style='animation-delay:200ms'>
                    <div class='panel-heading'>
                        <h3 class='panel-title'>Lokasi Customer @if($tanggal["dari"] != "" && $tanggal["sampai"] != "") (Filtered) @endif</h3>
                    </div>
                    <div class='panel-body' id='listDiv'>
                        <div style='font-size:15px;font-weight:bold;color:black;' class='text-center'>Kosong</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var customer_lok = {!! json_encode($data) !!};

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
    $(document).ready(function(){
        
        $("#btnFilter").on("click", function(){
            // $(location).attr('href', "{{ route('b.analisa-index') }}?dari="+$.trim($("#datepickerDari").val())+"&sampai="+$.trim($("#datepickerSampai").val()));
            pageLoad('{{ route("b.analisa-customerLokasi") }}'+"?dari="+$.trim($("#datepickerDari").val())+"&sampai="+$.trim($("#datepickerSampai").val()));
        });

        @if(count($data) > 0)
            $('#listDiv').html('');
            let temp_ = customer_lok;
            var page = 1, 
                recPerPage = 10,
                startRec = Math.max(page - 1, 0) * recPerPage, 
                recordsToShow = temp_.slice(startRec, startRec+recPerPage),
                jumlah_hal = Math.ceil((customer_lok.length / recPerPage));
            $.each(recordsToShow, (i, v) => {
                $('#listDiv').append(
                    "<div style='border-bottom: 1px solid #efefef' class='mt-10 pb-20 pt-10'>"+
                        "<div class='row'>"+
                            "<div class='col-md-3'>"+
                                "<div class='p-2 text-center'>"+
                                    "<span style='font-weight:bold;color:black;font-size:30px'>"+v.persen.toString().replace(".", ",")+"%</span>"+
                                "</div>"+
                            "</div>"+
                            "<div class='col-md-6'>"+
                                "<span style='font-size:15px'><b>"+v.data.kabupaten+", "+v.data.provinsi+"</b></span><br>"+
                                "<span class='badge badge-outline badge-success badge-lg' style='display:inline-block'>"+v.jumlah+" Order</span>"+
                            "</div>"+
                                "<div class='col-md-3'>"+
                                    "<div class='p-2 text-center'>"+
                                        "<span style='font-weight:bold;color:black;font-size:25px'>Rp "+uangFormat(v.data.net_sales)+"</span><br>"+
                                        "<span style='font-size:12px'>Net Sales</span>"+
                                    "</div>"+
                                "</div>"+
                        "</div>"+
                    "</div>"
                );
            });
            if(jumlah_hal > 1){
                $('#listDiv').append(
                    "<div class='mt-20'>"+
                        "<div class='row'>"+
                            "<div class='col-md-6'>"+
                                "<ul class='pagination'>"+
                                    "<li class='page-item disabled'><span class='page-link'><i class='icon wb-chevron-left-mini'></i></span></li>"+
                                    "<li class='page-item'><button class='page-link' id='btnNext' type='button'><i class='icon wb-chevron-right-mini'></i></button></li>"+
                                "</ul>"+
                            "</div>"+
                            "<div class='col-md-6'>"+
                                "<div class='float-right'>"+
                                    +page+" dari "+jumlah_hal+" Halaman ("+customer_lok.length+" Data)"+
                                "</div>"+
                            "</div>"+
                        "</div>"+
                    "</div>"
                );
            }

            $("#listDiv").on('click', '#btnNext', function(){
                let temp_next = customer_lok;
                $('#listDiv').html('');
                var pageNext = page+1, 
                    startRecNext = Math.max(pageNext - 1, 0) * recPerPage, 
                    recordsToShowNext = temp_next.slice(startRecNext, startRecNext + recPerPage);
                $.each(recordsToShowNext, (i, v) => {
                    $('#listDiv').append(
                        "<div style='border-bottom: 1px solid #efefef' class='mt-10 pb-20 pt-10'>"+
                            "<div class='row'>"+
                                "<div class='col-md-3'>"+
                                    "<div class='p-2 text-center'>"+
                                        "<span style='font-weight:bold;color:black;font-size:30px'>"+v.persen.toString().replace(".", ",")+"%</span>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-md-6'>"+
                                    "<span style='font-size:15px'><b>"+v.data.kabupaten+", "+v.data.provinsi+"</b></span><br>"+
                                    "<span class='badge badge-outline badge-success badge-lg' style='display:inline-block'>"+v.jumlah+" Order</span>"+
                                "</div>"+
                                "<div class='col-md-3'>"+
                                    "<div class='p-2 text-center'>"+
                                        "<span style='font-weight:bold;color:black;font-size:25px'>Rp "+uangFormat(v.data.net_sales)+"</span><br>"+
                                        "<span style='font-size:12px'>Net Sales</span>"+
                                    "</div>"+
                                "</div>"+
                            "</div>"+
                        "</div>"
                    );
                });
                if(jumlah_hal > 1){
                    if(jumlah_hal == pageNext){
                        var btnNext = "<li class='page-item disabled'><span class='page-link'><i class='icon wb-chevron-right-mini'></i></span></li>";
                    } else {
                        var btnNext = "<li class='page-item'><button class='page-link' id='btnNext' type='button'><i class='icon wb-chevron-right-mini'></i></button></li>";
                    }
                    if(pageNext == 1){
                        var btnPrev = "<li class='page-item disabled'><span class='page-link'><i class='icon wb-chevron-left-mini'></i></span></li>";
                    } else {
                        var btnPrev = "<li class='page-item'><button class='page-link' id='btnPrev' type='button'><i class='icon wb-chevron-left-mini'></i></button></li>";
                    }
                    $('#listDiv').append(
                        "<div class='mt-20'>"+
                            "<div class='row'>"+
                                "<div class='col-md-6'>"+
                                    "<ul class='pagination'>"+
                                        btnPrev+btnNext+
                                    "</ul>"+
                                "</div>"+
                                "<div class='col-md-6'>"+
                                    "<div class='float-right'>"+
                                        +pageNext+" dari "+jumlah_hal+" Halaman ("+customer_lok.length+" Data)"+
                                    "</div>"+
                                "</div>"+
                            "</div>"+
                        "</div>"
                    );
                }
                page = pageNext;
            });

            $("#listDiv").on('click', '#btnPrev', function(){
                let temp_prev = customer_lok;
                $('#listDiv').html('');
                var pagePrev = page-1, 
                    startRecPrev = Math.max(pagePrev - 1, 0) * recPerPage, 
                    recordsToShowPrev = temp_prev.slice(startRecPrev, startRecPrev + recPerPage);
                $.each(recordsToShowPrev, (i, v) => {
                    $('#listDiv').append(
                        "<div style='border-bottom: 1px solid #efefef' class='mt-10 pb-20 pt-10'>"+
                            "<div class='row'>"+
                                "<div class='col-md-3'>"+
                                    "<div class='p-2 text-center'>"+
                                        "<span style='font-weight:bold;color:black;font-size:30px'>"+v.persen.toString().replace(".", ",")+"%</span>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-md-6'>"+
                                    "<span style='font-size:15px'><b>"+v.data.kabupaten+", "+v.data.provinsi+"</b></span><br>"+
                                    "<span class='badge badge-outline badge-success badge-lg' style='display:inline-block'>"+v.jumlah+" Order</span>"+
                                "</div>"+
                                "<div class='col-md-3'>"+
                                    "<div class='p-2 text-center'>"+
                                        "<span style='font-weight:bold;color:black;font-size:25px'>Rp "+uangFormat(v.data.net_sales)+"</span><br>"+
                                        "<span style='font-size:12px'>Net Sales</span>"+
                                    "</div>"+
                                "</div>"+
                            "</div>"+
                        "</div>"
                    );
                });
                if(jumlah_hal > 1){
                    if(jumlah_hal == pagePrev){
                        var btnNext = "<li class='page-item disabled'><span class='page-link'><i class='icon wb-chevron-right-mini'></i></span></li>";
                    } else {
                        var btnNext = "<li class='page-item'><button class='page-link' id='btnNext' type='button'><i class='icon wb-chevron-right-mini'></i></button></li>";
                    }
                    if(pagePrev == 1){
                        var btnPrev = "<li class='page-item disabled'><span class='page-link'><i class='icon wb-chevron-left-mini'></i></span></li>";
                    } else {
                        var btnPrev = "<li class='page-item'><button class='page-link' id='btnPrev' type='button'><i class='icon wb-chevron-left-mini'></i></button></li>";
                    }
                    $('#listDiv').append(
                        "<div class='mt-20'>"+
                            "<div class='row'>"+
                                "<div class='col-md-6'>"+
                                    "<ul class='pagination'>"+
                                        btnPrev+btnNext+
                                    "</ul>"+
                                "</div>"+
                                "<div class='col-md-6'>"+
                                    "<div class='float-right'>"+
                                        +pagePrev+" dari "+jumlah_hal+" Halaman ("+customer_lok.length+" Data)"+
                                    "</div>"+
                                "</div>"+
                            "</div>"+
                        "</div>"
                    );
                }
                page = pagePrev;
            });
        @endif

        $("#datepickerDari").datepicker({
            format: "dd MM yyyy",
            orientation: 'bottom'
        }).on('changeDate', function(ev) {
            var dateOrder = new Date(ev.date.valueOf());
            $('#datepickerSampai').datepicker('setStartDate', dateOrder);
        });
            
        $("#datepickerSampai").datepicker({
            format: "dd MM yyyy",
            orientation: 'bottom'
        }).on('changeDate', function(ev) {
            var dateOrder2 = new Date(ev.date.valueOf());
            $('#datepickerDari').datepicker('setEndDate', dateOrder2);
        });
        
        @if($tanggal["dari"] != "")
            $("#datepickerSampai").datepicker("setStartDate", "{{ strip_tags($tanggal['dari']) }}");
        @endif
        
        @if($tanggal["sampai"] != "")
            $("#datepickerDari").datepicker("setEndDate", "{{ strip_tags($tanggal['sampai']) }}");
        @endif
    });

</script>
<!--uiop-->
@endsection