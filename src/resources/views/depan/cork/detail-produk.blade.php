@extends('depan.cork.index')
@section('page')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('d.home', ['domain_toko' => $toko->domain_toko]) }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page"><span>{{ $produk->nama_produk }}</span></li>
</ol>
@endsection
@section('isi')
<!--uiop-->
<style>
.product-image-thumb {
    box-shadow: 0 1px 2px rgba(0,0,0,.075);
    border-radius: .25rem;
    background-color: #fff;
    border: 1px solid #dee2e6;
    display: -ms-flexbox;
    display: flex;
    margin-right: 1rem;
    max-width: 7rem;
    padding: .5rem;
    cursor:pointer;
}
.product-image-thumb img {
    max-width: 100%;
    height: auto;
    -ms-flex-item-align: center;
    align-self: center;
}
.product-image-thumbs {
    -ms-flex-align: stretch;
    align-items: stretch;
    display: -ms-flexbox;
    display: flex;
    margin-top: 2rem;
}
.product-image-thumb:hover {
    opacity: .5;
}
</style>
<div class='container'>
    <div class="row layout-top-spacing justify-content-between">
        <div class="card" style='width:100%;'>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-6" id='gambarDiv'>
                        <h3 class="d-inline-block d-sm-none">{{ $produk->nama_produk }}</h3>
                        <div class="col-12">
                            <img src="{{ $produk->varian[0]->foto->utama }}" class="product-image" alt="Product Image" style='width:100%;'>
                        </div>
                        <div class="col-12 product-image-thumbs">
                            @php
                                $img_i = 0;
                                if(isset($produk->varian[0]->foto->utama)){
                                    if($img_i === 0){
                                        @endphp
                                            <div class="product-image-thumb active"><img src="{{ $produk->varian[0]->foto->utama }}" alt="Product Image"></div>
                                        @php
                                    } else {
                                        @endphp
                                            <div class="product-image-thumb"><img src="{{ $produk->varian[0]->foto->utama }}" alt="Product Image"></div>
                                        @php
                                    }
                                    $img_i++;
                                }
                                foreach(\App\Http\Controllers\PusatController::genArray($produk->varian[0]->foto->lain) as $ll){
                                    if($img_i === 0){
                                        @endphp
                                            <div class="product-image-thumb active"><img src="{{ $ll }}" alt="Product Image"></div>
                                        @php
                                    } else {
                                        @endphp
                                            <div class="product-image-thumb"><img src="{{ $ll }}" alt="Product Image"></div>
                                        @php
                                    }
                                    $img_i++;
                                }
                            @endphp
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <h3 class="my-3">{{ $produk->nama_produk }}</h3>
                        <hr>
                        @if(count($produk->varian) > 1)
                        <h5 class="mt-4">Varian</h5>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            @php
                                foreach(\App\Http\Controllers\PusatController::genArray($produk->varian) as $i => $v){
                                    $btnTampil = '';
                                    if(($v->ukuran != null && $v->ukuran != "") && ($v->warna != null && $v->warna != "")){
                                        $btnTampil .= "<span class='text-lg'>".$v->ukuran."</span><br>".$v->warna;
                                    } else if(($v->ukuran != null && $v->ukuran != "") && ($v->warna == null || $v->warna == "")){
                                        $btnTampil .= "<span class='text-lg'>".$v->ukuran."</span>";
                                    } else if(($v->ukuran == null || $v->ukuran == "") && ($v->warna != null && $v->warna != "")){
                                        $btnTampil .= "<span class='text-lg'>".$v->warna."</span>";
                                    }
                                    if($btnTampil === ''){
                                        $btnTampil = "<span class='text-lg'>".($i+1)."</span>";
                                    }
                                    @endphp
                                    @php
                                    if($i == 0){
                                        @endphp
                                        <label class="btn btn-primary text-center">
                                            <input type="radio" name="varian_pilihan" id="varian_pilihan-{{($i+1)}}" value='{{ $v->id_varian }}' autocomplete="off">
                                            {!! $btnTampil !!}
                                        </label>
                                        @php
                                    } else {
                                        @endphp
                                        <label class="btn btn-default text-center">
                                            <input type="radio" name="varian_pilihan" id="varian_pilihan-{{($i+1)}}" value='{{ $v->id_varian }}' autocomplete="off">
                                            {!! $btnTampil !!}
                                        </label>
                                        @php
                                    }
                                }
                            @endphp
                        </div>
                        @endif
                        <div class="mt-4" id='hargaDiv'>
                            <h5>Harga</h5>
                            <h4 class="mb-0">
                                {{ \App\Http\Controllers\PusatController::formatUang($produk->varian[0]->harga_jual_normal, true) }}
                            </h4>
                        </div>
                        <h5 class="mt-4">Jumlah</h5>
                        <div class='row'>
                            <div class='col-lg-5'>
                                <input type='text' class='form-control' name='jumlah' id='jumlah' placeholder='Jumlah' value='1'>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type='button' id='btnTambahCart' class="btn btn-primary btn-md" data-ip='{{ $produk->id_produk }}' data-iv='{{ $produk->varian[0]->id_varian }}'>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                &nbsp;Tambahkan ke Keranjang
                            </button>
                        </div>
                        <div class="mt-5 product-share">
                            Share:
                            <a href="http://www.facebook.com/sharer.php?u={{ urlencode(url()->current()) }}" target='_blank' class="btn btn-outline-dark">
                                Facebook
                            </a>
                            <a href="https://twitter.com/share?url={{ urlencode(url()->current()) }}" target='_blank' class="btn btn-outline-dark">
                                Twitter
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="w-100">
                        <div class="nav nav-tabs" id="product-tab" role="tablist">
                            <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc" 
                                role="tab" aria-controls="product-desc" aria-selected="true">Deskripsi</a>
                            <a class="nav-item nav-link" id="product-rating-tab" data-toggle="tab" href="#product-rating"
                                role="tab" aria-controls="product-rating" aria-selected="false">Review</a>
                        </div>
                    </div>
                    <div class="tab-content p-3" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="product-desc" role="tabpanel"aria-labelledby="product-desc-tab">
                            {{ $produk->ket }} 
                        </div>
                        <div class="tab-pane fade" id="product-rating" role="tabpanel" aria-labelledby="product-rating-tab">
                            -
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        
        $('.card-body').on('click', '.product-image-thumb', function() {
            const image_element = $(this).find('img');
            $('.product-image').prop('src', $(image_element).attr('src'))
            $('.product-image-thumb.active').removeClass('active');
            $(this).addClass('active');
        });

        $('.card-body').on('click', 'input[name=varian_pilihan]', function(){
            const data_img = {
                @foreach(\App\Http\Controllers\PusatController::genArray($produk->varian) as $v)
                    '{{ $v->id_varian }}' : {
                        utama: '{{ $v->foto->utama }}',
                        lain: jQuery.parseJSON('{!! json_encode($v->foto->lain) !!}')
                    },
                @endforeach
            };
            const data_harga = {
                @foreach(\App\Http\Controllers\PusatController::genArray($produk->varian) as $v)
                    '{{ $v->id_varian }}' : {
                        harga: parseInt('{{ $v->harga_jual_normal }}')
                    },
                @endforeach
            };
            let id = $(this).val();
            $('#btnTambahCart').data('iv', id);
            $('#hargaDiv').children('h4').text('Rp '+uangFormat(data_harga[id].harga));
            $('#gambarDiv').find('.product-image').prop('src', data_img[id].utama);
            $('#gambarDiv').children('div:last').html('');
            let i_ = 0;
            $('#gambarDiv').children('div:last').append('<div class="product-image-thumb active"><img src="'+data_img[id].utama+'" alt="Product Image"></div>');
            $.each(data_img[id].lain, (i, v) => {
                $('#gambarDiv').children('div:last').append('<div class="product-image-thumb"><img src="'+v+'" alt="Product Image"></div>');
            });
            let list = Array.prototype.slice.call($(this).parent().parent().children());
            var this_ = this;
            list.forEach(function(html) {
                if($(html).hasClass('btn-primary') && html !== this_){
                    $(html).removeClass('btn-primary');
                    $(html).addClass('btn-default');
                }
            });
            if($(this).parent().hasClass('btn-default')){
                $(this).parent().removeClass('btn-default');
                $(this).parent().removeClass('btn-default');
                $(this).parent().addClass('btn-primary');
            }
        });
    });
</script>
<!--uiop-->
@endsection