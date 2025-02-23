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

    public function show(TenderService $service, $id)
    {
        return $service->showOne($id);
    }
}
