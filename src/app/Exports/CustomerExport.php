<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class CustomerExport implements FromView
{
    public function __construct(string $data_of)
    {
        $this->data_of = $data_of;
    }

    public function view(): View
    {
        $customer = DB::table("t_customer")
            ->join('users', 't_customer.user_id', '=', 'users.id')
            ->select('users.name', 't_customer.kategori', 'users.no_telp', 't_customer.alamat', 't_customer.kecamatan', 't_customer.kabupaten', 't_customer.provinsi', 't_customer.kode_pos')
            ->where('t_customer.data_of', $this->data_of)
            ->orderBy('users.name', 'asc')
            ->get();

        return view('belakang.exports.Customer', compact('customer'));
    }
}
