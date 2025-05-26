<?php

namespace App\Http\Controllers;

use App\Models\FavouriteTenderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PotentialWinnerController extends Controller
{
    public function addPotentialWinner(Request $request): void
    {
        $favTenderId = FavouriteTenderModel::query()->where('tender_id', $request->tenderId)->pluck('id')->toArray();
        $isUsedTenders = DB::table('tender_potential_winner')->pluck('tender_id')->toArray();

        if (in_array($favTenderId[0], $isUsedTenders)) {
            DB::table('tender_potential_winner')
                ->where('tender_id', '=', $favTenderId)
                ->update(['tender_id' => $favTenderId[0], 'potential_winner_id' => $request->potentialId, 'user_id' => $request->userId]);
        } else {
            DB::table('tender_potential_winner')
                ->insert(['tender_id' => $favTenderId[0], 'potential_winner_id' => $request->potentialId, 'user_id' => $request->userId]);
        }


    }
}
