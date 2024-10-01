<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ContactController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sample', [SampleController::class, 'showSample']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// マイページ
Route::get('/mypage', [BlogController::class, 'mypage'])->name('mypage');

// 一覧画面表示
Route::get('/index', [BlogController::class, 'index'])->name('index');

// 新規登録画面表示
Route::get('/create', [BlogController::class, 'create'])->name('create');
// 新規登録処理
Route::post('/store', [BlogController::class, 'store'])->name('store');

// 詳細画面表示
Route::get('/blog/{id}', [BlogController::class, 'show'])->name('detail');

// 更新画面表示
Route::get('/blog/{id}/edit', [BlogController::class, 'edit'])->name('edit');
// 更新処理
Route::put('/blog/{id}', [BlogController::class, 'update'])->name('update');

// 検索処理
Route::get('/search', [BlogController::class, 'search'])->name('search');

// 削除機能
Route::delete('/blog/{id}', [BlogController::class, 'destroy'])->name('destroy');

// イイね追加
Route::post('/blogs/{blog}/like', [LikeController::class, 'likeBlog'])->middleware('auth');

// イイね削除
Route::delete('/blogs/{blog}/like', [LikeController::class, 'unlikeBlog'])->middleware('auth');

// 問い合わせフォーム画面
Route::get('/contact', [ContactController::class, 'showForm'])->name('contact.form');

// 問い合わせフォーム送信
Route::post('/contact', [ContactController::class, 'submitForm'])->name('contact.submit');
