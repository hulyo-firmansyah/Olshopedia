@extends('depan.cork.index')
@section('page')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('d.home', ['domain_toko' => $toko->domain_toko]) }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page"><span>Register</span></li>
</ol>
@endsection
@section('isi')
<!--uiop-->
<div class='container' style='margin-top:35px;'>
    <div class='row'>
        <div class='col-md-12'>
            <form role="form" action='{{ route("d.register-after", ["domain_toko" => $toko->domain_toko]) }}' method='post' id='registerAfterForm'>
                {{ csrf_field() }}
                <input name='i' type='text' value='{{ $requestData["i"] }}' style='display:none;'>
                <input name='d' type='text' value='{{ $requestData["d"] }}' style='display:none;'>
                <input name='v' type='text' value='{{ $requestData["v"] }}' style='display:none;'>
                <div class='card'>
                    <div class='card-header'>
                        <h3 class='card-title'>
                            Lengkapi Alamat Pengiriman
                        </h3>
                    </div>
                    <div class='card-body'>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" value='{{ $userData->name }}'
                                            readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                            </span>
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
                                        <input type="text" class="form-control" value='{{ $userData->email }}'
                                            readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign register"><circle cx="12" cy="12" r="4"></circle><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path></svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>No Telepon</label>
                                    <input type="text" id='no_telp' class="form-control ph-number" name='no_telp' placeholder='No Telepon'
                                        value='{{ $userData->no_telp }}'>
                                    <small id="error_no_telp" style='display:none;color:red;'>Silahkan isi No Telepon!</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kode Pos</label>
                                    <input type="text" id='kode_pos' class="form-control angkaSaja" name='kode_pos' placeholder='Kode Pos'>
                                    <small id="error_kode_pos" style='display:none;color:red;'>Silahkan isi Kode Pos!</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Provinsi</label>
                                    <select name='provinsi' id='provinsi'>
                                        <option value=''>-- Pilih Provinsi --</option>
                                        @php
                                        foreach(\App\Http\Controllers\PusatController::genArray($wilayah_indonesia)
                                        as $w){
                                        echo "<option value='".$w->provinsi."'>".$w->provinsi."</option>";
                                        }
                                        @endphp
                                    </select>
                                    <small id="error_provinsi" style='display:none;color:red;'>Silahkan Pilih Provinsi!</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Kabupaten/Kota</label>
                                    <select name='kabupaten' id='kabupaten'>
                                        <option value=''>-- Pilih Kabupaten/Kota --</option>
                                        @php
                                        foreach(\App\Http\Controllers\PusatController::genArray($wilayah_indonesia)
                                        as $w){
                                        foreach($w->kabupaten as $k){
                                        echo "<option value='".$k->type." ".$k->kabupaten_nama."'>".$k->type."
                                            ".$k->kabupaten_nama."</option>";
                                        }
                                        }
                                        @endphp
                                    </select>
                                    <small id="error_kabupaten" style='display:none;color:red;'>Silahkan Pilih Kabupaten!</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Kecamatan</label>
                                    <select name='kecamatan' id='kecamatan' width='100%'>
                                        <option value=''>-- Pilih Kecamatan --</option>
                                    </select>
                                    <small id="error_kecamatan" style='display:none;color:red;'>Silahkan Pilih Kecamatan!</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Alamat Lengkap</label>
                                    <textarea class="form-control" rows="3" placeholder="Alamat lengkap" name='alamat' id='alamat'></textarea>
                                    <small id="error_alamat" style='display:none;color:red;'>Silahkan isi alamat!</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='card-footer'>
                        <button type="button" class="btn btn-primary" id='btnSimpan'>Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
var cacheKabupaten = {},
    cacheKecamatan = {},
    cacheKecamatan_Kabupaten = {};
var cacheProvinsiAll = [];
var errorValidasi = 0;

$(document).ready(function() {
    
    $('#provinsi').select2({
        width: '100%'
    });
    $('#kabupaten').select2({
        width: '100%'
    });
    $('#kecamatan').select2({
        width: '100%'
    });
    
    $(".ph-number").inputmask({mask:"(+99) 999-9999-9999"});

    $('#btnSimpan').on('click', function(){
        let data = $('#registerAfterForm').serializeArray();
        // console.log(data);
        $.each(data, (i, v) => {
            if(v.value === ''){
                if(v.name == 'kode_pos'){
                    $('small#error_'+v.name).text('Silahkan isi Kode Pos!');
                    $('small#error_'+v.name).show();
                    $('#'+v.name).addClass('is-invalid');
                    errorValidasi++;
                } else if(v.name == 'no_telp'){
                    $('small#error_'+v.name).text('Silahkan isi No Telpon!');
                    $('small#error_'+v.name).show();
                    $('#'+v.name).addClass('is-invalid');
                    errorValidasi++;
                } else {
                    $('small#error_'+v.name).show();
                    $('#'+v.name).addClass('is-invalid');
                    errorValidasi++;
                }
            } else {
                if(v.name == 'kode_pos'){
                    var regex = /[^0-9]/gi;
                    if(regex.test(v.value)){
                        $('small#error_'+v.name).text('Kode Pos hanya boleh angka!');
                        $('small#error_'+v.name).show();
                        $('#'+v.name).addClass('is-invalid');
                        errorValidasi++;
                    }
                    if(v.value.length > 9){
                        $('small#error_'+v.name).text('Kode Pos tidak boleh lebih dari 9 angka!');
                        $('small#error_'+v.name).show();
                        $('#'+v.name).addClass('is-invalid');
                        errorValidasi++;
                    }
                }
            }
        });
        if(errorValidasi === 0){
            $('#registerAfterForm').submit();
        }
    });

    $('#kode_pos').on('input', function(){
        if ($('small#error_kode_pos').is(':visible')) {
            $('small#error_kode_pos').hide();
            $('#kode_pos').removeClass('is-invalid');
            errorValidasi = 0;
        }
    });

    $('#no_telp').on('input', function(){
        if ($('small#error_no_telp').is(':visible')) {
            $('small#error_no_telp').hide();
            $('#no_telp').removeClass('is-invalid');
            errorValidasi = 0;
        }
    });

    $('#provinsi').on('change', function(){
        if ($('small#error_provinsi').is(':visible')) {
            $('small#error_provinsi').hide();
            $('#provinsi').removeClass('is-invalid');
            errorValidasi = 0;
        }
    });

    $('#kabupaten').on('change', function(){
        if ($('small#error_kabupaten').is(':visible')) {
            $('small#error_kabupaten').hide();
            $('#kabupaten').removeClass('is-invalid');
            errorValidasi = 0;
        }
        if ($('small#error_provinsi').is(':visible')) {
            $('small#error_provinsi').hide();
            $('#provinsi').removeClass('is-invalid');
            errorValidasi = 0;
        }
    });

    $('#kecamatan').on('change', function(){
        if ($('small#error_kecamatan').is(':visible')) {
            $('small#error_kecamatan').hide();
            $('#kecamatan').removeClass('is-invalid');
            errorValidasi = 0;
        }
    });

    $('#alamat').on('input', function(){
        if ($('small#error_alamat').is(':visible')) {
            $('small#error_alamat').hide();
            $('#alamat').removeClass('is-invalid');
            errorValidasi = 0;
        }
    });

    var kabupatenCek = false;
    $('#provinsi').on('change', function(e, clickedIndex, isSelected, previousValue) {
        if (!kabupatenCek) {
            var val = $(this).val();
            $('#kabupaten').html(
                '<option value="">-- Pilih Kabupaten/Kota --</option>');
            var term = val.replace(/[^a-zA-Z]/gi, '');
            if (term in cacheKabupaten) {
                $.each(cacheKabupaten[term], function(i2, v2) {
                    let value = v2.type + " " + v2.kabupaten_nama;
                    let newOption = new Option(value, value, false, false);
                    $('#kabupaten').append(newOption);
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
                            $('#kabupaten').append(newOption);
                        });
                    }
                });
            }
            var term2 = term + "1";
            $('#kecamatan').html(
                '<option value="">-- Pilih Kecamatan --</option>');
            if (term2 in cacheKecamatan) {
                $.each(cacheKecamatan[term2], function(i3, v3) {
                    let value = v3.kecamatan.nama;
                    let newOption = new Option(value, value, false, false);
                    $('#kecamatan').append(newOption);
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
                            $('#kecamatan').append(newOption);
                        });
                    }
                });
            }
            kabupatenCek = true;
        }
    });

    $('#kabupaten').on('change', function(e) {
        var pilihKab = $(this).val();
        var provinsiPilih = '';
        var term = pilihKab.replace(/[^a-zA-Z]/gi, '');
        if (cacheProvinsiAll.length > 0) {
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
            $('#provinsi').val(provinsiPilih).trigger('change.select2');
        } else {
            $.ajax({
                url: "{{ route('b.ajax-getWilayah') }}",
                type: 'get',
                dataType: 'json',
                success: function(data) {
                    cacheProvinsiAll = data;
                    $.each(data, function(i, v) {
                        $.each(v.kabupaten, function(key, val) {
                            var tempPilih = val.type + ' ' + val
                                .kabupaten_nama;
                            if (pilihKab === tempPilih) {
                                provinsiPilih = v.provinsi;
                                return false;
                            }
                        });
                        if (provinsiPilih != '') return false;
                    });
                    $('#provinsi').val(provinsiPilih).trigger('change.select2');
                }
            });
        }
        var term2 = term + "2";
        $('#kecamatan').html(
            '<option value="">-- Pilih Kecamatan --</option>');
        if (term2 in cacheKecamatan_Kabupaten) {
            $.each(cacheKecamatan_Kabupaten[term2], function(i3, v3) {
                let value = v3.kecamatan.nama;
                let newOption = new Option(value, value, false, false);
                $('#kecamatan').append(newOption);
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
                        $('#kecamatan').append(newOption);
                    });
                }
            });
        }
    });

});
</script>
<!--uiop-->
@endsection