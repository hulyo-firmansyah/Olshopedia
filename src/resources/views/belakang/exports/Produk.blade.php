    <h3>Daftar Produk</h3>
    <p>Date : @php
        echo date("l, d-m-Y");
    @endphp</p>

    <br>

    <table class="table">
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Ukuran</th>
            <th>Warna</th>
            <th>Deskripsi</th>
            <th>SKU</th>
            <th>Keterangan</th>
            <th>Gambar</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th>Harga Reseller</th>
            <th>Berat (gram)</th>
            <th>Jumlah Stok</th>
            <th>Kategori</th>
        </tr>
    @foreach ($produk as $row)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$row->nama_produk}}</td>
                <td>{{$row->ukuran}}</td>
                <td>{{$row->warna}}</td>
                <td>{{$row->ket}}</td>
                <td>{{$row->sku}}</td>
                @php
                    $ketStok = explode("|", $row->stok);
                @endphp
                <td>{{$ketStok[1]}}</td>
                <td>
                @php
                if (isset($row->foto)){
                    if(count($row->foto['lain']) > 0){
                        $lain_foto = $row->foto['lain'];
                    } else {
                        $lain_foto = [];
                    }
                    $lain = implode(';', $lain_foto);
                    echo ($row->foto['utama'] != '') ? $row->foto['utama'].";".$lain : $lain;
                }else{
                    echo '';
                }
                @endphp
                </td>
                <td>{{$row->harga_beli}}</td>
                <td>{{$row->harga_jual_normal}}</td>
                <td>{{$row->harga_jual_reseller}}</td>
                <td>{{$row->berat}} gram</td>
                <td>{{$ketStok[0]}}</td>
                <td>{{$row->nama_kategori_produk}}</td>
            </tr>
        @endforeach
    </table>
