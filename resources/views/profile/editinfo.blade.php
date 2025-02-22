@php
    use App\Models\PriorityModel;
    use App\Models\WorkStageModel;
    use Illuminate\Support\Facades\Auth;

    $priorities = PriorityModel::select('id', 'name')->get()->toArray();
    $workStage = WorkStageModel::select('id', 'name')->get()->toArray();
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
                <div class="col-md-4">
                    <img src="https://via.placeholder.com/150" alt="Аватар" class="img-fluid rounded-circle">
                </div>
                <div class="col-md-8">
                    <h5 class="card-title">Имя пользователя</h5>
                    <p class="card-text">Email: user@example.com</p>
                    <p class="card-text">Телефон: +7 (999) 999-99-99</p>
                    <a href="#" class="btn btn-primary">Редактировать профиль</a>
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
                Статистика
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="tab-btn" id="settings-tab" data-bs-toggle="tab" href="#settings"
               role="tab" aria-controls="settings" aria-selected="true">
                Настройки
            </a>
        </li>
    </ul>
    <div class="tab-content product-tab-content">
        <div class="tab-pane fade show active" id="information" role="tabpanel" aria-labelledby="information-tab">
            <div class="product-information-body">
                <h4 class="title">Тут будет основная информация о профиле</h4>
                <p class="short-desc mb-4">Текст</p>
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
                                                <th>Номер заказа</th>
                                                <th>Дата</th>
                                                <th>Сумма</th>
                                                <th>Статус</th>
                                                <th>Действия</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>#2014</td>
                                                <td>2023-10-26</td>
                                                <td>1500 ₽</td>
                                                <td>Выполнен</td>
                                                <td><a href="#" class="btn btn-primary btn-sm">Подробнее</a></td>
                                            </tr>
                                            <tr>
                                                <td>#2015</td>
                                                <td>2023-10-27</td>
                                                <td>2000 ₽</td>
                                                <td>В обработке</td>
                                                <td><a href="#" class="btn btn-primary btn-sm">Подробнее</a></td>
                                            </tr>
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
                                <form action="" method="POST">
                                    <label for="name">Название приоритета:</label>
                                    <input type="text" id="name" name="name" class="form-control">
                                    <label for="code">Код приоритета:</label>
                                    <input type="text" id="code" name="code" class="form-control">
                                    <label for="color">Цвет для отображения:</label>
                                    <input type="color" id="color" name="color" class="form-control">
                                    <x-primary-button class="btn btn-custom-size lg-size btn-primary">
                                        {{ __('Сохранить') }}
                                    </x-primary-button>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="delete-priority" role="tabpanel"
                             aria-labelledby="delete-priority-tab">
                            <div class="product-delete-priority-body">
                                <form action="" method="POST">
                                    <label for="name">Выберите приоритет:</label>
                                    <select class="nice-select wide border-bottom-0 rounded-0">
                                        @foreach($priorities as $elem)
                                            <option value="{{$elem['id']}}">{{$elem['name']}}</option>
                                        @endforeach
                                    </select>
                                    <x-primary-button class="btn btn-custom-size lg-size btn-primary">
                                        {{ __('Удалить') }}
                                    </x-primary-button>
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
                                <form action="" method="POST">
                                    <label for="name">Наименование этапа работы:</label>
                                    <input type="text" id="name" name="name" class="form-control">
                                    <label for="code">Код этапа работы:</label>
                                    <input type="text" id="code" name="code" class="form-control">
                                    <x-primary-button class="btn btn-custom-size lg-size btn-primary">
                                        {{ __('Сохранить') }}
                                    </x-primary-button>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="delete-workstage" role="tabpanel"
                             aria-labelledby="delete-workstage-tab">
                            <div class="product-delete-workstage-body">
                                <form action="" method="POST">
                                    <label for="name">Выберите этап работы:</label>
                                    <select class="nice-select wide border-bottom-0 rounded-0">
                                        @foreach($workStage as $elem)
                                            <option value="{{$elem['id']}}">{{$elem['name']}}</option>
                                        @endforeach
                                    </select>
                                    <x-primary-button class="btn btn-custom-size lg-size btn-primary">
                                        {{ __('Удалить') }}
                                    </x-primary-button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        var userId = {{Auth::id()}}; // Получаем ID пользователя
    </script>
    <script src="{{asset('js/chosenTender.js')}}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

{{--@extends('header')--}}

{{--@section('content')--}}
{{--    <div class="breadcrumb-area breadcrumb-height" data-bg-image="{{ asset('myPublic/assets/images/background-img/1920400.png')}}">--}}
{{--        <div class="container h-100">--}}
{{--            <div class="row h-100">--}}
{{--                <div class="col-lg-12">--}}
{{--                    <div class="breadcrumb-item text-night-rider">--}}
{{--                        <h2 class="breadcrumb-heading">Личный кабинет</h2>--}}
{{--                        <ul>--}}
{{--                            <li>--}}
{{--                                <a href="">На главную</a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="py-12">--}}
{{--        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">--}}
{{--            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">--}}
{{--                <div class="login-form">--}}
{{--                    <header>--}}
{{--                        <h2 class="login-title">--}}
{{--                            {{ __('Информация профиля') }}--}}
{{--                        </h2>--}}

{{--                        <p class="mt-1 text-sm text-gray-600">--}}
{{--                            {{ __("Основная информация о пользователе") }}--}}
{{--                        </p>--}}
{{--                    </header>--}}

{{--                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">--}}
{{--                        @csrf--}}
{{--                    </form>--}}

{{--                    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">--}}
{{--                        @csrf--}}
{{--                        @method('patch')--}}

{{--                        <div>--}}
{{--                            <x-input-label for="name" :value="__('Имя пользователя')" />--}}
{{--                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"/>--}}
{{--                            <x-input-error class="mt-2" :messages="$errors->get('name')" />--}}
{{--                        </div>--}}

{{--                        <div>--}}
{{--                            <x-input-label for="surname" :value="__('Фамилия')" />--}}
{{--                            <x-text-input id="surname" name="surname" type="text" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />--}}
{{--                            <x-text-input id="surname" name="surname" type="text" class="mt-1 block w-full"/>--}}
{{--                            <x-input-error class="mt-2" :messages="$errors->get('surname')" />--}}
{{--                        </div>--}}

{{--                        <div>--}}
{{--                            <x-input-label for="birthday" :value="__('Дата рождения')" />--}}
{{--                            <x-text-input id="birthday" name="birthday" type="data" class="mt-1 block w-full"/>--}}
{{--                            <x-input-error class="mt-2" :messages="$errors->get('birthday')" />--}}
{{--                        </div>--}}

{{--                        <div class="flex items-center gap-4">--}}
{{--                            <x-primary-button class="btn btn-custom-size lg-size btn-primary">{{ __('Сохранить') }}</x-primary-button>--}}

{{--                            @if (session('status') === 'profile-updated')--}}
{{--                                <p--}}
{{--                                    x-data="{ show: true }"--}}
{{--                                    x-show="show"--}}
{{--                                    x-transition--}}
{{--                                    x-init="setTimeout(() => show = false, 2000)"--}}
{{--                                    class="text-sm text-gray-600"--}}
{{--                                >{{ __('Обновлено.') }}</p>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">--}}
{{--                <div class="login-form">--}}
{{--                    <header>--}}
{{--                        <h2 class="login-title">--}}
{{--                            {{ __('Статистика') }}--}}
{{--                        </h2>--}}

{{--                        <p class="mt-1 text-sm text-gray-600">--}}
{{--                            {{ __("Основная статистика аккаунта пользователя") }}--}}
{{--                        </p>--}}
{{--                    </header>--}}

{{--                    <div>--}}
{{--                        @csrf--}}

{{--                        <div>--}}
{{--                            <div>--}}
{{--                                {{__('Всего избранных тендеров')}}--}}
{{--                            </div>--}}
{{--                            <div>--}}
{{--                                Пока 1--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}
