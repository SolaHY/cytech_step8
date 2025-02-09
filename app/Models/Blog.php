<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'content', 'image', 'user_id'];

    // ユーザーとのリレーションを定義
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // いいねとのリレーションを定義
    public function likes()
    {
        // １つのブログに対して「いいね」は複数（多）
        return $this->hasMany(Like::class);
    }

    // 特定のユーザーがそのブログ投稿に「いいね」をしているかどうかを確認
    public function likedBy(User $user)
    {
        // 特定のユーザーが現在の投稿に対して『いいね』しているか確認し、
        // 現在の投稿に関する「いいね」のリレーションを返却する。
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    // ログインユーザのブログを取得
    public function getOwnBlog($user_id)
    {
        // blogsテーブルのデータで$user_id（ログインユーザID）とイコールのデータを取得
        $blogs = $this->where('user_id', $user_id)->get();

        // 取得したブログを返却
        return $blogs;
    }

    // ログインユーザ以外のブログを取得
    public function getOtherBlog($user_id)
    {
        // blogsテーブルのデータで$user_idがログインユーザIDと異なるデータを取得
        $blogs = Blog::where('user_id', '!=', $user_id) // ログインユーザー以外のブログを取得
            ->with('user') // usersテーブルのデータをリレーションで取得
            ->get();
        // 取得したブログを返却
        return $blogs;
    }
}
