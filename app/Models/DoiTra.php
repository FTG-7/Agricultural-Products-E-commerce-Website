<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoiTra extends Model
{
    use HasFactory;
    protected $table = 'doitra';
    protected $primaryKey = 'iddt';
    public $timestamps = false;

    protected $fillable = [
        'idtk', 'iddh', 'ngaytao', 'lydo', 'video', 'ghichu', 'hoantien', 'idnvgh', 'hinh', 'trangthai',
    ];

    // Mối quan hệ với bảng ChiTietDoiTra
    public function chiTietDoiTra()
    {
        return $this->hasMany(ChiTietDoiTra::class, 'iddt', 'iddt');
    }

    // Mối quan hệ với bảng DonHang
    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'iddh', 'iddh');
    }

    // Mối quan hệ với bảng TaiKhoan
    public function taiKhoan()
    {
        return $this->belongsTo(User::class, 'idtk', 'idtk');
    }

    public function nhanvien()
    {
        return $this->belongsTo(User::class, 'idnvgh', 'idtk');
    }
}
