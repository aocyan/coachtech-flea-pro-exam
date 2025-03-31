@extends('layouts.app')

@section('css')
	<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
       
<div class="register-header">
    <div class="register-header__logo">
        <h2>会員登録</h2>
    </div>
</div>
<form class="register-form" action="{{ route('user.store') }}" method="post">
@csrf
    <div class="form__group">
        <div class="form__group-title">
            <p>ユーザ名</p>
        </div>
        <input class="form__input" type="text" name="name" value="{{ old('name') }}" placeholder="例：鈴木　太郎　※フルネームで入力してください" />
        <div class="form__error">
            @error('name')
                {{ $message }}
            @enderror
        </div>
        <div class="form__group-title">
            <p>メールアドレス</p>
        </div>
        <input class="form__input" type="email" name="email" value="{{ old('email') }}" placeholder="例：sample@example.com" />
        <div class="form__error">
            @error('email')
                {{ $message }}
            @enderror
        </div>
        <div class="form__group-title">
            <p>パスワード</p>
        </div>
        <input class="form__input" type="password" name="password"/>
        <div class="form__error">
            @error('password')
                {{ $message }}
            @enderror
        </div>
        <div class="form__group-title">
            <p>確認用パスワード</p>
        </div>
        <input class="form__input" type="password" name="password_confirmation"/>
        <div class="form__error">
            @error('password')
                {{ $message }}
            @enderror
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit" name="submit">登録する</button>
        </div>
    </div>
</form>
<div class="login__link">
    <a class="login__link--button" href="{{ route('login') }}">ログインはこちら</a>
</div>

@endsection