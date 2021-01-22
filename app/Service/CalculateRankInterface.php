<?php

namespace App\Service;

interface CalculateRankInterface
{
    /**
     * 他の関数を呼び出す軸
     * 返り値の要素は固定
     * @param string $name
     * @return object {name,public_repo,commit_sum,issues,pull_requests,star_sum,followers,user_rank}
     */
    public function evaluation(string $name): object;

    /**
     * 累積分布関数の計算
     * @param int $mean ユーザーのスコア
     * @param int $sigma 点数の合計
     * @param int $to オフセットの合計
     * @return float
     */
    public function normalCdf(int $mean, int $sigma, int $to): float;
}
