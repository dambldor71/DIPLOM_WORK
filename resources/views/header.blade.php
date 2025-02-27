@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use App\Models\Tender;

    $priority = DB::table('priority')->where('user_id', Auth::id())->select('id', 'name', 'color_code')->get()->toArray();
    $stage = DB::table('work_stage')->where('user_id', Auth::id())->select('id', 'name')->get()->toArray();
    $favArray = ['Приоритет' => ['id' => 'priority', 'value' => $priority], 'Этап работ' => ['id' => 'stage', 'value' => $stage]];
@endphp

    <!DOCTYPE html>
<html lang="zxx">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pumori Tender</title>
    <meta name="robots" content="index, follow"/>
    <meta name="description"
          content="Tromic car accessories bootstrap 5 template is an awesome website template for any modern car accessories shop.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('myPublic/assets/images/favicon.ico')}}"/>

    <!-- CSS
    ============================================ -->

    <!-- Vendor CSS (Contain Bootstrap, Icon Fonts) -->
    <link rel="stylesheet" href="{{ asset('myPublic/assets/css/vendor/font-awesome.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('myPublic/assets/css/vendor/Pe-icon-7-stroke.css')}}"/>

    <!-- Plugin CSS (Global Plugins Files) -->
    <link rel="stylesheet" href="{{ asset('myPublic/assets/css/plugins/animate.min.css')}}">
    <link rel="stylesheet" href="{{ asset('myPublic/assets/css/plugins/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{ asset('myPublic/assets/css/plugins/swiper-bundle.min.css')}}">
    <link rel="stylesheet" href="{{ asset('myPublic/assets/css/plugins/nice-select.css')}}">
    <link rel="stylesheet" href="{{ asset('myPublic/assets/css/plugins/magnific-popup.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('myPublic/assets/css/plugins/ion.rangeSlider.min.css')}}"/>

    <!-- Minify Version -->
    <!-- <link rel="stylesheet" href="assets/css/vendor/vendor.min.css"> -->
    <!-- <link rel="stylesheet" href="assets/css/plugins/plugins.min.css"> -->

    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('myPublic/assets/css/style.css')}}">
    <!-- <link rel="stylesheet" href="assets/css/style.min.css"> -->

</head>

<body>
<div class="preloader-activate preloader-active open_tm_preloader">
    <div class="preloader-area-wrap">
        <div class="spinner d-flex justify-content-center align-items-center h-100">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
</div>
<div class="main-wrapper">

    <!-- Begin Main Header Area -->
    <header class="main-header-area">
        <div class="header-middle header-sticky py-6 py-lg-0">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <div class="header-middle-wrap position-relative">
                            <a href="{{route('mainpage')}}" class="header-logo">
                                <img src="{{ asset('myPublic/assets/images/logo/smile.png')}}" alt="Header Logo">
                            </a>

                            @if (Route::has('login'))
                                @auth
                                    <div class="main-menu d-none d-lg-block">
                                        <nav class="main-nav">
                                            <ul>
                                                <li class="megamenu-holder">
                                                    <a href="{{route('test',  Auth::id())}}">Личный кабинет
                                                    </a>
                                                </li>
                                                <li class="megamenu-holder">
                                                    <a href="{{route('search')}}">Поиск тендеров
                                                        <i class="pe-7s-angle-down"></i>
                                                    </a>
                                                    <ul class="drop-menu megamenu">
                                                        @foreach($categories as $category)
                                                            @php
                                                                $num = 1
                                                            @endphp
                                                            <li>
                                                                <span class="title">{{$category['name']}}</span>
                                                                <ul>
                                                                    @foreach($filters as $value)
                                                                        @if($value['cid'] === $category['cid'])
                                                                            @if($num < 6)
                                                                                <li>
                                                                                    <a href="http://{{$_SERVER['HTTP_HOST']}}/catalog?{{$value['fid']}}={{$category['cid']}}">{{$value['name']}}</a>
                                                                                </li>
                                                                                @php
                                                                                    $num += 1
                                                                                @endphp
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                                <li class="megamenu-holder">
                                                    <a href="{{route('favourite')}}">Избранное
                                                        <i class="pe-7s-angle-down"></i>
                                                    </a>
                                                    <ul class="drop-menu megamenu">
                                                        @foreach($favArray as $key => $cat)
                                                            <li>
                                                                <span class="title">{{$key}}</span>
                                                                <ul>
                                                                    @foreach($cat['value'] as $elem)
                                                                        <li>
                                                                            @if($key === 'Приоритет')
                                                                                <a href="http://{{$_SERVER['HTTP_HOST']}}/favourite-catalog?{{$cat['id']}}={{$elem->id}}&stage=all">{{$elem->name}}</a>
                                                                            @else
                                                                                <a href="http://{{$_SERVER['HTTP_HOST']}}/favourite-catalog?priority=all&{{$cat['id']}}={{$elem->id}}">{{$elem->name}}</a>
                                                                            @endif
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                                <li class="megamenu-holder">
                                                    <a href="">Помощь
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                @else
                                    <div class="main-menu d-none d-lg-block">
                                    </div>
                                @endauth
                            @endif
                            <div class="header-right">
                                @if (Route::has('login'))
                                    <nav class="-mx-3 flex flex-1 justify-end">
                                        @auth
                                            <ul>
                                                <li class="dropdown d-none d-lg-block">
                                                    <button class="btn btn-link dropdown-toggle ht-btn p-0"
                                                            type="button" id="settingButton" data-bs-toggle="dropdown"
                                                            aria-label="setting" aria-expanded="false">
                                                        {{ Auth::user()->name }}
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end"
                                                        aria-labelledby="settingButton">
                                                        <x-dropdown-link :href="route('profile.edit')">
                                                            {{ __('Смена данных') }}
                                                        </x-dropdown-link>
                                                        <x-dropdown-link :href="route('logout')">
                                                            {{ __('Выйти') }}
                                                        </x-dropdown-link>
                                                    </ul>
                                                </li>
                                            </ul>
                                        @else
                                            <a href="{{ route('login') }}"
                                               class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                                Войти
                                            </a>

                                            @if (Route::has('register'))
                                                <a href="{{ route('register') }}"
                                                   class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                                    Зарегистрироваться
                                                </a>
                                            @endif
                                        @endauth
                                    </nav>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                data-tippy="Close" data-tippy-inertia="true" data-tippy-animation="shift-away"
                                data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-search">
                            <span class="searchbox-info">Введите наименование и нажмите Enter для поиска или ESC для выхода</span>
                            <form action="#" class="hm-searchbox">
                                <input type="text" name="Search entire store here..."
                                       value="Введите наименование здесь..."
                                       onblur="if(this.value==''){this.value='Search entire store here...'}"
                                       onfocus="if(this.value=='Search entire store here...'){this.value=''}">
                                <button class="search-btn" type="submit" aria-label="searchbtn"><i
                                        class="pe-7s-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="offcanvas-minicart_wrapper" id="miniCart">
            <div class="offcanvas-body">
                <div class="minicart-content">
                    <div class="minicart-heading">
                        <h4 class="mb-0">Shopping Cart</h4>
                        <a href="#" class="button-close"><i class="pe-7s-close" data-tippy="Close"
                                                            data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                            data-tippy-delay="50" data-tippy-arrow="true"
                                                            data-tippy-theme="sharpborder"></i></a>
                    </div>
                    <ul class="minicart-list">
                        <li class="minicart-product">
                            <a class="product-item_remove" href="#"><i
                                    class="pe-7s-trash" data-tippy="Wanna Remove?" data-tippy-inertia="true"
                                    data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true"
                                    data-tippy-theme="sharpborder"></i></a>
                            <a href="shop.html" class="product-item_img">
                                <img class="img-full"
                                     src="{{ asset('myPublic/assets/images/product/small-size/1-1-70x70.png')}}"
                                     alt="Product Image">
                            </a>
                            <div class="product-item_content">
                                <a class="product-item_title" href="shop.html">Tail Light</a>
                                <span class="product-item_quantity">1 x $80.00</span>
                            </div>
                        </li>
                        <li class="minicart-product">
                            <a class="product-item_remove" href="#"><i
                                    class="pe-7s-trash" data-tippy="Wanna Remove?" data-tippy-inertia="true"
                                    data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true"
                                    data-tippy-theme="sharpborder"></i></a>
                            <a href="shop.html" class="product-item_img">
                                <img class="img-full"
                                     src="{{ asset('myPublic/assets/images/product/small-size/1-2-70x70.png')}}"
                                     alt="Product Image">
                            </a>
                            <div class="product-item_content">
                                <a class="product-item_title" href="shop.html">Wiper Blades</a>
                                <span class="product-item_quantity">1 x $80.00</span>
                            </div>
                        </li>
                        <li class="minicart-product">
                            <a class="product-item_remove" href="#">
                                <i class="pe-7s-trash" data-tippy="Wanna Remove?" data-tippy-inertia="true"
                                   data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true"
                                   data-tippy-theme="sharpborder"></i>
                            </a>
                            <a href="shop.html" class="product-item_img">
                                <img class="img-full"
                                     src="{{ asset('myPublic/assets/images/product/small-size/1-3-70x70.png')}}"
                                     alt="Product Image">
                            </a>
                            <div class="product-item_content">
                                <a class="product-item_title" href="shop.html">Suspension</a>
                                <span class="product-item_quantity">1 x $80.00</span>
                            </div>
                        </li>
                        <li class="minicart-product">
                            <a class="product-item_remove" href="#">
                                <i class="pe-7s-trash" data-tippy="Wanna Remove?" data-tippy-inertia="true"
                                   data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true"
                                   data-tippy-theme="sharpborder"></i>
                            </a>
                            <a href="shop.html" class="product-item_img">
                                <img class="img-full"
                                     src="{{ asset('myPublic/assets/images/product/small-size/1-4-70x70.png')}}"
                                     alt="Product Image">
                            </a>
                            <div class="product-item_content">
                                <a class="product-item_title" href="shop.html">Air Filter</a>
                                <span class="product-item_quantity">1 x $80.00</span>
                            </div>
                        </li>
                        <li class="minicart-product">
                            <a class="product-item_remove" href="#">
                                <i class="pe-7s-trash" data-tippy="Wanna Remove?" data-tippy-inertia="true"
                                   data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true"
                                   data-tippy-theme="sharpborder"></i>
                            </a>
                            <a href="shop.html" class="product-item_img">
                                <img class="img-full"
                                     src="{{ asset('myPublic/assets/images/product/small-size/1-5-70x70.png')}}"
                                     alt="Product Image">
                            </a>
                            <div class="product-item_content">
                                <a class="product-item_title" href="shop.html">Car Brakes</a>
                                <span class="product-item_quantity">1 x $80.00</span>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="minicart-item_total">
                    <span>Subtotal</span>
                    <span class="ammount">$240.00</span>
                </div>
                <div class="group-btn_wrap d-grid gap-2">
                    <a href="cart.html" class="btn btn-dark btn-primary-hover">View Cart</a>
                    <a href="checkout.html" class="btn btn-dark btn-primary-hover">Checkout</a>
                </div>
            </div>
        </div>
        <div class="global-overlay"></div>
    </header>
    <!-- Main Header Area End Here -->

    <!-- Begin Main Content Area -->
    <main class="main-content">
        @yield('content')
    </main>
    <!-- Main Content Area End Here -->

    <!-- Begin Footer Area -->
    <div class="footer-area">
        <div class="footer-top section-space-y-axis-100 text-lavender"
             data-bg-image="{{ asset('myPublic/assets/images/background-img/1-4-1920x419.png')}}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="widget-item">
                            <div class="footer-logo pb-4">
                                <a href="myPublic/index.html">
                                    <img src="{{ asset('myPublic/assets/images/logo/smile.png')}}" alt="Logo">
                                </a>
                            </div>
                            <p class="short-desc mb-2">В случае возникновения вопросов по работе сервиса рекомендуем
                                обратиться в поддержку в одной из социальных сетей или воспользоваться блоком
                                "Поддержка".</p>
                            <div class="social-link pt-2">
                                <ul>
                                    <li>
                                        <a href="#" data-tippy="Twitter" data-tippy-inertia="true"
                                           data-tippy-animation="shift-away" data-tippy-delay="50"
                                           data-tippy-arrow="true" data-tippy-theme="sharpborder">
                                            <i class="fa fa-twitter"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" data-tippy="Tumblr" data-tippy-inertia="true"
                                           data-tippy-animation="shift-away" data-tippy-delay="50"
                                           data-tippy-arrow="true" data-tippy-theme="sharpborder">
                                            <i class="fa fa-tumblr"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" data-tippy="Facebook" data-tippy-inertia="true"
                                           data-tippy-animation="shift-away" data-tippy-delay="50"
                                           data-tippy-arrow="true" data-tippy-theme="sharpborder">
                                            <i class="fa fa-facebook"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" data-tippy="Instagram" data-tippy-inertia="true"
                                           data-tippy-animation="shift-away" data-tippy-delay="50"
                                           data-tippy-arrow="true" data-tippy-theme="sharpborder">
                                            <i class="fa fa-instagram"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-4 pt-8 pt-lg-0">
                        <div class="widget-item">
                            <h3 class="widget-title mb-5">Ссылки</h3>
                            <ul class="widget-list-item">
                                <li>
                                    <i class="fa fa-chevron-right"></i>
                                    <a href="#">Поддержка</a>
                                </li>
                                <li>
                                    <i class="fa fa-chevron-right"></i>
                                    <a href="#">Сотрудничество</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-4 pt-8 pt-lg-0">
                        <div class="widget-item">
                            <h3 class="widget-title mb-5">Компания</h3>
                            <ul class="widget-list-item">
                                <li>
                                    <i class="fa fa-chevron-right"></i>
                                    <a href="#">О нас</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 pt-8 pt-lg-0">
                        <div class="widget-item">
                            <h3 class="widget-title mb-5">Краткая информация</h3>
                        </div>
                        <div class="widget-contact-info pb-2">
                            <ul>
                                <li>
                                    2024 Pumori Tender. Свердл.область, Екатеринбург 66, Россия,
                                </li>
                                <li>
                                    <a href="mailto://info@example.com">pumori.tender.search@yandex.ru</a>
                                </li>
                                <li>
                                    <a href="tel://+68-120034509">+7 (922) 209 8644</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Area End Here -->


    <!-- Begin Scroll To Top -->
    <a class="scroll-to-top" href="">
        <i class="fa fa-chevron-up"></i>
    </a>
    <!-- Scroll To Top End Here -->

</div>

<!-- Global Vendor, plugins JS -->

<!-- JS Files
============================================ -->
<!-- Global Vendor, plugins JS -->

<!-- Vendor JS -->
<script src="{{ asset('myPublic/assets/js/vendor/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('myPublic/assets/js/vendor/jquery-3.6.0.min.js')}}"></script>
<script src="{{ asset('myPublic/assets/js/vendor/jquery-migrate-3.3.2.min.js')}}"></script>
<script src="{{ asset('myPublic/assets/js/vendor/modernizr-3.11.2.min.js')}}"></script>

<!--Plugins JS-->
<script src="{{ asset('myPublic/assets/js/plugins/wow.min.js')}}"></script>
<script src="{{ asset('myPublic/assets/js/plugins/jquery-ui.min.js')}}"></script>
<script src="{{ asset('myPublic/assets/js/plugins/swiper-bundle.min.js')}}"></script>
<script src="{{ asset('myPublic/assets/js/plugins/jquery.nice-select.js')}}"></script>
<script src="{{ asset('myPublic/assets/js/plugins/parallax.min.js')}}"></script>
<script src="{{ asset('myPublic/assets/js/plugins/jquery.magnific-popup.min.js')}}"></script>
<script src="{{ asset('myPublic/assets/js/plugins/tippy.min.js')}}"></script>
<script src="{{ asset('myPublic/assets/js/plugins/ion.rangeSlider.min.js')}}"></script>
<script src="{{ asset('myPublic/assets/js/plugins/mailchimp-ajax.js')}}"></script>

<!-- Minify Version -->
<!-- <script src="assets/js/vendor.min.js"></script> -->
<!-- <script src="assets/js/plugins.min.js"></script> -->

<!--Main JS (Common Activation Codes)-->
<script src="{{ asset('myPublic/assets/js/main.js')}}"></script>
<!-- <script src="assets/js/main.min.js"></script> -->

</body>

</html>
