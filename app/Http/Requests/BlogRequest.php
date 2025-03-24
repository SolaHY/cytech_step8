<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
{
    /**
     * リクエストの認可処理
     * trueを返すことで、全ユーザーがこのリクエストを使用可能になります
     */
    public function authorize()
    {
        return true;
    }

    /**
     * バリデーションルールの定義
     * タイトル、内容、画像のバリデーションルールを設定
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',  // タイトルは必須で255文字以内
            'content' => 'required',        // 内容は必須
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // 画像は任意で、指定された形式のみ許可
        ];
    }

    /**
     * バリデーションエラーメッセージの定義
     * 各バリデーションルールに対する日本語のエラーメッセージを設定
     */
    public function messages()
    {
        return [
            'title.required' => 'タイトルは必須です。',
            'title.max' => 'タイトルは255文字以内で入力してください。',
            'content.required' => '内容は必須です。',
            'image.image' => '画像ファイルをアップロードしてください。',
            'image.mimes' => '画像はjpeg、png、jpg、gif形式のみアップロード可能です。',
            'image.max' => '画像サイズは2MB以下にしてください。',
        ];
    }
}
