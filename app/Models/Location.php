<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Patient\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="Location",
 *     required={"title"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="Location ID",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         maxLength=150,
 *         description="Location title/name",
 *         example="Main Office"
 *     ),
 *     @OA\Property(
 *         property="address",
 *         type="string",
 *         description="Physical address of the location",
 *         example="123 Main Street"
 *     ),
 *     @OA\Property(
 *         property="phone1",
 *         type="string",
 *         maxLength=50,
 *         description="Primary phone number",
 *         example="555-0123"
 *     ),
 *     @OA\Property(
 *         property="phone2",
 *         type="string",
 *         maxLength=50,
 *         description="Secondary phone number",
 *         example="555-0124"
 *     ),
 *     @OA\Property(
 *         property="city",
 *         type="string",
 *         maxLength=150,
 *         description="City name",
 *         example="New York"
 *     ),
 *     @OA\Property(
 *         property="state",
 *         type="string",
 *         maxLength=150,
 *         description="State name",
 *         example="NY"
 *     ),
 *     @OA\Property(
 *         property="zip",
 *         type="string",
 *         maxLength=150,
 *         description="ZIP/Postal code",
 *         example="10001"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         maxLength=150,
 *         description="Contact email address",
 *         example="contact@location.com"
 *     ),
 *     @OA\Property(
 *         property="telfax",
 *         type="string",
 *         description="Fax number",
 *         example="555-0125"
 *     ),
 *     @OA\Property(
 *         property="avatar",
 *         type="string",
 *         description="URL to location's image/avatar",
 *         example="storage/locations/avatar.jpg"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Creation timestamp",
 *         example="2024-01-01 12:00:00"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Last update timestamp",
 *         example="2024-01-01 12:00:00"
 *     ),
 *     @OA\Property(
 *         property="deleted_at",
 *         type="string",
 *         format="date-time",
 *         nullable=true,
 *         description="Soft delete timestamp",
 *         example=null
 *     )
 * )
 */
class Location extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'address',
        'phone1',
        'phone2',
        'city',
        'state',
        'zip',
        'email',
        'avatar',
        'telfax',
    ];

    //relations
    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function specialists()
    {
        return $this->belongsToMany(User::class, 'user_locations')
            ->withTimestamps();
    }

    //filtro buscador
    public function scopefilterAdvanceLocation(
        $query,
        $client_id,
        $name_client,
        $email_client,
        $doctor_id,
        $name_doctor,
        $email_doctor,
    ) {

        if ($client_id) {
            $query->where("client_id", $client_id);
        }

        if ($name_client) {
            $query->whereHas("patient", function ($q) use ($name_client) {
                $q->where(DB::raw("CONCAT(patients.first_name,' ',IFNULL(patients.last_name,''),' ',IFNULL(patients.email,''))"), "like", "%" . $name_patient . "%");
            });
        }
        if ($email_client) {
            $query->whereHas("patient", function ($q) use ($email_client) {
                $query->where("patientID", $patientID);
            });
        }
        if ($doctor_id) {
            $query->where("doctor_id", $doctor_id);
        }

        if ($name_doctor) {
            $query->whereHas("doctor", function ($q) use ($name_doctor) {
                $q->where(DB::raw("CONCAT(doctors.first_name,' ',IFNULL(doctors.last_name,''),' ',IFNULL(doctors.email,''))"), "like", "%" . $name_doctor . "%");
            });
        }
        if ($email_doctor) {
            $query->whereHas("doctor", function ($q) use ($email_doctor) {
                $query->where("doctor_id", $doctor_id);
            });
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
