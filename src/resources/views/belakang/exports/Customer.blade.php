    <h3>Daftar Customer</h3>
    <p>Date : @php
        echo date("l, d-m-Y");
    @endphp</p>

    <br>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>No Telp</th>
                <th>Alamat</th>
                <th>Kecamatan</th>
                <th>Kabupaten</th>
                <th>Provinsi</th>
                <th>Kode Pos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customer as $row)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$row->name}}</td>
                <td>{{$row->kategori}}</td>
                <td>{{$row->no_telp}}</td>
                <td>{{$row->alamat}}</td>
                <td>{{$row->kecamatan}}</td>
                <td>{{$row->kabupaten}}</td>
                <td>{{$row->provinsi}}</td>
                <td>{{$row->kode_pos}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
