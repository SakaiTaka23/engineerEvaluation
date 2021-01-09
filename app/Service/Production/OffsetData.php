<?php

namespace App\Service\Production;

use App\Service\OffsetDataInterface;

class OffsetData implements OffsetDataInterface
{
    private const PUBLIC_REPO_OFFSET = 1.18;
    private const COMMIT_OFFSET = 1.16;
    private const ISSUES_OFFSET = 1.13;
    private const PULL_REQUESTS_OFFSET = 1.10;
    private const STARS_OFFSET = 0.92;
    private const FOLLOWERS_OFFSET = 0.91;
    // PUBLIC_REPO_OFFSET+COMMIT_OFFSET+ISSUES_OFFSET + PULL_REQUESTS_OFFSET+STARS_OFFSET+FOLLOWERS_OFFSET;
    private const ALL_OFFSET = 6.4;

    public function calcScore(float $public_repo, float $commit_sum, float $issues, float $pull_requests, float $star_sum, float $followers): float
    {
        return ($public_repo * OffsetData::PUBLIC_REPO_OFFSET +
            $commit_sum * OffsetData::COMMIT_OFFSET +
            $issues * OffsetData::ISSUES_OFFSET +
            $pull_requests * OffsetData::PULL_REQUESTS_OFFSET +
            $star_sum * OffsetData::STARS_OFFSET +
            $followers * OffsetData::FOLLOWERS_OFFSET) / 100;
    }

    public function getAllOffset(): float
    {
        return OffsetData::ALL_OFFSET;
    }
}
