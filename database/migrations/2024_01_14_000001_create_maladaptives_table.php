<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaladaptivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maladaptives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bip_id')->constrained('bips');
            $table->string('name');
            $table->string('description');
            $table->integer('baseline_level');
            $table->dateTime('baseline_date');
            $table->integer('initial_intensity');
            $table->integer('current_intensity');
            $table->enum('status', ['active', 'completed', 'hold', 'discontinued', 'maintenance', 'met', 'monitoring']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maladaptives');
    }
}
