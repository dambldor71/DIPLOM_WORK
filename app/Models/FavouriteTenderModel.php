<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavouriteTenderModel extends Model
{
    protected $table = 'favourite_tenders';

    protected $fillable = ['tender_id', 'user_id'];
}
