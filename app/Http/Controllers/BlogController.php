<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\BlogRequest;

class BlogController extends Controller
{
    // コンストラクタ
    public function __construct(
        private Blog $blog = new Blog,
    ) {}

    // マイページ画面表示
    public function mypage()
    {
        // ログインユーザIDを取得
        $user_id = Auth::id();
        // モデルで自身のブログを取得する
        $blogs = $this->blog->getOwnBlog($user_id);
        // ビューにデータを渡す
        return view('mypage', compact('blogs'));
    }

    // 一覧画面表示
    public function index()
    {
        // ログインユーザIDを取得
        $user_id = Auth::id();

        // ログインユーザー以外のブログを取得し、ユーザー情報を一緒に取得
        $blogs = $this->blog->getOtherBlog($user_id);

        // ビューにデータを渡す
        return view('index', compact('blogs'));
    }

    // 新規投稿画面を表示
    public function create()
    {
        return view('create');
    }

    // 投稿データを保存
    public function store(BlogRequest $request)
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
        // タイトルの入力欄に入力された値を変数に代入
        $titleSearch = $request->input('title');
        // 日付の入力欄に入力された値を変数に代入
        $dateSearch = $request->input('created_at');

        // 検索するタイトルキーワードが入力された場合
        if ($request->filled('title')) {
            // 部分一致条件追加して検索
            $query->where('title', 'like', '%' . $titleSearch . '%');
        }

        // 検索する日付が入力された場合
        if ($request->filled('created_at')) {
            // 一致条件追加して検索
            $query->whereDate('created_at', $dateSearch);
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
