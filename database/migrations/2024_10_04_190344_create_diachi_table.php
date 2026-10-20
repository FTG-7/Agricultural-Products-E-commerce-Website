<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiachiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diachi', function (Blueprint $table) {
            $table->id('iddc'); // Khóa chính, tự động tăng
            $table->integer('idtk');
            $table->string('diachi'); // Địa chỉ
            $table->integer('loai')->default(0); // Loại địa chỉ

            // Khóa ngoại
            $table->foreign('idtk')->references('idtk')->on('taikhoan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diachi');
    }
}
