<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('number',50)->unique()->comment('角色唯一码');
            $table->string('name',50)->comment('角色名称');
            $table->string('desc')->comment('角色描述');
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `hu_roles` comment '管理员角色表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
