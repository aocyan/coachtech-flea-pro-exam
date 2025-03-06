@extends('layouts.app')

@section('css')
	<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endsection

@section('content')

<nav>
    <div class="header-nav">
        <div class="nav__search">
            <input class="nav__search--text" type="text" name="search" placeholder="なにをお探しですか？" />
        </div>
        <div class="nav__logout">
            <a class="logout-link" href="/login">ログアウト</a>
        </div>
        <div class="nav__maypage">
            <a class="mypage-link" href="/mypage">マイページ</a>
        </div>
        <div class="nav__sell">
            <a class="sell-link" href="/sell">出品</a>
        </div>
    </div>
</nav>
       
<div class="profile-header">
    <div class="profile-header__logo">
        <h2>プロフィール設定</h2>
    </div>
</div>
<form class="register-form" action=" method="">
@csrf
    <div class="form__group">
        <div class="form__image">
            <label class="form__image--button" for="image-upload">画像を選択する</label>
            <input class="form__image--item" type="file" id="image-upload" name="image" accept="image/*" />
        </div>
        <div class="form__group-title">
            <p>ユーザ名</p>
        </div>
        <input class="form__input" type="text" name="name" value="{{ old('name') }}" />
        <div class="form__error">
            @error('name')
                {{ $message }}
            @enderror
        </div>
        <div class="form__group-title">
            <p>郵便番号</p>
        </div>
        <input class="form__input" type="text" name="postal-number" value="{{ old('email') }}"/>
        <div class="form__error">
            @error('postal-number')
                {{ $message }}
            @enderror
        </div>
        <div class="form__group-title">
            <p>住所</p>
        </div>
        <input class="form__input" type="address" name="address"/>
        <div class="form__error">
            @error('password')
                {{ $message }}
            @enderror
        </div>
        <div class="form__group-title">
            <p>建物名</p>
        </div>
        <input class="form__input" type="text" name="building"/>
        <div class="form__error">
            @error('password')
                {{ $message }}
            @enderror
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit" name="update" value="update">更新する</button>
        </div>
    </div>
</form>

@endsection