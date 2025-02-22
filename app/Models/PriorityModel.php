<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriorityModel extends Model
{
    protected $table = 'priority';

    protected $fillable = ['name', 'code', 'color_code'];
}
