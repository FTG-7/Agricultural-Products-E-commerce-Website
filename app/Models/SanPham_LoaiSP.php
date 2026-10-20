<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPham_LoaiSP extends Model
{
    protected $table = 'sanpham_loaisp';
    protected $primaryKey = 'id'; // Thay đổi 'your_primary_key' thành tên cột khóa chính thực tế

    protected $fillable  = [
        'id', 
        'idloai', 
        'idsp',
  
    ];
    public $timestamps = false;
    public function SanPham() {
        return $this->hasMany(SanPham::class);
    }

    public function loaisp() {
        return $this->hasMany(loaisp::class);
    }
}
