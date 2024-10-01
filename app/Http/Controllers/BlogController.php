<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    // マイページ画面表示
    public function mypage()
    {
        // ログインユーザーのブログを取得し、ユーザー情報を一緒に取得
        $blogs = Blog::with('user')
            ->where('user_id', '=', auth()->id())  // ログインユーザーの投稿に限定
            ->get();

        // ビューにデータを渡す
        return view('mypage', compact('blogs'));
    }

    // 一覧画面表示
    public function index()
    {
        // ログインユーザー以外のブログを取得し、ユーザー情報を一緒に取得
        $blogs = Blog::with('user')
            ->where('user_id', '!=', auth()->id())  // ログインユーザーの投稿を除外
            ->get();

        // ビューにデータを渡す
        return view('index', compact('blogs'));
    }

    // 新規投稿画面を表示
    public function create()
    {
        return view('create');
    }

    // 投稿データを保存
    public function store(Request $request)
    {
        // バリデーション
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 画像ファイルの処理
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $imagePath;
        }

        $validatedData['user_id'] = auth()->id();

        // 投稿データを保存
        Blog::create($validatedData);

        // リダイレクト
        return redirect()->route('index')->with('success', 'ブログが投稿されました');
    }

    // 詳細画面を表示
    public function show($id)
    {
        // 指定されたIDのブログ投稿と投稿者の情報を取得
        $blog = Blog::with('user')->findOrFail($id);
        return view('detail', compact('blog'));
    }

    // 更新画面の表示
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('edit', compact('blog'));
    }

    // 更新処理
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $blog = Blog::findOrFail($id);
        $blog->title = $request->input('title');
        $blog->content = $request->input('content');

        // 画像がアップロードされた場合
        if ($request->hasFile('image')) {
            // 既存の画像を削除
            if ($blog->image) {
                Storage::delete('public/' . $blog->image);
            }

            // 画像を保存
            $imagePath = $request->file('image')->store('images', 'public');
            $blog->image = $imagePath;
        }

        $blog->save();

        return redirect()->route('detail', $id)
            ->with('success', '記事が更新されました');
    }

    public function search(Request $request)
    {
        $query = Blog::query();

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }

        if ($request->filled('created_at')) {
            $query->whereDate('created_at', $request->input('created_at'));
        }

        $blogs = $query->get();

        return view('index', compact('blogs'));
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return redirect()->route('index')
            ->with('success', '記事が削除されました');
    }
}
