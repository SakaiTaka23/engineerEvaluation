<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Service\FetchDataInterface;

class ValuationController extends Controller
{
    public function __construct(FetchDataInterface $fetch)
    {
        $this->fetch = $fetch;
    }

    public function index()
    {
        $this->fetch->publicRepoFollowers();
        return view('welcome');
    }
}
