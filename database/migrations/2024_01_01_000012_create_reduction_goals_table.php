<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReductionGoalsTable extends Migration
{
    public function up()
    {
        Schema::create('reduction_goals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('bip_id')->constrained('bips')->onDelete('cascade');
            $table->string('maladaptive')->nullable();
            $table->integer('baseline')->nullable();
            $table->string('current_status', 155)->nullable();
            $table->string('patient_identifier', 150)->nullable();
            $table->foreignId('client_id')->nullable()->constrained('users')->nullOnDelete();
            $table->json('goalstos')->nullable();
            $table->json('goalltos')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reduction_goals');
    }
}
