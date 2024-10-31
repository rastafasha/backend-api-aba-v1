<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsurancesTable extends Migration
{
    public function up()
    {
        Schema::create('insurances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('insurer_name')->nullable();
            $table->json('services')->nullable()->comment('Codes, provider, description, unit prize, Hourly Fee, max_allowed');
            $table->json('notes')->nullable()->comment('description');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('insurances');
    }
}
