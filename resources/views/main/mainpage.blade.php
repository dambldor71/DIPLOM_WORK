@extends('header')

@section('content')
    <div class="slider-area">
        <div class="swiper-container main-slider swiper-arrow with-bg_white">
            <div class="swiper-wrapper">
                <div class="swiper-slide animation-style-01">
                    <div class="slide-inner bg-height" data-bg-image="myPublic/assets/images/product/large-size/zaglushka.png">
                        <div class="container">
                            <div class="slide-content text-white">
                                <h3 class="sub-title">Быстрый поиск и управление на одном сайте</h3>
                                <h2 class="title mb-3">Pumori Tender</h2>
                                <p class="short-desc different-width mb-10">Подбирайте закупки и участвуйте в торгах надежных заказчиков</p>
                                <div class="button-wrap">
                                    <a class="btn btn-custom-size lg-size btn-primary" href='{{route('search')}}'>Поиск</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="background-img" data-bg-image="myPublic/assets/images/product/large-size/back.png">
        <div class="modal-search">
            <span class="searchbox-info">Начните поиск прямо сейчас</span>
            <form action="" class="hm-searchbox">
                <input type="text" name="searchString" placeholder="Ключевое слово, номер закупки, город" onblur="if(this.value==''){this.value='Ключевое слово, номер закупки, город'}" onfocus="if(this.value=='Ключевое слово, номер закупки, город'){this.value=''}">
                <button class="search-btn" type="submit" aria-label="searchbtn"><i class="pe-7s-search"></i></button>
            </form>
        </div>
    </div>
    <div class="background-img">
        <!-- Begin Shipping Area -->
        <div class="shipping-area section-space-y-axis-100">
            <div class="container">
                <div class="shipping-bg">
                    <div class="row shipping-wrap py-5 py-xl-0">
                        <div class="col-lg-4">
                            <div class="shipping-item">
                                <div class="shipping-img">
                                    <img src="{{ asset('myPublic/assets/images/shipping/icon/plane.png')}}" alt="Shipping Icon">
                                </div>
                                <div class="shipping-content">
                                    <h2 class="title">Работа 24/7</h2>
                                    <p class="short-desc mb-0">Используйте возможности сервиса 24/7</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 pt-4 pt-lg-0">
                            <div class="shipping-item">
                                <div class="shipping-img">
                                    <img src="{{ asset('myPublic/assets/images/shipping/icon/earphones.png')}}" alt="Shipping Icon">
                                </div>
                                <div class="shipping-content">
                                    <h2 class="title">Скорость поиска</h2>
                                    <p class="short-desc mb-0">Для быстрого поиска тендера данные берутся с прямых источников</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 pt-4 pt-lg-0">
                            <div class="shipping-item">
                                <div class="shipping-img">
                                    <img src="{{ asset('myPublic/assets/images/shipping/icon/shield.png')}}" alt="Shipping Icon">
                                </div>
                                <div class="shipping-content">
                                    <h2 class="title">Безопасность данных</h2>
                                    <p class="short-desc mb-0">Ваши данные находятся под надежной защитой</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
