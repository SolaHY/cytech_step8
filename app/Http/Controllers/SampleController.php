<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use Illuminate\Support\Facades\Auth;

class SampleController extends Controller
{
    // コンストラクタ
    public function __construct(
        private Sample $sample_model = new Sample,
    ) {}

    /**
     * サンプルデータを表示
     *
     * @return view
     */
    public function showSampleList()
    {
        // モデルでサンプルデータを全て取得
        $samples = $this->sample_model->getSampleListAll();

        // ビューにデータを渡す
        return view('sample.list', compact('samples'));
    }

    public function showSample()
    {
        // サンプルデータを全て取得
        $samples = Sample::all();

        // ビューにデータを渡す
        return view('sample', compact('samples'));
    }

    /**
     * samplesにデータを登録する
     * 登録するデータは画面で入力された値
     * @return view
     */
    public function store(SampleRequest $request)
    {
        // ログインユーザIDを取得。
        $user_id = Auth::id();

        // モデルでデータを登録
        $this->sample_model->storeData($request, $user_id);

        return view('sample.list');
    }

    /**
     * samplesにすでにあるデータを更新する
     * 更新対象のデータはsamplesのidが一致するもの一つ
     * 更新するデータは画面で入力された値
     * @return view
     */
    public function update(SampleRequest $request, $id)
    {
        // モデルでデータを更新
        $this->sample_model->updateData($request, $id);

        return view('sample.list');
    }

    /**
     * samplesにすでにあるデータを削除する
     * 削除対象は画面で選択されたデータのidと一致するもの
     * 
     * @return view
     */
    public function delete($id)
    {
        // モデルでデータを削除
        $this->sample_model->deleteData($id);

        return view('sample.list');
    }

    /**
     * ログインユーザのデータのみ表示する
     * ログインユーザの名前も表示する
     *
     * @return view
     */
    public function showLoginUserData()
    {
        // ログインユーザIDを取得。
        $user_id = Auth::id(); //auth()->id()でも可能。この場合は6行目は不要。

        // モデルでログインユーザのデータのみを取得
        $samples = $this->sample_model->userData($user_id);

        // ビューにデータを渡す
        return view('sample.list', compact('samples'));
    }
}
