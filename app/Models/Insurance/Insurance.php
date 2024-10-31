<?php

namespace App\Models\Insurance;

use App\Models\Patient\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Insurance extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
        'insurer_name',
        'services', //Codes, provider, description, unit prize, Hourly Fee, max_allowed
        'notes',//description
    ];

    // protected $casts = [
    //     'services' => 'json',
    //     'notes' => 'json',
    // ];

    public function scopefilterAdvanceInsurance($query,
    $insurer_name
    ){
        
        if($insurer_name){
            $query->where("insurer_name", $insurer_name);
        }
        
        return $query;
    }


    public function patients()
    {
        return $this->hasMany(Patient::class);
    }


}
