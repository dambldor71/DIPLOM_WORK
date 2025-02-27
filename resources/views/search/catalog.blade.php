@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use App\Models\Tender;

    $priority = DB::table('priority')->where('user_id', Auth::id())->select('id', 'name', 'color_code')->get()->toArray();
    $stage = DB::table('work_stage')->where('user_id', Auth::id())->select('id', 'name')->get()->toArray();
    $favArray = ['Приоритет' => ['id' => 'priority', 'value' => $priority], 'Этап работ' => ['id' => 'stage', 'value' => $stage]];
    $favTenders = DB::table('favourite_tenders')->pluck('tender_id')->toArray();
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
        </ul>
    </div>
    <div class="shop-area section-space-y-axis-100">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4 order-lg-1 order-2 pt-10 pt-lg-0">
                    <form action="{{$title === 'Избранное' ? route('favourite') : route('search')}}" method="GET">
                        <div class="widgets-searchbox widgets-area py-6 mb-9">
                            <input name='searchString' class="input-field" type="search" placeholder="Ключевое слово">
                            <button class="widgets-searchbox-btn" type="submit">
                                <i class="pe-7s-search"></i>
                            </button>
                        </div>
                        <div class="sidebar-area style-2">
{{--                            @dd($favArray)--}}
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
                            <div class="widgets-area widgets-filter mb-9">
                                <h2 class="widgets-title mb-5">Цена</h2>
                                <div class="widgets-item">
                                    <label for="min-price">Минимальная цена:</label>
                                    <input name="min-price" type="text" id="min-price" value="{{!empty($usedFilters) ? $usedFilters['min-price'] : 0}}">

                                    <label for="max-price">Максимальная цена:</label>
                                    <input name="max-price" type="text" id="max-price" value="{{!empty($usedFilters) ? $usedFilters['max-price'] : Tender::pluck('price')->max()}}">
                                </div>
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
                                                            <input name='{{$value['fid']}}' value='{{$value['cid']}}' class="input-checkbox" type="checkbox" id="color-selection-{{$value['fid']}}" checked>
                                                        @else
                                                            <input name='{{$value['fid']}}' value='{{$value['cid']}}' class="input-checkbox" type="checkbox" id="color-selection-{{$value['fid']}}">
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
                            <input class="btn btn-custom-size lg-size btn-primary" type="submit" value="Применить">
                        </div>
                    </form>
                </div>
                <div class="col-xl-9 col-lg-8 order-lg-2 order-1">
                    <div class="tab-content text-charcoal pt-8">
                        <div class="tab-pane fade" id="grid-view" role="tabpanel" aria-labelledby="grid-view-tab">
                            <div class="product-grid-view row">
                                <div class="col-lg-4">
                                    <div class="product-item">
                                        <div class="product-img img-zoom-effect">
                                            <a href="single-product-variable.html">
                                                <img class="img-full" src="assets/images/product/medium-size/shop/1-1-290x350.jpg" alt="Product Images">
                                            </a>
                                        </div>
                                        <div class="product-content">
                                            <a class="product-name pb-1" href="single-product-variable.html">Auto Clutch & Brake</a>
                                            <div class="price-box">
                                                <div class="price-box-holder">
                                                    <span>Price:</span>
                                                    <span class="new-price text-primary">$120.00</span>
                                                </div>
                                            </div>
                                            <div class="product-add-action">
                                                <ul>
                                                    <li>
                                                        <a href="cart.html" data-tippy="Add to cart" data-tippy-inertia="true" data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder">
                                                            <i class="pe-7s-cart"></i>
                                                        </a>
                                                    </li>
                                                    <li class="quuickview-btn" data-bs-toggle="modal" data-bs-target="#quickModal">
                                                        <a href="#" data-tippy="Quickview" data-tippy-inertia="true" data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder">
                                                            <i class="pe-7s-look"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="list-view" role="tabpanel" aria-labelledby="list-view-tab">
                            <div class="product-list-view with-sidebar row">
                                    @foreach($tenderInfo as $oneTender)
                                    <div class="col-12">
                                        <div class="product-list-item">
                                            <div class="product-list-content">
                                                <a class="product-name pb-2" href="{{route('tender', $oneTender['id'])}}">{{$oneTender['tender_code']}}</a>
                                                <div class="price-box pb-1">
                                                    <span class="new-price" style="color: #2F4C73">{{$oneTender['price']}} ₽</span>
                                                </div>
                                                <div>{{$oneTender['description']}}</div>
                                                <p class="short-desc mb-0" style="color: #2F4C73">{{$oneTender['customer']}}</p>
                                            </div>
                                            <ul class="dropdown d-none d-lg-block">
                                                @if($title === 'Избранное')
                                                    <button class="btn btn-link dropdown-toggle ht-btn p-0"  style="color: white; background: {{$oneTender['color_code']}};text-align: center; margin-top: 12px" type="button" id="settingButton" data-bs-toggle="dropdown" aria-label="setting" aria-expanded="false">
                                                        {{$oneTender['name']}}
                                                    </button>
                                                @else
                                                    <button style="font-size: 20px; color: #2F4C73; margin-top: 12px" class="btn btn-link dropdown-toggle ht-btn p-0" type="button" id="settingButton" data-bs-toggle="dropdown" aria-label="setting" aria-expanded="false">
                                                        <img src="myPublic/assets/images/favAdd/{{in_array($oneTender['id'], $favTenders) ? "add2" : "not-add2"}}.png" alt="q">
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
                                                    <button class="btn btn-link dropdown-toggle ht-btn p-0"  style="color: white; background: #2F4C73;text-align: center; margin-top: 12px" type="button" id="stageButton" data-bs-toggle="dropdown" aria-label="setting" aria-expanded="false">
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
                                            </ul>
                                            @if($title === 'Избранное')
                                                <span class="close-button position-absolute end-X" id="{{$oneTender['id']}}" title="Удалить из избранного">&times;</span>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="pagination-area pt-10">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end">
                                @if($links >= 1)
                                    @foreach($tenderInfo->links()->elements as $element)
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
