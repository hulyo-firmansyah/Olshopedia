@extends('belakang.index')
@section('isi')
<!--uiop-->
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="page-header page-header-bordered">
	<h1 class="page-title font-size-26 font-weight-100">Supplier</h1>
	<div class="page-header-actions">
		<ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);" onClick="pageLoad('{{ route('b.dashboard') }}')">Dashboard</a></li>
			<li class="breadcrumb-item active">Supplier</li>
		</ol>
	</div>
</div>
<div class="page-content">
	<div class="panel animation-slide-top">
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-4">
					<div class="form-group form-style form-inline">
						<button class="btn btn-success" data-target="#tambahSupplier" data-toggle="modal" type="button"><i class='fa fa-plus'></i> Tambah Supplier Baru</button>
					</div>
				</div>
			</div>
			<div class="col-lg-12 form-group">
				<div class="table-responsive">
                    <table class="table table-hover table-striped w-full" id="tableSupplier">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Nama Supplier</th>
                                <th>Asal Pengiriman</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                                <th><span class="site-menu-icon md-settings"></span></th>
                            </tr>
                        </thead>
                        <tbody id="isiTabelSupplier">
                        </tbody>
                    </table>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
var tabelDataSupplier;
var cacheKabupaten = {},
    cacheKecamatan = {},
    cacheKecamatan_Kabupaten = {};
var cacheProvinsiAll = [];
var isTrue_provinsi = false,
    isTrue_kabupaten = false,
    isTrue_kecamatan = false;

(function(world){
    
    //Delete Supplier
    world.fn.hapusSupplier = function(tabelData) {
        var id = $(this).data('id');
        swal({
            title: "Peringatan",
            text: "Apakah anda yakin ingin menghapus Supplier?",
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
                },
            },
            dangerMode: true
        }).then((willDelete) => {
            if (willDelete) {
                var hasil = '';
                $.ajax({
                    type: 'post',
                    url: "{{ route('b.supplier-proses') }}",
                    data: {
                        id: id,
                        tipe: 'hapus'
                    },
                    success: function(data) {
                        hasil = data;
                    },
                    error: function(xhr, b, c) {
                        swal("Error", '' + c, "error");
                    }
                }).done(function() {
                    if (hasil.sukses) {
                        swal("Berhasil!", "Berhasil menghapus Supplier!", "success");
                        tabelDataSupplier.ajax.reload(null, false);
                    } else {
                        swal("Gagal", "" + hasil.msg, "error");
                    }
                });
            }
        });
    }

    // Edit Supplier (Get Data)
    world.fn.editSupplier = function() {
        var id = $(this).data('id');
        var hasil;
        $.ajax({
            type: 'get',
            url: '{{ route("b.supplier-getData") }}',
            data: {
                v: id
            },
            success: function(data) {
                hasil = data;
            }
        }).done(function() {
            $('#edit_namaSupplier').val(hasil.nama_supplier);
            $('#edit_provinsiS').selectpicker('destroy');
			$("#edit_provinsiS > option[value='" + hasil.provinsi + "']").prop("selected", true);
            $('#edit_provinsiS').selectpicker({
                liveSearch: true,
                style: 'btn-outline btn-default'
            });
            $('#edit_kabupatenS').selectpicker('destroy');
            $('#edit_kabupatenS').html('');
            $('#edit_kabupatenS').html('<option value="" disabled selected>-- Pilih Kabupaten --</option>');
            var term = hasil.provinsi.replace(/[^a-zA-Z]/gi, '');
            if(term in cacheKabupaten){
                $.each(cacheKabupaten[term], function(i2, v2) {
                    $('#edit_kabupatenS').append("<option value='" + v2.type + " " + v2
                        .kabupaten_nama + "'>" + v2.type + " " + v2
                        .kabupaten_nama + "</option>");
                });
				$("#edit_kabupatenS > option[value='" + hasil.kabupaten + "']").prop("selected", true);
                $('#edit_kabupatenS').selectpicker({
					liveSearch: true,
					style: 'btn-outline btn-default'
				});
            } else {
                $.ajax({
                    url: "{{ route('b.ajax-getWilayah') }}",
                    type: 'get',
                    data: {
                        term: hasil.provinsi
                    },
                    dataType: 'json',
                    success: function(data) {
                        cacheKabupaten[term] = data;
                        $.each(data, function(i2, v2) {
                            $('#edit_kabupatenS').append("<option value='" + v2.type + " " + v2
                                .kabupaten_nama + "'>" + v2.type + " " + v2
                                .kabupaten_nama + "</option>");
                        });
				        $("#edit_kabupatenS > option[value='" + hasil.kabupaten + "']").prop("selected", true);
                        $('#edit_kabupatenS').selectpicker({
                            liveSearch: true,
                            style: 'btn-outline btn-default'
                        });
                    }
                });
            }
            var term2 = hasil.kabupaten.replace(/[^a-zA-Z]/gi, '')+"2";
            $('#edit_kecamatanS').selectpicker('destroy');
            $('#edit_kecamatanS').html('');
            $('#edit_kecamatanS').html('<option value="" disabled selected>-- Pilih Kecamatan --</option>');
            if(term2 in cacheKecamatan_Kabupaten){
                $.each(cacheKecamatan_Kabupaten[term2], function(i3, v3) {
                    $('#edit_kecamatanS').append("<option value='" + v3.kecamatan.nama +"'>" + v3.kecamatan.nama + "</option>");
                });
				$("#edit_kecamatanS > option[value='" + hasil.kecamatan + "']").prop("selected", true);
                $('#edit_kecamatanS').selectpicker({
					liveSearch: true,
					style: 'btn-outline btn-default'
				});
            } else {
                $.ajax({
                    url: "{{ route('b.ajax-getWilayahDetail') }}",
                    type: 'get',
                    data: {
                        term: hasil.kabupaten,
                        tipe: "2"
                    },
                    dataType: 'json',
                    success: function(data) {
                        cacheKecamatan_Kabupaten[term2] = data;
                        $.each(data, function(i3, v3) {
                            $('#edit_kecamatanS').append("<option value='" + v3.kecamatan.nama +
                                "'>" + v3.kecamatan.nama + "</option>");
                        });
				        $("#edit_kecamatanS > option[value='" + hasil.kecamatan + "']").prop("selected", true);
                        $('#edit_kecamatanS').selectpicker({
                            liveSearch: true,
                            style: 'btn-outline btn-default'
                        });
                    }
                });
            }
            $('#edit_no_telpSupplier').val(hasil.no_telp);
            $('#edit_kode_posSupplier').val(hasil.kode_pos);
            $('#edit_alamatSupplier').val(hasil.jalan);
            $('#edit_keteranganSupplier').val(hasil.ket);
            $('button[name=btnEditSupplier]').data('id', id);
        });
    }
})(jQuery);

$(document).ready(function(){
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    tabelDataSupplier = $('#tableSupplier').DataTable({
        ajax: {
            type: 'get',
            url: "{{ route('b.supplier-getData') }}",
        },
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        "order": [
            [1, 'asc']
        ]
    });
    tabelDataSupplier.on('order.dt search.dt', function() {
        tabelDataSupplier.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();


    $('#no_telpSupplier').on('input', function(){
        this.value = this.value.replace(/[^0-9]/gi, '');
    });

    $('#kode_posSupplier').on('input', function(){
        this.value = this.value.replace(/[^0-9]/gi, '');
    });

    $('#provinsiS').selectpicker({
        liveSearch: true,
        style: 'btn-outline btn-default'
    });
    $('#kabupatenS').selectpicker({
        liveSearch: true,
        style: 'btn-outline btn-default'
    });
    $('#kecamatanS').selectpicker({
        liveSearch: true,
        style: 'btn-outline btn-default'
    });
    $('#provinsiS').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
        $('#provinsiS').selectpicker('setStyle', 'animation-shake', 'remove');
        if (!$('#error_provinsiS').is(':hidden')) $('#error_provinsiS').hide();
        var val = $(this).val();
        $('#kabupatenS').html(
            '<option value="" disabled selected>-- Pilih Kabupaten --</option>');
        var term = val.replace(/[^a-zA-Z]/gi, '');
        if(term in cacheKabupaten){
            $.each(cacheKabupaten[term], function(i2, v2) {
                $('#kabupatenS').append("<option value='" + v2.type + " " + v2
                    .kabupaten_nama + "'>" + v2.type + " " + v2
                    .kabupaten_nama + "</option>");
            });
            $('#kabupatenS').selectpicker('refresh');
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
                        $('#kabupatenS').append("<option value='" + v2.type + " " + v2
                            .kabupaten_nama + "'>" + v2.type + " " + v2
                            .kabupaten_nama + "</option>");
                    });
                    $('#kabupatenS').selectpicker('refresh');
                }
            });
        }
        var term2 = term+"1";
        $('#kecamatanS').html(
            '<option value="" disabled selected>-- Pilih Kecamatan --</option>');
        if(term2 in cacheKecamatan){
            $.each(cacheKecamatan[term2], function(i3, v3) {
                $('#kecamatanS').append("<option value='" + v3.kecamatan.nama +
                    "'>" + v3.kecamatan.nama + "</option>");
            });
            $('#kecamatanS').selectpicker('refresh');
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
                        $('#kecamatanS').append("<option value='" + v3.kecamatan.nama +
                            "'>" + v3.kecamatan.nama + "</option>");
                    });
                    $('#kecamatanS').selectpicker('refresh');
                }
            });
        }
        if (!$('#error_kabupatenS').is(':hidden')) $('#error_kabupatenS').hide();
        if (!$('#error_kecamatanS').is(':hidden')) $('#error_kecamatanS').hide();
    });

    $('#formEditSupplier').on('changed.bs.select', '#edit_provinsiS', function(e, clickedIndex, isSelected, previousValue) {
        if(isTrue_provinsi){
            isTrue_provinsi = false;
            return;
        }
        isTrue_provinsi = true;
        $('#edit_provinsiS').selectpicker('setStyle', 'animation-shake', 'remove');
        if (!$('#error_edit_provinsiS').is(':hidden')) $('#error_edit_provinsiS').hide();
        var val = $(this).val();
        $('#edit_kabupatenS').html(
            '<option value="" disabled selected>-- Pilih Kabupaten --</option>');
        var term = val.replace(/[^a-zA-Z]/gi, '');
        if(term in cacheKabupaten){
            $.each(cacheKabupaten[term], function(i2, v2) {
                $('#edit_kabupatenS').append("<option value='" + v2.type + " " + v2
                    .kabupaten_nama + "'>" + v2.type + " " + v2
                    .kabupaten_nama + "</option>");
            });
            $('#edit_kabupatenS').selectpicker('refresh');
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
                        $('#edit_kabupatenS').append("<option value='" + v2.type + " " + v2
                            .kabupaten_nama + "'>" + v2.type + " " + v2
                            .kabupaten_nama + "</option>");
                    });
                    $('#edit_kabupatenS').selectpicker('refresh');
                }
            });
        }
        var term2 = term+"1";
        $('#edit_kecamatanS').html(
            '<option value="" disabled selected>-- Pilih Kecamatan --</option>');
        if(term2 in cacheKecamatan){
            $.each(cacheKecamatan[term2], function(i3, v3) {
                $('#edit_kecamatanS').append("<option value='" + v3.kecamatan.nama +
                    "'>" + v3.kecamatan.nama + "</option>");
            });
            $('#edit_kecamatanS').selectpicker('refresh');
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
                        $('#edit_kecamatanS').append("<option value='" + v3.kecamatan.nama +
                            "'>" + v3.kecamatan.nama + "</option>");
                    });
                    $('#edit_kecamatanS').selectpicker('refresh');
                }
            });
        }
        if (!$('#error_edit_kabupatenS').is(':hidden')) $('#error_edit_kabupatenS').hide();
        if (!$('#error_edit_kecamatanS').is(':hidden')) $('#error_edit_kecamatanS').hide();
    });

    $('#kabupatenS').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
        $('#kabupatenS').selectpicker('setStyle', 'animation-shake', 'remove');
        if (!$('#error_kabupatenS').is(':hidden')) $('#error_kabupatenS').hide();
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
            $('#provinsiS').selectpicker('val', provinsiPilih);
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
                    $('#provinsiS').selectpicker('val', provinsiPilih);
                }
            });
        }
        var term2 = term+"2";
        $('#kecamatanS').html(
            '<option value="" disabled selected>-- Pilih Kecamatan --</option>');
        if(term2 in cacheKecamatan_Kabupaten){
            $.each(cacheKecamatan_Kabupaten[term2], function(i3, v3) {
                $('#kecamatanS').append("<option value='" + v3.kecamatan.nama +
                    "'>" + v3.kecamatan.nama + "</option>");
            });
            $('#kecamatanS').selectpicker('refresh');
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
                        $('#kecamatanS').append("<option value='" + v3.kecamatan.nama +
                            "'>" + v3.kecamatan.nama + "</option>");
                    });
                    $('#kecamatanS').selectpicker('refresh');
                }
            });
        }
        if (!$('#error_provinsiS').is(':hidden')) $('#error_provinsiS').hide();
        if (!$('#error_kecamatanS').is(':hidden')) $('#error_kecamatanS').hide();
    });

    $('#formEditSupplier').on('changed.bs.select', '#edit_kabupatenS', function(e, clickedIndex, isSelected, previousValue) {
        if(isTrue_kabupaten){
            isTrue_kabupaten = false;
            return;
        }
        isTrue_kabupaten = true;
        $('#edit_kabupatenS').selectpicker('setStyle', 'animation-shake', 'remove');
        if (!$('#error_edit_kabupatenS').is(':hidden')) $('#error_edit_kabupatenS').hide();
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
            $('#edit_provinsiS').selectpicker('val', provinsiPilih);
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
                    $('#edit_provinsiS').selectpicker('val', provinsiPilih);
                }
            });
        }
        var term2 = term+"2";
        $('#edit_kecamatanS').html(
            '<option value="" disabled selected>-- Pilih Kecamatan --</option>');
        if(term2 in cacheKecamatan_Kabupaten){
            $.each(cacheKecamatan_Kabupaten[term2], function(i3, v3) {
                $('#edit_kecamatanS').append("<option value='" + v3.kecamatan.nama +
                    "'>" + v3.kecamatan.nama + "</option>");
            });
            $('#edit_kecamatanS').selectpicker('refresh');
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
                        $('#edit_kecamatanS').append("<option value='" + v3.kecamatan.nama +
                            "'>" + v3.kecamatan.nama + "</option>");
                    });
                    $('#edit_kecamatanS').selectpicker('refresh');
                }
            });
        }
        if (!$('#error_edit_provinsiS').is(':hidden')) $('#error_edit_provinsiS').hide();
        if (!$('#error_edit_kecamatanS').is(':hidden')) $('#error_edit_kecamatanS').hide();
    });

    $('#kecamatanS').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
        $('#kecamatanS').selectpicker('setStyle', 'animation-shake', 'remove');
        if (!$('#error_kecamatanS').is(':hidden')) $('#error_kecamatanS').hide();
        if (!$('#error_provinsiS').is(':hidden')) $('#error_provinsiS').hide();
        if (!$('#error_kabupatenS').is(':hidden')) $('#error_kabupatenS').hide();
    });

    $('#formEditSupplier').on('changed.bs.select', '#edit_kecamatanS', function(e, clickedIndex, isSelected, previousValue) {
        $('#edit_kecamatanS').selectpicker('setStyle', 'animation-shake', 'remove');
        if (!$('#error_edit_kecamatanS').is(':hidden')) $('#error_edit_kecamatanS').hide();
        if (!$('#error_edit_provinsiS').is(':hidden')) $('#error_edit_provinsiS').hide();
        if (!$('#error_edit_kabupatenS').is(':hidden')) $('#error_edit_kabupatenS').hide();
    });

    
    // Tambah Supplier
    $("button[name=btnTambahSupplier]").on('click', function() {
        var namaSupplier = $('#namaSupplier').val();
        var provinsiSupplier = $('#provinsiS').val();
        var kabupatenSupplier = $('#kabupatenS').val();
        var kecamatanSupplier = $('#kecamatanS').val();
        var no_telpSupplier = $('#no_telpSupplier').val();
        var kode_posSupplier = $('#kode_posSupplier').val();
        var alamatSupplier = $('#alamatSupplier').val();
        var keteranganSupplier = $('#keteranganSupplier').val();
        console.log(kode_posSupplier.length);
        var error = 0;
        if (namaSupplier == "") {
            $('#namaSupplier').addClass('is-invalid animation-shake');
            $('small#error_nama').attr('style', 'color:#f2353c;');
            $('small#error_nama').show();
            error++;
        }
        if (provinsiSupplier == null) {
            $('#provinsiS').selectpicker('setStyle', 'animation-shake', 'add');
            $('small#error_provinsiS').attr('style', 'color:#f2353c;');
            $('small#error_provinsiS').show();
            error++;
        }
        if (kabupatenSupplier == null) {
            $('#kabupatenS').selectpicker('setStyle', 'animation-shake', 'add');
            $('small#error_kabupatenS').attr('style', 'color:#f2353c;');
            $('small#error_kabupatenS').show();
            error++;
        }
        if (kecamatanSupplier == null) {
            $('#kecamatanS').selectpicker('setStyle', 'animation-shake', 'add');
            $('small#error_kecamatanS').attr('style', 'color:#f2353c;');
            $('small#error_kecamatanS').show();
            error++;
        }
        if (kode_posSupplier == "") {
            $('#kode_posSupplier').addClass('is-invalid animation-shake');
            $('small#error_kode_posSupplier').attr('style', 'color:#f2353c;');
            $('small#error_kode_posSupplier').text('Masukkan Kode Pos!');
            $('small#error_kode_posSupplier').show();
            error++;
        }
        if(kode_posSupplier.length > 9){
            $('#kode_posSupplier').addClass('is-invalid animation-shake');
            $('small#error_kode_posSupplier').attr('style', 'color:#f2353c;');
            $('small#error_kode_posSupplier').text('Digit Kode Pos terlalu banyak!');
            $('small#error_kode_posSupplier').show();
            error++;
        }
        if (alamatSupplier == "") {
            $('#alamatSupplier').addClass('is-invalid animation-shake');
            $('small#error_alamatSupplier').attr('style', 'color:#f2353c;');
            $('small#error_alamatSupplier').show();
            error++;
        }
        if (error === 0) {
            var hasil = '';
            $.ajax({
                type: 'post',
                url: "{{ route('b.supplier-proses') }}",
                data: {
                    nama: namaSupplier,
                    provinsi: provinsiSupplier,
                    kabupaten: kabupatenSupplier,
                    kecamatan: kecamatanSupplier,
                    no_telp: no_telpSupplier,
                    kode_pos: kode_posSupplier,
                    alamat: alamatSupplier,
                    ket: $('#keteranganSupplier').val(),
                    tipe: 'tambah',
                },
                success: function(data) {
                    hasil = data;
                },
                error: function(error, b, c) {
                    swal("Error", '' + c, "error")
                }
            }).done(function() {
                $('#tambahSupplier').modal('hide');
                if (hasil.status) {
                    swal("Berhasil!", "Berhasil menambah supplier!", "success");
                    tabelDataSupplier.ajax.reload(null, false);
                } else {
                    swal("Gagal!", "" + hasil.msg, "error");
                }
            }).fail(function() {
                
            })
        }
    })

    $('#namaSupplier').on('input', function(){
        if($('small#error_nama').is(':visible')){
            $('small#error_nama').hide();
            $('#namaSupplier').removeClass('is-invalid animation-shake');
        }
    });

    $('#kode_posSupplier').on('input', function(){
        if($('small#error_kode_posSupplier').is(':visible')){
            $('small#error_kode_posSupplier').hide();
            $('#kode_posSupplier').removeClass('is-invalid animation-shake');
        }
    });

    $('#alamatSupplier').on('input', function(){
        if($('small#error_alamatSupplier').is(':visible')){
            $('small#error_alamatSupplier').hide();
            $('#alamatSupplier').removeClass('is-invalid animation-shake');
        }
    });

    $('#provinsiS').on('changed.bs.select', function(){
        if($('small#error_provinsiS').is(':visible')){
            $('small#error_provinsiS').hide();
            $('#provinsiS').selectpicker('setStyle', 'animation-shake', 'remove');
        }
    });

    $('#kabupatenS').on('changed.bs.select', function(){
        if($('small#error_kabupatenS').is(':visible')){
            $('small#error_kabupatenS').hide();
            $('#kabupatenS').selectpicker('setStyle', 'animation-shake', 'remove');
        }
    });

    $('#kecamatanS').on('changed.bs.select', function(){
        if($('small#error_kecamatanS').is(':visible')){
            $('small#error_kecamatanS').hide();
            $('#kecamatanS').selectpicker('setStyle', 'animation-shake', 'remove');
        }
    });

    $('#tambahSupplier').on('hide.bs.modal', function(){
        $('#namaSupplier').val('');
        $('#no_telpSupplier').val('');
        $('#kode_posSupplier').val('');
        $('#alamatSupplier').val('');
        $('#keteranganSupplier').val('');
        $('#provinsiS').selectpicker('val', '');
        $('#kabupatenS').selectpicker('val', '');
        $('#kecamatanS').selectpicker('val', '');
        if($('small#error_nama').is(':visible')){
            $('small#error_nama').hide();
            $('#namaSupplier').removeClass('is-invalid animation-shake');
        }
        if($('small#error_no_telpSupplier').is(':visible')){
            $('small#error_no_telpSupplier').hide();
            $('#no_telpSupplier').removeClass('is-invalid animation-shake');
        }
        if($('small#error_kode_posSupplier').is(':visible')){
            $('small#error_kode_posSupplier').hide();
            $('#kode_posSupplier').removeClass('is-invalid animation-shake');
        }
        if($('small#error_alamatSupplier').is(':visible')){
            $('small#error_alamatSupplier').hide();
            $('#alamatSupplier').removeClass('is-invalid animation-shake');
        }
        if($('small#error_provinsiS').is(':visible')){
            $('small#error_provinsiS').hide();
            $('#provinsiS').selectpicker('setStyle', 'animation-shake', 'remove');
        }
        if($('small#error_kabupatenS').is(':visible')){
            $('small#error_kabupatenS').hide();
            $('#kabupatenS').selectpicker('setStyle', 'animation-shake', 'remove');
        }
        if($('small#error_kecamatanS').is(':visible')){
            $('small#error_kecamatanS').hide();
            $('#kecamatanS').selectpicker('setStyle', 'animation-shake', 'remove');
        }
    });

    // Update Supplier
    $("button[name=btnEditSupplier]").on('click', function() {
        var edit_namaSupplier = $('#edit_namaSupplier').val();
        var edit_provinsiSupplier = $('#edit_provinsiS').val();
        var edit_kabupatenSupplier = $('#edit_kabupatenS').val();
        var edit_kecamatanSupplier = $('#edit_kecamatanS').val();
        var edit_no_telpSupplier = $('#edit_no_telpSupplier').val();
        var edit_kode_posSupplier = $('#edit_kode_posSupplier').val();
        var edit_alamatSupplier = $('#edit_alamatSupplier').val();
        var edit_keteranganSupplier = $('#edit_keteranganSupplier').val();
        var err = 0;
        if (edit_namaSupplier == "") {
            $('#edit_namaSupplier').addClass('is-invalid animation-shake');
            $('small#error_edit_nama').attr('style', 'color:#f2353c;');
            $('small#error_edit_nama').show();
            error++;
        }
        if (edit_provinsiSupplier == null) {
            $('#edit_provinsiS').selectpicker('setStyle', 'animation-shake', 'add');
            $('small#error_edit_provinsiS').attr('style', 'color:#f2353c;');
            $('small#error_edit_provinsiS').show();
            error++;
        }
        if (edit_kabupatenSupplier == null) {
            $('#edit_kabupatenS').selectpicker('setStyle', 'animation-shake', 'add');
            $('small#error_edit_kabupatenS').attr('style', 'color:#f2353c;');
            $('small#error_edit_kabupatenS').show();
            error++;
        }
        if (edit_kecamatanSupplier == null) {
            $('#edit_kecamatanS').selectpicker('setStyle', 'animation-shake', 'add');
            $('small#error_edit_kecamatanS').attr('style', 'color:#f2353c;');
            $('small#error_edit_kecamatanS').show();
            error++;
        }
        if (edit_kode_posSupplier == "") {
            $('#edit_kode_posSupplier').addClass('is-invalid animation-shake');
            $('small#error_edit_kode_posSupplier').attr('style', 'color:#f2353c;');
            $('small#error_edit_kode_posSupplier').text('Masukkan Kode Pos!');
            $('small#error_edit_kode_posSupplier').show();
            error++;
        }
        if(edit_kode_posSupplier.length > 9){
            $('#edit_kode_posSupplier').addClass('is-invalid animation-shake');
            $('small#error_edit_kode_posSupplier').attr('style', 'color:#f2353c;');
            $('small#error_edit_kode_posSupplier').text('Digit Kode Pos terlalu banyak!');
            $('small#error_edit_kode_posSupplier').show();
            error++;
        }
        if (edit_alamatSupplier == "") {
            $('#edit_alamatSupplier').addClass('is-invalid animation-shake');
            $('small#error_edit_alamatSupplier').attr('style', 'color:#f2353c;');
            $('small#error_edit_alamatSupplier').show();
            error++;
        }
        if (err === 0) {
            var hasil = '';
            $.ajax({
                type: 'post',
                url: "{{ route('b.supplier-proses') }}",
                data: {
                    id: $(this).data('id'),
                    nama: edit_namaSupplier,
                    provinsi: edit_provinsiSupplier,
                    kabupaten: edit_kabupatenSupplier,
                    kecamatan: edit_kecamatanSupplier,
                    no_telp: edit_no_telpSupplier,
                    kode_pos: edit_kode_posSupplier,
                    alamat: edit_alamatSupplier,
                    ket: $('#edit_keteranganSupplier').val(),
                    tipe: 'edit'
                },
                success: function(data) {
                    hasil = data;
                },
                error: function(error, b, c) {
                    swal("Error", '' + c, "error");
                }
            }).done(function() {
                $('#editSupplier').modal('hide');
                tabelDataSupplier.ajax.reload();
                if (hasil.status) {
                    swal("Berhasil!", "Berhasil memperbarui supplier!", "success");
                    tabelDataSupplier.ajax.reload(null, false);
                } else {
                    swal("Gagal", "" + hasil.msg, "error");
                }
            }).fail(function() {
                $('#editSupplier').modal('hide');
            });
        }
    });


    $('#edit_namaSupplier').on('input', function(){
        if($('small#error_edit_nama').is(':visible')){
            $('small#error_edit_nama').hide();
            $('#edit_namaSupplier').removeClass('is-invalid animation-shake');
        }
    });

    $('#edit_kode_posSupplier').on('input', function(){
        if($('small#error_edit_kode_posSupplier').is(':visible')){
            $('small#error_edit_kode_posSupplier').hide();
            $('#edit_kode_posSupplier').removeClass('is-invalid animation-shake');
        }
    });

    $('#edit_alamatSupplier').on('input', function(){
        if($('small#error_edit_alamatSupplier').is(':visible')){
            $('small#error_edit_alamatSupplier').hide();
            $('#edit_alamatSupplier').removeClass('is-invalid animation-shake');
        }
    });

    $('#edit_provinsiS').on('changed.bs.select', function(){
        if($('small#error_edit_provinsiS').is(':visible')){
            $('small#error_edit_provinsiS').hide();
            $('#edit_provinsiS').selectpicker('setStyle', 'animation-shake', 'remove');
        }
    });

    $('#edit_kabupatenS').on('changed.bs.select', function(){
        if($('small#error_edit_kabupatenS').is(':visible')){
            $('small#error_edit_kabupatenS').hide();
            $('#edit_kabupatenS').selectpicker('setStyle', 'animation-shake', 'remove');
        }
    });

    $('#edit_kecamatanS').on('changed.bs.select', function(){
        if($('small#error_edit_kecamatanS').is(':visible')){
            $('small#error_edit_kecamatanS').hide();
            $('#edit_kecamatanS').selectpicker('setStyle', 'animation-shake', 'remove');
        }
    });

    $('#editSupplier').on('hide.bs.modal', function(){
        if($('small#error_edit_nama').is(':visible')){
            $('small#error_edit_nama').hide();
            $('#edit_namaSupplier').removeClass('is-invalid animation-shake');
        }
        if($('small#error_edit_kode_posSupplier').is(':visible')){
            $('small#error_edit_kode_posSupplier').hide();
            $('#edit_kode_posSupplier').removeClass('is-invalid animation-shake');
        }
        if($('small#error_edit_alamatSupplier').is(':visible')){
            $('small#error_edit_alamatSupplier').hide();
            $('#edit_alamatSupplier').removeClass('is-invalid animation-shake');
        }
        if($('small#error_edit_provinsiS').is(':visible')){
            $('small#error_edit_provinsiS').hide();
            $('#edit_provinsiS').selectpicker('setStyle', 'animation-shake', 'remove');
        }
        if($('small#error_edit_kabupatenS').is(':visible')){
            $('small#error_edit_kabupatenS').hide();
            $('#edit_kabupatenS').selectpicker('setStyle', 'animation-shake', 'remove');
        }
        if($('small#error_edit_kecamatanS').is(':visible')){
            $('small#error_edit_kecamatanS').hide();
            $('#edit_kecamatanS').selectpicker('setStyle', 'animation-shake', 'remove');
        }
    });
});
</script>
<!-- -- Modal tambah supplier -- -->
<div class="modal fade modal-fade-in-scale-up" id="tambahSupplier" aria-hidden="true"
    aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTitle">Tambah Supplier</h4>
            </div>
            <div class="modal-body">
                <form id="formTambahSupplier">
                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <label>Nama Supplier</label>
                            <input type="text" class="form-control" name="nama" placeholder="Nama Supplier" id="namaSupplier">
                            <small id="error_nama" style='color:#f2353c;display:none;'>Masukkan Nama Supplier!</small>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-lg-6 form-group">
                            <label>No Telepon</label>
                            <input type="text" class="form-control" name="no_telpSupplier" placeholder="No Telepon"
                                id="no_telpSupplier">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="">Kode Pos</label>
                            <input type="text" class="form-control" name="kode_posSupplier" placeholder="Kode Pos" id="kode_posSupplier">
                            <small id="error_kode_posSupplier" style="color:#f2353c; display: none;">Masukkan Kode Pos!</small>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-md-4 form-group">
                            <label>Provinsi</label>
                            <select name='provinsiS' class='form-control' id='provinsiS'>
                                <option value='' disabled selected>-- Pilih Provinsi --</option>
                                @php
                                foreach($wilayah_indonesia as $w){
                                echo "<option value='".$w->provinsi."'>".$w->provinsi."</option>";
                                }
                                @endphp
                            </select>
                            <small id="error_provinsiS" class='hidden'>Silahkan Pilih Provinsi!</small>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Kabupaten/Kota</label>
                            <select name='kabupatenS' class='form-control' id='kabupatenS'>
                                <option value='' disabled selected>-- Pilih Kabupaten --</option>
                                @php
                                foreach($wilayah_indonesia as $w){
                                foreach($w->kabupaten as $k){
                                echo "<option value='".$k->type." ".$k->kabupaten_nama."'>".$k->type."
                                    ".$k->kabupaten_nama."</option>";
                                }
                                }
                                @endphp
                            </select>
                            <small id="error_kabupatenS" class='hidden'>Silahkan Pilih Kabupaten!</small>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Kecamatan</label>
                            <select name='kecamatanS' class='form-control' id='kecamatanS'>
                                <option value='' disabled selected>-- Pilih Kecamatan --</option>
                            </select>
                            <small id="error_kecamatanS" class='hidden'>Silahkan Pilih Kecamatan!</small>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-lg-12 form-group">
                            <label for="">Alamat</label>
                            <textarea class="form-control" id="alamatSupplier" rows="2" placeholder="Alamat"></textarea>
                            <small id="error_alamatSupplier" style='color:#f2353c;display:none;'>Masukkan Alamat Supplier!</small>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-lg-12 form-group">
                            <label for="">Keterangan</label>
                            <textarea class="form-control" id="keteranganSupplier" rows="2" placeholder="Keterangan"></textarea>
                            <small class="text-help">Kosongkan Jika Tidak Ada Keterangan!</small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" name='btnTambahSupplier'>Tambah</button>
                <button class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- -- Modal edit supplier -- -->
<div class="modal fade modal-fade-in-scale-up" id="editSupplier" aria-hidden="true" aria-labelledby="exampleModalTitle"
    role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTitle">Edit Supplier</h4>
            </div>
            <div class="modal-body">
                <form id="formEditSupplier">
                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <label>Nama Supplier</label>
                            <input type="text" class="form-control" name="edit_nama" placeholder="Nama Supplier" id="edit_namaSupplier">
                            <small id="error_edit_nama" style='color:#f2353c;display:none;'>Masukkan Nama Supplier!</small>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-lg-6 form-group">
                            <label>No Telepon</label>
                            <input type="text" class="form-control" name="edit_no_telpSupplier" placeholder="No Telepon"
                                id="edit_no_telpSupplier">
                            <small id="error_edit_no_telpSupplier" style='color:#f2353c;display:none;'>Masukkan No Telepon Dengan Benar!</small>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="">Kode Pos</label>
                            <input type="text" class="form-control" name="edit_kode_posSupplier" placeholder="Kode Pos" id="edit_kode_posSupplier">
                            <small id="error_edit_kode_posSupplier" style="color:#f2353c; display: none;">Masukkan Kode Pos!</small>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-md-4 form-group">
                            <label>Provinsi</label>
                            <select name='edit_provinsiS' class='form-control' id='edit_provinsiS'>
                                <option value='' disabled selected>-- Pilih Provinsi --</option>
                                @php
                                foreach($wilayah_indonesia as $w){
                                echo "<option value='".$w->provinsi."'>".$w->provinsi."</option>";
                                }
                                @endphp
                            </select>
                            <small id="error_edit_provinsiS" class='hidden'>Silahkan Pilih Provinsi!</small>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Kabupaten/Kota</label>
                            <select name='edit_kabupatenS' class='form-control' id='edit_kabupatenS'>
                                <option value='' disabled selected>-- Pilih Kabupaten --</option>
                                @php
                                foreach($wilayah_indonesia as $w){
                                foreach($w->kabupaten as $k){
                                echo "<option value='".$k->type." ".$k->kabupaten_nama."'>".$k->type."
                                    ".$k->kabupaten_nama."</option>";
                                }
                                }
                                @endphp
                            </select>
                            <small id="error_edit_kabupatenS" class='hidden'>Silahkan Pilih Kabupaten!</small>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Kecamatan</label>
                            <select name='edit_kecamatanS' class='form-control' id='edit_kecamatanS'>
                                <option value='' disabled selected>-- Pilih Kecamatan --</option>
                            </select>
                            <small id="error_edit_kecamatanS" class='hidden'>Silahkan Pilih Kecamatan!</small>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-lg-12 form-group">
                            <label for="">Alamat</label>
                            <textarea class="form-control" id="edit_alamatSupplier" rows="2" placeholder="Alamat"></textarea>
                            <small id="error_edit_alamatSupplier" style='color:#f2353c;display:none;'>Masukkan Alamat Supplier!</small>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-lg-12 form-group">
                            <label for="">Keterangan</label>
                            <textarea class="form-control" id="edit_keteranganSupplier" rows="2" placeholder="Keterangan"></textarea>
                            <small class="text-help">Kosongkan Jika Tidak Ada Keterangan!</small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-warning" name='btnEditSupplier'>Edit</button>
                <button class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<!--uiop-->
@endsection