<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoteBcbasTable extends Migration
{
    public function up()
    {
        Schema::create('note_bcbas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('doctor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('patient_id')->nullable()->constrained('patients')->nullOnDelete();
            $table->string('patient_identifier')->nullable();
            $table->foreignId('insurance_id')->nullable()->constrained('insurances')->nullOnDelete();
            $table->string('insurance_identifier')->nullable();
            $table->foreignId('bip_id')->nullable()->constrained('bips')->nullOnDelete();
            $table->string('diagnosis_code', 50)->nullable();
            $table->string('cpt_code')->nullable();
            $table->string('meet_with_client_at')->nullable();
            $table->string('pos')->nullable();
            $table->string('participants')->nullable();
            $table->string('environmental_changes')->nullable();
            $table->timestamp('session_date')->nullable();
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
            $table->time('time_in2')->nullable();
            $table->time('time_out2')->nullable();
            $table->double('session_length_total')->nullable();
            $table->json('rbt_training_goals')->nullable();

            //note bcba 51
            $table->string('subtype')->nullable();
            $table->json('intake_outcome')->nullable();
            $table->json('assessment_tools')->nullable();
            $table->boolean('BCBA_conducted_client_observations')->nullable();
            $table->boolean('BCBA_conducted_assessments')->nullable();

            //note bcba 55
            $table->boolean('modifications_needed_at_this_time')->default(false);
            $table->text('additional_goals_or_interventions')->nullable();
            $table->json('intervention_protocols')->nullable();
            $table->json('replacement_protocols')->nullable();

            //note bcba 56
            // $table->json('demonstrated_intervention_protocols')->nullable();
            // $table->json('demonstrated_replacement_protocols')->nullable();
            $table->json('behavior_protocols')->nullable();
            $table->json('caregiver_goals')->nullable();

            $table->text('note_description')->nullable();
            $table->unsignedBigInteger('rendering_provider')->nullable();
            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->string('provider_signature')->nullable();
            $table->string('supervisor_signature')->nullable();
            $table->enum('status', ['pending', 'ok', 'no', 'review'])->default('pending');
            $table->text('summary_note')->nullable();
            $table->boolean('billed')->default(false);
            $table->boolean('paid')->default(false);

            $table->string('md', 20)->nullable();
            $table->string('md2', 20)->nullable();
            $table->string('md3', 20)->nullable();
            $table->unsignedInteger('location_id')->nullable();
            $table->foreignId('pa_service_id')->nullable()->constrained('pa_services')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            // Additional foreign key constraints
            $table->foreignId('provider_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreign('supervisor_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('note_bcbas');
    }
}
