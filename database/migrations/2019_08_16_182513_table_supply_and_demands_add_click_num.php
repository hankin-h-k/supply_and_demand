<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableSupplyAndDemandsAddClickNum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supply_and_demands', function (Blueprint $table) {
            $table->integer('click_num')->default(0)->comment('点击量')->after('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supply_and_demands', function (Blueprint $table) {
            $table->dropColumn('click_num');
        });
    }
}
