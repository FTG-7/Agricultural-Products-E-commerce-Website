<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietDoiTra extends Model
{
    use HasFactory;

    protected $table = 'chitietdoitra'; // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'idctdt'; // Khóa chính của bảng
    public $timestamps = false; // Nếu không sử dụng timestamps

    // Các trường có thể được gán hàng loạt
    protected $fillable = [
        'iddt',  
        'idsp',  
        'tensp',     
        'soluong',       
        'dongia',  
    ];

    // Mối quan hệ với bảng sản phẩm
    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'idsp', 'idsp');
    }

    // Mối quan hệ với bảng đổi trả
    public function doiTra()
    {
        return $this->belongsTo(DoiTra::class, 'iddt', 'iddt');
    }
}
