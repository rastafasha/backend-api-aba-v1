<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoteRbtsTable extends Migration
{
    public function up()
    {
        Schema::create('note_rbts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->string('patient_id')->nullable();
            $table->unsignedBigInteger('bip_id')->nullable();
            $table->unsignedBigInteger('provider_name_g')->nullable();
            $table->string('provider_credential')->nullable();
            $table->string('pos')->nullable();
            $table->timestamp('session_date')->nullable();
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
            $table->time('time_in2')->nullable();
            $table->time('time_out2')->nullable();
            $table->string('environmental_changes')->nullable();
            $table->json('maladaptives')->nullable();
            $table->json('replacements')->nullable();
            $table->json('interventions')->nullable();
            $table->string('meet_with_client_at')->nullable();
            $table->string('client_appeared')->nullable();
            $table->string('as_evidenced_by')->nullable();
            $table->string('rbt_modeled_and_demonstrated_to_caregiver')->nullable();
            $table->text('client_response_to_treatment_this_session')->nullable();
            $table->string('progress_noted_this_session_compared_to_previous_session')->nullable();
            $table->timestamp('next_session_is_scheduled_for')->nullable();
            $table->string('provider_signature')->nullable();
            $table->unsignedBigInteger('provider_name')->nullable();
            $table->string('supervisor_signature')->nullable();
            $table->unsignedBigInteger('supervisor_name')->nullable();
            $table->boolean('billed')->default(false);
            $table->boolean('pay')->default(false);
            $table->enum('status', ['pending', 'ok', 'no', 'review'])->default('pending');
            $table->text('cpt_code')->nullable();

            $table->unsignedInteger('location_id')->nullable();
            $table->string('md', 20)->nullable();
            $table->string('md2', 20)->nullable();
            $table->unsignedBigInteger('provider')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign key for provider
            $table->foreign('provider')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('note_rbts');
    }
}
