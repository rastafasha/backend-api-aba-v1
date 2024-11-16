<?php

namespace App\Models\Notes;

use App\Models\Notes\Traits\HasClientFromBip;
use App\Models\Notes\Traits\HasDoctor;
use App\Models\Notes\Traits\HasProvider;
use App\Models\Notes\Traits\HasSupervisor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

abstract class Note extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasProvider;
    use HasSupervisor;
    use HasClientFromBip;
    use HasDoctor;



    
}