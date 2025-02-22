<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriorityTenderModel extends Model
{
    protected $table = 'priority_tender';

    protected $fillable = ['tender_id', 'priority_id'];
}
