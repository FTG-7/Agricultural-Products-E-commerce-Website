<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diachi extends Model
{
    use HasFactory;

    protected $table = 'diachi';

    protected $primaryKey = 'iddc';

    public $timestamps = false;

    protected $fillable = ['idtk', 'diachi', 'loai'];
}
