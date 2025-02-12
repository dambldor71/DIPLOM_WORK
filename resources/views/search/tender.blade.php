@extends('header')

@section('content')
    <div class="breadcrumb-area breadcrumb-height" data-bg-image="{{ asset('myPublic/assets/images/background-img/1920400.png')}}">
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
    <div class="single-product-area section-space-top-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 pt-9 pt-lg-0">
                    <div class="single-product-content">
                        <h2 class="title mb-3">ТЕНДЕР {{$oneTenderInfo['code']}}</h2>
                        <div class="price-box pb-3">
                            <span class="new-price text-danger">{{$oneTenderInfo['price']}}</span>
                        </div>
                        <p class="short-desc mb-3">ОПИСАНИЕ ТЕНДЕРА</p>
{{--                        <ul class="quantity-with-btn pb-7">--}}
{{--                            <li class="affiliate-btn-wrap">--}}
{{--                                <a class="btn btn-custom-size lg-size btn-primary" href="#">Buy Now</a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
                        <div class="product-category pb-3">
                            <span class="title">Организация, осуществляющая размещение:</span>
                            <ul>
                                <li>
                                    {{$oneTenderInfo['author']}}
                                </li>
                            </ul>
                        </div>
                        <div class="product-category product-tags pb-3">
                            <span class="title">Размещено:</span>
                            <ul>
                                <li>
                                    <a href="#">{{$oneTenderInfo['dates'][0]}}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="product-category product-tags pb-3">
                            <span class="title">Окончание подачи заявок:</span>
                            <ul>
                                <li>
                                    <a href="#">{{$oneTenderInfo['dates'][2]}}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="product-category product-tags pb-3">
                            <span class="title">Последнее обновление данных:</span>
                            <ul>
                                <li>
                                    <a href="#">{{$oneTenderInfo['dates'][1]}}</a>
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
                            <a class="tab-btn" id="information-tab" data-bs-toggle="tab" href="#information" role="tab" aria-controls="information" aria-selected="false">
                                Информация о закупке
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="active tab-btn" id="description-tab" data-bs-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">
                                Документы
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content product-tab-content">
                        <div class="tab-pane fade" id="information" role="tabpanel" aria-labelledby="information-tab">
                            <div class="product-information-body">
                                <h4 class="title">Способ определения поставщика (подрядчика, исполнителя)</h4>

                                <p class="short-desc mb-4">{{$oneTenderInfo['lawType'][1]}}</p>
                                <h4 class="title">Адрес электронной площадки в информационно-телекоммуникационной сети «Интернет»</h4>
                                <a class="short-desc mb-4" href="{{$oneTenderInfo['placeName']}}">{{$oneTenderInfo['placeName']}}</a>
                                <h4 class="title">Заказчик</h4>
                                <a class="short-desc mb-4" href="{{$oneTenderInfo['authorLink']}}">{{$oneTenderInfo['author']}}</a>
                                <h4 class="title">Этап закупки</h4>
                                <p class="short-desc mb-0">{{$oneTenderInfo['status']}}</p>
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                            <div class="product-description-body">
                                <p class="short-desc mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sintdjrufoksk occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium dolorem laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sitdu aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit ametg consectetur, adipisci velit, sed quia non numquam eius modi tempora incidun.</p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                            <div class="product-review-body">
                                <div class="blog-comment">
                                    <h4 class="heading mb-7">3 Comments</h4>
                                    <div class="blog-comment-item mb-8">
                                        <div class="blog-comment-img">
                                            <img src="assets/images/blog/avatar/3-1-101x101.png" alt="User Image">
                                        </div>
                                        <div class="blog-comment-content pb-8">
                                            <div class="user-meta">
                                                <span><strong>Aidyn Cody -</strong> Jul 21,2021 at 15 hours ago</span>
                                            </div>
                                            <p class="user-comment mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor inci labore et dol magna aliqua. Ut enim ad minim veniam quis nostrud</p>
                                            <a class="btn btn-custom-size comment-btn" href="#">Reply</a>
                                        </div>
                                    </div>
                                    <div class="blog-comment-item relpy-item mb-8">
                                        <div class="blog-comment-img">
                                            <img src="assets/images/blog/avatar/3-2-101x101.png" alt="User Image">
                                        </div>
                                        <div class="blog-comment-content pb-8">
                                            <div class="user-meta">
                                                <span><strong>Aidyn Cody -</strong> Jul 21,2021 at 15 hours ago</span>
                                            </div>
                                            <p class="user-comment mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor inci labore et dol magna aliqua. Ut enim ad minim veniam quis nostrud</p>
                                            <a class="btn btn-custom-size comment-btn" href="#">Reply</a>
                                        </div>
                                    </div>
                                    <div class="blog-comment-item">
                                        <div class="blog-comment-img">
                                            <img src="assets/images/blog/avatar/3-3-101x101.png" alt="User Image">
                                        </div>
                                        <div class="blog-comment-content">
                                            <div class="user-meta">
                                                <span><strong>Aidyn Cody -</strong> Jul 21,2021 at 15 hours ago</span>
                                            </div>
                                            <p class="user-comment mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor inci labore et dol magna aliqua. Ut enim ad minim veniam quis nostrud</p>
                                            <a class="btn btn-custom-size comment-btn" href="#">Reply</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="feedback-area pt-10">
                                    <h2 class="heading mb-3">Add a review</h2>
                                    <p class="short-desc mb-3">Your email address will not be published.</p>
                                    <div class="rating-box">
                                        <span>Your rating</span>
                                        <ul class="ps-4">
                                            <li><i class="fa fa-star" data-tippy="1 star" data-tippy-inertia="true" data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder"></i></li>
                                            <li><i class="fa fa-star" data-tippy="2 star" data-tippy-inertia="true" data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder"></i></li>
                                            <li><i class="fa fa-star" data-tippy="3 star" data-tippy-inertia="true" data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder"></i></li>
                                            <li><i class="fa fa-star" data-tippy="4 star" data-tippy-inertia="true" data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder"></i></li>
                                            <li><i class="fa fa-star" data-tippy="5 star" data-tippy-inertia="true" data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder"></i></li>
                                        </ul>
                                    </div>
                                    <form class="feedback-form pt-8" action="#">
                                        <div class="group-input">
                                            <div class="form-field me-md-6 mb-6 mb-md-0">
                                                <input type="text" name="name" placeholder="Your Name*" class="input-field">
                                            </div>
                                            <div class="form-field me-md-6 mb-6 mb-md-0">
                                                <input type="text" name="email" placeholder="Your Email*" class="input-field">
                                            </div>
                                            <div class="form-field">
                                                <input type="text" name="number" placeholder="Phone number" class="input-field">
                                            </div>
                                        </div>
                                        <div class="form-field mt-6">
                                            <textarea name="message" placeholder="Message" class="textarea-field"></textarea>
                                        </div>
                                        <div class="button-wrap mt-8">
                                            <button type="submit" value="submit" class="btn btn-custom-size lg-size btn-primary" name="submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="background-img" data-bg-image="assets/images/background-img/1-2-1920x716.jpg">
        <div class="product-area product-arrow section-space-y-axis-100">
            <div class="container">
                <div class="section-title pb-55">
                    <h2 class="title mb-0">Related Products</h2>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="swiper-container product-slider">
                            <div class="swiper-wrapper text-heading">
                                <div class="swiper-slide">
                                    <div class="product-item">
                                        <div class="product-img img-zoom-effect">
                                            <a href="shop.html">
                                                <img class="img-full" src="assets/images/product/medium-size/product-slider/1-1-290x350.jpg" alt="Product Images">
                                            </a>
                                        </div>
                                        <div class="product-content">
                                            <a class="product-name pb-1" href="shop.html">Auto Clutch & Brake</a>
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
                                                    <li>
                                                        <a href="wishlist.html" data-tippy="Add to wishlist" data-tippy-inertia="true" data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder">
                                                            <i class="pe-7s-like"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="compare.html" data-tippy="Add to compare" data-tippy-inertia="true" data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder">
                                                            <i class="pe-7s-shuffle"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="product-item">
                                        <div class="product-img img-zoom-effect">
                                            <a href="shop.html">
                                                <img class="img-full" src="assets/images/product/medium-size/product-slider/1-2-290x350.jpg" alt="Product Images">
                                            </a>
                                        </div>
                                        <div class="product-content">
                                            <a class="product-name pb-1" href="shop.html">Fuel Injector</a>
                                            <div class="price-box">
                                                <div class="price-box-holder">
                                                    <span>Price:</span>
                                                    <span class="new-price text-primary">$130.00</span>
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
                                                    <li>
                                                        <a href="wishlist.html" data-tippy="Add to wishlist" data-tippy-inertia="true" data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder">
                                                            <i class="pe-7s-like"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="compare.html" data-tippy="Add to compare" data-tippy-inertia="true" data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder">
                                                            <i class="pe-7s-shuffle"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="product-item">
                                        <div class="product-img img-zoom-effect">
                                            <a href="shop.html">
                                                <img class="img-full" src="assets/images/product/medium-size/product-slider/1-3-290x350.jpg" alt="Product Images">
                                            </a>
                                        </div>
                                        <div class="product-content">
                                            <a class="product-name pb-1" href="shop.html">A/C Compressor</a>
                                            <div class="price-box">
                                                <div class="price-box-holder">
                                                    <span>Price:</span>
                                                    <span class="new-price text-primary">$150.00</span>
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
                                                    <li>
                                                        <a href="wishlist.html" data-tippy="Add to wishlist" data-tippy-inertia="true" data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder">
                                                            <i class="pe-7s-like"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="compare.html" data-tippy="Add to compare" data-tippy-inertia="true" data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder">
                                                            <i class="pe-7s-shuffle"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="product-item">
                                        <div class="product-img img-zoom-effect">
                                            <a href="shop.html">
                                                <img class="img-full" src="assets/images/product/medium-size/product-slider/1-4-290x350.jpg" alt="Product Images">
                                            </a>
                                        </div>
                                        <div class="product-content">
                                            <a class="product-name pb-1" href="shop.html">Shock Absorbers</a>
                                            <div class="price-box">
                                                <div class="price-box-holder">
                                                    <span>Price:</span>
                                                    <span class="new-price text-primary">$180.00</span>
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
                                                    <li>
                                                        <a href="wishlist.html" data-tippy="Add to wishlist" data-tippy-inertia="true" data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder">
                                                            <i class="pe-7s-like"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="compare.html" data-tippy="Add to compare" data-tippy-inertia="true" data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder">
                                                            <i class="pe-7s-shuffle"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Add Arrows -->
                        <div class="product-button-wrap pt-10">
                            <div class="product-button-prev">
                                <i class="pe-7s-angle-left"></i>
                            </div>
                            <div class="product-button-next">
                                <i class="pe-7s-angle-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
