<?php

namespace App\Http\Controllers\Models;

class ResultViewModel
{
    public function __construct(string $userName, int $publicRepo, int $commitSum, int $issues, int $pullRequest, int $starSum, int $followers, string $rank)
    {
        $this->userName = $userName;
        $this->publicRepo = $publicRepo;
        $this->commitSum = $commitSum;
        $this->issues = $issues;
        $this->pullRequest = $pullRequest;
        $this->starSum = $starSum;
        $this->followers = $followers;
        $this->rank = $rank;
    }
}
