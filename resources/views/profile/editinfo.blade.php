@php
    use App\Models\FavouriteTenderModel;use App\Models\PriorityModel;
    use App\Models\PriorityTenderModel;use App\Models\WorkStageModel;
    use App\Models\TelegramModel;
    use App\Models\WorkStageTendersModel;use Illuminate\Support\Facades\Auth;

    $priorities = PriorityModel::query()->where('user_id', Auth::id())->select('id', 'name', 'color_code')->get()->toArray();
    $workStage = WorkStageModel::query()->where('user_id', Auth::id())->select('id', 'name')->get()->toArray();
    $favArray = ['Приоритет' => ['id' => 'priority', 'value' => $priorities], 'Этап работ' => ['id' => 'stage', 'value' => $workStage]];
@endphp

@extends('header')

@section('content')
    <div class="breadcrumb-area breadcrumb-height"
         data-bg-image="{{ asset('myPublic/assets/images/background-img/1920400.png')}}">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-12">
                    <div class="breadcrumb-item text-night-rider">
                        <h2 class="breadcrumb-heading">Личный кабинет</h2>
                        <ul>
                            <li>
                                <a href="{{route('mainpage')}}">На главную</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4" style="text-align: right">
                    <img src="{{ asset('myPublic/assets/images/avatars/ava-default.png')}}" alt="Аватар"
                         class="img-fluid rounded-circle">
                </div>
                <div class="col-md-8">
                    <h3 class="card-title">{{$userInfo[0]['name'] . ' ' . $userInfo[0]['surname']}}</h3>
                    <button class="btn btn-custom-size lg-size btn-primary" style="border-radius: 20px"
                            id="openModalBtn">Редактировать
                    </button>

                    <div id="profileModal" class="modal">
                        <div class="modal-content">
                            <span class="close-button">&times;</span>
                            <h2>Редактировать профиль</h2>
                            <form id="profileForm" method="POST">
                                <div class="tab-pane fade show active">
                                    <label for="user-name">Имя:</label>
                                    <input type="text" placeholder="{{$userInfo[0]['name']}}"
                                           value="{{$userInfo[0]['name']}}" id="user-name" name="user-name"
                                           class="form-control"><br>
                                    <label for="user-surname">Фамилия:</label>
                                    <input type="text" placeholder="{{$userInfo[0]['surname']}}"
                                           value="{{$userInfo[0]['surname']}}" id="user-surname" name="user-surname"
                                           class="form-control"><br>
                                    <label for="user-birthday">Дата рождения:</label>
                                    <input type="date" placeholder="{{$userInfo[0]['birthday']}}"
                                           value="{{$userInfo[0]['birthday']}}" id="user-birthday" name="user-birthday"
                                           class="form-control"><br>
                                    <label for="user-phone">Номер телефона:</label>
                                    <input type="text" placeholder="{{$userInfo[0]['phone']}}"
                                           value="{{$userInfo[0]['phone']}}" id="user-phone" name="user-phone"
                                           class="form-control"><br>
                                    <label for="user-organization">Организация:</label>
                                    <input type="text" placeholder="{{$userInfo[0]['organization']}}"
                                           value="{{$userInfo[0]['organization']}}" id="user-organization"
                                           name="user-organization" class="form-control"><br>
                                    <button class="btn btn-custom-size lg-size btn-primary" style="border-radius: 20px"
                                            id="openModalBtn">{{ __('Сохранить') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <ul class="nav product-tab-nav mb-10" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="active tab-btn" id="information-tab" data-bs-toggle="tab" href="#information"
               role="tab" aria-controls="information" aria-selected="false">
                Персональные данные
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="tab-btn" id="statistics-tab" data-bs-toggle="tab" href="#statistics"
               role="tab" aria-controls="statistics" aria-selected="true">
                Статистика по тендерам
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="tab-btn" id="settings-tab" data-bs-toggle="tab" href="#settings"
               role="tab" aria-controls="settings" aria-selected="true">
                Приоритеты и этапы работ
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="tab-btn" id="parsing-tab" data-bs-toggle="tab" href="#parsing"
               role="tab" aria-controls="parsing" aria-selected="true">
                Частота парсинга
            </a>
        </li>
    </ul>
    <div class="tab-content product-tab-content">
        <div class="tab-pane fade show active" id="information" role="tabpanel" aria-labelledby="information-tab">
            <div class="product-information-body" style="text-align: center">
                <h4 style="color: #2F4C73" class="title">ФИО сотрудника:</h4>
                <h5 class="short-desc mb-4">{{$userInfo[0]['name'] . ' ' . $userInfo[0]['surname']}}</h5>
                <h4 style="color: #2F4C73" class="title">Номер телефона:</h4>
                <h5 class="short-desc mb-4">{{$userInfo[0]['phone']}}</h5>
                <h4 style="color: #2F4C73" class="title">Дата рождения:</h4>
                <h5 class="short-desc mb-4">{{$userInfo[0]['birthday']}}</h5>
                <h4 style="color: #2F4C73" class="title">Организация:</h4>
                <h5 class="short-desc mb-4">{{$userInfo[0]['organization']}}</h5>
                <h4 style="color: #2F4C73" class="title">Telegram:</h4>
                @if(TelegramModel::select('id')->where('user_id', Auth::id())->count())
                    <h5 class="short-desc mb-4"> {{'@' . TelegramModel::where('user_id', Auth::id())->pluck('telegram_id')[0]}}</h5>
                @else
                    <a class="short-desc mb-4" href="https://t.me/PumoriTenderBot">Привязать аккаунт Telegram</a>
                @endif
            </div>
        </div>
        <div class="tab-pane fade" id="statistics" role="tabpanel"
             aria-labelledby="statistics-tab">
            <div class="product-statistics-body">
                <div class="container">
                    <div class="row">
                        <div class="tab-content myaccount-tab-content">
                            <div class="tab-pane active" id="orders">
                                <div class="myaccount-orders">
                                    <h4 class="small-title">Моя статистика</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Описание</th>
                                                <th>Значение</th>
                                                <th>Подробнее</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>Всего тендеров в Избранном</td>
                                                <td>{{FavouriteTenderModel::where('user_id', Auth::id())->count()}}</td>
                                                <td><a href="{{route('favourite')}}" class="btn btn-primary btn-sm">Перейти</a>
                                                </td>
                                            </tr>
                                            @foreach($favArray as $key => $cat)
                                                @foreach($cat['value'] as $elem)
                                                    <tr>
                                                        @if($key === 'Приоритет')
                                                            <td>Всего тендеров с приоритетом &#39;{{$elem['name']}}
                                                                &#39;
                                                            </td>
                                                            <td>{{PriorityTenderModel::where('priority_id', $elem['id'])->leftJoin('favourite_tenders as ft', 'ft.id', '=', 'priority_tender.tender_id')->where('user_id', Auth::id())->count()}}</td>
                                                        @else
                                                            <td>Всего тендеров на этапе &#39;{{$elem['name']}}&#39;</td>
                                                            <td>{{WorkStageTendersModel::where('stage_id', $elem['id'])->leftJoin('favourite_tenders as ft', 'ft.id', '=', 'work_stage_tenders.favourite_id')->where('user_id', Auth::id())->count()}}</td>
                                                        @endif
                                                        <td>
                                                            @if($key === 'Приоритет')
                                                                <a href="http://{{$_SERVER['HTTP_HOST']}}/favourite-catalog?{{$cat['id']}}={{$elem['id']}}&stage=all"
                                                                   class="btn btn-primary btn-sm">Перейти</a>
                                                            @else
                                                                <a href="http://{{$_SERVER['HTTP_HOST']}}/favourite-catalog?priority=all&{{$cat['id']}}={{$elem['id']}}"
                                                                   class="btn btn-primary btn-sm">Перейти</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile">
                                <h4 class="small-title">Настройки профиля</h4>
                            </div>
                            <div class="tab-pane fade" id="address">
                                <h4 class="small-title">Адрес доставки</h4>
                            </div>
                            <div class="tab-pane fade" id="password">
                                <h4 class="small-title">Изменить пароль</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab-tab">
            <div class="product-settings-body">
                <div class="login-form">
                    <h2 class="text-lg font-medium text-gray-900">Редактирование приоритетов</h2>
                    <ul class="nav product-tab-nav mb-10" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="active tab-btn" id="add-priority-tab" data-bs-toggle="tab" href="#add-priority"
                               role="tab" aria-controls="add-priority" aria-selected="false">
                                Добавить
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="tab-btn" id="delete-priority-tab" data-bs-toggle="tab" href="#delete-priority"
                               role="tab" aria-controls="delete-priority" aria-selected="true">
                                Удалить
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content product-tab-content">
                        <div class="tab-pane fade show active" id="add-priority" role="tabpanel"
                             aria-labelledby="add-priority-tab">
                            <div class="product-add-priority-body">
                                <form id='add-priority-form' action="" method="POST">
                                    <label for="name">Название приоритета:</label>
                                    <input type="text" id="name" name="name" class="form-control">
                                    <label for="code">Код приоритета:</label>
                                    <input type="text" id="code" name="code" class="form-control">
                                    <label for="color">Цвет для отображения:</label>
                                    <input type="color" id="color" name="color" class="form-control">
                                    <button class="btn btn-custom-size lg-size btn-primary" style="border-radius: 20px"
                                            id="openModalBtn">{{ __('Сохранить') }}</button>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="delete-priority" role="tabpanel"
                             aria-labelledby="delete-priority-tab">
                            <div class="product-delete-priority-body">
                                <form id='delete-priority-form' action="" method="POST">
                                    <label for="name">Выберите приоритет:</label>
                                    <select id='selectPriority' class="nice-select wide border-bottom-0 rounded-0">
                                        @foreach($priorities as $elem)
                                            <option value="{{$elem['id']}}">{{$elem['name']}}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-custom-size lg-size btn-primary" style="border-radius: 20px"
                                            id="openModalBtn">{{ __('Удалить') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-settings-body">
                <div class="login-form">
                    <h2 class="text-lg font-medium text-gray-900">Редактирование этапов работ</h2>
                    <ul class="nav product-tab-nav mb-10" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="active tab-btn" id="add-workstage-tab" data-bs-toggle="tab" href="#add-workstage"
                               role="tab" aria-controls="add-workstage" aria-selected="false">
                                Добавить
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="tab-btn" id="delete-workstage-tab" data-bs-toggle="tab" href="#delete-workstage"
                               role="tab" aria-controls="delete-workstage" aria-selected="true">
                                Удалить
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content product-tab-content">
                        <div class="tab-pane fade show active" id="add-workstage" role="tabpanel"
                             aria-labelledby="add-workstage-tab">
                            <div class="product-add-workstage-body">
                                <form id='add-stage-form' action="" method="POST">
                                    <label for="name">Наименование этапа работы:</label>
                                    <input type="text" id="name" name="name" class="form-control">
                                    <label for="code">Код этапа работы:</label>
                                    <input type="text" id="code" name="code" class="form-control">
                                    <button class="btn btn-custom-size lg-size btn-primary" style="border-radius: 20px"
                                            id="openModalBtn">{{ __('Сохранить') }}</button>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="delete-workstage" role="tabpanel"
                             aria-labelledby="delete-workstage-tab">
                            <div class="product-delete-workstage-body">
                                <form id='delete-stage-form' action="" method="POST">
                                    <label for="name">Выберите этап работы:</label>
                                    <select id="selectStage" class="nice-select wide border-bottom-0 rounded-0">
                                        @foreach($workStage as $elem)
                                            <option value="{{$elem['id']}}">{{$elem['name']}}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-custom-size lg-size btn-primary" style="border-radius: 20px"
                                            id="openModalBtn">{{ __('Удалить') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="parsing" role="tabpanel" aria-labelledby="parsing-tab-tab">
            <div class="parsing-settings-body">
                <div class="login-form">
                    <h2 class="text-lg font-medium text-gray-900">Редактирование частоты парсинга данных</h2>
                    <div class="tab-content product-tab-content">
                        <div class="tab-pane fade show active" id="add-priority" role="tabpanel"
                             aria-labelledby="add-parsing-tab">
                            <div class="product-add-parsing-time-body">
                                <form id='add-parsing-time-form' action="" method="POST">
                                    <label for="all-time">Укажите, с какой частотой необходимо обновлять данные по избранным тендерам:</label>
                                    <input type="number" id="all-time" name="all-time" min="0" max="23" style="width: 400px" placeholder="Например, 1" value="0">
                                    <label for="favourite-time">Укажите, с какой частотой необходимо обновлять данные по всем тендерам:</label>
                                    <input type="number" id="favourite-time" name="favourite-time" min="0" max="23" style="width: 400px" placeholder="Например, 3" value="0">
                                    <br>
                                    <button class="btn btn-custom-size lg-size btn-primary" style="border-radius: 20px"
                                            id="openModalBtn">{{ __('Сохранить') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </div>


    <script>
        var userId = {{Auth::id()}}; // Получаем ID пользователя
    </script>
    <script src="{{asset('js/parsingTimeAdd.js')}}" defer></script>
    <script src="{{asset('js/priorityAdd.js')}}" defer></script>
    <script src="{{asset('js/priorityDelete.js')}}" defer></script>
    <script src="{{asset('js/stageAdd.js')}}" defer></script>
    <script src="{{asset('js/stageDelete.js')}}" defer></script>
    <script src="{{asset('js/modalEditForm.js')}}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
