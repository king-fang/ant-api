<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermsRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perms_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedMediumInteger('perms_id');
            $table->unsignedSmallInteger('roles_id');
            $table->foreign('roles_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');
            $table->foreign('perms_id')
                ->references('id')
                ->on('perms')
                ->onDelete('cascade');
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
        Schema::dropIfExists('perms_roles');
    }
}
