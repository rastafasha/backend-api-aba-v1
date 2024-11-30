<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname', 150)->nullable();
            $table->string('email')->unique();
            $table->string('patient_identifier', 50)->nullable();
            $table->string('phone', 150)->nullable();
            $table->timestamp('birth_date')->nullable()->useCurrent();
            $table->tinyInteger('gender')->unsigned()->default(1);
            $table->text('address')->nullable();
            $table->string('avatar')->nullable();
            $table->enum('status', ['inactive', 'active', 'black list', 'incoming'])->default('inactive');     
            $table->json('documents_pending')->nullable();
            $table->string('location_id', 50)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('parents');
    }
}
