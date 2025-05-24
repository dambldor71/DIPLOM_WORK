<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TenderCommentController extends Controller
{
    public function addComment(Request $request)
    {
        DB::table('tender_comments')->insert([
            'tender_id' => $request->tenderId,
            'comment' => $request->comment,
            'user_id' => $request->userId,
            'updated_at' => Carbon::now()
        ]);
    }
}
