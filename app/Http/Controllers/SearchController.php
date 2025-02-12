<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\myModel;

use App\Services\Search\SearchTenderService;
use Illuminate\Http\Request;
use phpQuery;

class SearchController extends Controller
{
    public function index(SearchTenderService $service)
    {
        return $service->searchAllTenders();
    }
}
