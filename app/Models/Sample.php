<?php

namespace App\Models;

use Illuminate\Support\Facades\DB; //クエリビルダを使用する場合は必要
use Illuminate\Database\Eloquent\Model; //Eloquent（エロクエント）を使用する場合は必要

class Sample extends Model
{
    protected $table = 'samples';
    protected $fillable = ['user_id', 'name', 'description', 'created_at', 'updated_at',];

    /**
     * usersテーブルとのリレーション定義
     * ①クエリビルダ（テーブルを直接指定）使用の場合は不要。
     * ②Eloquent（モデルを通じて操作）使用の場合のみ必要。
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * サンプルテーブルの全件取得(昇順)
     * ①、②どちらも同じ結果になる。
     * どちらかで統一する。
     * 
     */
    public function getSampleListAll()
    {
        // ①クエリビルダ（テーブルを直接指定）使用
        return DB::table($this->table) // DB::table('blogs')ともできる。この場合は10行目は不要。
            ->orderBy('id', 'asc') //idカラムの値の昇順でデータを取得。降順にしたい場合はascをdescにする。
            ->get();

        // ②Eloquent（モデルを通じて操作）使用
        return Blog::orderBy('id', 'asc')->get();
    }

    /**
     * ログインユーザのデータのみを取得
     * ログインユーザの名前も表示する
     * ①、②どちらも同じ結果になる。
     * どちらかで統一する。
     * 
     */
    public function userData($user_id)
    {
        // ①クエリビルダ（テーブルを直接指定）使用
        return DB::table('samples')
            ->join('users', 'samples.user_id', '=', 'users.id') // テーブルをuser_idで結合
            ->select('samples.*', 'users.name') // samplesの全てのカラムとusers.nameを取得
            ->where('samples.user_id', $user_id) // ログインユーザのデータのみに絞り込み
            ->orderBy('samples.updated_at', 'desc') // updated_atの降順
            ->get();

        // ②Eloquent（モデルを通じて操作）使用
        return Sample::with('user') // usersテーブルの情報をリレーションで取得
            ->select('samples.*') // samplesの全カラムを選択（デフォルトで含まれるため省略も可能）
            ->addSelect('users.name') // users.nameを追加
            ->join('users', 'samples.user_id', '=', 'users.id') // 明示的にJOIN
            ->where('samples.user_id', $user_id) // ログインユーザのデータのみに絞り込み
            ->orderBy('samples.updated_at', 'desc') // updated_atの降順
            ->get();
    }

    /**
     * samplesにすでにあるデータを更新する
     * ①、②どちらかで統一する。
     */
    public function updateData($request, $id)
    {
        // ①クエリビルダ使用
        DB::table('samples')
            ->where('id', $id) // 更新対象の条件。samplesテーブルのidと引数で渡されたidが一致するもの
            ->update([
                'title' => $request->input('title'), //入力されたtitle
                'description' => $request->input('description'), //入力されたdescription
                'updated_at' => now(), // 現在時刻
            ]);

        // ②Eloquent使用
        Sample::where('id', $id) // idが一致するレコードを指定
            ->update([
                'title'       => $request->input('title'), // 入力されたtitle
                'description' => $request->input('description'), // 入力されたdescription
                'updated_at'  => now(), // 現在時刻
            ]);
    }

    /**
     * samplesにデータを登録する
     * ①、②どちらかで統一する。
     */
    public function storeData($request, $user_id)
    {
        // ①クエリビルダ使用
        DB::table('samples')->insert([
            'user_id'     => $user_id, // ログインユーザーのID
            'title'       => $request->input('title'), //入力されたtitle
            'description' => $request->input('description'), //入力されたdescription
            'created_at'  => now(), //現在時刻
            'updated_at'  => now(), //現在時刻
        ]);

        // ②Eloquent使用
        Sample::create([
            'user_id'     => $user_id, // ログインユーザーのID
            'title'       => $request->input('title'), //入力されたtitle
            'description' => $request->input('description'), //入力されたdescription
            'created_at'  => now(), //現在時刻
            'updated_at'  => now(), //現在時刻
        ]);
    }

    /**
     * samplesにすでにあるデータを削除する
     * ①、②どちらかで統一する。
     */
    public function deleteData($id)
    {
        // ①クエリビルダ使用
        DB::table('samples')->where('id', $id)->delete(); //idが一致するレコードを指定

        // ②Eloquent使用
        Sample::where('id', $id)->delete(); //idが一致するレコードを指定
    }
}
