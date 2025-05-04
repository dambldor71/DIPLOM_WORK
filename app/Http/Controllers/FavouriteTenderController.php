<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use App\Services\Search\TenderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavouriteTenderController extends Controller
{
    public function index(TenderService $service, Request $request)
    {
        $tenderInfo = Tender::select('tenders.id', 'tender_code', 'price', 'link', 'description',
            'customer',
            DB::raw("TO_CHAR(start_date, 'DD.MM.YYYY') as start_date"),
            DB::raw("TO_CHAR(update_date, 'DD.MM.YYYY') as update_date"),
            DB::raw("TO_CHAR(end_date, 'DD.MM.YYYY') as end_date"),
            DB::raw("AGE(end_date, NOW()::date) as difference"),
            DB::raw("TO_CHAR(tenders.updated_at, 'DD.MM.YYYY HH24:MI') as updating_at"),
            'source_link', 'ft.user_id',
            'p.id as priorityId', 'p.name', 'p.color_code', 'ws.id as stageId', 'ws.name as stageName',
            'filter_law.name as law_name', 'filter_stage.name as purchase_stage')
            ->rightJoin('favourite_tenders as ft' , 'ft.tender_id', '=', 'tenders.id')
            ->where('ft.user_id', $request->user()->id)
            ->leftJoin('priority_tender as pt', 'pt.tender_id', '=', 'ft.id')
            ->leftJoin('priority as p', 'p.id', '=', 'pt.priority_id')
            ->leftJoin('work_stage_tenders as wst', 'wst.favourite_id', '=', 'ft.id')
            ->leftJoin('work_stage as ws', 'ws.id', '=', 'wst.stage_id')->orderBy('p.name')
            ->leftJoin('filters as filter_law', 'tenders.law', '=', 'filter_law.fid')
            ->leftJoin('filters as filter_stage', 'tenders.purchase_stage', '=', 'filter_stage.fid');
        $searchBox = $request->query();
        $catalogType = 'favourite';

        return $service->showAll($tenderInfo, $searchBox, $catalogType);
    }

    public function show(Request $request, TenderService $service, $id)
    {
        $tenderInfo = Tender::select('tenders.id', 'tender_code', 'price', 'link', 'description',
            'law', 'purchase_stage', 'type_of_select',
            'customer',
            DB::raw("TO_CHAR(start_date, 'DD.MM.YYYY') as start_date"),
            DB::raw("TO_CHAR(update_date, 'DD.MM.YYYY') as update_date"),
            DB::raw("TO_CHAR(end_date, 'DD.MM.YYYY') as end_date"),
            DB::raw("AGE(end_date, NOW()::date) as difference"),
            DB::raw("TO_CHAR(tenders.updated_at, 'DD.MM.YYYY HH24:MI') as updating_at"),
            'source_link', 'ft.user_id',
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
