<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSphethanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sphethan', function (Blueprint $table) {
            $table->id('idhh'); // Tạo cột idhh kiểu BIGINT tự tăng
            $table->integer('idsp'); // Cột idsp, là khóa ngoại đến bảng sanpham
            $table->integer('soluong')->default(0); // Cột soluong, mặc định là 0
            $table->date('ngayhh'); // Cột ngayhh, lưu ngày hết hạn
            $table->timestamps();

            // Định nghĩa khóa ngoại
            $table->foreign('idsp')->references('idsp')->on('sanpham')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sphethan');
    }
}
