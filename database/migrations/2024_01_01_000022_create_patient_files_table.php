<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientFilesTable extends Migration
{
    public function up()
    {
        Schema::create('patient_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('patient_identifier')->nullable();
            $table->string('name_file', 250)->nullable();
            $table->string('size', 50)->nullable();
            $table->string('resolution', 20)->nullable();
            $table->string('file', 250)->nullable();
            $table->string('type', 20)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('patient_files');
    }
}
