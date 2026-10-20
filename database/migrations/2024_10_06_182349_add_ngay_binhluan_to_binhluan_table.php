<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNgayBinhluanToBinhluanTable extends Migration
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
            $table->timestamp('ngay_binhluan')->nullable()->after('rating')->comment('Ngày bình luận');

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
            $table->dropColumn('ngay_binhluan');
        });
    }
}
