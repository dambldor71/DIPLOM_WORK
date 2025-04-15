<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use App\Services\Search\TenderService;
use Illuminate\Http\Request;

class FavouriteTenderController extends Controller
{
    public function index(TenderService $service, Request $request)
    {
        $tenderInfo = Tender::select('tenders.id', 'tender_code', 'price', 'link', 'description',
            'customer', 'start_date', 'update_date', 'end_date', 'source_link', 'ft.user_id',
            'p.id as priorityId', 'p.name', 'p.color_code', 'ws.id as stageId', 'ws.name as stageName')
            ->rightJoin('favourite_tenders as ft' , 'ft.tender_id', '=', 'tenders.id')
            ->where('ft.user_id', $request->user()->id)
            ->leftJoin('priority_tender as pt', 'pt.tender_id', '=', 'ft.id')
            ->leftJoin('priority as p', 'p.id', '=', 'pt.priority_id')
            ->leftJoin('work_stage_tenders as wst', 'wst.favourite_id', '=', 'ft.id')
            ->leftJoin('work_stage as ws', 'ws.id', '=', 'wst.stage_id')->orderBy('p.name');
        $searchBox = $request->query();
        $catalogType = 'favourite';

        return $service->showAll($tenderInfo, $searchBox, $catalogType);
    }

    public function show(Request $request, TenderService $service, $id)
    {
        $tenderInfo = Tender::select('tenders.id', 'tender_code', 'price', 'link', 'description',
            'law', 'purchase_stage', 'type_of_select',
            'customer', 'start_date', 'update_date', 'end_date', 'source_link', 'ft.user_id',
            'p.id as priorityId', 'p.name', 'p.color_code', 'ws.id as stageId', 'ws.name as stageName')
            ->rightJoin('favourite_tenders as ft' , 'ft.tender_id', '=', 'tenders.id')
            ->where('ft.user_id', $request->user()->id)
            ->leftJoin('priority_tender as pt', 'pt.tender_id', '=', 'ft.id')
            ->leftJoin('priority as p', 'p.id', '=', 'pt.priority_id')
            ->leftJoin('work_stage_tenders as wst', 'wst.favourite_id', '=', 'ft.id')
            ->leftJoin('work_stage as ws', 'ws.id', '=', 'wst.stage_id');
        $catalogType = 'favourite';

        return $service->showOne($tenderInfo, $request, $id, $catalogType);
    }
}
