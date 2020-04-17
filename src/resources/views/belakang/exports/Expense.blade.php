    <h3>Daftar Expense</h3>
    <p>Date : @php
        echo date("l, d-m-Y");
    @endphp</p>

    <br>

    <table class="table">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Catatan</th>
        </tr>
        @foreach ($expense as $row)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$row->tanggal}}</td>
                <td>{{$row->nama_expense}}</td>
                <td>{{$row->harga}}</td>
                <td>{{$row->jumlah}}</td>
                <td>{{$row->note}}</td>
            </tr>
        @endforeach
    </table>
