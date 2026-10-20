<?php

namespace App\Models\Admin;

use App\Models\SanPham;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhuyenMai extends Model
{
    protected $table = 'khuyenmai';
    protected $primaryKey = 'idkm';
    protected $fillable  = [
        'idkm', 
        'tenkm', 
        'loaikm',
        'dieukien', 
        'sanphamKM',
        'noidungkm', 
        'ngaybd',
        'ngaykt', 
        'trangthai',
        
    ];
    public $timestamps = false;
    public function sanpham()
    {
        return $this->belongsToMany(SanPham::class, 'chitietkhuyenmai', 'idkm', 'idsp');
    }
}
