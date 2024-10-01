<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TNGブログ')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <!-- ヘッダー部 -->
    <header class="py-3 mb-4 bg-primary-subtle">
        <div class="container">
            <div class="row mx-auto align-items-center">
                <div class="col-4"></div>
                <div class="col text-center">
                    <a href="{{ route('index') }}" class="text-decoration-none link-body-emphasis">
                        <h3>TNGブログ</h3>
                    </a>
                </div>
                <div class="col-4">
                    <div class="col-8">ログインユーザー: {{ auth()->user()->name }}</div>

                    <div class="col">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a class="btn btn-outline-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            ログアウト
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="row justify-content-center">
            <!-- フラッシュメッセージの表示 -->
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <!-- 各画面の中身 -->
            <div class="col-8">
                @yield('content')
            </div>
        </div>

    </div>

    <footer class=" d-flex flex-wrap justify-content-center py-3 mt-5 bg-primary-subtle">
        <!-- フッター部 -->
        <p>&copy; 2024 All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>