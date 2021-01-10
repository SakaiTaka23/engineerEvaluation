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

    public function index()
    {
        $rank = $this->rank->evaluation("SakaiTaka23");
        return view('welcome');
    }
}
