<?php

namespace App\Providers;

use App\Models\GioHang;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\LoaiSP;
use App\Models\SanPham;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $LoaiSP = LoaiSP::withCount('sanpham')->get();

        $maxPrice = SanPham::max('gia');

        // Chia sẻ biến cho tất cả các view
        View::share('LoaiSP', $LoaiSP);
        View::share('maxPrice', $maxPrice);
    }

    

}
