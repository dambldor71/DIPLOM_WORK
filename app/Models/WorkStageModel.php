<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkStageModel extends Model
{
    protected $table = 'work_stage';

    protected $fillable = ['name', 'code', 'user_id'];
}
