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
        padding:10px;
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
    </div>
    <div id='printable'>
        asasd
    </div>
    
    <script src="{{ asset('template/global/vendor/bootstrap/bootstrap.js') }}"></script>
</body>
</html>