@extends('header')

@section('content')
    <div class="breadcrumb-area breadcrumb-height" data-bg-image="{{ asset('myPublic/assets/images/background-img/1920400.png')}}">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-12">
                    <div class="breadcrumb-item text-night-rider">
                        <h2 class="breadcrumb-heading">ПОИСК ТЕНДЕРОВ</h2>
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
    <div class="shop-area section-space-y-axis-100">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4 order-lg-1 order-2 pt-10 pt-lg-0">
                    <div class="sidebar-area style-2">
                        @foreach(DB::table('category_filters')->get() as $filter)
                            <div class="widgets-area mb-9">
                                <h2 class="widgets-title mb-5">{{$filter->name}}</h2>
                                <div class="widgets-item">
                                    <ul class="widgets-checkbox">
                                        @foreach(DB::table('tender_filters')->where('category_id', $filter->id)->get() as $value)
                                            <li>
                                                <input class="input-checkbox" type="checkbox" id="color-selection-{{$value->id}}">
                                                <label class="label-checkbox mb-0" for="color-selection-{{$value->id}}">{{$value->name}}
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8 order-lg-2 order-1">
                    <div class="widgets-searchbox widgets-area py-6 mb-9">
                        <form id="widgets-searchbox" action="#">
                            <input class="input-field" type="text" placeholder="Ключевое слово, номер закупки, город">
                            <button class="widgets-searchbox-btn" type="submit">
                                <i class="pe-7s-search"></i>
                            </button>
                        </form>
                    </div>
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
{{--                                                https://zakupki.gov.ru/epz/order/notice/ea20/view/common-info.html?regNumber={{trim((str_replace('№', '', $oneTender['code'])))}}--}}
{{--                                                <a class="product-name pb-2" href="{{route('tender', trim(str_replace('№', '', $oneTender['code'])))}}">{{$oneTender['code']}}</a>--}}
                                                <a class="product-name pb-2" href="{{route('tender', $oneTender['request'])}}">{{$oneTender['code']}}</a>
                                                <div class="price-box pb-1">
                                                    <span class="new-price">{{$oneTender['price']}}</span>
                                                </div>
                                                <p class="short-desc mb-0">{{$oneTender['author']}}</p>
                                            </div>
                                            <li class="dropdown d-none d-lg-block">
                                                <button class="btn btn-link dropdown-toggle ht-btn p-0" type="button" id="settingButton" data-bs-toggle="dropdown" aria-label="setting" aria-expanded="false">
                                                    Статус
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="settingButton">

                                                    @foreach(DB::table('status')->get() as $element)
                                                        <button class="btn tender-status" style="color: white; background: {{$element->color_code}};text-align: center">
                                                            {{$element->name}}
                                                        </button>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        </div>
                                    </div>
                                    @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="pagination-area pt-10">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">&laquo;</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">&raquo;</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{--@section('javascript')--}}
{{--    @parent--}}
{{--    <script>--}}
{{--        $(document).ready(function() {--}}
{{--            $('.but_tender').click(function() {--}}
{{--                console.log('Привет');--}}
{{--            });--}}
{{--        }--}}
{{--    </script>--}}
{{--@stop--}}
