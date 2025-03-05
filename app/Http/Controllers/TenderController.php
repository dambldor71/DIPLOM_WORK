<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Tender;
use App\Services\Search\TenderService;
use Illuminate\Http\Request;

class TenderController extends Controller
{
    public function index(TenderService $service, Request $request)
    {
        $tenderInfo = Tender::select('id', 'tender_code', 'price', 'link', 'description',
            'customer', 'start_date', 'update_date', 'end_date', 'source_link');

        $searchBox = $request->query();

        return $service->showAll($tenderInfo, $searchBox);
    }

    public function show(Request $request, TenderService $service, $id)
    {
        $tenderInfo = Tender::select('tenders.id', 'tender_code', 'price', 'link', 'description',
            'law', 'purchase_stage', 'type_of_select',
            'customer', 'start_date', 'update_date', 'end_date', 'source_link');

//        dd($tenderInfo->get()->toArray());
        return $service->showOne($tenderInfo, $request, $id);
    }
}
