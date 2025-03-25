@php
    use App\Models\Category;use Illuminate\Support\Facades\Auth;
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
                        <h2 class="breadcrumb-heading">Помощь и руководство пользования</h2>
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
    <div class="faq-area section-space-y-axis-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="frequently-area">
                        <h2 class="heading mb-0">Общие сведения по структуре веб-сервиса</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="frequently-item">
                                            <ul>
                                                <li class="has-sub active">
                                                    <a href="javascript:void(0)">Веб-сервис для поиска
                                                        <i class="pe-7s-angle-down"></i>
                                                    </a>
                                                    <ul class="frequently-body">
                                                        <li>
                                                            Веб-сервис PumoriTender предназначен для потбора и отслеживания интересующих тендеров, благодаря предоставляемому функционалу продукта.
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-sub">
                                                    <a href="javascript:void(0)">Принцип работы
                                                        <i class="pe-7s-angle-down"></i>
                                                    </a>
                                                    <ul class="frequently-body">
                                                        <li>
                                                            Предоставление данных осуществляется с помощью парсинга. Данные обновляются каждые 3 часа.
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-sub">
                                                    <a href="javascript:void(0)">Страница "Поиск тендеров"
                                                        <i class="pe-7s-angle-down"></i>
                                                    </a>
                                                    <ul class="frequently-body">
                                                        <li>
                                                            На странице "Поиск тендеров" Вы можете ознакомиться со всеми существующими на данный момент записями о тендерах по 44 и 223 ФЗ.
                                                            <br><br>
                                                            Веб-сервис специализирован на тендерах на поставку металлообрабатывающих станков и металлорежущего инструмента.
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 pt-6 pt-md-0">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="frequently-item">
                                            <ul>
                                                <li class="has-sub active">
                                                    <a href="javascript:void(0)">Страница "Избранное"
                                                        <i class="pe-7s-angle-down"></i>
                                                    </a>
                                                    <ul class="frequently-body">
                                                        <li>
                                                            На странице "Избранное" Вы можете ознакомиться со всеми тендерами, которые были добавлены в избранное, изменить их приоритет, этап работ, а также сформировать отчёт по данной странице.
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-sub">
                                                    <a href="javascript:void(0)">Страница "Личный кабинет"
                                                        <i class="pe-7s-angle-down"></i>
                                                    </a>
                                                    <ul class="frequently-body">
                                                        <li>
                                                            На странице "Личный кабинет" Вы можете отредактировать профиль пользователя, получить краткие сведения по работе с тендерами, а также добавить и удалить приоритеты и этапы работ для тендеров.
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-sub">
                                                    <a href="javascript:void(0)">Страница "Помощь"
                                                        <i class="pe-7s-angle-down"></i>
                                                    </a>
                                                    <ul class="frequently-body">
                                                        <li>
                                                            Страница "Помощь" предоставляет краткую информацию по веб-сервису и работе с ним.
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="frequently-area section-space-top-95">
                        <h2 class="heading mb-0">Функциональные возможности</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="frequently-item">
                                            <ul>
                                                <li class="has-sub active">
                                                    <a href="javascript:void(0)">Фильтрация
                                                        <i class="pe-7s-angle-down"></i>
                                                    </a>
                                                    <ul class="frequently-body">
                                                        <li>
                                                            На страницах "Поиск тендеров" и "Избранное" можно воспользоваться функционалом фильтрации тендеров для уменьшения круга поиска и подбора наиболее подходящих вариантов.
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-sub">
                                                    <a href="javascript:void(0)">Система приоритетов
                                                        <i class="pe-7s-angle-down"></i>
                                                    </a>
                                                    <ul class="frequently-body">
                                                        <li>
                                                            Система приоритетов позволяет устанавливать степень заинтересованности в каждом тендере для дальнейшей работы с ним. Создание приоритетов лежит полностью на самом пользователе.
                                                            <br><br>
                                                            Вы можете создавать собственные приоритеты в "Личном кабинете" пользователя в разделе "Настройки".
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-sub">
                                                    <a href="javascript:void(0)">Добавление тендера в избранное
                                                        <i class="pe-7s-angle-down"></i>
                                                    </a>
                                                    <ul class="frequently-body">
                                                        <li>
                                                            Для добавления тендера в избранное на странице "Поиск тендеров" рядом с каждой записью расположена кнопка.<br><br>
                                                            <img src="myPublic/assets/images/favAdd/addZap1.png" alt="q">
                                                            Тендер не находится в избранном. <br><br>
                                                            <img src="myPublic/assets/images/favAdd/addZap2.png" alt="q">
                                                            Тендер уже добавлен в избранное. <br><br>
                                                            При добавлении тендера в избранное необходимо сразу указать приоритет, который будет установлен для данного тендера.
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 pt-6 pt-md-0">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="frequently-item">
                                            <ul>
                                                <li class="has-sub active">
                                                    <a href="javascript:void(0)">Система этапов работ
                                                        <i class="pe-7s-angle-down"></i>
                                                    </a>
                                                    <ul class="frequently-body">
                                                        <li>
                                                            Для каждого тендера в избранном Вы можете добавить этап, на котором находится данный тендер.
                                                            <br><br>
                                                            Система этапов предназначена для упрощения отслеживания и учёта работ с тендерами.
                                                            <br><br>
                                                            Этапы работы создаются пользователем, а значит вы можете разработать их полностью под себя.
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-sub">
                                                    <a href="javascript:void(0)">Генерация отчётов
                                                        <i class="pe-7s-angle-down"></i>
                                                    </a>
                                                    <ul class="frequently-body">
                                                        <li>
                                                            На странице "Избранное" пользователь может сформировать выгрузку в формате Excel, указав необходимые данные для выгрузки и то, какие тендеры необходимо добавить в выгрузку.
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-sub">
                                                    <a href="javascript:void(0)">Статистика по аккаунту
                                                        <i class="pe-7s-angle-down"></i>
                                                    </a>
                                                    <ul class="frequently-body">
                                                        <li>
                                                            В личном кабинете в разделе "Статистика" Вы можете ознакомиться со статистикой профиля.
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var userId = {{Auth::id()}};
    </script>
    <script src="{{asset('js/updateFavouriteTender.js')}}" defer></script>
    <script src="{{asset('js/deleteFavouriteTender.js')}}" defer></script>
    <script src="{{asset('js/modalUnloadForm.js')}}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
