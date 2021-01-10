<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Service\CalculateRankInterface;

class ValuationController extends Controller
{
    public function __construct(CalculateRankInterface $rank)
    {
        $this->rank = $rank;
    }

    public function result(Request $request)
    {
        $username = $request->userName;
        dd($username);
        /**
         * @todo 受け取った後に名前が有効かどうか確認すること!!!
         */
        // ↓ビュー確認後コメントアウト
        // $rank = $this->rank->evaluation("SakaiTaka23");
        $rank = [50.0, "A+"];
        return view('result', 'rank');
    }
}
