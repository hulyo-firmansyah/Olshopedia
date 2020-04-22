<?php

namespace App\Listeners\ProdukDataBerubah;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\ProdukDataBerubah;
use Illuminate\Support\Facades\Cache;

class HapusCacheProduk
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ProdukDataBerubah $event)
    {
        Cache::forget('data_beli_produk_setiap_'.$event->dataof);
        Cache::forget('data_produk_ajax_'.$event->dataof);
        Cache::forget('data_produk_lengkap_0_'.$event->dataof);
        Cache::forget('data_produk_lengkap_1_'.$event->dataof);
    }
}
