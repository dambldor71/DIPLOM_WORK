<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Tender;
use App\Services\Search\TenderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TenderController extends Controller
{
    public function index(TenderService $service, Request $request)
    {
//        dd($request->query());
        $tenderInfo = Tender::select('id', 'tender_code', 'price', 'link', 'description',
            'customer',
            DB::raw("TO_CHAR(start_date, 'DD.MM.YYYY') as start_date"),
            DB::raw("TO_CHAR(update_date, 'DD.MM.YYYY') as update_date"),
            DB::raw("TO_CHAR(end_date, 'DD.MM.YYYY') as end_date"),
            DB::raw("AGE(end_date, NOW()::date) as difference"),
            'source_link', 'filter_law.name as law_name', 'filter_stage.name as purchase_stage')
            ->leftJoin('filters as filter_law', 'tenders.law', '=', 'filter_law.fid')
            ->leftJoin('filters as filter_stage', 'tenders.purchase_stage', '=', 'filter_stage.fid');

        $searchBox = $request->query();

        return $service->showAll($tenderInfo, $searchBox);
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
            'source_link');

//        dd($tenderInfo->get()->toArray());
        return $service->showOne($tenderInfo, $request, $id);
    }
}
