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
}
