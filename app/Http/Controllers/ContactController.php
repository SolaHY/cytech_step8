<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function showForm()
    {
        // 問い合わせフォームを表示
        return view('contact');
    }

    // 問い合わせフォームの内容を送信
    public function submitForm(Request $request)
    {
        // バリデーション（任意で追加）
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // メール送信の詳細を設定
        $details = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
        ];

        try {
            // 管理者にメールを送信
            Mail::to(env('ADMIN_EMAIL'))->send(new ContactMail($details));

            return redirect()->route('index')
                ->with('success', 'お問い合わせが送信されました！');
        } catch (\Exception $e) {
            // 送信失敗時のエラーハンドリング
            \Log::error('メール送信エラー: ' . $e->getMessage());
            return back()->with('error', 'メール送信に失敗しました。後でもう一度お試しください。');
        }
    }
}
