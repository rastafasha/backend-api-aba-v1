<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientReportsTable extends Migration
{
    public function up()
    {
        Schema::create('client_reports', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Patient and Provider Info
            $table->string('patient_identifier', 155)->nullable();
            $table->unsignedBigInteger('sponsor_id')->nullable();
            $table->foreignId('note_rbt_id')->nullable()->constrained('note_rbts')->nullOnDelete();
            $table->foreignId('note_bcba_id')->nullable()->constrained('note_bcbas')->nullOnDelete();
            $table->unsignedBigInteger('insurer_id')->nullable();

            // Codes and Identifiers
            $table->string('cpt_code', 155)->nullable();
            $table->string('npi', 150)->nullable();
            $table->string('pa_number', 100)->nullable();
            $table->string('xe', 100)->nullable();
            $table->string('pos', 50)->nullable();

            // Modifiers
            $table->string('md', 50)->nullable();
            $table->string('md2', 50)->nullable();
            $table->string('md3', 50)->nullable();
            $table->string('mdbcba', 50)->nullable();
            $table->string('md2bcba', 50)->nullable();

            // Timing and Units
            $table->timestamp('session_date')->nullable();
            $table->time('total_hours')->nullable();
            $table->integer('n_units')->nullable();

            // Financial Information
            $table->double('chargesrbt')->nullable();
            $table->double('chargesbcba')->nullable();

            // Status Flags
            $table->boolean('billed')->default(false);
            $table->boolean('billedbcba')->default(false);
            $table->boolean('pay')->default(false);
            $table->boolean('paybcba')->default(false);

            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('sponsor_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('insurer_id')->references('id')->on('insurances')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('client_reports');
    }
}
