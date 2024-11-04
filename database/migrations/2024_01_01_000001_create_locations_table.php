<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 150)->nullable();
            $table->string('avatar')->nullable();
            $table->string('city', 150)->nullable();
            $table->string('state', 150)->nullable();
            $table->string('zip', 150)->nullable();
            $table->text('address')->nullable();
            $table->string('email', 150)->nullable();
            $table->string('phone1', 50)->nullable();
            $table->string('phone2', 50)->nullable();
            $table->string('telfax')->nullable(); // From fillable array
            $table->timestamps();
            $table->softDeletes();
        });

        // Create the pivot table for users and locations
        Schema::create('user_locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['user_id', 'location_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_locations');
        Schema::dropIfExists('locations');
    }
}
