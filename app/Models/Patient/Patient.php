<?php

namespace App\Models\Patient;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Bip\Bip;
use App\Models\Location;
use App\Models\Bip\ReductionGoal;
use App\Models\Insurance\Insurance;
use App\Models\PaService;
use App\Traits\LocationFilterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Schema(
 *     schema="Patient",
 *     title="Patient",
 *     description="Patient model",
 *     @OA\Property(property="id", type="integer", format="int64", description="Patient ID"),
 *     @OA\Property(property="location_id", type="integer", format="int64", nullable=true, description="Location ID"),
 *     @OA\Property(property="patient_id", type="string", nullable=true, description="External patient identifier"),
 *     @OA\Property(property="first_name", type="string", maxLength=250, description="Patient's first name"),
 *     @OA\Property(property="last_name", type="string", maxLength=250, description="Patient's last name"),
 *     @OA\Property(property="email", type="string", format="email", maxLength=250, nullable=true, description="Patient's email"),
 *     @OA\Property(property="phone", type="string", maxLength=25, nullable=true, description="Patient's phone number"),
 *     @OA\Property(property="language", type="string", maxLength=150, nullable=true, description="Patient's preferred language"),
 *     @OA\Property(property="parent_guardian_name", type="string", maxLength=150, nullable=true, description="Name of parent or guardian"),
 *     @OA\Property(property="parent_gender", type="integer", enum={1,2}, nullable=true, description="Parent or guardian's gender"),
 *     @OA\Property(property="parent_birth_date", type="string", format="m-d-Y", nullable=true, description="Parent or guardian's birth date"),
 *     @OA\Property(property="parent_address", type="string", maxLength=150, nullable=true, description="Parent or guardian's address"),
 *     @OA\Property(property="parent_city", type="string", maxLength=150, nullable=true, description="Parent or guardian's city"),
 *     @OA\Property(property="parent_state", type="string", maxLength=150, nullable=true, description="Parent or guardian's state"),
 *     @OA\Property(property="parent_zip", type="string", maxLength=150, nullable=true, description="Parent or guardian's zip code"),
 *     @OA\Property(property="relationship", type="string", maxLength=150, nullable=true, description="Relationship to patient"),
 *     @OA\Property(property="home_phone", type="string", maxLength=150, nullable=true, description="Home phone number"),
 *     @OA\Property(property="work_phone", type="string", maxLength=150, nullable=true, description="Work phone number"),
 *     @OA\Property(property="school_name", type="string", maxLength=150, nullable=true, description="School name"),
 *     @OA\Property(property="school_number", type="string", maxLength=150, nullable=true, description="School contact number"),
 *     @OA\Property(property="gender", type="integer", enum={1,2}, default=1, description="Patient's gender"),
 *     @OA\Property(property="birth_date", type="string", format="m-d-Y", nullable=true, description="Patient's birth date"),
 *     @OA\Property(property="age", type="integer", readOnly=true,  description="Patient's age (calculated from birth_date)"),
 *     @OA\Property(property="address", type="string", nullable=true, description="Patient's address"),
 *     @OA\Property(property="city", type="string", nullable=true, description="City"),
 *     @OA\Property(property="state", type="string", maxLength=150, nullable=true, description="State"),
 *     @OA\Property(property="zip", type="string", maxLength=150, nullable=true, description="ZIP code"),
 *     @OA\Property(property="avatar", type="string", nullable=true, description="Avatar image path"),
 *     @OA\Property(property="special_note", type="string", nullable=true, description="Special notes"),
 *     @OA\Property(property="status", type="string",
 *      enum={"incoming", "active", "inactive", "onHold", "onDischarge", "waitintOnPa", "waitintOnPaIa", "waitintOnIa", "waitintOnServices", "waitintOnStaff", "waitintOnSchool"},
 *      default="inactive", description="Patient status"),
 *     @OA\Property(property="insurer_id", type="integer", format="int64", nullable=true, description="Insurance ID"),
 *     @OA\Property(property="insurer_secondary_id", type="integer", format="int64", nullable=true, description="Insurance secondary ID"),
 *     @OA\Property(property="insurance_identifier", type="string", nullable=true),
 *     @OA\Property(property="insurance_secondary_identifier", type="string", nullable=true),
 *     @OA\Property(property="telehealth", type="boolean", default=false, description="Telehealth status"),
 *     @OA\Property(property="pay", type="boolean", default=false, description="Payment status"),
 *     @OA\Property(property="created_at", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="updated_at", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true)
 * )
 *
 * @OA\Schema(
 *     schema="PatientIntake",
 *     title="Patient Intake Status",
 *     @OA\Property(property="welcome", type="string", enum={"waiting", "reviewing", "psycho eval", "requested", "need new", "yes", "no", "2 insurance"}, default="waiting"),
 *     @OA\Property(property="consent", type="string",
 *      enum={"waiting", "reviewing", "psycho eval", "requested", "need new", "yes", "no", "2 insurance"},
 *      default="waiting"),
 *     @OA\Property(property="insurance_card", type="string",
 *      enum={"waiting", "reviewing", "psycho eval", "requested", "need new", "yes", "no", "2 insurance"},
 *      default="waiting"),
 *     @OA\Property(property="eligibility", type="string",
 *      enum={"pending", "waiting", "reviewing", "psycho eval", "requested", "need new", "yes", "no", "2 insurance"}, default="pending"),
 *     @OA\Property(property="interview", type="string", enum={"pending", "send", "receive", "no apply"}, default="pending")
 * )
 */
class Patient extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LocationFilterable;

    protected $fillable = [
        'rbt_home_id',
        'rbt2_school_id',
        'bcba_home_id',
        'bcba2_school_id',
        'clin_director_id',
        'location_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'patient_identifier', // en este caso el es ingresado manualmente ...
        'birth_date',
        'gender',
        'address',
        'language',
        'relationship',
        'home_phone',
        'home_phone',
        'work_phone',
        'school_name',
        'school_number',
        // 'age',
        'education',
        'profession',
        'zip',
        'state',
        'avatar',
        'special_note',
        'city',
        'diagnosis_code',
        'patient_control',
        'schedule',
        'summer_schedule',

        //benefits
        'insurer_id',
        'insurer_secondary_id',

        // 'insuranceId',
        'insurance_identifier',
        'insurance_secondary_identifier',
        'elegibility_date',
        'pos_covered',
        'deductible_individual_I_F',
        'balance',
        'coinsurance',
        'copayments',
        'oop',
        'eqhlid',
        'telehealth',
        'pay',

        // Parent / Guardian
        'parent_guardian_name',
        'parent_gender',
        'parent_birth_date',
        'parent_address',
        'parent_city',
        'parent_state',
        'parent_zip',

        //intake
        'welcome',
        'consent',
        'insurance_card',
        'eligibility',
        'mnl',
        'referral',
        'ados',
        'iep',
        'asd_diagnosis',
        'cde',
        'submitted',
        'interview',

        //pas
        // 'pa_assessments',
        'status',
        'emmployment',
        'auto_accident',
        'other_accident',
        'is_self_subscriber',
        'referring_provider_first_name',
        'referring_provider_last_name',
        'referring_provider_npi',
        'npi',

        //??
        // 'current_auth_expires',
        // 'telehealth',
        // 'insurer',
        // 'compayment_per_visit',
        // 'need_cognitive_eval',
        // 'rst_wk_hr',
        // 'rst',
        // 'an_wk_s',
        // 'pt',
        // 'school_bcba',
        // 'analyst_bcba',
        // 'data_report_and_rbt_correction'

    ];

    protected $casts = [
        'pos_covered' => 'array',
        'birth_date' => 'date:Y-m-d',
        'parent_birth_date' => 'date:Y-m-d',
        'pay' => 'boolean',
        'telehealth' => 'boolean',
        'emmployment' => 'boolean',
        'auto_accident' => 'boolean',
        'other_accident' => 'boolean',
        'is_self_subscriber' => 'boolean',
    ];

    protected $appends = ['age'];

    public function getAgeAttribute()
    {
        if (!$this->birth_date) {
            return null;
        }

        return Carbon::parse($this->birth_date)->age;
    }


    public const WAITING = 'waiting';
    public const REQUESTED = 'requested';
    public const REVIEWING = 'reviewing';
    public const NEED_NEW = 'need new';
    public const INSURANCE = '2 insurance';
    public const PSYCHO_EVAL = 'psycho eval';
    public const YES = 'yes';
    public const NO = 'no';

    public static function welcomeTypes()
    {
        return [
            self::WAITING,
            self::REQUESTED,
            self::REVIEWING,
            self::REQUESTED,
            self::NEED_NEW,
            self::PSYCHO_EVAL,
            self::INSURANCE,
            self::NO,
            self::YES,
        ];
    }
    public static function consentTypes()
    {
        return [
            self::WAITING,
            self::REQUESTED,
            self::REVIEWING,
            self::REQUESTED,
            self::NEED_NEW,
            self::PSYCHO_EVAL,
            self::INSURANCE,
            self::NO,
            self::YES,
        ];
    }
    public static function insurance_cardTypes()
    {
        return [
            self::WAITING,
            self::REQUESTED,
            self::REVIEWING,
            self::REQUESTED,
            self::NEED_NEW,
            self::PSYCHO_EVAL,
            self::INSURANCE,
            self::NO,
            self::YES,
        ];
    }
    public static function mnlTypes()
    {
        return [
            self::WAITING,
            self::REQUESTED,
            self::REVIEWING,
            self::REQUESTED,
            self::NEED_NEW,
            self::PSYCHO_EVAL,
            self::INSURANCE,
            self::NO,
            self::YES,
        ];
    }
    public static function referralTypes()
    {
        return [
            self::WAITING,
            self::REQUESTED,
            self::REVIEWING,
            self::REQUESTED,
            self::NEED_NEW,
            self::PSYCHO_EVAL,
            self::INSURANCE,
            self::NO,
            self::YES,
        ];
    }
    public static function adosTypes()
    {
        return [
            self::WAITING,
            self::REQUESTED,
            self::REVIEWING,
            self::REQUESTED,
            self::NEED_NEW,
            self::PSYCHO_EVAL,
            self::INSURANCE,
            self::NO,
            self::YES,
        ];
    }
    public static function iepTypes()
    {
        return [
            self::WAITING,
            self::REQUESTED,
            self::REVIEWING,
            self::REQUESTED,
            self::NEED_NEW,
            self::PSYCHO_EVAL,
            self::INSURANCE,
            self::NO,
            self::YES,
        ];
    }
    public static function asd_diagnosisTypes()
    {
        return [
            self::WAITING,
            self::REQUESTED,
            self::REVIEWING,
            self::REQUESTED,
            self::NEED_NEW,
            self::PSYCHO_EVAL,
            self::INSURANCE,
            self::NO,
            self::YES,
        ];
    }
    public static function cdeTypes()
    {
        return [
            self::WAITING,
            self::REQUESTED,
            self::REVIEWING,
            self::REQUESTED,
            self::NEED_NEW,
            self::PSYCHO_EVAL,
            self::INSURANCE,
            self::NO,
            self::YES,
        ];
    }
    public static function submittedTypes()
    {
        return [
            self::WAITING,
            self::REQUESTED,
            self::REVIEWING,
            self::REQUESTED,
            self::NEED_NEW,
            self::PSYCHO_EVAL,
            self::INSURANCE,
            self::NO,
            self::YES,
        ];
    }



    public function setCreateAttribute($value)
    {
        date_default_timezone_set("America/Caracas");
        $this->attribute['created_at'] = Carbon::now();
    }

    public function setUpdateAttribute($value)
    {
        date_default_timezone_set("America/Caracas");
        $this->attribute['updated_at'] = Carbon::now();
    }




    public function rbt_home()
    {
        return $this->belongsTo(User::class, 'rbt_home_id');
    }
    public function rbt2_school()
    {
        return $this->belongsTo(User::class, 'rbt2_school_id');
    }
    public function bcba_home()
    {
        return $this->belongsTo(User::class, 'bcba_home_id');
    }
    public function bcba2_school()
    {
        return $this->belongsTo(User::class, 'bcba2_school_id');
    }
    public function clin_director()
    {
        return $this->belongsTo(User::class, 'clin_director_id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'id');
    }
    public function local_manager()
    {
        return $this->belongsTo(User::class, 'id');
    }
    public function doctors()
    {
        return $this->hasMany(User::class, 'id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function insurances()
    {
        return $this->belongsTo(Insurance::class, 'insurer_id');
    }

    public function insurer()
    {
        return $this->belongsTo(Insurance::class, 'insurer_id');
    }

    public function insurance_secondary()
    {
        return $this->belongsTo(Insurance::class, 'insurer_secondary_id');
    }

    public function bip()
    {
        return $this->hasOne(Bip::class, 'patient_identifier');
    }

    public function reductiongoal()
    {
        return $this->hasMany(ReductionGoal::class, 'patient_identifier');
    }


    public function paServices()
    {
        return $this->hasMany(PaService::class);
    }





    //filtro buscador
    public function scopefilterAdvancePatient(
        $query,
        $patient_identifier,
        $name_patient,
        $email_patient,
        $status
    ) {

        if ($patient_identifier) {
            $query->where("patient_identifier", $patient_identifier);
        }

        if ($name_patient) {
            $query->whereHas("patient", function ($q) use ($name_patient) {
                $q->where(DB::raw("CONCAT(patients.first_name,' ',IFNULL(patients.last_name,''),' ',IFNULL(patients.email,''))"), "like", "%" . $name_patient . "%");
            });
        }
        if ($status) {
            $query->where('status', $status);
        }


        // if($date_start && $date_end){
        //     $query->whereBetween("date_appointment", [
        //         Carbon::parse($date_start)->format("Y-m-d"),
        //         Carbon::parse($date_end)->format("Y-m-d"),
        //     ]);
        // }
        return $query;
    }

    //filtro buscador
    public function scopefilterAdvanceClientLog(
        $query,
        $patient_identifier,
        $name_patient,
        $email_patient,
        $status
        // $rbt_home,
        //         $rbt2_school,
        //         $bcba_home,
        //         $bcba2_school,
        //         $clin_director,
    ) {

        if ($patient_identifier) {
            $query->where("patient_identifier", $patient_identifier);
        }

        if ($name_patient) {
            $query->whereHas("patient", function ($q) use ($name_patient) {
                $q->where(DB::raw("CONCAT(patients.first_name,' ',IFNULL(patients.last_name,''),' ',IFNULL(patients.email,''))"), "like", "%" . $name_patient . "%");
            });
        }
        // if($rbt_home){
        //     $query->whereHas("rbt_home", function($q)use($rbt_home){
        //         $q->where(DB::raw("CONCAT(users.name,' ',IFNULL(users.surname,''),' ',IFNULL(users.email,''))"),"like","%".$rbt_home."%");

        //     });
        // }
        if ($status) {
            $query->where('status', $status);
        }


        // if($date_start && $date_end){
        //     $query->whereBetween("date_appointment", [
        //         Carbon::parse($date_start)->format("Y-m-d"),
        //         Carbon::parse($date_end)->format("Y-m-d"),
        //     ]);
        // }
        return $query;
    }
}
