@extends('app')

@section('title', 'ブログ詳細')

@section('content')
{{-- CSRFトークンをJavaScriptで使用するためのメタタグ --}}
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- Font Awesomeの読み込み --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
{{-- 外部JavaScriptファイルの読み込み --}}
<script src="{{ asset('js/like.js') }}"></script>

<div class="container">
    <h1>ブログ詳細</h1>
    <div class="container">
        {{-- ブログのタイトルと投稿者情報 --}}
        <h2>{{ $blog->title }}</h2>
        <p>投稿者: {{ $blog->user->name }}</p>
        <p>{{ $blog->content }}</p>
        {{-- ブログ画像の表示（存在する場合） --}}
        @if($blog->image)
        <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="img-fluid">
        @endif
        <p>{{ $blog->created_at->format('Y-m-d') }}</p>
        {{-- いいねボタンとカウンター --}}
        <div class="mb-3">
            <button id="like-btn" class="border-0 bg-transparent"
                data-blog-id="{{ $blog->id }}"
                @if($blog->likedBy(Auth::user())) style="color: red;" @endif>
                <i class="fas fa-heart"></i>
            </button>
            <span id="like-count">{{ $blog->likes()->count() }}</span>
        </div>
        {{-- ブログ投稿者の場合のみ表示される更新・削除ボタン --}}
        @if(auth()->check() && auth()->user()->id === $blog->user_id)
        <a href="{{ route('edit', $blog->id) }}" class="btn btn-primary">更新する</a>
        <form action="{{ route('destroy', $blog->id) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除しますか？');">削除する</button>
        </form>
        @endif
        {{-- ブログ一覧ページへの戻るボタン --}}
        <a href="{{ route('index') }}" class="btn btn-secondary">一覧に戻る</a>
    </div>
</div>
@endsection