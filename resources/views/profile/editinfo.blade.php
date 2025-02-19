@extends('header')

@section('content')
    <div class="breadcrumb-area breadcrumb-height" data-bg-image="{{ asset('myPublic/assets/images/background-img/1920400.png')}}">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-12">
                    <div class="breadcrumb-item text-night-rider">
                        <h2 class="breadcrumb-heading">Личный кабинет</h2>
                        <ul>
                            <li>
                                <a href="">На главную</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="login-form">
                    <header>
                        <h2 class="login-title">
                            {{ __('Информация профиля') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Основная информация о пользователе") }}
                        </p>
                    </header>

                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                        @csrf
                    </form>

                    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <div>
                            <x-input-label for="name" :value="__('Имя пользователя')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"/>
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="surname" :value="__('Фамилия')" />
{{--                            <x-text-input id="surname" name="surname" type="text" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />--}}
                            <x-text-input id="surname" name="surname" type="text" class="mt-1 block w-full"/>
                            <x-input-error class="mt-2" :messages="$errors->get('surname')" />
                        </div>

                        <div>
                            <x-input-label for="birthday" :value="__('Дата рождения')" />
                            <x-text-input id="birthday" name="birthday" type="data" class="mt-1 block w-full"/>
                            <x-input-error class="mt-2" :messages="$errors->get('birthday')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button class="btn btn-custom-size lg-size btn-primary">{{ __('Сохранить') }}</x-primary-button>

                            @if (session('status') === 'profile-updated')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600"
                                >{{ __('Обновлено.') }}</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="login-form">
                    <header>
                        <h2 class="login-title">
                            {{ __('Статистика') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Основная статистика аккаунта пользователя") }}
                        </p>
                    </header>

                    <div>
                        @csrf

                        <div>
                            <div>
                                {{__('Всего избранных тендеров')}}
                            </div>
                            <div>
                                Пока 1
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
