<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaladaptivesAndWasTheRbtPresent extends Migration
{
    public function up()
    {
        Schema::table('note_bcbas', function (Blueprint $table) {
            $table->json('maladaptives')->nullable()->after('modifications_needed_at_this_time');
            $table->boolean('was_the_rbt_present')->nullable()->after('maladaptives');
        });
    }

    public function down()
    {
        Schema::table('note_bcbas', function (Blueprint $table) {
            $table->dropColumn(['maladaptives', 'was_the_rbt_present']);
        });
    }
}
