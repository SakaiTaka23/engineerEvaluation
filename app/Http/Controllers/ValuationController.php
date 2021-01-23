<?php

namespace App\Http\Controllers;

use App\Jobs\EvaluationJob;
use App\Mail\SendResult;
use App\Repositories\UserRepositoryInterface;
use App\Rules\UserExists;
use Illuminate\Http\Request;

use App\Service\CalculateRankInterface;
use Illuminate\Support\Facades\Mail;

class ValuationController extends Controller
{
    public function __construct(CalculateRankInterface $rank, UserRepositoryInterface $repository)
    {
        $this->rank = $rank;
        $this->repository = $repository;
    }

    public function loading(Request $request)
    {
        $request->validate([
            'name' => ['required', new UserExists],
            'email' => ['required','email']
        ]);

        $id = $this->repository->setTask($request->name, $request->email);
        EvaluationJob::dispatch($id);

        return view('loading');
    }
}
