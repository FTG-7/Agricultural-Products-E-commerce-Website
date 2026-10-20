<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GioHang extends Model
{
    use HasFactory;
    protected $table = 'giohang';
    protected $primaryKey = 'idgh';
    public $timestamps = false;

    protected $fillable = [
        'idgh', 
        'idtk', 
        'idsp', 
        'soluong', 
        'dongia',
    ];

    public function sanpham()
    {
        return $this->belongsTo(SanPham::class, 'idsp', 'idsp')->with('Anh');
    }

    // Thêm các thuộc tính tùy chỉnh
    protected $appends = [
        'discountAmount', 
        'increasedProductName', 
        'promoName', 
        'promoContent', 
        'promoCondition'
    ];

    // Getters
    public function getDiscountAmountAttribute()
    {
        return $this->attributes['discountAmount'] ?? 0;
    }

    public function getIncreasedProductNameAttribute()
    {
        return $this->attributes['increasedProductName'] ?? null;
    }

    public function getPromoNameAttribute()
    {
        return $this->attributes['promoName'] ?? null;
    }

    public function getPromoContentAttribute()
    {
        return $this->attributes['promoContent'] ?? null;
    }

    public function getPromoConditionAttribute()
    {
        return $this->attributes['promoCondition'] ?? null;
    }

    // Setters
    public function setDiscountAmountAttribute($value)
    {
        $this->attributes['discountAmount'] = $value;
    }

    public function setIncreasedProductNameAttribute($value)
    {
        $this->attributes['increasedProductName'] = $value;
    }

    public function setPromoNameAttribute($value)
    {
        $this->attributes['promoName'] = $value;
    }

    public function setPromoContentAttribute($value)
    {
        $this->attributes['promoContent'] = $value;
    }

    public function setPromoConditionAttribute($value)
    {
        $this->attributes['promoCondition'] = $value;
    }
}
