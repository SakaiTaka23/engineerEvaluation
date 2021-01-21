<?php

namespace App\Service;

interface CalculateRankInterface
{
    public function evaluation(string $name): array;
    public function normalCdf(int $mean, int $sigma, int $to): float;
}
