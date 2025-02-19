<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\Search\SearchTenderService;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function indexWelcome(SearchTenderService $service) {
        $categories = Category::query()->get()->toArray();

        $filters = $service->selectFilter()->get()->toArray();

        return view('welcome', compact('categories', 'filters'));
    }
}
