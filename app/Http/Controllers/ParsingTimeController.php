<?php

namespace App\Http\Controllers;

use App\Models\ParserTime;
use Illuminate\Http\Request;

class ParsingTimeController extends Controller
{
    public function addParsingTime(Request $request)
    {
        $userParserTime = ParserTime::query()->get()->toArray();

        if (!empty($userParserTime)) {
            $this->updateParserTime($request);
        } else {
            ParserTime::query()->insert(['user_id' => $request->userId,
                'all_tenders_time' => $request->allTendersTime,
                'favourite_tenders_time' => $request->favouriteTendersTime]);
        }
    }

    private function updateParserTime(Request $request)
    {
        ParserTime::query()->update(['all_tenders_time' => $request->allTendersTime,
                'favourite_tenders_time' => $request->favouriteTendersTime
            ]);
    }
}
