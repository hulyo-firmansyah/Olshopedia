<h3>Daftar Order</h3>
<p>
    @php
        echo $date;
    @endphp
</p>

@php
    function uangFormat($angka, $rupiah = null){
		return ((is_null($rupiah)) ? "" : "Rp ").number_format($angka, 0, ',', '.');
    }

    function diskon($harga, $diskon)
    {
        return ((int)$harga - (((int)$harga * (int)$diskon) / 100));
    }
@endphp

<br>

<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal Pemesanan</th>
            <th>Tanggal Bayar</th>
            <th>Pemesan</th>
            <th>Telp. Pemesan</th>
            <th>Penerima</th>
            <th>Telp. Penerima</th>
            <th>Alamat</th>
            <th>Detail Produk</th>
            <th>Total Harga Jual (Tidak Termasuk Diskon)</th>
            <th>Ongkir</th>
            <th>Total Diskon</th>
            <th>Asuransi / Biaya Lain</th>
            <th>Total Customer Bayar (Gross Sales)</th>
            <th>Omzet (Net Sales)</th>
            <th>Gross Profit</th>
            <th>Ekspedisi</th>
            <th>No Resi</th>
            <th>Posted by</th>
            <th>Note</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $row)
        @php
            $all_diskon = [];
            if ($row['status'] == 'belum'){
                $hp = 0;
                $ho = 0;
                $do = 0;
                $all_diskon = null;
            } else {
                if (isset($row['diskon_produk'])) {
                    foreach ($row['data_produk'] as $key) {
                        foreach ($row['diskon_produk'] as $item) {
                            if($key->id_varian == $item->id_varian){
                                if ($row['pemesan']->pemesan_kategori == 'Customer') {
                                    if ($item->tipe == '%') {
                                        $dp = $key->nama_produk .'|'. diskon($key->harga_jual_normal, $item->harga);
                                    }elseif ($item->tipe == '*') {
                                        $dp = $key->nama_produk .'|'. $item->harga;
                                    }
                                }elseif ($row['pemesan']->pemesan_kategori == 'Reseller'){
                                    if ($item->tipe == '%') {
                                        $dp = $key->nama_produk .'|'. diskon($key->harga_jual_reseller, $item->harga);
                                    }elseif ($item->tipe == '*') {
                                        $dp = $key->nama_produk .'|'. $item->harga;
                                    }
                                }
                            }
                        }
                        array_push($all_diskon, $dp);
                    }
                }
                if (isset($row['diskon_order'])) {
                    foreach ($row['diskon_order'] as $key) {
                        $d = $key->nama .'|'. $key->harga;
                        $do = $key->harga;
                    }
                    array_push($all_diskon, $d);
                } else {
                    $do = 0;
                }
                $hp = $row['harga_produk'];
                $ho = $row['harga_ongkir'];
            }
            // dd($do);
            $gs = ($hp + $ho) - $do;
            $ns = $hp - $do;
        @endphp
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$row['tanggal_order']}}</td>
            <td>
                @php
                    if (isset($row['idp2'])){
                        foreach ($row['idp2'] as $key){
                            if ($key->via == 'CASH') {
                                $tipe = $key->via;
                            }else{
                                $via = explode('|', $key->via);
                                $tipe = $via[1];
                            }
                            echo $key->tgl_bayar .'-'. $tipe . '<br>';
                        }
                    }
                @endphp
            </td>
            <td>{{$row['pemesan']->name}}</td>
            <td>{{$row['pemesan']->no_telp}}</td>
            <td>{{$row['penerima']->name}}</td>
            <td>{{$row['penerima']->no_telp}}</td>
            <td>{{$row['alamat_t']}}</td>
            @foreach ($row['data_produk'] as $v)
                <td>{{$v->nama_produk}} x {{$v->jumlah}}</td>
            @endforeach
            <td>{{uangFormat($hp, true)}}</td>
            <td>{{uangFormat($ho, true)}}</td>
            <td>
                @php
                    if($all_diskon != []){
                        foreach ($all_diskon as $item){
                            $diskon = explode('|', $item);
                            echo $diskon[0] .' - '. uangFormat($diskon[1], true) . '<br>';
                            $total_diskon += $diskon[1];
                        }
                    }else{
                        $diskon = 0;
                        $total_diskon = 0;
                        echo uangFormat($diskon, true);
                    }
                @endphp
            </td>
            <td>
            @php
                if (isset($row['biaya_lain'])){
                    foreach ($row['biaya_lain'] as $item){
                        echo $item->nama .' - '. uangFormat($item->harga, true);
                        $total_biayaLain +=  $item->harga;
                    };
                } else {
                    echo uangFormat(0, true);
                    $total_biayaLain =  0;
                }
                @endphp
            </td>
            <td>{{uangFormat($gs, true)}}</td>
            @php
                $net_sales = $gs - ($ho + $total_biayaLain);
            @endphp
            <td>{{uangFormat($net_sales, true)}}</td>
            <td>
                @php
                    foreach ($row['data_produk'] as $key) {
                        echo $gp = uangFormat($row['harga_produk'] - ($key->harga_beli * $key->jumlah) - $total_diskon, true)   ;
                    }
                @endphp
            </td>
            <td>{{ucfirst($row['eks'])}}</td>
            <td>{{$row['no_resi']}}</td>
            <td>{{$row['admin']}}</td>
            <td>{{$row['note']}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
