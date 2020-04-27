@extends('belakang.index')
@section('isi')
<!--uiop-->
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="page-header page-header-bordered">
	<h1 class="page-title font-size-26 font-weight-100">Customer</h1>
	<div class="page-header-actions">
		<ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);" onClick="pageLoad('{{ route('b.dashboard') }}')">Dashboard</a></li>
			<li class="breadcrumb-item active">Customer</li>
		</ol>
	</div>
</div>
<div class="page-content">
	<div class="panel animation-slide-top">
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-4">
					<div class="form-group form-style form-inline">
						<button class="btn btn-success" data-target="#modTambah" data-toggle="modal" type="button"><i class='fa fa-plus'></i> Tambah Customer Baru</button>
                        @if(($ijin->downloadExcel === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner')
                        <div class="dropdown btn-group mr-5">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Menu</button>
                            <div class="dropdown-menu" aria-labelledby="exampleColorDropdown1" role="menu">
                                <a class="dropdown-item" href="{{ route('b.excel-export-customer', ['format' => 'xlsx']) }}"><i class='wb-download'></i> Download Excel File (.xlsx)</a>
                                <a class="dropdown-item" href="{{ route('b.excel-export-customer', ['format' => 'xls']) }}"><i class='wb-download'></i> Download Excel File (.xls)</a>
                                <a class="dropdown-item" href="{{ route('b.excel-export-customer', ['format' => 'csv']) }}"><i class='wb-download'></i> Download Excel File (.csv)</a>
                            </div>
                        </div>
						@endif
					</div>
				</div>
			</div>
			<div class="col-lg-12 form-group">
				<div class="table-responsive">
					<table class="table table-hover table-striped w-full" id="table_customer">
						<thead>
							<tr>
								<th width="5%">No</th>
								<th width="30%">Nama Customer</th>
								<th width="10%">Kategori</th>
								<th width="10%">No Telp</th>
								<th width="30%">Alamat</th>
								<th width="15%"><span class="site-menu-icon md-settings"></span></th>
							</tr>
						</thead>
						<tbody id="isiTabel">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- modal tambah customer -->
<div class="modal fade modal-fade-in-scale-up" id="modTambah" aria-hidden="true" aria-labelledby="exampleModalTitle"
    role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple" style='max-width:800px;'>
        <div class="modal-content" style='width:800px;'>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTitle">Tambah Customer</h4>
            </div>
            <div class="modal-body">
                <form id="form_customer">
                    <div class='row'>
                        <div class="col-md-4 form-group">
                            <label>Kategori Customer</label>
                            <select name='kategoriC' class='form-control' id='kategoriC'>
                                <option value='Customer'>Customer</option>
                                <option value='Reseller'>Reseller</option>
                                <option value='Dropshipper'>Dropshipper</option>
                            </select>
                        </div>
                        <div class="col-md-8 form-group">
                            <label>Nama Lengkap</label>
                            <input type='text' name='namaC' class='form-control' id='namaC'>
                            <small id="error_namaC" class='hidden'></small>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-md-6 form-group">
                            <label>Email</label>
                            <input type='email' name='emailC' class='form-control' id='emailC'>
                            <small id="error_emailC" class='hidden'></small>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Password</label>
                            <div class="input-search">
                                <button type="button" style="height:40px;cursor:pointer" class="input-search-btn" id='btnEye' tabindex='-1'><i class="icon md-eye-off" aria-hidden="true"></i></button>
                                <!-- <input type='text' name='passwordC' class='form-control' id='passwordC' placeholder="Password" value='{{$pass}}' autocomplete="on" style='border-radius:unset'> -->
                                <input type='text' name='passwordC' class='form-control' id='passwordC' placeholder="Password" value='' autocomplete="on" style='border-radius:unset'>
                                <small id="error_passwordC" class="hidden"></small>
                            </div>
                            <!-- <div class='input-group'>
                                <input type='text' name='passwordC' class='form-control' id='passwordC'
                                    value='{{$pass}}' readOnly>
                                <div class='input-group-append'>
                                    <button type='button' onClick='copyToClipboard($("#passwordC"))'
                                        style='cursor:pointer' class='input-group-text'>Copy</button>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-md-4 form-group">
                            <label>Provinsi</label>
                            <select name='provinsiC' class='form-control' id='provinsiC'>
                                <option value='' disabled selected>-- Pilih Provinsi --</option>
                                @php
                                $wilayah = json_decode($wilayah_indonesia);
                                foreach($wilayah as $w){
                                echo "<option value='".$w->provinsi."'>".$w->provinsi."</option>";
                                }
                                @endphp
                            </select>
                            <small id="error_provinsiC" class='hidden'></small>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Kabupaten/Kota</label>
                            <select name='kabupatenC' class='form-control' id='kabupatenC'>
                                <option value='' disabled selected>-- Pilih Kabupaten --</option>
                                @php
                                $wilayah = json_decode($wilayah_indonesia);
                                foreach($wilayah as $w){
                                foreach($w->kabupaten as $k){
                                echo "<option value='".$k->type." ".$k->kabupaten_nama."'>".$k->type."
                                    ".$k->kabupaten_nama."</option>";
                                }
                                }
                                @endphp
                            </select>
                            <small id="error_kabupatenC" class='hidden'></small>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Kecamatan</label>
                            <select name='kecamatanC' class='form-control' id='kecamatanC'>
                                <option value='' disabled selected>-- Pilih Kecamatan --</option>
                            </select>
                            <small id="error_kecamatanC" class='hidden'></small>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-md-4 form-group">
                            <label>Kode Pos</label>
                            <input type='text' name='kode_posC' class='form-control' id='kode_posC'>
                            <small id="error_kode_posC" class='hidden'></small>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>No telepon</label>
                            <div class='input-group'>
                                <div class='input-group-prepend'>
                                    <span class='input-group-text'><i class='glyphicon glyphicon-earphone'></i></span>
                                </div>
                                <input type='text' name='no_telpC' class='form-control' id='no_telpC'>
                            </div>
                            <small id="error_no_telpC" class='hidden'></small>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-md-12 form-group">
                            <label>Alamat</label>
                            <textarea name='alamatC' id='alamatC' class='form-control'></textarea>
                            <small id="error_alamatC" class='hidden'></small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-primary" value='Tambah' name='btnTambah' id='btnTambah'>
                <button class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- modal edit customer -->
<div class="modal fade modal-fade-in-scale-up" id="modEdit" aria-hidden="true" aria-labelledby="exampleModalTitle"
    role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple" style='max-width:800px;'>
        <div class="modal-content" style='width:800px;'>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTitle">Edit Customer</h4>
            </div>
            <div class="modal-body">
                <form id="form_customer_edit">
                    <div class='row'>
                        <div class="col-md-4 form-group">
                            <label>Kategori Customer</label>
							<input name='id_cust' id='id_cust' class='hidden'>
                            <select name='kategoriC_edit' class='form-control' id='kategoriC_edit'>
                                <option value='Customer'>Customer</option>
                                <option value='Reseller'>Reseller</option>
                                <option value='Dropshipper'>Dropshipper</option>
                            </select>
                        </div>
                        <div class="col-md-8 form-group">
                            <label>Nama Lengkap</label>
                            <input type='text' name='namaC_edit' class='form-control' id='namaC_edit'>
                            <small id="error_namaC_edit" class='hidden'></small>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-md-12 form-group">
                            <label>Email</label>
                            <input type='email' name='emailC_edit' class='form-control' id='emailC_edit'>
                            <small id="error_emailC_edit" class='hidden'></small>
                        </div>
                        <!-- <div class="col-md-6 form-group">
                            <label>Password</label>
                            <div class='input-group'>
                                <input type='text' name='passwordC_edit' class='form-control' id='passwordC_edit'
                                    value='{{$pass}}' readOnly>
                                <div class='input-group-append'>
                                    <button type='button' onClick='copyToClipboard($("#passwordC"))'
                                        style='cursor:pointer' class='input-group-text'>Copy</button>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class='row'>
                        <div class="col-md-4 form-group">
                            <label>Provinsi</label>
                            <select name='provinsiC_edit' class='form-control' id='provinsiC_edit'>
                                <option value='' disabled selected>-- Pilih Provinsi --</option>
                                @php
                                $wilayah = json_decode($wilayah_indonesia);
                                foreach($wilayah as $w){
                                echo "<option value='".$w->provinsi."'>".$w->provinsi."</option>";
                                }
                                @endphp
                            </select>
                            <small id="error_provinsiC_edit" class='hidden'></small>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Kabupaten/Kota</label>
                            <select name='kabupatenC_edit' class='form-control' id='kabupatenC_edit'>
                                <option value='' disabled selected>-- Pilih Kabupaten --</option>
                                @php
                                $wilayah = json_decode($wilayah_indonesia);
                                foreach($wilayah as $w){
                                foreach($w->kabupaten as $k){
                                echo "<option value='".$k->type." ".$k->kabupaten_nama."'>".$k->type."
                                    ".$k->kabupaten_nama."</option>";
                                }
                                }
                                @endphp
                            </select>
                            <small id="error_kabupatenC_edit" class='hidden'></small>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Kecamatan</label>
                            <select name='kecamatanC_edit' class='form-control' id='kecamatanC_edit'>
                                <option value='' disabled selected>-- Pilih Kecamatan --</option>
                            </select>
                            <small id="error_kecamatanC_edit" class='hidden'></small>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-md-4 form-group">
                            <label>Kode Pos</label>
                            <input type='text' name='kode_posC_edit' class='form-control' id='kode_posC_edit'>
                            <small id="error_kode_posC_edit" class='hidden'></small>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>No telepon</label>
                            <div class='input-group'>
                                <div class='input-group-prepend'>
                                    <span class='input-group-text'><i class='glyphicon glyphicon-earphone'></i></span>
                                </div>
                                <input type='text' name='no_telpC_edit' class='form-control' id='no_telpC_edit'>
                            </div>
                            <small id="error_no_telpC_edit" class='hidden'></small>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-md-12 form-group">
                            <label>Alamat</label>
                            <textarea name='alamatC_edit' id='alamatC_edit' class='form-control'></textarea>
                            <small id="error_alamatC_edit" class='hidden'></small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-warning" value='Edit' name='btnEdit' id='btnEdit'>
                <button class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<script>
	var tabelData;
	var cacheKabupaten = {},
		cacheKecamatan = {},
		cacheKecamatan_Kabupaten = {};
	var cacheProvinsiAll = [];

	function copyToClipboard(copyText) {
		copyText.select();
		document.execCommand("copy");
	}

	function hapusIsi(tipe = false) {
		if(!tipe){
			$('#error_namaC').html(" ");
			$('#error_namaC').hide();
			$('#error_emailC').html(" ");
			$('#error_emailC').hide();
			$('#error_provinsiC').html(" ");
			$('#error_provinsiC').hide();
			$('#error_kabupatenC').html(" ");
			$('#error_kabupatenC').hide();
			$('#error_kecamatanC').html(" ");
			$('#error_kecamatanC').hide();
			$('#error_kode_posC').html(" ");
			$('#error_kode_posC').hide();
			$('#error_no_telpC').html(" ");
			$('#error_no_telpC').hide();
			$('#error_alamatC').html(" ");
			$('#error_alamatC').hide();
			$('#namaC').removeClass("animation-shake");
			$('#namaC').removeClass("is-invalid");
			$('small#error_passwordC').hide();
			$('#passwordC').removeClass('is-invalid animation-shake');
			$('#namaC').val("");
			$('#emailC').removeClass("animation-shake");
			$('#emailC').removeClass("is-invalid");
			$('#emailC').val("");
			$('#provinsiC').parent().children('button').removeClass("animation-shake");
			$('#provinsiC').selectpicker('val', '');
			$('#kabupatenC').parent().children('button').removeClass("animation-shake");
			$('#kabupatenC').selectpicker('val', '');
			$('#kecamatanC').parent().children('button').removeClass("animation-shake");
			$('#kecamatanC').selectpicker('val', '');
			$('#kode_posC').removeClass("animation-shake");
			$('#kode_posC').removeClass("is-invalid");
			$('#kode_posC').val("");
			$('#no_telpC').removeClass("animation-shake");
			$('#no_telpC').removeClass("is-invalid");
			$('#no_telpC').val("");
			$('#alamatC').removeClass("animation-shake");
			$('#alamatC').removeClass("is-invalid");
			$('#alamatC').val("");
		} else {
			$('#error_namaC_edit').html(" ");
			$('#error_namaC_edit').hide();
			$('#error_emailC_edit').html(" ");
			$('#error_emailC_edit').hide();
			$('#error_provinsiC_edit').html(" ");
			$('#error_provinsiC_edit').hide();
			$('#error_kabupatenC_edit').html(" ");
			$('#error_kabupatenC_edit').hide();
			$('#error_kecamatanC_edit').html(" ");
			$('#error_kecamatanC_edit').hide();
			$('#error_kode_posC_edit').html(" ");
			$('#error_kode_posC_edit').hide();
			$('#error_no_telpC_edit').html(" ");
			$('#error_no_telpC_edit').hide();
			$('#error_alamatC_edit').html(" ");
			$('#error_alamatC_edit').hide();
			$('#namaC_edit').removeClass("animation-shake");
			$('#namaC_edit').removeClass("is-invalid");
			$('#namaC_edit').val("");
			$('#emailC_edit').removeClass("animation-shake");
			$('#emailC_edit').removeClass("is-invalid");
			$('#emailC_edit').val("");
			$('#provinsiC_edit').parent().children('button').removeClass("animation-shake");
			$('#provinsiC_edit').selectpicker('val', '');
			$('#kabupatenC_edit').parent().children('button').removeClass("animation-shake");
			$('#kabupatenC_edit').selectpicker('val', '');
			$('#kecamatanC_edit').parent().children('button').removeClass("animation-shake");
			$('#kecamatanC_edit').selectpicker('val', '');
			$('#kode_posC_edit').removeClass("animation-shake");
			$('#kode_posC_edit').removeClass("is-invalid");
			$('#kode_posC_edit').val("");
			$('#no_telpC_edit').removeClass("animation-shake");
			$('#no_telpC_edit').removeClass("is-invalid");
			$('#no_telpC_edit').val("");
			$('#alamatC_edit').removeClass("animation-shake");
			$('#alamatC_edit').removeClass("is-invalid");
			$('#alamatC_edit').val("");
		}
	}

	
	$(document).ready(function() {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		tabelData = $('#table_customer').DataTable({
			ajax: {
				type: 'get',
				url: "{{ route('b.customer-getData') }}",
			}
		});

		
		$('#passwordC').password({
			animate: false,
			minimumLength: 0,
			enterPass: '',
			badPass: '<span class="red-800 font-size-14">The password is weak</span>',
			goodPass: '<span class="yellow-800 font-size-14">Good password</span>',
			strongPass: '<span class="green-700 font-size-14">Strong password</span>',
			shortPass: ''
		});

        $('#btnEye').click(function(){
            if($('#passwordC').attr('type') == 'password'){
                $('#passwordC').attr('type', 'text');
                $('#btnEye').children().attr('class', 'icon md-eye-off');
            } else if($('#passwordC').attr('type') == 'text'){
                $('#passwordC').attr('type', 'password');
                $('#btnEye').children().attr('class', 'icon md-eye');
            }
        });

		
		$('#namaC').on('input', function(){
			if($('small#error_namaC').is(':visible')){
				$('small#error_namaC').hide();
				$('#namaC').removeClass('is-invalid animation-shake');
			}
		});
		
		$('#emailC').on('input', function(){
			if($('small#error_emailC').is(':visible')){
				$('small#error_emailC').hide();
				$('#emailC').removeClass('is-invalid animation-shake');
			}
		});
		
		$('#passwordC').on('input', function(){
			if($('small#error_passwordC').is(':visible')){
				$('small#error_passwordC').hide();
				$('#passwordC').removeClass('is-invalid animation-shake');
			}
		});
		
		$('#kode_posC').on('input', function(){
			if($('small#error_kode_posC').is(':visible')){
				$('small#error_kode_posC').hide();
				$('#kode_posC').removeClass('is-invalid animation-shake');
			}
		});
		
		$('#no_telpC').on('input', function(){
			if($('small#error_no_telpC').is(':visible')){
				$('small#error_no_telpC').hide();
				$('#no_telpC').removeClass('is-invalid animation-shake');
			}
		});
		
		$('#alamatC').on('input', function(){
			if($('small#error_alamatC').is(':visible')){
				$('small#error_alamatC').hide();
				$('#alamatC').removeClass('is-invalid animation-shake');
			}
		});
		
		$('#namaC_edit').on('input', function(){
			if($('small#error_namaC_edit').is(':visible')){
				$('small#error_namaC_edit').hide();
				$('#namaC_edit').removeClass('is-invalid animation-shake');
			}
		});
		
		$('#emailC_edit').on('input', function(){
			if($('small#error_emailC_edit').is(':visible')){
				$('small#error_emailC_edit').hide();
				$('#emailC_edit').removeClass('is-invalid animation-shake');
			}
		});
		
		$('#kode_posC_edit').on('input', function(){
			if($('small#error_kode_posC_edit').is(':visible')){
				$('small#error_kode_posC_edit').hide();
				$('#kode_posC_edit').removeClass('is-invalid animation-shake');
			}
		});
		
		$('#no_telpC_edit').on('input', function(){
			if($('small#error_no_telpC_edit').is(':visible')){
				$('small#error_no_telpC_edit').hide();
				$('#no_telpC_edit').removeClass('is-invalid animation-shake');
			}
		});
		
		$('#alamatC_edit').on('input', function(){
			if($('small#error_alamatC_edit').is(':visible')){
				$('small#error_alamatC_edit').hide();
				$('#alamatC_edit').removeClass('is-invalid animation-shake');
			}
		});
		
		$('#kategoriC').selectpicker({
			style: 'btn-outline btn-default'
		});
		$('#provinsiC').selectpicker({
			liveSearch: true,
			style: 'btn-outline btn-default'
		});
		$('#kecamatanC').selectpicker({
			liveSearch: true,
			style: 'btn-outline btn-default'
		});
		$('#kabupatenC').selectpicker({
			liveSearch: true,
			style: 'btn-outline btn-default'
		});
		
		$('#kategoriC_edit').selectpicker({
			style: 'btn-outline btn-default'
		});
		$('#provinsiC_edit').selectpicker({
			liveSearch: true,
			style: 'btn-outline btn-default'
		});
		$('#kecamatanC_edit').selectpicker({
			liveSearch: true,
			style: 'btn-outline btn-default'
		});
		$('#kabupatenC_edit').selectpicker({
			liveSearch: true,
			style: 'btn-outline btn-default'
		});

		$('#provinsiC').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
			$('#provinsiC').selectpicker('setStyle', 'animation-shake', 'remove');
			if (!$('#error_provinsiC').is(':hidden')) $('#error_provinsiC').hide();
			var val = $(this).val();
			$('#kabupatenC').html(
				'<option value="" disabled selected>-- Pilih Kabupaten --</option>');
			var term = val.replace(/[^a-zA-Z]/gi, '');
			if(term in cacheKabupaten){
				$.each(cacheKabupaten[term], function(i2, v2) {
					$('#kabupatenC').append("<option value='" + v2.type + " " + v2
						.kabupaten_nama + "'>" + v2.type + " " + v2
						.kabupaten_nama + "</option>");
				});
				$('#kabupatenC').selectpicker('refresh');
			} else {
				$.ajax({
					url: "{{ route('b.ajax-getWilayah') }}",
					type: 'get',
					data: {
						term: val
					},
					dataType: 'json',
					success: function(data) {
                    	cacheKabupaten[term] = data;
						$.each(data, function(i2, v2) {
							$('#kabupatenC').append("<option value='" + v2.type + " " + v2
								.kabupaten_nama + "'>" + v2.type + " " + v2
								.kabupaten_nama + "</option>");
						});
						$('#kabupatenC').selectpicker('refresh');
					}
				});
			}
			var term2 = term+"1";
			$('#kecamatanC').html(
				'<option value="" disabled selected>-- Pilih Kecamatan --</option>');
			if(term2 in cacheKecamatan){
				$.each(cacheKecamatan[term2], function(i3, v3) {
					$('#kecamatanC').append("<option value='" + v3.kecamatan.nama +
						"'>" + v3.kecamatan.nama + "</option>");
				});
				$('#kecamatanC').selectpicker('refresh');
			} else {
				$.ajax({
					url: "{{ route('b.ajax-getWilayahDetail') }}",
					type: 'get',
					data: {
						term: val,
						tipe: "1"
					},
					dataType: 'json',
					success: function(data) {
						cacheKecamatan[term2] = data;
						$.each(data, function(i3, v3) {
							$('#kecamatanC').append("<option value='" + v3.kecamatan.nama +
								"'>" + v3.kecamatan.nama + "</option>");
						});
						$('#kecamatanC').selectpicker('refresh');
					}
				});
			}
			if (!$('#error_kabupatenC').is(':hidden')) $('#error_kabupatenC').hide();
			if (!$('#error_kecamatanC').is(':hidden')) $('#error_kecamatanC').hide();
		});

		$('#provinsiC_edit').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
			$('#provinsiC_edit').selectpicker('setStyle', 'animation-shake', 'remove');
			if (!$('#error_provinsiC_edit').is(':hidden')) $('#error_provinsiC_edit').hide();
			var val = $(this).val();
			$('#kabupatenC_edit').html(
				'<option value="" disabled selected>-- Pilih Kabupaten --</option>');
			var term = val.replace(/[^a-zA-Z]/gi, '');
			if(term in cacheKabupaten){
				$.each(cacheKabupaten[term], function(i2, v2) {
					$('#kabupatenC_edit').append("<option value='" + v2.type + " " + v2
						.kabupaten_nama + "'>" + v2.type + " " + v2
						.kabupaten_nama + "</option>");
				});
				$('#kabupatenC_edit').selectpicker('refresh');
			} else {
				$.ajax({
					url: "{{ route('b.ajax-getWilayah') }}",
					type: 'get',
					data: {
						term: val
					},
					dataType: 'json',
					success: function(data) {
                    	cacheKabupaten[term] = data;
						$.each(data, function(i2, v2) {
							$('#kabupatenC_edit').append("<option value='" + v2.type + " " + v2
								.kabupaten_nama + "'>" + v2.type + " " + v2
								.kabupaten_nama + "</option>");
						});
						$('#kabupatenC_edit').selectpicker('refresh');
					}
				});
			}
			var term2 = term+"1";
			$('#kecamatanC_edit').html(
				'<option value="" disabled selected>-- Pilih Kecamatan --</option>');
			if(term2 in cacheKecamatan){
				$.each(cacheKecamatan[term2], function(i3, v3) {
					$('#kecamatanC_edit').append("<option value='" + v3.kecamatan.nama +
						"'>" + v3.kecamatan.nama + "</option>");
				});
				$('#kecamatanC_edit').selectpicker('refresh');
			} else {
				$.ajax({
					url: "{{ route('b.ajax-getWilayahDetail') }}",
					type: 'get',
					data: {
						term: val,
						tipe: "1"
					},
					dataType: 'json',
					success: function(data) {
						cacheKecamatan[term2] = data;
						$.each(data, function(i3, v3) {
							$('#kecamatanC_edit').append("<option value='" + v3.kecamatan.nama +
								"'>" + v3.kecamatan.nama + "</option>");
						});
						$('#kecamatanC_edit').selectpicker('refresh');
					}
				});
			}
			if (!$('#error_kabupatenC_edit').is(':hidden')) $('#error_kabupatenC_edit').hide();
			if (!$('#error_kecamatanC_edit').is(':hidden')) $('#error_kecamatanC_edit').hide();
		});

		$('#kabupatenC').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
			$('#kabupatenC').selectpicker('setStyle', 'animation-shake', 'remove');
			if (!$('#error_kabupatenC').is(':hidden')) $('#error_kabupatenC').hide();
			var pilihKab = $(this).val();
			var provinsiPilih = '';
			var term = pilihKab.replace(/[^a-zA-Z]/gi, '');
			if(cacheProvinsiAll.length > 0){
				$.each(cacheProvinsiAll, function(i, v) {
					$.each(v.kabupaten, function(key, val) {
						var tempPilih = val.type + ' ' + val.kabupaten_nama;
						if (pilihKab === tempPilih) {
							provinsiPilih = v.provinsi;
							return false;
						}
					});
					if (provinsiPilih != '') return false;
				});
				$('#provinsiC').selectpicker('val', provinsiPilih);
			} else {
				$.ajax({
					url: "{{ route('b.ajax-getWilayah') }}",
					type: 'get',
					dataType: 'json',
					success: function(data) {
                    	cacheProvinsiAll = data;
						$.each(data, function(i, v) {
							$.each(v.kabupaten, function(key, val) {
								var tempPilih = val.type + ' ' + val.kabupaten_nama;
								if (pilihKab === tempPilih) {
									provinsiPilih = v.provinsi;
									return false;
								}
							});
							if (provinsiPilih != '') return false;
						});
						$('#provinsiC').selectpicker('val', provinsiPilih);
					}
				});
			}
			var term2 = term+"2";
			$('#kecamatanC').html(
				'<option value="" disabled selected>-- Pilih Kecamatan --</option>');
			if(term2 in cacheKecamatan_Kabupaten){
				$.each(cacheKecamatan_Kabupaten[term2], function(i3, v3) {
					$('#kecamatanC').append("<option value='" + v3.kecamatan.nama +
						"'>" + v3.kecamatan.nama + "</option>");
				});
				$('#kecamatanC').selectpicker('refresh');
			} else {
				$.ajax({
					url: "{{ route('b.ajax-getWilayahDetail') }}",
					type: 'get',
					data: {
						term: pilihKab,
						tipe: "2"
					},
					dataType: 'json',
					success: function(data) {
						cacheKecamatan_Kabupaten[term2] = data;
						$.each(data, function(i3, v3) {
							$('#kecamatanC').append("<option value='" + v3.kecamatan.nama +
								"'>" + v3.kecamatan.nama + "</option>");
						});
						$('#kecamatanC').selectpicker('refresh');
					}
				});
			}
			if (!$('#error_provinsiC').is(':hidden')) $('#error_provinsiC').hide();
			if (!$('#error_kecamatanC').is(':hidden')) $('#error_kecamatanC').hide();
		});
		
		var isKabu_edit = false;
		$('#form_customer_edit').on('changed.bs.select', '#kabupatenC_edit', function(e, clickedIndex, isSelected, previousValue) {
			if(isKabu_edit){
				isKabu_edit = false;
				return;
			}
			isKabu_edit = true;

			$('#kabupatenC_edit').selectpicker('setStyle', 'animation-shake', 'remove');
			if (!$('#error_kabupatenC_edit').is(':hidden')) $('#error_kabupatenC_edit').hide();
			var pilihKab = $(this).val();
			var provinsiPilih = '';
			var term = pilihKab.replace(/[^a-zA-Z]/gi, '');
			if(cacheProvinsiAll.length > 0){
				$.each(cacheProvinsiAll, function(i, v) {
					$.each(v.kabupaten, function(key, val) {
						var tempPilih = val.type + ' ' + val.kabupaten_nama;
						if (pilihKab === tempPilih) {
							provinsiPilih = v.provinsi;
							return false;
						}
					});
					if (provinsiPilih != '') return false;
				});
				$('#provinsiC_edit').selectpicker('val', provinsiPilih);
			} else {
				$.ajax({
					url: "{{ route('b.ajax-getWilayah') }}",
					type: 'get',
					dataType: 'json',
					success: function(data) {
						cacheProvinsiAll = data;
						$.each(data, function(i, v) {
							$.each(v.kabupaten, function(key, val) {
								var tempPilih = val.type + ' ' + val.kabupaten_nama;
								if (pilihKab === tempPilih) {
									provinsiPilih = v.provinsi;
									return false;
								}
							});
							if (provinsiPilih != '') return false;
						});
						$('#provinsiC_edit').selectpicker('val', provinsiPilih);
					}
				});
			}
			var term2 = term+"2";
			$('#kecamatanC_edit').html(
				'<option value="" disabled selected>-- Pilih Kecamatan --</option>');
			if(term2 in cacheKecamatan_Kabupaten){
				$.each(cacheKecamatan_Kabupaten[term2], function(i3, v3) {
					$('#kecamatanC_edit').append("<option value='" + v3.kecamatan.nama +
						"'>" + v3.kecamatan.nama + "</option>");
				});
				$('#kecamatanC_edit').selectpicker('refresh');
			} else {
				$.ajax({
					url: "{{ route('b.ajax-getWilayahDetail') }}",
					type: 'get',
					data: {
						term: pilihKab,
						tipe: "2"
					},
					dataType: 'json',
					success: function(data) {
						cacheKecamatan_Kabupaten[term2] = data;
						$.each(data, function(i3, v3) {
							$('#kecamatanC_edit').append("<option value='" + v3.kecamatan.nama +
								"'>" + v3.kecamatan.nama + "</option>");
						});
						$('#kecamatanC_edit').selectpicker('refresh');
					}
				});
			}
			if (!$('#error_provinsiC_edit').is(':hidden')) $('#error_provinsiC_edit').hide();
			if (!$('#error_kecamatanC_edit').is(':hidden')) $('#error_kecamatanC_edit').hide();
		});

		
		$('#kecamatanC').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
			$('#kecamatanC').selectpicker('setStyle', 'animation-shake', 'remove');
			var pilihKec = $(this).val();
			var provinsiPilih = kabupatenPilih = '';
			if (!$('#error_kecamatanC').is(':hidden')) $('#error_kecamatanC').hide();
			if (!$('#error_provinsiC').is(':hidden')) $('#error_provinsiC').hide();
			if (!$('#error_kabupatenC').is(':hidden')) $('#error_kabupatenC').hide();
		});
		
		$('#kecamatanC_edit').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
			$('#kecamatanC_edit').selectpicker('setStyle', 'animation-shake', 'remove');
			var pilihKec = $(this).val();
			var provinsiPilih = kabupatenPilih = '';
			if (!$('#error_kecamatanC_edit').is(':hidden')) $('#error_kecamatanC_edit').hide();
			if (!$('#error_provinsiC_edit').is(':hidden')) $('#error_provinsiC_edit').hide();
			if (!$('#error_kabupatenC_edit').is(':hidden')) $('#error_kabupatenC_edit').hide();
		});

		
		$('#modTambah').on('hidden.bs.modal', function() {
			hapusIsi();
		});
		
		$('#modEdit').on('hidden.bs.modal', function() {
			hapusIsi(true);
		});

		$("#modTambah").on("input", "#no_telpC", function(){
			this.value = this.value.replace(/[^0-9\+]/g, '');
		});

		$("#modEdit").on("input", "#no_telpC_edit", function(){
			this.value = this.value.replace(/[^0-9\+]/g, '');
		});

		$("#modTambah").on("input", "#kode_posC", function(){
			this.value = this.value.replace(/[^0-9]/g, '');
		});

		$("#modEdit").on("input", "#kode_posC_edit", function(){
			this.value = this.value.replace(/[^0-9]/g, '');
		});

		
		$('#btnTambah').click(function() {
			var errorValidasi = 0;
			var data = $('#form_customer').serializeArray();
			if ($("#provinsiC").val() == null) {
				data.push({
					name: "provinsiC",
					value: ""
				});
			}
			if ($("#kabupatenC").val() == null) {
				data.push({
					name: "kabupatenC",
					value: ""
				});
			}
			if ($("#kecamatanC").val() == null) {
				data.push({
					name: "kecamatanC",
					value: ""
				});
			}
			var namaData = {
				namaC: "Nama Lengkap",
				emailC: "Email",
				provinsiC: "Provinsi",
				kabupatenC: "Kabupaten",
				kecamatanC: "Kecamatan",
				kode_posC: "Kode Pos",
				no_telpC: "Nomor Telepon",
				alamatC: "Alamat",
				passwordC: "Password",
			};
			var cekEmail_diisi = false;
			$.each(data, function(i, v) {
				if (v.name == "emailC" && v.value != "") {
					var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
					if (!regex.test(v.value)) {
						$('#' + v.name).attr('class', 'form-control is-invalid animation-shake');
						$('#error_' + v.name).show();
						$('#error_' + v.name).attr('class', 'invalid-feedback');
						$('#error_' + v.name).html('Masukkan ' + namaData[v.name] + ' yang benar!');
						errorValidasi++;
					}
					cekEmail_diisi = true;
				}
			});
			$.each(data, function(i, v) {
				// if (v.name != "tipe_customerM" && v.value == "") {
				if (v.name != "tipe_customerM" && v.value == "" && v.name != 'emailC' && v.name != 'passwordC') {
					if (v.name == 'provinsiC' || v.name == 'kabupatenC' || v.name == 'kecamatanC') {
						$('#' + v.name).selectpicker('setStyle', 'animation-shake', 'add');
					} else {
						$('#' + v.name).attr('class', 'form-control is-invalid animation-shake');
					}
					$('#error_' + v.name).attr('class', 'invalid-feedback');
					$('#error_' + v.name).html(namaData[v.name] + ' tidak boleh kosong!');
					$('#error_' + v.name).show();
					errorValidasi++;
				}
				if(v.name == "kode_posC" && v.value != ""){
					if(v.value.length > 9){
						$('#' + v.name).attr('class', 'form-control is-invalid animation-shake');
						$('#error_' + v.name).attr('class', 'invalid-feedback');
						$('#error_' + v.name).html(namaData[v.name] + ' tidak boleh lebih dari 9 digit!');
						$('#error_' + v.name).show();
						errorValidasi++;
					}
				}
				if (v.name == "namaC" && v.value.length > 191) {
					$('#' + v.name).attr('class', 'form-control is-invalid animation-shake');
					$('#error_' + v.name).show();
					$('#error_' + v.name).attr('class', 'invalid-feedback');
					$('#error_' + v.name).html(namaData[v.name] +
						' tidak boleh lebih dari 191 karakter!');
					errorValidasi++;
				}
				if (v.name == "passwordC" && v.value == "" && cekEmail_diisi) {
					$('#' + v.name).attr('class', 'form-control is-invalid animation-shake');
					$('#error_' + v.name).show();
					$('#error_' + v.name).attr('class', 'invalid-feedback');
					$('#error_' + v.name).html(namaData[v.name] +
						' harus diisi jika email juga diisi!');
					errorValidasi++;
				}
				// if (v.name == "emailC" && v.value != "") {
				// 	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				// 	if (!regex.test(v.value)) {
				// 		$('#' + v.name).attr('class', 'form-control is-invalid animation-shake');
				// 		$('#error_' + v.name).show();
				// 		$('#error_' + v.name).attr('class', 'invalid-feedback');
				// 		$('#error_' + v.name).html('Masukkan ' + namaData[v.name] + ' yang benar!');
				// 		errorValidasi++;
				// 	}
				// }
				if (v.name == "kategoriC") {
					if (v.value != "Customer" && v.value != "Reseller" && v.value !=
						"Dropshipper") {
						v.value = "Customer";
					}
				}
			});
			// console.log(data);
			// console.log(errorValidasi);
			if (errorValidasi == 0) {
				var hasil = {};
				$.each(data, function(i, v) {
					hasil[v.name] = v.value;
				})
				var resp = '';
				// return console.log(hasil);
				// console.log(data);
				$.ajax({
					type: 'post',
					url: "{{ route('b.customer-store') }}",
					data: hasil,
					success: function(datares) {
						resp = datares;
					},
					error: function(xhr, b, c) {
						swal("Error", '' + c, "error");
					}
				}).done(function() {
					$('#modTambah').modal('hide');
					// console.log(hasil);
					if (resp.status) {
						swal("Berhasil!", "Berhasil menambah Customer!", "success");
						hapusIsi();
					} else {
						swal("Gagal", "" + resp.msg, "error");
					}
                    tabelData.ajax.reload(null, false);
				}).fail(function() {
					$('#modTambah').modal('hide');
				});
			}
		});
		
		$('#btnEdit').click(function() {
			var errorValidasi = 0;
			var data = $('#form_customer_edit').serializeArray();
			if ($("#provinsiC_edit").val() == null) {
				data.push({
					name: "provinsiC_edit",
					value: ""
				});
			}
			if ($("#kabupatenC_edit").val() == null) {
				data.push({
					name: "kabupatenC_edit",
					value: ""
				});
			}
			if ($("#kecamatanC_edit").val() == null) {
				data.push({
					name: "kecamatanC_edit",
					value: ""
				});
			}
			var namaData = {
				namaC_edit: "Nama Lengkap",
				emailC_edit: "Email",
				provinsiC_edit: "Provinsi",
				kabupatenC_edit: "Kabupaten",
				kecamatanC_edit: "Kecamatan",
				kode_posC_edit: "Kode Pos",
				no_telpC_edit: "Nomor Telepon",
				alamatC_edit: "Alamat",
			};
			$.each(data, function(i, v) {
				if (v.name == "passwordC_edit" && v.value == "") {
					v.value = "12345";
				}
				if (v.name != "id_cust" && v.value == "") {
					if (v.name == 'provinsiC_edit' || v.name == 'kabupatenC_edit' || v.name == 'kecamatanC_edit') {
						$('#' + v.name).selectpicker('setStyle', 'animation-shake', 'add');
					} else {
						$('#' + v.name).attr('class', 'form-control is-invalid animation-shake');
					}
					$('#error_' + v.name).show();
					$('#error_' + v.name).attr('class', 'invalid-feedback');
					$('#error_' + v.name).html(namaData[v.name] + ' tidak boleh kosong!');
					errorValidasi++;
				}
				if(v.name == "kode_posC_edit" && v.value != ""){
					if(v.value.length > 9){
						$('#' + v.name).attr('class', 'form-control is-invalid animation-shake');
						$('#error_' + v.name).attr('class', 'invalid-feedback');
						$('#error_' + v.name).html(namaData[v.name] + ' tidak boleh lebih dari 9 digit!');
						$('#error_' + v.name).show();
						errorValidasi++;
					}
				}
				if (v.name == "namaC_edit" && v.value.length > 191) {
					$('#' + v.name).attr('class', 'form-control is-invalid animation-shake');
					$('#error_' + v.name).show();
					$('#error_' + v.name).attr('class', 'invalid-feedback');
					$('#error_' + v.name).html(namaData[v.name] +
						' tidak boleh lebih dari 191 karakter!');
					errorValidasi++;
				}
				if (v.name == "emailC_edit" && v.value != "") {
					var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
					if (!regex.test(v.value)) {
						$('#' + v.name).attr('class', 'form-control is-invalid animation-shake');
						$('#error_' + v.name).show();
						$('#error_' + v.name).attr('class', 'invalid-feedback');
						$('#error_' + v.name).html('Masukkan ' + namaData[v.name] + ' yang benar!');
						errorValidasi++;
					}
				}
				if (v.name == "kategoriC_edit") {
					if (v.value != "Customer" && v.value != "Reseller" && v.value !=
						"Dropshipper") {
						v.value = "Customer";
					}
				}
			});
				// console.log(data);
			if (errorValidasi == 0) {
				var hasil = {};
				$.each(data, function(i, v) {
					hasil[v.name] = v.value;
				})
				var resp = '';
				// console.log(hasil);
				$.ajax({
					type: 'post',
					url: "{{ route('b.customer-update') }}",
					data: hasil,
					success: function(datares) {
						resp = datares;
					},
					error: function(xhr, b, c) {
						swal("Error", '' + c, "error");
					}
				}).done(function() {
					$('#modEdit').modal('hide');
					// console.log(hasil);
					if (resp.status) {
						swal("Berhasil!", "Berhasil mengedit Customer!", "success");
						hapusIsi(true);
					} else {
						swal("Gagal", "" + resp.msg, "error");
					}
                    tabelData.ajax.reload(null, false);
				}).fail(function() {
					$('#modEdit').modal('hide');
				});
			}
		});
	});
	
	(function (world) {
		@if(($ijin->editCustomer === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner')
		world.fn.editC = function () {
			hapusIsi(true);
			var id = jQuery(this).parent().children('input').val();
			$("#id_cust").val(id);
			var hasil2;
			$.ajax({
				type: 'get',
				url: "{{ route('b.customer-edit') }}",
				data: {
					id: id
				},
				success: function (data) {
					hasil2 = data;
					// console.log(data);
				}
			}).done(function () {
				// console.log(hasil2, id);
				$("#kategoriC_edit").selectpicker('val', hasil2.kategori);
				$("#provinsiC_edit").selectpicker('val', hasil2.provinsi);
				$('#namaC_edit').val(hasil2.name);
				$('#kabupatenC_edit').selectpicker('destroy');
				$('#kabupatenC_edit').html('');
                $.ajax({
                    url: "{{ route('b.ajax-getWilayah') }}",
                    type: 'get',
                    data: {
                        term: hasil2.provinsi
                    },
                    dataType: 'json',
                    success: function(data) {
						$.each(data, function (i, v) {
							$('#kabupatenC_edit').append("<option value='" + v.type + " " + v.kabupaten_nama +
								"'>" + v.type + " " + v.kabupaten_nama + "</option>");
						});
						$("#kabupatenC_edit > option[value='" + hasil2.kabupaten + "']").prop("selected", true);
						$('#kabupatenC_edit').selectpicker({
							liveSearch: true,
							style: 'btn-outline btn-default'
						});
                    }
                });
				$('#kecamatanC_edit').selectpicker('destroy');
				$('#kecamatanC_edit').html(
					'<option value="" disabled selected>-- Pilih Kecamatan --</option>');
				$.ajax({
					url: "{{ route('b.ajax-getWilayahDetail') }}",
					type: 'get',
					data: {
						term: hasil2.kabupaten,
						tipe: "2"
					},
					dataType: 'json',
					success: function (data) {
						$.each(data, function (i3, v3) {
							$('#kecamatanC_edit').append("<option value='" + v3.kecamatan.nama +
								"'>" + v3.kecamatan.nama + "</option>");
						});
						$("#kecamatanC_edit > option[value='" + hasil2.kecamatan + "']").prop("selected", true);
						$('#kecamatanC_edit').selectpicker({
							liveSearch: true,
							style: 'btn-outline btn-default'
						});
					}
				});
				$('#emailC_edit').val(hasil2.email);
				// $('#passwordC_edit').val(hasil2.password);
				$('#kode_posC_edit').val(hasil2.kode_pos);
				$('#no_telpC_edit').val(hasil2.no_telp);
				$('#alamatC_edit').val(hasil2.alamat);

			});
		}
		@endif
		
		@if(($ijin->hapusCustomer === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner')
		world.fn.hapusC = function (tabelData) {
			var id = jQuery(this).parent().children('input').val();
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
					var hasil = '';
					$.ajax({
						type: 'POST',
						url: "{{ route('b.customer-destroy') }}",
						data: {
							id: id,
						},
						success: function (data) {
							hasil = data;
						},
						error: function (xhr, b, c) {
							swal("Error", '' + c, "error");
						}
					}).done(function () {
						if (hasil.sukses) {
							swal("Berhasil!", "Berhasil menghapus Customer!", "success");
							tabelData.ajax.reload(null, false);
						} else {
							swal("Gagal", "" + hasil.msg, "error");
						}
					});
				}
			});
		}
		@endif
	})(jQuery);
</script>
<!--uiop-->
@endsection