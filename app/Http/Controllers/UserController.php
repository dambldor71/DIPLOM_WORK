<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\UserInfoModel;
use App\Services\Search\TenderService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index($id, TenderService $service)
    {
        $userInfo = UserInfoModel::select('name', 'surname', 'phone', 'birthday', 'organization')->where('user_id', $id)->get()->toArray();
        if ($userInfo === []) {
            $userInfo = [0 => ["name" => "Данные",
                                "surname" => "отсутствуют",
                                "phone" => "Данные отсутствуют",
                                "birthday" => "Данные отсутствуют",
                                "organization" => "Данные отсутствуют",
                                "telegram" => "Данные отсутствуют"]];
        }
        $categories = Category::query()->get()->toArray();
        $filters = $service->selectFilter()->get()->toArray();

        return view('profile.editinfo', compact('categories', 'filters', 'userInfo'));
    }

    public function update(Request $request)
    {
        UserInfoModel::where('user_id', $request->userId)->update(['name' => $request->name, 'surname' => $request->surname,
            'phone' => $request->phone, 'birthday' => $request->birthday, 'organization' => $request->organization]);
    }
}
