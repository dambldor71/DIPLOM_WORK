@extends('header')

@section('content')
    <div class="breadcrumb-area breadcrumb-height"
         data-bg-image="{{asset('myPublic/assets/images/background-img/1920400.png')}}">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-12">
                    <div class="breadcrumb-item text-night-rider">
                        <h2 class="breadcrumb-heading">Подробная информация о тендере</h2>
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
    {{--    @dd($oneTenderInfo)--}}
    <div class="single-product-area section-space-top-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 pt-9 pt-lg-0">
                    <div class="single-product-content">
                        <h2 class="title mb-3">ТЕНДЕР {{$oneTenderInfo['tender_code']}}</h2>
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
                                    <a href="#">{{$oneTenderInfo['end_date']}}</a>
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
                    </div>
                </div>
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
                                Документы
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content product-tab-content">
                        <div class="tab-pane fade show active" id="information" role="tabpanel" aria-labelledby="information-tab">
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
                                <a class="short-desc mb-0" href="{{$oneTenderInfo['link']}}">Кликните, чтобы перейти</a>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="description" role="tabpanel"
                             aria-labelledby="description-tab">
                            <div class="product-description-body">
                                <p class="short-desc mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                                    do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                                    veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                                    dolore eu fugiat nulla pariatur. Excepteur sintdjrufoksk occaecat cupidatat non
                                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut
                                    perspiciatis unde omnis iste natus error sit voluptatem accusantium dolorem
                                    laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi
                                    architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia
                                    voluptas sitdu aspernatur aut odit aut fugit, sed quia consequuntur magni dolores
                                    eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem
                                    ipsum quia dolor sit ametg consectetur, adipisci velit, sed quia non numquam eius
                                    modi tempora incidun.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
