@php
    use App\Models\TenderPotentialWinnerModel;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;

    $priority = DB::table('priority')->where('user_id', Auth::id())->select('id', 'name', 'color_code')->get()->toArray();
    $stage = DB::table('work_stage')->where('user_id', Auth::id())->select('id', 'name')->get()->toArray();
    $favArray = ['Приоритет' => ['id' => 'priority', 'value' => $priority], 'Этап работ' => ['id' => 'stage', 'value' => $stage]];
    $favTenders = DB::table('favourite_tenders')->pluck('tender_id', 'id')->toArray();

@endphp
@extends('header')

@section('content')
    <div class="breadcrumb-area breadcrumb-height"
         data-bg-image="{{asset('myPublic/assets/images/background-img/1920400.png')}}">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-12">
                    <div class="breadcrumb-item text-night-rider">
                        <h2 class="breadcrumb-heading">Подробная информация о тендере</h2>
                        @if($title !== '')
                            <h3 class="breadcrumb-heading">Избранное</h3>
                        @endif
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
    {{--        @dd($oneTenderInfo)--}}
    <div class="single-product-area section-space-top-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 pt-9 pt-lg-0">
                    <div class="single-product-content">
                        <h2 class="title mb-3" id="tender-code">{{$oneTenderInfo['tender_code']}}</h2>
                        <div class="price-box pb-3">
                            <span class="new-price text-danger">{{$oneTenderInfo['price']}} ₽</span>
                        </div>
                        <p class="short-desc mb-3">{{$oneTenderInfo['description']}}</p>
                        <div class="product-category pb-3">
                            <span class="title">Организация, осуществляющая размещение:</span>
                            <ul>
                                <li>
                                    {{$oneTenderInfo['customer']}}
                                </li>
                            </ul>
                        </div>
                        <div class="product-category product-tags pb-3">
                            <span class="title">Размещено:</span>
                            <ul>
                                <li>
                                    <a href="#">{{$oneTenderInfo['start_date']}}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="product-category product-tags pb-3">
                            <span class="title">Окончание подачи заявок:</span>
                            <ul>
                                <li>
                                    <a style="display: inline-block;" href="#">{{$oneTenderInfo['end_date']}}</a>
                                    @if(!str_contains($oneTenderInfo['difference'], '-') && !str_contains($oneTenderInfo['difference'], '00:00:00'))
                                        @if ((int) explode(' ', $oneTenderInfo['difference'])[0] > 7)
                                            <a style="display: inline-block; margin-left:25px; color: green">(осталось {{explode(' ', $oneTenderInfo['difference'])[0]}} дней)</a>
                                        @elseif((int) explode(' ', $oneTenderInfo['difference'])[0] > 4)
                                            <a style="display: inline-block; margin-left:25px; color: orangered">(осталось {{explode(' ', $oneTenderInfo['difference'])[0]}} дней)</a>
                                        @else
                                            <a style="display: inline-block; margin-left:25px; color: darkred">(осталось {{explode(' ', $oneTenderInfo['difference'])[0]}} дня)</a>
                                        @endif
                                    @endif
                                </li>
                            </ul>
                        </div>
                        <div class="product-category product-tags pb-3">
                            <span class="title">Последнее обновление данных:</span>
                            <ul>
                                <li>
                                    <a href="#">{{$oneTenderInfo['update_date']}}</a>
                                </li>
                            </ul>
                        </div>
{{--                        @dd($oneTenderInfo)--}}
                        <div class="product-category product-tags pb-3">
                            @if($oneTenderInfo['winner'] !== null)
                                <span class="title">Результаты проведения закупки:</span>
                                <ul>
                                    <li>
                                        <a style="color: #002F86" href="#">{{strlen($oneTenderInfo['winner']) < 20
                                           ? "ИДЕНТИФИКАЦИОННЫЙ НОМЕР ПОБЕДИТЕЛЯ - " . $oneTenderInfo['winner']
                                           : $oneTenderInfo['winner']}}</a>
                                    </li>
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <ul class="dropdown d-none d-lg-block position-absolute end-60">
                    {{--                    @dd($oneTenderInfo)--}}
                    {{--                    @dd($favTenders, $oneTenderInfo['id'])--}}
                    <p class="short-desc mb-0" style="font-size: 18px; margin-top: 10px; color: black">Актуально
                        на {{$oneTenderInfo['updating_at']}}</p>
                    <button style="font-size: 18px; color: black" class="btn btn-link ht-btn p-0" type="button"
                            id="updateTenderButton">
                        Обновить <img src="{{ asset('myPublic/assets/images/favAdd/updateButton.png')}}" alt="q"
                                      title="">
                    </button>
                    <br>
                    @if(in_array($oneTenderInfo['id'], $favTenders))
                        <button class="btn btn-link dropdown-toggle ht-btn p-0"
                                style="font-size: 24px; color: white; background: {{$oneTenderInfo['color_code']}};text-align: center; margin-top: 50px"
                                type="button" id="settingButton" data-bs-toggle="dropdown" aria-label="setting"
                                aria-expanded="false">
                            {{$oneTenderInfo['name']}}
                        </button>
                    @else
                        <button class="btn btn-link dropdown-toggle ht-btn p-0"
                                style="font-size: 24px; color: white; background: #2F4C73; text-align: center; margin-top: 50px"
                                type="button" id="settingButton" data-bs-toggle="dropdown" aria-label="setting"
                                aria-expanded="false">
                            Не в избранном
                        </button>
                    @endif
                    {{--                    @dd($priority)--}}
                    <li class="dropdown-menu dropdown-menu-end" id="{{$oneTenderInfo['id']}}"
                        aria-labelledby="settingButton">
                        @foreach($priority as $element)
                            <button id='{{$element->id}}' class="btn tender-status"
                                    style="color: white; background: {{$element->color_code}};text-align: center">
                                {{$element->name}}
                            </button>
                        @endforeach
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="product-tab-area section-space-y-axis-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="nav product-tab-nav mb-10" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="active tab-btn" id="information-tab" data-bs-toggle="tab" href="#information"
                               role="tab" aria-controls="information" aria-selected="true">
                                Информация о закупке
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="tab-btn" id="description-tab" data-bs-toggle="tab" href="#description"
                               role="tab" aria-controls="description" aria-selected="false">
                                Взаимодействие с тендером
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content product-tab-content">
                        <div class="tab-pane fade show active" id="information" role="tabpanel"
                             aria-labelledby="information-tab">
                            <div class="product-information-body">
                                <h4 class="title">Описание тендера</h4>
                                <p class="short-desc mb-4">{{$oneTenderInfo['description']}}</p>
                                <h4 class="title">Закон</h4>
                                <p class="short-desc mb-4">{{$tenderFilters[0]}}</p>
                                <h4 class="title">Способ определения поставщика (подрядчика, исполнителя)</h4>
                                <p class="short-desc mb-4">{{$tenderFilters[2]}}</p>
                                <h4 class="title">Адрес электронной площадки в информационно-телекоммуникационной сети
                                    «Интернет»</h4>
                                <a class="short-desc mb-4"
                                   href="{{$oneTenderInfo['source_link']}}">{{$oneTenderInfo['source_link']}}</a>
                                <h4 class="title">Заказчик</h4>
                                <a class="short-desc mb-4"
                                   href="{{$oneTenderInfo['customer']}}">{{$oneTenderInfo['customer']}}</a>
                                <h4 class="title">Этап закупки</h4>
                                <p class="short-desc mb-0">{{$tenderFilters[1]}}</p>
                                <h4 class="title">Ссылка на тендер на zakupki.gov</h4>
                                <a class="short-desc mb-0" href="{{$oneTenderInfo['link']}}" id="tenderLinkUpdate">Кликните,
                                    чтобы перейти</a>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="description" role="tabpanel"
                             aria-labelledby="description-tab">
                            <div class="product-description-body">
                                @if(in_array($oneTenderInfo['id'], $favTenders))
                                    <form style="margin-bottom: 15px" id='add-id-winner-to-tender' action="" method="POST">
                                        <div class="product-add-priority-body">
                                            @php($myId = DB::table('tender_potential_winner')
                                                     ->where('tender_id', array_search($oneTenderInfo['id'], $favTenders))
                                                     ->where('user_id', Auth::id())
                                                     ->pluck('potential_winner_id')
                                                     ->toArray())
                                                <div class="product-information-body">
                                                    <h4 style="color: #002F86" class="title">ID участника тендера:
                                                        {{$myId ? $myId[0] : 'номер не указан'}}</h4>
                                                </div>
                                                <br>
                                                <h4 class="title">Добавить/обновить индентификационный номер</h4>
                                                <input type="text" id="contest-id" name="contest-id" class="form-control"
                                                       placeholder="В случае одобрения Вашей заявки, укажите id участника">
                                                <br>
                                                <button class="btn btn-custom-size lg-size btn-primary"
                                                        style="border-radius: 20px"
                                                        id="openModalBtn">{{ __('Сохранить') }}</button>
                                        </div>
                                    </form>
                                @endif
                                <br><br>
                                <form style="margin-bottom: 15px" id='add-сomment-to-tender' action="" method="POST">
                                    <div class="product-add-priority-body">
                                        <h4 class="title">Добавить комментарий к тендеру</h4>
                                        <input type="text" id="comment" name="comment" class="form-control"
                                               placeholder="Укажите комментарий к тендеру">
                                        <br>
                                        <button class="btn btn-custom-size lg-size btn-primary"
                                                style="border-radius: 20px"
                                                id="openModalBtn">{{ __('Сохранить') }}</button>
                                    </div>
                                </form>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Дата</th>
                                        <th>Комментарии</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach(DB::table('tender_comments')
                                                ->where('tender_id', '=', $oneTenderInfo['id'])
                                                ->where('user_id', '=', Auth::id())
                                                ->select('updated_at', 'comment')
                                                ->get()
                                                ->toArray() as $comment)
                                        <tr>
                                            <td>{{$comment->updated_at}}</td>
                                            <td>{{$comment->comment}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--    @dd($oneTenderInfo)--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        var userId = {{Auth::id()}};
        var tenderId ={{$oneTenderInfo['id']}}
    </script>
    <script src="{{asset('js/updateFavouriteTender.js')}}" defer></script>
    <script src="{{asset('js/addContestId.js')}}" defer></script>
    <script src="{{asset('js/addTenderComment.js')}}" defer></script>
    <script src="{{asset('js/updateTenderInfo.js')}}" defer></script>
@endsection
