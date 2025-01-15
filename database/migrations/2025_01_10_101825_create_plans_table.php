<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bip_id')->constrained('bips');
            $table->string('name');
            $table->text('description');
            $table->integer('baseline_level')->nullable();
            $table->date('baseline_date')->nullable();
            $table->integer('initial_intensity')->nullable();
            $table->integer('current_intensity')->nullable();
            $table->enum('category', ['maladaptive', 'replacement', 'caregiver_training', 'rbt_training']);
            $table->enum('status', ['active', 'completed', 'hold', 'discontinued', 'maintenance', 'met', 'monitoring']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
