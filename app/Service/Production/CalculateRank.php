<?php

namespace App\Service\Production;

use App\Repositories\UserRepositoryInterface;
use App\Service\CalculateRankInterface;
use App\Service\FetchGitHubAPIInterface;
use App\Service\OffsetDataInterface;
use App\Service\RankDataInterface;

class CalculateRank implements CalculateRankInterface
{
    public function __construct(FetchGitHubAPIInterface $fetch, OffsetDataInterface $offset, RankDataInterface $rank, UserRepositoryInterface $repository)
    {
        $this->fetch = $fetch;
        $this->offset = $offset;
        $this->rank = $rank;
        $this->repository = $repository;
    }

    public function evaluation(int $id): int
    {
        $name = $this->repository->getTask($id);
        $this->fetch->summarizeData($name);
        $userStats = $this->repository->getUserStats($name);
        $userScore = $this->offset->calcScore(
            $userStats->public_repo,
            $userStats->commit_sum,
            $userStats->issues,
            $userStats->pull_requests,
            $userStats->star_sum,
            $userStats->followers
        );
        $totalValue = $this->rank->getTotalValue();
        $allOffset = $this->offset->getAllOffset();
        $normalizedScore = round($this->normalCdf($userScore, $totalValue, $allOffset) * 100, 3);
        $userRank = $this->rank->calcRank($normalizedScore);
        $this->repository->setUserRank($name, $userRank);
        $resultId = $this->repository->getResultId($name);
        return $resultId;
    }

    public function normalCdf(int $mean, int $sigma, int $to): float
    {
        $z = ($to - $mean) / sqrt(2 * $sigma * $sigma);
        $t = 1 / (1 + 0.3275911 * abs($z));
        $a1 = 0.254829592;
        $a2 = -0.284496736;
        $a3 = 1.421413741;
        $a4 = -1.453152027;
        $a5 = 1.061405429;
        $erf = 1 - (((($a5 * $t + $a4) * $t + $a3) * $t + $a2) * $t + $a1) * $t * exp(-$z * $z);
        $sign = 1;
        if ($z < 0) {
            $sign = -1;
        }
        return (1 / 2) * (1 + $sign * $erf);
    }
}
