@extends('app')

@section('title', 'マイページ')

@section('content')
<div class="container">
    <h1>マイページ</h1>
    {{-- 新規投稿ボタンと他の投稿へのリンク --}}
    <div class="d-flex mb-3">
        <a href="{{ route('create') }}" class="btn btn-success mb-3">新規投稿</a>
        <a href="{{ route('index') }}" class="ms-auto">他の人の投稿</a>
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
                {{-- アクションボタン（詳細表示・削除） --}}
                <td>
                    <a href="{{ route('detail', $blog->id) }}" class="btn btn-primary">詳細</a>
                    <form action="{{ route('destroy', $blog->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除しますか？');">削除</button>
                    </form>
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
@endsection