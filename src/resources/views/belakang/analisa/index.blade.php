@extends('belakang.index')
@section('isi')
<!--uiop-->
<div class="page-header page-header-bordered">
    <h1 class="page-title font-size-26 font-weight-100">Analisa</h1>
    <div class="page-header-actions">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);"
                    onClick="pageLoad('{{ route('b.dashboard') }}')">Dashboard</a></li>
            <li class="breadcrumb-item active">Analisa</li>
        </ol>
    </div>
</div>
<div class="page-content">
    <div class='container'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='float-right animation-slide-right' style='animation-delay:600ms'>
                    <div class='panel p-15'>
                        <div class='d-flex'>
                            <div class="input-group">
                                <input type="text" class="form-control" style='border-color:#3e8ef7' value='{{ $tanggal["dari"] }}' id='datepickerDari' placeholder='Dari Tanggal' name='f_tglDari' autocomplete='off'>
                                <div class="input-group-addon bg-blue-600 white">-</div>
                                <input type="text" class="form-control" style='border-color:#3e8ef7' value='{{ $tanggal["sampai"] }}' id="datepickerSampai" placeholder='Sampai Tanggal' name='f_tglSampai' autocomplete='off'>
                            </div>
                            <button type="button" class="btn btn-icon btn-primary ml-10" id='btnFilter'><i class="icon fa-filter" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-xxl-4'>
                <div class='panel panel-primary panel-line animation-slide-top' style='animation-delay:100ms'>
                    <div class='panel-heading'>
                        <h3 class='panel-title'>Best Customer</h3>
                    </div>
                    <div class='panel-body'>
                        @if(count($data['best_customer']) > 0)
                            @foreach($data['best_customer'] as $i => $v)
                                @php
                                    $i_ = 0;
                                    $i__ = false;
                                @endphp
                                <div style='border-bottom: 1px solid #efefef' class='mt-10 pb-10'>
                                    <div class='row'>
                                        <div class='col-md-3'>
                                            <div class="p-2 text-center">
                                                <span style='font-weight:bold;color:black;font-size:25px'>{{ $v['jumlah'] }}</span><br>
                                                <span style='font-size:12px'>Order</span>
                                            </div>
                                        </div>
                                        <div class='col-md-8'>
                                            @for($y=$i; $y<=4; $y++)
                                                @php
                                                    if(!$i__){
                                                        $i_ = $i;
                                                        $i__ = true;
                                                    }
                                                @endphp
                                                <i class='icon wb-star orange-500'></i>
                                            @endfor
                                            @for($t=0; $t<$i_; $t++)
                                                <i class='icon wb-star grey-400'></i>
                                            @endfor
                                            <br>
                                            <span style='font-size:17px'><b>{{ ucwords(strtolower($v['data']->name)) }}</b></span>
                                            @if($v['data']->kategori == "Reseller")
                                                <span class='badge badge-outline badge-success ml-10' style='display:inline-block'>Reseller</span>
                                            @elseif($v['data']->kategori == "Dropshipper")
                                                <span class='badge badge-outline badge-info ml-10' style='display:inline-block'>Dropshipper</span>
                                            @endif
                                            <br>
                                            <span class='text-muted'>{{ $v['data']->kabupaten }}, {{ $v['data']->provinsi }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class='mt-20'>
                                <div class='text-center'>
                                    <button type='button' class='btn btn-primary' onClick="pageLoad('{{ route('b.analisa-bestCustomer') }}')">Lihat Semua</button>
                                </div>
                            </div>
                        @else
                            <div style='font-size:15px;font-weight:bold;color:black;' class='text-center'>Kosong</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class='col-xxl-4 col-xl-6'>
                <div class='panel panel-success panel-line animation-slide-top' style="animation-delay:200ms">
                    <div class='panel-heading'>
                        <h3 class='panel-title'>Best Penjualan Produk</h3>
                    </div>
                    <div class='panel-body'>
                        @if(count($data['best_penjualan_produk']) > 0)
                            @foreach($data['best_penjualan_produk'] as $i => $v)
                                <div style='border-bottom: 1px solid #efefef' class='mt-10 pb-10'>
                                    <div class='row'>
                                        <div class='col-md-3'>
                                            <div class="p-2 text-center">
                                                <img class="rounded" width="50" height="50" src="{{ $v['data']->foto }}">
                                            </div>
                                        </div>
                                        <div class='col-md-8'>
                                            <span style='font-size:17px'><b>{{ ucwords(strtolower($v['data']->nama_produk)) }}</b></span><br>
                                            <span class='badge badge-outline badge-success badge-lg' style='display:inline-block'>{{ $v['jumlah'] }} Item Terjual</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class='mt-20'>
                                <div class='text-center'>
                                    <button type='button' class='btn btn-success' onClick="pageLoad('{{ route('b.analisa-bestProduk') }}')">Lihat Semua</button>
                                </div>
                            </div>
                        @else
                            <div style='font-size:15px;font-weight:bold;color:black;' class='text-center'>Kosong</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class='col-xxl-4 col-xl-6'>
                <div class='panel panel-info panel-line animation-slide-top' style='animation-delay:300ms'>
                    <div class='panel-heading'>
                        <h3 class='panel-title'>Lokasi Customer</h3>
                    </div>
                    <div class='panel-body'>
                        @if(count($data['lokasi_customer']) > 0)
                            @foreach($data['lokasi_customer'] as $i => $v)
                                <div style='border-bottom: 1px solid #efefef' class='mt-10 pb-10'>
                                    <div class='row'>
                                        <div class='col-md-3'>
                                            <div class="p-2 text-center">
                                                <span style='font-weight:bold;color:black;font-size:20px'>{{ str_replace(".", ",", $v['persen']) }}%</span>
                                            </div>
                                        </div>
                                        <div class='col-md-8'>
                                            <span style='font-size:15px'><b>{{ $v['data']->kabupaten }}, {{ $v['data']->provinsi }}</b></span><br>
                                            <span class='badge badge-outline badge-success badge-lg' style='display:inline-block'>{{ $v['jumlah'] }} Order</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class='mt-20'>
                                <div class='text-center'>
                                    <button type='button' class='btn btn-info' onClick="pageLoad('{{ route('b.analisa-customerLokasi') }}')">Lihat Semua</button>
                                </div>
                            </div>
                        @else
                            <div style='font-size:15px;font-weight:bold;color:black;' class='text-center'>Kosong</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-xl-12'>
                <div class='panel animation-slide-bottom' style='animation-delay:500ms'>
                    <div class='panel-heading'>
                        <h3 class='panel-title'>Grafik Analisa @if($tanggal["dari"] != '' && $tanggal["sampai"] != '') Setelah difilter @else Bulan Ini @endif</h3>
                    </div>
                    <div class='panel-body'>
                        <canvas id="chart-lengkap" class=''></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){

        var chart_lengkap = new Chart(document.getElementById('chart-lengkap').getContext('2d'), {
            type: 'line',
            data: {
                labels: {!! $data['chart_lengkap']['tgl'] !!},
                datasets: [{
                    label: 'Order',
                    fill: false,
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
					pointRadius: 5,
					pointHoverRadius: 5,
                    data: {!! $data['chart_lengkap']['order']['data'] !!}
                },{
                    label: 'Produk Terjual',
                    fill: false,
                    backgroundColor: 'rgb(26, 140, 255)',
                    borderColor: 'rgb(26, 140, 255)',
					pointRadius: 5,
					pointHoverRadius: 5,
                    data: {!! $data['chart_lengkap']['produk']['data'] !!}
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
				}
			}
        });
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

        @if($tanggal["dari"] != "")
            $("#datepickerSampai").datepicker("setStartDate", "{{ strip_tags($tanggal['dari']) }}");
        @endif
        
        @if($tanggal["sampai"] != "")
            $("#datepickerDari").datepicker("setEndDate", "{{ strip_tags($tanggal['sampai']) }}");
        @endif

        $("#btnFilter").on("click", function(){
            // $(location).attr('href', "{{ route('b.analisa-index') }}?dari="+$.trim($("#datepickerDari").val())+"&sampai="+$.trim($("#datepickerSampai").val()));
            pageLoad('{{ route("b.analisa-index") }}'+"?dari="+$.trim($("#datepickerDari").val())+"&sampai="+$.trim($("#datepickerSampai").val()));
        });
    });
</script>
<!--uiop-->
@endsection