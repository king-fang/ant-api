<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermsTable extends Migration
{
    public function up()
    {
        Schema::create('perms', function(Blueprint $table) {
            $table->mediumIncrements('id');

            $table->string('name', 30)->unique()->comment('路由名称');

            $table->string('path', 100)->comment('实际跳转跳转路径');

            $table->string('redirect', 100)->comment('默认跳转路径(针对父组件默认跳转页面)')->nullable();

            $table->string('component', 50)->comment('组件别名')->default('RouteView');

            $table->tinyInteger('hidden')->comment('1 开启 2隐藏');

            $table->string('title',100)->comment('菜单中文标题');

            $table->string('icon',30)->comment('图标')->nullable();

            $table->tinyInteger('hidden_header_content')->default(1)->comment('1 false 2 true 针对父级选择Pageview组件');

            $table->mediumInteger('pid')->comment('父级id')->default(0);

            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `hu_perms` comment '权限表'");
    }

    public function down()
    {
        Schema::drop('perms');
    }
}
