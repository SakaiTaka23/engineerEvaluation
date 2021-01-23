<?php

namespace App\Repositories;

interface UserRepositoryInterface
{

    /**
     * タスクの初期設定 名前をDBへ保存
     * @param string $name
     * @return int 作成したカラムのid
     */
    public function setTask(string $name, string $mail):int;

    /**
     * idを受け取りそのカラムのnameを返す
     * @param int $id
     * @return string ユーザー名
     */
    public function getTask(int $id):string;

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
     * 今までの値を格納したidを返す
     * @param string $name
     * @return
     */
    public function getResultId(string $name):int;


    /**
     * idを引数としてとり該当のもの、基本情報を取得、返却
     * @param int $id
     * @return object {name,email,public_repo,commit_sum,issues,pull_requests,star_sum,followers}
     */
    public function getResult(int $id):object;
}
