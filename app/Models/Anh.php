<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anh extends Model
{
    protected $table = 'anh'; // Khai báo tên bảng (nếu không phải là 'anhs')
    protected $primaryKey = 'idanh';
    protected $fillable  = [ 
        'idanh', 
        'idsp',
        'tenanh',
    ];
    public $timestamps = false;
    // Thiết lập quan hệ ngược với model SanPham (nếu cần)
    public function sanPham() {
        return $this->belongsTo(SanPham::class, 'idsp', 'idsp');
    }
}
