<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSustitutionGoalsTable extends Migration
{
    public function up()
    {
        Schema::create('sustitution_goals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('goal')->nullable();
            $table->string('current_status', 155)->nullable();
            $table->text('description')->nullable();
            $table->string('patient_id', 150)->nullable();
            $table->foreignId('client_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('bip_id')->constrained('bips')->onDelete('cascade');
            $table->json('goalstos')->nullable()->comment('JSON array of STO goals');
            $table->json('goalltos')->nullable()->comment('JSON array of LTO goals');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sustitution_goals');
    }
}
