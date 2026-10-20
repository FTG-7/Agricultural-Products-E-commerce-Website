<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRatingToBinhluanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('binhluan', function (Blueprint $table) {
            //
            $table->unsignedTinyInteger('rating')->after('noidung')->default(0)->comment('Đánh giá của bình luận từ 1-5');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('binhluan', function (Blueprint $table) {
            //
            $table->dropColumn('rating');
        });
    }
}
