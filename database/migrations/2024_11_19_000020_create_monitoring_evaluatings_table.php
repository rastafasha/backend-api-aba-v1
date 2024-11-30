<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonitoringEvaluatingsTable extends Migration
{
    public function up()
    {
        Schema::create('monitoring_evaluatings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('bip_id')->nullable()->constrained('bips')->nullOnDelete();
            $table->string('patient_identifier')->nullable();
            $table->foreignId('client_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('treatment_fidelity')->nullable();
            $table->json('rbt_training_goals')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('monitoring_evaluatings');
    }
}
