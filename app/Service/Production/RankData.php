<?php

namespace App\Service\Production;

use App\Service\RankDataInterface;

class RankData implements RankDataInterface
{
    // 上位何%かを表す
    private const RANK_S_PERCENTAGE = 1;
    private const RANK_DOUBLE_A_PERCENTAGE = 25;
    private const RANK_A2_PERCENTAGE = 45;
    private const RANK_A3_PERCENTAGE = 60;
    private const RANK_B_PERCENTAGE = 100;
    private const TOTAL_PERCENTAGE = RankData::RANK_S_PERCENTAGE + RankData::RANK_DOUBLE_A_PERCENTAGE + RankData::RANK_A2_PERCENTAGE + RankData::RANK_A3_PERCENTAGE + RankData::RANK_B_PERCENTAGE;

    private const RANK_S_VALUE = 49;
    private const RANK_DOUBLE_A_VALUE = 49.5;
    private const RANK_A2_VALUE = 50;
    private const RANK_A3_VALUE = 51;

    public function calcRank(float $normalizedScore): string
    {
        $rank = "";
        switch ($normalizedScore) {
            case $normalizedScore < RankData::RANK_S_VALUE:
                $rank = "S+";
                break;
            case $normalizedScore >= RankData::RANK_S_VALUE && $normalizedScore < RankData::RANK_DOUBLE_A_VALUE:
                $rank = "S";
                break;
            case $normalizedScore >= RankData::RANK_DOUBLE_A_VALUE && $normalizedScore < RankData::RANK_A2_VALUE:
                $rank = "A++";
                break;
            case $normalizedScore >= RankData::RANK_A2_VALUE && $normalizedScore < RankData::RANK_A3_VALUE:
                $rank = "A+";
                break;
            default:
                $rank = "B+";
        }
        return $rank;
    }

    public function getTotalValue(): int
    {
        return RankData::TOTAL_PERCENTAGE;
    }
}
