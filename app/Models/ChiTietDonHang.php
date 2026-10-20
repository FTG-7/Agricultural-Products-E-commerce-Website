<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietDonHang extends Model
{
    use HasFactory;

    protected $table = 'chitietdonhang'; // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'idcthd'; // Khóa chính của bảng
    public $timestamps = false; // Nếu bạn không sử dụng timestamps

    // Các trường có thể được gán hàng loạt
    protected $fillable = [
        'iddh',    // ID đơn hàng
        'idsp',    // ID sản phẩm
        'tensp',   // Tên sản phẩm
        'soluong', // Số lượng
        'gia'      // Giá
    ];

    // Mối quan hệ với đơn hàng
    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'iddh', 'iddh');
    }

    // Mối quan hệ với sản phẩm
    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'idsp', 'idsp');
    }
}
