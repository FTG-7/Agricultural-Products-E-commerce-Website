<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class loaisp extends Model
{
    protected $table = 'loaisp';
    protected $primaryKey = 'idloai'; // Thay đổi 'your_primary_key' thành tên cột khóa chính thực tế
    public $timestamps = false; // Nếu không sử dụng timestamp
    protected $fillable  = [ 
        'idloai', // Đảm bảo cột này tồn tại
        'tenloai'
  
    ];

    public function sanpham()
    {
        return $this->belongsToMany(SanPham::class, 'sanpham_loaisp', 'idloai', 'idsp');
    }
}
