<?php

namespace App\Service\Production;

use App\Service\RankDataInterface;

class RankData implements RankDataInterface
{
    // 上位何%かを表す
    private const RANK_S_VALUE = 1;
    private const RANK_DOUBLE_A_VALUE = 25;
    private const RANK_A2_VALUE = 45;
    private const RANK_A3_VALUE = 60;
    // private const RANK_B_VALUE = 100;
    // TOTAL_VALUES = RANK_S_VALUE + RANK_DOUBLE_A_VALUE + RANK_A2_VALUE + RANK_A3_VALUE + RANK_B_VALUE
    private const TOTAL_VALUE = 231;

    public function getTotalValue(): int
    {
        return RankData::TOTAL_VALUE;
    }

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
}
