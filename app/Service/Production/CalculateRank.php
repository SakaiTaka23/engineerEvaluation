<?php

namespace App\Service\Production;

use App\Service\CalculateRankInterface;

class CalculateRank implements CalculateRankInterface
{
    public function evaluation(string $name): array
    {
        return [];
    }

    public function normalcdf(int $mean, int $sigma, int $to): int
    {
        return 0;
    }
}
