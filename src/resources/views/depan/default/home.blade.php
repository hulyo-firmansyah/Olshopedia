@extends('depan.default.index')
@section('isi')
<!--uiop-->
<div class='row'>
    <div class='col-lg-6'>
        <h1 class="page-title font-size-26 font-weight-100">Katalog Produk</h1>
    </div>
    <div class='col-lg-6'>
        <div class='text-right' style='margin-top:25px'>
            <div class='form-inline'>
                <label for='sorting'>Urutkan berdasarkan :</label>
                <select id='sorting'>
                    <option value='a-z'>A - Z</option>
                    <option value='z-a'>Z - A</option>
                    <option value='murah-mahal'>Termurah - Termahal</option>
                    <option value='mahal-murah  '>Termahal - Termurah</option>
                </select>
            </div>
        </div>
    </div>
</div>
<hr>

<div class="row">
    @foreach(\App\Http\Controllers\PusatController::genArray($produk) as $p)
    <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="thumbnail">
            <img src="{{ asset('photo.png') }}" alt="..." width='240px' height='240px'>
            <div class="caption">
                <h3>{{ $p->nama_produk }}</h3>
                @php
                    if($p->termurah !== $p->termahal){
                        @endphp
                        <p>{{ \App\Http\Controllers\PusatController::formatUang($p->termurah, true).' - '.\App\Http\Controllers\PusatController::formatUang($p->termahal, true) }}</p>
                        @php
                    } else {
                        @endphp
                        <p>{{ \App\Http\Controllers\PusatController::formatUang($p->termurah, true) }}</p>
                        @php
                    }
                @endphp
                <p>{{ $p->ket ?? '' }}</p>
                <p class='text-right'>
                    <a href="javascript:void(0)" class="btn btn-primary" role="button" data-id='{{ $p->id_produk }}'>Selengkapnya</a>
                </p>
            </div>
        </div>
    </div>
    @endforeach
</div>
<script>
    $(document).ready(function(){
        $('#sorting').on('change', function(){
            $.ajax({
                type: 'get',
                url: '',
                beforeSend: function() {
                    $('#body-page').html(
                        '<div style="top:50%;left:50%;position:absolute"><div class="loader vertical-align-middle loader-grill"></div></div>'
                    );
                },
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            // console.log(percentComplete);
                        }
                        $('#body-page').html(
                            '<div style="top:50%;left:50%;position:absolute"><div class="loader vertical-align-middle loader-grill"></div></div>'
                        );
                    }, false);
                    xhr.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            // console.log(percentComplete);
                        }
                        $('#body-page').html(
                            '<div style="top:50%;left:50%;position:absolute"><div class="loader vertical-align-middle loader-grill"></div></div>'
                        );
                    }, false);
                    return xhr;
                },
                success: function(data, textStatus, xhr) {
                    console.log(data);
                },
                error: function(xhr, b, c) {
                    $('#body-page').html('error');
                }
            }); 
        });
    });
</script>
<!--uiop-->
@endsection