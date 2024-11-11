<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeEscalationTechniquesTable extends Migration
{
    public function up()
    {
        Schema::create('de_escalation_techniques', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('bip_id')->nullable()->constrained('bips')->nullOnDelete();
            $table->string('patient_id')->nullable();
            $table->foreignId('client_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('description')->nullable();
            $table->text('service_recomendation')->nullable();
            $table->json('recomendation_lists')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('de_escalation_techniques');
    }
}
