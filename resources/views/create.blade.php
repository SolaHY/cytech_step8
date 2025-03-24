@extends('app')

@section('title', '新規投稿')

@section('content')
<div class="container">
    <h1>新規投稿</h1>
    {{-- バリデーションエラーメッセージの表示 --}}
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    {{-- ブログ投稿フォーム --}}
    <form action="{{ route('store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- タイトル入力フィールド --}}
        <div class="form-group">
            <label for="title">タイトル:</label>
            <input type="text" name="title" id="title" class="form-control">
        </div>
        {{-- 本文入力フィールド --}}
        <div class="form-group">
            <label for="content">内容:</label>
            <textarea name="content" id="content" class="form-control"></textarea>
        </div>
        {{-- 画像アップロードフィールド --}}
        <div class="form-group">
            <label for="image">画像:</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>
        {{-- 投稿ボタン --}}
        <button type="submit" class="btn btn-primary">投稿</button>
    </form>
</div>
@endsection