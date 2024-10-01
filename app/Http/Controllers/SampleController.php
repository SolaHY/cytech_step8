<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use Illuminate\Http\Request;


class SampleController extends Controller
{
    public function showSample()
    {
        // サンプルデータを全て取得
        $samples = Sample::all();

        // ビューにデータを渡す
        return view('sample', compact('samples'));
    }
}
