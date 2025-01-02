<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('long_term_objectives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reduction_goal_id')->constrained('reduction_goals')->onDelete('cascade');
            $table->enum('status', ['in progress', 'mastered', 'not started', 'discontinued', 'maintenance'])->default('not started');
            $table->date('initial_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('description');
            $table->decimal('target', 8, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('long_term_objectives');
    }
};
