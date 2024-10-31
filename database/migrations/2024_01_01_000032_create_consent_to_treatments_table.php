<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsentToTreatmentsTable extends Migration
{
    public function up()
    {
        Schema::create('consent_to_treatments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('bip_id')->nullable()->constrained('bips')->nullOnDelete();
            $table->string('patient_id')->nullable();
            $table->foreignId('client_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('analyst_signature')->nullable();
            $table->timestamp('analyst_signature_date')->nullable();
            $table->string('parent_guardian_signature')->nullable();
            $table->timestamp('parent_guardian_signature_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consent_to_treatments');
    }
}
