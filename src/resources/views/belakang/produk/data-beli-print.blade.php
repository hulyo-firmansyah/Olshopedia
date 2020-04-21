<!DOCTYPE html>
<html class="no-js css-menubar" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="bootstrap admin template">
    <meta name="author" content="NickmanUiop">
    <title>Olshopedia</title>
    <script src="{{ asset('template/global/vendor/jquery/jquery.js') }}"></script>
    <link rel="apple-touch-icon" href="{{ asset('template/assets/images/apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('template/assets/images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('template/global/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/css/bootstrap-extend.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/fonts/font-awesome/font-awesome.css') }}">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
    <style>
    @media print {
        @page{
            margin:5mm;
            padding:0;
            size: auto;
        }

        #non-printable {
            display:none!important;
        }

        #printable, #printable * {
            visibility: visible;
            color-adjust: exact;
            -webkit-print-color-adjust: exact; 
            print-color-adjust: exact;
        }
        
    }
    body {
        background-color: #f0f0f0;
    }
    #printable {
        padding-top:20px;
        padding-bottom:20px;
        padding-right: 40px;
        padding-left:40px;
        color:black
    }
    #non-printable {
        height: auto;
        padding: 25px;
        background-color: #2e3035;
        color:#888;
        margin: -10px -10px 0 -10px;
    }
    </style>
</head>
<body>
    <div id='non-printable'>
        <a href='{{ route("b.produk-dataBeli") }}' class='btn btn-dark'><i class='fa fa-arrow-left'></i> Kembali ke Data Pembelian Produk</a> 
        <button class='btn btn-dark' onClick='window.print()'><i class='fa fa-print'></i> Print</button> 
    </div>
    <div id='printable'>
        <center>
            <h3>{{ $toko->nama_toko }}</h3>
            <h5>{{ $toko->deskripsi_toko }}</h5>
            <h5>{{ $toko->alamat_toko }}</h5>
            <h5>No Telp: {{ $toko->no_telp_toko }}</h5>
        </center>
        <table border='0' class='mt-20'>
            <tr>
                <td>No Nota</td>
                <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                <td>{{ $data_beli->no_nota }}</td>
            </tr>
            <tr>
                <td>Tanggal Beli</td>
                <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                <td>{{ date('j F Y', strtotime($data_beli->tgl_beli)) }}</td>
            </tr>
            <tr>
                <td>Admin</td>
                <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                <td>{{ $nama_admin }}</td>
            </tr>
        </table>
        <table width="100%" border="1" cellspacing="0" class="mt-20">
            <thead>
                <tr style='text-align:center'>
                    <th>Nama Produk</th>
                    <th>Supplier</th>
                    <th>Harga Beli</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach(\App\Http\Controllers\PusatController::genArray($data) as $d)
                    @php
                        $subtotal = $d->jumlah * $d->harga_beli;
                    @endphp
                    <tr>
                        <td>{{ $d->nama_produk }}</td>
                        <td>{{ $d->supplier }}</td>
                        <td style='text-align:center'>Rp {{ \App\Http\Controllers\PusatController::formatUang($d->harga_beli) }}</td>
                        <td style='text-align:center'>{{ $d->jumlah }}</td>
                        <td style='text-align:center'>Rp {{ \App\Http\Controllers\PusatController::formatUang($subtotal) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="{{ asset('template/global/vendor/bootstrap/bootstrap.js') }}"></script>
</body>
</html>