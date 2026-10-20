<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BinhLuan extends Model
{
    protected $table = 'binhluan';
    protected $primaryKey = 'idbl';
    protected $fillable  = [ 
        'idbl', 
        'idtk',
        'idsp',
        'noidung',
        'rating',         // Nếu bạn đã thêm cột rating vào bảng
        'ngay_binhluan',  // Thêm cột ngày bình luận vào đây
    ];
    public $timestamps = false;
    
    protected $casts = [
        'ngay_binhluan' => 'datetime', // Chuyển đổi sang kiểu Carbon
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'idtk', 'idtk');
    }

    // Each comment belongs to one product
    public function sanpham()
    {
        return $this->belongsTo(SanPham::class, 'idsp', 'idsp');
    }
}
