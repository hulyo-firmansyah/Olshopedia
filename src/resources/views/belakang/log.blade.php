@extends('belakang.index')
@section('title', 'Log')
@section('isi')
<!--uiop-->
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="page-header page-header-bordered">
    <h1 class="page-title font-size-26 font-weight-100">Log Aktifitas</h1>
    <div class="page-header-actions">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);"
                    onClick="pageLoad('{{ route('b.dashboard') }}')">Dashboard</a></li>
            <li class="breadcrumb-item active">Log Aktifitas</li>
        </ol>
    </div>
</div>

<div class="page-content mt-50">
    <div class='container'>
        <div class='row'>
            <div class='col-xxl-5 col-xl-6'>
                <div class='panel p-10 animation-slide-left' style='animation-delay:200ms'>
                    <div class="input-group">
                        <input type="text" class="form-control" id='datepickerDari' name='f_tglDari' autocomplete='off' value="{{$filter['tglDari']}}">
                        <div class="input-group-addon">Sampai</div>
                        <input type="text" class="form-control" id="datepickerSampai" name='f_tglSampai' autocomplete='off' value="{{$filter['tglSampai']}}">
                        <button type='button' class='btn btn-success ml-5' id='btnUseFilter'><i class="fas fa-filter"></i> Filter</button>
                    </div>
                </div>
            </div>
            <div class='col-xxl-5 hidden-xl-down'>
            </div>
            <div class='col-xxl-2 col-xl-6'>
                <div class='panel p-10 animation-slide-right text-center' style='animation-delay:200ms'>
                    <form action="{{ route('b.log-deleteLog') }}">
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus Semua Log</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class='col-xl-12'>
                <div class="panel p-4 animation-slide-bottom" style='animation-delay:100ms'>
                    @if ($msg_sukses = Session::get('msg_success'))
                    <div class='alert alert-success mb-3' role='alert' id='al-success'><i class='fa fa-check'></i> SUCCESS: {{$msg_sukses}}</div>
                    @endif
                    @if ($msg_warning = Session::get('msg_warning'))
                    <div class='alert alert-danger mb-3' role='alert' id='al-warning'><i class='fa fa-minus-circle'></i> WARNING: {{$msg_warning}}</div>
                    @endif
                    @if ($msg_error = Session::get('msg_error'))
                    <div class='alert alert-danger mb-3' role='alert' id='al-error'><i class='fa fa-minus-circle'></i> ERROR: {{$msg_error}}</div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div id="listDiv">
                                <div style='font-size:15px;font-weight:bold;color:black;' class='text-center pb--20'>Kosong</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var data_log = {!! json_encode($data) !!};

    // Document ready
    $(document).ready(function () {
        //Alert
        @if($msg_sukses = Session::get('msg_success') || $msg_error = Session::get('msg_error') || $msg_warning = Session::get('msg_warning'))
            window.setTimeout(function() {
                $('.alert').animate({
                    height: 'toggle'
                }, 'slow');
            }, 5000);
        @endif

        //Datepicker
        $("#datepickerDari").datepicker({
            format: "dd M yyyy",
            orientation: 'bottom'
        }).on('changeDate', function (ev) {
            var dateOrder = new Date(ev.date.valueOf());
            $('#datepickerSampai').datepicker('setStartDate', dateOrder);
        });

        $("#datepickerSampai").datepicker({
            format: "dd M yyyy",
            orientation: 'bottom'
        }).on('changeDate', function (ev) {
            var dateOrder = new Date(ev.date.valueOf());
            $('#datepickerDari').datepicker('setEndDate', dateOrder);
        });

        //Filter Log
        $("#btnUseFilter").on('click', function () {
            $dari = $("#datepickerDari").val();
            $sampai = $("#datepickerSampai").val();
            pageLoad("{{ route('b.log-index')}}?dari=" + $dari + "&sampai=" + $sampai);
        })

        $("#datepickerDari").datepicker({
            format: "dd MM yyyy",
            orientation: 'bottom'
        }).on('changeDate', function (ev) {
            var dateOrder = new Date(ev.date.valueOf());
            $('#datepickerSampai').datepicker('setStartDate', dateOrder);
        });

        $("#datepickerSampai").datepicker({
            format: "dd MM yyyy",
            orientation: 'bottom'
        }).on('changeDate', function (ev) {
            var dateOrder2 = new Date(ev.date.valueOf());
            $('#datepickerDari').datepicker('setEndDate', dateOrder2);
        });

        @if($filter['tglDari'] != "")
        $("#datepickerSampai").datepicker("setStartDate", "{{ strip_tags($filter['tglDari']) }}");
        @endif

        @if($filter['tglSampai'] != "")
        $("#datepickerDari").datepicker("setEndDate", "{{ strip_tags($filter['tglSampai']) }}");
        @endif


        //Show Log data
        @if(count($data) > 0)
        $('#listDiv').html('');
        let temp_cust = data_log;
        var page = 1,
            recPerPage = 5,
            startRec = Math.max(page - 1, 0) * recPerPage,
            recordsToShow = data_log.slice(startRec, startRec + recPerPage),
            jumlah_hal = Math.ceil((data_log.length / recPerPage));
        $.each(recordsToShow, (i, v) => {
            $time =
                $('#listDiv').append(
                    "<a href='javascript:void(0);' class='list-group-item list-group-item-action flex-column align-items-start border'>" +
                    "<div class='d-flex justify-content-between'>" +
                    "<h5 class='mb-1'>" + v.name + " &nbsp;&nbsp;(" + v.email + ")</h5>" +
                    "<small>" + v.since + "</small>" +
                    "</div>" +
                    "<p>" + v.tanggal_waktu + ": " + v.keterangan + ".</p>" +
                    "</a>"
                );
        });
        if (jumlah_hal > 1) {
            $('#listDiv').append(
                "<div class='mt-20'>" +
                "<div class='row'>" +
                "<div class='col-md-6'>" +
                "<ul class='pagination'>" +
                "<li class='page-item disabled'><span class='page-link'><i class='icon wb-chevron-left-mini'></i></span></li>" +
                "<li class='page-item'><button class='page-link' id='btnNext' type='button'><i class='icon wb-chevron-right-mini'></i></button></li>" +
                "</ul>" +
                "</div>" +
                "<div class='col-md-6'>" +
                "<div class='float-right'>" +
                +page + " dari " + jumlah_hal + " Halaman (" + data_log.length + " Data)" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>"
            );
        }

        $("#listDiv").on('click', '#btnNext', function () {
            let temp_next = data_log;
            $('#listDiv').html('');
            var pageNext = page + 1,
                startRecNext = Math.max(pageNext - 1, 0) * recPerPage,
                recordsToShowNext = temp_next.slice(startRecNext, startRecNext + recPerPage);
            $.each(recordsToShowNext, (i, v) => {
                $('#listDiv').append(
                    "<a href='javascript:void(0);' class='list-group-item list-group-item-action flex-column align-items-start border'>" +
                    "<div class='d-flex justify-content-between'>" +
                    "<h5 class='mb-1'>" + v.name + " &nbsp;&nbsp;(" + v.email + ")</h5>" +
                    "<small>" + v.since + "</small>" +
                    "</div>" +
                    "<p>" + v.tanggal_waktu + ": " + v.keterangan + ".</p>" +
                    "</a>"
                );
            });
            if (jumlah_hal > 1) {
                if (jumlah_hal == pageNext) {
                    var btnNext =
                        "<li class='page-item disabled'><span class='page-link'><i class='icon wb-chevron-right-mini'></i></span></li>";
                } else {
                    var btnNext =
                        "<li class='page-item'><button class='page-link' id='btnNext' type='button'><i class='icon wb-chevron-right-mini'></i></button></li>";
                }
                if (pageNext == 1) {
                    var btnPrev =
                        "<li class='page-item disabled'><span class='page-link'><i class='icon wb-chevron-left-mini'></i></span></li>";
                } else {
                    var btnPrev =
                        "<li class='page-item'><button class='page-link' id='btnPrev' type='button'><i class='icon wb-chevron-left-mini'></i></button></li>";
                }
                $('#listDiv').append(
                    "<div class='mt-20'>" +
                    "<div class='row'>" +
                    "<div class='col-md-6'>" +
                    "<ul class='pagination'>" +
                    btnPrev + btnNext +
                    "</ul>" +
                    "</div>" +
                    "<div class='col-md-6'>" +
                    "<div class='float-right'>" +
                    +pageNext + " dari " + jumlah_hal + " Halaman (" + data_log.length + " Data)" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>"
                );
            }
            page = pageNext;
        });

        $("#listDiv").on('click', '#btnPrev', function () {
            let temp_prev = data_log;
            $('#listDiv').html('');
            var pagePrev = page - 1,
                startRecPrev = Math.max(pagePrev - 1, 0) * recPerPage,
                recordsToShowPrev = temp_prev.slice(startRecPrev, startRecPrev + recPerPage);
            $.each(recordsToShowPrev, (i, v) => {
                $('#listDiv').append(
                    "<a href='javascript:void(0);' class='list-group-item list-group-item-action flex-column align-items-start border'>" +
                    "<div class='d-flex justify-content-between'>" +
                    "<h5 class='mb-1'>" + v.name + " &nbsp;&nbsp;(" + v.email + ")</h5>" +
                    "<small>" + v.since + "</small>" +
                    "</div>" +
                    "<p>" + v.tanggal_waktu + ": " + v.keterangan + ".</p>" +
                    "</a>"
                );
            });
            if (jumlah_hal > 1) {
                if (jumlah_hal == pagePrev) {
                    var btnNext =
                        "<li class='page-item disabled'><span class='page-link'><i class='icon wb-chevron-right-mini'></i></span></li>";
                } else {
                    var btnNext =
                        "<li class='page-item'><button class='page-link' id='btnNext' type='button'><i class='icon wb-chevron-right-mini'></i></button></li>";
                }
                if (pagePrev == 1) {
                    var btnPrev =
                        "<li class='page-item disabled'><span class='page-link'><i class='icon wb-chevron-left-mini'></i></span></li>";
                } else {
                    var btnPrev =
                        "<li class='page-item'><button class='page-link' id='btnPrev' type='button'><i class='icon wb-chevron-left-mini'></i></button></li>";
                }
                $('#listDiv').append(
                    "<div class='mt-20'>" +
                    "<div class='row'>" +
                    "<div class='col-md-6'>" +
                    "<ul class='pagination'>" +
                    btnPrev + btnNext +
                    "</ul>" +
                    "</div>" +
                    "<div class='col-md-6'>" +
                    "<div class='float-right'>" +
                    +pagePrev + " dari " + jumlah_hal + " Halaman (" + data_log.length + " Data)" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>"
                );
            }
            page = pagePrev;
        });
        @endif

    });

</script>
<!--uiop-->
@endsection
