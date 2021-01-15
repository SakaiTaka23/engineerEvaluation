<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Models\ResultViewModel;
use App\Rules\UserExists;
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
        $request->validate([
            'userName' => ['required', new UserExists],
        ]);
        $username = $request->userName;
        /**
         * @todo 受け取った後に名前が有効かどうか確認すること!!!
         */
        // ↓ビュー確認後コメントアウト
        // $rank = $this->rank->evaluation("SakaiTaka23");
        // 擬似データ
        $viewModel = new ResultViewModel("SakaiTaka23", 1, 1, 1, 1, 1, 1, "A+");
        return view('result', compact('viewModel'));
    }
}
