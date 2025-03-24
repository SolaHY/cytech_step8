@extends('app')

@section('title', 'ブログ一覧')

@section('content')
<div class="container">
    <h1>ブログ一覧</h1>
    {{-- マイページへのリンク --}}
    <div class="d-flex mb-3">
        <a href="{{ route('mypage') }}" class="mb-3 ms-auto">マイページ</a>
    </div>
    {{-- 検索フォーム --}}
    <form action="{{ route('search') }}" method="GET" class="my-3">
        <div class="row align-items-center">
            {{-- タイトル検索用のテキストボックス --}}
            <div class="col-4">
                <input type="text" name="title" class="form-control" placeholder="タイトルで検索" value="{{ request('title') }}">
            </div>
            {{-- 日付検索用のカレンダー --}}
            <div class="col-4">
                <input type="date" name="created_at" class="form-control" value="{{ request('created_at') }}">
            </div>
            {{-- 検索実行ボタン --}}
            <div class="col-2">
                <button type="submit" class="btn btn-primary">検索</button>
            </div>
        </div>
    </form>

    {{-- ブログ一覧テーブル --}}
    <table border="1" class="table">
        {{-- テーブルヘッダー --}}
        <thead>
            <tr>
                <th>投稿者</th>
                <th>タイトル</th>
                <th>内容</th>
                <th>画像</th>
                <th>投稿日</th>
            </tr>
        </thead>
        {{-- テーブルボディ --}}
        <tbody>
            @forelse($blogs as $blog)
            <tr>
                <td>{{ $blog->user->name }}</td>
                <td>{{ $blog->title }}</td>
                <td>{{ $blog->content }}</td>
                <td>
                    {{-- ブログ画像の表示（存在する場合） --}}
                    @if($blog->image)
                    <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" width="100">
                    @else
                    画像なし
                    @endif
                </td>
                <td>{{ $blog->created_at->format('Y-m-d') }}</td>
                {{-- 詳細表示ボタン --}}
                <td>
                    <a href="{{ route('detail', $blog->id) }}" class="btn btn-primary">詳細</a>
                </td>
            </tr>
            @empty
            {{-- ブログが存在しない場合のメッセージ --}}
            <tr>
                <td colspan="4" class="text-center">該当する記事はありません。</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{-- お問い合わせフォームへのリンク --}}
<div class="text-center mt-5">
    <a href="{{ route('contact.form') }}" class="btn btn-warning">お問い合わせ</a>
</div>
@endsection