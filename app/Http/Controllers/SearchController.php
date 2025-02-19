<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Search\SearchTenderService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(SearchTenderService $service, Request $request)
    {
        $searchBox = $request->query();
        return $service->showAll($searchBox);
    }
}
