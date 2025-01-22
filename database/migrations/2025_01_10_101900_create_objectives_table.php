<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjectivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objectives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained('plans')->cascadeOnDelete();
            $table->enum('type', ['STO', 'LTO'])->default('STO');
            $table->enum('status', ['in progress', 'mastered', 'not started', 'discontinued', 'maintenance'])->default('not started');
            $table->date('initial_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('description');
            $table->decimal('start_point', 8, 2)->nullable();
            $table->decimal('target', 8, 2)->nullable();
            $table->integer('order')->default(1);
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
        Schema::dropIfExists('objectives');
    }
}
