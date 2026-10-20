<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SanPhamThongKeExport implements FromView
{
    protected $sanPhamThongKe;

    public function __construct($sanPhamThongKe)
    {
        $this->sanPhamThongKe = $sanPhamThongKe;
    }

    public function view(): View
    {
        return view('exports.sanphamthongke', [
            'sanPhamThongKe' => $this->sanPhamThongKe
        ]);
    }
}
