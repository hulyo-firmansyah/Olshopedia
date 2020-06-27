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
    <script src="{{ asset('template/global/js/Plugin/sweetalert.js') }}"></script>
    <script src="{{ asset('alertifyjs/alertify.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('alertifyjs/css/alertify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('alertifyjs/css/themes/bootstrap.min.css') }}">

    <link rel="apple-touch-icon" href="{{ asset('template/assets/images/apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('template/assets/images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('jquery-ui-1.12.1.custom/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/css/bootstrap-extend.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/css/site.min.css') }}">

    <!-- Plugins -->
    <link rel="stylesheet" href="{{ asset('template/global/vendor/animsition/animsition.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/vendor/asscrollable/asScrollable.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/vendor/bootstrap-touchspin/bootstrap-touchspin.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/vendor/switchery/switchery.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/vendor/intro-js/introjs.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/vendor/slidepanel/slidePanel.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/vendor/flag-icon-css/flag-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/vendor/bootstrap-select/bootstrap-select.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/vendor/webui-popover/webui-popover.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/vendor/toolbar/toolbar.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/vendor/icheck/icheck.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/vendor/aspieprogress/asPieProgress.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/examples/css/dashboard/ecommerce.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/vendor/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template/global/vendor/datatables.net-fixedheader-bs4/dataTables.fixedheader.bootstrap4.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template/global/vendor/datatables.net-fixedcolumns-bs4/dataTables.fixedcolumns.bootstrap4.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template/global/vendor/datatables.net-rowgroup-bs4/dataTables.rowgroup.bootstrap4.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template/global/vendor/datatables.net-scroller-bs4/dataTables.scroller.bootstrap4.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template/global/vendor/datatables.net-select-bs4/dataTables.select.bootstrap4.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template/global/vendor/datatables.net-responsive-bs4/dataTables.responsive.bootstrap4.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template/global/vendor/datatables.net-buttons-bs4/dataTables.buttons.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/examples/css/tables/datatable.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/vendor/dropify/dropify.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/vendor/summernote/summernote.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/vendor/ladda/ladda.min.css') }}">
    <style>
    .datepicker table tr td.active:not(:disabled):not(.disabled):active,
    .datepicker table tr td.active:not(:disabled):not(.disabled).active,
    .show>.datepicker table tr td.active.dropdown-toggle,
    .datepicker table tr td.active.highlighted:not(:disabled):not(.disabled):active,
    .datepicker table tr td.active.highlighted:not(:disabled):not(.disabled).active,
    .show>.datepicker table tr td.active.highlighted.dropdown-toggle {
        color: #ffffff;
        background-color: #0a6beb;
        border-color: #0a6beb;
    }
    </style>



    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('template/global/fonts/font-awesome/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/fonts/web-icons/web-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/fonts/material-design/material-design.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/fonts/brand-icons/brand-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/global/fonts/glyphicons/glyphicons.css') }}">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>

    <!--[if lt IE 9]>
    <script src="{{ asset('template/global/vendor/html5shiv/html5shiv.min.js') }}"></script>
    <![endif]-->

    <!--[if lt IE 10]>
    <script src="{{ asset('template/global/vendor/media-match/media.match.min.js') }}"></script>
    <script src="{{ asset('template/global/vendor/respond/respond.min.js') }}"></script>
    <![endif]-->

    <!-- Scripts -->
    <script src="{{ asset('template/global/vendor/breakpoints/breakpoints.js') }}"></script>
    <script>
    Breakpoints();
    </script>
</head>

<body class="animsition ecommerce_dashboard">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega" role="navigation">

        <div class="navbar-header">
            <button type="button" class="navbar-toggler hamburger hamburger-close navbar-toggler-left hided"
                data-toggle="menubar">
                <span class="sr-only">Toggle navigation</span>
                <span class="hamburger-bar"></span>
            </button>
            <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-collapse"
                data-toggle="collapse">
                <i class="icon wb-more-horizontal" aria-hidden="true"></i>
            </button>
            <div class="navbar-brand navbar-brand-center site-gridmenu-toggle" data-toggle="gridmenu">
                <span class="navbar-brand-logo">
                    <img class="brand-img" src="{{ asset('template/assets//images/logo-colored.png') }}" alt="...">
                </span>
                <span class="navbar-brand-text hidden-xs-down">Olshopedia</span>
            </div>
            <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-search"
                data-toggle="collapse">
                <span class="sr-only">Toggle Search</span>
                <i class="icon wb-search" aria-hidden="true"></i>
            </button>
        </div>

        <div class="navbar-container container-fluid">
            <!-- Navbar Collapse -->
            <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
                <!-- Navbar Toolbar -->
                <ul class="nav navbar-toolbar">
                    <li class="nav-item hidden-float" id="toggleMenubar">
                        <a class="nav-link" data-toggle="menubar" href="#" role="button">
                            <i class="icon hamburger hamburger-arrow-left">
                                <span class="sr-only">Toggle menubar</span>
                                <span class="hamburger-bar"></span>
                            </i>
                        </a>
                    </li>
                </ul>
                <!-- End Navbar Toolbar -->

                <!-- Navbar Toolbar Right -->
                <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)" data-animation="scale-up"
                            aria-expanded="false" role="button">
                            @php
                            $bahasa = (Session::has('locale')) ? Session::get('locale') : 'id';
                            $tampil_bahasa = ($bahasa == 'en') ? 'gb' : $bahasa;
                            @endphp
                            <span class="flag-icon flag-icon-{{ $tampil_bahasa }}"></span>
                        </a>
                        <div class="dropdown-menu" role="menu">
                            <a class="dropdown-item" id='langBtn-en'
                                href="{{ route('b.locale') }}?lang=en&next={{ urlencode(url()->current()) }}"
                                role="menuitem">
                                <span class="flag-icon flag-icon-gb"></span> English</a>
                            <a class="dropdown-item" id='langBtn-id'
                                href="{{ route('b.locale') }}?lang=id&next={{ urlencode(url()->current()) }}"
                                role="menuitem">
                                <span class="flag-icon flag-icon-id"></span> Indonesia</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link navbar-avatar" data-toggle="dropdown" href="#" aria-expanded="false"
                            data-animation="scale-up" role="button" style='padding-top:1.586rem'>
                            <span class='text-center'>
                                {{ Auth::user()->name }}
                            </span>
                        </a>
                        <div class="dropdown-menu" role="menu">
                            <a class="dropdown-item" href="javascript:void(0)" role="menuitem" onClick="pageLoad('{{ route('b.profil-index') }}');$(this).parent().parent().children('a').dropdown('toggle')">
                                <i class="icon wb-user" aria-hidden="true"></i> @lang("index.profil")
                            </a>
                            <a class="dropdown-item" href="javascript:void(0)" role="menuitem" onClick="pageLoad('{{ route('b.setting-index') }}');$(this).parent().parent().children('a').dropdown('toggle')" >
                                <i class="icon wb-settings" aria-hidden="true"></i> @lang("index.pengaturan")
                            </a>
                            <div class="dropdown-divider" role="presentation"></div>
                            <form id="logout-form" action="{{ route('b.logout') }}" method="POST"
                                style="display: none;">{{ csrf_field() }}</form>
                            <a class="dropdown-item" href="{{ route('b.logout') }}" role="menuitem"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                    class="icon wb-power" aria-hidden="true"></i> Logout</a>
                        </div>
                    </li>
                </ul>
                <!-- End Navbar Toolbar Right -->
            </div>
            <!-- End Navbar Collapse -->

        </div>
    </nav>
    @php
        $id_user = Auth::user()->id;
        $data_user = \DB::table('t_user_meta')
            ->where('user_id', $id_user)
            ->select('role', 'ijin')
            ->get()->first();
        if(isset($data_user)){
            if(isset($data_user->ijin)){
                $ijin = json_decode($data_user->ijin);
            } else {
                $ijin = new \stdclass();
                $ijin->menuExpense = 1;
                $ijin->melihatAnalisa = 1;
            }
        } else {
            $ijin = new \stdclass();
            $ijin->menuExpense = 1;
            $ijin->melihatAnalisa = 1;
        }
    @endphp
    <div class="site-menubar">
        <div class="site-menubar-body">
            <ul class="site-menu" data-plugin="menu">
                <li class="site-menu-category">Menu</li>
                <li class="site-menu-item">
                    <a class="animsition-link menuLoad" href="{{ route('b.dashboard') }}">
                        <!-- onClick="pageLoad('{{ route('b.dashboard') }}', $(this))"> -->
                        <i class="site-menu-icon wb-dashboard" aria-hidden="true"></i>
                        <span class="site-menu-title">@lang("index.dasbor")</span>
                    </a>
                </li>
                <li class="site-menu-item has-sub">
                    <a href="javascript:void(0)">
                        <i class="site-menu-icon md-shopping-cart" aria-hidden="true"></i>
                        <span class="site-menu-title">@lang("index.order")</span>
                        <span class="site-menu-arrow"></span>
                    </a>
                    <ul class="site-menu-sub">
                        <li class="site-menu-item">
                            <a class="animsition-link menuLoad" href="{{ route('b.order-index') }}">
                                <!-- onClick="pageLoad('{{ route('b.order-index') }}', $(this))"> -->
                                <span class="site-menu-title">@lang("index.semua_order")</span>
                            </a>
                        </li>
                        <li class="site-menu-item">
                            <a class="animsition-link menuLoad" href="{{ route('b.order-cancel') }}">
                                <!-- onClick="pageLoad('{{ route('b.order-cancel') }}', $(this))"> -->
                                <span class="site-menu-title">@lang("index.canceled_order")</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="site-menu-item has-sub">
                    <a href="javascript:void(0)">
                        <i class="site-menu-icon fa fa-cubes" aria-hidden="true"></i>
                        <span class="site-menu-title">@lang("index.produk")</span>
                        <span class="site-menu-arrow"></span>
                    </a>
                    <ul class="site-menu-sub">
                        <li class="site-menu-item">
                            <a class="animsition-link menuLoad" href="{{ route('b.produk-index') }}">
                                <!-- onClick="pageLoad('{{ route('b.produk-index') }}', $(this))"> -->
                                <span class="site-menu-title">@lang("index.daftar_produk")</span>
                            </a>
                        </li>
                        <li class="site-menu-item">
                            <a class="animsition-link menuLoad" href="{{ route('b.produkKategori-index') }}">
                                <!-- onClick="pageLoad('{{ route('b.produkKategori-index') }}', $(this))"> -->
                                <span class="site-menu-title">@lang("index.daftar_kategori_produk")</span>
                            </a>
                        </li>
                        <li class="site-menu-item">
                            <a class="animsition-link menuLoad" href="{{ route('b.produk-beli') }}">
                                <!-- onClick="pageLoad('{{ route('b.produk-index') }}', $(this))"> -->
                                <span class="site-menu-title">@lang("index.beli_produk")</span>
                            </a>
                        </li>
                        <li class="site-menu-item">
                            <a class="animsition-link menuLoad" href="{{ route('b.produk-dataBeli') }}">
                                <!-- onClick="pageLoad('{{ route('b.produk-index') }}', $(this))"> -->
                                <span class="site-menu-title">@lang("index.data_beli_produk")</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="site-menu-item">
                    <a class="animsition-link menuLoad" href="{{ route('b.customer-index') }}">
                        <!-- onClick="pageLoad('{{ route('b.customer-index') }}', $(this))"> -->
                        <i class="site-menu-icon wb-users" aria-hidden="true"></i>
                        <span class="site-menu-title">@lang("index.customer")</span>
                    </a>
                </li>
                <li class="site-menu-item">
                    <a class="animsition-link menuLoad" href="{{ route('b.supplier-index') }}">
                        <!-- onClick="pageLoad('{{ route('b.customer-index') }}', $(this))"> -->
                        <i class="site-menu-icon fa-user" aria-hidden="true"></i>
                        <span class="site-menu-title">@lang("index.supplier")</span>
                    </a>
                </li>
                @if(($data_user->role == 'Admin' && $ijin->menuExpense === 1) || $data_user->role == 'Owner')
                <li class="site-menu-item">
                    <a class="animsition-link menuLoad" href="{{ route('b.expense-index') }}">
                        <!-- onClick="pageLoad('{{ route('b.expense-index') }}', $(this))"> -->
                        <i class="site-menu-icon fa fa-money" aria-hidden="true"></i>
                        <span class="site-menu-title">@lang("index.expense")</span>
                    </a>
                </li>
                @endif
                @if(($data_user->role == 'Admin' && $ijin->melihatAnalisa === 1) || $data_user->role == 'Owner')
                <li class="site-menu-item">
                    <a class="animsition-link menuLoad" href="{{ route('b.analisa-index') }}">
                        <!-- onClick="pageLoad('{{ route('b.analisa-index') }}', $(this))"> -->
                        <i class="site-menu-icon fa-line-chart" aria-hidden="true"></i>
                        <span class="site-menu-title">@lang("index.analisa")</span>
                    </a>
                </li>
                @endif
                @if($data_user->role == 'Owner')
                <li class="site-menu-item">
                    <a class="animsition-link menuLoad" href="{{ route('b.laporan-index') }}">
                        <!-- onClick="pageLoad('{{ route('b.laporan-index') }}', $(this))"> -->
                        <i class="site-menu-icon fa-area-chart" aria-hidden="true"></i>
                        <span class="site-menu-title">@lang("index.laporan")</span>
                    </a>
                </li>
                <li class="site-menu-item">
                    <a class="animsition-link menuLoad" href="{{ route('b.addons-index') }}">
                        <i class="site-menu-icon fa-puzzle-piece" aria-hidden="true"></i>
                        <span class="site-menu-title">@lang("index.addons")</span>
                    </a>
                </li>
                <li class="site-menu-item">
                    <a class="animsition-link menuLoad" href="{{ route('b.setting-index') }}">
                        <!-- onClick="pageLoad('{{ route('b.setting-index') }}', $(this))"> -->
                        <i class="site-menu-icon wb-settings" aria-hidden="true"></i>
                        <span class="site-menu-title">@lang("index.pengaturan")</span>
                    </a>
                </li>
                @endif
                <li class="site-menu-category">Tentang Olshopedia</li>
                <li class="site-menu-item">
                    <a class="animsition-link menuLoad" href="{{ route('b.tentang-versionHistory') }}"> 
                    <!-- onClick="pageLoad('{{ route('b.tentang-versionHistory') }}', $(this))"> -->
                        <i class="site-menu-icon fa-file-text" aria-hidden="true"></i>
                        <span class="site-menu-title">@lang("index.riwayat_versi")</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Page -->
    <div class="page">
        @yield('isi')
    </div>
    <!-- End Page -->


    <!-- Footer -->
    <footer class="site-footer">
        <div class="site-footer-legal">© 2020 <a href="#">Olshopedia</a></div>
        <div class="site-footer-right">
            v0.9.5
        </div>
    </footer>

    <!-- Core  -->
    <script src='{{ asset("jquery-ui-1.12.1.custom/jquery-ui.js") }}'></script>
    <script src='{{ asset("js/jquery-migrate-3.0.0.min.js") }}'></script>
    <script src="{{ asset('template/global/vendor/babel-external-helpers/babel-external-helpers.js') }}"></script>
    <script src="{{ asset('template/global/vendor/popper-js/umd/popper.min.js') }}"></script>
    <script src="{{ asset('template/global/vendor/bootstrap/bootstrap.js') }}"></script>
    <script src="{{ asset('template/global/vendor/animsition/animsition.js') }}"></script>
    <script src="{{ asset('template/global/vendor/mousewheel/jquery.mousewheel.js') }}"></script>
    <script src="{{ asset('template/global/vendor/asscrollbar/jquery-asScrollbar.js') }}"></script>
    <script src="{{ asset('template/global/vendor/asscrollable/jquery-asScrollable.js') }}"></script>
    <script src="{{ asset('template/global/vendor/ashoverscroll/jquery-asHoverScroll.js') }}"></script>

    <!-- Plugins -->
    <script src="{{ asset('template/global/vendor/switchery/switchery.js') }}"></script>
    <script src="{{ asset('template/global/vendor/intro-js/intro.js') }}"></script>
    <script src="{{ asset('template/global/vendor/screenfull/screenfull.js') }}"></script>
    <script src="{{ asset('template/global/vendor/slidepanel/jquery-slidePanel.js') }}"></script>
    <script src="{{ asset('template/global/vendor/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('template/global/vendor/webui-popover/jquery.webui-popover.min.js') }}"></script>
    <script src="{{ asset('template/global/vendor/toolbar/jquery.toolbar.js') }}"></script>
    <script src="{{ asset('template/global/vendor/aspieprogress/jquery-asPieProgress.js') }}"></script>
    <script src="{{ asset('template/global/vendor/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('template/global/vendor/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('template/global/vendor/datatables.net-fixedheader/dataTables.fixedHeader.js') }}"></script>
    <script src="{{ asset('template/global/vendor/datatables.net-fixedcolumns/dataTables.fixedColumns.js') }}"></script>
    <script src="{{ asset('template/global/vendor/datatables.net-rowgroup/dataTables.rowGroup.js') }}"></script>
    <script src="{{ asset('template/global/vendor/datatables.net-scroller/dataTables.scroller.js') }}"></script>
    <script src="{{ asset('template/global/vendor/datatables.net-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('template/global/vendor/datatables.net-responsive-bs4/responsive.bootstrap4.js') }}"></script>
    <script src="{{ asset('template/global/vendor/datatables.net-buttons/dataTables.buttons.js') }}"></script>
    <script src="{{ asset('template/global/vendor/datatables.net-buttons/buttons.html5.js') }}"></script>
    <script src="{{ asset('template/global/vendor/datatables.net-buttons/buttons.flash.js') }}"></script>
    <script src="{{ asset('template/global/vendor/datatables.net-buttons/buttons.print.js') }}"></script>
    <script src="{{ asset('template/global/vendor/datatables.net-buttons/buttons.colVis.js') }}"></script>
    <script src="{{ asset('template/global/vendor/datatables.net-buttons-bs4/buttons.bootstrap4.js') }}"></script>
    <script src="{{ asset('template/global/vendor/asrange/jquery-asRange.min.js') }}"></script>
    <script src="{{ asset('template/global/vendor/bootbox/bootbox.js') }}"></script>
    <script src="{{ asset('template/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('template/global/vendor/icheck/icheck.min.js') }}"></script>
    <script src="{{ asset('template/global/vendor/dropify/dropify.min.js') }}"></script>
    <script src="{{ asset('template/global/vendor/bootstrap-touchspin/bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ asset('template/global/vendor/chart-js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/password/password.min.js') }}"></script>
    <script src="{{ asset('template/global/vendor/summernote/summernote.min.js') }}"></script>
    <script src="{{ asset('template/global/vendor/ladda/spin.min.js') }}"></script>
    <script src="{{ asset('template/global/vendor/ladda/ladda.min.js') }}"></script>


    <!-- Scripts -->
    <script src="{{ asset('template/global/js/Component.js') }}"></script>
    <script src="{{ asset('template/global/js/Plugin.js') }}"></script>
    <script src="{{ asset('template/global/js/Base.js') }}"></script>
    <script src="{{ asset('template/global/js/Config.js') }}"></script>

    <script src="{{ asset('template/assets/js/Section/Menubar.js') }}"></script>
    <script src="{{ asset('template/assets/js/Section/GridMenu.js') }}"></script>
    <script src="{{ asset('template/assets/js/Section/Sidebar.js') }}"></script>
    <script src="{{ asset('template/assets/js/Section/PageAside.js') }}"></script>
    <script src="{{ asset('template/assets/js/Plugin/menu.js') }}"></script>

    <script src="{{ asset('template/global/js/config/colors.js') }}"></script>
    <script src="{{ asset('template/assets/js/config/tour.js') }}"></script>
    <script>
    Config.set('assets', '../../assets');
    </script>

    <!-- Page -->
    <script src="{{ asset('template/assets/js/Site.js') }}"></script>
    <script src="{{ asset('template/global/js/Plugin/asscrollable.js') }}"></script>
    <script src="{{ asset('template/global/js/Plugin/slidepanel.js') }}"></script>
    <script src="{{ asset('template/global/js/Plugin/switchery.js') }}"></script>
    <script src="{{ asset('template/global/js/Plugin/aspieprogress.js') }}"></script>
    <script src="{{ asset('template/global/js/Plugin/datatables.js') }}"></script>
    <script src="{{ asset('template/global/js/Plugin/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('template/global/js/Plugin/icheck.js') }}"></script>
    <script src="{{ asset('template/global/js/Plugin/webui-popover.js') }}"></script>
    <script src="{{ asset('template/assets/examples/js/uikit/tooltip-popover.js')}}"></script>
    <script src="{{ asset('template/global/js/Plugin/dropify.js') }}"></script>
    <script src="{{ asset('template/global/js/Plugin/bootstrap-select.js') }}"></script>
    <script src="{{ asset('template/global/js/Plugin/bootstrap-touchspin.js') }}"></script>
    <script src="{{ asset('template/global/js/Plugin/summernote.js') }}"></script>
    <script>
    

    function pageLoad(urlTujuan, elm = null) {
        var hasil;
        $.ajax({
            type: 'get',
            url: urlTujuan,
            beforeSend: function() {
                $('.page').html(
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
                    $('.page').html(
                        '<div style="top:50%;left:50%;position:absolute"><div class="loader vertical-align-middle loader-grill"></div></div>'
                    );
                }, false);
                xhr.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        // console.log(percentComplete);
                    }
                    $('.page').html(
                        '<div style="top:50%;left:50%;position:absolute"><div class="loader vertical-align-middle loader-grill"></div></div>'
                    );
                }, false);
                return xhr;
            },
            success: function(data, textStatus, xhr) {
                if($.trim(data) == 'dari_ajax_butuh_login'){
                    return $(location).attr("href", "{{ route('b.dashboard') }}");
                }
                hasil = data;
            },
            error: function(xhr, b, c) {
                swal("Error", '' + c, "error");
                $('.page').html('error');
            }
        }).done(function() {
            $('.page').html(hasil.data);
            if(elm != null){
                var list = Array.prototype.slice.call($(".site-menu-item"));
                list.forEach(function(html) {
                    if($(html).hasClass("active")){
                        $(html).removeClass("active");
                    }
                });
                elm.parent().addClass("active");
            }
            window.history.pushState('forward', null, urlTujuan);
            $('#langBtn-id').attr('href', "{{ route('b.locale') }}?lang=id&next="+encodeURIComponent($(location).attr('href')));
            $('#langBtn-en').attr('href', "{{ route('b.locale') }}?lang=id&next="+encodeURIComponent($(location).attr('href')));
        });
    }

    jQuery(document).ready(function($) {

        $('.menuLoad').on('click', (e) => {
            e.preventDefault();

            //fix bug pada addon timer
            if(typeof timer_interval !== 'undefined' && typeof timer_interval !== 'false'){
                clearInterval(timer_interval);
            }

            var urlTujuan = $(e.currentTarget).attr('href');
            var elm = $(e.currentTarget);
            var hasil;
            $.ajax({
                type: 'get',
                url: urlTujuan,
                beforeSend: function() {
                    $('.page').html(
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
                        $('.page').html(
                            '<div style="top:50%;left:50%;position:absolute"><div class="loader vertical-align-middle loader-grill"></div></div>'
                        );
                    }, false);
                    xhr.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            // console.log(percentComplete);
                        }
                        $('.page').html(
                            '<div style="top:50%;left:50%;position:absolute"><div class="loader vertical-align-middle loader-grill"></div></div>'
                        );
                    }, false);
                    return xhr;
                },
                success: function(data, textStatus, xhr) {
                    if($.trim(data) == 'dari_ajax_butuh_login'){
                        return $(location).attr("href", "{{ route('b.dashboard') }}");
                    }
                    hasil = data;
                },
                error: function(xhr, b, c) {
                    swal("Error", '' + c, "error");
                    $('.page').html('error');
                }
            }).done(function() {
                $('.page').html(hasil.data);
                if(elm != null){
                    var list = Array.prototype.slice.call($(".site-menu-item"));
                    list.forEach(function(html) {
                        if($(html).hasClass("active")){
                            $(html).removeClass("active");
                        }
                    });
                    elm.parent().addClass("active");
                }
                window.history.pushState('forward', null, urlTujuan);
                $('#langBtn-id').attr('href', "{{ route('b.locale') }}?lang=id&next="+encodeURIComponent($(location).attr('href')));
                $('#langBtn-en').attr('href', "{{ route('b.locale') }}?lang=id&next="+encodeURIComponent($(location).attr('href')));
            }); 
        });

        if (window.history && window.history.pushState) {
            $(window).on('popstate', function() {
                location.reload();
            });
        }
    });
    </script>
</body>

</html>