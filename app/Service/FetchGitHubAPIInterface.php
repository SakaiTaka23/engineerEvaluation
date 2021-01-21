<?php

namespace App\Service;

interface FetchGitHubAPIInterface
{
    public function Issues(string $name): int;
    public function PullRequests(string $name): int;
    public function publicRepoFollowers(string $name): array;
    public function commitStar(string $name): array;

    public function summarizeData(string $name): array;
}
