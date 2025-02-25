<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkStageTendersModel extends Model
{
    protected $table = 'work_stage_tenders';

    protected $fillable = ['favourite_id', 'stage_id'];
}
