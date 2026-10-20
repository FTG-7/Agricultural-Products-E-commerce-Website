<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BinhLuan;
use App\Models\SanPham;

class BinhLuanController extends Controller
{
    public function store(Request $request, $idsp)
{
    // Validate dữ liệu
    $request->validate([
        'noidung' => 'required|max:500',
        'rating' => 'required|integer|between:1,5',
    ], [
        'noidung.required' => 'Bạn phải nhập nội dung bình luận.',
        'noidung.max' => 'Nội dung bình luận không được vượt quá 500 ký tự.',
        'rating.required' => 'Bạn phải chọn đánh giá sao.',
        'rating.integer' => 'Đánh giá phải là một số nguyên.',
        'rating.between' => 'Đánh giá phải nằm trong khoảng từ 1 đến 5 sao.',
    ]);

    // Lưu bình luận vào database
    BinhLuan::create([
        'idtk' => auth()->id(),
        'idsp' => $idsp,
        'noidung' => $request->noidung,
        'rating' => $request->rating,
        'ngay_binhluan' => now(),
    ]);

    // Lưu sản phẩm liên quan vào session
    $relatedProducts = SanPham::whereHas('loaisp', function($query) use ($idsp) {
        $query->whereIn('loaisp.idloai', SanPham::find($idsp)->loaisp->pluck('idloai')->toArray());
    })
    ->where('idsp', '!=', $idsp)  // Loại trừ sản phẩm hiện tại
    ->limit(5)  // Giới hạn số lượng sản phẩm liên quan
    ->get();

    session(['relatedProducts' => $relatedProducts]);


    // Chuyển hướng về trang sản phẩm
    return redirect()->route('user.ds_SanPham.detail_product', $idsp)->with('success', 'Bình luận của bạn đã được đăng.');
}

    
}
