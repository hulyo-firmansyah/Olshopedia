@extends('belakang.index')
@section('isi')
<!--uiop-->
<div class="page-header page-header-bordered">
	<h1 class="page-title font-size-26 font-weight-100">History Order</h1>
	<div class="page-header-actions">
		<ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);" onClick="pageLoad('{{ route('b.dashboard') }}')">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0);" onClick="pageLoad('{{ route('b.customer-index') }}')">Customer</a></li>
			<li class="breadcrumb-item active">History Order</li>
		</ol>
	</div>
</div>
<div class="page-content">
	<div class='container'>
		<div class='row'>
			<div class='col-md-6'>
				<div class="panel animation-slide-left">
					<div class="panel-body">
						<label class='text-muted' style='font-size:15px'>Nama Customer</label><br>
						<span style='font-size:25px;color:black;text-weight:bold'>{{$nama}}</span>
					</div>
				</div>
			</div>
			<div class='col-md-6'>
				<div class="panel animation-slide-right">
					<div class="panel-body">
						<div class="d-flex justify-content-around">
							<div class="p-2 text-center">
								<span style='font-weight:bold;color:black;font-size:25px'>
									@php
										if(count($data_order) == 0){
											echo "0";
										} else {
											echo $data_order->total();
										}
									@endphp
								</span><br>
								<span style='font-size:15px' class='text-muted'>Jumlah Order</span>
							</div>
							<div class="p-2 text-center">
								<span style='font-weight:bold;color:black;font-size:25px'>{{ $jumlah_prod }}</span><br>
								<span style='font-size:15px' class='text-muted'>Jumlah Item Produk</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class='row'>
			<div class='col-md-12'>
				<div class="panel animation-slide-bottom">
					<div class="panel-body">
						<div class='table-responsive'>
							<table class='table table-bordered'>
								<thead>
									<tr>
										<td><b>No</b></td>
										<td><b>Tanggal</b></td>
										<td><b>Order</b></td>
										<td><b>Produk</b></td>
										<td><b>Total Bayar</b></td>
									</tr>
								</thead>
								<tbody>
									@foreach($order as $iD => $vD)
										{!! $vD !!}
									@endforeach
								</tbody>
							</table>
						</div>
						@php
							if(!(count($data_order) == 0)){
								echo "<div class='float-right'>".$data_order->links('vendor.pagination.bootstrap-4')."</div>";
							} 
						@endphp
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
</script>
<!--uiop-->
@endsection