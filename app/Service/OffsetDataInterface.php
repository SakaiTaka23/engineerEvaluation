<?php

namespace App\Service;

interface OffsetDataInterface
{
    public function calcScore(
        float $public_repo,
        float $commit_sum,
        float $issues,
        float $pull_requests,
        float $star_sum,
        float $followers
    ): float;

    public function getAllOffset(): float;
}
