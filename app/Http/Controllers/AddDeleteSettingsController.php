<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\PriorityModel;
use App\Models\WorkStageModel;
use Illuminate\Http\Request;

class AddDeleteSettingsController extends Controller
{
    public function addStage(Request $request): void
    {
        WorkStageModel::query()->insert(['name' => $request->stageName, 'code' => $request->stageCode, 'user_id' => $request->userId]);
    }

    public function deleteStage(Request $request): void
    {
        WorkStageModel::where('id', (int)$request->stageId)->delete();
    }

    public function addPriority(Request $request): void
    {
        $id = PriorityModel::count() + 1;
        PriorityModel::query()->insert(['id' => $id, 'name' => $request->priorityName, 'code' => $request->priorityCode,
            'color_code' => $request->priorityColor, 'user_id' => $request->userId]);
    }

    public function deletePriority(Request $request): void
    {
        PriorityModel::where('id', (int)$request->priorityId)->delete();
    }
}
