<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class ExpenseExport implements FromView
{
    public function __construct(string $data_of)
    {
        $this->data_of = $data_of;
    }

    public function view(): View
    {
        $expense = DB::table("t_expense")
            ->select("tanggal", "nama_expense", "harga", "jumlah", "note")
            ->where("data_of", $this->data_of)
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('belakang.exports.Expense', compact('expense'));
    }
}
