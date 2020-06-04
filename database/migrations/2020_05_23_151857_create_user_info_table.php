<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUserInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_info', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->comment('自增ID');
            $table->char('code',32)->unique('uniq_code')->comment('sso唯一标识');
            $table->string('openid',32)->unique('uniq_openid')->comment('用户的标识');
            $table->string('nickname',64)->default('')->comment('用户的昵称');
            $table->tinyInteger('sex')->default(0)->comment('性别|1男性，2女性，0未知');
            $table->string('country')->default('')->comment('国家');
            $table->string('province')->default('')->comment('省份');
            $table->string('city')->default('')->comment('city');
            $table->string('headimgurl')->default('')->comment('用户头像');
            $table->integer('subscribe_time')->unsigned()->comment('用户关注时间');
            $table->string('unionid',32)->default('')->comment('只有在用户将公众号绑定到微信开放平台帐号后，才会出现该字段');
            $table->string('subscribe_scene',32)->default('')->comment('用户关注的渠道来源');
            $table->timestamp('createAt')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('创建时间');
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
        Schema::dropIfExists('user_info');
    }
}
