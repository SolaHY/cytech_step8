@extends('app')

@section('title', 'お問い合わせフォーム')

@section('content')
<div class="container">
    <h1>お問い合わせフォーム</h1>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('contact.submit') }}" method="POST">
        @csrf
        <div class="mt-3">
            <label for="name">名前:</label>
            <input type="text" id="name" name="name">
        </div>
        <div>
            <label for="email">メールアドレス:</label>
            <input type="email" id="email" name="email">
        </div>
        <div>
            <label for="message">お問い合わせ内容:</label>
            <textarea id="message" name="message"></textarea>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">送信</button>
        </div>
    </form>
</div>
@endsection