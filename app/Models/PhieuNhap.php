<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhieuNhap extends Model
{
    protected $table = 'phieunhap';
    protected $primaryKey = 'idpn';
    public $timestamps = false;

    protected $fillable = [
        'tennhacungcap', 'ngaylap', 'tongtien', 'ghichu', 'xacnhan',
    ];

    // Mối quan hệ với bảng chi tiết phiếu nhập
    public function chiTietPhieuNhap()
    {
        return $this->hasMany(ChiTietPhieuNhap::class, 'idpn', 'idpn');
    }
}
