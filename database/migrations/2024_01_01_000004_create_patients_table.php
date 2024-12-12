<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('location_id')->nullable();
            $table->string('patient_identifier')->nullable();
            $table->string('first_name', 250);
            $table->string('last_name', 250);
            $table->string('email', 250)->nullable();
            $table->string('phone', 25)->nullable();
            $table->string('language', 150)->nullable();
            $table->string('parent_guardian_name', 150)->nullable();

            $table->string('relationship', 150)->nullable();
            $table->string('home_phone', 150)->nullable();
            $table->string('work_phone', 150)->nullable();
            $table->string('school_name', 150)->nullable();
            $table->string('school_number', 150)->nullable();
            $table->string('zip', 150)->nullable();
            $table->string('state', 150)->nullable();
            $table->text('address')->nullable();
            $table->tinyInteger('gender')->default(1);
            $table->tinyInteger('parent_gender')->default(1);
            $table->timestamp('birth_date')->nullable();
            $table->timestamp('parent_birth_date')->nullable();
            // $table->string('age', 50)->nullable();
            $table->string('avatar')->nullable();
            $table->string('city')->nullable();
            $table->string('education', 150)->nullable();
            $table->string('profession', 150)->nullable();
            $table->string('schedule')->nullable();
            $table->string('summer_schedule')->nullable();
            $table->text('special_note')->nullable();
            $table->foreignId('insurer_id')->nullable()->constrained('insurances')->nullOnDelete();
            $table->foreignId('insurer_secondary_id')->nullable()->constrained('insurances')->nullOnDelete();
            // $table->string('insuranceId', 50)->nullable();
            $table->string('insurance_identifier')->nullable();
            $table->string('insurance_secondary_identifier')->nullable();
            $table->string('eqhlid')->nullable();
            $table->timestamp('elegibility_date')->nullable();
            $table->json('pos_covered')->nullable();
            $table->string('deductible_individual_I_F', 150)->nullable();
            $table->string('balance', 150)->nullable();
            $table->string('coinsurance', 150)->nullable();
            $table->string('copayments', 150)->nullable();
            $table->string('oop', 150)->nullable();
            $table->string('diagnosis_code')->nullable();
            $table->enum('status', [
                'incoming', 'active', 'inactive', 'onHold', 'onDischarge',
                'waitintOnPa', 'waitintOnPaIa', 'waitintOnIa',
                'waitintOnServices', 'waitintOnStaff', 'waitintOnSchool'
            ])->default('inactive');
            $table->string('patient_control')->nullable();
            // $table->json('pa_assessments')->nullable();
            // $table->string('compayment_per_visit')->nullable();
            // $table->string('insurer_secundary', 50)->nullable();

            // Status enums
            $table->enum('welcome', ['waiting', 'reviewing', 'psycho eval', 'requested', 'need new', 'yes', 'no', '2 insurance'])->default('waiting');
            $table->enum('consent', ['waiting', 'reviewing', 'psycho eval', 'requested', 'need new', 'yes', 'no', '2 insurance'])->default('waiting');
            $table->enum('insurance_card', ['waiting', 'reviewing', 'psycho eval', 'requested', 'need new', 'yes', 'no', '2 insurance'])->default('waiting');
            $table->enum('mnl', ['waiting', 'reviewing', 'psycho eval', 'requested', 'need new', 'yes', 'no', '2 insurance'])->default('waiting');
            $table->enum('referral', ['waiting', 'reviewing', 'psycho eval', 'requested', 'need new', 'yes', 'no', '2 insurance'])->default('waiting');
            $table->enum('ados', ['waiting', 'reviewing', 'psycho eval', 'requested', 'need new', 'yes', 'no', '2 insurance'])->default('waiting');
            $table->enum('iep', ['waiting', 'reviewing', 'psycho eval', 'requested', 'need new', 'yes', 'no', '2 insurance'])->default('waiting');
            $table->enum('asd_diagnosis', ['waiting', 'reviewing', 'psycho eval', 'requested', 'need new', 'yes', 'no', '2 insurance'])->default('waiting');
            $table->enum('cde', ['waiting', 'reviewing', 'psycho eval', 'requested', 'need new', 'yes', 'no', '2 insurance'])->default('waiting');
            $table->enum('submitted', ['waiting', 'reviewing', 'psycho eval', 'requested', 'need new', 'yes', 'no', '2 insurance'])->default('waiting');
            $table->enum('eligibility', ['pending', 'waiting', 'reviewing', 'psycho eval', 'requested', 'need new', 'yes', 'no', '2 insurance'])->default('pending');
            $table->enum('interview', ['pending', 'send', 'receive', 'no apply'])->default('pending');

            // Provider IDs
            $table->unsignedBigInteger('rbt_home_id')->nullable();
            $table->unsignedBigInteger('rbt2_school_id')->nullable();
            $table->unsignedBigInteger('bcba_home_id')->nullable();
            $table->unsignedBigInteger('bcba2_school_id')->nullable();
            $table->unsignedBigInteger('clin_director_id')->nullable();

            // Flags
            // $table->string('telehealth', 50)->default('false');
            $table->boolean('telehealth')->default(false);
            // $table->string('pay', 50)->default('false');
            $table->boolean('pay')->default(false);
            $table->boolean('emmployment')->default(false);
            $table->boolean('auto_accident')->default(false);
            $table->boolean('other_accident')->default(false);
            $table->boolean('is_self_subscriber')->default(false);

            $table->timestamps();
            $table->softDeletes();

            // Foreign keys for provider relationships
            $table->foreign('rbt_home_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('rbt2_school_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('bcba_home_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('bcba2_school_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('clin_director_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('location_id')->references('id')->on('locations')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
