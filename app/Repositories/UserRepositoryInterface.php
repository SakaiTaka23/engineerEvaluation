<?php

namespace App\Repositories;

interface UserRepositoryInterface
{

    /**
     * タスクの初期設定 名前をDBへ保存
     * @param string $name
     * @return void
     */
    public function setTask(string $name,string $mail):void;

    /**
     * 取得したユーザーのデータをDBへ保存
     * @param string $name
     * @param int $publicRepo
     * @param int $commitSum
     * @param int $issues
     * @param int $pullRequests
     * @param int $starSum
     * @param int $followers
     * @return void
     */
    public function setUserStats(string $name, int $publicRepo, int $commitSum, int $issues, int $pullRequests, int $starSum, int $followers):void;

    /**
     * setUserStatsで設定して値を読み込む 返り値の要素は確定
     * @param string $name
     * @return object {public_repo,commit_sum,issues,pull_requests,star_sum,followers}
     */
    public function getUserStats(string $name):object;

    /**
     * 計算後のランクを保存
     * ランクは S+,S,A++,A+,B+
     * @param string $name
     * @param string $rank
     * @return void
     */
    public function setUserRank(string $name, string $rank):void;

    /**
     * 今までの結果を取得、返却
     * コレクションを整形して返したい
     * @param string $name
     * @return
     */
    public function getResultId(string $name):int;

    /**
     * タスクをコマンド化するときに実装
     * タスク終了フラグを立てる
     */
    // public function finistTask(string $name):void;
}
