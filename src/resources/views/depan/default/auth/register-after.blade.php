@extends('depan.default.index')
@section('isi')
<!--uiop-->
<div clas='content-header'>
    <div class='container'>
        <div class="row mb-5">
        </div>
    </div>
</div>
<div class="content">
    <div class='container'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='card-header'>
                        <h3 class='card-title'>
                            Lengkapi Alamat Pengiriman
                        </h3>
                    </div>
                    <div class='card-body'>
                        <form role="form">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Nama Lengkap</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-at"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>No Telepon</label>
                                        <input type="text" class="form-control" name='no_telp' placeholder='No Telepon'>
                                        <small id="error_no_telp" style='display:none;'>Silahkan Pilih Kabupaten!</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kode Pos</label>
                                        <input type="text" class="form-control" name='kode_pos' placeholder='Kode Pos'>
                                        <small id="error_kode_pos" style='display:none;'>Silahkan Pilih Kabupaten!</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Provinsi</label>
                                        <select name='provinsi' id='provinsiS'>
                                            <option value=''>-- Pilih Provinsi --</option>
                                            @php
                                            foreach(\App\Http\Controllers\PusatController::genArray($wilayah_indonesia) as $w){
                                                echo "<option value='".$w->provinsi."'>".$w->provinsi."</option>";
                                            }
                                            @endphp
                                        </select>
                                        <small id="error_provinsiS" style='display:none;'>Silahkan Pilih Provinsi!</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Kabupaten/Kota</label>
                                        <select name='kabupaten' id='kabupatenS'>
                                            <option value=''>-- Pilih Kabupaten/Kota --</option>
                                            @php
                                            foreach(\App\Http\Controllers\PusatController::genArray($wilayah_indonesia) as $w){
                                                foreach($w->kabupaten as $k){
                                                    echo "<option value='".$k->type." ".$k->kabupaten_nama."'>".$k->type." ".$k->kabupaten_nama."</option>";
                                                }
                                            }
                                            @endphp
                                        </select>
                                        <small id="error_kabupatenS" style='display:none;'>Silahkan Pilih Kabupaten!</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Kecamatan</label>
                                        <select name='kecamatan' id='kecamatanS' width='100%'>
                                            <option value=''>-- Pilih Kecamatan --</option>
                                        </select>
                                        <small id="error_kecamatanS" style='display:none;'>Silahkan Pilih Kecamatan!</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Alamat Lengkap</label>
                                        <textarea class="form-control" rows="3" placeholder="Alamat lengkap"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var cacheKabupaten = {},
    cacheKecamatan = {},
    cacheKecamatan_Kabupaten = {};
var cacheProvinsiAll = [];

    $(document).ready(function(){
        $('#provinsiS').select2({
            theme: 'bootstrap4',
            width: '100%'
        });
        $('#kabupatenS').select2({
            theme: 'bootstrap4',
            width: '100%'
        });
        $('#kecamatanS').select2({
            theme: 'bootstrap4',
            width: '100%'
        });

        $('#provinsiS').on('change', function(){
            if($('small#error_provinsiS').is(':visible')){
                $('small#error_provinsiS').hide();
                $('#provinsiS').removeClass('animation-shake');
            }
        });

        $('#kabupatenS').on('change', function(){
            if($('small#error_kabupatenS').is(':visible')){
                $('small#error_kabupatenS').hide();
                $('#kabupatenS').removeClass('animation-shake');
            }
        });

        $('#kecamatanS').on('change', function(){
            if($('small#error_kecamatanS').is(':visible')){
                $('small#error_kecamatanS').hide();
                $('#kecamatanS').removeClass('animation-shake');
            }
        });
        
        var kabupatenCek = false;
        $('#provinsiS').on('change', function(e, clickedIndex, isSelected, previousValue) {
            $('#provinsiS').removeClass('animation-shake');
            if (!$('#error_provinsiS').is(':hidden')) $('#error_provinsiS').hide();
            if(!kabupatenCek){
                var val = $(this).val();
                $('#kabupatenS').html(
                    '<option value="">-- Pilih Kabupaten --</option>');
                var term = val.replace(/[^a-zA-Z]/gi, '');
                if(term in cacheKabupaten){
                    $.each(cacheKabupaten[term], function(i2, v2) {
                        let value = v2.type + " " + v2.kabupaten_nama;
                        let newOption = new Option(value, value, false, false);
                        $('#kabupatenS').append(newOption);
                    });
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
                                let value = v2.type + " " + v2.kabupaten_nama;
                                let newOption = new Option(value, value, false, false);
                                $('#kabupatenS').append(newOption);
                            });
                        }
                    });
                }
                var term2 = term+"1";
                $('#kecamatanS').html(
                    '<option value="">-- Pilih Kecamatan --</option>');
                if(term2 in cacheKecamatan){
                    $.each(cacheKecamatan[term2], function(i3, v3) {
                        let value = v3.kecamatan.nama;
                        let newOption = new Option(value, value, false, false);
                        $('#kecamatanS').append(newOption);
                    });
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
                                let value = v3.kecamatan.nama;
                                let newOption = new Option(value, value, false, false);
                                $('#kecamatanS').append(newOption);
                            });
                        }
                    });
                }
                kabupatenCek = true;
            }
            if (!$('#error_kabupatenS').is(':hidden')) $('#error_kabupatenS').hide();
            if (!$('#error_kecamatanS').is(':hidden')) $('#error_kecamatanS').hide();
        });

        $('#kabupatenS').on('change', function(e) {
            $('#kabupatenS').removeClass('animation-shake');
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
                $('#provinsiS').val(provinsiPilih).trigger('change.select2');
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
                        $('#provinsiS').val(provinsiPilih).trigger('change.select2');
                    }
                });
            }
            var term2 = term+"2";
            $('#kecamatanS').html(
                '<option value="">-- Pilih Kecamatan --</option>');
            if(term2 in cacheKecamatan_Kabupaten){
                $.each(cacheKecamatan_Kabupaten[term2], function(i3, v3) {
                    let value = v3.kecamatan.nama;
                    let newOption = new Option(value, value, false, false);
                    $('#kecamatanS').append(newOption);
                });
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
                            let value = v3.kecamatan.nama;
                            let newOption = new Option(value, value, false, false);
                            $('#kecamatanS').append(newOption);
                        });
                    }
                });
            }
            if (!$('#error_provinsiS').is(':hidden')) $('#error_provinsiS').hide();
            if (!$('#error_kecamatanS').is(':hidden')) $('#error_kecamatanS').hide();
        });
        
        $('#kecamatanS').on('change', function(e, clickedIndex, isSelected, previousValue) {
            $('#kecamatanS').removeClass('animation-shake');
            if (!$('#error_kecamatanS').is(':hidden')) $('#error_kecamatanS').hide();
            if (!$('#error_provinsiS').is(':hidden')) $('#error_provinsiS').hide();
            if (!$('#error_kabupatenS').is(':hidden')) $('#error_kabupatenS').hide();
        });
    });
</script>
<!--uiop-->
@endsection