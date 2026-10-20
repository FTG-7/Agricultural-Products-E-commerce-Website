<?php

namespace App\Models;

use App\Models\Admin\KhuyenMai;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    protected $table = 'sanpham';
    protected $primaryKey = 'idsp';
    protected $fillable  = [
        'idsp', 
        'tensp', 
        'mota',
        'gia', 
        'donvitinh', 
        'xuatxu',
        'soluong', 
        'trangthai',
        'handoitra',
    ];
    public $timestamps = false;
    public function loaisp()
    {
        return $this->belongsToMany(loaisp::class, 'sanpham_loaisp', 'idsp', 'idloai');
    }
    public function Anh(){
        return $this->hasMany(Anh::class,'idsp', 'idsp');
    }

    public function khuyenmai()
    {
        return $this->belongsToMany(KhuyenMai::class, 'chitietkhuyenmai', 'idsp', 'idkm');
    }

    public function binhluan()
    {
        return $this->hasMany(BinhLuan::class, 'idsp', 'idsp');
    }

    public function chitietPhieuNhap()
    {
        return $this->hasMany(ChiTietPhieuNhap::class, 'idsp', 'idsp');
    }

    public function spHetHan()
    {
        return $this->hasMany(SpHetHan::class, 'idsp', 'id');
    }
}
