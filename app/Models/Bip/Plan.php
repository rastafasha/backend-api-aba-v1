<?php

namespace App\Models\Bip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Bip\Bip;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Schema(
 *     schema="Plan",
 *     title="Plan",
 *     description="Plan model for behavior intervention strategies. Can be one of four types: maladaptive (for reducing problem behaviors),
 *         replacement (for teaching alternative behaviors), caregiver_training (for training caregivers), or rbt_training (for training RBTs).",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="bip_id", type="integer", format="int64", example=1, description="ID of the BIP this plan belongs to"),
 *     @OA\Property(property="name", type="string", example="Aggressive Behavior", description="Name of the plan"),
 *     @OA\Property(property="description", type="string", example="Displays aggressive behavior towards others", description="Detailed description of the plan"),
 *     @OA\Property(
 *         property="baseline_level",
 *         type="integer",
 *         format="int32",
 *         example=5,
 *         nullable=true,
 *         description="Required for maladaptive and replacement plans. Initial baseline measurement.
 *             For maladaptive plans, represents frequency of behavior. For replacement plans, represents current skill level."
 *     ),
 *     @OA\Property(
 *         property="baseline_date",
 *         type="string",
 *         format="date",
 *         example="2024-01-01",
 *         nullable=true,
 *         description="Required for maladaptive and replacement plans. Date when baseline was measured."
 *     ),
 *     @OA\Property(
 *         property="initial_intensity",
 *         type="integer",
 *         format="int32",
 *         example=7,
 *         nullable=true,
 *         description="Required for maladaptive and replacement plans. Initial intensity of the behavior (1-10 scale)."
 *     ),
 *     @OA\Property(
 *         property="current_intensity",
 *         type="integer",
 *         format="int32",
 *         example=4,
 *         nullable=true,
 *         description="Required for maladaptive and replacement plans. Current intensity of the behavior (1-10 scale)."
 *     ),
 *     @OA\Property(
 *         property="category",
 *         type="string",
 *         enum={"maladaptive", "replacement", "caregiver_training", "rbt_training"},
 *         example="maladaptive",
 *         description="Category determines required fields and validation rules. Maladaptive and replacement plans require baseline fields.
 *             Each category has specific objective target rules."
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         enum={"active", "completed", "hold", "discontinued", "maintenance", "met", "monitoring"},
 *         example="active",
 *         description="Current status of the plan. Affects whether new objectives can be added."
 *     ),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="deleted_at", type="string", format="datetime", nullable=true),
 *     @OA\Property(
 *         property="objectives",
 *         type="array",
 *         description="List of objectives associated with this plan. Each plan can have multiple STOs (Short Term Objectives)
 *             but only one LTO (Long Term Objective). STOs are ordered by their order field, while LTOs always have order=999.",
 *         @OA\Items(ref="#/components/schemas/Objective")
 *     )
 * )
 */
class Plan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'bip_id',
        'name',
        'description',
        'baseline_level',
        'baseline_date',
        'initial_intensity',
        'current_intensity',
        'category',
        'status',
    ];

    protected $casts = [
        'baseline_date' => 'date:Y-m-d',
    ];

    public function bip()
    {
        return $this->belongsTo(Bip::class, 'bip_id');
    }

    public function objectives()
    {
        return $this->hasMany(Objective::class, 'plan_id')->orderBy('order');
    }

    public static function validate($data, $isUpdate = false)
    {
        $baseRules = [
            'name' => $isUpdate ? 'sometimes|required|string|max:255' : 'required|string|max:255',
            'description' => $isUpdate ? 'sometimes|required|string' : 'required|string',
            'category' => $isUpdate ?
                'sometimes|required|in:maladaptive,replacement,caregiver_training,rbt_training' :
                'required|in:maladaptive,replacement,caregiver_training,rbt_training',
            'status' => $isUpdate ?
                'sometimes|required|in:active,completed,hold,discontinued,maintenance,met,monitoring' :
                'required|in:active,completed,hold,discontinued,maintenance,met,monitoring',
        ];

        // Only require bip_id for new records
        if (!$isUpdate) {
            $baseRules['bip_id'] = 'required|exists:bips,id';
        }

        $validator = Validator::make($data, $baseRules);

        // Only apply baseline validations for maladaptive/replacement categories and new records
        if (!$isUpdate) {
            $validator->sometimes(['baseline_level', 'baseline_date', 'initial_intensity', 'current_intensity'], 'required', function ($input) {
                return in_array($input->category, ['maladaptive', 'replacement']);
            });
        }

        $validator->sometimes(['baseline_level', 'initial_intensity', 'current_intensity'], 'integer', function ($input) {
            return isset($input->category) && in_array($input->category, ['maladaptive', 'replacement']);
        });

        $validator->sometimes('baseline_date', 'date', function ($input) {
            return isset($input->category) && in_array($input->category, ['maladaptive', 'replacement']);
        });

        return $validator;
    }
}
