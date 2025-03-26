@extends('layouts.app')

@section('css')
	<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')


<div class="thanks__block">
    <p class="thanks__sentence">購入手続きが完了しました。<br>ご利用ありがとうございました。<br>またのご利用をお待ちしております。</p>
    <a class="index__link" href="{{ route('product.index') }}">商品一覧にもどる</a>
</div>

@endsection