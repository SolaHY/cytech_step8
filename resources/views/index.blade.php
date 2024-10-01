@extends('app')

@section('title', 'ブログ一覧')

@section('content')
<div class="container">
    <h1>ブログ一覧</h1>

    <div class="d-flex mb-3">
        <a href="{{ route('mypage') }}" class="mb-3 ms-auto">マイページ</a>
    </div>

    <form action="{{ route('search') }}" method="GET" class="my-3">
        <div class="row align-items-center">
            <div class="col-4">
                <input type="text" name="title" class="form-control" placeholder="タイトルで検索" value="{{ request('title') }}">
            </div>
            <div class="col-4">
                <input type="date" name="created_at" class="form-control" value="{{ request('created_at') }}">
            </div>
            <div class="col-2">
                <button type="submit" class="btn btn-primary">検索</button>
            </div>
        </div>
    </form>

    <table border="1" class="table">
        <thead>
            <tr>
                <th>投稿者</th>
                <th>タイトル</th>
                <th>内容</th>
                <th>画像</th>
                <th>投稿日</th>
            </tr>
        </thead>
        <tbody>
            @forelse($blogs as $blog)
            <tr>
                <th>{{ $blog->user->name }}</th>
                <th>タイトル</th>
                <td>{{ $blog->title }}</td>
                <td>{{ $blog->content }}</td>
                <td>
                    @if($blog->image)
                    <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" width="100">
                    @else
                    画像なし
                    @endif
                </td>
                <td>{{ $blog->created_at->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('detail', $blog->id) }}" class="btn btn-primary">詳細</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">該当する記事はありません。</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>
<div class="text-center mt-5">
    <!-- 問い合わせフォームへのリンクを追加 -->
    <a href="{{ route('contact.form') }}" class="btn btn-warning">お問い合わせ</a>
</div>
@endsection