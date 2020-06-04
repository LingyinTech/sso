<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTokenRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('token_record', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->comment('自增ID');
            $table->string('token',32)->unique('uniq_token')->comment('扫码登录token');
            $table->string('ticket',128)->index('idx_ticket')->comment('获取的二维码ticket');
            $table->string('openid',32)->default('')->comment('openid');
            $table->string('redirect_uri',255)->default('')->comment('回调地址');
            $table->integer('expireAt')->unsigned()->default(0)->comment('token有效时间');
            $table->timestamp('updateAt')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('更新时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('token_record');
    }
}
