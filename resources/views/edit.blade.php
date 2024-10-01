@extends('app')

@section('title', 'ブログ編集')

@section('content')
<div class="container">
    <h1>ブログを編集</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('update', $blog->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">タイトル</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $blog->title) }}" required>
        </div>

        <div class="form-group">
            <label for="content">内容</label>
            <textarea name="content" class="form-control" rows="5" required>{{ old('content', $blog->content) }}</textarea>
        </div>

        <!-- 現在の画像の表示 -->
        @if($blog->image)
        <div class="form-group">
            <label>現在の画像</label>
            <div>
                <img src="{{ asset('storage/' . $blog->image) }}" alt="Current Image" style="max-width: 200px; height: auto;">
            </div>
        </div>
        @endif

        <!-- 画像のアップロード -->
        <div class="form-group">
            <label for="image">画像をアップロード</label>
            <input type="file" name="image" class="form-control-file">
        </div>

        <button type="submit" class="btn btn-primary">更新する</button>
        <a href="{{ route('detail', $blog->id) }}" class="btn btn-secondary">キャンセル</a>
    </form>
</div>
@endsection