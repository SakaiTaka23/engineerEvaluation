<?php

namespace App\Service;

interface RankDataInterface
{
    public function calcRank(float $normalizedScore): string;

    public function getTotalValue(): int;
}
