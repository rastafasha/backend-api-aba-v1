<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralizationTrainingsTable extends Migration
{
    public function up()
    {
        Schema::create('generalization_trainings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('bip_id')->nullable()->constrained('bips')->nullOnDelete();
            $table->string('patient_identifier')->nullable();
            $table->foreignId('client_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('discharge_plan')->nullable();
            $table->json('transition_fading_plans')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('generalization_trainings');
    }
}
