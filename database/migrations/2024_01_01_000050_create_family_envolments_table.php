<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamilyEnvolmentsTable extends Migration
{
    public function up()
    {
        Schema::create('family_envolments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('bip_id')->nullable()->constrained('bips')->nullOnDelete();
            $table->string('patient_id')->nullable();
            $table->foreignId('client_id')->nullable()->constrained('users')->nullOnDelete();
            $table->json('caregivers_training_goals')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('family_envolments');
    }
}
