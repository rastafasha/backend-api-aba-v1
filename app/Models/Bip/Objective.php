<?php

namespace App\Models\Bip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Schema(
 *     schema="Objective",
 *     title="Objective",
 *     description="Objective model for behavior intervention plans. Has multiple STOs and one LTO.",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="plan_id", type="integer", format="int64", example=1, description="ID of the plan this objective belongs to"),
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         enum={"STO", "LTO"},
 *         example="STO",
 *         description="STO = Short Term Objective (multiple allowed per plan), LTO = Long Term Objective (only one per plan).",
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         enum={"in progress", "mastered", "not started", "discontinued", "maintenance"},
 *         example="in progress",
 *         description="Current status of the objective. Affects data collection and progress tracking."
 *     ),
 *     @OA\Property(
 *         property="initial_date",
 *         type="string",
 *         format="date",
 *         example="2024-01-01",
 *         nullable=true,
 *         description="Start date of the objective. Must be before end_date. Required when status changes from 'not started'."
 *     ),
 *     @OA\Property(
 *         property="end_date",
 *         type="string",
 *         format="date",
 *         example="2024-03-01",
 *         nullable=true,
 *         description="End date of the objective. Must be after initial_date. Required when status changes from 'not started'."
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         example="Reduce inappropriate behavior to less than 5 instances per day",
 *         description="Detailed description of what this objective aims to achieve. Should be specific and measurable."
 *     ),
 *     @OA\Property(
 *         property="start_point",
 *         type="number",
 *         format="float",
 *         example=10,
 *         nullable=true,
 *         description="Starting point of the objective. For maladaptive plans: initial value, for replacement plans: 0, for training plans: 0."
 *     ),
 *     @OA\Property(
 *         property="target",
 *         type="number",
 *         format="float",
 *         example=5,
 *         nullable=true,
 *         description="Target value to achieve. For maladaptive plans: decreases, for replacement plans: increases, for training plans: mastery percentage."
 *     ),
 *     @OA\Property(
 *         property="order",
 *         type="integer",
 *         example=1,
 *         description="Order of the objective. For LTOs, this is always 999. For STOs, this determines their sequence.",
 *     ),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="deleted_at", type="string", format="datetime", nullable=true)
 * )
 */
class Objective extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'plan_id',
        'type',
        'status',
        'initial_date',
        'end_date',
        'description',
        'start_point',
        'target',
        'order'
    ];

    protected $casts = [
        'initial_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
        'start_point' => 'integer',
        'target' => 'integer',
        'order' => 'integer'
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public static function validate($data)
    {
        $validator = Validator::make($data, [
            'plan_id' => 'required|exists:plans,id',
            'type' => 'required|in:STO,LTO',
            'status' => 'required|in:in progress,mastered,not started,discontinued,maintenance',
            'initial_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:initial_date',
            'description' => 'required|string',
            'start_point' => 'nullable|numeric',
            'target' => 'nullable|numeric',
            'order' => [
                'nullable',
                'integer',
                function ($attribute, $value, $fail) use ($data) {
                    if (isset($data['type']) && $data['type'] === 'LTO' && isset($value) && $value !== 999) {
                        $fail('LTO order must be 999');
                    }
                }
            ]
        ]);

        $validator->after(function ($validator) use ($data) {
            // Check for multiple LTOs
            if (isset($data['type']) && $data['type'] === 'LTO' && isset($data['plan_id'])) {
                $existingLto = self::where('plan_id', $data['plan_id'])
                    ->where('type', 'LTO')
                    ->when(isset($data['id']), function ($query) use ($data) {
                        return $query->where('id', '!=', $data['id']);
                    })
                    ->exists();

                if ($existingLto) {
                    $validator->errors()->add('multiple_lto', 'Plan already has a long term objective');
                }
            }

            // Validate target based on plan category
            if (isset($data['target']) && isset($data['plan_id'])) {
                $plan = Plan::find($data['plan_id']);
                if ($plan) {
                    if ($plan->category === 'maladaptive' && $data['target'] > 100) {
                        $validator->errors()->add('target', 'Target for maladaptive plans must be between 0 and 100');
                    } elseif ($plan->category === 'replacement' && $data['target'] < 0) {
                        $validator->errors()->add('target', 'Target for replacement plans must be greater than or equal to 0');
                    }
                }
            }
        });

        return $validator;
    }
}
