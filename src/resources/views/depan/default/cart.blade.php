@extends('depan.default.index')
@section('isi')
<!--uiop-->
<div class="content-header">
    <div class='container'>
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Home</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a
                            href="{{ route('d.home', ['domain_toko' => $toko->domain_toko]) }}">Home</a></li>
                    <li class="breadcrumb-item active">Cart</li>
                </ol>
            </div>
        </div>
        <hr>
    </div>
</div>
<div class='content'>
    <div class='container'>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Cart</h3>
            </div>
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th style='width:15px'></th>
                        </tr>
                    </thead>
                    <tbody id='cartList'>
                        @php
                            $i = 0;
                            $total = 0;
                        @endphp
                        @foreach(\App\Http\Controllers\PusatController::genArray($cart) as $i_c => $c)
                            @php
                                $harga = $c->price * $c->quantity;
                                $total += $harga;
                            @endphp
                            <tr>
                                <td>{{ (++$i) }}</td>
                                <td>{{ $c->name }}</td>
                                <td>{{ $c->quantity }}</td>
                                <td data-harga='{{ $c->price }}'>{{ \App\Http\Controllers\PusatController::formatUang($harga, true) }}</td>
                                <td><button type='button' class='btn btn-danger btn-sm btnHapusCart' data-id='{{ $c->id }}'>X</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan='3' class='text-right'>Total</th>
                            <td colspan='2' id='totalCart'>{{ \App\Http\Controllers\PusatController::formatUang($total, true) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function hitungUlang(awal = false){
        var total = 0;
        if($('#cartList tr').length > 0 && !awal){
            let list = Array.prototype.slice.call($('#cartList tr'));
            var i = 0;
            list.forEach(function(html) {
                $(html).children('td:first').text(++i);
                let harga = parseInt($(html).children('td:nth-child(4)').data('harga'));
                let jumlah = parseInt($(html).children('td:nth-child(3)').text());
                total += (harga * jumlah);
            });
            $('#totalCart').text('Rp '+uangFormat(total));
            $('#badgeCart').show();
        } else {
            $('#cartList').append('<tr><td colspan="5" class="text-center">Tidak ada produk di Cart</td></tr>');
            $('#totalCart').text('Rp 0');
            $('#badgeCart').hide();
        }
    }

    $(document).ready(function(){

        @if(count($cart) < 1)
            hitungUlang(true);
        @endif

        $('.btnHapusCart').on('click', function(){
            let id = $(this).data('id');
            var this_ = this;
            $.ajax({
                type: 'post',
                url: "{{ route('d.cart-hapus', ['domain_toko' => $toko->domain_toko]) }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                },
                success: function(data) {
                    // console.log(data);
                    if(data.status){
                        $(document).Toasts('create', {
                            class: 'bg-success',
                            title: 'Berhasil',
                            autohide: true,
                            delay: 3000,
                            body: ''+data.msg
                        });
                        $('#badgeCart').text(data.cart_count);
                        $(this_).parent().parent().remove();
                        hitungUlang();
                    } else {
                        $(document).Toasts('create', {
                            class: 'bg-danger',
                            title: 'Error',
                            autohide: true,
                            delay: 3000,
                            body: ''+data.msg
                        });
                    }
                },
                error: function(xhr, b, c) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Error',
                        autohide: true,
                        delay: 3000,
                        body: ''+c
                    });
                }
            });
        });

    });
</script>
<!--uiop-->
@endsection