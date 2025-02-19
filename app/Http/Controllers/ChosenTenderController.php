<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChosenTenderController extends Controller
{
    public function index(Request $request) {
        dd($request);
        return view('chosenTender');
    }
}
