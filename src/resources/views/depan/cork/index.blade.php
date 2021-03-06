
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>{{ $toko->nama_toko }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('template_depan/cork/assets/img/favicon.ico') }}" />
    
    <script src="{{ asset('template_depan/cork/assets/js/libs/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('template_depan/cork/plugins/input-mask/jquery.inputmask.bundle.min.js') }}"></script>
    
    <link href="{{ asset('template_depan/cork/assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('template_depan/cork/assets/js/loader.js') }}"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('template_depan/cork/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template_depan/cork/assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{ asset('template_depan/cork/plugins/font-icons/fontawesome/css/regular.css') }}">
    <link rel="stylesheet" href="{{ asset('template_depan/cork/plugins/font-icons/fontawesome/css/fontawesome.css') }}">
    <link href="{{ asset('template_depan/cork/assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('template_depan/cork/plugins/select2/select2.min.css') }}">

    <script src="{{ asset('template_depan/cork/plugins/sweetalerts/promise-polyfill.js') }}"></script>
    <link href="{{ asset('template_depan/cork/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template_depan/cork/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template_depan/cork/assets/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template_depan/cork/assets/css/apps/invoice.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('template_depan/cork/assets/css/forms/theme-checkbox-radio.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('template_depan/cork/assets/css/forms/switches.css') }}">
    <link href="{{ asset('template_depan/cork/plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('template_depan/cork/plugins/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/pearls.css') }}">
    <style>
        .navbar .navbar-item .nav-item.user-profile-dropdown .dropdown-menu .dropdown-item button[type=submit] {
            display: block;
            color: #3b3f5c;
            font-size: 13px;
            font-weight: 600;
            padding: 9px 30px;
            border: none;
            background: transparent
        }
        #loader-div {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.75);
            z-index: 10000;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: center;
            justify-content: center;
        }
    </style>
</head>

<body class="alt-menu">
    <div id="loader-div">
        <div class="text-center">
            <div class="spinner-border align-self-center loader-lg" style='color:white;width:100px;height:100px'></div>
        </div>
    </div>
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>

    <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm">

            <ul class="navbar-item theme-brand flex-row  text-center">
                @php
                    if(isset($toko->foto_id)){
                        $foto = \DB::table('t_foto')
                            ->where('data_of', \App\Http\Controllers\PusatController::dataOfByDomainToko($toko->domain_toko))
                            ->where('id_foto', $toko->foto_id)
                            ->get()->first();
                        if(isset($foto->path)){
                            @endphp
                            <li class="nav-item theme-logo">
                                <a href="{{ route('d.home', ['domain_toko' => $toko->domain_toko]) }}">
                                    <img src="{{ asset($foto->path) }}" class="navbar-logo" alt="logo">
                                </a>
                            </li>
                            @php
                        }
                    }
                @endphp
                <li class="nav-item theme-text">
                    <a href="{{ route('d.home', ['domain_toko' => $toko->domain_toko]) }}" class="nav-link">{{ $toko->nama_toko }}</a>
                </li>
            </ul>

            <ul class="navbar-item flex-row ml-md-auto">
                @if(\Auth::check())
                <li class="nav-item dropdown user-profile-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <svg xmlns="http://www.w3.org/2000/svg" style='color:white;' width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                        <div class="">
                            <div class="dropdown-item">
                                <a class="" href="user_profile.html"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg> My Profile</a>
                            </div>
                            <div class="dropdown-item">
                                <a class="" href="apps_mailbox.html"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-inbox">
                                        <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline>
                                        <path
                                            d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z">
                                        </path>
                                    </svg> Inbox</a>
                            </div>
                            <div class="dropdown-item">
                                <a class="" href="auth_lockscreen.html"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-lock">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg> Lock Screen</a>
                            </div>
                            <div class="dropdown-item">
                                <form action='{{ route("d.logout", ["domain_toko" => $toko->domain_toko]) }}' method='post'>
                                    {{ csrf_field() }}
                                    <button type='submit'><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-log-out">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                            <polyline points="16 17 21 12 16 7"></polyline>
                                            <line x1="21" y1="12" x2="9" y2="12"></line>
                                        </svg> Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
                @else
                <li class="nav-item dropdown message-dropdown">
                    <a href="{{ route('d.login', ['domain_toko' => $toko->domain_toko]) }}" class="nav-link" id="login" aria-haspopup="true" aria-expanded="true" style='color:white;'>
                        Login
                    </a>
                </li>
                <li class="nav-item dropdown user-profile-dropdown">
                    <a href="{{ route('d.register', ['domain_toko' => $toko->domain_toko]) }}" class="nav-link user" id="register" aria-haspopup="true" aria-expanded="true" style='color:white;'>
                        Register
                    </a>
                </li>
                @endif
            </ul>
        </header>
    </div>

    @php
        $cart_count = count(\Cart::session(request()->getClientIp())->getContent());
        $hidden = $cart_count > 0 ? '' : 'display:none;';
    @endphp

    <div class="sub-header-container">
        <header class="header navbar navbar-expand-sm">
            <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom">
                <svg
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-menu">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </a>

            <ul class="navbar-nav flex-row">
                <li>
                    <div class="page-header">
                        <nav class="breadcrumb-one" aria-label="breadcrumb">
                            @yield('page')
                        </nav>
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav flex-row ml-auto ">
                <li class="nav-item more-dropdown">
                    <div class="custom-dropdown-icon">
                        <a href="{{ route('d.cart-index', ['domain_toko' => $toko->domain_toko]) }}" class='btn btn-outline-dark mt-1'>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                            </svg>
                            Cart
                            <span class="badge badge-danger counter" style='{{ $hidden }}' id="badgeCart">{{ $cart_count }}</span>
                        </a>
                    </div>
                </li>
            </ul>
        </header>
    </div>

    <div class="main-container sidebar-closed sbar-open" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <div class="sidebar-wrapper sidebar-theme">
            <nav id="sidebar">
                <div class="shadow-bottom"></div>
                <ul class="list-unstyled menu-categories ps" id="accordionExample">
                    <li class="menu">
                        <a href="{{ route('d.home', ['domain_toko' => $toko->domain_toko]) }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                                <span> Home</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu">
                        <a href="{{ route('d.cart-index', ['domain_toko' => $toko->domain_toko]) }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                </svg>
                                Cart
                            </div>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                @yield('isi')
            </div>
            <div class="footer-wrapper" style='margin-top:15px'>
                <div class="footer-section f-section-1">
                    <p class="">Copyright © 2020 <a target="_blank" href="https://designreset.com">DesignReset</a>, All
                        rights reserved.</p>
                </div>
                <div class="footer-section f-section-2">
                    <p class="">Olshopedia</p>
                </div>
            </div>
        </div>

    </div>

    <script src="{{ asset('template_depan/cork/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('template_depan/cork/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('template_depan/cork/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('template_depan/cork/assets/js/app.js') }}"></script>
    <script>

    function uangFormat(number) {
        var sp = number.toString().split("").reverse();
        var yt = 0;
        var te = "";
        $.each(sp, function(i, v) {
            if (yt === 3) {
                te += ".";
                yt = 0;
            }
            te += v;
            yt++;
        });
        var hasil = te.split("").reverse().join("");
        return hasil;
    }

    $(document).ready(function() {
        App.init();

        $('.angkaSaja').on('input', function(){
            this.value = this.value.replace(/[^0-9]/, '');
        });

        $('#btnCari').on('click', function(){
            $(location).attr('href', '{{ route("d.home", ["toko_slug" => $toko->domain_toko]) }}?q='+$('#queryCari').val()+'@if($r["sort"] !== "")&sort={{$r["sort"]}}@endif');
        });

        $('#queryCari').keyup(function(e){
            if(e.keyCode == 13){
                $('#btnCari').trigger("click");
            }
        });
    });
    </script>
    <script src="{{ asset('template_depan/cork/assets/js/custom.js') }}"></script>
    <script src="{{ asset('template_depan/cork/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('template_depan/cork/plugins/select2/custom-select2.js') }}"></script>
    <script src="{{ asset('template_depan/cork/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('template_depan/cork/plugins/sweetalerts/custom-sweetalert.js') }}"></script>
    <script src="{{ asset('template_depan/cork/plugins/input-mask/input-mask.js') }}"></script>
    <script src="{{ asset('template_depan/cork/assets/js/apps/invoice.js') }}"></script>
    <script src="{{ asset('template_depan/cork/assets/js/scrollspyNav.js') }}"></script>
    <script src="{{ asset('template_depan/cork/plugins/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('template_depan/cork/plugins/flatpickr/custom-flatpickr.js') }}"></script>

</body>

</html>