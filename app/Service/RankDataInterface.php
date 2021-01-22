<?php

namespace App\Service;

interface RankDataInterface
{
    /**
     * 累積分布で計算されたスコアからランクを計算
     * @param float $normalizedScore 累積分布計算後の値
     * @return string S+|S|A++|A+|B+
     */
    public function calcRank(float $normalizedScore): string;

    /**
     * あらかじめ計算された割合の合計を返す
     * @return int 合計値
     */
    public function getTotalValue(): int;
}
