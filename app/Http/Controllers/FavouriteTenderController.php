<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use App\Services\Favourite\FavouriteTenderService;
use App\Services\Search\TenderService;
use Illuminate\Http\Request;

class FavouriteTenderController extends Controller
{
    public function index(TenderService $service, Request $request)
    {
        $tenderInfo = Tender::select('tenders.id', 'tender_code', 'price', 'link', 'description',
            'customer', 'start_date', 'update_date', 'end_date', 'source_link', 'ft.user_id')
            ->rightJoin('favourite_tenders as ft' , 'ft.tender_id', '=', 'tenders.id')
            ->where('user_id', $request->user()->id);
        $searchBox = $request->query();
        $catalogType = 'favourite';

        return $service->showAll($tenderInfo, $searchBox, $catalogType);
    }

    public function show(TenderService $service, $id)
    {
        $service->showOne($id);
    }
}
