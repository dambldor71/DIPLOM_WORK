<?php

namespace App\Http\Controllers;

use App\Models\FavouriteTenderModel;
use App\Models\PriorityTenderModel;
use App\Models\WorkStageTendersModel;
use Illuminate\Http\Request;

class ChosenTenderController extends Controller
{
    public function addFavouriteTender(Request $request): void
    {
        $chosenTenders = FavouriteTenderModel::select('tender_id')->pluck('tender_id')->toArray();

        if (!in_array($request->tenderId, $chosenTenders)) {
            FavouriteTenderModel::query()
                ->insert(['tender_id' => $request->tenderId, 'user_id' => $request->userId]);

            $favouriteTenderId = FavouriteTenderModel::select('id')
                ->where('tender_id', $request->tenderId)->first()->toArray();

            PriorityTenderModel::query()
                ->insert(['tender_id' => $favouriteTenderId['id'], 'priority_id' => $request->priority]);
        } else {
            $favouriteTenderId = FavouriteTenderModel::select('id')
                ->where('tender_id', $request->tenderId)->first()->toArray();

            PriorityTenderModel::where('tender_id', $favouriteTenderId['id'])
                ->update(['priority_id' => $request->priority]);
        }
    }

    public function addStageTender(Request $request): void
    {
        $favouriteId = FavouriteTenderModel::where('tender_id', $request->tenderId)->pluck('id')->first();

        if (WorkStageTendersModel::where('favourite_id', $favouriteId)->count() !== 0) {
            WorkStageTendersModel::query()->where('favourite_id', $favouriteId)->update(['stage_id' => $request->stage]);
        } else {
            WorkStageTendersModel::query()->insert(['favourite_id' => $favouriteId, 'stage_id' => $request->stage]);
        }
    }

    public function removeFavouriteTender(Request $request): void
    {
        $favouriteId = FavouriteTenderModel::where('tender_id', $request->tenderId)->pluck('id')->first();

        PriorityTenderModel::where('tender_id', $favouriteId)->delete();
        WorkStageTendersModel::where('favourite_id', $favouriteId)->delete();
        FavouriteTenderModel::where('tender_id', $request->tenderId)->delete();
    }
}
