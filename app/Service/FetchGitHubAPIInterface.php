<?php

namespace App\Service;

interface FetchGitHubAPIInterface
{
    /**
     * Issues取得
     * @param string $name
     * @return int
     */
    public function Issues(string $name): int;

    /**
     * PullRequests取得
     * @param string $name
     * @return int
     */
    public function PullRequests(string $name): int;

    /**
     * publicRepo,Followers取得
     * @param string $name
     * @return array [$publicRepo, $followers]
     */
    public function publicRepoFollowers(string $name): array;

    /**
     * commit,star取得
     * @param string $name
     * @return array [$commit, $star]
     */
    public function commitStar(string $name): array;

    /**
     * ステータス全体を取得 クラス内の関数を実行して計算
     * @param string $name
     * @return void
     */
    public function summarizeData(string $name): void;
}
