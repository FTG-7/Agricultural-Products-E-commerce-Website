<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tokens', function (Blueprint $table) {
            $table->id();
            $table->integer('idtk');
            $table->string('token'); // Token
            $table->enum('loai', ['kichhoat', 'quenmk','doimail']); // Loại token: activation, password_reset
            $table->timestamp('hethan')->nullable(); // Thời gian hết hạn của token
            $table->timestamps();

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
        Schema::dropIfExists('tokens');
    }
}
