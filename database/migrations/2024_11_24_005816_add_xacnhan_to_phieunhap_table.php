<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddXacnhanToPhieunhapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('phieunhap', function (Blueprint $table) {
            $table->boolean('xacnhan')->default(0)->after('ghichu'); // Thêm cột xacnhan với giá trị mặc định là 0
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('phieunhap', function (Blueprint $table) {
            $table->dropColumn('xacnhan'); // Xóa cột xacnhan nếu rollback
        });
    }
}
