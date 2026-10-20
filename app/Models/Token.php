<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $table = 'tokens';
    protected $primaryKey = 'id';
    protected $fillable = ['idtk', 'token', 'loai', 'hethan'];

    public function user()
    {
        return $this->belongsTo(User::class, 'idtk', 'idtk'); // Liên kết với bảng taikhoan
    }
}
