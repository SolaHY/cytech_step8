<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // 同じユーザーが同じ投稿に複数回いいねできないようにユニーク制約を追加
            $table->unique(['blog_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('likes');
    }
};
