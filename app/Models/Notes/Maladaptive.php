<?php

namespace App\Models\Notes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Maladaptive extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
        'patient_id',
        'note_rbt_id',
        'maladaptive_behavior',
        'number_of_occurrences',

    ];
}
