<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Location;
use App\Models\Patient\Patient;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Parents extends Authenticatable implements JWTSubject
{
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use SoftDeletes;


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }


    protected $fillable = [
        'name',
        'surname',
        'email',
        'patient_identifier',
        'phone',
        'birth_date',
        'gender',
        'address',
        'avatar',
        'status',
        'documents_pending',
        'location_id',
        'password',


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

    public const PARENT = 'PARENT';

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

    public function isParent()
    {
        return $this->role === Parents::PARENT;
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_identifier');
    }
}
