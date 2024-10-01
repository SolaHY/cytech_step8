<?php

return [
    'custom' => [
        'title' => [
            'required' => 'タイトルを入力してください。',
            'max' => 'タイトルは255文字以内で入力してください。',
        ],
        'content' => [
            'required' => 'コンテンツを入力してください。',
        ],
        'image' => [
            'image' => '画像ファイルを選択してください。',
            'mimes' => 'jpeg, png, jpg, gif形式の画像ファイルを選択してください。',
            'max' => '画像ファイルのサイズは2048キロバイト以下にしてください。',
        ],
    ],

    'attributes' => [
        'title' => 'タイトル',
        'content' => 'コンテンツ',
        'image' => '画像',
    ],
];
