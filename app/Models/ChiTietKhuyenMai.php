<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietKhuyenMai extends Model
{
    protected $table = 'chitietkhuyenmai';
    public $timestamps = false;
    protected $primaryKey = 'idctkm';
    protected $fillable = ['idkm', 'idsp'];

}
