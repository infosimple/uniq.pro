@extends('platform::auth')
@section('title',__('Регистрация'))

@section('content')
    <h1 class="h5 text-black">{{__('Регистрация')}}</h1>
    <form class="m-t-md"
          role="form"
          method="POST"
          data-controller="layouts--form"
          data-action="layouts--form#submit"
          data-layouts--form-button-animate="#button-login"
          data-layouts--form-button-text="{{ __('Загрузка...') }}"
          action="{{ route('register') }}">
        @csrf

        <div class="form-group">

            <label class="form-label">{{__('Имя')}}</label>

            {!!  \Orchid\Screen\Fields\Input::make('name')
                ->type('text')
                ->required()
                ->tabindex(1)
                ->placeholder(__('Введите ваше имя'))
            !!}
        </div>

        <div class="form-group">

            <label class="form-label">{{__('Адрес электронной почты')}}</label>

            {!!  \Orchid\Screen\Fields\Input::make('email')
                ->type('email')
                ->required()
                ->tabindex(2)
                ->placeholder(__('Введите адрес электронной почты'))
            !!}
        </div>

        <div class="form-group">
            <label class="form-label w-full">
                {{__('Пароль')}}
            </label>

            {!!  \Orchid\Screen\Fields\Password::make('password')
                ->required()
                ->tabindex(3)
                ->placeholder(__('Введите ваш пароль'))
            !!}
        </div>

        <div class="form-group">
            <label class="form-label w-full">
                {{__('Пароль ещё раз')}}
            </label>

            {!!  \Orchid\Screen\Fields\Password::make('password_confirmation')
                ->required()
                ->tabindex(4)
                ->placeholder(__('Повторите ваш пароль'))
            !!}
        </div>

        <div class="row ">
            <div class="form-group col-md-5 col-xs-12">
                <a href="/login" class="btn btn-default btn-block"><i class="icon-login text-xs mr-2"></i>Авторизация</a>
            </div>
            <div class="form-group col-md-7 col-xs-12">
                <button id="button-login" type="submit" class="btn btn-success btn-block" tabindex="3">
                    {{__('Зарегистрироваться')}}
                </button>
            </div>
        </div>
    </form>
@endsection
