<?php

namespace App\Service;

interface OffsetDataInterface
{
    /**
     * 与えられた引数を元にそのユーザーのスコアを計算
     * @param float $public_repo
     * @param float $commit_sum
     * @param float $issues
     * @param float $pull_requests
     * @param float $star_sum
     * @param float $followers
     * @return float 計算結果
     */
    public function calcScore(
        float $public_repo,
        float $commit_sum,
        float $issues,
        float $pull_requests,
        float $star_sum,
        float $followers
    ): float;

    /**
     * あらかじめ計算されたオフセットの合計を返す
     * @return float 合計
     */
    public function getAllOffset(): float;
}
