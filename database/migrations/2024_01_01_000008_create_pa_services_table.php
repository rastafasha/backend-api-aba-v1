<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pa_services', function (Blueprint $table) {
          $table->id();
          $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
          $table->string('pa_services');
          $table->string('cpt');
          $table->integer('n_units');
          $table->date('start_date');
          $table->date('end_date');
          $table->timestamps();
          $table->softDeletes();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pa_services');
    }
}
