<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietPhieuNhap extends Model
{
    protected $table = 'chitietphieunhap';
    protected $primaryKey = 'idctpn';
    public $timestamps = false;

    protected $fillable = [
        'idpn', 'idsp', 'tensp', 'soluong', 'dongia',
    ];

    // Mối quan hệ với bảng phiếu nhập
    public function phieuNhap()
    {
        return $this->belongsTo(PhieuNhap::class, 'idpn', 'idpn');
    }

    // Mối quan hệ với bảng sản phẩm
    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'idsp', 'idsp');
    }
    // Mối quan hệ với bảng ảnh (bảng Anh)
    public function anhSanPham()
    {
        return $this->belongsTo(SanPham::class, 'idsp', 'idsp')->with('Anh');
    }
}