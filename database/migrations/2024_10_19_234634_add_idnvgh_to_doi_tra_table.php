<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdnvghToDoiTraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doitra', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('idnvgh')->nullable()->after('hoantien');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doitra', function (Blueprint $table) {
            //
            $table->dropColumn('idnvgh');
        });
    }
}
