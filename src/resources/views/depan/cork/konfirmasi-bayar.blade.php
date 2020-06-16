@extends('depan.cork.index')
@section('page')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('d.home', ['domain_toko' => $toko->domain_toko]) }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('d.order', ['domain_toko' => $toko->domain_toko, 'order_slug' => $order_slug]) }}">Order #{{ $order_data->urut_order }}</a></li>
    <li class="breadcrumb-item active" aria-current="page"><span>Konfirmasi Pembayaran</span></li>
</ol>
@endsection
@section('isi')
<!--uiop-->
@php
    $total_data = json_decode($order_data->total);
    $total = $total_data->hargaProduk + $total_data->hargaOngkir + $total_data->kode_unik;
@endphp
<div class='container'>
    <div class="row layout-top-spacing justify-content-between">
        <div class="card animated animatedFadeInUp fadeInUp" style='width:100%;'>
            <div class='card-header'>
                <h5>
                    <strong>Konfirmasi Pembayaran</strong>
                    <span>(INV #{{ $order_data->urut_order }})</span>
                </h5>
            </div>
            <div class="card-body">
                <div class='row'>
                    <div class="form-group col-md-12">
                        <label for="order_pilih" style='color:black;'>Pilih tagihan yang ingin dikonfirmasi pembayarannya:</label>
                        <select id='order_pilih' height='100%' name='order_pilih' class="">
                            <option value='{{ $order_slug }}'>INV #{{ $order_data->urut_order }} (Rp {{ App\Http\Controllers\PusatController::formatUang($total) }})</option>
                        </select>
                    </div> 
                </div>
                <div class='row'>
                    <div class="col-md-8 form-group">
                        <label for="atas_nama" style='color:black;'>Atas Nama</label>
                        <input type="text" class="form-control" id="atas_nama" name='atas_nama'>
                        <div class="invalid-feedback" id='atas_nama-error'></div>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="tgl_transfer" style='color:black;'>Tanggal Transfer</label>
                        <input type="text" class="form-control" id="tgl_transfer" name='tgl_transfer'>
                        <div class="invalid-feedback" id='tgl_transfer-error'></div>
                    </div>
                </div>
                <div class='row'>
                    <div class="col-md-6 form-group">
                        <label for="nominal" style='color:black;'>Nominal yang ditransfer</label>
                        <input type="text" class="form-control angkaSaja" id="nominal" name='nominal'>
                        <div class="invalid-feedback" id='nominal-error'></div>
                    </div> 
                    <div class="col-md-6 form-group">
                        <label for="bank_tujuan" style='color:black;'>Bank tujuan:</label>
                        <select id='bank_tujuan' height='100%' name='bank_tujuan'>
                            @foreach(App\Http\Controllers\PusatController::genArray($bank) as $b)
                                <option value='{{ $b->id_bank }}|{{ $b->bank }}'>{{ $b->bank }} ({{ $b->no_rek }} A.n. {{ strtoupper($b->atas_nama) }})</option>
                            @endforeach
                        </select>
                    </div> 
                </div>
                <div class='row'>
                    <div class='form-group col-md-12'>
                        <label for="foto_bukti" style='color:black;'>Foto bukti transfer</label>
                        <div class="custom-file mb-4" id='foto_bukti'>
                            <input type="file" class="custom-file-input" id="customFile" name='foto_bukti'>
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                        <div class="invalid-feedback" id='foto_bukti-error'></div>
                    </div>
                </div>
                <div class='row'>
                    <div class='form-group col-md-12'>
                        <label for="catatan" style='color:black;'>Catatan</label>
                        <textarea id='catatan' class='form-control' name='catatan'></textarea>
                    </div>
                </div>
                <div class='row'>
                    <div class='form-group col-md-12' style='margin-top:1rem;'>
                        <button class="btn btn-primary btn-block" style='font-size:20px;height:50px;' id='btnSimpan'>Konfirmasi Pembayaran</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){

        var f1 = flatpickr(document.getElementById('tgl_transfer'), {
            defaultDate: new Date()
        });

        $('#customFile').change(function() {
            if(!$('#foto_bukti-error').is(':hidden')) $('#foto_bukti-error').hide();
            $(this).next('label').text($(this).val().split('\\')[2]);
        });

        $('#bank_tujuan').select2({
            minimumResultsForSearch: -1
        });

        $('#order_pilih').select2({
            minimumResultsForSearch: -1
        });

        $('#btnSimpan').on('click', function(){
            let error = 0;
            let atas_nama = $('#atas_nama').val();
            let tgl_transfer = $('#tgl_transfer').val();
            let nominal = $('#nominal').val();
            let foto_bukti = $('#customFile').val();
            let foto_bukti_split = foto_bukti === '' ? null : foto_bukti.split('.');
            let ext_allow = ['jpeg', 'jpg', 'gif', 'png'];
            if(atas_nama == ''){
                $('#atas_nama').addClass('is-invalid');
                $('#atas_nama-error').text('Atas Nama tidak boleh kosong!');
                $('#atas_nama-error').show();
                error++;
            }
            if(tgl_transfer == ''){
                $('#tgl_transfer').addClass('is-invalid');
                $('#tgl_transfer-error').text('Tgl Transfer tidak boleh kosong!');
                $('#tgl_transfer-error').show();
                error++;
            }
            if(nominal == ''){
                $('#nominal').addClass('is-invalid');
                $('#nominal-error').text('Nominal tidak boleh kosong!');
                $('#nominal-error').show();
                error++;
            }
            let regex = /[^0-9]/gi;
            if(nominal.match(/[^0-9]/gi)){
                $('#nominal').addClass('is-invalid');
                $('#nominal-error').text('Nominal tidak boleh selain angka!');
                $('#nominal-error').show();
                error++;
            }
            if(foto_bukti != ''){
                if(foto_bukti_split[foto_bukti_split.length-1] in ext_allow === false){
                    $('#foto_bukti-error').text('ekstensi tidak didukung!');
                    $('#foto_bukti-error').show();
                    error++;
                }
            }
            if(error < 1){
                // let url = "{{ route('d.konfirmasi-bayar-proses', ['domain_toko' => $toko->domain_toko]) }}";
                // let form = $("<form action='"+url+"' method='post' enctype='multipart/form-data'></form>");
                // form.append('{{ csrf_field() }}');
                // $('#order_pilih').clone().appendTo(form);
                // $('#atas_nama').clone().appendTo(form);
                // $('#nominal').clone().appendTo(form);
                // $('#tgl_transfer').clone().appendTo(form);
                // $('#customFile').clone().appendTo(form);
                // $('#catatan').clone().appendTo(form);
                // $('body').append(form);
                // form.submit();
            }
        });

        $('#atas_nama').on('input', function(){
            if($(this).hasClass('is-invalid')){
                $(this).removeClass('is-invalid');
                $('#atas_nama-error').hide();
            }
        });

        $('#nominal').on('input', function(){
            if($(this).hasClass('is-invalid')){
                $(this).removeClass('is-invalid');
                $('#nominal-error').hide();
            }
        });

    });
</script>
<!--uiop-->
@endsection