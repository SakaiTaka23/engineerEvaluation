<?php

namespace App\Repositories;

interface UserRepositoryInterface{

    /**
     * タスクの初期設定 名前をDBへ保存
     * @param string $name
     * @return void
     */
    public function setTask(string $name):void;

    /**
     * 取得したユーザーのデータをDBへ保存
     * @param int $publicRepo
     * @param int $commitSum
     * @param int $issues
     * @param int $pullRequests
     * @param int $starSum
     * @param int $followers
     * @return void
     */
    public function setUserStats(int $publicRepo,int $commitSum,int $issues,int $pullRequests,int $starSum,int $followers):void;

    /**
     * 計算後のランクを保存
     * ランクは S+,S,A++,A+,B+
     * @param string $rank
     * @return void
     */
    public function setUserRank(string $rank):void;

    /**
     * タスクをコマンド化するときに実装
     * タスク終了フラグを立てる
     */
    // public function finistTask(string $name):void;
}
