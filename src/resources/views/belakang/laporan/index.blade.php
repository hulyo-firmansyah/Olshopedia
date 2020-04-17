@extends('belakang.index')
@section('isi')
<!--uiop-->
<div class="page-header page-header-bordered">
    <h1 class="page-title font-size-26 font-weight-100">Laporan</h1>
    <div class="page-header-actions">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);"
                    onClick="pageLoad('{{ route('b.dashboard') }}')">Dashboard</a></li>
            <li class="breadcrumb-item active">Laporan</li>
        </ol>
    </div>
</div>
<div class="page-content">
    <div class='container'>
        <div class='row'>
            <div class='col-lg-12'>
                <div class='float-right animation-slide-right' style='animation-delay:350ms'>
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
            <div class='col-xxl-4 col-xl-6'>
                <div class="card p-30 flex-row justify-content-between animation-scale-up" style='animation-delay:100ms'>
                    <div class="white">
                        <i class="icon icon-circle icon-2x fa-balance-scale bg-red-600" aria-hidden="true"></i>
                    </div>
                    <div class="counter counter-md counter text-right">
                        <div class="counter-number-group">
                            <span class="counter-number">{{ $data['gross_sales'] }}</span>
                            <span class="counter-number-related text-capitalize"></span>
                        </div>
                        <div class="counter-label text-capitalize font-size-16">Gross Sales <i class='icon fa-question-circle' id='gross_sales-help'></i></div>
                    </div>
                </div>
            </div>
            <div class='col-xxl-4 col-xl-6'>
                <div class="card p-30 flex-row justify-content-between animation-scale-up" style='animation-delay:200ms'>
                    <div class="white">
                        <i class="icon icon-circle icon-2x fa-shopping-cart bg-blue-600" aria-hidden="true"></i>
                    </div>
                    <div class="counter counter-md counter text-right">
                        <div class="counter-number-group">
                            <span class="counter-number">{{ $data['net_sales'] }}</span>
                            <span class="counter-number-related text-capitalize"></span>
                        </div>
                        <div class="counter-label text-capitalize font-size-16">Net Sales <i class='icon fa-question-circle' id='net_sales-help'></i></div>
                    </div>
                </div>
            </div>
            <div class='col-xxl-4 col-xl-6'>
                <div class="card p-30 flex-row justify-content-between animation-scale-up" style='animation-delay:300ms'>
                    <div class="white">
                        <i class="icon icon-circle icon-2x fa-cart-arrow-down bg-green-600" aria-hidden="true"></i>
                    </div>
                    <div class="counter counter-md counter text-right">
                        <div class="counter-number-group">
                            <span class="counter-number">{{ $data['gross_profit'] }}</span>
                            <span class="counter-number-related text-capitalize"></span>
                        </div>
                        <div class="counter-label text-capitalize font-size-16">Gross Profit <i class='icon fa-question-circle' id='gross_profit-help'></i></div>
                    </div>
                </div>
            </div>
            <div class='col-xxl-4 col-xl-6'>
                <div class="card p-30 flex-row justify-content-between animation-scale-up" style='animation-delay:400ms'>
                    <div class="white">
                        <i class="icon icon-circle icon-2x fa-credit-card bg-light-green-600" aria-hidden="true"></i>
                    </div>
                    <div class="counter counter-md counter text-right">
                        <div class="counter-number-group">
                            <span class="counter-number">{{ $data['expense'] }}</span>
                            <span class="counter-number-related text-capitalize"></span>
                        </div>
                        <div class="counter-label text-capitalize font-size-16">Expense <i class='icon fa-question-circle' id='expense-help'></i></div>
                    </div>
                </div>
            </div>
            <div class='col-xxl-4 col-xl-6'>
                <div class="card p-30 flex-row justify-content-between animation-scale-up" style='animation-delay:500ms'>
                    <div class="white">
                        <i class="icon icon-circle icon-2x fa-line-chart bg-purple-600" aria-hidden="true"></i>
                    </div>
                    <div class="counter counter-md counter text-right">
                        <div class="counter-number-group">
                            <span class="counter-number">{{ $data['net_profit'] }}</span>
                            <span class="counter-number-related text-capitalize"></span>
                        </div>
                        <div class="counter-label text-capitalize font-size-16">Net Profit <i class='icon fa-question-circle' id='net_profit-help'></i></div>
                    </div>
                </div>
            </div>
            <div class='col-xxl-4 col-xl-6'>
                <div class="card p-30 flex-row justify-content-between animation-scale-up" style='animation-delay:600ms'>
                    <div class="white">
                        <i class="icon icon-circle icon-2x fa-money bg-cyan-500" aria-hidden="true"></i>
                    </div>
                    <div class="counter counter-md counter text-right">
                        <div class="counter-number-group">
                            <span class="counter-number">{{ $data['unpaid_gross_sales'] }}</span>
                            <span class="counter-number-related text-capitalize"></span>
                        </div>
                        <div class="counter-label text-capitalize font-size-16">Unpaid Gross Sales <i class='icon fa-question-circle' id='unpaid_gross_sales-help'></i></div>
                    </div>
                </div>
            </div>
            <div class='col-xxl-4 col-xl-6'>
                <div class="card p-30 flex-row justify-content-between animation-scale-up" style='animation-delay:700ms'>
                    <div class="white">
                        <i class="icon icon-circle icon-2x fa-archive bg-teal-600" aria-hidden="true"></i>
                    </div>
                    <div class="counter counter-md counter text-right">
                        <div class="counter-number-group">
                            <span class="counter-number">{{ $data['total_harga_beli_produk'] }}</span>
                            <span class="counter-number-related text-capitalize"></span>
                        </div>
                        <div class="counter-label text-capitalize font-size-16">Total Harga Beli Produk</div>
                    </div>
                </div>
            </div>
            <div class='col-xxl-4 col-xl-6'>
                <div class="card p-30 flex-row justify-content-between animation-scale-up" style='animation-delay:800ms'>
                    <div class="white">
                        <i class="icon icon-circle icon-2x fa-cubes bg-orange-600" aria-hidden="true"></i>
                    </div>
                    <div class="counter counter-md counter text-right">
                        <div class="counter-number-group">
                            <span class="counter-number">{{ $data['produk_terjual'] }}</span>
                            <span class="counter-number-related text-capitalize"></span>
                        </div>
                        <div class="counter-label text-capitalize font-size-16">Total Produk Terjual</div>
                    </div>
                </div>
            </div>
            <div class='col-xxl-4 col-xl-6'>
                <div class="card p-30 flex-row justify-content-between animation-scale-up" style='animation-delay:900ms'>
                    <div class="white">
                        <i class="icon icon-circle icon-2x fa-shopping-basket bg-yellow-600" aria-hidden="true"></i>
                    </div>
                    <div class="counter counter-md counter text-right">
                        <div class="counter-number-group">
                            <span class="counter-number">{{ $data['order_selesai'] }}</span>
                            <span class="counter-number-related text-capitalize"></span>
                        </div>
                        <div class="counter-label text-capitalize font-size-16">Total Order Terselesaikan</div>
                    </div>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-xl-6'>
                <div class='panel animation-slide-left' style='animation-delay:500ms'>
                    <div class='panel-heading'>
                        <h3 class='panel-title'>Data Transaksi per Via Pembayaran</h3>
                    </div>
                    <div class='panel-body'>
                        <div class='table-responsive'>
                            <table class="table table-hover table-striped w-full" id="tableDataTransaksi">
                                <thead>
                                    <tr>
                                        <th>Via Pembayaran</th>
                                        <th>Total Dana Masuk</th>
                                    </tr>
                                </thead>
                                <tbody id="isiTableDataTransaksi">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-xl-6'>
                <div class='panel animation-slide-right' style='animation-delay:500ms'>
                    <div class='panel-heading'>
                        <h3 class='panel-title'>Grafik Expedisi</h3>
                    </div>
                    <div class='panel-body'>
                        <canvas id="chart-expedisi"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-12'>
                <div class='panel animation-slide-bottom' style='animation-delay:400ms'>
                    <div class='panel-heading'>
                        <h3 class='panel-title'>Grafik Keuntungan</h3>
                    </div>
                    <div class='panel-body'>
                        <canvas id='chart-untung'></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        var chart_expedisi = new Chart(document.getElementById('chart-expedisi').getContext('2d'), {
            type: 'pie',
            data: {
                labels: {!! $data['chart_expedisi']['expedisi'] !!},
                datasets: [{
                    data: {!! $data['chart_expedisi']['data'] !!},
                    backgroundColor: {!! $data['chart_expedisi']['warna'] !!}
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

        var tabelDataTransaksi = $('#tableDataTransaksi').DataTable({
            ajax: {
                type: 'get',
                url: "{{ route('b.laporan-getTransaksiData') }}",
                data: {
                    dari: "{{ $tanggal['dari'] }}",
                    sampai: "{{ $tanggal['sampai'] }}",
                }
            },
            "searching": false,
            "paging": false,
            "info": false,
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            }],
            "order": [
                [1, 'asc']
            ]
        });

		var myBar = new Chart(document.getElementById('chart-untung').getContext('2d'), {
            type: 'bar',
            data: {
                labels: {!! $data['chart_untung']['list_tgl'] !!},
                datasets: [{
                    label: 'Net Sales',
                    backgroundColor: 'rgb(62, 142, 247)',
                    borderColor: 'rgb(62, 142, 247)',
                    borderWidth: 1,
                    data: {!! $data['chart_untung']['net_sales'] !!}
                }, {
                    label: 'Gross Profit',
                    backgroundColor: 'rgb(17, 194, 109)',
                    borderColor: 'rgb(17, 194, 109)',
                    borderWidth: 1,
                    data: {!! $data['chart_untung']['gross_profit'] !!}
                }]
		    },
            options: {
				responsive: true,
				tooltips: {
					mode: 'index',
					intersect: false,
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = " "+data.datasets[tooltipItem.datasetIndex].label || '';

                            if (label) {
                                label += ': ';
                            }
                            var sp = tooltipItem.yLabel.toString().split("").reverse();
                            var yt = 0;
                            var te = "";
                            var temp = [];
                            var cekMin = false;
                            $.each(sp, function(i, v) {
                                if(v == "-") {
                                    cekMin = true;
                                } else if(v == "."){
                                    temp.push(",");
                                } else {
                                    temp.push(v);
                                }
                            });
                            $.each(temp, function(i, v) {
                                if(v == ","){
                                    yt = 0;
                                } else if (yt === 3) {
                                    te += ".";
                                    yt = 0;
                                }
                                te += v;
                                yt++;
                            });
                            var hasil = te.split("").reverse().join("");
                            if(cekMin){
                                label += '  - Rp '+ hasil;
                            } else {
                                label += '  Rp '+ hasil;
                            }
                            return label;
                        }
                    }
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
                scales: {
                    yAxes: [{
                        ticks: {
                            callback: function(value, index, values) {
                                var sp = value.toString().split("").reverse();
                                var yt = 0;
                                var te = "";
                                var temp = [];
                                var cekMin = false;
                                $.each(sp, function(i, v) {
                                    if(v == "-") {
                                        cekMin = true;
                                    } else if(v == "."){
                                        temp.push(",");
                                    } else {
                                        temp.push(v);
                                    }
                                });
                                $.each(temp, function(i, v) {
                                    if(v == ","){
                                        yt = 0;
                                    } else if (yt === 3) {
                                        te += ".";
                                        yt = 0;
                                    }
                                    te += v;
                                    yt++;
                                });
                                var hasil = te.split("").reverse().join("");
                                if(cekMin){
                                    return '- Rp '+hasil;
                                } else {
                                    return 'Rp ' + hasil;
                                }
                            }
                        }
                    }]
                },
            }
        });
        
        $('#gross_sales-help').tooltip({
            trigger: 'hover',
            title: 'Total hasil penjualan termasuk ongkir dan biaya lain',
            placement: 'bottom'
        });
        
        $('#unpaid_gross_sales-help').tooltip({
            trigger: 'hover',
            title: 'Total Gross Sales dari order yang belum dibayar',
            placement: 'bottom'
        });
        
        $('#net_sales-help').tooltip({
            trigger: 'hover',
            title: 'Total hasil penjualan tidak termasuk ongkir dan biaya lain',
            placement: 'bottom'
        });
        
        $('#gross_profit-help').tooltip({
            trigger: 'hover',
            title: 'Total hasil Net Sales dikurangi total harga beli produk',
            placement: 'bottom'
        });
        
        $('#expense-help').tooltip({
            trigger: 'hover',
            title: 'Total pengeluaran',
            placement: 'bottom'
        });
        
        $('#net_profit-help').tooltip({
            trigger: 'hover',
            title: 'Total hasil Gross Profit dikurangi Expense',
            placement: 'bottom'
        });

        $("#btnFilter").on("click", function(){
            // $(location).attr('href', "{{ route('b.analisa-index') }}?dari="+$.trim($("#datepickerDari").val())+"&sampai="+$.trim($("#datepickerSampai").val()));
            pageLoad('{{ route("b.laporan-index") }}'+"?dari="+$.trim($("#datepickerDari").val())+"&sampai="+$.trim($("#datepickerSampai").val()));
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