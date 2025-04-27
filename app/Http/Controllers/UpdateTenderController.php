<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UpdateTenderController extends Controller
{
    public function updateTender(Request $request)
    {
//        dd(($request->link));
        $pythonScript = '/home/serik/python/oneTenderParser.py';
        $command = "python3 " . escapeshellarg($pythonScript) . " " . escapeshellarg($request->link);
        $output = shell_exec($command);
    }
}
