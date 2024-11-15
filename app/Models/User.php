<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Location;
use App\Traits\HavePermission;
use App\Models\Patient\Patient;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HavePermission;
    use HasRoles;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | goblan variables
    |--------------------------------------------------------------------------
    */
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',

        //
        'surname',
        'phone',
        'birth_date',
        'gender',
        'address',
        'avatar',
        'status',

        'currently_pay_through_company',
        'llc',
        'ien',
        'wc',
        'electronic_signature',
        'agency_location',
        'city',
        'languages',
        'dob',
        'ss_number',
        'date_of_hire',
        'start_pay',
        'driver_license_expiration',
        'cpr_every_2_years',
        'background_every_5_years',
        'e_verify',
        'national_sex_offender_registry',
        'certificate_number',
        'bacb_license_expiration',
        'liability_insurance_annually',
        'local_police_rec_every_5_years',
        'npi',
        'medicaid_provider',
        'ceu_hippa_annually',
        'ceu_domestic_violence_no_expiration',
        'ceu_security_awareness_annually',
        'ceu_zero_tolerance_every_3_years',
        'ceu_hiv_bloodborne_pathogens_infection_control_no_expiration',
        'ceu_civil_rights_no_expiration',
        'school_badge',
        'w_9_w_4_form',
        'contract',
        'two_four_week_notice_agreement',
        'credentialing_package_bcbas_only',
        'caqh_bcbas_only',
        'contract_type',
        'salary',
        'location_id',

    ];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const SUPERADMIN = 'SUPERADMIN';
    const GUEST = 'GUEST';
    const PARENT = 'PARENT';

    const inactive = 'inactive';
    const active = 'active';
    const blac_list = 'black list';
    const incoming = 'incoming';

    public static function statusTypes()
    {
        return [
            self::inactive, self::active,
            self::blac_list, self::incoming,
        ];
    }

    public function setCreatedAtAttribute($value)
    {
        date_default_timezone_set('America/Caracas');
        $this->attributes["created_at"] = Carbon::now();
    }

    public function setUpdatedAtAttribute($value)
    {
        date_default_timezone_set("America/Caracas");
        $this->attributes["updated_at"] = Carbon::now();
    }


    /*
    |--------------------------------------------------------------------------
    | functions
    |--------------------------------------------------------------------------
    */

    public function isSuperAdmin()
    {
        return $this->role === User::SUPERADMIN;
    }

    public function isGuest()
    {
        return $this->role === User::GUEST;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */


    public function patient()
    {
        return $this->hasMany(Patient::class);
    }



    // public function locations()
    // {
    //     return $this->belongsToMany(UserLocation::class, 'location_id');
    // }

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'user_locations');
    }
}
