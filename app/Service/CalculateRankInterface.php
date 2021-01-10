<?php

namespace App\Service;

interface CalculateRankInterface
{
    public function evaluation(string $name): array;
    public function normalcdf(int $mean, int $sigma, int $to): int;
}
