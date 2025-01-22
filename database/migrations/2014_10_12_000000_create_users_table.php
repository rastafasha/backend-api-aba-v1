<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('surname', 150)->nullable();
            $table->string('phone', 150)->nullable();
            $table->timestamp('birth_date')->nullable()->useCurrent();
            $table->tinyInteger('gender')->unsigned()->default(1);
            $table->text('address')->nullable();
            $table->string('avatar')->nullable();
            $table->enum('status', ['inactive', 'active', 'black list', 'incoming'])->default('inactive');
            $table->string('currently_pay_through_company', 150)->nullable();
            $table->string('llc', 150)->nullable();
            $table->string('ien', 150)->nullable();
            $table->string('wc', 150)->nullable();
            $table->string('electronic_signature', 150)->nullable();
            $table->string('agency_location')->nullable();
            $table->string('city')->nullable();
            $table->string('languages', 50)->nullable();
            $table->string('ss_number', 150)->nullable();
            $table->timestamp('date_of_hire')->nullable()->useCurrent();
            $table->string('start_pay')->nullable()->nullable();
            $table->timestamp('driver_license_expiration')->nullable()->useCurrent();
            $table->string('cpr_every_2_years')->nullable();
            $table->string('background_every_5_years')->nullable();
            $table->string('e_verify')->nullable();
            $table->string('national_sex_offender_registry')->nullable();
            $table->string('certificate_number')->nullable();
            $table->string('bacb_license_expiration')->nullable();
            $table->string('liability_insurance_annually')->nullable();
            $table->string('local_police_rec_every_5_years')->nullable();
            $table->string('npi')->nullable();
            $table->string('medicaid_provider')->nullable();
            $table->string('ceu_hippa_annually')->nullable();
            $table->string('ceu_domestic_violence_no_expiration')->nullable();
            $table->string('ceu_security_awareness_annually')->nullable();
            $table->string('ceu_zero_tolerance_every_3_years')->nullable();
            $table->string('ceu_hiv_bloodborne_pathogens_infection_control_no_expiration')->nullable();
            $table->string('ceu_civil_rights_no_expiration')->nullable();
            $table->string('school_badge')->nullable();
            $table->string('w_9_w_4_form')->nullable();
            $table->string('contract')->nullable();
            $table->string('two_four_week_notice_agreement')->nullable();
            $table->string('credentialing_package_bcbas_only')->nullable();
            $table->string('caqh_bcbas_only')->nullable();
            $table->string('contract_type', 155)->nullable();
            $table->double('salary')->nullable();
            $table->string('location_id', 50)->nullable();
            $table->string('note', 50)->nullable();
            $table->string('schedule', 50)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
