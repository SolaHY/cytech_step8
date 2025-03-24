<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>はじめてのView</title>
</head>

<body>
    <h1>はじめてのView</h1>
    <p>Viewファイルを利用してHTMLの文字列を返すと、ルーティングのファイル(web.php)がシンプルになります。</p>
    <ul>
        @foreach($samples as $sample)
        <li>
            {{ $sample->name }}: {{ $sample->description }}
        </li>
        @endforeach
    </ul>
</body>

</html>