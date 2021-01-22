<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Models\ResultViewModel;
use App\Mail\SendResult;
use App\Rules\UserExists;
use Illuminate\Http\Request;

use App\Service\CalculateRankInterface;
use Illuminate\Support\Facades\Mail;

class ValuationController extends Controller
{
    public function __construct(CalculateRankInterface $rank)
    {
        $this->rank = $rank;
    }

    // public function result(Request $request)
    // {
    //     $request->validate([
    //         'userName' => ['required', new UserExists],
    //     ]);
    //     $username = $request->userName;
    //     list($user_data, $rank) = $this->rank->evaluation($username);
    //     $viewModel = new ResultViewModel($username, $user_data[0], $user_data[1], $user_data[2], $user_data[3], $user_data[4], $user_data[5], $rank);
    //     // 擬似データ
    //     // $viewModel = new ResultViewModel("SakaiTaka23", 1, 1, 1, 1, 1, 1, "A+");
    //     // dd($viewModel);
    //     return view('result', compact('viewModel'));
    // }

    public function loading(Request $request){
        $request->validate([
            'name' => ['required', new UserExists],
            'email' => ['required','email']
        ]);

        $mailTo = (object)[
            'name' => $request->name,
            'email' => $request->email,
        ];
        var_dump($mailTo);
        Mail::to($mailTo)->send(new SendResult());

        return view('loading');
    }
}
