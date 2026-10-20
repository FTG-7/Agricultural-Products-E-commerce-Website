<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpHetHan extends Model
{
    use HasFactory;

    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'sphethan';

    // Khóa chính của bảng
    protected $primaryKey = 'idhh';

    // Các cột có thể gán giá trị hàng loạt
    protected $fillable = [
        'idsp',
        'soluong',
        'ngayhh',
    ];

    // Tắt timestamps nếu không cần created_at và updated_at
    public $timestamps = true;

    // Liên kết với model SanPham
    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'idsp', 'idsp');
    }
}
