@extends('belakang.index')
@section('isi')
<!--uiop-->
<div class="page-header page-header-bordered">
    <h1 class="page-title font-size-26 font-weight-100">Dashboard</h1>
    <div class="page-header-actions">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">@php echo date('d F Y'); @endphp</li>
        </ol>
    </div>
</div>

<div class="page-content container-fluid">
    <div class="row">
        @if(($ijin->melihatOmset === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner')
        <div class="col-xxl-3 col-lg-6 info-panel animation-slide-top" style='animation-delay:100ms'>
            <div class="card card-inverse card-shadow bg-yellow-700 white">
                <div class="card-block p-20">
                    <i class="icon fa-shopping-cart ml-10 mt-10"></i>
                    <span class="ml-15 font-weight-400">ORDER HARI INI</span>
                    <div class="content-text text-center mb-0">
                        @if($data['order_hari_ini']['cek'] === 1)
                            <i class="text-success icon wb-triangle-up font-size-20"></i>
                        @elseif($data['order_hari_ini']['cek'] === -1)
                            <i class="text-danger icon wb-triangle-down font-size-20"></i>
                        @endif
                        <span class="font-size-40 font-weight-100">{{ $data['order_hari_ini']['data'] }}</span>
                    </div>
                    <a class='float-right' style='text-decoration:none;font-weight:bold;color:white' href='javascript::void(0)' onClick="pageLoad('{{ $url_['order_hari_ini'] }}')">Lihat Detail <i class='fa fa-angle-double-right'></i></a>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-lg-6 info-panel animation-slide-top" style='animation-delay:200ms'>
            <div class="card card-inverse card-shadow bg-orange-500 white">
                <div class="card-block p-20">
                    <i class="icon fa-cart-arrow-down ml-10 mt-10"></i>
                    <span class="ml-15 font-weight-400">ORDER BELUM DIPROSES</span>
                    <div class="content-text text-center mb-0">
                        <span class="font-size-40 font-weight-100">{{ $data['belum_diproses']['data'] }}</span>
                    </div>
                    <a class='float-right' style='text-decoration:none;font-weight:bold;color:white' href='javascript::void(0)' onClick="pageLoad('{{ $url_['belum_diproses'] }}')">Lihat Detail <i class='fa fa-angle-double-right'></i></a>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-lg-6 info-panel animation-slide-top" style='animation-delay:300ms'>
            <div class="card card-inverse card-shadow bg-teal-500 white">
                <div class="card-block p-20">
                    <i class="icon fa-cube ml-10 mt-10"></i>
                    <span class="ml-15 font-weight-400">PRODUK TERJUAL</span>
                    <div class="content-text text-center mb-0">
                        <span class="font-size-40 font-weight-100">{{ $data['produk_terjual']['data'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-lg-6 info-panel animation-slide-top" style='animation-delay:400ms'>
            <div class="card card-inverse card-shadow bg-cyan-500 white" style='overflow-wrap: break-word;'>
                <div class="card-block p-20">
                    <i class="icon fa-dollar ml-10 mt-10"></i>
                    <span class="ml-15 font-weight-400">GROSS PROFIT</span>
                    <div class="content-text text-center mb-0" style='overflow-wrap: break-word;'>
                        <span class="font-size-30 font-weight-100 @if($data['gross_profit']['cek'] === 1) white @elseif($data['gross_profit']['cek'] === -1) text-danger @endif">{{ $data['gross_profit']['data'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        @else 
        <div class="col-lg-4 col-md-6 info-panel animation-slide-top" style='animation-delay:100ms'>
            <div class="card card-inverse card-shadow bg-yellow-700 white">
                <div class="card-block p-20">
                    <i class="icon fa-shopping-cart ml-10 mt-10"></i>
                    <span class="ml-15 font-weight-400">ORDER HARI INI</span>
                    <div class="content-text text-center mb-0">
                        @if($data['order_hari_ini']['cek'] === 1)
                            <i class="text-success icon wb-triangle-up font-size-20"></i>
                        @elseif($data['order_hari_ini']['cek'] === -1)
                            <i class="text-danger icon wb-triangle-down font-size-20"></i>
                        @endif
                        <span class="font-size-40 font-weight-100">{{ $data['order_hari_ini']['data'] }}</span>
                    </div>
                    <a class='float-right' style='text-decoration:none;font-weight:bold;color:white' href='javascript::void(0)' onClick="pageLoad('{{ $url_['order_hari_ini'] }}')">Lihat Detail <i class='fa fa-angle-double-right'></i></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 info-panel animation-slide-top" style='animation-delay:200ms'>
            <div class="card card-inverse card-shadow bg-orange-500 white">
                <div class="card-block p-20">
                    <i class="icon fa-cart-arrow-down ml-10 mt-10"></i>
                    <span class="ml-15 font-weight-400">ORDER BELUM DIPROSES</span>
                    <div class="content-text text-center mb-0">
                        <span class="font-size-40 font-weight-100">{{ $data['belum_diproses']['data'] }}</span>
                    </div>
                    <a class='float-right' style='text-decoration:none;font-weight:bold;color:white' href='javascript::void(0)' onClick="pageLoad('{{ $url_['belum_diproses'] }}')">Lihat Detail <i class='fa fa-angle-double-right'></i></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 info-panel animation-slide-top" style='animation-delay:300ms'>
            <div class="card card-inverse card-shadow bg-teal-500 white">
                <div class="card-block p-20">
                    <i class="icon fa-cube ml-10 mt-10"></i>
                    <span class="ml-15 font-weight-400">PRODUK TERJUAL</span>
                    <div class="content-text text-center mb-0">
                        <span class="font-size-40 font-weight-100">{{ $data['produk_terjual']['data'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class='row'>
        @if(($ijin->melihatOmset === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner')
        <div class='col-xxl-6 col-xl-12'>
            <div class='panel animation-slide-left' style='animation-delay:100ms'>
                <div class='panel-heading'>
                    <h3 class='panel-title'>Grafik Order dan Produk Terjual Bulan Ini</h3>
                </div>
                <div class='panel-body'>
                    <canvas id="chart-order_dan_produk_bulan_ini" class=''></canvas>
                </div>
            </div>
        </div>
        <div class='col-xxl-6 col-xl-12'>
            <div class='panel animation-slide-right' style='animation-delay:100ms'>
                <div class='panel-heading'>
                    <h3 class='panel-title'>Grafik Gross Profit Bulan Ini</h3>
                </div>
                <div class='panel-body'>
                    <canvas id="chart-gross_profit_bulan_ini" class=''></canvas>
                </div>
            </div>
        </div>
        @else
        <div class='col-xxl-12'>
            <div class='panel animation-slide-left' style='animation-delay:100ms'>
                <div class='panel-heading'>
                    <h3 class='panel-title'>Grafik Order dan Produk Terjual Bulan Ini</h3>
                </div>
                <div class='panel-body'>
                    <canvas id="chart-order_dan_produk_bulan_ini" class=''></canvas>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalFirstSetup" aria-hidden="false" aria-labelledby="modalFirstSetupLabel" role="dialog"
    tabindex="-1">
    <div class="modal-dialog modal-simple modal-lg">
        <form class="modal-content" id="formFirstSetup">
            <div class="modal-header">
                <div class="container">
                    <div class='row'>
                        <div class="col-lg-12">
                            <h4 id="exampleFormModalLabel" class='text-center'>Selamat datang di Olshopedia</h4>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-lg-12">
                            <p class='text-center'>Silahkan isi semua field dibawah ini untuk konfigurasi toko Online Anda</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-5 form-group">
                        <label for="">Nama toko Online / Usaha</label>
                        <input type="text" class="form-control" id="namaToko" name="namaToko" placeholder="Nama Toko" value="{{$store->nama_toko}}">
                        <small id="error_namaToko" style='color:#f2353c;display:none;'>Masukkan Nama Toko Online Anda!</small>
                    </div>
                    <div class="col-lg-7 form-group">
                        <label for="">Subdomain anda <span class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Sudomain untuk toko online anda di Olshopedia"></span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">olshopedia.com/</span>
                            </div>
                        <input type="text" class="form-control" id="subdomainToko" name="subdomainToko" placeholder="Domain" value="{{$store->domain_toko}}">
                        </div>
                        <small id="error_subdomainToko" style='color:#f2353c;display:none;'>Masukkan subdomain Toko Online Anda!</small>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label for="">Nama lengkap</label>
                        <input type="text" class="form-control" id="namaLengkapToko" name="namaLengkapToko" placeholder="Nama Lengkap" value="{{$store->name}}">
                        <small id="error_namaLengkapToko" style='color:#f2353c;display:none;'>Masukkan Nama Lengkap Anda!</small>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label for="">No. Telepon / Handphone</label>
                        <input type="number" class="form-control" id="no_telpToko" name="no_telpToko" placeholder="No. Telepon" value="{{$store->no_telp_toko}}">
                        <small id="error_no_telpToko" style="color:#f2353c; display:none">Masukkan No Telepon dengan benar</small>
                    </div>
                    <div class="col-lg-12 form-group">
                        <label for="">Deskripsi</label>
                        <textarea class="form-control" name="deskripsiToko" id="deskripsiToko" rows="2">{{$store->deskripsi_toko}}</textarea>
                        <small class="text-help">Kosongkan jika tidak ada Keterangan!</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" name='btnSaveFirstSetup'>Simpan</button>
            </div>
        </form>
    </div>
</div>
<!-- End Modal -->
<script>
    $(document).ready(function () {
        var chart_order_dan_produk_bulan_ini = new Chart(document.getElementById('chart-order_dan_produk_bulan_ini').getContext('2d'), {
            type: 'line',
            data: {
                labels: {!! $data['chart_order_dan_produk_bulan_ini']['tgl'] !!},
                datasets: [{
                    label: 'Order',
                    fill: false,
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
					pointRadius: 5,
					pointHoverRadius: 5,
                    data: {!! $data['chart_order_dan_produk_bulan_ini']['order']['data'] !!}
                },{
                    label: 'Produk Terjual',
                    fill: false,
                    backgroundColor: 'rgb(26, 140, 255)',
                    borderColor: 'rgb(26, 140, 255)',
					pointRadius: 5,
					pointHoverRadius: 5,
                    data: {!! $data['chart_order_dan_produk_bulan_ini']['produk']['data'] !!}
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

        @if(($ijin->melihatOmset === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner')
        var chart_gross_profit_bulan_ini = new Chart(document.getElementById('chart-gross_profit_bulan_ini').getContext('2d'), {
            type: 'line',
            data: {
                labels: {!! $data['chart_gross_profit_bulan_ini']['tgl'] !!},
                datasets: [{
                    label: 'Gross Profit',
                    fill: false,
                    backgroundColor: 'rgb(39, 181, 0)',
                    borderColor: 'rgb(39, 181, 0)',
					pointRadius: 5,
					pointHoverRadius: 5,
                    data: {!! $data['chart_gross_profit_bulan_ini']['data'] !!}
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
                }
			}
        });
        @endif



        var namaCache = "{{$store->name}}";
		@if(is_null($store->domain_toko))
            // $('#modalFirstSetup').modal('show');
            $('#modalFirstSetup').modal({backdrop: 'static', keyboard: false})  
		@endif
        
        $('#namaToko').on('input', (e) => {
            if($('#namaToko').hasClass('is-invalid')){
                $('#namaToko').removeClass('is-invalid animation-shake');
                $('small#error_namaToko').hide();
            }
        });

        $('#namaLengkapToko').on('input', (e) => {
            if($('#namaLengkapToko').hasClass('is-invalid')){
                $('#namaLengkapToko').removeClass('is-invalid animation-shake');
                $('small#error_namaLengkapToko').hide();
            }
        });

        $('#no_telpToko').on('input', (e) => {
            if($('#no_telpToko').hasClass('is-invalid')){
                $('#no_telpToko').removeClass('is-invalid animation-shake');
                $('small#error_no_telpToko').hide();
            }
        });

        $("#subdomainToko").on("input", function(){
            this.value = this.value.replace(/[^0-9a-z_]/g, "");
            if($('#subdomainToko').hasClass('is-invalid')){
                $('#subdomainToko').removeClass('is-invalid animation-shake');
                $('small#error_subdomainToko').hide();
            }
        })
        // First setup
        $("button[name=btnSaveFirstSetup]").on('click', function () {
            var namaToko = $('#namaToko').val();
            var subdomainToko = $('#subdomainToko').val();
            var namaLengkap = $('#namaLengkapToko').val();
            var no_telp = $('#no_telpToko').val();
            var deskripsiToko = $('#deskripsiToko').val();
            var error = 0;
            if (namaToko == "") {
                $('#namaToko').addClass('is-invalid animation-shake');
                $('small#error_namaToko').attr('style', 'color:#f2353c;');
                $('small#error_namaToko').show();
                error++;
            }
            if (subdomainToko == "") {
                $('#subdomainToko').addClass('is-invalid animation-shake');
                $('small#error_subdomainToko').attr('style', 'color:#f2353c;');
                $('small#error_subdomainToko').show();
                error++;
            }
            if (namaLengkap == 0) {
                $('#namaLengkapToko').addClass('is-invalid animation-shake');
                $('small#error_namaLengkapToko').attr('style', 'color:#f2353c;');
                $('small#error_namaLengkapToko').show();
                error++;
            }
            if (no_telp == "") {
                $('#no_telpToko').addClass('is-invalid animation-shake');
                $('small#error_no_telpToko').attr('style', 'color:#f2353c;');
                $('small#error_no_telpToko').show();
                error++;
            }
            // if (deskripsiToko == "") {
            //     $('#deskripsiToko').attr('class', 'form-control is-invalid animation-shake');
            //     $('small#error_alamatUser').attr('style', 'color:#f2353c;');
            //     error++;
            // }
            if (error === 0) {
                var hasil = '';
                $.ajax({
                    type: 'post',
                    url: "{{ route('b.setting-proses') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        namaToko: namaToko,
                        subdomainToko: subdomainToko,
                        namaLengkap: namaLengkap,
                        no_telp: no_telp,
                        deskripsiToko: $('#deskripsiToko').val(),
                        dd: "{{ $key['dd'] }}",
                        tt: "{{ $key['tt'] }}"
                    },
                    success: function (data) {
                        hasil = data;
                    },
                    error: function (error, b, c) {
                        swal("Error", '' + c, "error")
                    }
                }).done(function () {
                    $('#modalFirstSetup').modal('hide');
                    if (hasil.status) {
                        swal({
                            title: "Berhasil!",
                            text: "Data berhasil disimpan!",
                            icon: "success"
                        }).then(function (){
                            $(location).attr("href", "{{ route('b.dashboard') }}");
                        });
                    } else {
                        swal({
                            title: "Gagal!",
                            text: "" + hasil.msg,
                            icon: "error"
                        }).then(function (){
                            $(location).attr("href", "{{ route('b.dashboard') }}");
                        });
                    }
                }).fail(function () {
                    $('#modalFirstSetup').modal('hide');
                })
            }
        })
    });
</script>

<!--uiop-->
@endsection