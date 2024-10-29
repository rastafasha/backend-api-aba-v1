<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaServiceIdToNotesTables extends Migration
{
    public function up()
    {
        Schema::table('note_rbts', function (Blueprint $table) {
            $table->unsignedBigInteger('pa_service_id')->nullable();
            $table->foreign('pa_service_id')->references('id')->on('pa_services')->onDelete('set null');
        });

        Schema::table('note_bcbas', function (Blueprint $table) {
            $table->unsignedBigInteger('pa_service_id')->nullable();
            $table->foreign('pa_service_id')->references('id')->on('pa_services')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('note_rbts', function (Blueprint $table) {
            $table->dropForeign(['pa_service_id']);
            $table->dropColumn('pa_service_id');
        });

        Schema::table('note_bcbas', function (Blueprint $table) {
            $table->dropForeign(['pa_service_id']);
            $table->dropColumn('pa_service_id');
        });
    }
}
