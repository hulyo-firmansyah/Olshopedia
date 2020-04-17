@extends('belakang.index')
@section('isi')
<!--uiop-->
<style>
.selectBug{
    animation-fill-mode: backwards;
    -webkit-animation-fill-mode: backwards;
}

@media (max-width: 1599px){
    #buttonDiv {
        padding-top:10px;
        margin-left:5px;
    }
}
@media (max-width: 991px){
    #tglDiv {
        padding-top:10px;
    }
}
@media (max-width:767px){
    #customDiv {
        padding-top:10px;
    }
}
</style>
<div class="page-header page-header-bordered">
    <h1 class="page-title font-size-26 font-weight-100">Best Customer</h1>
    <div class="page-header-actions">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);"
                    onClick="pageLoad('{{ route('b.dashboard') }}')">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0);"
                    onClick="pageLoad('{{ route('b.analisa-index') }}')">Analisa</a></li>
            <li class="breadcrumb-item active">Best Customer</li>
        </ol>
    </div>
</div>
<div class="page-content">
    <div class='container'>
        <div class='row'>
            <div class='col-xl-12'>
                <div class='float-right'>
                    <div class='panel p-15 animation-slide-top selectBug' style='animation-delay:300ms'>
                        <div class='row'>
                            <div class='col-xxl-3 col-xl-3 col-lg-4 col-md-6'>
                                <select id='s_tipeCustomer'>
                                    <option value='0' @if($filter['tipe'] == '0') selected @endif>Semua Kategori Customer</option>
                                    <option value='Customer' @if($filter['tipe'] == 'Customer') selected @endif>Customer</option>
                                    <option value='Reseller' @if($filter['tipe'] == 'Reseller') selected @endif>Reseller</option>
                                    <option value='Dropshipper' @if($filter['tipe'] == 'Dropshipper') selected @endif>Dropshipper</option>
                                </select>
                            </div>
                            <div class='col-xxl-3 col-xl-3 col-lg-4 col-md-6' id='customDiv'>
                                <select id='s_tipeTampil'>
                                    <option value='jumlah_order' @if($filter['tampil'] == 'jumlah_order') selected @endif>Jumlah Order</option>
                                    <option value='jumlah_produk' @if($filter['tampil'] == 'jumlah_produk') selected @endif>Jumlah Produk Terjual</option>
                                    <option value='gross_sales' @if($filter['tampil'] == 'gross_sales') selected @endif>Gross Sales</option>
                                    @if(($ijin->melihatOmset === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner')
                                    <option value='net_sales' @if($filter['tampil'] == 'net_sales') selected @endif>Net Sales</option>
                                    @endif
                                </select>
                            </div>
                        <!-- </div>
                        <div class='row'> -->
                            <div class='col-xxl-5 col-xl-6 col-lg-4 col-md-9' id='tglDiv'>
                                <div class="input-group">
                                    <input type="text" class="form-control" style='border-color:#3e8ef7' value='{{ $filter["tanggal_dari"] }}' id='datepickerDari' placeholder='Dari Tanggal' name='f_tglDari' autocomplete='off'>
                                    <div class="input-group-addon bg-blue-600 white">-</div>
                                    <input type="text" class="form-control" style='border-color:#3e8ef7' value='{{ $filter["tanggal_sampai"] }}' id="datepickerSampai" placeholder='Sampai Tanggal' name='f_tglSampai' autocomplete='off'>
                                </div>
                            </div>
                            <div class='col-xxl-1 col-xl-12 col-lg-12 col-md-3 pl-0 pr-0' style='margin-right: -53px;' id='buttonDiv'>
                                <button type="button" class="btn btn-icon btn-primary ml-10" id='btnFilter'><i class="icon fa-filter" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-xl-6'>
                <div class='panel panel-primary panel-line animation-slide-left' style='animation-delay:200ms'>
                    <div class='panel-heading'>
                        <h3 class='panel-title'>Chart Best Customer @if($filter["tanggal_sampai"] != "" || $filter["tanggal_dari"] != "" || $filter["tipe"] != "" || $filter["tampil"] != "" ) (Filtered) @endif</h3>
                    </div>
                    <div class='panel-body'>
                        <canvas id="chart-best-customer" class=''></canvas>
                    </div>
                </div>
            </div>
            <div class='col-xl-6'>
                <div class='panel panel-primary panel-line animation-slide-right' style='animation-delay:200ms'>
                    <div class='panel-heading'>
                        <h3 class='panel-title'>Best Customer @if($filter["tanggal_sampai"] != "" || $filter["tanggal_dari"] != "" || $filter["tipe"] != "" || $filter["tampil"] != "" ) (Filtered) @endif</h3>
                    </div>
                    <div class='panel-body' id='listDiv'>
                        <div style='font-size:15px;font-weight:bold;color:black;' class='text-center'>Kosong</div>
                    </div>
    <!-- <ul class="pagination">
            <li class="page-item disabled"><span class="page-link">asd</span></li>
            <li class="page-item"><a class="page-link" href="d" rel="prev">asd</a></li>
            <li class="page-item"><a class="page-link" href="a" rel="next">asd</a></li>
            <li class="page-item disabled"><span class="page-link">f</span></li>
    </ul> -->
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var data_cust = {!! json_encode($data['list_best_customer']) !!};
    var tampil_cek = @if($filter['tampil'] == "" || $filter['tampil'] == "jumlah_order") "Order" @elseif($filter['tampil'] == "jumlah_produk") "Produk" @elseif($filter['tampil'] == "gross_sales") "Gross Sales" @elseif($filter['tampil'] == "net_sales") "Net Sales" @endif;
    var ukuran_cek = {
        "a" : @if($filter['tampil'] == "" || $filter['tampil'] == "jumlah_order" || $filter['tampil'] == "jumlah_produk") "3" @else "5" @endif,
        "b" : @if($filter['tampil'] == "" || $filter['tampil'] == "jumlah_order" || $filter['tampil'] == "jumlah_produk") "9" @else "6" @endif
    }

    
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
            var dateOrder = new Date(ev.date.valueOf());
            $('#datepickerDari').datepicker('setEndDate', dateOrder);
        });

        @if($filter["tanggal_dari"] != "")
            $("#datepickerSampai").datepicker("setStartDate", "{{ strip_tags($filter['tanggal_dari']) }}");
        @endif
        
        @if($filter["tanggal_sampai"] != "")
            $("#datepickerDari").datepicker("setEndDate", "{{ strip_tags($filter['tanggal_sampai']) }}");
        @endif

        $("#btnFilter").on("click", function(){
            // $(location).attr('href', "{{ route('b.analisa-index') }}?dari="+$.trim($("#datepickerDari").val())+"&sampai="+$.trim($("#datepickerSampai").val()));
            pageLoad('{{ route("b.analisa-bestCustomer") }}'+"?tipe="+$('#s_tipeCustomer').val()+"&tampil="+$('#s_tipeTampil').val()+"&dari="+$.trim($("#datepickerDari").val())+"&sampai="+$.trim($("#datepickerSampai").val()));
        });

        @if(count($data['list_best_customer']) > 0)
            $('#listDiv').html('');
            let temp_cust = data_cust;
            var page = 1, 
                recPerPage = 5, 
                startRec = Math.max(page - 1, 0) * recPerPage, 
                recordsToShow = temp_cust.slice(startRec, startRec+recPerPage),
                jumlah_hal = Math.ceil((data_cust.length / recPerPage));
            $.each(recordsToShow, (i, v) => {
                $('#listDiv').append(
                    "<div style='border-bottom: 1px solid #efefef' class='mt-10 pb-10'>"+
                        "<div class='row'>"+
                            "<div class='col-md-"+ukuran_cek.a+"'>"+
                                "<div class='p-2 text-center'>"+
                                    "<span style='font-weight:bold;color:black;font-size:25px'>"+((tampil_cek == "Produk" || tampil_cek == "Order") ? v.jumlah : "Rp "+uangFormat(v.jumlah))+"</span><br>"+
                                    "<span style='font-size:12px'>"+tampil_cek+"</span>"+
                                "</div>"+
                            "</div>"+
                            "<div class='col-md-"+ukuran_cek.b+"'>"+
                                v.star+
                                "<span style='font-size:17px'><b>"+v.data.name+"</b></span>"+
                                (v.data.kategori == "Reseller" ? "<span class='badge badge-outline badge-success ml-10' style='display:inline-block'>Reseller</span>" : 
                                    (v.data.kategori == "Dropshipper" ? "<span class='badge badge-outline badge-info ml-10' style='display:inline-block'>Dropshipper</span>" : "")
                                )+
                                "<br>"+
                                "<span class='text-muted'>"+v.data.kabupaten+", "+v.data.provinsi+"</span>"+
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
                                    +page+" dari "+jumlah_hal+" Halaman ("+data_cust.length+" Data)"+
                                "</div>"+
                            "</div>"+
                        "</div>"+
                    "</div>"
                );
            }

            $("#listDiv").on('click', '#btnNext', function(){
                let temp_next = data_cust;
                $('#listDiv').html('');
                var pageNext = page+1, 
                    startRecNext = Math.max(pageNext - 1, 0) * recPerPage, 
                    recordsToShowNext = temp_next.slice(startRecNext, startRecNext + recPerPage);
                $.each(recordsToShowNext, (i, v) => {
                    $('#listDiv').append(
                        "<div style='border-bottom: 1px solid #efefef' class='mt-10 pb-10'>"+
                            "<div class='row'>"+
                                "<div class='col-md-"+ukuran_cek.a+"'>"+
                                    "<div class='p-2 text-center'>"+
                                        "<span style='font-weight:bold;color:black;font-size:25px'>"+((tampil_cek == "Produk" || tampil_cek == "Order") ? v.jumlah : "Rp "+uangFormat(v.jumlah))+"</span><br>"+
                                        "<span style='font-size:12px'>"+tampil_cek+"</span>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-md-"+ukuran_cek.b+"'>"+
                                    v.star+
                                    "<span style='font-size:17px'><b>"+v.data.name+"</b></span>"+
                                    (v.data.kategori == "Reseller" ? "<span class='badge badge-outline badge-success ml-10' style='display:inline-block'>Reseller</span>" : 
                                        (v.data.kategori == "Dropshipper" ? "<span class='badge badge-outline badge-info ml-10' style='display:inline-block'>Dropshipper</span>" : "")
                                    )+
                                    "<br>"+
                                    "<span class='text-muted'>"+v.data.kabupaten+", "+v.data.provinsi+"</span>"+
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
                                        +pageNext+" dari "+jumlah_hal+" Halaman ("+data_cust.length+" Data)"+
                                    "</div>"+
                                "</div>"+
                            "</div>"+
                        "</div>"
                    );
                }
                page = pageNext;
            });

            $("#listDiv").on('click', '#btnPrev', function(){
                let temp_prev = data_cust;
                $('#listDiv').html('');
                var pagePrev = page-1, 
                    startRecPrev = Math.max(pagePrev - 1, 0) * recPerPage, 
                    recordsToShowPrev = temp_prev.slice(startRecPrev, startRecPrev + recPerPage);
                $.each(recordsToShowPrev, (i, v) => {
                    $('#listDiv').append(
                        "<div style='border-bottom: 1px solid #efefef' class='mt-10 pb-10'>"+
                            "<div class='row'>"+
                                "<div class='col-md-"+ukuran_cek.a+"'>"+
                                    "<div class='p-2 text-center'>"+
                                        "<span style='font-weight:bold;color:black;font-size:25px'>"+((tampil_cek == "Produk" || tampil_cek == "Order") ? v.jumlah : "Rp "+uangFormat(v.jumlah))+"</span><br>"+
                                        "<span style='font-size:12px'>"+tampil_cek+"</span>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-md-"+ukuran_cek.b+"'>"+
                                    v.star+
                                    "<span style='font-size:17px'><b>"+v.data.name+"</b></span>"+
                                    (v.data.kategori == "Reseller" ? "<span class='badge badge-outline badge-success ml-10' style='display:inline-block'>Reseller</span>" : 
                                        (v.data.kategori == "Dropshipper" ? "<span class='badge badge-outline badge-info ml-10' style='display:inline-block'>Dropshipper</span>" : "")
                                    )+
                                    "<br>"+
                                    "<span class='text-muted'>"+v.data.kabupaten+", "+v.data.provinsi+"</span>"+
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
                                        +pagePrev+" dari "+jumlah_hal+" Halaman ("+data_cust.length+" Data)"+
                                    "</div>"+
                                "</div>"+
                            "</div>"+
                        "</div>"
                    );
                }
                page = pagePrev;
            });
        @endif

        var chart_best_customer = new Chart(document.getElementById('chart-best-customer').getContext('2d'), {
            type: 'pie',
            data: {
                labels: {!! $data['chart_best_customer']['label'] !!},
                datasets: [{
					data: {!! $data['chart_best_customer']['data'] !!},
					backgroundColor: {!! $data['chart_best_customer']['warna'] !!}
				}]
            },
            options: {
				responsive: true,
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var index = tooltipItem.index;
                            var total = 0;
                            $.each(data.datasets[0].data, function(i, v){
                                total += v;
                            });
                            var jumlah = data.datasets[0].data[index];
                            var persen = (jumlah / total) * 100;
                            var label = data.labels[index]+": "+jumlah+" Order ("+Math.round(persen).toString()+"%)";
                            return label;
                        }
                    }
                }
			}
        });

        $('#s_tipeCustomer').selectpicker({
            style: 'btn-primary'
        });

        $('#s_tipeTampil').selectpicker({
            style: 'btn-primary'
        });
    
    });
</script>
<!--uiop-->
@endsection