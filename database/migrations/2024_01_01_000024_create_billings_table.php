<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingsTable extends Migration
{
    public function up()
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('patient_identifier', 155)->nullable();
            $table->unsignedBigInteger('sponsor_id')->nullable();
            $table->string('cpt_code', 155)->nullable();
            $table->unsignedBigInteger('insurer_id')->nullable();
            $table->double('insurer_rate')->nullable();
            $table->timestamp('date')->nullable();
            $table->time('total_hours')->nullable();
            $table->time('total_units')->nullable();
            $table->double('billing_total')->nullable();
            $table->time('week_total_hours')->nullable();
            $table->time('week_total_units')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('sponsor_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('insurer_id')->references('id')->on('insurances')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('billings');
    }
}
