@extends('belakang.index')
@section('isi')
<!--uiop-->
@php
//echo "<pre>".print_r($data, true)."</pre>";
@endphp
<div class="page-header page-header-bordered">
    <div class='row'>
        <div class='col-md-6'>
            <h1 class="page-title font-size-26 font-weight-100">Detail Produk</h1>
        </div>
        <div class='col-md-6'>
            <div class="page-header-actions">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"
                            onClick="pageLoad('{{ route('b.dashboard') }}')">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);"
                            onClick="pageLoad('{{ route('b.produk-index') }}')">Produk</a></li>
                    <li class="breadcrumb-item active">Detail Produk ({{ $data->nama }})</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="page-content">
    <div class='container'>
        <div class="panel animation-slide-top" style='animation-delay:100ms;'>
            <div class="panel-body">
                <div class='row'>
                    <div class='col-md-8'>
                        <h1 style='font-weight:400;color:#555;'>
                            {{ $data->nama }}
                            @if($data->cek["diskon"] == 1)
                                <span class="badge badge-danger badge-round" style='font-size:12px;vertical-align:middle'>Diskon</span>
                            @endif
                            @if(count($data->grosir) > 0)
                                <span class="badge badge-success badge-round" style='font-size:12px;vertical-align:middle'>Grosir</span>
                            @endif
                        </h1>
                        <div>
                            asdasd
                        </div>
                    </div>
                    <div class="col-md-4" style="border-left: 1px solid #ddd;">
						<div class="float-right">
                            <a href="javascript:void(0);" onClick="pageLoad('{{ route('b.produk-edit', ['id_produk' => $data->id_produk ]) }}')" class="btn btn-warning btn-sm">
                                <i class="fa fa-pencil"></i> Edit
                            </a>
                        </div>
						<span><b>Jenis Produk</b></span>
					    <p class="mt-0">
						    <span style='font-weight:bold;color:black'>
                                @if($data->supplier == 0)
                                    Stok Sendiri
                                @else
                                    Supplier Lain
                                @endif
                            </span>
					    </p>
                        <div class='d-flex'>
                            <div>
                                <span><b>Kategori</b></span>
                                <p class="mt-0">
                                    <span style='font-weight:bold;color:black'>{{ $data->kategori }}</span>
                                </p>
                            </div>
                            <div class='ml-30'>
                                <span><b>Berat</b></span>
                                <p class="mt-0">
                                    <span style='font-weight:bold;color:black'>{{ $data->berat }} Gram</span>
                                </p>
                            </div>
                            <div class='ml-30'>
                                <span><b>Total Stok</b></span>
                                <p class="mt-0">
                                    <span style='font-size:25px;color:black'>{{ $data->total_stok }}</span>
                                </p>
                            </div>
                        </div>
				    </div>
                </div>
                <div class='row'>
                    <div class='col-md-12'>
                        <div class='table-responsive'>
                            <table class='table table-hover'>
                                <tbody>
                                    @php
                                        foreach($data->varian as $iV => $vV){
                                            echo "<tr>";
                                            echo "<td><img class='rounded' width='80' height='80' src='".$vV['foto']."'></td>";
                                            echo "<td>".
                                                "<span><b>SKU</b></span>".
                                                "<p class='mt-0'><span style='font-weight:bold;color:black'>".$vV["sku"]."</span></p>".
                                            "</td>";
                                            echo "<td>".
                                                "<span><b>Harga Beli</b></span>".
                                                "<p class='mt-0'><span style='font-weight:bold;color:black'>".$vV["harga_beli"]."</span></p>".
                                            "</td>";
                                            echo "<td>".
                                                "<span><b>Harga Jual</b></span>".
                                                "<p class='mt-0'><span style='font-weight:bold;color:black'>".$vV["harga_jual_normal"]."</span></p>".
                                            "</td>";
                                            echo "<td>".
                                                "<span><b>Harga Reseller</b></span>".
                                                "<p class='mt-0'><span style='font-weight:bold;color:black'>".$vV["harga_jual_reseller"]."</span></p>".
                                            "</td>";
                                            echo "<td>".
                                                "<span><b>Stok</b></span>".
                                                "<p class='mt-0'><span style='font-weight:bold;color:black'>".$vV["stok"]["nilai"]."</span></p>".
                                            "</td>";
                                            echo "</tr>";
                                        }
                                    @endphp
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @if(count($data->grosir) > 0)
                <div class='row' style='margin-top: 30px;'>
                    <div class='col-md-6'>
                        <h4>Harga Grosir</h4>
                        <div class='table-responsive'>
                            <table class='table table-bordered'>
                                <thead>
                                    <tr>
                                        <th>Rentang</th>
                                        <th>Harga Satuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        foreach($data->grosir as $iG => $vG){
                                            echo "<tr>";
                                            echo "<td>".$vG["rentan"]["min"]." -- ".$vG["rentan"]["max"]."</td>";
                                            echo "<td>".$vG["harga"]."</td>";
                                            echo "</tr>";
                                        }
                                    @endphp
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    @foreach($data->varian as $iDv => $vDv)
        $('#stokRiwayat-{{ $vDv["id_varian"] }}').tooltip({
            trigger: 'hover',
            title: 'Lihat Riwayat Stok',
            placement: 'left'
        });
    @endforeach
});
</script>
<!--uiop-->
@endsection