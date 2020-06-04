@extends('depan.cork.index')
@section('page')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('d.home', ['domain_toko' => $toko->domain_toko]) }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page"><span>Cart</span></li>
</ol>
@endsection
@section('isi')
<!--uiop-->
<div class='container'>
    <div class='row' style='margin-top:30px;'>
        <div class='col-md-12'>
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
                    const toast = swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        padding: '2em'
                    });
                    if(data.status){
                        toast({
                            type: 'success',
                            title: ''+data.msg,
                            padding: '2em',
                        });
                        $('#badgeCart').text(data.cart_count);
                        $(this_).parent().parent().remove();
                        hitungUlang();
                    } else {
                        toast({
                            type: 'error',
                            title: ''+data.msg,
                            padding: '2em',
                        });
                    }
                },
                error: function(xhr, b, c) {
                    const toast = swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        padding: '2em'
                    });
                    toast({
                        type: 'error',
                        title: ''+c,
                        padding: '2em',
                    });
                }
            });
        });

    });
</script>
<!--uiop-->
@endsection