<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\UserInfoModel;
use App\Services\Search\TenderService;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index(TenderService $service)
    {
        $categories = Category::query()->get()->toArray();
        $filters = $service->selectFilter()->get()->toArray();

        return view('main.supportpage', compact('categories', 'filters'));
    }
}
