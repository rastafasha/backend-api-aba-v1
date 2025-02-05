<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBipsTable extends Migration
{
    public function up()
    {
        Schema::create('bips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('client_id')->constrained('users');
            $table->string('patient_identifier', 50)->nullable();
            $table->foreignId('doctor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->tinyInteger('type_of_assessment')->default(1);
            $table->text('background_information')->nullable();
            $table->text('previous_treatment_and_result')->nullable();
            $table->text('current_treatment_and_progress')->nullable();
            $table->text('education_status')->nullable();
            $table->text('physical_and_medical_status')->nullable();
            $table->text('strengths')->nullable();
            $table->text('weaknesses')->nullable();
            $table->json('physical_and_medical')->nullable();
            $table->json('maladaptives')->nullable();
            $table->text('assestment_conducted')->nullable();
            $table->json('assestment_conducted_options')->nullable();
            $table->json('assestment_evaluation_settings')->nullable();
            $table->json('prevalent_setting_event_and_antecedents')->nullable();
            $table->text('hypothesis_based_intervention')->nullable();
            $table->json('interventions')->nullable();
            $table->json('tangibles')->nullable();
            $table->json('attention')->nullable();
            $table->json('escape')->nullable();
            $table->json('sensory')->nullable();

            // new fields
            $table->text('discharge_plan')->nullable();
            $table->text('fading_plan')->nullable();
            $table->text('risk_assessment')->nullable();
            $table->text('generalization_training')->nullable();

            $table->json('recommendations')->nullable();
            $table->json('crisis_plan')->nullable();
            $table->json('de_escalation_techniques')->nullable();
            $table->json('documents_reviewed')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bips');
    }
}
