<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrisisPlansTable extends Migration
{
    public function up()
    {
        Schema::create('crisis_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('bip_id')->nullable()->constrained('bips')->nullOnDelete();
            $table->string('patient_id')->nullable();
            $table->text('crisis_description')->nullable();
            $table->text('crisis_note')->nullable();
            $table->text('caregiver_requirements_for_prevention_of_crisis')->nullable();
            $table->json('risk_factors')->nullable();
            $table->json('suicidalities')->nullable();
            $table->json('homicidalities')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('crisis_plans');
    }
}
