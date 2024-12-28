<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('short_term_objectives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reduction_goal_id')->constrained('reduction_goals')->onDelete('cascade');
            $table->enum('status', ['in progress', 'mastered', 'initiated', 'on hold', 'discontinued', 'maintenance']);
            $table->date('initial_date');
            $table->date('end_date');
            $table->text('description');
            $table->decimal('target', 8, 2);
            $table->integer('order')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('short_term_objectives');
    }
};