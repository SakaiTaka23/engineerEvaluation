<?php

namespace App\Service\Production;

use App\Service\CalculateRankInterface;
use App\Service\FetchGitHubAPIInterface;
use App\Service\OffsetDataInterface;
use App\Service\RankDataInterface;

class CalculateRank implements CalculateRankInterface
{
    public function __construct(FetchGitHubAPIInterface $fetch, OffsetDataInterface $offset, RankDataInterface $rank)
    {
        $this->fetch = $fetch;
        $this->offset = $offset;
        $this->rank = $rank;
    }

    public function evaluation(string $name): array
    {
        $summarizedData = $this->fetch->summarizeData($name);
        $userScore = $this->offset->calcScore(
            $summarizedData[0],
            $summarizedData[1],
            $summarizedData[2],
            $summarizedData[3],
            $summarizedData[4],
            $summarizedData[5]
        );
        $totalValue = $this->rank->getTotalValue();
        $allOffset = $this->offset->getAllOffset();
        $normalizedScore = $this->normalCdf($userScore, $totalValue, $allOffset) * 100;
        $normalizedScore = round($normalizedScore, 3);
        $userRank = $this->rank->calcRank($normalizedScore);
        return [$summarizedData, $userRank];
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
