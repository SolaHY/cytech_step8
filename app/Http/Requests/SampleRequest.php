<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SampleRequest extends FormRequest
{
    public function authorize()
    {
        // ここをtrueにすることで、
        // 全ユーザーがこのリクエストを使用可能になります。
        return true;
    }

    public function rules()
    {
        // フォームバリデーションルールを定義
        return [
            'title' => 'required|max:255',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        // 各バリデーションルールに対するエラーメッセージ
        return [
            'title.required' => 'タイトルは必須です。',
            'title.max' => 'タイトルは255文字以内で入力してください。',
            'description.required' => '説明は必須です。',
        ];
    }
}
