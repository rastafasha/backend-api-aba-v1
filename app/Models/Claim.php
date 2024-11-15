<?php

namespace App\Models;

use App\Models\Notes\NoteBcba;
use App\Models\Notes\NoteRbt;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Claim",
 *     required={"status", "rbt_notes_ids", "bcba_notes_ids", "filename", "content"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="Claim ID"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         description="Status of the claim",
 *         example="pending"
 *     ),
 *     @OA\Property(
 *         property="rbt_notes_ids",
 *         type="array",
 *         @OA\Items(type="integer"),
 *         description="Array of RBT note IDs"
 *     ),
 *     @OA\Property(
 *         property="bcba_notes_ids",
 *         type="array",
 *         @OA\Items(type="integer"),
 *         description="Array of BCBA note IDs"
 *     ),
 *     @OA\Property(
 *         property="filename",
 *         type="string",
 *         description="Name of the claim file",
 *         example="Claim.dat"
 *     ),
 *     @OA\Property(
 *         property="content",
 *         type="string",
 *         description="Content of the claim file"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Creation timestamp"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Last update timestamp"
 *     )
 * )
 */
class Claim extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'rbt_notes_ids',
        'bcba_notes_ids',
        'filename',
        'content',
    ];

    protected $casts = [
        'rbt_notes_ids' => 'json',
        'bcba_notes_ids' => 'json',
    ];


    public function rbt_notes()
    {
        return $this->belongsToMany(NoteRbt::class, 'note_rbts')
            ->withTimestamps();
    }

    public function bcba_notes()
    {
        return $this->belongsToMany(NoteBcba::class, 'note_bcbas')
            ->withTimestamps();
    }
}
