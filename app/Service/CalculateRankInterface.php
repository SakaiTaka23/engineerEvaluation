<?php

namespace App\Service;

interface CalculateRankInterface
{
    /**
     * 他の関数を呼び出す軸
     * @param string $name
     * @return void スケジューラー回す時点で名前はわかっているはずだから返す必要なし！
     */
    public function evaluation(string $name): void;

    /**
     * 累積分布関数の計算
     * @param int $mean ユーザーのスコア
     * @param int $sigma 点数の合計
     * @param int $to オフセットの合計
     * @return float
     */
    public function normalCdf(int $mean, int $sigma, int $to): float;
}
