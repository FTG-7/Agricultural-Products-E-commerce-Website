<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTongToChitietdonhangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chitietdonhang', function (Blueprint $table) {
            //
            $table->integer('tong')->nullable()->after('gia'); // Thêm cột 'tong' kiểu int, cho phép NULL
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chitietdonhang', function (Blueprint $table) {
            //
            $table->dropColumn('tong'); // Xóa cột 'tong' khi rollback migration
        });
    }
}
