<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSupplyAndDemand extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supply_and_demands', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->tinyInteger('is_top')->default(0)->comment('是否置顶');
            $table->enum('type', ['SUPPLY', 'DEMAND'])->nullable()->comment('类型 SUPPLY供应，DEMAND需求');
            $table->text('pics')->nullable()->comment('图片');
            $table->string('title')->nullable()->comment('标题');
            $table->integer('industry_id')->nullable()->comment('所属行业id');
            $table->string('province')->nullable()->comment('省');
            $table->string('city')->nullable()->comment('市');
            $table->string('start_time')->nullable()->comment('开始时间');
            $table->string('end_time')->nullable()->comment('结束时间');
            $table->text('content')->nullable()->comment('内容');
            $table->string('linkman')->nullable()->comment('联系人');
            $table->string('link_wechat')->nullable()->comment('联系微信');
            $table->string('link_email')->nullable()->comment('联系邮箱');
            $table->string('link_mobile')->nullable()->comment('联系电话');
            $table->enum('status', ['UNPLAY', 'UNDERWAY', 'FINISHED', 'CANCELED'])->nullable()->comment('状态');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supply_and_demands');
    }
}
