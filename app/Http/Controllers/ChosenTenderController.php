<?php

namespace App\Http\Controllers;

use App\Models\FavouriteTenderModel;
use App\Models\PriorityTenderModel;
use Illuminate\Http\Request;

class ChosenTenderController extends Controller
{
    public function addFavouriteTender(Request $request) {
        $chosenTenders = FavouriteTenderModel::select('tender_id')->pluck('tender_id')->toArray();

        if (!in_array($request->tenderId, $chosenTenders)) {
            FavouriteTenderModel::query()
                ->insert(['tender_id' => $request->tenderId, 'user_id' => $request->userId]);

            $favouriteTenderId = FavouriteTenderModel::select('id')
                ->where('tender_id', $request->tenderId)->first()->toArray();

            PriorityTenderModel::query()
                ->insert(['tender_id' => $favouriteTenderId['id'], 'priority_id' => $request->priority]);
        }
    }
}
