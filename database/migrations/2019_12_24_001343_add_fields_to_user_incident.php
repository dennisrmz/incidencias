<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUserIncident extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_incident', function ($table) {
            $table->date('fecha_aceptacion')->nullable($value = true);
            $table->date('fecha_rechazo')->nullable($value = true);
            $table->date('fecha_finalizacion')->nullable($value = true);
            $table->string('descripcion_rechazo')->nullable(True);
            $table->string('observaciones')->nullable(True);
            $table->date('fecha_finalizacion_user')->nullable($value = true);
          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_incident');
    }
}
