<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('lastname')->nullable($value = true);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('username')->unique()->nullable($value = true);
            $table->boolean('es_lider')->default(0);
            $table->integer('equipments_id')->unsigned()->nullable($value = true);
            $table->foreign('equipments_id')->references('id')->on('equipments')->onDelete('cascade');
            $table->integer('departaments_id')->unsigned()->nullable($value = true);
            $table->foreign('departaments_id')->references('id')->on('departaments')->onDelete('cascade');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
