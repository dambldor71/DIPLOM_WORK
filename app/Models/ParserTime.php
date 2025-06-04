<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParserTime extends Model
{
    protected $table = 'parser_time';

    protected $fillable = ['user_id', 'all_tenders_time', 'favourite_tenders_time'];
}
