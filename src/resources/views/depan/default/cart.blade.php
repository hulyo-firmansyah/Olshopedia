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
    function hitungUlang(){
        var total = 0;
        let list = Array.prototype.slice.call($('#cartList tr'));
        var i = 0;
        list.forEach(function(html) {
            $(html).children('td:first').text(++i);
            let harga = parseInt($(html).children('td:nth-child(4)').data('harga'));
            let jumlah = parseInt($(html).children('td:nth-child(3)').text());
            total += (harga * jumlah);
        });
        $('#totalCart').text('Rp '+uangFormat(total));
    }

    $(document).ready(function(){
        $('.btnHapusCart').on('click', function(){
            let id = $(this).data('id');
            $(this).parent().parent().remove();
            hitungUlang();
        });
    });
</script>
<!--uiop-->
@endsection