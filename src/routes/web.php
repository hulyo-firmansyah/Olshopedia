<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//    D:\Installed\xampp\apache\conf\httpd.conf   (DocumentRoot)
//    D:\Installed\xampp\apache\conf\extra/httpd-vhosts.conf   
//    C:\Windows\System32\drivers\etc\hosts  

// Route::domain('app.localhost/olshopedia')->group(function () {
    
    //login dan register
    Route::get('/login', 'belakang\auth\LoginController@showLoginForm')->name('b.login');
    Route::post('/login', 'belakang\auth\LoginController@login');
    Route::post('/logout', 'belakang\auth\LoginController@logout')->name('b.logout');
    Route::get('/register', 'belakang\auth\RegisterController@showRegistrationForm')->name('b.register');
    Route::post('/register', 'belakang\auth\RegisterController@register');
    
    //Verification Email dan Forgot Password
    Route::get('/verified/{token}','belakang\auth\AccountVerifiedController@verified')->name('b.email-verified');
    Route::get('/resendMail', 'belakang\auth\AccountVerifiedController@resendMail')->name('b.email-resendMail');
    Route::get('/passMailSend', 'belakang\auth\ForgotPasswordController@passMailSend')->name('b.password-email');
    Route::get('/resetPass/{mail}-{token}', 'belakang\auth\ForgotPasswordController@showFormResetPass')->name('b.password-resetPass');
    Route::get('/renewPassword','belakang\auth\ForgotPasswordController@renewPassword')->name('b.password-renewPassword');
    Route::get('/forgotPassword', 'belakang\auth\ForgotPasswordController@showLinkRequestForm')->name('b.password-forgotPassword');
    

    Route::get('/version_history', 'belakang\TentangController@versionHistory')->name('b.tentang-versionHistory');


    //index dan locale
    Route::get('/', 'belakang\DashboardController@index')->name("b.dashboard");
    // Route::get('/optimize', 'belakang\DashboardController@optimize')->name("b.optimize");
    Route::get('/locale', 'belakang\DashboardController@locale')->name("b.locale");
    
    //Ajax
    Route::prefix('ajax')->group(function(){
        Route::get('/getWilayah', 'belakang\AjaxController@getWilayah')->name("b.ajax-getWilayah");
        Route::get('/getWilayahDetail', 'belakang\AjaxController@getWilayahDetail')->name("b.ajax-getWilayahDetail");
        Route::get('/getProduk', 'belakang\AjaxController@getProduk')->name("b.ajax-getProduk");
        Route::get('/getProdukById', 'belakang\AjaxController@getProdukById')->name("b.ajax-getProdukById");
        Route::get('/getOffsetProdukAkhirById', 'belakang\AjaxController@getOffsetProdukAkhirById')->name("b.ajax-getOffsetProdukAkhirById");
        Route::get('/cariKecamatan', 'belakang\AjaxController@cariKecamatan')->name("b.ajax-cariKecamatan");
        Route::get('/get-ProdukDetail', 'belakang\AjaxController@getProdukDetail')->name("b.ajax-getProdukDetail");
        Route::get('/get-Customer', 'belakang\AjaxController@getCustomer')->name("b.ajax-getCustomer");
    });

    //Profile User
    Route::prefix('profil')->group(function(){
        Route::get('/', 'belakang\ProfileController@index')->name('b.profil-index');
        Route::post('/updateProfile', 'belakang\ProfileController@updateProfile')->name('b.profil-update');
    });

    //Analisa
    Route::prefix('analisa')->group(function(){
        Route::get('/', 'belakang\AnalisaController@analisaIndex')->name("b.analisa-index");
        Route::get('/best-customer', 'belakang\AnalisaController@bestCustomerIndex')->name("b.analisa-bestCustomer");
        Route::get('/best-produk', 'belakang\AnalisaController@bestProdukIndex')->name("b.analisa-bestProduk");
        Route::get('/lokasi-customer', 'belakang\AnalisaController@customerLokasiIndex')->name("b.analisa-customerLokasi");
    });

    //Laporan
    Route::prefix('laporan')->group(function(){
        Route::get('/', 'belakang\LaporanController@laporanIndex')->name("b.laporan-index");
        Route::get('/getTransaksiData', 'belakang\LaporanController@getTransaksiData')->name("b.laporan-getTransaksiData");
    });

    //Setting Store
    Route::prefix('setting')->group(function(){
        Route::get('/', 'belakang\SettingController@index')->name("b.setting-index");
        Route::post('/proses', 'belakang\SettingController@proses')->name("b.setting-proses");
        Route::get('/getUserData', 'belakang\SettingController@getDataUsers')->name('b.setting-getUserData');
        Route::get('/getPaymentData', 'belakang\SettingController@getPaymentData')->name("b.setting-getPaymentData");
        Route::get('/getOrderSourceData', 'belakang\SettingController@getOrderSourceData')->name('b.setting-getOrderSourceData');
        Route::get('/getFilterOrderData', 'belakang\SettingController@getFilterOrderData')->name('b.setting-getFilterOrderData');
    });

    Route::prefix('print_label')->group(function(){
        Route::post('/simpan', 'belakang\PrintController@simpan')->name("b.print-simpan");
        Route::get('/{target?}', 'belakang\PrintController@index')->name("b.print-index");
    });

    //log
    Route::prefix('log')->group(function(){
        Route::get('/', 'belakang\LogController@index')->name('b.log-index');
        Route::get('/deleteLog', 'belakang\LogController@deleteLog')->name('b.log-deleteLog');
    });

    //produk
    Route::prefix('produk')->group(function(){  
        Route::get('/semua', 'belakang\ProdukController@produkIndex')->name("b.produk-index");
        Route::get('/beli', 'belakang\ProdukController@beliProdukIndex')->name("b.produk-beli");
        Route::get('/data-beli', 'belakang\ProdukController@dataBeliProdukIndex')->name("b.produk-dataBeli");
        Route::get('/data-beli/edit/{target?}', 'belakang\ProdukController@dataBeliProdukEdit')->name("b.produk-dataBeli_edit");
        Route::get('/data-beli/print/{target?}', 'belakang\ProdukController@dataBeliProdukPrint')->name("b.produk-dataBeli_print");
        Route::get('/', 'belakang\ProdukController@redirectIndex');
        Route::get('/{id_produk?}/edit', 'belakang\ProdukController@editProduk')->name("b.produk-edit");
        Route::post('/proses', 'belakang\ProdukController@prosesProduk')->name("b.produk-proses");
        Route::post('/edit_langsung', 'belakang\ProdukController@editLangsungProduk')->name("b.produk-editLangsung");
        Route::post('/beli_proses', 'belakang\ProdukController@beliProsesProduk')->name("b.produk-beliProses");
        Route::get('/tambah', 'belakang\ProdukController@tambahProduk')->name("b.produk-tambah");
        Route::get('/tambahFormWithOffset', 'belakang\ProdukController@tambahFormProdukWithOffset')->name("b.produk-tambahFormProdukWithOffset");
        Route::get('/tambahForm', 'belakang\ProdukController@tambahFormProduk')->name("b.produk-tambahForm");
        Route::get('/tambahModalFoto', 'belakang\ProdukController@tambahModalFoto')->name("b.produk-tambahModalFoto");
        Route::get('/{id_produk?}/detail', 'belakang\ProdukController@detailIndex')->name("b.produk-detail");
        Route::get('/getData', 'belakang\ProdukController@getProduk')->name("b.produk-getData");
        Route::get('/getProdukBeliData', 'belakang\ProdukController@getProdukBeliData')->name("b.produk-getProdukBeliData");
        Route::get('/getDataBeli', 'belakang\ProdukController@getProdukBeli')->name("b.produk-getDataBeli");
        Route::get('/getProdukData', 'belakang\ProdukController@getProdukData')->name("b.produk-getProdukData");
        Route::get('/getRiwayatStokData', 'belakang\ProdukController@getRiwayatStok')->name("b.produk-getRiwayatStok");
        Route::get('/riwayat-stok/{id_varian?}', 'belakang\ProdukController@riwayatStokIndex')->name("b.produk-riwayatStok");
    });
    
    //produk kategori
    Route::get('/kategori-produk', 'belakang\ProdukKategoriController@produkKategoriIndex')->name("b.produkKategori-index");
    Route::post('/kategori-produk/proses', 'belakang\ProdukKategoriController@prosesProdukKategori')->name("b.produkKategori-proses");
    Route::get('/kategori-produk-getData', 'belakang\ProdukKategoriController@getProdukKategori')->name("b.produkKategori-getData");
    
    //expense
    Route::get('/expense', 'belakang\ExpenseController@index')->name("b.expense-index");
    Route::post('/expense/proses', 'belakang\ExpenseController@prosesExpense')->name("b.expense-proses");
    Route::get('/expense-getData', 'belakang\ExpenseController@getExpense')->name("b.expense-getData");
    
    //Customer
    Route::prefix('customer')->group(function(){    
        Route::get('/semua', 'belakang\CustomerController@index')->name("b.customer-index");
        Route::get('/', 'belakang\CustomerController@redirectIndex');
        Route::get('/edit', 'belakang\CustomerController@edit')->name("b.customer-edit");
        Route::get('/getData', 'belakang\CustomerController@getCustomer')->name("b.customer-getData");
        Route::get('/{id_user?}/history/', 'belakang\CustomerController@historyIndex')->name("b.customer-history");
        Route::post('/store', 'belakang\CustomerController@store')->name("b.customer-store");    
        Route::post('/update', 'belakang\CustomerController@update')->name("b.customer-update");
        Route::post('/destroy', 'belakang\CustomerController@destroy')->name("b.customer-destroy");
    });

    //Supplier
    Route::prefix('supplier')->group(function(){
        Route::get('/semua', 'belakang\SupplierController@index')->name("b.supplier-index");
        Route::get('/', 'belakang\SupplierController@redirectIndex');
        Route::get('/getData', 'belakang\SupplierController@getData')->name('b.supplier-getData');
        Route::post('/proses', 'belakang\SupplierController@proses')->name("b.supplier-proses");
    });
    
    //order
    Route::prefix('order')->group(function(){
        Route::get('/semua', 'belakang\OrderController@semuaIndex')->name("b.order-index");
        Route::get('/', 'belakang\OrderController@redirectIndex');
        // Route::post('/get-Foto', 'belakang\OrderController@getFoto')->name("b.order-getFoto");
        Route::get('/cekOngkir', 'belakang\OrderController@cekOngkir')->name("b.order-cekOngkir");
        Route::post('/simpan', 'belakang\OrderController@saveOrder')->name("b.order-simpan");
        Route::post('/edit_order', 'belakang\OrderController@editOrder')->name("b.order-editProses");
        Route::get('/tambah', 'belakang\OrderController@orderTambah')->name("b.order-tambah");
        Route::get('/canceled', 'belakang\OrderController@cancelIndex')->name("b.order-cancel");
        Route::post('/proses', 'belakang\OrderController@proses')->name("b.order-proses");
        Route::get('/edit/{id_order?}', 'belakang\OrderController@editIndex')->name("b.order-edit");
        Route::get('/search', 'belakang\OrderController@cariIndex')->name("b.order-search");
        Route::get('/track-resi', 'belakang\OrderController@trackResiIndex')->name("b.order-trackResi");
        Route::get('/lacak-resi/{id_order?}', 'belakang\OrderController@LacakResiIndex')->name("b.order-lacakResi");
        Route::get('/filter', 'belakang\OrderController@filterIndex')->name("b.order-filter");
        Route::get('/{id_order?}/detail', 'belakang\OrderController@detailIndex')->name("b.order-detail");
        // Route::get('/tes', 'belakang\OrderController@testes');   
    });

    Route::prefix('addons')->group(function(){
        Route::get('/', 'belakang\AddonsController@index')->name("b.addons-index");
        Route::get('/notif-resi-email', 'belakang\AddonsController@notifResiEmailIndex')->name("b.addons-notifResiEmail");
        Route::post('/notif-resi-email-proses', 'belakang\AddonsController@simpanNotifResiEmail')->name("b.addons-notifResiEmail_proses");
        Route::post('/notif-resi-email-test', 'belakang\AddonsController@kirimTestNotifResiEmail')->name("b.addons-notifResiEmail_test");
        Route::get('/notif-wa', 'belakang\AddonsController@notifWaIndex')->name("b.addons-notifWa");
        Route::get('/notif-wa-proses', 'belakang\AddonsController@simpanNotifWa')->name("b.addons-notifWa_proses");
        Route::post('/notif-wa-test', 'belakang\AddonsController@kirimTestNotifWa')->name("b.addons-notifWa_test");
    });


    //export/import excel
    Route::prefix("excel")->group(function(){
        Route::get('/export-expense/{format?}','belakang\ExcelController@exportExpense')->name("b.excel-export-expense");
        Route::get('/export-customer/{format?}','belakang\ExcelController@exportCustomer')->name("b.excel-export-customer");
        Route::get('/export-order/{format?}','belakang\ExcelController@exportOrder')->name("b.excel-export-order");
        Route::get('/export-produk/{format?}','belakang\ExcelController@exportProduk')->name("b.excel-export-produk");
        Route::post('/import-produk','belakang\ExcelController@importProduk')->name("b.excel-import-produk");
        Route::post('/import-produk-proses','belakang\ExcelController@importProdukProses')->name("b.excel-import-produk-proses");
        Route::get('/template-produk','belakang\ExcelController@templateProduk')->name("b.excel-template-produk");
        // Route::get('/export-kategori-produk','belakang\ExcelController@exportKategoriProduk')->name("e.export-kategori-produk");
    });

    //storefront
    Route::get('/{domain_toko}', 'depan\HomeController@index')->name("d.home");

    Route::get('/{domain_toko}/register', 'depan\auth\RegisterController@showRegistrationForm')->name("d.register");
    Route::post('/{domain_toko}/register', 'depan\auth\RegisterController@register');
    Route::get('/{domain_toko}/register-proses', 'depan\auth\RegisterController@registerAfter')->name('d.register-after');
    Route::post('/{domain_toko}/register-proses', 'depan\auth\RegisterController@registerProses');

    Route::get('/{domain_toko}/verified/{token}','depan\auth\AccountVerifiedController@verified')->name('d.email-verified');
    Route::post('/{domain_toko}/resendMail', 'depan\auth\AccountVerifiedController@resendMail')->name('d.email-resendMail');

    Route::get('/{domain_toko}/login', 'depan\auth\LoginController@showLoginForm')->name('d.login');
    Route::post('/{domain_toko}/login', 'depan\auth\LoginController@login');
    Route::post('/{domain_toko}/logout', 'depan\auth\LoginController@logout')->name('d.logout');
    
    Route::get('/{domain_toko}/passMailSend', 'depan\auth\ForgotPasswordController@passMailSend')->name('d.password-email');
    Route::get('/{domain_toko}/resetPass/{mail}-{token}', 'depan\auth\ForgotPasswordController@showFormResetPass')->name('d.password-resetPass');
    Route::get('/{domain_toko}/renewPassword','depan\auth\ForgotPasswordController@renewPassword')->name('d.password-renewPassword');
    Route::get('/{domain_toko}/forgotPassword', 'depan\auth\ForgotPasswordController@showLinkRequestForm')->name('d.password-forgotPassword');

    Route::get('/{domain_toko}/produk/{nama_produk?}', 'depan\HomeController@produkIndex')->name("d.produk-index");
    Route::get('/{domain_toko}/cart', 'depan\CartController@tampil')->name('d.cart-index');
    Route::post('/{domain_toko}/cart-tambah', 'depan\CartController@tambah')->name('d.cart-tambah');
    Route::post('/{domain_toko}/cart-hapus', 'depan\CartController@hapus')->name('d.cart-hapus');

    Route::get('/{domain_toko}/guest_checkout', 'depan\CheckoutController@guest_checkout')->name('d.guest-checkout');
    Route::post('/{domain_toko}/proses', 'depan\CheckoutController@proses')->name('d.proses');

    Route::get('/{domain_toko}/order/{order_slug?}', 'depan\OrderController@orderIndex')->name('d.order');
    
// });
// Route::domain('{subdomain}.localhost')->group(function () {
//     Route::get('/', function ($subdomain){
//         echo $subdomain;
//     });
// });
// Route::get('/{subdomainasd}', function ($subdomainasd){
//     echo $subdomainasd;
// });

// Route::group(['domain' => 'admins.localhost'], function () {
//     Route::get('/', function () {
//         return "asd";
//     });
// });
// Route::prefix('admin')->group(function () {
// 	Route::get('/login', 'belakang\auth\LoginController@showLoginForm')->name('b.login');
// 	Route::post('/login', 'belakang\auth\LoginController@login');
// 	Route::post('/logout', 'belakang\auth\LoginController@logout')->name('b.logout');
// 	Route::get('/register', 'belakang\auth\RegisterController@showRegistrationForm')->name('b.register');
// 	Route::post('/register', 'belakang\auth\RegisterController@register');
// 	// Route::get('/password/reset', 'belakang\auth\ForgotPasswordController@showLinkRequestForm')->name('b.password.request');
// 	// Route::post('/password/email', 'belakang\auth\ForgotPasswordController@sendResetLinkEmail')->name('b.password.email');
// 	// Route::get('/password/reset/{token}', 'belakang\auth\ResetPasswordController@showResetForm')->name('b.password.reset');
// 	// Route::post('/password/reset', 'belakang\auth\ResetPasswordController@reset');
		
// 	//index dan locale
//     Route::get('/', 'belakang\DashboardController@index')->name("b.dashboard");
//     Route::get('/locale', 'belakang\DashboardController@locale')->name("b.locale");

//     //produk
//     Route::get('/produk', 'belakang\ProdukController@produkIndex');
//     Route::get('/produk/edit/{id_produk?}', 'belakang\ProdukController@editProduk');
//     Route::post('/produk/proses', 'belakang\ProdukController@prosesProduk');
//     Route::get('/produk/tambah', 'belakang\ProdukController@tambahProduk');
//     Route::get('/produk/tambahForm', 'belakang\ProdukController@tambahFormProduk');
//     Route::get('/produk-getData', 'belakang\ProdukController@getProduk');

//     //produk kategori
//     Route::get('/produk-kategori', 'belakang\ProdukController@produkKategoriIndex');
//     Route::post('/produk-kategori/proses', 'belakang\ProdukController@prosesProdukKategori');
//     Route::get('/produk-kategori-getData', 'belakang\ProdukController@getProdukKategori');

//     //expense
//     Route::get('/expense', 'belakang\ExpenseController@index');
//     Route::post('/expense/proses', 'belakang\ExpenseController@prosesExpense');
//     Route::get('/expense-getData', 'belakang\ExpenseController@getExpense');

//     //Customer
//     Route::prefix('customer')->group(function(){    
//         Route::get('/all', 'belakang\CustomerController@index');
//         Route::get('/edit', 'belakang\CustomerController@edit');
//         Route::get('/getData', 'belakang\CustomerController@getCustomer');
//         Route::get('/store', 'belakang\CustomerController@store');    
//         Route::get('/update', 'belakang\CustomerController@update');
//         Route::post('/destroy', 'belakang\CustomerController@destroy');
//         Route::post('/getWilayah', 'belakang\CustomerController@getWilayah');
//         Route::post('/cariKecamatan', 'belakang\CustomerController@cariKecamatan');
//         Route::post('/getWilayahDetail', 'belakang\CustomerController@getWilayahDetail');
//     });

//     // Route::get('/asd', function(){
//         //     return Hash::make("asdad");
//         // });
//     // Route::get('/asd', 'belakang\OrderController@testing');

//     //order
//     Route::prefix('order')->group(function(){
//         Route::get('/semua', 'belakang\OrderController@semuaIndex');
//         Route::get('/', function(){
//             return redirect("admin/order/semua");
//         });
//         Route::post('/get-Produk', 'belakang\OrderController@getProduk');
//         Route::post('/get-ProdukDetail', 'belakang\OrderController@getProdukDetail');
//         Route::post('/get-Wilayah', 'belakang\OrderController@getWilayah');
//         Route::post('/cariKecamatan', 'belakang\OrderController@cariKecamatan');
//         Route::post('/cekOngkir', 'belakang\OrderController@cekOngkir');
//         Route::post('/get-WilayahDetail', 'belakang\OrderController@getWilayahDetail');
//         Route::post('/get-Customer', 'belakang\OrderController@getCustomer');
//         Route::post('/simpan', 'belakang\OrderController@saveOrder');
//         Route::get('/tambah', 'belakang\OrderController@orderTambah');
//         Route::get('/canceled', 'belakang\OrderController@cancelIndex');
//         Route::post('/proses', 'belakang\OrderController@proses');
//         Route::get('/detail/{id_order?}', 'belakang\OrderController@detailIndex');
//         Route::get('/search', 'belakang\OrderController@cariIndex');
//         Route::get('/track-resi', 'belakang\OrderController@trackResiIndex');
//     });
// });
