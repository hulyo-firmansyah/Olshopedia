@extends('belakang.index')
@section('isi')
<!--uiop-->
<style>
.ui-helper-hidden {
    display: none;
}

.ui-helper-hidden-accessible {
    position: absolute !important;
    clip: rect(1px 1px 1px 1px);
    clip: rect(1px, 1px, 1px, 1px);
}

.ui-helper-reset {
    margin: 0;
    padding: 0;
    border: 0;
    outline: 0;
    line-height: 1.3;
    text-decoration: none;
    font-size: 100%;
    list-style: none;
}

.ui-helper-clearfix:before,
.ui-helper-clearfix:after {
    content: "";
    display: table;
}

.ui-helper-clearfix:after {
    clear: both;
}

.ui-helper-clearfix {
    zoom: 1;
}

.ui-helper-zfix {
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    position: absolute;
    opacity: 0;
    filter: Alpha(Opacity=0);
}


/* Interaction Cues
----------------------------------*/
.ui-state-disabled {
    cursor: default !important;
}


/* Icons
----------------------------------*/

/* states and images */
.ui-icon {
    display: block;
    text-indent: -99999px;
    overflow: hidden;
    background-repeat: no-repeat;
}


/* Misc visuals
----------------------------------*/

/* Overlays */
.ui-widget-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

/* IE/Win - Fix animation bug - #4615 */
.ui-accordion {
    width: 100%;
}

.ui-accordion .ui-accordion-header {
    cursor: pointer;
    position: relative;
    margin-top: 1px;
    zoom: 1;
}

.ui-accordion .ui-accordion-li-fix {
    display: inline;
}

.ui-accordion .ui-accordion-header-active {
    border-bottom: 0 !important;
}

.ui-accordion .ui-accordion-header a {
    display: block;
    font-size: 1em;
    padding: .5em .5em .5em .7em;
}

.ui-accordion-icons .ui-accordion-header a {
    padding-left: 2.2em;
}

.ui-accordion .ui-accordion-header .ui-icon {
    position: absolute;
    left: .5em;
    top: 50%;
    margin-top: -8px;
}

.ui-accordion .ui-accordion-content {
    padding: 1em 2.2em;
    border-top: 0;
    margin-top: -2px;
    position: relative;
    top: 1px;
    margin-bottom: 2px;
    overflow: auto;
    display: none;
    zoom: 1;
}

.ui-accordion .ui-accordion-content-active {
    display: block;
}

.ui-autocomplete {
    position: absolute;
    cursor: default;
    width: 100px;
    overflow-y: auto;
    overflow-x: hidden;
    max-height: 350px;
}

/* workarounds */
* html .ui-autocomplete {
    width: 1px;
}

/* without this, the menu expands to 100% in IE6 */

/*
 * jQuery UI Menu 1.8.23
 *
 * Copyright 2010, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Menu#theming
 */
.ui-menu {
    list-style: none;
    padding: 2px;
    margin: 0;
    display: block;
    float: left;
    border-radius: 5px;
}

.ui-menu .ui-menu {
    margin-top: -3px;
}

.ui-menu .ui-menu-item {
    margin: 0;
    padding: 1px;
    zoom: 1;
    float: left;
    clear: left;
    width: 100%;
    border-bottom: 1px solid #e3e3e3;
}

.ui-menu .ui-menu-item div {
    text-decoration: none;
    display: block;
    padding: .2em .4em;
    line-height: 1.5;
    zoom: 1;
}

.ui-menu-item .ui-menu-item-wrapper.ui-state-active {
    background: #e3e3e3 !important;
    border: 1px solid #e3e3e3;
    color: black;
}

.ui-menu .ui-menu-item div.ui-state-hover,
.ui-menu .ui-menu-item div.ui-state-active {
    font-weight: normal;
    margin: -1px;
}


</style>
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
                        <label for="namaToko" style='font-weight:500'>Nama Toko Online / Usaha</label>
                        <input type="text" class="form-control" id="namaToko" name="namaToko" placeholder="Nama Toko" value="{{$store->nama_toko}}">
                        <small id="error_namaToko" style='color:#f2353c;display:none;'>Masukkan Nama Toko Online Anda!</small>
                    </div>
                    <div class="col-lg-7 form-group">
                        <label for="subdomainToko" style='font-weight:500'>Subdomain anda <span class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Sudomain untuk toko online anda di Olshopedia"></span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">app.olshopedia.com/</span>
                            </div>
                        <input type="text" class="form-control" id="subdomainToko" name="subdomainToko" placeholder="Domain" value="{{$store->domain_toko}}">
                        </div>
                        <small id="error_subdomainToko" style='color:#f2353c;display:none;'>Masukkan subdomain Toko Online Anda!</small>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label for="namaLengkap" style='font-weight:500'>Nama lengkap anda</label>
                        <input type="text" class="form-control" id="namaLengkap" name="namaLengkap" placeholder="Nama Lengkap" value="{{$store->name}}">
                        <small id="error_namaLengkap" style='color:#f2353c;display:none;'>Masukkan Nama Lengkap Anda!</small>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label for="no_telpToko" style='font-weight:500'>No. Telepon Toko</label>
                        <input type="number" class="form-control" id="no_telpToko" name="no_telpToko" placeholder="No. Telepon" value="{{$store->no_telp_toko}}">
                        <small id="error_no_telpToko" style="color:#f2353c; display:none">Masukkan No Telepon dengan benar!</small>
                    </div>
                    <div class='col-md-4 form-group'>
                        <label for="alamatToko" style='font-weight:500'>Alamat Kecamatan Toko</label>
                        <div class="input-search">
                            <a href='javascript:void(0)' class="input-search-btn" style='margin-top:8px;color:#76838f;cursor:default;' id='iconKecamatanCari'>
                                <i class="icon wb-search" aria-hidden="true"></i>
                            </a>
                            <input id="kecamatanCari" name='kecamatan' class="ui-autocomplete-input form-control" type="text"
                                maxlength="100" acceskey="k" autocomplete="off" placeholder="Kecamatan"
                                role="textbox" aria-autocomplete="list" aria-haspopup="true" style='border-radius:inherit;'>
                        </div>
                        <div id='hasilKecamatanCari' style='display:none;border:1px solid #e4eaec;padding:10px' onMouseOver='pilihover()' onMouseOut='pilihout()'></div> 
                        <small id='error_kecamatanCari' class='hidden' style='color:red;'>Tidak ditemukan!</small>
                    </div>
                    <div class='col-md-8 form-group'>
                        <label for="alamatToko" style='font-weight:500'>Alamat Lengkap Toko</label>
                        <textarea class="form-control" id="alamatToko" name="alamatToko"
                            rows="3" placeholder="Alamat Lengkap"></textarea>
                        <small id='error_alamatToko' class='hidden' style='color:red;'>Silahkan isi Alamat Lengkap terlebih dahulu!</small>
                    </div>
                    <div class="col-lg-12 form-group">
                        <label for="deskripsiToko" style='font-weight:500'>Deskripsi Toko</label>
                        <textarea class="form-control" name="deskripsiToko" id="deskripsiToko" rows="2"></textarea>
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
var tampilPilih = false,
    kecamatanCari = '',
    cacheKecamatanCari = {};


function pilihover() {
    if (!tampilPilih) {
        if (!$('#editKecamatanCari').length)
            $('#hasilKecamatanCari').append(
                '<div id="editKecamatanCari" style="color:#eb6709;display:inline-block;position:absolute;right:50px;"><div>Edit</div></div>'
            );
        $('#hasilKecamatanCari').css({
            'border': '1px solid #eb6709',
            'padding': '10px',
            'cursor': 'pointer'
        });
        tampilPilih = true;
    }
}

function pilihout() {
    if (tampilPilih) {
        if ($('#editKecamatanCari').length)
            $('#editKecamatanCari').remove();
        $('#hasilKecamatanCari').css({
            'border': '1px solid #e4eaec',
            'padding': '10px',
            'cursor': 'default'
        });
        tampilPilih = false;
    }
}
    $(document).ready(function () {
        $("input#kecamatanCari").autocomplete({
            minLength: 3,
            source: function(request, response) {
                // console.log('a');
                $('.ui-autocomplete').appendTo($('#formFirstSetup'));
                var term = request.term;
                if (term in cacheKecamatanCari) {
                    $("#iconKecamatanCari").html("<div class='loader vertical-align-middle loader-rotate-plane' style='height:20px;width:20px'></div>");
                    response(cacheKecamatanCari[term]);
                    $("#iconKecamatanCari").html('<i class="icon wb-search" aria-hidden="true"></i>');
                    if(cacheKecamatanCari[term].length > 0){
                        $("#error_kecamatanCari").hide();
                    } else {
                        $("#error_kecamatanCari").show();
                        $("#error_kecamatanCari").text('Tidak Ditemukan!');
                    }
                    return;
                }

                $.ajax({
                    url: "{{ route('b.ajax-cariKecamatan') }}",
                    type: 'get',
                    dataType: "json",
                    data: request,
                    success: function(data) {
                        cacheKecamatanCari[term] = data;
                        response(data);
                        $("#iconKecamatanCari").html('<i class="icon wb-search" aria-hidden="true"></i>');
                        if(data.length > 0){
                            $("#error_kecamatanCari").hide();
                        } else {
                            $("#error_kecamatanCari").show();
                            $("#error_kecamatanCari").text('Tidak Ditemukan!');
                        }
                    },
                    beforeSend: function(){
                        $("#iconKecamatanCari").html("<div class='loader vertical-align-middle loader-rotate-plane' style='height:20px;width:20px'></div>");
                    },
                });
            },
            open: function(e, ui) {
                var acData = $(this).data('uiAutocomplete');
                acData.menu.element.find('div').each(function() {
                    var me = $(this);
                    var t = me.text();
                    me.html('');
                    me.html(t);
                });
            },
            select: function(event, ui) {
                var hasil = ui.item.label;
                $('#hasilKecamatanCari').html(hasil);
                $('#hasilKecamatanCari').show();
                $('#iconKecamatanCari').hide();
                $(this).hide();
                kecamatanCari = ui.item.label;
            }
        });

        $('#kecamatanCari').on('input', function(){
            if($('#error_kecamatanCari').is(':visible')){
                $('#error_kecamatanCari').hide();
            }
            if($(this).hasClass('is-invalid')){
                $(this).removeClass('is-invalid animation-shake');
            }
        })

        $('#hasilKecamatanCari').click(function() {
            $(this).hide();
            $('#hasilKecamatanCari').text('');
            $('input#kecamatanCari').show();
            $('#iconKecamatanCari').show();
            $('input#kecamatanCari').val(kecamatanCari);
        });
    
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

        $('#namaLengkap').on('input', (e) => {
            if($('#namaLengkap').hasClass('is-invalid')){
                $('#namaLengkap').removeClass('is-invalid animation-shake');
                $('small#error_namaLengkap').hide();
            }
        });

        $('#no_telpToko').on('input', (e) => {
            if($('#no_telpToko').hasClass('is-invalid')){
                $('#no_telpToko').removeClass('is-invalid animation-shake');
                $('small#error_no_telpToko').hide();
            }
        });

        $('#alamatToko').on('input', (e) => {
            if($('#alamatToko').hasClass('is-invalid')){
                $('#alamatToko').removeClass('is-invalid animation-shake');
                $('small#error_alamatToko').hide();
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
            var namaLengkap = $('#namaLengkap').val();
            var no_telpToko = $('#no_telpToko').val();
            var deskripsiToko = $('#deskripsiToko').val();
            var alamatToko = $('#alamatToko').val();
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
                $('#namaLengkap').addClass('is-invalid animation-shake');
                $('small#error_namaLengkap').attr('style', 'color:#f2353c;');
                $('small#error_namaLengkap').show();
                error++;
            }
            if (no_telpToko == "") {
                $('#no_telpToko').addClass('is-invalid animation-shake');
                $('small#error_no_telpToko').attr('style', 'color:#f2353c;');
                $('small#error_no_telpToko').show();
                error++;
            }
            if (alamatToko == "") {
                $('#alamatToko').addClass('is-invalid animation-shake');
                $('small#error_alamatToko').attr('style', 'color:#f2353c;');
                $('small#error_alamatToko').show();
                error++;
            }
            let regexKecamatan = /[0-9]{1,2}\|[0-9]{1,3}\|[0-9]{1,5}/gi;
            if($('#kecamatanCari').is(':visible') || $('#hasilKecamatanCari').text() === '' || $('#kecamatanCari').val().match(regexKecamatan) === null){
                $('#kecamatanCari').addClass('is-invalid animation-shake');
                $("#error_kecamatanCari").text('Silahakan pilih Kecamatan terlebih dahulu!');
                $("#error_kecamatanCari").show();
                error++;
            }
            // return;
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
                        no_telpToko: no_telpToko,
                        alamatToko: alamatToko,
                        kecamatan: $('#kecamatanCari').val(),
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