<?php

namespace App\Http\Controllers;

use App\Jobs\EvaluationJob;
use App\Repositories\UserRepositoryInterface;
use App\Rules\UserExists;
use Illuminate\Http\Request;

use App\Service\CalculateRankInterface;

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
            'name' => ['bail','required', new UserExists],
            'email' => ['bail','required','email']
        ]);

        $id = $this->repository->setTask($request->name, $request->email);
        EvaluationJob::dispatch($id);

        $viewModel = (object)[
            'name' => $request->name,
            'mail' => $request->email
        ];

        return view('loading', compact('viewModel'));
    }
}
