<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    use HasFactory;

    protected $table = 'donhang'; // Tên bảng
    protected $primaryKey = 'iddh'; // Khóa chính
    public $timestamps = false; // Sử dụng timestamps

    protected $fillable = [
        'idtk', 
        'tennhan', 
        'ngaydat', 
        'ngaygiao', 
        'diachigiao',
        'sdt', 
        'ghichu', 
        'tongtien', 
        'pttt',
        "ttthanhtoan",
        'trangthai',
        'idnvgh'
    ];
    

    public function chiTietDonHang()
    {
        return $this->hasMany(ChiTietDonHang::class, 'iddh', 'iddh');
    }

    public function taiKhoan()
    {
        return $this->belongsTo(User::class, 'idtk', 'idtk');
    }

    public function diaChi()
    {
        return $this->belongsTo(DiaChi::class, 'idtk', 'idtk');
    }

    public function nhanvien()
    {
        return $this->belongsTo(User::class, 'idnvgh', 'idtk');
    }

    
}
