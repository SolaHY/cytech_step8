<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    // ①イイねを追加する処理
    public function likeBlog(Request $request, Blog $blog)
    {
        $user = Auth::user(); // 現在ログインしているユーザーを取得

        // ユーザーが既にこのブログに「いいね」しているか確認
        if (!$blog->likedBy($user)) {
            // 「いいね」していなければ、likesテーブルに新しいレコードを作成
            Like::create([
                'blog_id' => $blog->id, // このブログのID
                'user_id' => $user->id, // ログインしているユーザーのID
            ]);
        }

        // そのブログに対する現在の「いいね」数を返す
        return response()->json([
            'likes_count' => $blog->likes()->count(),
        ]);
    }

    // ②イイねを削除する処理
    public function unlikeBlog(Request $request, Blog $blog)
    {
        $user = Auth::user(); // 現在ログインしているユーザーを取得

        // ユーザーがこのブログに「いいね」しているか確認
        if ($blog->likedBy($user)) {
            // 「いいね」していれば、likesテーブルからそのレコードを削除
            Like::where('blog_id', $blog->id)
                ->where('user_id', $user->id)
                ->delete();
        }

        // そのブログに対する現在の「いいね」数を返す
        return response()->json([
            'likes_count' => $blog->likes()->count(),
        ]);
    }
}
