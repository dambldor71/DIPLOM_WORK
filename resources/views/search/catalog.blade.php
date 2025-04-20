@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use App\Models\Tender;

    $priority = DB::table('priority')->where('user_id', Auth::id())->select('id', 'name', 'color_code')->get()->toArray();
    $stage = DB::table('work_stage')->where('user_id', Auth::id())->select('id', 'name')->get()->toArray();
    $favArray = ['Приоритет' => ['id' => 'priority', 'value' => $priority], 'Этап работ' => ['id' => 'stage', 'value' => $stage]];
    $favTenders = DB::table('favourite_tenders')->where('user_id', Auth::id())->pluck('tender_id')->toArray();
@endphp
@extends('header')

@section('content')
{{--    @dd($stage);--}}
    <div class="breadcrumb-area breadcrumb-height" data-bg-image="{{ asset('myPublic/assets/images/background-img/1920400.png')}}">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-12">
                    <div class="breadcrumb-item text-night-rider">
                        <h2 class="breadcrumb-heading">{{$title}}</h2>
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
    <div class="col-lg-12">
        <div>
            <h3 style="margin-left: 350px; margin-top: 50px; color: #1f2226">{{$allTendersNum}}</h3>
        </div>
    </div>
    <div>
        <ul class="widgets-tags" style="margin-left: 345px; margin-top: 25px; color: #2F4C73">
            @foreach($usedFilters as $uFilter)
                <li>
                    <a>{{$uFilter}}</a>
                </li>
            @endforeach
            @if(count($usedFilters))
                <li>
                    <a href="{{route($title === 'Избранное' ? 'favourite' : 'search')}}">Сбросить фильтры ✕</a>
                </li>
            @endif
        </ul>
    </div>
    <div class="shop-area section-space-y-axis-100">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4 order-lg-1 order-2 pt-10 pt-lg-0">
                    <form action="{{$title === 'Избранное' ? route('favourite') : route('search')}}" method="GET">
                        <div class="widgets-searchbox widgets-area py-6 mb-9">
                            <input name='searchString' class="input-field" type="search" placeholder="Ключевое слово"
                            @if(in_array('searchString', array_keys($usedFilters)))
                                value="{{$usedFilters['searchString']}}"
                            @endif
                            >
                            <button class="widgets-searchbox-btn" type="submit">
                                <i class="pe-7s-search"></i>
                            </button>
                        </div>
                        <div class="sidebar-area style-2">
                            @if($title === 'Избранное')
                                @foreach($favArray as $key => $cat)
                                    <div class="widgets-area mb-9">
                                        <h2 class="widgets-title mb-5">{{$key}}</h2>
                                        <div class="widget-item">
                                            <label class="label-checkbox mb-0" for="{{$cat['id']}}"></label>
                                            <select id='{{$cat['id']}}' name='{{$cat['id']}}' class="nice-select wide border-bottom-0 rounded-0">
                                                <option value="all">Любой</option>
                                                @foreach($cat['value'] as $elem)
                                                    @if(in_array($elem->name, $usedFilters) === true)
                                                        <option value="{{$elem->id}}" selected>{{$elem->name}}</option>
                                                    @else
                                                        <option value="{{$elem->id}}">{{$elem->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
{{--                            @dd($usedFilters)--}}
                            <div class="widgets-area widgets-filter mb-9">
                                <h2 class="widgets-title mb-5">Цена</h2>
                                <div class="widgets-item">
                                    <label for="min-price">Минимальная цена:</label>
                                    <input class="form-control" name="min-price" type="text" id="min-price" value="{{in_array('min-price', array_keys($usedFilters)) ? $usedFilters['min-price'] : 0}}">
                                    <label for="max-price">Максимальная цена:</label>
                                    <input class="form-control" name="max-price" type="text" id="max-price" value="{{in_array('max-price', array_keys($usedFilters)) ? $usedFilters['max-price'] : Tender::pluck('price')->max()}}">
                                </div>
                            </div>
                            <div class="widgets-area widgets-filter mb-9">
                                <h2 class="widgets-title mb-5">Дата</h2>
                                <label style="color: #0b0b0b">Размещение:</label>
                                <div style="display: grid; grid-template-columns: auto 1fr auto 1fr; gap: 10px;">
                                    <span>От:</span>
                                    <input type="date" id="stDate1" name="stDate1" class="form-control">
                                </div>
                                <div style="display: grid; grid-template-columns: auto 1fr auto 1fr; gap: 10px;">
                                    <span>До:</span>
                                    <input type="date" id="stDate2" name="stDate2" class="form-control">
                                </div>
                                <br>

                                <label style="color: #0b0b0b">Окончание:</label>
                                <div style="display: grid; grid-template-columns: auto 1fr auto 1fr; gap: 10px;">
                                    <span>От:</span>
                                    <input type="date" id="finDate1" name="finDate1" class="form-control">
                                </div>
                                <div style="display: grid; grid-template-columns: auto 1fr auto 1fr; gap: 10px;">
                                    <span>До:</span>
                                    <input type="date" id="finDate2" name="finDate2" class="form-control">
                                </div>
{{--                                <div class="widgets-item">--}}
{{--                                    <label>Размещение:</label>--}}
{{--                                    --}}{{--НУЖНО В ОДНУ СТРОКУ--}}
{{--                                    <span style="display: inline-block; margin-right: 5px;">От:</span>--}}
{{--                                    <input type="date" id="stDate1" name="stDate1" class="form-control" style="display: inline-block;">--}}
{{--                                    До: <input type="date" id="stDate2" name="stDate2" class="form-control"><br>--}}
{{--                                    <label>Окончание:</label>--}}
{{--                                    От: <input type="date" id="finDate1" name="finDate1" class="form-control">--}}
{{--                                    До: <input type="date" id="finDate2" name="finDate2" class="form-control">--}}
{{--                                </div>--}}
                            </div>
                            @foreach($categories as $category)
                                <div class="widgets-area mb-9">
                                    <h2 class="widgets-title mb-5">{{$category['name']}}</h2>
                                    <div class="widgets-item">
                                        <ul class="widgets-checkbox">
                                            @foreach($filters as $value)
                                                {{--                                            @dd($value)--}}
                                                @if($value['cid'] === $category['cid'])
                                                    <li>
                                                        @if(in_array($value['name'], $usedFilters) === true)
                                                            <input name='{{$value['fid']}}f' value='{{$value['cid']}}' class="input-checkbox" type="checkbox" id="color-selection-{{$value['fid']}}" checked>
                                                        @else
                                                            <input name='{{$value['fid']}}f' value='{{$value['cid']}}' class="input-checkbox" type="checkbox" id="color-selection-{{$value['fid']}}">
                                                        @endif
                                                        <label class="label-checkbox mb-0" for="color-selection-{{$value['fid']}}">{{$value['name']}}
                                                        </label>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="button-wrap">
                            <input class="btn btn-custom-size lg-size btn-primary" style="border-radius: 20px" type="submit" value="Применить">
                        </div>
                    </form>
                </div>
                <div class="col-xl-9 col-lg-8 order-lg-2 order-1">
                    <div class="product-topbar">
                        <ul>
                            <li class="short">
                                <select class="nice-select rounded-0">
                                    <option value="1">Сортировка по умолчанию</option>
                                    <option value="2">По возрастанию цены</option>
                                    <option value="3">По убыванию цены</option>
                                    <option value="4">По дате окончания</option>
                                    <option value="5">По номеру тендера</option>
                                </select>
                            </li>
                            @if($title === 'Избранное')
                                <li class="product-view-wrap">
                                    <ul class="nav" role="tablist">
                                        <li class="grid-view" role="presentation">
                                            <a id="grid-view-tab" data-bs-toggle="tab" href="#list-view" role="tab" aria-selected="true">
                                                Мои тендеры
                                            </a>
                                        </li>
                                        <li class="list-view" role="presentation">
                                            <a class="active" id="list-view-tab" data-bs-toggle="tab" href="#grid-view" role="tab" aria-selected="true">
                                                На рассмотрении
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <button class="btn btn-custom-size lg-size btn-primary" style="border-radius: 20px; font-size: 12px" id="openUnloadBtn">Выполнить выгрузку</button>

                                    <div id="unloadModal" class="modal">
                                        <div class="modal-content">
                                            <h2>Формат выгрузки</h2>
                                            <form action="{{route('export')}}" id="unloadForm" method="GET">
                                                <div class="tab-pane fade show active">
                                                    <label for="file-name">Введите название файла:</label>
                                                    <input type="text" placeholder="test" value="Отчёт по избранным тендерам на {{date('d.m.Y')}}" id="file-name" name="file-name" class="form-control"><br>
                                                    <label class="label-checkbox mb-0" for="unload-type">Выберите формат выгрузки:</label>
                                                    <select id='kinds' name='kinds' class="nice-select wide border-bottom-0 rounded-0">
                                                        <option value="all">Все тендеры в Избранном</option>
                                                        <option value="only-my">Только Мои тендеры</option>
                                                        <option value="only-watch">Только тендеры На рассмотрении</option>
                                                    </select>
                                                    <br><br><br><br>
                                                    <label>Укажите поля для выгрузки:</label>
                                                    <div class="widgets-item">
                                                        <ul class="widgets-checkbox">
                                                            <li>
                                                                <input name='Код-тендера' value='tender_code' class="input-checkbox" type="checkbox" id="Код-тендера" checked>
                                                                <label class="label-checkbox mb-00" for="Код-тендера">Код тендера</label>
                                                                <input name='Цена' value='price' class="input-checkbox" type="checkbox" id="Цена" checked>
                                                                <label class="label-checkbox mb-00" for="Цена">Цена</label>
                                                                <input name='zakupki.gov' value='link' class="input-checkbox" type="checkbox" id="zakupki.gov">
                                                                <label class="label-checkbox mb-00" for="zakupki.gov">Ссылка zakupki.gov</label>
                                                                <input name='Описание' value='tenders.description' class="input-checkbox" type="checkbox" id="Описание" checked>
                                                                <label class="label-checkbox mb-00" for="Описание">Описание</label>
                                                                <input name='Заказчик' value='customer' class="input-checkbox" type="checkbox" id="Заказчик" checked>
                                                                <label class="label-checkbox mb-00" for="Заказчик">Заказчик</label>
                                                                <input name='Дата-размещения' value='start_date' class="input-checkbox" type="checkbox" id="Дата-размещения">
                                                                <label class="label-checkbox mb-00" for="Дата-размещения">Дата размещения</label>
                                                                <input name='Дата-обновления' value='update_date' class="input-checkbox" type="checkbox" id="Дата-обновления">
                                                                <label class="label-checkbox mb-00" for="Дата-обновления">Дата обновления</label>
                                                                <input name='Дата-завершения' value='end_date' class="input-checkbox" type="checkbox" id="Дата завершения">
                                                                <label class="label-checkbox mb-00" for="Дата завершения">Дата завершения</label>
                                                                <input name='Приоритет' value='p.name' class="input-checkbox" type="checkbox" id="Приоритет">
                                                                <label class="label-checkbox mb-00" for="Приоритет">Приоритет</label>
                                                                <input name='Этап' value='ws.name as stageName' class="input-checkbox" type="checkbox" id="Этап">
                                                                <label class="label-checkbox mb-00" for="Этап">Этап работ</label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <button class="btn btn-custom-size lg-size btn-primary" style="border-radius: 20px" id="openUnloadBtn">{{ __('Сохранить') }}</button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="tab-content text-charcoal pt-8">
                        <div class="tab-pane fade show active" id="grid-view" role="tabpanel" aria-labelledby="grid-view-tab">
                            <div class="product-list-view with-sidebar row">
                                @foreach($tenderInfo as $oneTender)
{{--                                    @dd($oneTender)--}}
                                    @if($oneTender['stageName'] === null)
                                        <div class="col-12">
                                            <div class="product-list-item">
                                                <div class="product-list-content">
                                                    <a class="product-name pb-2" style="display: inline-block" href="{{route(in_array($oneTender['id'], $favTenders) ? 'favourite-tender' : 'tender', $oneTender['id'])}}">{{$oneTender['tender_code']}}</a>
                                                    <p class="short-desc mb-0" style="display: inline-block; margin-left:10px; color: #2F4C73">{{$oneTender['law_name']}}</p>
                                                    <div class="price-box pb-1">
                                                        <span class="new-price" style="color: #2F4C73">{{$oneTender['price']}} ₽</span>
                                                    </div>
                                                    <div>{{$oneTender['description']}}</div>
                                                    <p class="short-desc mb-0" style="color: #2F4C73">{{$oneTender['customer']}}</p>
                                                </div>
                                                <ul class="dropdown d-none d-lg-block" style="margin-left:75px">
                                                    @if($title === 'Избранное')
                                                        <button class="btn btn-link dropdown-toggle ht-btn p-0"  style="color: white; background: {{$oneTender['color_code']}};text-align: center; margin-top: 5px" type="button" id="settingButton" data-bs-toggle="dropdown" aria-label="setting" aria-expanded="false">
                                                            {{$oneTender['name']}}
                                                        </button>
                                                    @else
                                                        <button style="font-size: 20px; color: #2F4C73; margin-top: 5px" class="btn btn-link dropdown-toggle ht-btn p-0" type="button" id="settingButton" data-bs-toggle="dropdown" aria-label="setting" aria-expanded="false">
                                                            <img src="myPublic/assets/images/favAdd/{{in_array($oneTender['id'], $favTenders) ? "addZap2" : "addZap1"}}.png" alt="q" title="">
                                                        </button>
                                                    @endif
                                                    <li class="dropdown-menu dropdown-menu-end" id="{{$oneTender->id}}" aria-labelledby="settingButton">
                                                        @foreach($priority as $element)
                                                            <button id='{{$element->id}}' class="btn tender-status" style="color: white; background: {{$element->color_code}};text-align: center">
                                                                {{$element->name}}
                                                            </button>
                                                        @endforeach
                                                    </li>
                                                    {{--                                                    @dd($oneTender)--}}
                                                    <br>
                                                    @if($title === 'Избранное')
                                                        <button class="btn btn-link dropdown-toggle ht-btn p-0"  style="color: white; background: #2F4C73;text-align: center; margin-top: 5px" type="button" id="stageButton" data-bs-toggle="dropdown" aria-label="setting" aria-expanded="false">
                                                            {{$oneTender['stageName'] !== null ? $oneTender['stageName'] : 'Этап не выбран'}}
                                                        </button>
                                                        <li class="dropdown-menu dropdown-menu-end" id="{{$oneTender->id}}" aria-labelledby="stageButton">
                                                            @foreach($stage as $element)
                                                                <button id='{{$element->id}}' class="btn tender-stage">
                                                                    {{$element->name}}
                                                                </button>
                                                            @endforeach
                                                        </li>
                                                    @endif
                                                    <br><br>
                                                    <p class="short-desc mb-0" style="margin-top: 30px; color: #2F4C73">{{$oneTender['start_date'] . ' - ' . $oneTender['end_date']}}</p>
                                                    <p class="short-desc mb-0" style="display: inline-block; margin-top: 10px; color: #2F4C73">{{$oneTender['purchase_stage']}}</p>
                                                    @if(!str_contains($oneTender['difference'], '-') && !str_contains($oneTender['difference'], '00:00:00'))
                                                        @if ((int) explode(' ', $oneTender['difference'])[0] >= 7)
                                                            <p class="short-desc mb-0" style="display: inline-block; margin-left:25px; color: green">{{explode(' ', $oneTender['difference'])[0]}} дней</p>
                                                        @elseif((int) explode(' ', $oneTender['difference'])[0] > 3)
                                                            <p class="short-desc mb-0" style="display: inline-block; margin-left:25px; color: orangered">{{explode(' ', $oneTender['difference'])[0]}} дней</p>
                                                        @else
                                                            <p class="short-desc mb-0" style="display: inline-block; margin-left:25px; color: darkred">{{explode(' ', $oneTender['difference'])[0]}} дней</p>
                                                        @endif
                                                    @endif
                                                    <br><br>
                                                </ul>
                                                @if($title === 'Избранное')
                                                    <span class="close-button position-absolute end-X" id="{{$oneTender['id']}}" title="Удалить из избранного">&times;</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="list-view" role="tabpanel" aria-labelledby="list-view-tab">
                            <div class="product-list-view with-sidebar row">
                                    @foreach($tenderInfo as $oneTender)
{{--                                        @dd($tenderInfo)--}}
                                        @if($oneTender['stageName'] !== null)
                                            <div class="col-12">
                                                <div class="product-list-item">
                                                    <div class="product-list-content">
                                                        <a class="product-name pb-2" style="display: inline-block" href="{{route(in_array($oneTender['id'], $favTenders) ? 'favourite-tender' : 'tender', $oneTender['id'])}}">{{$oneTender['tender_code']}}</a>
                                                        <p class="short-desc mb-0" style="display: inline-block; margin-left:25px; color: #2F4C73">{{$oneTender['law_name']}}</p>
                                                        <div class="price-box pb-1">
                                                            <span class="new-price" style="color: #2F4C73">{{$oneTender['price']}} ₽</span>
                                                        </div>
                                                        <div>{{$oneTender['description']}}</div>
                                                        <p class="short-desc mb-0" style="color: #2F4C73">{{$oneTender['customer']}}</p>
                                                    </div>
                                                    <ul class="dropdown d-none d-lg-block" style="margin-left:75px">
                                                        @if($title === 'Избранное')
                                                            <button class="btn btn-link dropdown-toggle ht-btn p-0"  style="color: white; background: {{$oneTender['color_code']}};text-align: center; margin-top: 5px" type="button" id="settingButton" data-bs-toggle="dropdown" aria-label="setting" aria-expanded="false">
                                                                {{$oneTender['name']}}
                                                            </button>
                                                        @else
                                                            <button style="font-size: 20px; color: #2F4C73; margin-top: 5px" class="btn btn-link dropdown-toggle ht-btn p-0" type="button" id="settingButton" data-bs-toggle="dropdown" aria-label="setting" aria-expanded="false">
                                                                <img src="myPublic/assets/images/favAdd/{{in_array($oneTender['id'], $favTenders) ? "addZap2" : "addZap1"}}.png" alt="q"  title="{{$oneTender['priority']}}">
                                                            </button>
                                                        @endif
                                                        <li class="dropdown-menu dropdown-menu-end" id="{{$oneTender->id}}" aria-labelledby="settingButton">
                                                            @foreach($priority as $element)
                                                                <button id='{{$element->id}}' class="btn tender-status" style="color: white; background: {{$element->color_code}};text-align: center">
                                                                    {{$element->name}}
                                                                </button>
                                                            @endforeach
                                                        </li>
                                                        <br>
                                                        @if($title === 'Избранное')
                                                            <button class="btn btn-link dropdown-toggle ht-btn p-0"  style="color: white; background: #2F4C73;text-align: center; margin-top: 5px" type="button" id="stageButton" data-bs-toggle="dropdown" aria-label="setting" aria-expanded="false">
                                                                {{$oneTender['stageName'] !== null ? $oneTender['stageName'] : 'Этап не выбран'}}
                                                            </button>
                                                            <li class="dropdown-menu dropdown-menu-end" id="{{$oneTender->id}}" aria-labelledby="stageButton">
                                                                @foreach($stage as $element)
                                                                    <button id='{{$element->id}}' class="btn tender-stage">
                                                                        {{$element->name}}
                                                                    </button>
                                                                @endforeach
                                                            </li>
                                                        @endif
                                                        <p class="short-desc mb-0" style="margin-top: 30px; color: #2F4C73">{{$oneTender['start_date'] . ' - ' . $oneTender['end_date']}}</p>
                                                        <p class="short-desc mb-0" style="display: inline-block; margin-top: 10px; color: #2F4C73">{{$oneTender['purchase_stage']}}</p>
                                                        @if(!str_contains($oneTender['difference'], '-') && !str_contains($oneTender['difference'], '00:00:00'))
                                                            @if ((int) explode(' ', $oneTender['difference'])[0] >= 7)
                                                                <p class="short-desc mb-0" style="display: inline-block; margin-left:25px; color: green">{{explode(' ', $oneTender['difference'])[0]}} дней</p>
                                                            @elseif((int) explode(' ', $oneTender['difference'])[0] > 3)
                                                                <p class="short-desc mb-0" style="display: inline-block; margin-left:25px; color: orangered">{{explode(' ', $oneTender['difference'])[0]}} дней</p>
                                                            @else
                                                                <p class="short-desc mb-0" style="display: inline-block; margin-left:25px; color: darkred">{{explode(' ', $oneTender['difference'])[0]}} дней</p>
                                                            @endif
                                                        @endif
                                                        <br><br>
                                                    </ul>
                                                    @if($title === 'Избранное')
                                                        <span class="close-button position-absolute end-X" id="{{$oneTender['id']}}" title="Удалить из избранного">&times;</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="pagination-area pt-10">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end">
                                @if($links >= 1)
                                    @foreach($tenderInfo->links()->elements as $element)
{{--                                        @dd($tenderInfo->links()->elements)--}}
                                        @if($element === '...')
                                            <li class="page-item active" style="vertical-align: bottom">...</li>
                                        @else
                                            @foreach($element as $elem)
                                                <li class="page-item active"><a class="page-link" href="{{$elem}}">{{array_search($elem, $element)}}</a></li>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </div>

    <script>
        var userId = {{Auth::id()}};
    </script>
    <script src="{{asset('js/updateFavouriteTender.js')}}" defer></script>
    <script src="{{asset('js/deleteFavouriteTender.js')}}" defer></script>
    <script src="{{asset('js/modalUnloadForm.js')}}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
