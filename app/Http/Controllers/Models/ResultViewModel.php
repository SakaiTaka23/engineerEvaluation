<?php

namespace App\Http\Controllers\Models;

class ResultViewModel
{
    public function __construct(int $publicRepo, int $commitSum, int $issues, int $pullRequest, int $starSum, int $followers)
    {
        $this->publicRepo = $publicRepo;
        $this->commitSum = $commitSum;
        $this->issues = $issues;
        $this->pullRequest = $pullRequest;
        $this->starSum = $starSum;
        $this->followers = $followers;
    }
}
