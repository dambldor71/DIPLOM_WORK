<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function export(Request $request)
    {
        return Excel::download(
            new UsersExport(
                Auth::id(),
                $request['kinds'],
                array_slice($request->all(), 2)),
            $request['file-name']. '.xlsx'
        );
    }
}
