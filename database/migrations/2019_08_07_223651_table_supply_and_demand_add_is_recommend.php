<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableSupplyAndDemandAddIsRecommend extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supply_and_demands', function (Blueprint $table) {
            $table->tinyInteger('is_recommend')->default(0)->comment('是否推荐')->after('is_top');
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
            //
        });
    }
}
